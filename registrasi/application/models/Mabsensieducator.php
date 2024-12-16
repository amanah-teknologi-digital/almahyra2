<?php  

    class Mabsensieducator extends CI_Model
    {
        public function __construct() {
            parent::__construct();

            ## declate table name here
            $this->table_name = 'absensi_anak' ;
            $this->login = $this->session->userdata['auth'];
        }

        function getListAnak($id_role){
            $user = $this->session->userdata['auth'];

            $tanggal_sekarang = date('Y-m-d');

            if ($id_role == 1 OR $id_role == 2 OR $id_role == 5){ // admin & superadmin & system absen
                $where_anak = "";
            }elseif ($id_role == 3){ // educator
                $where_anak = " AND a.educator = $user->id";
            }elseif($id_role == 4){ // orangtua
                $where_anak = " AND a.id_orangtua = $user->id";
            }else{
                $where_anak = " AND 1 = 0";
            }

            $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_absensi, e.tanggal, e.waktu_checkin, e.waktu_checkout, f.name as nama_user, g.name as nama_role, h.name as nama_user2, i.name as nama_role2
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                LEFT JOIN absen_anak e ON e.id_anak = a.id AND e.tanggal = '$tanggal_sekarang'
                LEFT JOIN data_user f ON f.id = e.updater
                LEFT JOIN m_role g ON g.id = f.id_role
                LEFT JOIN data_user h ON h.id = e.updater2
                LEFT JOIN m_role i ON i.id = h.id_role
                WHERE a.is_active = 1 $where_anak ORDER BY e.waktu_checkout ASC, e.id_absensi ASC, b.usia_hari ASC";

            $query = $this->db->query($sql);

            return $query->result();
        }

        function getDataAbsenByIdAnak($id_anak){
            $tanggal_sekarang = date('Y-m-d');

            $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_absensi, e.tanggal, e.waktu_checkin, e.waktu_checkout, e.kondisi, e.kondisi_checkout, e.suhu, e.suhu_checkout,
                f.name as nama_user, g.name as nama_role, h.name as nama_user2, i.name as nama_role2
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                LEFT JOIN absen_anak e ON e.id_anak = a.id AND e.tanggal = '$tanggal_sekarang'
                LEFT JOIN data_user f ON f.id = e.updater
                LEFT JOIN m_role g ON g.id = f.id_role
                LEFT JOIN data_user h ON h.id = e.updater2
                LEFT JOIN m_role i ON i.id = h.id_role
                WHERE a.is_active = 1 AND a.id = $id_anak ORDER BY e.waktu_checkout DESC, e.id_absensi DESC, b.usia_hari ASC";

            $query = $this->db->query($sql);

            return $query->row();
        }

        function absenMasuk(){
            $user = $this->session->userdata['auth'];
            $tanggal_sekarang = date('Y-m-d');


            $this->db->trans_start();

            $a_input['id_anak'] = $_POST['id_anak'];
            $a_input['tanggal'] = $tanggal_sekarang;
            $a_input['waktu_checkin'] = date('H:i:s');
            $a_input['kondisi'] = $_POST['kondisi'];
            $a_input['suhu'] = $_POST['suhu'];
            $a_input['created_at'] = date('Y-m-d H:m:s');
            $a_input['updater'] = $user->id;

            $this->db->insert('absen_anak', $a_input);

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        function absenPulang(){
            $user = $this->session->userdata['auth'];
            $tanggal_sekarang = date('Y-m-d');

            $sql = "SELECT * FROM absen_anak WHERE id_anak = ".$_POST['id_anak']." AND tanggal = '$tanggal_sekarang'";
            $query = $this->db->query($sql);
            $data = $query->row();

            if (!empty($data)){
                $id_absensi = $data->id_absensi;
                $this->db->trans_start();

                $a_input['waktu_checkout'] = date('H:i:s');
                $a_input['kondisi_checkout'] = $_POST['kondisi'];
                $a_input['suhu_checkout'] = $_POST['suhu'];
                $a_input['updater2'] = $user->id;

                $this->db->where('id_absensi', $id_absensi);
                $this->db->update('absen_anak', $a_input);

                $this->db->trans_complete();

                return $this->db->trans_status();
            }else{
                return false;
            }
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