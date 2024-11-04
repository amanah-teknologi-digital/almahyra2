<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabsensiitems extends CI_Controller {

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
            'controller'=>'cabsensiitems',
            'redirect'=>'absensi-items',
            'title'=>'Absensi Item',
            'parent'=>'absensi'
        );
		## load model here 
		$this->load->model('Mabsensiitems', 'Absensiitems');
        $this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mkembanganak', 'Kembanganak');
        $this->load->model('Mitems', 'Items');
        $this->load->model('Mabsensiitemsitem', 'Absensiitemsitem');
        
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->RegisterAnak->getAll();

        $data['items'] = $this->Items->getList();

        if ($this->session->userdata['auth']->id_role == 4) {
            // ortu
            // $this->load->view('inc/absensiitems/orangtua', $data);    
            $this->load->view('inc/absensiitems/list', $data);    
        } else {
            // admin
            $this->load->view('inc/absensiitems/list', $data);    
        }
		
	}

	public function insert() {
		
        $err = $this->Absensiitems->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		
        $data = $this->data;

        $data['list_edit'] = $this->Absensiitems->getByID($id) ;

        $data['list_absensi'] = $this->Absensiitems->getByIDanak($id) ;

        $data['list_items'] = $this->Absensiitemsitem->getAllbyIdanak($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
        
		$err = $this->Absensiitemsitem->update($this->input->post('id'));

		$this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($err));

        return 1;
	}

	public function delete($id) {
		$err = $this->Absensiitems->delete($id);

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
