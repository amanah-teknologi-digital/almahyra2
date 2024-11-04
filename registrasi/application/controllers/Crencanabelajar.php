<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRencanabelajar extends CI_Controller {

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
            'controller'=>'crencanabelajar',
            'redirect'=>'rencana-belajar',
            'title'=>'Rencana Pembelajaran Tematik Tahunan',
            'parent'=>'rencana'
        );
		## load model here 
		$this->load->model('Mrencanabelajar', 'Rencanabelajar');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->Rencanabelajar->getAll();
		$data['column'] = $this->Rencanabelajar->getColumn();	

		$this->load->view('inc/rencanabelajar/list', $data);
	}

	public function insert() {
		
		$err = $this->Rencanabelajar->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Rencanabelajar->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->Rencanabelajar->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->Rencanabelajar->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}

    public function rencanaf() {   

        $data = $this->data;

        

        $this->load->view('inc/rencanabelajar/rencana_f', $data);
    }

    public function rencanarpp() {   

        $data = $this->data;

        $data['laporan'] = null ;
        $data['jumlah'] = 0 ;
        
        if (!empty($_POST['tanggal'])) {
            $data['laporan'] = $this->Rencanabelajar->getReport($_POST['tanggal']);
            $data['jumlah'] = ceil(count($data['laporan'])/10) ;
        }
        
        $this->load->view('inc/rencanabelajar/rencana_full', $data);
        
    }
}
