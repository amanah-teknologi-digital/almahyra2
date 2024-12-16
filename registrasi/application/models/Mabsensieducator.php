<?php  

    class Mabsensieducator extends CI_Model
    {
        public function __construct() {
            parent::__construct();

            ## declate table name here
            $this->table_name = 'absensi_anak' ;
            $this->login = $this->session->userdata['auth'];
        }

        function getListEducator($id_role){
            $user = $this->session->userdata['auth'];

            if ($id_role == 1 OR $id_role == 2 OR $id_role == 5){ // admin & superadmin & system absen
                $where = "";
            }elseif ($id_role == 3){ // educator
                $where = " AND a.id = $user->id";
            }elseif($id_role == 4){ // orangtua
                $where = " AND 1 = 0";
            }else{
                $where = " AND 1 = 0";
            }

            $sql = "SELECT *
                FROM data_user a 
                WHERE a.id_role = 3 AND a.is_active = 1 $where ORDER BY a.name ASC";
            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataEducator($educator){
            $sql = "SELECT a.id, a.name as nama_educator
                FROM data_user a 
                WHERE a.id = $educator AND a.is_active = 1";
            $query = $this->db->query($sql);

            return $query->row();
        }

        function getAbsensiEducator($educator){
            $tanggal_sekarang = date('Y-m-d');

            $sql = "SELECT a.id_absensi, a.tanggal, a.id_jenisabsen, a.id_jenislembur, a.waktu_checkin,
                a.waktu_checkout, a.kondisi, a.kondisi_checkout, a.keterangan, b.nama as jenis_absen, c.nama as jenis_lembur
                FROM absen_educator a 
                JOIN ref_jenisabsen b ON b.id_jenisabsen = a.id_jenisabsen
                LEFT JOIN ref_jenislembur c ON c.id_jenislembur = a.id_jenislembur
                WHERE a.tanggal = '$tanggal_sekarang' AND a.id_user = $educator 
                ORDER BY a.waktu_checkin DESC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListJenisAbsensi(){
            $sql = "SELECT * FROM ref_jenisabsen ORDER BY id_jenisabsen ASC";
            $query = $this->db->query($sql);

            return $query->result();
        }

        function getListJenisLembur(){
            $sql = "SELECT * FROM ref_jenislembur ORDER BY id_jenislembur ASC";
            $query = $this->db->query($sql);

            return $query->result();
        }

        function checkOnprogressAbsensi($educator){
            $tanggal_sekarang = date('Y-m-d');

            $sql = "SELECT a.id_absensi
                FROM absen_educator a 
                WHERE a.tanggal = '$tanggal_sekarang' AND a.id_user = $educator AND a.waktu_checkout IS NULL";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function absenMasuk(){
            $user = $this->session->userdata['auth'];
            $tanggal_sekarang = date('Y-m-d');

            $checkOnprogresAbsensi = $this->checkOnprogressAbsensi($_POST['educator']);
            if (empty($checkOnprogresAbsensi)) {
                $this->db->trans_start();

                $a_input['id_user'] = $_POST['educator'];
                $a_input['tanggal'] = $tanggal_sekarang;
                $a_input['id_jenisabsen'] = $_POST['jenis_absen'];
                if (isset($_POST['jenis_lembur']) && !empty($_POST['jenis_lembur'])){
                    $a_input['id_jenislembur'] = $_POST['jenis_lembur'];
                }
                $a_input['waktu_checkin'] = date('H:i:s');
                $a_input['kondisi'] = $_POST['kondisi'];
                if (isset($_POST['keterangan']) && !empty($_POST['keterangan'])){
                    $a_input['keterangan'] = $_POST['keterangan'];
                }
                $a_input['created_at'] = date('Y-m-d H:m:s');

                $this->db->insert('absen_educator', $a_input);

                $this->db->trans_complete();

                return $this->db->trans_status();
            }else{
                return false;
            }
        }

        function getDataAbsenByIdAbsensi($id_absensi){
            $sql = "SELECT *
                FROM absen_educator a
                WHERE a.id_absensi = $id_absensi";
            $query = $this->db->query($sql);

            return $query->row();
        }

        function absenPulang(){
            $user = $this->session->userdata['auth'];

            $id_absensi = $_POST['id_absensi'];
            $this->db->trans_start();

            $a_input['waktu_checkout'] = date('H:i:s');
            $a_input['kondisi_checkout'] = $_POST['kondisi'];
            $a_input['updated_at'] = date('Y-m-d H:m:s');

            $this->db->where('id_absensi', $id_absensi);
            $this->db->update('absen_educator', $a_input);

            $this->db->trans_complete();

            return $this->db->trans_status();
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
            $this->db->where(array('id_anak' => $id, 'is_active' => '1'));
            
            $this->db->order_by('id','desc');

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

            unset($a_input['tbl_length']);
            $a_input['date_created'] = date('Y-m-d H:m:s');
            $a_input['is_active']    = '1';
            $a_input['lokasi']    = '-';
            $a_input['waktu']    = date('H:i:s');
            $a_input['tanggal']    = date('Y-m-d');
                
            $this->db->insert($this->table_name, $a_input);

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