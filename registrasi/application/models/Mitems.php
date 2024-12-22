<?php  

	class MItems extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'm_items' ;
	    }

	    ## get all data in table
	    function getAll() {
	    	$this->db->where('is_active','1');

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->select('m_items.id, m_items.name');
	    	
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

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

	    ## insert data into table
	    function insert() {
	        $a_input = array();

            $standarisasi = $_POST['standarisasi'];
            $standarisasi = json_encode($standarisasi, JSON_FORCE_OBJECT);
	        $a_input['pilihan'] = $standarisasi;
	        $a_input['date_created'] = date('Y-m-d H:m:s');
	        $a_input['is_active']	 = '1';
	        $a_input['name']	 = $_POST['name'];

	        $this->db->insert($this->table_name, $a_input);

	        return $this->db->error();	        
	    }

	    ## update data in table
	    function update($id) {
            $standarisasi = $_POST['standarisasi_update'];
            $standarisasi = json_encode($standarisasi, JSON_FORCE_OBJECT);

	        $a_input['name'] = $_POST['name'];
	        $a_input['date_updated'] = date('Y-m-d H:m:s');
	        $a_input['pilihan'] = $standarisasi;

	        $this->db->where('id', $id);
	        
	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);	        
	    }

	    ## delete data in table
		function delete($id) {
			$a_input['is_active'] = '0';    
			
			$this->db->where('id', $id);

			$this->db->update($this->table_name, $a_input);

			return $this->db->error();	      
		}

		## get data by id in table
	    function getByKode($id) {
	        $this->db->where(array('kode' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

	}

?>