<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CTemplateJadwal extends CI_Controller {

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
            'controller'=>'ctemplatejadwal',
            'redirect'=>'template-jadwal',
            'title'=>'Template Jadwal',
            'parent'=>'rencana'
        );
		## load model here 
		$this->load->model('MTemplateJadwal', 'TemplateJadwal');
	}

	public function index()	{
		$data = $this->data;

		$data['list'] = $this->TemplateJadwal->getAll();
		$data['column'] = $this->TemplateJadwal->getColumn();

		$this->load->view('inc/templatejadwal/list', $data);
	}

	public function insert() {
        $data = $this->TemplateJadwal->insertTemplate();

        $err = $data['err'];
        $id_template_jadwal = $data['id_templatejadwal'];

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Merubah Data');
            redirect($this->data['redirect']);
        }else{
            $this->session->set_flashdata('success', 'Berhasil Merubah Data');
            redirect($this->data['redirect'].'/edit/'.$id_template_jadwal);
        }
	}

    public function lihatdata($id_templatejadwal){
        var_dump($id_templatejadwal);
    }

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Tahun->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->Tahun->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
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
