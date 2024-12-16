<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabsensieducator extends CI_Controller {

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
            'controller'=>'cabsensieducator',
            'redirect'=>'absensi-educator',
            'title'=>'Absensi Educator',
            'parent'=>'absensi',
            'role' => $this->session->userdata['auth']->id_role,
        );
        ## load model here 
        $this->load->model('Mabsensieducator', 'Absensieducator');
    }

    public function index() {
        $data = $this->data;

        if (!empty($_POST)) {
            $this->session->set_userdata('educator_session_absen', $_POST['educator']);
        }

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $educator = $this->session->userdata('educator_session_absen');
        $data['list_educator'] = $this->Absensieducator->getListEducator($this->role);
        if ($this->role == 3) {
            $educator = $this->session->userdata['auth']->id;
        }

        if (!empty($educator)) {
            $data['data_educator'] = $this->Absensieducator->getDataEducator($educator);
            $data['absensi'] = $this->Absensieducator->getAbsensiEducator($educator);
            $data['status_absen'] = $this->Absensieducator->checkOnprogressAbsensi($educator);
        }else{
            $data['data_educator'] = [];
            $data['absensi'] = [];
            $data['status_absen'] = [];
        }
        $data['list_jenisabsensi'] = $this->Absensieducator->getListJenisAbsensi();
        $data['list_jenislembur'] = $this->Absensieducator->getListJenisLembur();
        $data['educator'] = $educator;

        $this->load->view('inc/absensieducator/list', $data);
    }

    public function insert() {
        
        $err = $this->Absensianak->insert();

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }

        redirect($this->data['redirect']);
    }

    public function edit($id) {
        $data = $this->Absensieducator->getDataAbsenByIdAbsensi($id);

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function absenmasuk(){
        $err = $this->Absensieducator->absenMasuk();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Absen Masuk');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Absen Masuk');
        }

        redirect($this->data['redirect']);
    }

    public function absenpulang(){
        $err = $this->Absensieducator->absenPulang();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Absen Pulang');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Absen Pulang');
        }

        redirect($this->data['redirect']);
    }
}
