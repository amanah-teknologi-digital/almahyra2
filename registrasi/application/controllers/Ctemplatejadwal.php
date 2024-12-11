<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctemplatejadwal extends CI_Controller {

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
		$this->load->model('Mtemplatejadwal', 'TemplateJadwal');
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
        $data = $this->data;

        $data['data_template'] = $this->TemplateJadwal->getByID($id_templatejadwal);
        $data['data_jadwal_template'] = $this->TemplateJadwal->getDataJadwalTempateById($id_templatejadwal);
        $data['id_templatejadwal'] = $id_templatejadwal;

        $this->load->view('inc/templatejadwal/lihat_data', $data);
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
        $err = $this->TemplateJadwal->delete($id);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        }

        redirect($this->data['redirect']);
	}

    public function editkegiatan($id) {
        $data = $this->data;
        $data['list_edit'] = $this->TemplateJadwal->getJadwalKegiatanHarianById($id) ;

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function insertkegiatan() {
        $err = $this->TemplateJadwal->insertKegiatan();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        }

        redirect($this->data['redirect'].'/edit/'.$_POST['id_templatejadwal']);
    }

    public function updatekegiatan() {
        $err = $this->TemplateJadwal->updateKegiatan();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        }

        redirect($this->data['redirect'].'/edit/'.$_POST['id_templatejadwal']);
    }

    public function hapuskegiatan() {
        $err = $this->TemplateJadwal->hapusKegiatan($_POST['id_kegiatan']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        }

        redirect($this->data['redirect'].'/edit/'.$_POST['id_templatejadwal']);
    }
}
