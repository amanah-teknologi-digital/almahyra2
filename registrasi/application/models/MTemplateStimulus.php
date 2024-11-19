<?php  

	class MTemplateStimulus extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'template_stimulus' ;
	    }

	    ## get all data in table
	    function getAll() {
            $sql = "SELECT a.*, b.name as nama_user, c.name as nama_role FROM template_stimulus a 
                JOIN data_user b ON b.id = a.updater 
                JOIN m_role c ON c.id = b.id_role            
                ORDER BY a.id_templatestimulus DESC";

            $query = $this->db->query($sql);

	        return $query->result();
		}

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->select('m_role.id, m_role.name');
	    	
	    	$this->db->where(array('is_active' => '1'));

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get data by id in table
	    function getByID($id) {
	        $this->db->where(array('id_templatestimulus' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

	    ## insert data into table
        function insertStimulasi(){
            $user = $this->session->userdata['auth'];

            $nama_template = $_POST['nama_template'];
            $nama = $_POST['nama_tema'];
            $uraian = $_POST['editorContent'];
            $keterangan = $_POST['keterangan'];

            $this->db->trans_start();

            $a_input['nama_template'] = $nama_template;
            $a_input['nama'] = $nama;
            $a_input['uraian'] = $uraian;
            $a_input['keterangan'] = $keterangan;
            $a_input['created_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;

            $this->db->insert('template_stimulus', $a_input);

            $this->db->trans_complete();

            return $this->db->trans_status();
	    }

        function updateStimulasi($id_templatestimulus){
            $user = $this->session->userdata['auth'];

            $nama_template = $_POST['nama_template'];
            $nama = $_POST['nama_tema'];
            $uraian = $_POST['editorContent'];
            $keterangan = $_POST['keterangan'];

            $this->db->trans_start();

            $a_input['nama_template'] = $nama_template;
            $a_input['nama'] = $nama;
            $a_input['uraian'] = $uraian;
            $a_input['keterangan'] = $keterangan;
            $a_input['updated_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;

            $this->db->where('id_templatestimulus', $id_templatestimulus);
            $this->db->update('template_stimulus', $a_input);

            $this->db->trans_complete();

            return $this->db->trans_status();
	    }

	    ## update data in table
	    function update($id) {
            $user = $this->session->userdata['auth'];

	        $a_input['uraian'] = $_POST['name'];
	        $a_input['updated_at'] = date('Y-m-d H:m:s');
	        $a_input['updater'] = $user->id;

	        $this->db->where('tahun', $id);
	        
	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);	        
	    }

	    ## delete data in table
		function delete($id) {
            $this->db->trans_start();

            $this->db->where('id_templatestimulus', $id);
            $this->db->delete('template_stimulus');

            $this->db->trans_complete();

            return $this->db->trans_status();
		}

		## get data by id in table
	    function getByKode($id) {
	        $this->db->where(array('kode' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

	}

?>