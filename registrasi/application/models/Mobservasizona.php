<?php  

	class MObservasizona extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'observasi_data_zona' ;
            $this->login = $this->session->userdata['auth'];
	    }

	    ## get all data in table
	    function getAll() {
	    	$this->db->where('is_active','1');

            if($this->login->id_role == 4) {

                $this->db->where('id_orangtua', $this->login->id);                
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
	        $this->db->select('
                observasi_data_zona.id, 
                observasi_data_zona.tanggal, 
                data_user.name as pengajar, 
                m_kelas.name as zona,
                m_kelas.status,');

            $this->db->where(array('id_anak' => $id, 'observasi_data_zona.is_active' => '1'));
            
            $this->db->order_by('id','desc');

            $this->db->join('m_kelas', 'm_kelas.id = observasi_data_zona.id_zona', 'left'); 

            $this->db->join('data_user', 'data_user.id = m_kelas.id_pengasuh', 'left'); 

            $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        ## get data by id in table
        function getByIDanak($id) {
            $this->db->select('
                observasi_data_zona.id, 
                observasi_data_zona.tanggal, 
                data_user.name as pengajar, 
                m_kelas.name as zona,
                m_kelas.status,');

            $this->db->where(array('id_anak' => $id, 'observasi_data_zona.is_active' => '1'));
            
            $this->db->order_by('tanggal','desc');

            $this->db->join('m_kelas', 'm_kelas.id = observasi_data_zona.id_zona', 'left'); 

            $this->db->join('data_user', 'data_user.id = m_kelas.id_pengasuh', 'left'); 

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

            unset($a_input['tbl_length']);
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

            if ($a_input['id'] == null) {
                unset($a_input['id']);

                $this->db->insert($this->table_name, $a_input);
            } else {
                $this->db->where('id', $id);
            
                $this->db->update($this->table_name, $a_input);
            }

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