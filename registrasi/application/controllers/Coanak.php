<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coanak extends CI_Controller {

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
            'controller'=>'coanak',
            'redirect'=>'observasi-anak',
            'title'=>'Observasi Anak',
            'parent'=>'observasi'
        );
        ## load model here 
        $this->load->model('Mobservasianak', 'ObservasiAnak');
        $this->load->model('Mregisteranak', 'RegisterAnak');
    }

    public function index() {   

        $data = $this->data;

        $data['list'] = $this->RegisterAnak->getAll();

        $this->load->view('inc/observasianak/list', $data);
    }

    public function insert() {
        
        $err = $this->ObservasiAnak->insert();

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }

        redirect($this->data['redirect']);
    }

    public function edit($id) {
        $data = $this->data;

        $data['list_anak'] = $this->RegisterAnak->getByID($id) ;
        
        $data['list_edit'] = $this->ObservasiAnak->getByID($id) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function update() {
        $err = $this->ObservasiAnak->update($this->input->post('id'));

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Data');
        }   

        redirect($this->data['redirect']);
    }

    public function delete($id) {
        $err = $this->ObservasiAnak->delete($id);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
        }   

        redirect($this->data['redirect']);
    }
}
