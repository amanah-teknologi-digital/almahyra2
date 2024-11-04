<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRrekammedik extends CI_Controller {

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
		$this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mregisterrekammedik', 'RegisterRekammedik');
        $this->load->model('Mimunisasi', 'Imunisasi');
        $this->load->model('Mpenyakit', 'Penyakit');
        $this->load->model('Mrekampenyakit', 'Rekampenyakit');
        $this->load->model('Mrekamimunisasi', 'Rekamimunisasi');

        $this->data = array(
            'controller'=>'crrekammedik',
            'redirect'=>'register-rekam-medik',
            'title'=>'Register Rekam Medik Anak',
            'parent'=>'register',
            'imunisasi'=>$this->Imunisasi->getList(),
            'penyakit'=>$this->Penyakit->getList(),
        );
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->RegisterAnak->getAll();

		$this->load->view('inc/rekammedik/list', $data);
	}

	public function insert() {
		
		$err = $this->RegisterRekammedik->insert();

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

        $data['list_edit'] = $this->RegisterRekammedik->getByIDAnak($id) ;

        $data['list_edit_penyakit'] = [];
        $data['list_edit_imunisasi'] = [];    
        
        if(!empty($data['list_edit'])) {
            $data['list_edit_penyakit'] = $this->Rekampenyakit->getListbyIdrekam($data['list_edit']->id) ;
    
            $data['list_edit_imunisasi'] = $this->Rekamimunisasi->getListbyIdrekam($data['list_edit']->id) ;    
        }       
        
	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->RegisterRekammedik->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->RegisterRekammedik->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}
}
