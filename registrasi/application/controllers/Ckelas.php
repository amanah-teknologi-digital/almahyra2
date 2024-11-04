<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CKelas extends CI_Controller {

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
            'controller'=>'ckelas',
            'redirect'=>'kelas',
            'title'=>'Zona',
            'parent'=>'referensi'
        );
		## load model here 
		$this->load->model('Mkelas', 'Kelas');
        $this->load->model('Musia', 'Usia');
        $this->load->model('Mpengguna', 'Pengasuh');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->Kelas->getAll();

        $data['usia'] = $this->Usia->getList();

        $data['pengasuh'] = $this->Pengasuh->getAllPengajar();

        $data['column'] = $this->Kelas->getColumn();	

		$this->load->view('inc/kelas/list', $data);
	}

	public function insert() {
		
		$err = $this->Kelas->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Kelas->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->Kelas->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->Kelas->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}
}
