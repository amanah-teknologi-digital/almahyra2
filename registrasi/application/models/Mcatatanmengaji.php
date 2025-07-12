<?php

class Mcatatanmengaji extends CI_Model
{
    public function __construct() {
        parent::__construct();

        ## declate table name here
        $this->table_name = 'absensi_anak' ;
        $this->login = $this->session->userdata['auth'];
    }

    function getHasilCheckup($tanggal_sekarang = ''){
        if (empty($tanggal_sekarang)) {
            $tanggal_sekarang = date('Y-m-d');
        }

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

    function simpanRekamMedic(){
        date_default_timezone_set('Asia/Jakarta');

        $id_checkup = $this->input->post('id_checkup');
        $list_form = $this->getDataRincianCheckup($id_checkup);

        $this->db->trans_start();

        $update_checkup['updated_at'] = date('Y-m-d H:m:s');
        $update_checkup['keterangan'] = $this->input->post('keterangan');
        $this->db->where('id_checkup', $id_checkup);
        $this->db->update('medical_checkup', $update_checkup);

        foreach ($list_form as $form){
            $id_rinciancheckup = $form->id_rinciancheckup;
            if (!empty($id_rinciancheckup)){ //update
                $a_input['nilai'] = $this->input->post($form->kolom);
                if (!empty($form->action)) {
                    $a_input['aksi_medic'] = $this->input->post('action_' . $form->kolom);
                }

                $this->db->where('id_rinciancheckup', $id_rinciancheckup);
                $this->db->update('rincian_medicalcheckup', $a_input);
            }else{ //insert
                $a_input['id_rinciancheckup'] = $id_rinciancheckup;
                $a_input['id_checkup'] = $id_checkup;
                $a_input['id_formmedical'] = $form->id_formmedical;
                $a_input['nilai'] = $this->input->post($form->kolom);
                if (!empty($form->action)) {
                    $a_input['aksi_medic'] = $this->input->post('action_' . $form->kolom);
                }

                $this->db->insert('rincian_medicalcheckup', $a_input);
            }
        }

        if (isset($_FILES['file_dukung'])){
            $this->uploadfiles();
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    function uploadfiles() {
        $input = 'file_dukung'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        $total = count($_FILES[$input]['name']); // multiple files
        $path = './uploads/medical_checkup/'; // your upload path

        for ($i = 0; $i < $total; $i++) {
            $temp_filename = date('dmyhis').rand(1, 1000000);
            $temp_filename = $temp_filename.$i;
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = $_FILES[$input]['name'][$i]; // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            $ext = pathinfo($_FILES[$input]['name'][$i], PATHINFO_EXTENSION);

            //Make sure we have a file path
            if ($tmpFilePath != ""){
                //Setup our new file path
                $newFilePath = $path . $temp_filename.'.'.$ext;

                //Upload the file into the new path
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $id_file = $this->insertDokumentasiHarian($temp_filename, $ext, $fileName, $fileSize, $_POST['id_checkup']);
                    if (empty($id_file)) {
                        @unlink($newFilePath);
                        break;
                    }
                } else {
                    break;
                }
            } else {
                break;
            }
        }

        return true;
    }

    function hapusDokumentasiFile($id_file){
        $sql = "SELECT download_url FROM file_medicalcheckup WHERE id_file = $id_file";
        $query = $this->db->query($sql);
        $download_url = $query->row()->download_url;
        $path = './'.$download_url;

        $this->db->trans_start();

        $this->db->where('id_file', $id_file);
        $this->db->delete('file_medicalcheckup');

        $this->db->trans_complete();

        if($this->db->trans_status()){
            @unlink($path);
        }

        return $this->db->trans_status();
    }

    function insertDokumentasiHarian($temp_filename, $ext, $fileName, $fileSize, $id_checkup){
        $user = $this->session->userdata['auth'];

        $a_input['id_checkup'] = $id_checkup;
        $a_input['file_name'] = $fileName;
        $a_input['size'] = $fileSize;
        $a_input['download_url'] = 'uploads/medical_checkup/' . $temp_filename.'.'.$ext;
        $a_input['temp_file_name'] = $temp_filename;
        $a_input['ext'] = $ext;
        $a_input['created_at'] = date('Y-m-d H:m:s');
        $a_input['updater'] = $user->id;

        $this->db->insert('file_medicalcheckup', $a_input);

        return $this->db->insert_id();
    }

    function getDokumentasiFile($id_checkup){
        $sql = "SELECT * FROM file_medicalcheckup WHERE id_checkup = $id_checkup";
        $query = $this->db->query($sql);

        return $query->result();
    }
}

?>