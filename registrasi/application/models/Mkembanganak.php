<?php  

	class MKembanganak extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'm_kembang_anak' ;
	    }

	    ## get all data in table
	    function getAll() {
            $this->db->select('m_kembang_anak.*, m_usia.name as usia, m_aspek.name as aspek');

            $this->db->join('m_usia', 'm_usia.id = m_kembang_anak.id_usia', 'left'); 

            $this->db->join('m_aspek', 'm_aspek.id = m_kembang_anak.id_aspek', 'left'); 

	    	$this->db->where('m_kembang_anak.is_active','1');
	    	
	    	$this->db->order_by('m_kembang_anak.id_aspek, m_kembang_anak.id_usia', 'ASC');

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->select('m_kembang_anak.id, m_kembang_anak.name');
	    	
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

        function getByIDusia($id) {
            $this->db->select('m_kembang_anak.id, m_kembang_anak.name, m_aspek.name as aspek');

            $this->db->join('m_aspek', 'm_aspek.id = m_kembang_anak.id_aspek', 'left'); 

            $this->db->where(array('id_usia' => $id));

            $this->db->order_by('id_aspek', 'ASC');
            
            $query = $this->db->get($this->table_name);
            
            return $query->result();
        }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

	    ## insert data into table
	    function insert() {
	        $a_input = array();
	       
	        foreach ($_POST as $key => $row) {
	            $a_input[$key] = $row;
	        }

	        $a_input['date_created'] = date('Y-m-d H:m:s');
	        $a_input['is_active']	 = '1';

            $this->db->insert($this->table_name, $a_input);

	        return $this->db->error();	        
	    }

	    ## update data in table
	    function update($id) {
	    	$_data = $this->input->post() ;
	    	
	        foreach ($_data as $key => $row) {
	            $a_input[$key] = $row;
	        }

	        $a_input['date_updated'] = date('Y-m-d H:m:s');	        

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