<?php  

	class MKelas extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'm_kelas' ;
	    }

	    ## get all data in table
	    function getAll() {
	    	$this->db->select('m_kelas.*, data_user.name as pengasuh, m_usia.name as usia');            

            $this->db->join('data_user', 'data_user.id = m_kelas.id_pengasuh', 'left'); 

            $this->db->join('m_usia', 'm_usia.id = m_kelas.id_usia', 'left'); 

            $this->db->where('m_kelas.is_active', '1');

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->select('m_kelas.id, m_kelas.name , data_user.name as pengasuh, m_usia.name as usia, m_kelas.status');            

            $this->db->join('data_user', 'data_user.id = m_kelas.id_pengasuh', 'left'); 

            $this->db->join('m_usia', 'm_usia.id = m_kelas.id_usia', 'left'); 

            $this->db->where('m_kelas.is_active', '1');

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get data by id in table
	    function getByID($id) {
            $this->db->select('m_kelas.*, data_user.name as pengasuh, m_usia.name as usia');            

            $this->db->join('data_user', 'data_user.id = m_kelas.id_pengasuh', 'left'); 

            $this->db->join('m_usia', 'm_usia.id = m_kelas.id_usia', 'left'); 

	        $this->db->where('m_kelas.id', $id);
	        
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