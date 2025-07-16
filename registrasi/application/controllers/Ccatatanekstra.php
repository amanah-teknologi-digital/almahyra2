<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccatatanekstra extends CI_Controller {

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
            'controller'=>'ccatatanekstra',
            'redirect'=>'catatan-ekstra',
            'title'=>'Catatan Ekstrakurikuler',
            'parent'=>'ekstra',
            'role' => $this->session->userdata['auth']->id_role,
            'categori_image' => ['jpg', 'jpeg', 'png', 'gif'],
            'categori_video' => ['mp4', '3gp', 'avi', 'mkv','mov'],
        );
        ## load model here
        $this->load->model('Mcatatanekstra', 'CatatanEkstra');
    }

    public function index() {
        if (!empty($_POST)) {
            $this->session->set_userdata('tgl_session_ekstra', $_POST['tanggal']);
            $this->session->set_userdata('ekstra_session_ekstra', $_POST['ekstra']);
        }

        $tanggal = $this->session->userdata('tgl_session_ekstra');
        $ekstra = $this->session->userdata('ekstra_session_ekstra');

        $data = $this->data;
        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }

        $data['list_ekstra'] = $this->CatatanEkstra->getListEkstra();

        if (!empty($data['list_ekstra'])) {
            $temp_ekstra = json_decode(json_encode($data['list_ekstra']), true);
            if (empty($ekstra)) {
                if (!empty($temp_ekstra)) {
                    $ekstra = $temp_ekstra[0]['id_ekstra'];
                }else{
                    $ekstra = 0;
                }
            }
        } else {
            $ekstra = 0;
        }

        $data['tanggal'] = $tanggal;
        $data['ekstra'] = $ekstra;
        $data['hasil_catatan'] = $this->CatatanEkstra->getHasilEkstra($tanggal, $ekstra);
        $data['nama_ekstra'] = $this->getNamaByIdEkstra($data['list_ekstra'], $ekstra);
        $data['role'] = $this->role;

        $this->load->view('inc/catatanekstra/list', $data);
    }

    public function getNamaByIdEkstra($data, $ekstra) {
        foreach ($data as $item) {
            if ($item->id_ekstra == $ekstra) {
                return $item->nama;
            }
        }
        return null; // jika tidak ditemukan
    }

    public function checkAktivitas(){
        $tanggal = $this->input->post('tanggal');
        $id_ekstra = $this->input->post('ekstra');
        $id_anak = $this->input->post('id_anak');

        $id_ekstracatatan  = $this->CatatanEkstra->checkAktivitas($tanggal, $id_anak, $id_ekstra);

        redirect($this->data['redirect'].'/lihat-data/'.$id_ekstracatatan);
    }

    public function lihatdata($id_ekstracatatan){
        $data = $this->data;

        $data['hasil_catatan'] = $this->CatatanEkstra->getDataEkstra($id_ekstracatatan);
        $temp_datamengaji = json_decode(json_encode($data['data_mengaji']), true);
        $tanggal = $temp_datamengaji['tanggal'];
        $id_anak = $temp_datamengaji['id'];
        $data['data_sebelum'] = $this->CatatanEkstra->getDataSebelumnya($id_ekstracatatan, $tanggal, $id_anak);
        $data['role'] = $this->role;
        $temp_datadokumentasi = $this->CatatanEkstra->getDokumentasiFile($id_ekstracatatan);
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
