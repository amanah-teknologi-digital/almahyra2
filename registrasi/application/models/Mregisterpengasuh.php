<?php  

	class MRegisterpengasuh extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'registrasi_data_pengasuh' ;
            $this->login = $this->session->userdata['auth'];
	    }

	    ## get all data in table
	    function getAll() {
            
	    	$this->db->where('is_active','1');

            if($this->login->id_role == 3) {

                $this->db->where('id', $this->login->id);                
            }

	        $query = $this->db->get($this->table_name);

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
            $this->db->where(array('id' => $id));
            
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
            $a_input['id']  = $this->login->id;

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

        ## get data by id orang tua in table
        function getDetails($id_anak) {
            $this->db->where(
                array(
                    'registrasi_data_pengasuh.id' => $id_anak,
                    'registrasi_data_pengasuh.is_active' => 1,
                )
            );

            $this->db->select('
                registrasi_data_pengasuh.*, 
                registrasi_data_berkas_pengasuh.upload_foto_anak
            ');

            $this->db->join('registrasi_data_berkas_pengasuh', 'registrasi_data_berkas_pengasuh.id_anak = registrasi_data_pengasuh.id', 'left'); 
            
            $query = $this->db->get($this->table_name);
            
            return $query->row();
        }

	}

?>