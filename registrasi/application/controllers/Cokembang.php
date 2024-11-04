<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cokembang extends CI_Controller {

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
            'controller'=>'cokembang',
            'redirect'=>'observasi-perkembangan',
            'title'=>'Observasi Kembang',
            'parent'=>'observasi'
        );
		## load model here 
		$this->load->model('Mobservasikembang', 'ObservasiKembang');
        $this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mkembanganak', 'Kembanganak');
        $this->load->model('Musia', 'Usia');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->RegisterAnak->getAll();

        $data['pertanyaan'] = $this->Kembanganak->getList();

        $data['usia'] = $this->Usia->getList();

		$this->load->view('inc/observasikembang/list', $data);
	}

	public function insert() {
		
		$err = $this->ObservasiKembang->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

        $data['list_edit'] = $this->ObservasiKembang->getByID($id) ;

        $data['list_kembang'] = $this->ObservasiKembang->getByIDanak($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->ObservasiKembang->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->ObservasiKembang->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}

    public function pertanyaan($id) {
        
        $data['pertanyaan'] = $this->Kembanganak->getByIDusia($id) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }
}
