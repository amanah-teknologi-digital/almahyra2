<?php  

	class MTematikBulan extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'ref_bulan' ;
	    }

	    ## get all data in table
	    function getAll()
        {
            $sql = "SELECT a.*, b.jml_bulan, COALESCE(c.jml_tematikbulanan, 0) AS jml_tematikbulanan FROM ref_tahun a 
                LEFT JOIN (SELECT COUNT(bulan) as jml_bulan FROM ref_bulan) b ON 1 = 1
                LEFT JOIN (SELECT tahun, COUNT(bulan) as jml_tematikbulanan FROM tema_bulanan GROUP BY tahun) c ON c.tahun = a.tahun                           
                ORDER BY a.tahun DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getAllBulanByTahun($tahun) {
            $sql = "SELECT a.bulan, a.nama as nama_bulan, b.id_temabulanan, b.nama as nama_temabulanan, b.deskripsi,
                b.created_at, b.updated_at, c.name as nama_user, d.name as nama_role
                FROM ref_bulan a 
                LEFT JOIN tema_bulanan b ON b.bulan = a.bulan and b.tahun = $tahun                          
                LEFT JOIN data_user c ON c.id = b.updater               
                LEFT JOIN m_role d ON d.id = c.id_role               
                ORDER BY a.bulan ASC";

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
	        $this->db->where(array('id_temabulanan' => $id));
	        
	        $query = $this->db->get("tema_bulanan");
	        
	        return $query->row();
	    }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

	    ## insert data into table
	    function insert() {
            $user = $this->session->userdata['auth'];

            $tahun = $_POST['tahun_penentuan'];
            $bulan = $_POST['bulan_penentuan'];
            $nama_tema = $_POST['nama_tema'];
            $keterangan = $_POST['keterangan'];

	        $a_input['tahun'] = $tahun;
	        $a_input['bulan'] = $bulan;
	        $a_input['nama'] = $nama_tema;
	        $a_input['deskripsi'] = $keterangan;
	        $a_input['created_at'] = date('Y-m-d H:m:s');
	        $a_input['updater'] = $user->id;

	        $this->db->insert('tema_bulanan', $a_input);

	        return $this->db->error();	        
	    }

        function insertSubTema() {
            $user = $this->session->userdata['auth'];

            $nama_subtema = $_POST['nama_subtema'];
            $keterangan = $_POST['keterangan'];
            $tanggal_pelaksanaan = $_POST['tanggal_pelaksanaan'];
            $list_tanggal = explode(',', $tanggal_pelaksanaan);
            $id_temabulanan = $_POST['id_temabulanan'];

            if (count($list_tanggal) > 0){
                $this->db->trans_start();

                $a_input['id_temabulanan'] = $id_temabulanan;
                $a_input['nama'] = $nama_subtema;
                $a_input['keterangan'] = $keterangan;
                $a_input['created_at'] = date('Y-m-d H:m:s');
                $a_input['updater'] = $user->id;

                $this->db->insert('jadwal_mingguan', $a_input);
                $id_jadwalmingguan = $this->db->insert_id();

                foreach ($list_tanggal as $tanggal){
                    $temp_date = date('Y-m-d', strtotime($tanggal));
                    $a_input_rincian['id_jadwalmingguan'] = $id_jadwalmingguan;
                    $a_input_rincian['tanggal'] = $temp_date;
                    $a_input_rincian['created_at'] = date('Y-m-d H:m:s');
                    $a_input_rincian['updater'] = $user->id;

                    $this->db->insert('rincian_jadwal_mingguan', $a_input_rincian);
                }

                $this->db->trans_complete();
            }

	        return $this->db->trans_status();
	    }

        function insertKegiatan() {
            $user = $this->session->userdata['auth'];

            $id_rincianjadwal_mingguan = $_POST['id_rincianjadwal_mingguan'];
            $id_kelas = $_POST['id_kelas'];
            $jam_mulai = $_POST['jam_mulai'];
            $jam_selesai = $_POST['jam_selesai'];
            $nama_kegiatan = $_POST['nama_kegiatan'];
            $keterangan = $_POST['keterangan'];

            $sql = "SELECT id_jadwalharian FROM jadwal_harian WHERE id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan AND id_kelas = $id_kelas";
            $query = $this->db->query($sql);
            $id_jadwalharian = $query->row()->id_jadwalharian;

            $this->db->trans_start();

            if (empty($id_jadwalharian)) {
                $input_jadwal['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
                $input_jadwal['id_kelas'] = $id_kelas;
                $this->db->insert('jadwal_harian', $input_jadwal);
                $id_jadwalharian = $this->db->insert_id();
            }

            $a_input['id_jadwalharian'] = $id_jadwalharian;
            $a_input['jam_mulai'] = $jam_mulai;
            $a_input['jam_selesai'] = $jam_selesai;
            $a_input['uraian'] = $nama_kegiatan;
            $a_input['keterangan'] = $keterangan;
            $a_input['created_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;

            $this->db->insert('rincian_jadwal_harian', $a_input);
            $this->db->trans_complete();

	        return $this->db->trans_status();
	    }

        function updateSubTema() {
            $user = $this->session->userdata['auth'];

            $nama_subtema = $_POST['nama_subtema'];
            $keterangan = $_POST['keterangan'];
            $tanggal_pelaksanaan = $_POST['tanggal_pelaksanaan'];
            $list_tanggal = explode(',', $tanggal_pelaksanaan);
            $id_jadwalmingguan = $_POST['id_jadwalmingguan'];
            $data_tanggal = $this->getTanggalJadwalMingguan($id_jadwalmingguan);

            $list_jadwal_editable = [];
            $list_jadwal_noneditable = [];
            foreach ($data_tanggal as $tanggal){
                if (empty($tanggal->is_inputjadwalharian)){
                    $list_jadwal_editable[] = $tanggal->tanggal;
                }else{
                    $list_jadwal_noneditable[] = $tanggal->tanggal;
                }
            }

            if (count($list_tanggal) > 0){
                $this->db->trans_start();

                $a_input['nama'] = $nama_subtema;
                $a_input['keterangan'] = $keterangan;
                $a_input['updated_at'] = date('Y-m-d H:m:s');
                $a_input['updater'] = $user->id;

                $this->db->where('id_jadwalmingguan', $id_jadwalmingguan);
                $this->db->update('jadwal_mingguan', $a_input);

                //hapus sub tema yang belum diisi jadwal harian
                if (count($list_jadwal_editable) > 0) {
                    $this->db->where_in('tanggal', $list_jadwal_editable);
                    $this->db->delete('rincian_jadwal_mingguan');
                }

                foreach ($list_tanggal as $tanggal){
                    if (!in_array($tanggal, $list_jadwal_noneditable)) {
                        $temp_date = date('Y-m-d', strtotime($tanggal));
                        $a_input_rincian['id_jadwalmingguan'] = $id_jadwalmingguan;
                        $a_input_rincian['tanggal'] = $temp_date;
                        $a_input_rincian['created_at'] = date('Y-m-d H:m:s');
                        $a_input_rincian['updater'] = $user->id;

                        $this->db->insert('rincian_jadwal_mingguan', $a_input_rincian);
                    }
                }

                $this->db->trans_complete();
            }

	        return $this->db->trans_status();
	    }
        function updateKegiatan() {
            $user = $this->session->userdata['auth'];

            $id_rincianjadwal_harian = $_POST['id_rincianjadwal_harian'];
            $jam_mulai = $_POST['jam_mulai'];
            $jam_selesai = $_POST['jam_selesai'];
            $nama_kegiatan = $_POST['nama_kegiatan'];
            $keterangan = $_POST['keterangan'];

            $a_input['jam_mulai'] = $jam_mulai;
            $a_input['jam_selesai'] = $jam_selesai;
            $a_input['uraian'] = $nama_kegiatan;
            $a_input['keterangan'] = $keterangan;
            $a_input['updated_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;

            $this->db->trans_start();

            $this->db->where('id_rincianjadwal_harian', $id_rincianjadwal_harian);
            $this->db->update('rincian_jadwal_harian', $a_input);

            $this->db->trans_complete();

	        return $this->db->trans_status();
	    }

        function hapusSubTema($id_jadwalmingguan) {
            $this->db->trans_start();

            $this->db->where('id_jadwalmingguan', $id_jadwalmingguan);
            $this->db->delete('rincian_jadwal_mingguan');

            $this->db->where('id_jadwalmingguan', $id_jadwalmingguan);
            $this->db->delete('jadwal_mingguan');

            $this->db->trans_complete();

	        return $this->db->trans_status();
	    }

        function hapusKegiatan($id_rincianjadwal_harian) {
            $this->db->trans_start();

            $this->db->where('id_rincianjadwal_harian', $id_rincianjadwal_harian);
            $this->db->delete('rincian_jadwal_harian');

            $this->db->trans_complete();

	        return $this->db->trans_status();
	    }

	    ## update data in table
	    function update($id) {
            $user = $this->session->userdata['auth'];

	        $a_input['nama'] = $_POST['nama_tema'];
	        $a_input['deskripsi'] = $_POST['keterangan'];
	        $a_input['updated_at'] = date('Y-m-d H:m:s');
	        $a_input['updater'] = $user->id;

	        $this->db->where('id_temabulanan', $id);
	        
	        $this->db->update('tema_bulanan', $a_input);

	        return $this->db->error(1);	        
	    }

	    ## delete data in table
		function delete($id) {
			$this->db->where('tahun', $id)->where('is_aktif', 0);

			$this->db->delete($this->table_name);

			return $this->db->affected_rows();
		}

		## get data by id in table
	    function getByKode($id) {
	        $this->db->where(array('kode' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        function getJadwalMingguanByTahun($tahun) {
            $sql = "SELECT a.bulan, b.id_temabulanan, c.id_jadwalmingguan, c.nama as nama_subtema, d.tanggal, c.keterangan,
                e.name as nama_user, f.name as nama_role,d.id_rincianjadwal_mingguan, d.created_at, d.updated_at, g.id_rincianjadwal_mingguan as is_inputjadwalharian
                FROM ref_bulan a 
                JOIN tema_bulanan b ON b.bulan = a.bulan and b.tahun = $tahun
                JOIN jadwal_mingguan c ON c.id_temabulanan = b.id_temabulanan
                JOIN rincian_jadwal_mingguan d ON d.id_jadwalmingguan = c.id_jadwalmingguan                          
                JOIN data_user e ON e.id = d.updater               
                JOIN m_role f ON f.id = e.id_role       
                LEFT JOIN (SELECT id_rincianjadwal_mingguan FROM jadwal_harian GROUP BY id_rincianjadwal_mingguan) g ON g.id_rincianjadwal_mingguan = d.id_rincianjadwal_mingguan
                ORDER BY c.id_jadwalmingguan, d.tanggal ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getTanggalSelected($tahun) {
            $sql = "SELECT a.tanggal
                FROM rincian_jadwal_mingguan a 
                JOIN jadwal_mingguan b ON b.id_jadwalmingguan = a.id_jadwalmingguan
                JOIN tema_bulanan c ON c.id_temabulanan = b.id_temabulanan
                WHERE c.tahun = $tahun              
                ORDER BY a.tanggal ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getTanggalSelectedExcludeIdMingguan($tahun, $id_jadwalmingguan) {
            $sql = "SELECT a.tanggal
                FROM rincian_jadwal_mingguan a 
                JOIN jadwal_mingguan b ON b.id_jadwalmingguan = a.id_jadwalmingguan
                JOIN tema_bulanan c ON c.id_temabulanan = b.id_temabulanan
                WHERE c.tahun = $tahun AND b.id_jadwalmingguan != $id_jadwalmingguan            
                ORDER BY a.tanggal ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getJadwalMingguanById($id_jadwalmingguan) {
            $sql = "SELECT * FROM jadwal_mingguan WHERE id_jadwalmingguan = $id_jadwalmingguan";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function getRincianJadwalMingguanById($id_rincianjadwal_mingguan) {
            $sql = "SELECT * FROM rincian_jadwal_mingguan WHERE id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function getTanggalJadwalMingguan($id_jadwalmingguan) {
            $sql = "SELECT a.tanggal, b.id_rincianjadwal_mingguan as is_inputjadwalharian FROM rincian_jadwal_mingguan a 
                 LEFT JOIN (SELECT id_rincianjadwal_mingguan FROM jadwal_harian GROUP BY id_rincianjadwal_mingguan) b ON b.id_rincianjadwal_mingguan = a.id_rincianjadwal_mingguan
                 WHERE a.id_jadwalmingguan = $id_jadwalmingguan";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getBulanBySubTema($id_temabulanan) {
            $sql = "SELECT bulan FROM tema_bulanan WHERE id_temabulanan = $id_temabulanan";

            $query = $this->db->query($sql);
            $bulan = $query->row()->bulan;

            return $bulan;
        }

        function getTahunByIdJadwalMingguan($id_jadwalmingguan) {
            $sql = "SELECT b.tahun FROM jadwal_mingguan a 
             JOIN tema_bulanan b ON b.id_temabulanan = a.id_temabulanan
             WHERE a.id_jadwalmingguan = $id_jadwalmingguan";

            $query = $this->db->query($sql);

            return $query->row()->tahun;
        }

        function getBulanByIdJadwalMingguan($id_jadwalmingguan) {
            $sql = "SELECT b.bulan FROM jadwal_mingguan a 
             JOIN tema_bulanan b ON b.id_temabulanan = a.id_temabulanan
             WHERE a.id_jadwalmingguan = $id_jadwalmingguan";

            $query = $this->db->query($sql);

            return $query->row()->bulan;
        }

        function getBulanByIdRincianJadwal($id_rincianjadwal_mingguan) {
            $sql = "SELECT c.bulan FROM rincian_jadwal_mingguan a 
             JOIN jadwal_mingguan b ON b.id_jadwalmingguan = a.id_jadwalmingguan
             JOIN tema_bulanan c ON c.id_temabulanan = b.id_temabulanan
             WHERE a.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan";

            $query = $this->db->query($sql);

            return $query->row()->bulan;
        }

        function getKelas(){
            $sql = "SELECT * FROM ref_kelas";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getJadwalHarianById($id_rincianjadwal_mingguan){
            $sql = "SELECT a.id_jadwalharian, a.id_kelas, b.*, c.name as nama_user, d.name as nama_role
            FROM jadwal_harian a 
            JOIN rincian_jadwal_harian b ON b.id_jadwalharian = a.id_jadwalharian
            JOIN data_user c ON c.id = b.updater               
            JOIN m_role d ON d.id = c.id_role
           WHERE a.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan
           ORDER BY a.id_kelas, b.jam_mulai ASC ";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getJadwalKegiatanHarianById($id_rincianjadwal_harian){
            $sql = "SELECT * FROM rincian_jadwal_harian a WHERE a.id_rincianjadwal_harian = $id_rincianjadwal_harian";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function getJadwalStimulus($id_rincianjadwal_mingguan){
            $sql = "SELECT a.id_jadwalstimulus, a.id_kelas, b.*, c.name as nama_user, d.name as nama_role
            FROM jadwal_stimulus a 
            JOIN rincian_jadwal_stimulus b ON b.id_jadwalstimulus = a.id_jadwalstimulus
            JOIN data_user c ON c.id = b.updater               
            JOIN m_role d ON d.id = c.id_role
           WHERE a.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan";

            $query = $this->db->query($sql);

            return $query->result();
        }

	}

?>