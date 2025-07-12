<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claporanmengaji extends CI_Controller {

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
        }else{
            $parent = 'laporan';
        }

		$this->data = array(
            'controller'=>'claporanmengaji',
            'redirect'=>'laporan-mengaji',
            'title'=>'Laporan Mengaji Anak',
            'parent'=>$parent,
        );
		## load model here 
		$this->load->model('Mlaporanmengaji', 'LaporanMengaji');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_lapmengaji', $_POST['tahun']);
            $this->session->set_userdata('tanggal_session_lapmengaji', $_POST['tanggal']);
            $this->session->set_userdata('sesi_session_lapmengaji', $_POST['sesi']);
            $this->session->set_userdata('ustadzah_session_lapmengaji', $_POST['id_ustadzah']);
        }

        $tahun = $this->session->userdata('tahun_session_lapmengaji');
        $tanggal = $this->session->userdata('tanggal_session_lapmengaji');
        $sesi = $this->session->userdata('sesi_session_lapmengaji');
        $id_ustadzah = $this->session->userdata('ustadzah_session_lapmengaji');

        if (empty($tahun)) {
            $tahun = Date('Y');
        }

        if (empty($tanggal)) {
            $tanggal = -1;
        }

        if (empty($sesi)) {
            $sesi = 0;
        }

        if (empty($id_ustadzah)) {
            $id_ustadzah = 0;
        }

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['list_tahun'] = $this->LaporanMengaji->getListTahun();
        $data['list_tanggal'] = $this->LaporanMengaji->getListTanggalByTahun($tahun);
        $data['list_sesi'] = $this->LaporanMengaji->getListSesi();
        $data['list_ustadzah'] = $this->LaporanMengaji->getListUstadzah($this->role);
        $data['tahun'] = $tahun;
        $data['tanggal'] = $tanggal;
        $data['sesi'] = $sesi;
        $data['id_ustadzah'] = $id_ustadzah;
        $data['nama_sesi'] = $this->getNamaByIdSesi($data['list_sesi'], $sesi);
        $data['nama_ustadzah'] = $this->getNamaByIdUstadzah($data['list_ustadzah'], $id_ustadzah);
        $data['hasil_mengaji'] = $this->LaporanMengaji->getHasilMengaji($this->role, $tahun, $tanggal, $sesi, $id_ustadzah);

		$this->load->view('inc/laporanmengaji/list', $data);
	}

    public function getNamaByIdSesi($data, $id_sesi) {
        foreach ($data as $item) {
            if ($item->id_sesi == $id_sesi) {
                return $item->nama;
            }
        }
        return null; // jika tidak ditemukan
    }

    public function getNamaByIdUstadzah($data, $id_ustadzah) {
        foreach ($data as $item) {
            if ($item->id == $id_ustadzah) {
                return $item->name;
            }
        }
        return null; // jika tidak ditemukan
    }

    function cetaklaporanmengaji(){
        $data = $this->data;

        $tahun = $_POST['tahun'];
        $tanggal = $_POST['tanggal'];
        $sesi = $_POST['sesi'];
        $id_ustadzah = $_POST['id_ustadzah'];

        $data['tahun'] = $tahun;
        $data['list_sesi'] = $this->LaporanMengaji->getListSesi();
        $data['nama_sesi'] = $this->getNamaByIdSesi($data['list_sesi'], $sesi);
        $data['list_ustadzah'] = $this->LaporanMengaji->getListUstadzah($this->role);
        $data['nama_ustadzah'] = $this->getNamaByIdUstadzah($data['list_ustadzah'], $id_ustadzah);
        $data['hasil_mengaji'] = $this->LaporanMengaji->getHasilMengaji($this->role, $tahun, $tanggal, $sesi, $id_ustadzah);
        $data['tanggal'] = $tanggal;

        $this->load->view('inc/laporanmengaji/cetak_absensi', $data);
    }

    public function getDataTanggal(){
        $tahun = $_POST['tahun'];

        $data = $this->LaporanMengaji->getListTanggalByTahun($tahun);
        if (!empty($data)) {
            $data_list = [];
            foreach ($data as $key => $value) {
                $value->nama_hari = format_date_indonesia($value->tanggal);
                $value->tanggal = date('d-m-Y', strtotime($value->tanggal));
                $data_list[] = $value;
            }
            $data['tanggal'] = $data_list;
        }else{
            $data['tanggal'] = [];
            $data['kelas'] = [];
        }

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;

    }
}
