<?php  

	class MRegisterorangtua extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'registrasi_data_orangtua' ;
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
	    function getByIDAnak($id) {
	        $this->db->where(array('id_anak' => $id, 'is_active' => '1'));
	        
            $this->db->order_by('hubungan', 'ASC');

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
	       
            $index = 0;

            $hubungan_orang_tua = $_POST['hubungan_orang_tua'];
            unset($_POST['hubungan_orang_tua']);
            $id_anak = $_POST['id_anak'];
            unset($_POST['id_anak']);
	        
            $this->delete($id_anak);

            foreach ($_POST as $key => $row) {
                foreach ($_POST[$key] as $idx => $vx) {
                    $a_input[$idx][$key] = $_POST[$key][$idx];
                    $a_input[$idx]['id_anak'] = $id_anak;
                    
                    if($_POST['hubungan'][2] == 'W') {
                        $a_input[2]['hubungan_orang_tua'] = $hubungan_orang_tua;
                    }

                    $index++;
                }
            }
            
            foreach ($a_input as $key => $row) {
                $row['date_created'] = date('Y-m-d H:m:s');
                $row['is_active']    = '1';

                $this->db->insert($this->table_name, $row);
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

	        $this->db->where('id', $id);
	        
	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);	        
	    }

	    ## delete data in table
		function delete($id) {
			$a_input['is_active'] = '0';    
			
			$this->db->where('id_anak', $id);

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