<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabsensipengasuh extends CI_Controller {

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
            'controller'=>'cabsensipengasuh',
            'redirect'=>'absensi-pengasuh',
            'title'=>'Absensi Pengasuh',
            'parent'=>'Absensi'
        );
        ## load model here 
        $this->load->model('Mabsensipengasuh', 'AbsensiPengasuh');
        $this->load->model('Mregisterpengasuh', 'RegisterPengasuh');
    }

    public function index() {   

        $data = $this->data;

        $data['list'] = $this->RegisterPengasuh->getAll();

        $this->load->view('inc/absensipengasuh/list', $data);
    }

    public function insert() {
        
        $err = $this->AbsensiPengasuh->insert();

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }

        redirect($this->data['redirect']);
    }

    public function edit($id) {
        $data = $this->data;

        $data['list_edit'] = $this->AbsensiPengasuh->getByID($id) ;

        $data['list_hasil'] = $this->AbsensiPengasuh->getByIDanak($id) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function update() {
        $err = $this->AbsensiPengasuh->update($this->input->post('id'));

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Data');
        }   

        redirect($this->data['redirect']);
    }

    public function delete($id) {
        $err = $this->AbsensiPengasuh->delete($id);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
        }   

        redirect($this->data['redirect']);
    }
}
