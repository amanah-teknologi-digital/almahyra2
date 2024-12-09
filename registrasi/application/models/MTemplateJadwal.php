<?php  

	class MTemplateJadwal extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'template_jadwal' ;
	    }

	    ## get all data in table
	    function getAll() {
            $sql = "SELECT a.*, b.name as nama_user, c.name as nama_role FROM template_jadwal a 
                JOIN data_user b ON b.id = a.updater 
                JOIN m_role c ON c.id = b.id_role            
                ORDER BY a.id_templatejadwal DESC";

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

        function getDataJadwalTempateById($id_templatejadwal) {
            $sql = "SELECT a.*, b.name as nama_user, c.name as nama_role FROM jadwal_kegiatan a 
                JOIN data_user b ON b.id = a.updater 
                JOIN m_role c ON c.id = b.id_role       
                WHERE a.id_templatejadwal = $id_templatejadwal
                ORDER BY a.jam_mulai ASC";

            $query = $this->db->query($sql);

            return $query->result();
		}

		## get data by id in table
	    function getByID($id) {
	        $this->db->where(array('id_templatejadwal' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

	    ## insert data into table
	    function insertTemplate() {
            $user = $this->session->userdata['auth'];
            $nama_template = $_POST['nama_template'];

            $this->db->trans_start();

            $a_input['nama'] = $nama_template;
            $a_input['created_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;

            $this->db->insert('template_jadwal', $a_input);
            $id_templatejadwal = $this->db->insert_id();

            $this->db->trans_complete();

            return ['err' => $this->db->trans_status(), 'id_templatejadwal' => $id_templatejadwal];
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

            $this->db->where('id_templatejadwal', $id);
            $this->db->delete('jadwal_kegiatan');

            $this->db->where('id_templatejadwal', $id);
            $this->db->delete('template_jadwal');


            $this->db->trans_complete();

            return $this->db->trans_status();
		}

		## get data by id in table
	    function getByKode($id) {
	        $this->db->where(array('kode' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        function insertKegiatan() {
            $user = $this->session->userdata['auth'];

            $id_templatejadwal = $_POST['id_templatejadwal'];
            $jam_mulai = $_POST['jam_mulai'];
            $jam_selesai = $_POST['jam_selesai'];
            $nama_kegiatan = $_POST['nama_kegiatan'];
            $keterangan = $_POST['keterangan'];
            $standarisasi = $_POST['standarisasi'];
            $standarisasi = json_encode($standarisasi, JSON_FORCE_OBJECT);

            $this->db->trans_start();

            $a_input['id_templatejadwal'] = $id_templatejadwal;
            $a_input['jam_mulai'] = $jam_mulai;
            $a_input['jam_selesai'] = $jam_selesai;
            $a_input['uraian'] = $nama_kegiatan;
            $a_input['keterangan'] = $keterangan;
            $a_input['created_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;
            $a_input['standar_pilihan'] = $standarisasi;

            $this->db->insert('jadwal_kegiatan', $a_input);
            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function getJadwalKegiatanHarianById($id_kegiatan){
            $sql = "SELECT * FROM jadwal_kegiatan a WHERE a.id_kegiatan = $id_kegiatan";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function updateKegiatan() {
            $user = $this->session->userdata['auth'];

            $id_kegiatan = $_POST['id_kegiatan'];
            $jam_mulai = $_POST['jam_mulai'];
            $jam_selesai = $_POST['jam_selesai'];
            $nama_kegiatan = $_POST['nama_kegiatan'];
            $keterangan = $_POST['keterangan'];
            $standarisasi = $_POST['standarisasi_update'];
            $standarisasi = json_encode($standarisasi, JSON_FORCE_OBJECT);

            $a_input['jam_mulai'] = $jam_mulai;
            $a_input['jam_selesai'] = $jam_selesai;
            $a_input['uraian'] = $nama_kegiatan;
            $a_input['keterangan'] = $keterangan;
            $a_input['updated_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;
            $a_input['standar_pilihan'] = $standarisasi;

            $this->db->trans_start();

            $this->db->where('id_kegiatan', $id_kegiatan);
            $this->db->update('jadwal_kegiatan', $a_input);

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function hapusKegiatan($id_kegiatan) {
            $this->db->trans_start();

            $this->db->where('id_kegiatan', $id_kegiatan);
            $this->db->delete('jadwal_kegiatan');

            $this->db->trans_complete();

            return $this->db->trans_status();
        }
    }

?>