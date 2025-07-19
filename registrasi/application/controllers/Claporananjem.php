<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claporananjem extends CI_Controller {

	var $data = array();
    private $role ;

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

        $this->role = $this->session->userdata('auth')->id_role;

		$this->data = array(
            'controller'=>'claporananjem',
            'redirect'=>'laporan-anjem',
            'title'=>'Laporan Antar Jemput',
            'parent'=>'laporan',
        );
		## load model here 
		$this->load->model('Mlaporananjem', 'LaporanAnjem');
	}

	public function index()	{
        $data = $this->data;
        if (!empty($_POST)) {
            $this->session->set_userdata('id_anak_session_lanjem', $_POST['id_anak']);
        }

        $id_anak = $this->session->userdata('id_anak_session_lanjem');
        $data['list_anak'] = $this->LaporanAnjem->getListAnak($this->role);
        $temp_listanak = json_decode(json_encode($data['list_anak']), true);

        if (empty($id_anak)){
            if (!empty($temp_listanak)) {
                $id_anak = $temp_listanak[0]['id'];
            } else {
                $id_anak = 0;
            }
        }

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        if (!empty($id_anak)) {
            $data['data_anak'] = $this->LaporanAnjem->getDataAnak($id_anak);
            $data['data_kebutuhan'] = $this->LaporanAnjem->getDataKebutuhan($id_anak);
        }else{
            $data['data_anak'] = [];
            $data['data_kebutuhan'] = [];
        }

        $data['id_anak'] = $id_anak;

		$this->load->view('inc/laporananjem/list', $data);
	}

    function cetakkebutuhananak(){
        $data = $this->data;
        $id_anak = $_POST['id_anak'];

        if (!empty($id_anak)) {
            $data['data_anak'] = $this->LaporanAnjem->getDataAnak($id_anak);
            $data['data_kebutuhan'] = $this->LaporanAnjem->getDataKebutuhan($id_anak);
        }else{
            $data['data_anak'] = [];
            $data['data_kebutuhan'] = [];
        }

        $this->load->view('inc/laporananjem/cetak_data', $data);
    }
}
