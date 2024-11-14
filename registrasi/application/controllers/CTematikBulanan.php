<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CTematikBulanan extends CI_Controller {

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
            'controller'=>'ctematikbulanan',
            'redirect'=>'tematik-bulanan',
            'title'=>'Tematik Bulanan',
            'parent'=>'rencana'
        );
		## load model here 
		$this->load->model('MTematikbulan', 'TematikBulan');
		$this->load->model('MTahun', 'Tahun');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->TematikBulan->getAll();
		$data['column'] = $this->TematikBulan->getColumn();

		$this->load->view('inc/tematikbulan/list', $data);
	}

    public function lihatdata($tahun){
        $data = $this->data;

        $data['tema_tahun'] = $this->Tahun->getByID($tahun);
        $data['list_bulan'] = $this->TematikBulan->getAllBulanByTahun($tahun);
        $data['tahun_tematik'] = $tahun;

        $this->load->view('inc/tematikbulan/lihat_data', $data);
    }

	public function insert() {
		$err = $this->TematikBulan->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->TematikBulan->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->TematikBulan->update($this->input->post('id_temabulanan'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan']);
	}

	public function delete($id) {
		$err = $this->Tahun->delete($id);

		if ($err > 0) {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}
}
