<?php  

	class MaktivitasHarianAnak extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'ref_tahun' ;
	    }

	    ## get all data in table
	    function getAll() {
            $sql = "SELECT a.*, b.name as nama_user, c.name as nama_role, d.tahun as is_pakai FROM ref_tahun a 
                JOIN data_user b ON b.id = a.updater 
                JOIN m_role c ON c.id = b.id_role 
                LEFT JOIN (SELECT tahun FROM tema_bulanan GROUP BY tahun) d ON d.tahun = a.tahun                           
                ORDER BY a.tahun DESC";

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
	        $this->db->where(array('tahun' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

        function getListTahun(){
            $sql = "SELECT * FROM ref_tahun ORDER BY tahun DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListTanggalByTahun($tahun){
            $sql = "SELECT b.nama as nama_subtema, e.nama as nama_bulan, a.nama as nama_tema, c.id_rincianjadwal_mingguan, c.tanggal
                FROM tema_bulanan a 
                JOIN jadwal_mingguan b ON b.id_temabulanan = a.id_temabulanan
                JOIN rincian_jadwal_mingguan c ON c.id_jadwalmingguan = b.id_jadwalmingguan
                JOIN jadwal_harian d ON d.id_rincianjadwal_mingguan = c.id_rincianjadwal_mingguan
                JOIN ref_bulan e ON e.bulan = a.bulan  
                WHERE a.tahun = $tahun
                GROUP BY b.nama, e.nama, a.nama, c.id_rincianjadwal_mingguan, c.tanggal
                ORDER BY c.tanggal DESC ";

                $query = $this->db->query($sql);

                return $query->result();
        }

        function getDataKonklusi($id_aktivitas){
            $sql = "SELECT a.id_konklusi as id_konklusi_input, a.nama as nama_konklusi, a.jenis, a.nilai, a.kolom, a.flag, b.id_aktivitas, b.id_konklusi, b.uraian, b.keterangan
                FROM konklusi a 
                LEFT JOIN konklusi_aktivitas b ON b.id_konklusi = a.id_konklusi AND b.id_aktivitas = $id_aktivitas";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getAktivitasHarian($id_rincianjadwal_mingguan){
            $sql = "SELECT * FROM jadwal_harian a 
            JOIN 
            WHERE a.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getKelasByIdRincian($id_rincianjadwal_mingguan){
            $sql = "SELECT a.id_jadwalharian, b.nama as nama_kelas FROM jadwal_harian a 
            JOIN ref_kelas b ON b.id_kelas = a.id_kelas
            WHERE a.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getAktivitasHarianByIdJadwal($id_jadwalharian){
            $sql = "SELECT a.*, b.id_aktivitas, b.progres_aktivitas FROM registrasi_data_anak a 
                JOIN(
                SELECT c.id_aktivitas, c.id_jadwalharian, c.id_anak, COALESCE(d.progres_aktivitas,0) as progres_aktivitas
                FROM jadwal_harian a
                JOIN ref_kelas b ON b.id_kelas = a.id_kelas
                JOIN aktivitas c ON c.id_jadwalharian = a.id_jadwalharian
                LEFT JOIN (SELECT COUNT(id_rincianaktivitas) as progres_aktivitas, id_aktivitas FROM rincian_aktivitas GROUP BY id_aktivitas) as d ON d.id_aktivitas = c.id_aktivitas
                WHERE a.id_jadwalharian = $id_jadwalharian
                UNION
                SELECT null as id_aktivitas, null as id_jadwalharian, d.id as id_anak, 0 as progres_aktivitas
                FROM jadwal_harian a 
                JOIN map_kelasusia b ON b.id_kelas = a.id_kelas
                JOIN v_kategori_usia c ON c.id_usia = b.id_usia
                JOIN registrasi_data_anak d ON d.id = c.id 
                WHERE a.id_jadwalharian = $id_jadwalharian AND c.is_active = 1 AND d.id NOT IN (SELECT id_anak FROM aktivitas WHERE id_jadwalharian = $id_jadwalharian)
                ) as b ON b.id_anak = a.id ORDER BY a.nama ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function checkAktivitas($id_jadwalharian, $id_anak){
            $sql = "SELECT id_aktivitas FROM aktivitas WHERE id_jadwalharian = $id_jadwalharian AND id_anak = $id_anak";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                return $query->row()->id_aktivitas;
            }else{
                $a_input['id_jadwalharian'] = $id_jadwalharian;
                $a_input['id_anak'] = $id_anak;
                $a_input['created_at'] = date('Y-m-d H:m:s');

                $this->db->insert('aktivitas', $a_input);

                return $this->db->insert_id();
            }
        }

        public function getKegiatanByAktivitas($id_aktivitas){
            $sql = "SELECT c.id_rincianaktivitas, b.id_rincianjadwal_harian, b.jam_mulai, b.jam_selesai, b.uraian, c.status, c.keterangan, c.created_at, c.updated_at
                FROM aktivitas a 
                JOIN rincian_jadwal_harian b ON b.id_jadwalharian = a.id_jadwalharian
                LEFT JOIN rincian_aktivitas c ON c.id_rincianjadwal_harian = b.id_rincianjadwal_harian AND c.id_aktivitas = a.id_aktivitas
                LEFT JOIN data_user d ON d.id = c.updater
                WHERE a.id_aktivitas = $id_aktivitas 
                ORDER BY b.jam_mulai ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        public function getDataStimulusByAktivitas($id_aktivitas){
            $sql = "SELECT d.*
                FROM aktivitas a 
                JOIN jadwal_harian b ON b.id_jadwalharian = a.id_jadwalharian
                JOIN jadwal_stimulus c ON c.id_rincianjadwal_mingguan = b.id_rincianjadwal_mingguan AND c.id_kelas = b.id_kelas
                JOIN rincian_jadwal_stimulus d ON d.id_jadwalstimulus = c.id_jadwalstimulus
                WHERE a.id_aktivitas = $id_aktivitas";

            $query = $this->db->query($sql);

            return $query->row();
        }

        public function getDataAnakByAktivitas($id_aktivitas){
            $sql = "SELECT b.*, d.nama as nama_kelas, a.created_at as tanggal_aktivitas
                FROM aktivitas a 
                JOIN registrasi_data_anak b ON b.id = a.id_anak
                JOIN jadwal_harian c ON c.id_jadwalharian = a.id_jadwalharian
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                WHERE a.id_aktivitas = $id_aktivitas";

            $query = $this->db->query($sql);

            return $query->row();
        }

        public function getDataSubtemaByAktivitas($id_aktivitas){
            $sql = "SELECT c.id_rincianjadwal_mingguan, c.tanggal, d.nama as nama_subtema, e.name as nama_educator, a.created_at, a.updated_at
                FROM aktivitas a 
                JOIN jadwal_harian b ON b.id_jadwalharian = a.id_jadwalharian
                JOIN rincian_jadwal_mingguan c ON c.id_rincianjadwal_mingguan = b.id_rincianjadwal_mingguan
                JOIN jadwal_mingguan d ON d.id_jadwalmingguan = c.id_jadwalmingguan
                JOIN data_user e ON e.id = a.educator
                WHERE a.id_aktivitas = $id_aktivitas";

            $query = $this->db->query($sql);

            return $query->row();
        }

        public function getIdAktivitas($id_rincianjadwal_mingguan, $id_anak){
            $sql = "SELECT a.id_aktivitas, a.id_jadwalharian FROM aktivitas a 
                    JOIN jadwal_harian b ON b.id_jadwalharian = a.id_jadwalharian
                    WHERE b.id_rincianjadwal_mingguan = $id_rincianjadwal_mingguan AND a.id_anak = $id_anak";

            $query = $this->db->query($sql);

            return $query->row();
        }

        public function getDataCapaianIndikator($id_aktivitas){
            $sql = "SELECT b.*, c.name as nama_indikator, d.nama as nama_usia, e.name as nama_aspek
                FROM aktivitas a 
                JOIN capaian_indikator b ON b.id_aktivitas = a.id_aktivitas
                JOIN m_kembang_anak c ON c.id = b.id_indikator
                JOIN ref_usia d ON d.id_usia = c.id_usia
                JOIN m_aspek e ON e.id = c.id_aspek
                WHERE a.id_aktivitas = $id_aktivitas
                ORDER BY d.days_min ASC, e.id ASC, c.id ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getJumlahKegiatan($id_jadwalharian){
            $sql = "SELECT COUNT(id_rincianjadwal_harian) as jumlah_kegiatan FROM rincian_jadwal_harian WHERE id_jadwalharian = $id_jadwalharian";

            $query = $this->db->query($sql);

            return $query->row()->jumlah_kegiatan;
        }

        function simpanAktivitas($id_aktivitas){
            $user = $this->session->userdata['auth'];

            $list_kegiatan = $this->getKegiatanByAktivitas($id_aktivitas);
            $list_kolom_konklusi = $this->getDataKonklusi($id_aktivitas);

            $this->db->trans_start();

            foreach ($list_kegiatan as $kegiatan){
                $id_rincianjadwal_harian = $kegiatan->id_rincianjadwal_harian;
                $status = $_POST['status'.$id_rincianjadwal_harian];
                $keterangan = $_POST['keterangan'.$id_rincianjadwal_harian];

                $sql = "SELECT id_rincianaktivitas FROM rincian_aktivitas WHERE id_rincianjadwal_harian = $id_rincianjadwal_harian AND id_aktivitas = $id_aktivitas";
                $query = $this->db->query($sql);

                if (empty($query->row()->id_rincianaktivitas)) {
                    $input_data['id_aktivitas'] = $id_aktivitas;
                    $input_data['id_rincianjadwal_harian'] = $id_rincianjadwal_harian;
                    $input_data['status'] = $status;
                    $input_data['keterangan'] = $keterangan;
                    $input_data['created_at'] = date('Y-m-d H:m:s');
                    $input_data['updater'] = $user->id;

                    $this->db->insert('rincian_aktivitas', $input_data);
                }else{
                    $id_rincianaktivitas = $query->row()->id_rincianaktivitas;

                    $input_data['status'] = $status;
                    $input_data['keterangan'] = $keterangan;
                    $input_data['updated_at'] = date('Y-m-d H:m:s');
                    $input_data['updater'] = $user->id;

                    $this->db->where('id_rincianaktivitas', $id_rincianaktivitas);
                    $this->db->update('rincian_aktivitas', $input_data);
                }
            }

            //input konklusi
            foreach ($list_kolom_konklusi as $kolom_konklusi){
                $id_konklusi = $kolom_konklusi->id_konklusi;
                $kolom = $kolom_konklusi->kolom;
                $input_data_konklusi = [];

                if (empty($id_konklusi)) {
                    $input_data_konklusi['id_aktivitas'] = $id_aktivitas;
                    $input_data_konklusi['id_konklusi'] = $kolom_konklusi->id_konklusi_input;
                    if (!empty($kolom_konklusi->flag)){
                        $input_data_konklusi['uraian'] = $_POST[$kolom];
                    }else{
                        if (isset($_POST[$kolom])) {
                            $input_data_konklusi['uraian'] = $_POST[$kolom];
                        }
                    }

                    if ($kolom_konklusi->jenis == 'select' && isset($_POST['keterangan_konklusi'.$kolom_konklusi->id_konklusi_input])){
                        $input_data_konklusi['keterangan'] = $_POST['keterangan_konklusi'.$kolom_konklusi->id_konklusi_input];
                    }

                    $input_data_konklusi['created_at'] = date('Y-m-d H:m:s');
                    $input_data_konklusi['updater'] = $user->id;
                    $this->db->insert('konklusi_aktivitas', $input_data_konklusi);
                }else{
                    if (!empty($kolom_konklusi->flag)){
                        $input_data_konklusi['uraian'] = $_POST[$kolom];
                    }else{
                        if (isset($_POST[$kolom])) {
                            $input_data_konklusi['uraian'] = $_POST[$kolom];
                        }
                    }

                    if ($kolom_konklusi->jenis == 'select' && isset($_POST['keterangan_konklusi'.$kolom_konklusi->id_konklusi_input])){
                        $input_data_konklusi['keterangan'] = $_POST['keterangan_konklusi'.$kolom_konklusi->id_konklusi_input];
                    }

                    $input_data_konklusi['updated_at'] = date('Y-m-d H:m:s');
                    $input_data_konklusi['updater'] = $user->id;
                    $this->db->where('id_konklusi', $id_konklusi)->where('id_aktivitas', $id_aktivitas);
                    $this->db->update('konklusi_aktivitas', $input_data_konklusi);
                }
            }

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function tambahCapaian($id_aktivitas){
            $user = $this->session->userdata['auth'];

            $list_indikator = $_POST['indikators'];

            $this->db->trans_start();

            foreach ($list_indikator as $indikator){
                $input_data['id_aktivitas'] = $id_aktivitas;
                $input_data['id_indikator'] = $indikator;
                $input_data['created_at'] = date('Y-m-d H:m:s');
                $input_data['updater'] = $user->id;

                $this->db->insert('capaian_indikator', $input_data);

            }

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function hapusCapaianIndikator($id_capaianindikator){
            $sql = "SELECT download_url FROM file_capaianindikator WHERE id_capaianindikator = $id_capaianindikator";
            $query = $this->db->query($sql);
            $list_file = $query->result();

            $this->db->trans_start();

            $this->db->where('id_capaianindikator', $id_capaianindikator);
            $this->db->delete('file_capaianindikator');

            $this->db->where('id_capaianindikator', $id_capaianindikator);
            $this->db->delete('capaian_indikator');

            $this->db->trans_complete();

            if($this->db->trans_status()){
                foreach ($list_file as $file){
                    $path = './'.$file->download_url;
                    @unlink($path);
                }
            }

            return $this->db->trans_status();
        }

        function hapusCapaianIndikatorFile($id_file){
            $sql = "SELECT download_url FROM file_capaianindikator WHERE id_file = $id_file";
            $query = $this->db->query($sql);
            $download_url = $query->row()->download_url;
            $path = './'.$download_url;

            $this->db->trans_start();

            $this->db->where('id_file', $id_file);
            $this->db->delete('file_capaianindikator');

            $this->db->trans_complete();

            if($this->db->trans_status()){
                @unlink($path);
            }

            return $this->db->trans_status();
        }

        function insertCapaianIndikatorFile($temp_filename, $ext, $fileName, $fileSize, $id_capaianindikator){
            $user = $this->session->userdata['auth'];

            $a_input['id_capaianindikator'] = $id_capaianindikator;
            $a_input['file_name'] = $fileName;
            $a_input['size'] = $fileSize;
            $a_input['download_url'] = 'uploads/aktivitas_harian/' . $temp_filename.'.'.$ext;
            $a_input['temp_file_name'] = $temp_filename;
            $a_input['ext'] = $ext;
            $a_input['created_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;

            $this->db->insert('file_capaianindikator', $a_input);

            return $this->db->insert_id();
        }

	    ## insert data into table
	    function insert() {
            $user = $this->session->userdata['auth'];
            $tahun_sekarang = date('Y');

	        $a_input['tahun'] = $_POST['tahun'];
	        $a_input['uraian'] = $_POST['name'];
	        $a_input['created_at'] = date('Y-m-d H:m:s');
            if ($tahun_sekarang == $_POST['tahun']){
                $a_input['is_aktif'] = 1;
            }else{
                $a_input['is_aktif'] = 0;
            }

	        $a_input['updater'] = $user->id;

	        $this->db->insert($this->table_name, $a_input);

	        return $this->db->error();	        
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

        function getDataIndikator($id_aktivitas){
            $sql = "SELECT a.id_anak FROM aktivitas a WHERE a.id_aktivitas = $id_aktivitas";
            $query = $this->db->query($sql);
            $id_anak = $query->row()->id_anak;

            $sql = "SELECT d.id_usia FROM aktivitas a 
                           JOIN registrasi_data_anak b ON b.id = a.id_anak
                           JOIN v_kategori_usia c ON c.id = b.id
                           JOIN ref_usia d ON d.days_min <= c.usia_hari
                           WHERE a.id_aktivitas = $id_aktivitas";
            $query = $this->db->query($sql);
            $list_id_usia = array_column($query->result_array(), 'id_usia');

            $sql = "SELECT a.*, b.name as nama_aspek, c.nama as nama_usia FROM m_kembang_anak a 
                           JOIN m_aspek b ON b.id = a.id_aspek AND b.is_active = 1
                           JOIN ref_usia c ON c.id_usia = a.id_usia
                           WHERE a.is_active = 1 AND a.id_usia IN (".implode(',', $list_id_usia).") 
                           AND a.id NOT IN (SELECT id_indikator FROM capaian_indikator a 
                           JOIN aktivitas b ON b.id_aktivitas = a.id_aktivitas 
                           WHERE b.id_anak = $id_anak) 
                           ORDER BY c.days_min ASC, b.id ASC, a.id ASC";
            $query = $this->db->query($sql);
            $list_idindikator = $query->result();

            return $list_idindikator;
        }

        function getCapaianIndikatorFile($id_capaianindikator){
            $sql = "SELECT * FROM file_capaianindikator WHERE id_capaianindikator = $id_capaianindikator";
            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListAnak($role, $id_anak = null){
            $user = $this->session->userdata['auth'];

            if (!empty($id_anak)){
                $where = "WHERE a.id = $id_anak";
            }else{
                $where = "WHERE 1=1 ";
            }

            if ($role == 1 OR $role == 2){ // admin
                $where_anak = "";
            }elseif ($role == 3){ // educator
                $where_anak = " AND a.id IN (SELECT c.id FROM m_kelas a
                    JOIN v_kategori_usia b ON b.id_usia = a.id_usia
                    JOIN registrasi_data_anak c ON c.id = b.id
                    WHERE a.id_pengasuh = $user->id)";
            }elseif ($role == 4){ // orang tua
                $where_anak = " AND a.id_orangtua = $user->id";
            }

            $sql = "SELECT
                           a.id,
                           a.nama                            as nama_anak,
                           a.tanggal_lahir,
                           a.is_active,
                           a.jenis_kelamin,
                           b.usia_hari,
                           f.nama                            as nama_kelas
                    FROM registrasi_data_anak a
                             JOIN v_kategori_usia b ON b.id = a.id
                             JOIN map_kelasusia g ON g.id_usia = b.id_usia
                             JOIN ref_kelas f ON f.id_kelas = g.id_kelas
                    $where $where_anak
                    ORDER BY a.is_active DESC, f.id_kelas DESC, a.nama ASC";
            $query = $this->db->query($sql);

            if (!empty($id_anak)) {
                return $query->row();
            }else {
                return $query->result();
            }
        }

        function getDokumentasiHarian($id_aktivitas){
            $sql = "SELECT b.id_file, b.file_name, b.download_url, b.temp_file_name, b.size, b.ext, b.created_at
                FROM aktivitas a 
                JOIN file_aktivitasharian b ON b.id_jadwalharian = a.id_jadwalharian
                WHERE a.id_aktivitas = $id_aktivitas AND b.ext IN ('jpg','jpeg','png','gif')";

            $query = $this->db->query($sql);

            return $query->result();
        }
	}

?>