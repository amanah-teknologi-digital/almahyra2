<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CTagihan extends CI_Controller {

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
            'controller'=>'ctagihan',
            'redirect'=>'uraian-tagihan',
            'title'=>'Tagihan Tagihan',
            'parent'=>'referensi'
        );
		## load model here 
		$this->load->model('Mtagihan', 'Tagihan');
        $this->load->model('Muraian', 'Uraian');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->Tagihan->getAll();

        $data['uraian'] = $this->Uraian->getList();

		$data['column'] = $this->Tagihan->getColumn();	

		$this->load->view('inc/tagihan/list', $data);
	}

	public function insert() {
		
		$err = $this->Tagihan->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Tagihan->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->Tagihan->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->Tagihan->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}
}
