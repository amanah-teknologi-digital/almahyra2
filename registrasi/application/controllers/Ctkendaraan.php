<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CTKendaraan extends CI_Controller {

	var $data = array();
	function __construct() {
		parent::__construct();
		
		if (empty($this->session->userdata['auth'])) {
            $this->session->set_flashdata('failed', 'Anda Harus Login');

            redirect('login');
        } else {
            if($this->session->userdata['auth']->activation == 0 || $this->session->userdata['auth']->activation == '0') {
                redirect('profile');
            }
        } 

		## load model here 
		$this->load->model('Mtkendaraan', 'Tkendaraan');
		$this->load->model('Mkendaraan', 'Kendaraan');

		$this->data = array(
            'controller'=>'ctkendaraan',
            'redirect'=>'peminjaman-kendaraan',
            'title'=>'Peminjaman Kendaraan',
            'parent'=>'peminjaman',
            'kendaraan' => $this->Kendaraan->getList(),
        );

	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->Tkendaraan->getAll();
		$data['column'] = $this->Tkendaraan->getColumn();	
		$data['inavailable'] = $this->Tkendaraan->getInAvailble();


		$data['available'] = array();

		foreach ($data['kendaraan'] as $key => $row) {
			if(!in_array($row->id, $data['inavailable'])) {
				array_push($data['available'], $row);
			} 
		}
		
		$this->load->view('inc/tkendaraan/list', $data);
	}

	public function pengembalian() {	
		$data = $this->data;

		$data['parent'] = 'pengembalian';

		$data['list'] = $this->Tkendaraan->getPengembalian();
		
		$data['column'] = $this->Tkendaraan->getColumn();	

		$this->load->view('inc/tkendaraan/list_pengembalian', $data);
	}

	public function insert() {
        $filename = null;
        
        if($_FILES['nota']['size'] > 0) {
            $filename = $this->do_upload();
        }
        
		$err = $this->Tkendaraan->insert($filename);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Tkendaraan->getByID($id) ;

		$data['list_edit']->tanggal_peminjaman_mulai = date("Y-m-d", strtotime($data['list_edit']->tanggal_peminjaman_mulai));

		$data['list_edit']->tanggal_peminjaman_selesai = date("Y-m-d", strtotime($data['list_edit']->tanggal_peminjaman_selesai));

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$filename = null;
		
		if($_FILES['nota']['size'] > 0) {
			$filename = $this->do_upload();
		}

		$err = $this->Tkendaraan->update($this->input->post('id'),$filename);			

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function update_pengembalian() {
		$filename = null;
		
		if($_FILES['nota']['size'] > 0) {
			$filename = $this->do_upload();
		}

		$err = $this->Tkendaraan->update($this->input->post('id'),$filename);			

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect'].'/pengembalian');
	}

	public function delete($id) {
		$err = $this->Tkendaraan->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}

	public function do_upload() {
		$config['upload_path']          = './uploads';
        $config['allowed_types']        = 'pdf|png|jpeg|jpg';
        $config['max_size']             = '10000';
        $config['file_name']     		= date('dmyhis');

        $this->load->library('upload', $config);

        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('nota')){
                $error = array('error' => $this->upload->display_errors());

                $this->session->set_flashdata('failed', 'Gagal menggunggah dokumen.'. $this->upload->display_errors());

                redirect($this->data['redirect']);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());

                return $this->upload->data('file_name');
        }
	}
}
