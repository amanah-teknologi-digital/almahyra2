<?php  

	class MTematikBulan extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'ref_bulan' ;
	    }

	    ## get all data in table
	    function getAll()
        {
            $sql = "SELECT a.*, b.jml_bulan, COALESCE(c.jml_tematikbulanan, 0) AS jml_tematikbulanan FROM ref_tahun a 
                LEFT JOIN (SELECT COUNT(bulan) as jml_bulan FROM ref_bulan) b ON 1 = 1
                LEFT JOIN (SELECT tahun, COUNT(bulan) as jml_tematikbulanan FROM tema_bulanan GROUP BY tahun) c ON c.tahun = a.tahun                           
                ORDER BY a.tahun DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getAllBulanByTahun($tahun) {
            $sql = "SELECT a.bulan, a.nama as nama_bulan, b.id_temabulanan, b.nama as nama_temabulanan, b.deskripsi,
                b.created_at, b.updated_at, c.name as nama_user, d.name as nama_role
                FROM ref_bulan a 
                LEFT JOIN tema_bulanan b ON b.bulan = a.bulan and b.tahun = $tahun                          
                LEFT JOIN data_user c ON c.id = b.updater               
                LEFT JOIN m_role d ON d.id = c.id_role               
                ORDER BY a.bulan ASC";

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
	        $this->db->where(array('id_temabulanan' => $id));
	        
	        $query = $this->db->get("tema_bulanan");
	        
	        return $query->row();
	    }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

	    ## insert data into table
	    function insert() {
            $user = $this->session->userdata['auth'];

            $tahun = $_POST['tahun_penentuan'];
            $bulan = $_POST['bulan_penentuan'];
            $nama_tema = $_POST['nama_tema'];
            $keterangan = $_POST['keterangan'];

	        $a_input['tahun'] = $tahun;
	        $a_input['bulan'] = $bulan;
	        $a_input['nama'] = $nama_tema;
	        $a_input['deskripsi'] = $keterangan;
	        $a_input['created_at'] = date('Y-m-d H:m:s');
	        $a_input['updater'] = $user->id;

	        $this->db->insert('tema_bulanan', $a_input);

	        return $this->db->error();	        
	    }

	    ## update data in table
	    function update($id) {
            $user = $this->session->userdata['auth'];

	        $a_input['nama'] = $_POST['nama_tema'];
	        $a_input['deskripsi'] = $_POST['keterangan'];
	        $a_input['updated_at'] = date('Y-m-d H:m:s');
	        $a_input['updater'] = $user->id;

	        $this->db->where('id_temabulanan', $id);
	        
	        $this->db->update('tema_bulanan', $a_input);

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

        function getJadwalMingguanByTahun($tahun) {
            $sql = "SELECT a.bulan, b.id_temabulanan, c.id_jadwalmingguan, c.nama as nama_subtema, d.tanggal,
                e.name as nama_user, f.name as nama_role, d.created_at, d.updated_at
                FROM ref_bulan a 
                JOIN tema_bulanan b ON b.bulan = a.bulan and b.tahun = $tahun
                JOIN jadwal_mingguan c ON c.id_temabulanan = b.id_temabulanan
                JOIN rincian_jadwal_mingguan d ON d.id_jadwalmingguan = c.id_jadwalmingguan                          
                JOIN data_user e ON e.id = d.updater               
                JOIN m_role f ON f.id = e.id_role               
                ORDER BY c.id_jadwalmingguan, d.tanggal ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

	}

?>