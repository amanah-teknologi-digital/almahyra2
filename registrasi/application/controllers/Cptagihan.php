<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPtagihan extends CI_Controller {

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
            'controller'=>'cptagihan',
            'redirect'=>'pembayaran-tagihan',
            'title'=>'Pembayaran Tagihan',
            'parent'=>'pembayaran'
        );
		## load model here 
		$this->load->model('Mpembayarantagihan', 'Ptagihan');
        $this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mtagihan', 'Tagihan');
	}

	public function index() {   

        $data = $this->data;

        $data['list'] = $this->RegisterAnak->getAll();

        $data['tagihan'] = $this->Tagihan->getList();

        $data['column'] = $this->RegisterAnak->getColumn(); 

        $this->load->view('inc/ptagihan/list', $data);
    }

	public function insert() {
		
        if(empty($this->input->post('tagihan'))) {
            $this->session->set_flashdata('failed', 'Anda belum mencentang tagihan apapun');
        } else {
            $err = $this->Ptagihan->insert();
            
            if ($err['code'] == '0') {
                $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
            } else {
                $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
            }    
        }

		redirect($this->data['redirect']);
	}

	public function edit($id) {
        $data = $this->data;

        $data['list_edit'] = $this->Ptagihan->getByID($id) ;

        $data['list_tagihan'] = $this->Ptagihan->getByIDanak($id) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }

	public function update() {

		$err = $this->Ptagihan->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->Ptagihan->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}

    public function bayar() {
        
        $filenames = array();
        
        foreach ($_FILES as $key => $v) {
            
            if($_FILES[$key]['size'] > 0) {
                
                $res = $this->do_upload($key);
                
                $filenames[$key] = $res;
            }

        }

        $err = $this->Ptagihan->bayar($this->input->post('id'), $filenames);           
        
        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }
   

        redirect($this->data['redirect']);
    }

    public function do_upload($key) {
        $config['upload_path']          = './uploads';
        $config['allowed_types']        = '*';
        $config['max_size']             = '100000';
        $config['file_name']            = date('dmyhis');

        $this->load->library('upload', $config);

        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($key)){
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

    public function validasi($id) {
        $data = $this->data;

        $data['list_edit'] = $this->Ptagihan->getDetail($id) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }
}
