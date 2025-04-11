<?php  

	class Mlaporanabsensieducator extends CI_Model
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

        function getListEducator($id_role){
            $user = $this->session->userdata['auth'];

            if ($id_role == 1 OR $id_role == 2 OR $id_role == 5){ // admin & superadmin & system absen
                $where = "";
            }elseif ($id_role == 3){ // educator
                $where = " AND a.id = $user->id";
            }elseif($id_role == 4){ // orangtua
                $where = " AND 1 = 0";
            }else{
                $where = " AND 1 = 0";
            }

            $sql = "SELECT a.id, a.name as nama_educator, a.is_active
                FROM data_user a 
                WHERE a.id_role = 3 $where ORDER BY a.name ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataAbsensi($id_user, $tahun){
            $sql = "SELECT a.id_absensi, a.tanggal, a.tanggal_checkout, a.id_jenisabsen, a.id_jenislembur, a.waktu_checkin,
                a.waktu_checkout, a.kondisi, a.kondisi_checkout, a.keterangan, b.nama as jenis_absen, c.nama as jenis_lembur, d.name as nama_educator
                FROM absen_educator a 
                JOIN ref_jenisabsen b ON b.id_jenisabsen = a.id_jenisabsen
                JOIN data_user d ON d.id = a.id_user
                LEFT JOIN ref_jenislembur c ON c.id_jenislembur = a.id_jenislembur
                WHERE a.id_user = '$id_user' AND YEAR(a.tanggal) = $tahun
                ORDER BY a.tanggal DESC, a.waktu_checkin DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataEducator($id_user){
            $sql = "SELECT a.id, a.name as nama_educator
                FROM data_user a 
                WHERE a.id = $id_user";

            $query = $this->db->query($sql);

            return $query->row();
        }
	}

?>