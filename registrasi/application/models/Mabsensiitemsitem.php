<?php  

	class Mabsensiitemsitem extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'absensi_items_item' ;
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

        ## get all data in table
        function getAllbyIdanak($id) {
            $this->db->select('
                absensi_items_item.*,
                m_items.name as item,
                m_items.satuan'
            );

            $this->db->where(array('id_anak' => $id, 'tanggal' => date($this->input->post('tanggal'))));

            $this->db->join('m_items', 'm_items.id = absensi_items_item.id_item', 'left'); 

            $this->db->order_by('tanggal','desc');

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
            // $this->db->where(array('id_anak' => $id, 'm_kembang_anak.is_active' => '1'));
            
            // $this->db->order_by('tanggal','desc');

            // $this->db->join('m_kembang_anak', 'm_kembang_anak.id = observasi_data_perkembangan_anak.id_kembang_anak', 'left'); 

            // $this->db->join('m_aspek', 'm_aspek.id = m_kembang_anak.id_aspek', 'left'); 

            // $this->db->select('
            //     observasi_data_perkembangan_anak.answer, 
            //     observasi_data_perkembangan_anak.tanggal, 
            //     m_kembang_anak.name,
            //     m_aspek.name as aspek'
            // );

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
	        
            $a_input['tanggal'] = $this->input->post('id');
            $a_input['suhu'] = $this->input->post('suhu');
            $a_input['kondisi'] = $this->input->post('kondisi');
            $a_input['status'] = $this->input->post('status');
            $a_input['id_anak'] = $this->input->post('id_anak');
            // $a_input['keterangan'] = $this->input->post('keterangan') ? $this->input->post('keterangan') : '-';

            $arr_jumlah = array();

	        foreach ($_POST as $key => $row) {
                if (strpos($key, 'jumlah') !== false) {
                    $id_item =  explode("_", $key)[1];
                    array_push($arr_jumlah,"blue","yellow");
                } 
	        }
            
            foreach ($answer as $key => $p) {
                $split = explode('_',$p);
                
                $a_input['id_kembang_anak'] = $split[0];
                $a_input['answer']  = $split[1];

                $a_input['date_created'] = date('Y-m-d H:m:s');
                $a_input['is_active']    = '1';

                $this->db->insert($this->table_name, $a_input);    
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

            $this->db->where('id', $a_input['id']);
            
            $this->db->update($this->table_name, $a_input);

            unset($a_input['id']);
            
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