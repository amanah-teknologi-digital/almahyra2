<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabsensianak extends CI_Controller {

    var $data = array();
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

        $this->data = array(
            'controller'=>'cabsensianak',
            'redirect'=>'absensi-anak',
            'title'=>'Absensi Anak',
            'parent'=>'absensi',
            'role' => $this->session->userdata('auth')->id_role,
        );
        ## load model here 
        $this->load->model('Mabsensianak', 'Absensianak');
    }

    public function index() {

        $data = $this->data;

        $data['list'] = $this->Absensianak->getListAnak();

        $this->load->view('inc/absensianak/list', $data);
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
        $data = $this->Absensianak->getDataAbsenByIdAnak($id);

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function absenmasuk(){
        $err = $this->Absensianak->absenMasuk();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Absen Masuk');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Absen Masuk');
        }

        redirect($this->data['redirect']);
    }

    public function absenpulang(){
        $err = $this->Absensianak->absenPulang();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Absen Pulang');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Absen Pulang');
        }

        redirect($this->data['redirect']);
    }

    public function update() {
        $err = $this->Absensianak->update($this->input->post('id'));

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Data');
        }   

        redirect($this->data['redirect']);
    }

    public function delete($id) {
        $err = $this->Absensianak->delete($id);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
        }   

        redirect($this->data['redirect']);
    }
}
