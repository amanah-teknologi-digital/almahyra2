<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cdataekstrakulikuler extends CI_Controller {

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
            'controller'=>'cdataekstrakulikuler',
            'redirect'=>'data-ekstrakulikuler',
            'title'=>'Data Ekstrakulikuler',
            'parent'=>'ekstra'
        );
		## load model here 
		$this->load->model('Mdataekstra', 'DataEkstrakulikuler');
	}

	public function index()	{
		$data = $this->data;

        $data['list_ekstra'] = $this->DataEkstrakulikuler->getListEkstrakulikuler();
        $data['list_pengampu'] = $this->DataEkstrakulikuler->getListPengampu();

		$this->load->view('inc/dataekstra/list', $data);
	}

    public function insert() {
        $data = $this->DataEkstrakulikuler->insertTemplate();

        $err = $data['err'];
        $id_ekstra = $data['id_ekstra'];

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambah Data');
            redirect($this->data['redirect']);
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambah Data');
            redirect($this->data['redirect'].'/edit/'.$id_ekstra);
        }
    }

    public function insertsiswa() {
        $data = $this->DataEkstrakulikuler->insertSiswa();

        $err = $data['err'];
        $id_ekstra = $data['id_ekstra'];

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambah Siswa');
            redirect($this->data['redirect']);
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambah Siswa');
            redirect($this->data['redirect'].'/edit/'.$id_ekstra);
        }
    }

    public function lihatdata($id_ekstra){
        $data = $this->data;

        $data['data_ekstra'] = $this->DataEkstrakulikuler->getDataEkstra($id_ekstra);
        $data['data_formekstra'] = $this->DataEkstrakulikuler->getDataEkstraForm($id_ekstra);
        $data['data_siswa'] = $this->DataEkstrakulikuler->getDataSiswa($id_ekstra);
        $data['list_siswa'] = $this->DataEkstrakulikuler->getListSiswa($id_ekstra);
        $data['id_ekstra'] = $id_ekstra;

        $this->load->view('inc/dataekstra/lihat_data', $data);
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
        $err = $this->DataEkstrakulikuler->delete($id);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        }

        redirect($this->data['redirect']);
	}

    public function editkegiatan($id) {
        $data = $this->data;
        $data['list_edit'] = $this->DataEkstrakulikuler->getJadwalKegiatanHarianById($id) ;

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function insertkegiatan() {
        $err = $this->DataEkstrakulikuler->insertKegiatan();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        }

        redirect($this->data['redirect'].'/edit/'.$_POST['id_ekstra']);
    }

    public function updatekegiatan() {
        $err = $this->DataEkstrakulikuler->updateKegiatan();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        }

        redirect($this->data['redirect'].'/edit/'.$_POST['id_ekstra']);
    }

    public function hapuskegiatan() {
        $err = $this->DataEkstrakulikuler->hapusKegiatan($_POST['id_formekstra']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        }

        redirect($this->data['redirect'].'/edit/'.$_POST['id_ekstra']);
    }

    public function hapussiswa() {
        $err = $this->DataEkstrakulikuler->hapusSiswa($_POST['id_anak'], $_POST['id_ekstra']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Siswa');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Siswa');
        }

        redirect($this->data['redirect'].'/edit/'.$_POST['id_ekstra']);
    }

    public function updatepengampu(){
        $id_ekstra = $_POST["id_ekstra"];
        $id_pengampu = $_POST["id_pengampu"];

        $err = $this->DataEkstrakulikuler->updatePengampuEkstra($id_ekstra, $id_pengampu);

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Merubah Pengampu Ekstra');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Merubah Pengampu Ekstra');
        }

        redirect($this->data['redirect']);
    }
}
