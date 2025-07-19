<?php  

	class Mlaporananjem extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'ref_tahun' ;
	    }

	    ## get all data in table
	    function getAll() {
            $sql = "SELECT a.*, b.name as nama_user, c.name as nama_role, d.tahun as is_pakai FROM ref_tahun a 
                JOIN data_user b ON b.id = a.updater 
                JOIN m_role c ON c.id = b.id_role 
                LEFT JOIN (SELECT tahun FROM tema_bulanan GROUP BY tahun) d ON d.tahun = a.tahun                           
                ORDER BY a.tahun DESC";

            $query = $this->db->query($sql);

	        return $query->result();
		}

        function getListTahun(){
            $sql = "SELECT DISTINCT YEAR(tanggal) as tahun FROM absen_anak ORDER BY YEAR(tanggal) DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListTanggalByTahun($tahun){
            $sql = "SELECT DISTINCT tanggal FROM absen_anak WHERE YEAR(tanggal) = $tahun ORDER BY tanggal DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListAnak($id_role){
            $user = $this->session->userdata['auth'];

            if ($id_role == 1){ // admin & superadmin & system absen
                $where_anak = " AND a.id IN(SELECT DISTINCT id_anak FROM antar_jemput WHERE is_valid = 1)";
            }elseif ($id_role == 3){ // educator
                $where_anak = " AND a.id IN(SELECT DISTINCT id_anak FROM antar_jemput WHERE is_valid = 1 AND educator = ".$user->id.")";
            }elseif($id_role == 4){ // orangtua
                $where_anak = " AND a.id_orangtua = $user->id";
            }else{
                $where_anak = " AND 1 = 0";
            }

            $sql = "SELECT a.id, a.nama as nama_anak
                FROM registrasi_data_anak a 
                WHERE 1 = 1 $where_anak ORDER BY a.nama ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataKebutuhan($id_anak){
            $sql = "SELECT a.*, d.nama as nama_kelas, e.name as nama_educator, f.nama as nama_jeniskebutuhan
                FROM antar_jemput a 
                JOIN v_kategori_usia b ON b.id = a.id_anak 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN data_user e ON e.id = a.educator
                JOIN jenis_antarjemput f ON f.id_jenis_antarjemput = a.id_jenis_antarjemput
                WHERE a.id_anak = $id_anak AND a.is_valid = 1 ORDER BY a.tanggal DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataAnak($id_anak){
            $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                WHERE a.id = $id_anak";

            $query = $this->db->query($sql);

            return $query->row();
        }
	}

?>