<?php  

	class MPembayarantagihan extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'pembayaran_tagihan' ;
            $this->login = $this->session->userdata['auth'];
	    }

	    ## get all data in table
	    function getAll() {
	    	$this->db->where('is_active','1');

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->select('pembayaran_tagihan.id, pembayaran_tagihan.name');
	    	
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
        function getDetail($id) {
            $this->db->where(array('id' => $id, 'is_active' => '1'));
            
            $query = $this->db->get($this->table_name);
            
            return $query->row();
        }

        ## get data by id in table
        function getByIDanak($id) {
            
            $this->db->select('
                pembayaran_tagihan.id,
                pembayaran_tagihan.tanggal_tagihan, 
                pembayaran_tagihan.status,
                pembayaran_tagihan.bukti,
                m_tagihan.name,
                m_tagihan.harga,
                m_tagihan.satuan,
                m_uraian.name as uraian
                ');

            $this->db->where(array('id_anak' => $id, 'pembayaran_tagihan.is_active' => '1'));

            $this->db->join('m_tagihan', 'pembayaran_tagihan.id_tagihan = m_tagihan.id', 'left'); 

            $this->db->join('m_uraian', 'm_tagihan.id_uraian = m_uraian.id', 'left'); 

            $this->db->order_by('tanggal_tagihan','desc');

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

            $tagihan = $a_input['tagihan'] ;
            unset($a_input['tbl_length']);
            unset($a_input['tagihan']);

	        $a_input['date_created'] = date('Y-m-d H:m:s');
	        $a_input['is_active']	 = '1';

            foreach ($tagihan as $key => $id_tagihan) {
                $a_input['id_tagihan'] = $id_tagihan;                
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

        function bayar($id, $filenames) {
            $a_input = array();
           
            foreach ($filenames as $key => $row) {
                $a_input[$key] = $row;
            }

            $a_input['date_created'] = date('Y-m-d H:m:s');
            $a_input['is_active']    = '1';

            $this->db->where('id', $id);
            
            $this->db->update($this->table_name, $a_input); 

            return $this->db->error();          
        }

        function getByIDanakSum($id) {
            
            $this->db->select('
                pembayaran_tagihan.tanggal_tagihan, 
                sum(m_tagihan.harga) as harga
            ');

            $this->db->where(array('id_anak' => $id, 'pembayaran_tagihan.is_active' => '1'));

            $this->db->join('m_tagihan', 'pembayaran_tagihan.id_tagihan = m_tagihan.id', 'left'); 

            $this->db->group_by('MONTH(tanggal_tagihan)');

            $this->db->order_by('tanggal_tagihan','desc');

            $query = $this->db->get($this->table_name);
            
            return $query->result();
        }

        function getByIDanakDetail($id_anak, $tanggal) {
            
            $this->db->select('
                pembayaran_tagihan.id,
                pembayaran_tagihan.tanggal_tagihan, 
                pembayaran_tagihan.status,
                pembayaran_tagihan.bukti,
                m_tagihan.name,
                m_tagihan.harga,
                m_tagihan.satuan,
                m_uraian.name as uraian
            ');

            $awal = date('Y-m-01', strtotime('01-'.$tanggal));
            
            $akhir = date('Y-m-31', strtotime('31-'.$tanggal));

            $this->db->where(array('id_anak' => $id_anak, 'pembayaran_tagihan.is_active' => '1'));

            $this->db->where('tanggal_tagihan >=', $awal);
            
            $this->db->where('tanggal_tagihan <=', $akhir);

            $this->db->join('m_tagihan', 'pembayaran_tagihan.id_tagihan = m_tagihan.id', 'left'); 

            $this->db->join('m_uraian', 'm_tagihan.id_uraian = m_uraian.id', 'left'); 

            $this->db->order_by('tanggal_tagihan','desc');

            $query = $this->db->get($this->table_name);
            
            return $query->result();
        }

	}

?>