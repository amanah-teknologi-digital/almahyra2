<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccatatanmengaji extends CI_Controller {

    var $data = array();
    private $role;
    function __construct() {
        parent::__construct();

        if (empty($this->session->userdata['auth'])) {
            $this->session->set_flashdata('failed', 'Anda Harus Login');

            redirect('login');
        } else {
            // if($this->session->userdata['auth']->activation == 0 || $this->session->userdata['auth']->activation == '0') {
            //     redirect('profile');
            // }
        }

        $this->role = $this->session->userdata['auth']->id_role;

        $this->data = array(
            'controller'=>'ccatatanmengaji',
            'redirect'=>'catatan-mengaji',
            'title'=>'Catatan Mengaji',
            'parent'=>'mengaji',
            'role' => $this->session->userdata['auth']->id_role,
            'categori_image' => ['jpg', 'jpeg', 'png', 'gif'],
            'categori_video' => ['mp4', '3gp', 'avi', 'mkv','mov'],
        );
        ## load model here
        $this->load->model('Mcatatanmengaji', 'CatatanMengaji');
    }

    public function index() {
        if (!empty($_POST)) {
            $this->session->set_userdata('tgl_session_mengaji', $_POST['tanggal_mc']);
            $this->session->set_userdata('sesi_session_mengaji', $_POST['sesi']);
        }

        $tanggal_mc = $this->session->userdata('tgl_session_mengaji');
        $sesi = $this->session->userdata('sesi_session_mengaji');

        $data = $this->data;
        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        if (empty($tanggal_mc)) {
            $tanggal_mc = date('Y-m-d');
        }

        if (empty($sesi)) {
            $sesi = 1;
        }

        $data['tanggal_mc'] = $tanggal_mc;
        $data['sesi_mc'] = $sesi;
        $data['hasil_mengaji'] = $this->CatatanMengaji->getHasilMengaji($tanggal_mc, $sesi);
        $data['list_sesi'] = $this->CatatanMengaji->getListSesi();
        $data['nama_sesi'] = $this->getNamaByIdSesi($data['list_sesi'], $sesi);
        $data['role'] = $this->role;

        $this->load->view('inc/catatanmengaji/list', $data);
    }

    public function getNamaByIdSesi($data, $id_sesi) {
        foreach ($data as $item) {
            if ($item->id_sesi == $id_sesi) {
                return $item->nama;
            }
        }
        return null; // jika tidak ditemukan
    }

    public function checkAktivitas(){
        $tanggal = $this->input->post('tanggal');
        $sesi = $this->input->post('sesi');
        $id_anak = $this->input->post('id_anak');

        $id_mengaji  = $this->CatatanMengaji->checkAktivitas($tanggal, $id_anak, $sesi);

        redirect($this->data['redirect'].'/lihat-data/'.$id_mengaji);
    }

    public function lihatdata($id_mengaji){
        $data = $this->data;

        $data['data_mengaji'] = $this->CatatanMengaji->getDataMengaji($id_mengaji);
        $data['list_jilid'] = $this->CatatanMengaji->getListJilid();
        $data['role'] = $this->role;
        $temp_datadokumentasi = $this->CatatanMengaji->getDokumentasiFile($id_mengaji);
        $data['preview'] = $data['config'] = [];
        foreach ($temp_datadokumentasi as $row){
            $temp_type = strtolower($row->ext);
            if (in_array(strtolower($row->ext), $this->data['categori_image'])) {
                $temp_type = 'image';
            }elseif (in_array(strtolower($row->ext), $this->data['categori_video'])) {
                $temp_type = 'video';
            }

            $fileId = $row->id_file; // some unique key to identify the file
            $data['preview'][] = base_url().$row->download_url;
            if ($temp_type == 'video'){
                if ($row->ext == 'mov'){
                    $row->ext = 'mp4';
                }
                $preview_file = '<video controls width="120px"><source src="'.base_url().$row->download_url.'" type="video/mp4"></video>'; // Video preview with controls
                $data['config'][] = [
                    'type' => $temp_type,
                    'key' => $fileId,
                    'caption' => $row->file_name,
                    'size' => $row->size,
                    'filetype' => "video/".$row->ext,
                    'downloadUrl' => base_url().$row->download_url, // the url to download the file
                    'url' => base_url() . $this->data['controller'] . '/hapusfile', // server api to delete the file based on key
                    'preview' => $preview_file
                ];
            }else{
                $data['config'][] = [
                    'type' => $temp_type,
                    'key' => $fileId,
                    'caption' => $row->file_name,
                    'size' => $row->size,
                    'downloadUrl' => base_url().$row->download_url, // the url to download the file
                    'url' => base_url() . $this->data['controller'] . '/hapusfile', // server api to delete the file based on key
                ];
            }
        }

        $data['dokumentasi_file'] = [
            'preview' => $data['preview'],
            'config' => $data['config']
        ];

        $this->load->view('inc/catatanmengaji/lihat_data', $data);
    }

    public function simpancatatanmengaji(){
        $err = $this->CatatanMengaji->simpanCatatanMengaji();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menyimpan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menyimpan Data');
        }

        redirect($this->data['redirect'].'/lihat-data/'.$_POST['id_catatan']);
    }

    function hapusfile(){
        header('Content-Type: application/json'); // set json response headers

        $err = $this->CatatanMengaji->hapusDokumentasiFile($_POST['key']);

        $out = ['initialPreview' => [], 'initialPreviewConfig' => [], 'initialPreviewAsData' => true];
        if ($err === FALSE) {
            $out['error'] = 'Oh snap! We could not delete the file now. Please try again later.';
        }

        echo json_encode($out); // return json data
        exit(); // terminate
    }
}
