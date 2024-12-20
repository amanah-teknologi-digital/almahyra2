<?php  

	class Mlaporanmedicalcheckup extends CI_Model
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

        function getDataMedicalCheckup($id_anak, $tahun){
            $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_checkup, e.tanggal, e.keterangan, f.*, g.kolom, g.satuan
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN medical_checkup e ON e.id_anak = a.id AND YEAR(e.tanggal) = $tahun
                JOIN rincian_medicalcheckup f ON f.id_checkup = e.id_checkup
                JOIN form_medical g ON g.id_formmedical = f.id_formmedical
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

        function getDokumentasiFile($id_checkup){
            $sql = "SELECT * FROM file_medicalcheckup WHERE id_checkup = $id_checkup";
            $query = $this->db->query($sql);

            return $query->result();
        }
	}

?>