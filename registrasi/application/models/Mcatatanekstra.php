<?php

class Mcatatanekstra extends CI_Model
{
    public function __construct() {
        parent::__construct();

        ## declate table name here
        $this->table_name = 'absensi_anak' ;
        $this->login = $this->session->userdata['auth'];
    }

    function getHasilEkstra($tanggal, $id_ekstra){
        $sql = "SELECT a.id, a.nama as nama_anak, a.nick, a.tempat_lahir, a.tanggal_lahir, a.jenis_kelamin, d.nama as nama_kelas,
                e.id_ekstracatatan, e.tanggal, e.keterangan, e.nilai, e.created_at, e.updated_at, e.is_catat
                FROM registrasi_data_anak a 
                JOIN v_kategori_usia b ON b.id = a.id 
                JOIN map_kelasusia c ON c.id_usia = b.id_usia
                JOIN ref_kelas d ON d.id_kelas = c.id_kelas
                LEFT JOIN ekstrakulikuler_catatan e ON e.id_anak = a.id AND e.tanggal = '$tanggal' AND e.id_ekstra = $id_ekstra
            
                WHERE a.is_active = 1 ORDER BY a.nama ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function getListEkstra(){
        $id_user = $this->session->userdata['auth']->id;
        $sql = "SELECT * FROM ekstrakulikuler WHERE pengampu = $id_user";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function checkAktivitas($tanggal, $id_anak, $id_ekstra){
        $sql = "SELECT id_ekstracatatan FROM ekstrakulikuler_catatan WHERE id_anak = $id_anak AND tanggal = '$tanggal' AND id_ekstra = '$id_ekstra'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row()->id_ekstracatatan;
        } else {
            $sql = "SELECT * FROM ekstrakulikuler_form WHERE id_ekstra = $id_ekstra";
            $query = $this->db->query($sql);
            $dataform = $query->result();

            if (!empty($dataform)) {
                $a_input['id_anak'] = $id_anak;
                $a_input['id_ekstra'] = $id_ekstra;
                $a_input['tanggal'] = $tanggal;
                $a_input['created_at'] = date('Y-m-d H:m:s');

                $this->db->insert('ekstrakulikuler_catatan', $a_input);
                $id_ekstracatatan = $this->db->insert_id();

                $sql = "INSERT INTO ekstrakulikuler_catatandet (id_ekstracatatan, nama, kolom, jenis_kolom, pilihan_standar) SELECT $id_ekstracatatan, nama, kolom, jenis_kolom, pilihan_standar FROM ekstrakulikuler_form WHERE id_ekstra = $id_ekstra ORDER BY id_formekstra";
                $this->db->query($sql);

                return $id_ekstracatatan;
            }else{
                $this->session->set_flashdata('failed', 'Form Ekstrakulikuler belum ditentukan! Mohon Hubungi Admin untuk menentukan');

                redirect('catat-ekstrakulikuler');
            }
        }
    }

    function getDataEkstra($id_ekstracatatan){
        $sql = "SELECT a.*, b.nama as nama_ekstra, c.nama as nama_anak, c.tanggal_lahir, f.nama as nama_kelas  FROM ekstrakulikuler_catatan a 
         JOIN ekstrakulikuler b ON b.id_ekstra = a.id_ekstra
         JOIN registrasi_data_anak c ON c.id = a.id_anak
         JOIN v_kategori_usia d ON d.id = c.id 
         JOIN map_kelasusia e ON e.id_usia = d.id_usia
         JOIN ref_kelas f ON f.id_kelas = e.id_kelas                                                                          
         WHERE a.id_ekstracatatan = $id_ekstracatatan";

        $query = $this->db->query($sql);

        return $query->row();
    }

    function getDataEkstraForm($id_ekstracatatan){
        $sql = "SELECT * FROM ekstrakulikuler_catatandet WHERE id_ekstracatatan = $id_ekstracatatan";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function simpanCatatanEkstra(){
        date_default_timezone_set('Asia/Jakarta');

        $sql = "SELECT id_ekstracatatandet, kolom FROM ekstrakulikuler_catatandet WHERE id_ekstracatatan = ".$_POST['id_ekstracatatan'];
        $query = $this->db->query($sql);
        $datalistform =  $query->result();

        $this->db->trans_start();
        foreach ($datalistform as $form){
            $id_ekstracatatandet = $form->id_ekstracatatandet;
            $kolom = $form->kolom;
            $value = $this->input->post($kolom);

            $update_checkup['value'] = $value;
            $this->db->where('id_ekstracatatandet', $id_ekstracatatandet);
            $this->db->update('ekstrakulikuler_catatandet', $update_checkup);
        }

        $update_ekstra['is_catat'] = 1;
        $update_ekstra['nilai'] = $this->input->post('nilai');
        $update_ekstra['keterangan'] = $this->input->post('keterangan');
        $this->db->where('id_ekstracatatan', $_POST['id_ekstracatatan']);
        $this->db->update('ekstrakulikuler_catatan', $update_ekstra);

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
        $path = './uploads/catatan_ekstra/'; // your upload path

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
                    $id_file = $this->insertDokumentasiHarian($temp_filename, $ext, $fileName, $fileSize, $_POST['id_ekstracatatan']);
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
        $sql = "SELECT download_url FROM file_ektrakulikuler WHERE id_file = $id_file";
        $query = $this->db->query($sql);
        $download_url = $query->row()->download_url;
        $path = './'.$download_url;

        $this->db->trans_start();

        $this->db->where('id_file', $id_file);
        $this->db->delete('file_ektrakulikuler');

        $this->db->trans_complete();

        if($this->db->trans_status()){
            @unlink($path);
        }

        return $this->db->trans_status();
    }

    function insertDokumentasiHarian($temp_filename, $ext, $fileName, $fileSize, $id_ekstracatatan){
        $user = $this->session->userdata['auth'];

        $a_input['id_ekstracatatan'] = $id_ekstracatatan;
        $a_input['file_name'] = $fileName;
        $a_input['size'] = $fileSize;
        $a_input['download_url'] = 'uploads/catatan_ekstra/' . $temp_filename.'.'.$ext;
        $a_input['temp_file_name'] = $temp_filename;
        $a_input['ext'] = $ext;
        $a_input['created_at'] = date('Y-m-d H:m:s');
        $a_input['updater'] = $user->id;

        $this->db->insert('file_ektrakulikuler', $a_input);

        return $this->db->insert_id();
    }

    function getDokumentasiFile($id_ekstracatatan){
        $sql = "SELECT * FROM file_ektrakulikuler WHERE id_ekstracatatan = $id_ekstracatatan";
        $query = $this->db->query($sql);

        return $query->result();
    }
}

?>