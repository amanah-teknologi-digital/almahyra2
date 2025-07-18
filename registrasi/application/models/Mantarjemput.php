<?php

class Mantarjemput extends CI_Model
{
    public function __construct() {
        parent::__construct();

        ## declate table name here
        $this->table_name = 'absensi_anak' ;
        $this->login = $this->session->userdata['auth'];
    }

    function getDataAnjem($tanggal){
        $sql = "SELECT a.*, g.nama as nama_anak, g.tanggal_lahir, g.jenis_kelamin, d.nama as nama_kelas, e.nama as nama_jenisanjem, f.name as nama_educator
                FROM antar_jemput a 
                JOIN registrasi_data_anak g ON g.id = a.id_anak
                JOIN v_kategori_usia b ON b.id = g.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN jenis_antarjemput e ON e.id_jenis_antarjemput = a.id_jenis_antarjemput
                JOIN data_user f ON f.id = a.educator
                WHERE a.tanggal = '$tanggal' ORDER BY a.id_antarjemput DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function getListJenisAnjem(){
        $sql = "SELECT * FROM jenis_antarjemput";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function getListAnak(){
        $sql = "SELECT * FROM registrasi_data_anak WHERE is_active = 1 ORDER BY nama";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function getListEducator($id_role){
        $user = $this->session->userdata['auth'];

        if ($id_role == 3){
            $where = ' id = '.$user->id;
        }elseif ($id_role == 1){
            $where = ' 1 = 1';
        }else{
            $where = ' 1 = 0';
        }

        $sql = "SELECT * FROM data_user WHERE $where AND is_active = 1 AND id_role = 3 ORDER BY name";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function simpanCatatanAnjem(){
        $user = $this->session->userdata['auth'];
        date_default_timezone_set('Asia/Jakarta');

        $id_jenisanjem = $this->input->post('jenis_anjem');
        $id_anak = $this->input->post('anak');
        $keterangan = $this->input->post('keterangan');
        $tanggal= $this->input->post('tanggal');
        $lokasi_antar= $this->input->post('lokasi_antar');
        $lokasi_tujuan= $this->input->post('lokasi_tujuan');
        $educator= $this->input->post('educator');

        $this->db->trans_start();

        $a_input['id_jenis_antarjemput'] = $id_jenisanjem;
        $a_input['id_anak'] = $id_anak;
        $a_input['tanggal'] = $tanggal;
        $a_input['lokasi_start'] = $lokasi_antar;
        $a_input['lokasi_tujuan'] = $lokasi_tujuan;
        $a_input['keterangan'] = $keterangan;
        $a_input['educator'] = $educator;
        $a_input['created_at'] = date('Y-m-d H:m:s');

        $this->db->insert('antar_jemput', $a_input);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    function uploadfiles() {
        $input = 'file_dukung'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        $total = count($_FILES[$input]['name']); // multiple files
        $path = './uploads/catatan_mengaji/'; // your upload path

        for ($i = 0; $i < $total; $i++) {
            $temp_filename = date('dmyhis').rand(1, 1000000);
            $temp_filename = $temp_filename.$i;
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = $_FILES[$input]['name'][$i]; // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            $ext = pathinfo($_FILES[$input]['name'][$i], PATHINFO_EXTENSION);

            //Make sure we have a file path
            if ($tmpFilePath != ""){
                //Setup our new file path
                $newFilePath = $path . $temp_filename.'.'.$ext;

                //Upload the file into the new path
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $id_file = $this->insertDokumentasiHarian($temp_filename, $ext, $fileName, $fileSize, $_POST['id_catatan']);
                    if (empty($id_file)) {
                        @unlink($newFilePath);
                        break;
                    }
                } else {
                    break;
                }
            } else {
                break;
            }
        }

        return true;
    }

    function hapusDokumentasiFile($id_file){
        $sql = "SELECT download_url FROM file_mengaji WHERE id_file = $id_file";
        $query = $this->db->query($sql);
        $download_url = $query->row()->download_url;
        $path = './'.$download_url;

        $this->db->trans_start();

        $this->db->where('id_file', $id_file);
        $this->db->delete('file_mengaji');

        $this->db->trans_complete();

        if($this->db->trans_status()){
            @unlink($path);
        }

        return $this->db->trans_status();
    }

    function insertDokumentasiHarian($temp_filename, $ext, $fileName, $fileSize, $id_catatan){
        $user = $this->session->userdata['auth'];

        $a_input['id_catatan'] = $id_catatan;
        $a_input['file_name'] = $fileName;
        $a_input['size'] = $fileSize;
        $a_input['download_url'] = 'uploads/catatan_mengaji/' . $temp_filename.'.'.$ext;
        $a_input['temp_file_name'] = $temp_filename;
        $a_input['ext'] = $ext;
        $a_input['created_at'] = date('Y-m-d H:m:s');
        $a_input['updater'] = $user->id;

        $this->db->insert('file_mengaji', $a_input);

        return $this->db->insert_id();
    }

    function getDokumentasiFile($id_mengaji){
        $sql = "SELECT * FROM file_mengaji WHERE id_catatan = $id_mengaji";
        $query = $this->db->query($sql);

        return $query->result();
    }

    function updatestatus($id) {
        $a_input['is_valid'] = $_POST['status'];
        $a_input['updated_at'] = date('Y-m-d H:m:s');

        $this->db->where('id_antarjemput', $id);

        $this->db->update('antar_jemput', $a_input);

        return $this->db->error(1);
    }
}

?>