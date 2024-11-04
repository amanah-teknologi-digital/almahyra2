<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRBerkasPengasuh extends CI_Controller {

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
            'controller'=>'crberkaspengasuh',
            'redirect'=>'register-berkas-pengasuh',
            'title'=>'Register Berkas Pengasuh',
            'parent'=>'register'
        );
		## load model here 
		$this->load->model('Mregisterberkaspengasuh', 'RegisterBerkasPengasuh');
        $this->load->model('Mregisterpengasuh', 'RegisterPengasuh');
	}  

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->RegisterPengasuh->getAll();	

		$this->load->view('inc/registerberkaspengasuh/list', $data);
	}

	public function insert() {
		
		$filenames = array();
        
        foreach ($_FILES as $key => $v) {
            
            if($_FILES[$key]['size'] > 0) {
                
                $res = $this->do_upload($key);
                
                $filenames[$key] = $res;
            }

        }

        $err = $this->RegisterBerkasPengasuh->insert($this->input->post('id_anak'),$filenames);           
        
        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }
   

        redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

        $data['list_anak'] = $this->RegisterPengasuh->getByID($id) ;

		$data['list_edit'] = $this->RegisterBerkasPengasuh->getByIDAnak($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->RegisterBerkasPengasuh->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->RegisterBerkasPengasuh->delete($id);

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
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
}
