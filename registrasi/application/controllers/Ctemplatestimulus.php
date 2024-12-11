<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctemplatestimulus extends CI_Controller {

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
            'controller'=>'ctemplatestimulus',
            'redirect'=>'template-stimulus',
            'title'=>'Template Stimulus',
            'parent'=>'rencana'
        );
		## load model here 
		$this->load->model('Mtemplatestimulus', 'TemplateStimulus');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->TemplateStimulus->getAll();
		$data['column'] = $this->TemplateStimulus->getColumn();

		$this->load->view('inc/templatestimulus/list', $data);
	}

	public function insert() {
        $err = $this->TemplateStimulus->insertStimulasi();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambah Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambah Data');
        }

        redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->TemplateStimulus->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
        $err = $this->TemplateStimulus->updateStimulasi($_POST['id_templatestimulus']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Merubah Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Merubah Data');
        }

        redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->TemplateStimulus->delete($id);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        }

        redirect($this->data['redirect']);
	}
}
