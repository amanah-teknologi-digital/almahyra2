<?php  

	class MaktivitasHarian extends CI_Model
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

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->select('m_role.id, m_role.name');
	    	
	    	$this->db->where(array('is_active' => '1'));

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get data by id in table
	    function getByID($id) {
	        $this->db->where(array('tahun' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

        function getListTahun(){
            $sql = "SELECT * FROM ref_tahun ORDER BY tahun DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListTanggalByTahun($tahun){
            $sql = "SELECT b.nama as nama_subtema, e.nama as nama_bulan, a.nama as nama_tema, c.id_rincianjadwal_mingguan, c.tanggal
                FROM tema_bulanan a 
                JOIN jadwal_mingguan b ON b.id_temabulanan = a.id_temabulanan
                JOIN rincian_jadwal_mingguan c ON c.id_jadwalmingguan = b.id_jadwalmingguan
                JOIN jadwal_harian d ON d.id_rincianjadwal_mingguan = c.id_rincianjadwal_mingguan
                JOIN ref_bulan e ON e.bulan = a.bulan  
                WHERE a.tahun = $tahun ORDER BY c.tanggal DESC";

                $query = $this->db->query($sql);

                return $query->result();
        }

        function getAktivitasHarian($id_rincianjadwal_mingguan){
            $sql = "SELECT * FROM jadwal_harian a 
            JOIN 
            WHERE a.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getKelasByIdRincian($id_rincianjadwal_mingguan){
            $sql = "SELECT a.id_jadwalharian, b.nama as nama_kelas FROM jadwal_harian a 
            JOIN ref_kelas b ON b.id_kelas = a.id_kelas
            WHERE a.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getAktivitasHarianByIdJadwal($id_jadwalharian){
            $sql = "SELECT a.*, b.id_aktivitas, b.progres_aktivitas FROM registrasi_data_anak a 
                JOIN(
                SELECT c.id_aktivitas, c.id_jadwalharian, c.id_anak, COALESCE(d.progres_aktivitas,0) as progres_aktivitas
                FROM jadwal_harian a
                JOIN ref_kelas b ON b.id_kelas = a.id_kelas
                JOIN aktivitas c ON c.id_jadwalharian = a.id_jadwalharian
                LEFT JOIN (SELECT COUNT(id_rincianaktivitas) as progres_aktivitas, id_aktivitas FROM rincian_aktivitas GROUP BY id_aktivitas) as d ON d.id_aktivitas = c.id_aktivitas
                WHERE a.id_jadwalharian = $id_jadwalharian
                UNION
                SELECT null as id_aktivitas, null as id_jadwalharian, d.id as id_anak, 0 as progres_aktivitas
                FROM jadwal_harian a 
                JOIN map_kelasusia b ON b.id_kelas = a.id_kelas
                JOIN v_kategori_usia c ON c.id_usia = b.id_usia
                JOIN registrasi_data_anak d ON d.id = c.id 
                WHERE a.id_jadwalharian = $id_jadwalharian AND c.is_active = 1 AND d.id NOT IN (SELECT id_anak FROM aktivitas WHERE id_jadwalharian = $id_jadwalharian)
                ) as b ON b.id_anak = a.id ORDER BY a.nama ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function checkAktivitas($id_jadwalharian, $id_anak){
            $sql = "SELECT id_aktivitas FROM aktivitas WHERE id_jadwalharian = $id_jadwalharian AND id_anak = $id_anak";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                return $query->row()->id_aktivitas;
            }else{
                $a_input['id_jadwalharian'] = $id_jadwalharian;
                $a_input['id_anak'] = $id_anak;

                $this->db->insert('aktivitas', $a_input);

                return $this->db->insert_id();
            }
        }

        function getJumlahKegiatan($id_jadwalharian){
            $sql = "SELECT COUNT(id_rincianjadwal_harian) as jumlah_kegiatan FROM rincian_jadwal_harian WHERE id_jadwalharian = $id_jadwalharian";

            $query = $this->db->query($sql);

            return $query->row()->jumlah_kegiatan;
        }

	    ## insert data into table
	    function insert() {
            $user = $this->session->userdata['auth'];
            $tahun_sekarang = date('Y');

	        $a_input['tahun'] = $_POST['tahun'];
	        $a_input['uraian'] = $_POST['name'];
	        $a_input['created_at'] = date('Y-m-d H:m:s');
            if ($tahun_sekarang == $_POST['tahun']){
                $a_input['is_aktif'] = 1;
            }else{
                $a_input['is_aktif'] = 0;
            }

	        $a_input['updater'] = $user->id;

	        $this->db->insert($this->table_name, $a_input);

	        return $this->db->error();	        
	    }

	    ## update data in table
	    function update($id) {
            $user = $this->session->userdata['auth'];

	        $a_input['uraian'] = $_POST['name'];
	        $a_input['updated_at'] = date('Y-m-d H:m:s');
	        $a_input['updater'] = $user->id;

	        $this->db->where('tahun', $id);
	        
	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);	        
	    }

	    ## delete data in table
		function delete($id) {
			$this->db->where('tahun', $id)->where('is_aktif', 0);

			$this->db->delete($this->table_name);

			return $this->db->affected_rows();
		}

		## get data by id in table
	    function getByKode($id) {
	        $this->db->where(array('kode' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

	}

?>