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
		$data['column'] = $this->KelasAnak->getColumn();
        $data['list_educator'] = $this->KelasAnak->getListEducator();

		$this->load->view('inc/registeranak/list', $data);
	}

	public function insert() {
		
		$err = $this->KelasAnak->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->KelasAnak->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->KelasAnak->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

    public function updatestatus() {
        $err = $this->KelasAnak->updatestatus($_POST['id_user']);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Status');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Status');
        }

        redirect($this->data['redirect']);
    }

	public function delete($id) {
		$err = $this->KelasAnak->delete($id);

		if ($err) {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}
}
