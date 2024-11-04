<?php  

	class MRegisterrekammedik extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'registrasi_data_rekam_medik' ;
            $this->login = $this->session->userdata['auth'];
            $this->load->model('Mrekampenyakit', 'MRekampenyakit');
            $this->load->model('Mrekamimunisasi', 'MRekamimunisasi');
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
	        $this->db->where(array('id' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        ## get data by id in table
        function getByIDAnak($id) {
            $this->db->where(array('id_anak' => $id, 'is_active' => '1'));

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

            $this->delete($a_input['id_anak']);

	        $a_input['date_created'] = date('Y-m-d H:m:s');
	        $a_input['is_active']	 = '1';

            $a_input_imunisasi = array();
            if(!empty($a_input['imunisasi'])){
                $a_input_imunisasi = $a_input['imunisasi'];
                unset($a_input['imunisasi']);    
            }

            $a_input_penyakit = array();
            $a_input_penyakit_keterangan = array();
            if(!empty($a_input['penyakit'])){
                $a_input_penyakit = $a_input['penyakit'];
                unset($a_input['penyakit']);    

                $a_input_penyakit_keterangan = $a_input['keterangan'];
                unset($a_input['keterangan']); 
            } else {
                unset($a_input['keterangan']); 
            }

            $this->db->insert($this->table_name, $a_input);

            $id_rekam_medik = $this->db->insert_id();

            if(!empty($a_input_imunisasi)){
                // insert
                $this->MRekamimunisasi->delete($id_rekam_medik);

                foreach ($a_input_imunisasi as $key => $value) {
                    $imunisasi['id_rekam_medik']  = $id_rekam_medik;
                    $imunisasi['id_imunisasi']  = $value;
                    $this->MRekamimunisasi->insert($imunisasi);
                }  
            }

            if(!empty($a_input_penyakit)){
                // insert
                $this->MRekampenyakit->delete($id_rekam_medik);

                foreach ($a_input_penyakit as $key => $value) {
                    $penyakit['id_rekam_medik']  = $id_rekam_medik;
                    $penyakit['id_penyakit']  = $value;
                    $penyakit['keterangan']  = $a_input_penyakit_keterangan[$value];

                    $this->MRekampenyakit->insert($penyakit);
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

	}

?>