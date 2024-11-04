<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cozona extends CI_Controller {

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
            'controller'=>'cozona',
            'redirect'=>'penentuan-zona',
            'title'=>'Observasi Zona',
            'parent'=>'observasi'
        );
        ## load model here 
        $this->load->model('Mobservasizona', 'ObservasiZona');
        $this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mpengguna', 'Pengguna');
        $this->load->model('Mkelas', 'Zona');
    }

    public function index() {   

        $data = $this->data;

        $data['list'] = $this->RegisterAnak->getAll();

        $data['pengajar'] = $this->Pengguna->getAllPengajar();

        $data['zona'] = $this->Zona->getList();

        $this->load->view('inc/observasizona/list', $data);
    }

    public function insert() {
        
        $err = $this->ObservasiZona->insert();

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }

        redirect($this->data['redirect']);
    }

    public function edit($id) {
        $data = $this->data;

        $data['list_edit'] = $this->ObservasiZona->getByID($id) ;

        $data['list_zona'] = $this->ObservasiZona->getByIDanak($id) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function update() {
        $err = $this->ObservasiZona->update($this->input->post('id'));

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Data');
        }   

        redirect($this->data['redirect']);
    }

    public function delete($id) {
        $err = $this->ObservasiZona->delete($id);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
        }   

        redirect($this->data['redirect']);
    }
}
