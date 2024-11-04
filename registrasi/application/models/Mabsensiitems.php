<?php  

	class Mabsensiitems extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'absensi_items' ;
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
	        $this->db->where(array('id_anak' => $id, 'is_active' => '1'));
	        
            $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        ## get data by id in table
        function getByIDanak($id) {
            $this->db->where(array('id_anak' => $id, 'is_active' => '1', 'tanggal' => date("Y-m-d")));
            
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
	        
            $a_input['id_anak'] = $this->input->post('id_anak');
            $a_input['tanggal'] = $this->input->post('tanggal');
            $a_input['kondisi'] = $this->input->post('kondisi');
            $a_input['suhu'] = $this->input->post('suhu');            
            $a_input['status'] = $this->input->post('status');
            $a_input['date_created'] = date('Y-m-d H:m:s');
            $a_input['is_active']    = '1'; 

            $this->db->insert($this->table_name, $a_input);    
            $id_absensi = $this->db->insert_id();

            foreach ($_POST as $key => $row) {

                $i_input = array();

                if (strpos($key, 'jumlah') !== false) {
                    $id_item =  explode("_", $key)[1];

                    $i_input['id_anak'] = $this->input->post('id_anak');
                    $i_input['id_absensi'] = $id_absensi ;
                    $i_input['id_item'] = $id_item ;
                    $i_input['jumlah'] = $row ;
                    $i_input['sisa'] = 0;
                    $i_input['keterangan'] = '-';
                    $i_input['tanggal'] = $this->input->post('tanggal');
                    
                    $this->db->insert('absensi_items_item', $i_input);  
                } 
	        }
            
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