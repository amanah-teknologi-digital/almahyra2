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

        function getListJilid(){
            $sql = "SELECT * FROM mengaji_jilid";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataEkstrakulikuler($id_user){
            $sql = "SELECT * FROM ekstrakulikuler";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function getDataEsktraByGuru(){
            $id_user = $this->session->userdata['auth']->id;

            $sql = "SELECT * FROM ekstrakulikuler WHERE pengampu = $id_user";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function getListAnak($role){
            $user = $this->session->userdata['auth'];
            if ($role == 1 OR $role == 2 OR $role == 6 OR $role == 7 OR $role == 8) { // admin & superadmin & system absen
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

        function getListAnakEkstra($role){
            $user = $this->session->userdata['auth'];
            if ($role == 1) { // admin & superadmin & system absen
                $where = "";
            }elseif ($role == 9) { // educator
                $where = " AND a.pengampu_update = $user->id";
            }elseif ($role == 3) { // educator
                $where = " AND b.educator = $user->id";
            }elseif ($role == 4) { // orangtua
                $where = " AND b.id_orangtua = $user->id";
            }else{
                $where = " AND 1 = 0";
            }

            $sql = "SELECT DISTINCT b.id, b.nama as nama_anak
                FROM ekstrakulikuler_catatan a
                JOIN registrasi_data_anak b ON b.id = a.id_anak
                WHERE b.is_active = 1 AND a.is_catat = 1 $where ORDER BY b.nama ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListEkstra($id_anak){
            $sql = "SELECT DISTINCT b.id_ekstra, b.nama as nama_ekstra
                FROM ekstrakulikuler_catatan a
                JOIN ekstrakulikuler b ON b.id_ekstra = a.id_ekstra
                WHERE a.id_anak = $id_anak AND a.is_catat = 1 ORDER BY b.id_ekstra ASC";

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

        function getDataCatatanMengaji($id_anak){
            $sql = "SELECT
                        tanggal,
                        id_anak,
                        id_ekstra,
                        nilai
                    FROM
                        ekstrakulikuler_catatan
                    WHERE
                        is_catat = 1 AND id_anak = $id_anak
                    GROUP BY
                        tanggal, id_anak, id_ekstra
                    ORDER BY
                        id_ekstra, tanggal";

            $query = $this->db->query($sql);

            return $query->result();
        }

    }
?>