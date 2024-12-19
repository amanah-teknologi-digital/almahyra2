<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claporanmedicalcheckup extends CI_Controller {

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
            'controller'=>'claporanabsensianak',
            'redirect'=>'laporan-absensianak',
            'title'=>'Laporan Absensi Anak',
            'parent'=>'laporan',
        );
		## load model here 
		$this->load->model('Mlaporanabsensianak', 'LaporanAbsensiAnak');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_absensianak', $_POST['tahun']);
            $this->session->set_userdata('id_anak_session_absensianak', $_POST['id_anak']);
        }

        $tahun = $this->session->userdata('tahun_session_absensianak');
        $id_anak = $this->session->userdata('id_anak_session_absensianak');
        if (empty($id_anak)){
            $id_anak = 0;
        }

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['tahun'] = $this->LaporanAbsensiAnak->getListTahun();
        if (empty($tahun)) {
            $tahun = $data['tahun'][0]->tahun;
        }

        if (empty($tahun)){
            $tahun = 0;
        }

        $data['list_anak'] = $this->LaporanAbsensiAnak->getListAnak($this->role);

        if (!empty($id_anak)) {
            $data['data_anak'] = $this->LaporanAbsensiAnak->getDataAnak($id_anak);
            $data['data_absensi'] = $this->LaporanAbsensiAnak->getDataAbsensi($id_anak, $tahun);
        }else{
            $data['data_anak'] = [];
            $data['data_absensi'] = [];
        }

        $data['tahun_selected'] = $tahun;
        $data['id_anak'] = $id_anak;

		$this->load->view('inc/laporanabsensianak/list', $data);
	}

    function cetakabsensianak(){
        $data = $this->data;

        $id_anak = $_POST['id_anak'];
        $tahun = $_POST['tahun'];

        if (!empty($id_anak)) {
            $data['data_anak'] = $this->LaporanAbsensiAnak->getDataAnak($id_anak);
            $data['data_absensi'] = $this->LaporanAbsensiAnak->getDataAbsensi($id_anak, $tahun);
        }else{
            $data['data_anak'] = [];
            $data['data_absensi'] = [];
        }

        $data['tahun_selected'] = $tahun;

        $this->load->view('inc/laporanabsensianak/cetak_absensi', $data);
    }
}
