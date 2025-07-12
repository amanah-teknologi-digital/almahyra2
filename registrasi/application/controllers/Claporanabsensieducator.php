<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claporanabsensieducator extends CI_Controller {

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

        if ($this->role == 7 || $this->role == 8) {
            $parent = 'mengaji';
            $label = "Ustadzah";
            $title = 'Laporan Absensi Ustadzah';
        }else{
            $parent = 'absensi';
            $label = "Educator";
            $title = 'Laporan Absensi Educator';
        }

		$this->data = array(
            'controller'=>'claporanabsensieducator',
            'redirect'=>'laporan-absensieducator',
            'title'=>$title,
            'label'=>$label,
            'parent'=>$parent,
        );
		## load model here 
		$this->load->model('Mlaporanabsensieducator', 'LaporanAbsensiEducator');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_absensieducator', $_POST['tahun']);
            $this->session->set_userdata('id_educator_session_absensieducator', $_POST['id_user']);
        }

        $tahun = $this->session->userdata('tahun_session_absensieducator');
        $id_user = $this->session->userdata('id_educator_session_absensieducator');
        if (empty($id_user)){
            $id_user = 0;
        }

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['tahun'] = $this->LaporanAbsensiEducator->getListTahun();
        if (empty($tahun)) {
            $tahun = $data['tahun'][0]->tahun;
        }

        if (empty($tahun)){
            $tahun = 0;
        }

        $data['list_educator'] = $this->LaporanAbsensiEducator->getListEducator($this->role);

        if (!empty($id_user)) {
            $data['data_educator'] = $this->LaporanAbsensiEducator->getDataEducator($id_user);
            $data['data_absensi'] = $this->LaporanAbsensiEducator->getDataAbsensi($id_user, $tahun);
        }else{
            $data['data_educator'] = [];
            $data['data_absensi'] = [];
        }

        $data['tahun_selected'] = $tahun;
        $data['id_user'] = $id_user;

		$this->load->view('inc/laporanabsensieducator/list', $data);
	}

    function cetakabsensieducator(){
        $data = $this->data;

        $id_user = $_POST['id_user'];
        $tahun = $_POST['tahun'];

        if (!empty($id_user)) {
            $data['data_educator'] = $this->LaporanAbsensiEducator->getDataEducator($id_user);
            $data['data_absensi'] = $this->LaporanAbsensiEducator->getDataAbsensi($id_user, $tahun);
        }else{
            $data['data_educator'] = [];
            $data['data_absensi'] = [];
        }
        $data['tahun_selected'] = $tahun;

        $this->load->view('inc/laporanabsensieducator/cetak_absensi', $data);
    }
}
