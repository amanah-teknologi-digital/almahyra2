<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cantarjemput extends CI_Controller {

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
            'controller'=>'cantarjemput',
            'redirect'=>'antar-jemput',
            'title'=>'Antar Jemput',
            'parent'=>'kebutuhan',
            'role' => $this->session->userdata['auth']->id_role,
            'categori_image' => ['jpg', 'jpeg', 'png', 'gif'],
            'categori_video' => ['mp4', '3gp', 'avi', 'mkv','mov'],
        );
        ## load model here
        $this->load->model('Mantarjemput', 'AntarJemput');
    }

    public function index() {
        if (!empty($_POST)) {
            $this->session->set_userdata('tgl_session_antarjemput', $_POST['tanggal']);
        }

        $tanggal = $this->session->userdata('tgl_session_antarjemput');

        $data = $this->data;
        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }

        $data['tanggal'] = $tanggal;
        $data['list_anak'] = $this->AntarJemput->getListAnak();
        $data['list_educator'] = $this->AntarJemput->getListEducator($this->role);
        $data['list_jenisanjem'] = $this->AntarJemput->getListJenisAnjem();
        $data['antar_jemput'] = $this->AntarJemput->getDataAnjem($tanggal);
        $data['role'] = $this->role;

        $this->load->view('inc/antarjemput/list', $data);
    }

    public function simpancatatan(){
        $err = $this->AntarJemput->simpanCatatanAnjem();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menyimpan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menyimpan Data');
        }

        redirect($this->data['redirect']);
    }

    public function updatestatus() {
        $err = $this->AntarJemput->updatestatus($_POST['id_antarjemput']);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Status');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Status');
        }

        redirect($this->data['redirect']);
    }
}
