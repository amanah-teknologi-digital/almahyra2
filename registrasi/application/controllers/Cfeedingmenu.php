<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cfeedingmenu extends CI_Controller {

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
            'controller'=>'cfeedingmenu',
            'redirect'=>'feeding-menu',
            'title'=>'Feeding Menu',
            'parent'=>'rencana'
        );
		## load model here 
		$this->load->model('Mfeedingmenu', 'FeedingMenu');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_feeding', $_POST['tahun']);
            $this->session->set_userdata('id_rincianjadwal_mingguan_session_feeding', $_POST['id_rincianjadwal_mingguan']);
            $this->session->set_userdata('id_jadwalharian_session_feeding', $_POST['id_jadwalharian']);
        }

        $tahun = $this->session->userdata('tahun_session_feeding');
        $id_rincianjadwal_mingguan = $this->session->userdata('id_rincianjadwal_mingguan_session_feeding');
        $id_jadwalharian = $this->session->userdata('id_jadwalharian_session_feeding');

		$data = $this->data;
        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $nama_tema = "";
        $nama_subtema = "";
        $tanggal = "";
        $nama_kelas = "";

        $data['tahun'] = $this->FeedingMenu->getListTahun();
        if (empty($tahun)) {
            foreach ($data['tahun'] as $key => $value) {
                if ($value->is_aktif == 1) {
                    $tahun = $value->tahun;
                }
            }
        }

        if (empty($tahun)) {
            $tahun = 0;
        }

        $data['tahun_selected'] = $tahun;

        $data['tanggal'] = $this->FeedingMenu->getListTanggalByTahun($tahun);
        if (empty($id_rincianjadwal_mingguan)) {
            if (!empty($data['tanggal'])) {
                $id_rincianjadwal_mingguan = $data['tanggal'][0]->id_rincianjadwal_mingguan;
            }else{
                $id_rincianjadwal_mingguan = 0;
            }
        }

        foreach ($data['tanggal'] as $value_tanggal) {
            if ($value_tanggal->id_rincianjadwal_mingguan == $id_rincianjadwal_mingguan) {
                $nama_tema = $value_tanggal->nama_tema;
                $nama_subtema = $value_tanggal->nama_subtema;
                $tanggal = $value_tanggal->tanggal;

                break;
            }
        }

        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['kelas'] = $this->FeedingMenu->getKelasByIdRincian($id_rincianjadwal_mingguan);
        if (!empty($data['kelas'])) {
            if (empty($id_jadwalharian)) {
                $id_jadwalharian = $data['kelas'][0]->id_jadwalharian;
            }

            foreach ($data['kelas'] as $value_kelas) {
                if ($value_kelas->id_jadwalharian == $id_jadwalharian) {
                    $nama_kelas = $value_kelas->nama_kelas;
                    break;
                }
            }

            $data['id_jadwalharian'] = $id_jadwalharian;

            $temp_datafeedingmenu = $this->FeedingMenu->getDataFeedingMenu($id_jadwalharian);
            $data['feedingmenu'] = $temp_datafeedingmenu;
            if (!empty($temp_datafeedingmenu)) {
                $data['id_feedingmenu'] = $temp_datafeedingmenu->id_feedingmenu;
            }else{
                $data['id_feedingmenu'] = 0;
            }

        }else{
            $data['feedingmenu'] = [];
            $data['id_jadwalharian'] = 0;
        }

        $data['nama_tema'] = $nama_tema;
        $data['nama_subtema'] = $nama_subtema;
        $data['tanggal_selected'] = $tanggal;
        $data['nama_kelas'] = $nama_kelas;

		$data['column'] = $this->FeedingMenu->getColumn();

		$this->load->view('inc/feedingmenu/list', $data);
	}

    public function getDataTanggal(){
        $tahun = $_POST['tahun'];

        $data = $this->FeedingMenu->getListTanggalByTahun($tahun);
        if (!empty($data)) {
            $id_rincianjadwal_mingguan = $data[0]->id_rincianjadwal_mingguan;
            $kelas = $this->FeedingMenu->getKelasByIdRincian($id_rincianjadwal_mingguan);

            $data_list = [];
            foreach ($data as $key => $value) {
                $value->nama_hari = format_date_indonesia($value->tanggal);
                $value->tanggal = date('d-m-Y', strtotime($value->tanggal));
                $data_list[] = $value;
            }
            $data['tanggal'] = $data_list;
            $data['kelas'] = $kelas;
        }else{
            $data['tanggal'] = [];
            $data['kelas'] = [];
        }

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;

    }

    public function getDataKelas()
    {
        $id_rincianjadwal_mingguan = $_POST['id_rincianjadwal_mingguan'];

        $data['kelas'] = $this->FeedingMenu->getKelasByIdRincian($id_rincianjadwal_mingguan);

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;

    }

    public function update() {
        $err = $this->FeedingMenu->updateFeedingMenu($_POST['id_jadwalharian']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Simpan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Simpan Data');
        }

        redirect($this->data['redirect']);
    }
}
