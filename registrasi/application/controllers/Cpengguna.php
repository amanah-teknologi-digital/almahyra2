<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPengguna extends CI_Controller {

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

		## load model here 
		$this->load->model('Mpengguna', 'Pengguna');
		$this->load->model('Mrole', 'Role');

		$this->data = array(
            'controller'=>'cpengguna',
            'redirect'=>'pengguna',
            'title'=>'Pengguna',
            'parent'=>'referensi',
            'role'=>$this->Role->getList(),
        );
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->Pengguna->getAll();
		$data['column'] = $this->Pengguna->getColumn();	

		$this->load->view('inc/pengguna/list', $data);
	}

	public function insert() {
		
		$err = $this->Pengguna->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Pengguna->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->Pengguna->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->Pengguna->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}

	public function resets() {
		$data = $this->data;

		$data['error'] = $this->Pengguna->resets($this->input->post('id'));

		$this->output->set_output(json_encode($data['error']));

	    return $data['error'];
	}
}
