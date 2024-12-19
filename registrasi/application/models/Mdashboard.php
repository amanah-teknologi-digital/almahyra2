<?php  

	class Mdashboard extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        function getAnakByOrangtua($id_orangtua){
            $sql = "SELECT a.*, d.id_kelas, e.nama as nama_kelas
                FROM registrasi_data_anak a 
                JOIN data_user b ON b.id = a.id_orangtua
                JOIN v_kategori_usia c ON c.id = a.id
                JOIN map_kelasusia d ON d.id_usia = c.id_usia
                JOIN ref_kelas e ON e.id_kelas = d.id_kelas
                WHERE a.id_orangtua = $id_orangtua AND a.is_active = 1 ORDER BY a.anak_ke ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListAnak($role){
            $user = $this->session->userdata['auth'];
            if ($role == 1 OR $role == 2) { // admin & superadmin & system absen
                $where = "";
            }elseif ($role == 3) { // educator
                $where = " AND a.educator = $user->id";
            }elseif ($role == 4) { // orangtua
                $where = " AND a.id_orangtua = $user->id";
            }else{
                $where = " AND 1 = 0";
            }

            $sql = "SELECT a.id, a.nama as nama_anak
                FROM registrasi_data_anak a
                LEFT JOIN (SELECT COUNT(a.id_checkup) as jml_medicalchekup, id_anak FROM medical_checkup a JOIN (SELECT id_checkup FROM rincian_medicalcheckup GROUP BY id_checkup) b ON b.id_checkup = a.id_checkup GROUP BY id_anak) h ON h.id_anak = a.id
                WHERE a.is_active = 1 $where ORDER BY h.jml_medicalchekup DESC, a.nama ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataMedicalCheckup($id_anak){
            $sql = "SELECT a.tanggal, b.*, c.satuan, c.nama_kolom
                FROM medical_checkup a 
                JOIN rincian_medicalcheckup b ON b.id_checkup = a.id_checkup
                JOIN form_medical c ON c.id_formmedical = b.id_formmedical
                WHERE a.id_anak = $id_anak AND b.id_formmedical IN(1,2,3,4) ORDER BY b.id_formmedical, a.tanggal ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

    }
?>