<?php  

	class Mlaporanmengaji extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'ref_tahun' ;
	    }

	    ## get all data in table

        function getListSesi(){
            $sql = "SELECT * FROM mengaji_sesi";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListUstadzah($id_role){
            if ($id_role == 7){
                $user = $this->session->userdata['auth'];
                $where = " AND id = ".$user->id;
            }else{
                $where = "";
            }

            $sql = "SELECT id, name FROM data_user WHERE id_role = 7 AND status = 1 $where";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListTahun(){
            $sql = "SELECT DISTINCT YEAR(tanggal) as tahun FROM mengaji_catatan ORDER BY YEAR(tanggal) DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getHasilMengaji($id_role, $tahun, $tanggal, $sesi, $id_ustadzah){
            $kondisi = " AND YEAR(e.tanggal) = ".$tahun;

            if ($tanggal == -1){
                $kondisi .= " AND e.is_catat = 1 ";
            }else{
                $kondisi .= " AND e.tanggal = '$tanggal' AND e.is_catat = 1 ";
            }

            if (!empty($sesi)) {
                $kondisi .= " AND e.id_sesi = '$sesi' ";
            }

            if (!empty($id_ustadzah)) {
                $kondisi .= " AND e.id_ustadzah = '$id_ustadzah' ";
            }

            if ($id_role == 7){
                $user = $this->session->userdata['auth'];
                $kondisi .= " AND e.id_ustadzah = ".$user->id;
            }

            if ($id_role == 4){
                $user = $this->session->userdata['auth'];
                $kondisi .= " AND a.id_orangtua = ".$user->id;
            }

            if ($id_role == 3){
                $user = $this->session->userdata['auth'];
                $kondisi .= " AND a.educator = ".$user->id;
            }

            $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_catatan, e.halaman, e.nilai, e.tanggal, e.keterangan, e.created_at, e.updated_at, e.is_catat, f.name as nama_ustadzah, g.name as nama_role,
                h.nama as nama_sesi, i.nama as nama_jilid
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN mengaji_catatan e ON e.id_anak = a.id $kondisi
                JOIN mengaji_sesi h ON h.id_sesi = e.id_sesi
                JOIN mengaji_jilid i ON i.id_jilidmengaji = e.id_jilidmengaji
                JOIN data_user f ON f.id = e.id_ustadzah
                JOIN m_role g ON g.id = f.id_role
                WHERE a.is_active = 1 ORDER BY e.tanggal DESC, a.id, h.id_sesi ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

	    function getAll() {
            $sql = "SELECT a.*, b.name as nama_user, c.name as nama_role, d.tahun as is_pakai FROM ref_tahun a 
                JOIN data_user b ON b.id = a.updater 
                JOIN m_role c ON c.id = b.id_role 
                LEFT JOIN (SELECT tahun FROM tema_bulanan GROUP BY tahun) d ON d.tahun = a.tahun                           
                ORDER BY a.tahun DESC";

            $query = $this->db->query($sql);

	        return $query->result();
		}

        function getListTanggalByTahun($tahun){
            $sql = "SELECT DISTINCT tanggal FROM mengaji_catatan WHERE YEAR(tanggal) = $tahun ORDER BY tanggal DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListAnak($id_role){
            $user = $this->session->userdata['auth'];

            $tanggal_sekarang = date('Y-m-d');

            if ($id_role == 1 OR $id_role == 2 OR $id_role == 5){ // admin & superadmin & system absen
                $where_anak = "";
            }elseif ($id_role == 3){ // educator
                $where_anak = " AND a.educator = $user->id";
            }elseif($id_role == 4){ // orangtua
                $where_anak = " AND a.id_orangtua = $user->id";
            }else{
                $where_anak = " AND 1 = 0";
            }

            $sql = "SELECT a.id, a.nama as nama_anak, a.tanggal_lahir, a.is_active
                FROM registrasi_data_anak a 
                WHERE 1 = 1 $where_anak ORDER BY a.tanggal_lahir ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataAbsensi($id_anak, $tahun){
            $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_absensi, e.tanggal, e.tanggal_checkout, e.waktu_checkin, e.suhu, e.suhu_checkout, e.kondisi, e.kondisi_checkout, e.waktu_checkout, f.name as nama_user, g.name as nama_role, h.name as nama_user2, i.name as nama_role2
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN absen_anak e ON e.id_anak = a.id AND YEAR(e.tanggal) = $tahun
                JOIN data_user f ON f.id = e.updater
                JOIN m_role g ON g.id = f.id_role
                LEFT JOIN data_user h ON h.id = e.updater2
                LEFT JOIN m_role i ON i.id = h.id_role
                WHERE a.id = $id_anak ORDER BY e.tanggal DESC";

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

        function getLaporanMengajiFile($id_catatanmengaji){
            $sql = "SELECT * FROM file_mengaji WHERE id_catatan = $id_catatanmengaji";
            $query = $this->db->query($sql);

            return $query->result();
        }
	}

?>