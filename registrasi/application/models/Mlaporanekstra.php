<?php  

	class Mlaporanekstra extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'ref_tahun' ;
	    }

	    ## get all data in table
        function getListEsktra($id_role){
            $user = $this->session->userdata['auth'];

            if ($id_role == 9){ //guru ekstra
                $where = " a.id_ekstra IN (SELECT DISTINCT id_ekstra FROM ekstrakulikuler_catatan WHERE pengampu_update = $user->id AND is_catat = 1)";
            }elseif($id_role == 1){ //admin
                $where = " 1 = 1"; // semua ekstra
            }elseif ($id_role == 3){ // educator
                $where = " a.id_ekstra IN (SELECT DISTINCT id_ekstra FROM ekstrakulikuler_catatan WHERE is_catat = 1 AND id_anak IN(SELECT id FROM registrasi_data_anak WHERE educator = $user->id))";
            }elseif($id_role == 4){ // orangtua
                $where = " a.id_ekstra IN (SELECT DISTINCT id_ekstra FROM ekstrakulikuler_catatan WHERE  is_catat = 1 AND id_anak IN(SELECT id FROM registrasi_data_anak WHERE id_orangtua = $user->id))";
            }else{
                $where = " AND 1 = 0";
            }

            $sql = "SELECT * FROM ekstrakulikuler a WHERE $where ORDER BY a.id_ekstra";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListAnak($id_ekstra, $id_role){
            $user = $this->session->userdata['auth'];

            if ($id_role == 9){ // admin & superadmin &  absen
                $where_anak = " AND 1 = 1";
            }elseif ($id_role == 1){ // admin
                $where_anak = " AND 1 = 1";
            }elseif ($id_role == 3){ // educator
                $where_anak = " AND c.educator = $user->id";
            }elseif($id_role == 4){ // orangtua
                $where_anak = " AND c.id_orangtua = $user->id";
            }else{
                $where_anak = " AND 1 = 0";
            }

            $sql = "SELECT c.id, c.nama as nama_anak, f.nama as nama_kelas FROM ekstrakulikuler a 
                JOIN (SELECT DISTINCT id_ekstra, id_anak FROM ekstrakulikuler_catatan WHERE is_catat = 1) b ON b.id_ekstra = a.id_ekstra
                JOIN registrasi_data_anak c ON c.id = b.id_anak
                JOIN v_kategori_usia d ON d.id = c.id 
                JOIN map_kelasusia e ON e.id_usia = d.id_usia
                JOIN ref_kelas f ON f.id_kelas = e.id_kelas
                WHERE a.id_ekstra = $id_ekstra $where_anak";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListTanggalByAnak($id_ekstra, $id_anak){
            if ($id_anak != -1) {
                $where_anak = " a.id_anak = $id_anak";
            }else{
                $where_anak = " 1 = 1";
            }

            $sql = "SELECT DISTINCT a.tanggal FROM ekstrakulikuler_catatan a 
                WHERE $where_anak AND a.id_ekstra = $id_ekstra AND a.is_catat = 1 ORDER BY a.tanggal DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getHasilEkstra($id_role, $id_ekstra, $id_anak, $tanggal){
            $user = $this->session->userdata['auth'];
            $kondisi = " ek.id_ekstra = $id_ekstra AND a.tanggal = '$tanggal' AND a.is_catat = 1";

            if ($id_anak == -1){
                if ($id_role == 9){ //guru ekstra
                    $kondisi .= "";
                }elseif($id_role == 1){ //admin
                    $kondisi .= ""; // semua ekstra
                }elseif ($id_role == 3){ // educator
                    $kondisi .= " AND a.id_anak IN (SELECT id FROM registrasi_data_anak WHERE educator = $user->id)";
                }elseif($id_role == 4){ // orangtua
                    $kondisi .= " AND a.id_anak IN (SELECT id FROM registrasi_data_anak WHERE id_orangtua = $user->id)";
                }else{
                    $kondisi .= " AND 1 = 0";
                }
            }else{
                $kondisi .= " AND a.id_anak = $id_anak ";
            }

            $sql = "SELECT a.*, b.nama as nama_anak, d.nama as nama_kelas, e.name as nama_pengampu
                FROM ekstrakulikuler_catatan a 
                JOIN ekstrakulikuler ek ON ek.id_ekstra = a.id_ekstra
                JOIN registrasi_data_anak an ON an.id = a.id_anak
                JOIN v_kategori_usia b ON b.id = an.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN data_user e ON e.id = a.pengampu_update
                WHERE $kondisi ORDER BY an.nama ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getLaporanEsktraFile($id_catatanekstra){
            $sql = "SELECT * FROM file_ektrakulikuler WHERE id_ekstracatatan = $id_catatanekstra";
            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataEkstraForm($id_ekstracatatan){
            $sql = "SELECT * FROM ekstrakulikuler_catatandet WHERE id_ekstracatatan = $id_ekstracatatan";

            $query = $this->db->query($sql);

            return $query->result();
        }
	}

?>