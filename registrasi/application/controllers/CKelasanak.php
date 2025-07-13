<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CKelasanak extends CI_Controller {

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
            'controller'=>'ckelasanak',
            'redirect'=>'kelas-anak',
            'title'=>'Kelas Anak',
            'parent'=>'register'
        );
		## load model here 
		$this->load->model('Mkelasanak', 'KelasAnak');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->KelasAnak->getAll();
        $data['listkelasnonalmahyra'] = $this->KelasAnak->getKelasNonAlmahyra();
		$data['column'] = $this->KelasAnak->getColumn();
        $data['list_educator'] = $this->KelasAnak->getListEducator();

		$this->load->view('inc/kelasanak/list', $data);
	}

    public function updatestatus() {
        $id_anak = $_POST["id_anak"];
        $id_usia = $_POST["id_usia"];

        $err = $this->KelasAnak->updateKelasAnak($id_usia, $id_anak);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Kelas Anak');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Kelas Anak');
        }

        redirect($this->data['redirect']);
    }

    public function updatekeAlmahyra() {
        $id_anak = $_POST["id_anak"];

        $err = $this->KelasAnak->updateKeAlmahyra($id_anak);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Kelas Anak');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Kelas Anak');
        }

        redirect($this->data['redirect']);
    }
}
