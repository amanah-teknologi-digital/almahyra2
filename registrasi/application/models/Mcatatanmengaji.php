<?php

class Mcatatanmengaji extends CI_Model
{
    public function __construct() {
        parent::__construct();

        ## declate table name here
        $this->table_name = 'absensi_anak' ;
        $this->login = $this->session->userdata['auth'];
    }

    function getHasilMengaji($tanggal_mc, $sesi){
        $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_catatan, e.tanggal, e.keterangan, e.created_at, e.updated_at, e.is_catat, f.name as nama_ustadzah, g.name as nama_role, h.nama as sesi
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                LEFT JOIN mengaji_catatan e ON e.id_anak = a.id AND e.tanggal = '$tanggal_mc' AND e.id_sesi = $sesi
                LEFT JOIN mengaji_sesi h ON h.id_sesi = e.id_sesi
                LEFT JOIN data_user f ON f.id = e.id_ustadzah
                LEFT JOIN m_role g ON g.id = f.id_role
                WHERE a.is_active = 1 ORDER BY a.nama ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function getListSesi(){
        $sql = "SELECT * FROM mengaji_sesi";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function getListJilid(){
        $sql = "SELECT * FROM mengaji_jilid";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function checkAktivitas($tanggal, $id_anak, $sesi){
        $sql = "SELECT id_catatan FROM mengaji_catatan WHERE id_anak = $id_anak AND tanggal = '$tanggal' AND id_sesi = '$sesi'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row()->id_catatan;
        }else{
            $a_input['id_anak'] = $id_anak;
            $a_input['id_sesi'] = $sesi;
            $a_input['tanggal'] = $tanggal;
            $a_input['created_at'] = date('Y-m-d H:m:s');

            $this->db->insert('mengaji_catatan', $a_input);

            return $this->db->insert_id();
        }
    }

    function getDataMengaji($id_mengaji){
        $sql = "SELECT a.id, a.nama as nama_anak, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_catatan, e.tanggal, e.id_jilidmengaji, e.id_sesi, e.halaman, e.keterangan, e.nilai, e.created_at, e.updated_at,
                f.name as nama_ustadzah, g.name as nama_role, j.nama as namasesi
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                JOIN mengaji_catatan e ON e.id_anak = a.id
                JOIN mengaji_sesi j ON j.id_sesi = e.id_sesi
                LEFT JOIN data_user f ON f.id = e.id_ustadzah
                LEFT JOIN m_role g ON g.id = f.id_role
                WHERE e.id_catatan = $id_mengaji";

        $query = $this->db->query($sql);

        return $query->row();
    }

    function getDataSebelumnya($id_mengaji, $tgl_mengaji, $id_anak){
        $sql = "SELECT a.*, b.nama as nama_jilid, f.name as nama_ustadzah, g.nama as nama_sesi FROM mengaji_catatan a 
                JOIN mengaji_jilid b ON b.id_jilidmengaji = a.id_jilidmengaji
                JOIN data_user f ON f.id = a.id_ustadzah
                JOIN mengaji_sesi g ON g.id_sesi = a.id_sesi
                WHERE tanggal <= '$tgl_mengaji' AND id_anak = $id_anak AND id_catatan != $id_mengaji ORDER BY tanggal, id_sesi DESC";

        $query = $this->db->query($sql);

        return $query->row();
    }

    function simpanCatatanMengaji(){
        $user = $this->session->userdata['auth'];
        date_default_timezone_set('Asia/Jakarta');

        $id_catatan = $this->input->post('id_catatan');
        $jilid = $this->input->post('jilid');
        $halaman = $this->input->post('halaman');
        $nilai = $this->input->post('nilai');

        $this->db->trans_start();

        $update_checkup['id_ustadzah'] = $user->id;
        $update_checkup['id_jilidmengaji'] = $jilid;
        $update_checkup['halaman'] = $halaman;
        $update_checkup['nilai'] = $nilai;
        $update_checkup['is_catat'] = 1;
        $update_checkup['updated_at'] = date('Y-m-d H:m:s');
        $update_checkup['keterangan'] = $this->input->post('keterangan');
        $update_checkup['updater'] = $user->id;
        $this->db->where('id_catatan', $id_catatan);
        $this->db->update('mengaji_catatan', $update_checkup);

        if (isset($_FILES['file_dukung'])){
            $this->uploadfiles();
        }

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
}

?>