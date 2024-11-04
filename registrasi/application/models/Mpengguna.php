<?php  

	class MPengguna extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'data_user' ;
	    }

	    ## get all data in table
	    function getAll() {
	    	$this->db->select('data_user.*, m_role.name as role');

	    	$this->db->where('data_user.is_active','1');

	    	$this->db->join('m_role', 'm_role.id = data_user.id_role', 'left'); 

	    	// $this->db->limit(1);

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

        ## get all data in table
        function getAllPengajar() {
            $this->db->select('data_user.id, data_user.name');

            $this->db->where('data_user.is_active','1');

            $this->db->where('data_user.id_role','3');

            // $this->db->limit(1);

            $query = $this->db->get($this->table_name);

            return $query->result();
        }

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->select('data_user.id, data_user.name');
	    	
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
	       
	        foreach ($_POST as $key => $row) {
	            $a_input[$key] = $row;
	        }

	        // $a_input['id_role']= $a_input['id_role'];
            // $a_input['name']= $a_input['name'];
            // $a_input['email']= $a_input['email'];
            // $a_input['password']= $a_input['password'];
            // $a_input['phone']= $a_input['phone'];
            // $a_input['photo']= $a_input['photo'];
            // $a_input['purpose']= $a_input['purpose'];
	        $a_input['date_created'] = date('Y-m-d H:m:s');
	        $a_input['is_active']	 = '1';

	        $this->db->insert($this->table_name, $a_input);

	        return $this->db->error();	        
	    }

	    ## update data in table
	    function update($id) {
	    	$a_input = array();

	    	$_data = $this->input->post() ;
	    	
	        foreach ($_data as $key => $row) {
	            $a_input[$key] = $row;
	        }

	        $a_input['date_updated'] = date('Y-m-d H:m:s');	    

	        if($a_input['password']) {
	        	$a_input['password'] = md5($a_input['password']);
	        } else {
	        	unset($a_input['password']);
	        } 

	        $this->db->where('id', $id);
	        
	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);	        
	    }

	    ## delete data in table
		function delete($id) {
			$a_input = array();

			$a_input['is_active'] = '0';    
			
			$this->db->where('id', $id);

			$this->db->update($this->table_name, $a_input);

			return $this->db->error();	      
		}

		## delete data in table
		function resets($id) {
			$a_input = array();

			$a_input['password'] = md5('12345');

			$this->db->where('id', $id);

			$this->db->update($this->table_name, $a_input);

			return $this->db->error();	      
		}

		function getLogin() {

			$_data = $this->input->post() ;
            
            // $a_input = array();

			foreach ($_data as $key => $row) {
	            $a_input[$key] = $row;
	        }

	        $this->db->select('
	        	data_user.id_role, 
	        	data_user.name, 
	        	data_user.email, 
	        	data_user.phone,
	        	data_user.id,
                data_user.photo,
                data_user.purpose,
                data_user.status,
	        ');

	        $this->db->where(
	    		array(
	    			'data_user.email' 	  => $a_input['email'],
	    			// 'data_user.password'  => md5($a_input['password']),
                    'data_user.password'  => $a_input['password'],
	    			'data_user.is_active' => 1,
                    // 'data_user.status' => 1,
	    		)
	    	);	   

            $this->db->limit(1);

	        $query = $this->db->get($this->table_name);
			  
	        return $query->row();
	    }

        function getAllKepalaSekolah() {
            $this->db->select('data_user.name, m_role.name as role');

            $this->db->where('data_user.is_active','1');

            $this->db->where('m_role.name','Kepala Sekolah');

            $this->db->join('m_role', 'm_role.id = data_user.id_role', 'left'); 

            $this->db->order_by('data_user.id','desc');

            $query = $this->db->get($this->table_name);

            return $query->row();
        }

	}

?>