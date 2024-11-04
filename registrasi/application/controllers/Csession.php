<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CSession extends CI_Controller {

	var $data = array();

	function __construct() {
		parent::__construct();
		
		$this->load->model('Mpengguna', 'User');

        $this->data = array(
            'controller'=>'csession',
            'redirect'=>'login',
            'parent'=>'dashboard'
        );

	}

	public function index()	{	

		$data = $this->data;

		$this->load->view('inc/session/index', $data);
	}

	public function profile()	{	

		$data = $this->data;
		// print_r($this->session->userdata('auth')->id);die();
        $data['profile'] = $this->User->getByID($this->session->userdata('auth')->id);

		$this->load->view('inc/session/profile', $data);
	}

	public function update() {
		$err = $this->User->update($this->input->post('id'));
		
		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data Silahkan Logout Terlebih Dahulu');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect('profile');
	}

	public function login()	{	

		$data = $this->data;

		$exist = $this->User->getLogin();
		
		if (empty($exist)) {				
			
			$this->session->set_flashdata('failed', 'User Not Found');
			
			redirect($this->data['controller']);	

		} else {
            
            if($exist->status > 0 ) {
                $this->session->set_userdata('auth', $exist);       
            
                $this->session->set_flashdata('success', 'Selamat Datang');
                
                redirect('dashboard');          
            } else {
                $this->session->set_flashdata('info', 'Akun anda belum di verifikasi admin. Mohon menunggu');
            
                redirect($this->data['controller']);    
            }			
		}

		// $this->load->view('inc/session/index', $data);
	}

    public function register(){
        $err = $this->User->insert();

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Registrasi. Silahkan Menunggu Verifikasi Akun');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Registrasi');
        }

        redirect($this->data['redirect']);
    }

	public function logout()	{	

		$this->session->sess_destroy();

		redirect($this->data['redirect']);		
	}

}
