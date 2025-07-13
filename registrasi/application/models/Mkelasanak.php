<?php  

	class Mkelasanak extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'registrasi_data_anak' ;
            $this->login = $this->session->userdata['auth'];
	    }

        function getListEducator(){
            $sql = "SELECT a.id, a.name as nama_educator
                FROM data_user a 
                WHERE a.id_role = 3 AND a.is_active = 1";
            $query = $this->db->query($sql);

            return $query->result();
        }

	    ## get all data in table
	    function getAll() {
            if($this->login->id_role == 4) {
                $where = " AND a.id_orangtua = ".$this->login->id;
            }else{
                $where = "";
            }

            $sql = "SELECT a.*, d.nama as nama_kelas
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                WHERE a.is_active = 1 $where ORDER BY a.nama ASC";

            $query = $this->db->query($sql);

	        return $query->result();
		}

        public function getKelasNonAlmahyra(){
            $sql = "SELECT *
                FROM ref_usia
                WHERE id_usia IN(13,14)";

            $query = $this->db->query($sql);

            return $query->result();
        }

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->where(array('is_active' => '1'));

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get data by id in table
	    function getByID($id) {
	        $this->db->where(array('id' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        ## get data by id in table
        function getByIDorangtua($id) {
            $this->db->where(array('id_orangtua' => $id));
            
            $query = $this->db->get($this->table_name);
            
            return $query->result();
        }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

        function updateKelasAnak($id_usia, $id_anak) {
            $user = $this->session->userdata['auth'];

            $a_input['id_usia'] = $id_usia;
            $a_input['updater_kelas'] = $user->id;
	        $a_input['date_updated'] = date('Y-m-d H:m:s');

	        $this->db->where('id', $id_anak);

	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);
	    }

        function updateKeAlmahyra($id_anak) {
            $user = $this->session->userdata['auth'];

            $a_input['id_usia'] = null;
            $a_input['updater_kelas'] = $user->id;
	        $a_input['date_updated'] = date('Y-m-d H:m:s');

	        $this->db->where('id', $id_anak);

	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);
	    }

		## get data by id in table
	    function getByKode($id) {
	        $this->db->where(array('kode' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        ## get data by id orang tua in table
        function getDetails($id_anak) {
            $this->db->where(
                array(
                    'registrasi_data_anak.id' => $id_anak,
                    'registrasi_data_anak.is_active' => 1,
                )
            );

            $this->db->select('
                registrasi_data_anak.*, 
                registrasi_data_berkas.upload_foto_anak
            ');

            $this->db->join('registrasi_data_berkas', 'registrasi_data_berkas.id_anak = registrasi_data_anak.id', 'left'); 
            
            $query = $this->db->get($this->table_name);
            
            return $query->row();
        }

	}

?>