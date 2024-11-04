<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CKembanganak extends CI_Controller {

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
            'controller'=>'ckembanganak',
            'redirect'=>'kembang-anak',
            'title'=>'Pertanyaan Perkembangan Anak',
            'parent'=>'referensi'
        );
		## load model here 
		$this->load->model('Mkembanganak', 'Kembanganak');
        $this->load->model('Musia', 'Usia');
        $this->load->model('Maspek', 'Aspek');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->Kembanganak->getAll();

        $data['usia'] = $this->Usia->getList();
        
        $data['aspek'] = $this->Aspek->getList();

		$data['column'] = $this->Kembanganak->getColumn();	

		$this->load->view('inc/kembanganak/list', $data);
	}

	public function insert() {
		
		$err = $this->Kembanganak->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Kembanganak->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->Kembanganak->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->Kembanganak->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}
}
