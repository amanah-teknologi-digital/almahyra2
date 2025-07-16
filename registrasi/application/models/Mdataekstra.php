<?php  

	class Mdataekstra extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'template_jadwal' ;
	    }

        function getListEkstrakulikuler(){
            $sql = "SELECT a.*, b.name as nama_pengampu FROM ekstrakulikuler a 
                LEFT JOIN data_user b ON a.pengampu = b.id";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataEkstra($id_ekstra){
            $sql = "SELECT a.* FROM ekstrakulikuler a 
                WHERE a.id_ekstra = $id_ekstra";

            $query = $this->db->query($sql);

            return $query->row();
        }
        function getDataEkstraForm($id_ekstra){
            $sql = "SELECT b.* FROM ekstrakulikuler a 
                JOIN ekstrakulikuler_form b ON a.id_ekstra = b.id_ekstra
            WHERE a.id_ekstra = $id_ekstra ORDER BY b.id_formekstra";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataSiswa($id_ekstra){
            $sql = "SELECT b.*, e.nama as nama_kelas FROM ekstrakulikuler_siswa a 
                JOIN registrasi_data_anak b ON b.id = a.id_anak 
                JOIN v_kategori_usia c ON c.id = b.id 
                JOIN map_kelasusia d ON d.id_usia = c.id_usia
                JOIN ref_kelas e ON e.id_kelas = d.id_kelas
            WHERE a.id_ekstra = $id_ekstra ORDER BY b.nama";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListSiswa($id_ekstra){
            $sql = "SELECT b.*, e.nama as nama_kelas FROM registrasi_data_anak b 
                JOIN v_kategori_usia c ON c.id = b.id 
                JOIN map_kelasusia d ON d.id_usia = c.id_usia
                JOIN ref_kelas e ON e.id_kelas = d.id_kelas
            WHERE
            b.is_active = 1 AND b.id NOT IN (SELECT id_anak FROM ekstrakulikuler_siswa WHERE id_ekstra = $id_ekstra) AND b.id_usia IS NOT NULL
            ORDER BY b.nama";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListPengampu(){
            $sql = "SELECT a.* FROM data_user a WHERE a.id_role = 9 ORDER BY a.id";

            $query = $this->db->query($sql);

            return $query->result();
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
            $nama_template = $_POST['nama_ekstra'];
            $keterangan = $_POST['keterangan'];

            $this->db->trans_start();

            $a_input['nama'] = $nama_template;
            $a_input['keterangan'] = $keterangan;
            $a_input['created_at'] = date('Y-m-d H:m:s');

            $this->db->insert('ekstrakulikuler', $a_input);
            $id_ekstra = $this->db->insert_id();

            $this->db->trans_complete();

            return ['err' => $this->db->trans_status(), 'id_ekstra' => $id_ekstra];
        }

        function insertSiswa() {
            $siswa = $_POST['siswa'];
            $id_ekstra = $_POST['id_ekstra'];

            $this->db->trans_start();
            foreach ($siswa as $key => $value) {
                $a_input['id_ekstra'] = $id_ekstra;
                $a_input['id_anak'] = $value;

                $this->db->insert('ekstrakulikuler_siswa', $a_input);
            }

            $this->db->trans_complete();

            return ['err' => $this->db->trans_status(), 'id_ekstra' => $id_ekstra];
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

            $this->db->where('id_ekstra', $id);
            $this->db->delete('ekstrakulikuler_siswa');

            $this->db->where('id_ekstra', $id);
            $this->db->delete('ekstrakulikuler_form');

            $this->db->where('id_ekstra', $id);
            $this->db->delete('ekstrakulikuler');


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
            $id_ekstra = $_POST['id_ekstra'];
            $nama_kegiatan = $_POST['nama_kegiatan'];
            $nama_kolom = $_POST['nama_kolom'];
            $nama_kolom = strtolower($nama_kolom); // huruf kecil semua
            $nama_kolom = preg_replace('/[^a-z0-9_ ]/', '', $nama_kolom); // hapus karakter aneh
            $nama_kolom = str_replace(' ', '_', $nama_kolom); // spasi jadi underscore
            if ($nama_kolom == 'nilai'){
                $nama_kolom = null;
            }
            $jenis_kolom = $_POST['jenis_kolom'];
            if (isset($_POST['standarisasi']) && $_POST['jenis_kolom'] == 'select') {
                $standarisasi = $_POST['standarisasi'];
                $standarisasi = json_encode($standarisasi, JSON_FORCE_OBJECT);
            }else{
                $standarisasi = null;
            }

            $this->db->trans_start();

            $a_input['id_ekstra'] = $id_ekstra;
            $a_input['nama'] = $nama_kegiatan;
            $a_input['kolom'] = $nama_kolom;
            $a_input['jenis_kolom'] = $jenis_kolom;
            $a_input['pilihan_standar'] = $standarisasi;

            $this->db->insert('ekstrakulikuler_form', $a_input);
            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function getJadwalKegiatanHarianById($id_kegiatan){
            $sql = "SELECT * FROM ekstrakulikuler_form a WHERE a.id_formekstra = $id_kegiatan";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function updateKegiatan() {
            $id_form = $_POST['id_formekstra'];
            $nama_kegiatan = $_POST['nama_kegiatan'];
            $nama_kolom = $_POST['nama_kolom'];
            $nama_kolom = strtolower($nama_kolom); // huruf kecil semua
            $nama_kolom = preg_replace('/[^a-z0-9_ ]/', '', $nama_kolom); // hapus karakter aneh
            $nama_kolom = str_replace(' ', '_', $nama_kolom); // spasi jadi underscore
            if ($nama_kolom == 'nilai'){
                $nama_kolom = null;
            }
            $jenis_kolom = $_POST['jenis_kolom'];
            if (isset($_POST['standarisasi']) && $_POST['jenis_kolom'] == 'select') {
                $standarisasi = $_POST['standarisasi'];
                $standarisasi = json_encode($standarisasi, JSON_FORCE_OBJECT);
            }else{
                $standarisasi = null;
            }

            $a_input['nama'] = $nama_kegiatan;
            $a_input['kolom'] = $nama_kolom;
            $a_input['jenis_kolom'] = $jenis_kolom;
            $a_input['pilihan_standar'] = $standarisasi;

            $this->db->trans_start();

            $this->db->where('id_formekstra', $id_form);
            $this->db->update('ekstrakulikuler_form', $a_input);

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function hapusKegiatan($id_kegiatan) {
            $this->db->trans_start();

            $this->db->where('id_formekstra', $id_kegiatan);
            $this->db->delete('ekstrakulikuler_form');

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function hapusSiswa($id_anak, $id_ekstra) {
            $this->db->trans_start();

            $this->db->where('id_ekstra', $id_ekstra);
            $this->db->where('id_anak', $id_anak);
            $this->db->delete('ekstrakulikuler_siswa');

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function updatePengampuEkstra($id_ekstra, $id_pengampu){
            if (empty($id_pengampu)){
                $id_pengampu = null;
            }

            $a_input['pengampu'] = $id_pengampu;
            $a_input['updated_at'] = date('Y-m-d H:m:s');

            $this->db->where('id_ekstra', $id_ekstra);

            $this->db->update('ekstrakulikuler', $a_input);

            return $this->db->error(1);
        }
    }

?>