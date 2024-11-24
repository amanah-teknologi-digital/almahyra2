<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CTahun extends CI_Controller {

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
            'controller'=>'ctahun',
            'redirect'=>'tahun',
            'title'=>'Tematik Tahunan',
            'parent'=>'rencana'
        );
		## load model here 
		$this->load->model('Mtahun', 'Tahun');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->Tahun->getAll();
		$data['column'] = $this->Tahun->getColumn();

		$this->load->view('inc/tahun/list', $data);
	}

	public function insert() {
        try {
            $this->Tahun->insert();

            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data: ' . $e->getMessage());
        }

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Tahun->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
        try {
            $this->Tahun->update($this->input->post('id'));

            $this->session->set_flashdata('success', 'Berhasil Merubah Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Merubah Data: ' . $e->getMessage());
        }

		redirect($this->data['redirect']);
	}

	public function delete($id) {
        try {
            $this->Tahun->delete($id);

            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data: ' . $e->getMessage());
        }

		redirect($this->data['redirect']);
	}
}
