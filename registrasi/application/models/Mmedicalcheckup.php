<?php

class Mmedicalcheckup extends CI_Model
{
    public function __construct() {
        parent::__construct();

        ## declate table name here
        $this->table_name = 'absensi_anak' ;
        $this->login = $this->session->userdata['auth'];
    }

    function getHasilCheckup(){
        $tanggal_sekarang = date('Y-m-d');

        $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_checkup, h.id_checkup as rinci, e.tanggal, e.keterangan, e.created_at, e.updated_at, f.name as nama_medic, g.name as nama_role
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                LEFT JOIN medical_checkup e ON e.id_anak = a.id AND e.tanggal = '$tanggal_sekarang'
                LEFT JOIN data_user f ON f.id = e.medic
                LEFT JOIN m_role g ON g.id = f.id_role
                LEFT JOIN (SELECT id_checkup FROM rincian_medicalcheckup GROUP BY id_checkup) h ON h.id_checkup = e.id_checkup
                WHERE a.is_active = 1 ORDER BY a.nama ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function checkAktivitas($tanggal, $id_anak){
        $user = $this->session->userdata['auth'];

        $sql = "SELECT id_checkup FROM medical_checkup WHERE id_anak = $id_anak AND tanggal = '$tanggal'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row()->id_checkup;
        }else{
            $a_input['id_anak'] = $id_anak;
            $a_input['medic'] = $user->id;
            $a_input['tanggal'] = $tanggal;
            $a_input['created_at'] = date('Y-m-d H:m:s');

            $this->db->insert('medical_checkup', $a_input);

            return $this->db->insert_id();
        }
    }

    function getDataCheckup($id_checkup){
        $sql = "SELECT a.id, a.nama as nama_anak, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_checkup, e.tanggal, e.keterangan, e.created_at, e.updated_at, f.name as nama_medic, g.name as nama_role
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN medical_checkup e ON e.id_anak = a.id
                JOIN data_user f ON f.id = e.medic
                JOIN m_role g ON g.id = f.id_role
                WHERE e.id_checkup = $id_checkup";

        $query = $this->db->query($sql);

        return $query->row();
    }

    function getDataRincianCheckup($id_checkup){
        $sql = "SELECT a.*, b.id_rinciancheckup, b.nilai, b.aksi_medic
                FROM form_medical a 
                LEFT JOIN rincian_medicalcheckup b ON b.id_formmedical = a.id_formmedical AND b.id_checkup = $id_checkup";

        $query = $this->db->query($sql);

        return $query->result();
    }
}

?>