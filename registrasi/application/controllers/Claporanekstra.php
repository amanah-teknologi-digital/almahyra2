<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claporanekstra extends CI_Controller {

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

        if ($this->role == 9) {
            $parent = 'ekstra';
        }else{
            $parent = 'laporan';
        }

		$this->data = array(
            'controller'=>'claporanekstra',
            'redirect'=>'laporan-ekstrakulikuler',
            'title'=>'Laporan Ekstrakulikuler',
            'parent'=>$parent,
        );
		## load model here 
		$this->load->model('Mlaporanekstra', 'LaporanEkstra');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('ekstra_session_lapekstra', $_POST['ekstra']);
            $this->session->set_userdata('anak_session_lapekstra', $_POST['anak']);
            $this->session->set_userdata('tanggal_session_lapekstra', $_POST['tanggal']);
        }

        $id_ekstra = $this->session->userdata('ekstra_session_lapekstra');
        $id_anak = $this->session->userdata('anak_session_lapekstra');
        $tanggal = $this->session->userdata('tanggal_session_lapekstra');

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['list_ekstra'] = $this->LaporanEkstra->getListEsktra($this->role);
        if (!empty($id_ekstra)){
            $data['list_anak'] = $this->LaporanEkstra->getListAnak($id_ekstra, $this->role);
        }else{
            $data['list_anak'] = [];
        }

        if (!empty($id_anak) && !empty($id_ekstra)) {
            $data['list_tanggal'] = $this->LaporanEkstra->getListTanggalByAnak($id_ekstra, $id_anak);
        } else {
            $data['list_tanggal'] = [];
        }

        $data['tanggal'] = $tanggal;
        $data['anak'] = $id_anak;
        $data['ekstra'] = $id_ekstra;
        $data['id_role'] = $this->role;
        $data['nama_ekstra'] = $this->getNamaByIdEkstra($data['list_ekstra'], $id_ekstra);
        if (!empty($id_ekstra) && !empty($tanggal) && !empty($id_anak)) {
            $data['hasil_ekstra'] = $this->LaporanEkstra->getHasilEkstra($this->role, $id_ekstra, $id_anak, $tanggal);
        }else{
            $data['hasil_ekstra'] = [];
        }

		$this->load->view('inc/laporanekstra/list', $data);
	}

    public function getNamaByIdEkstra($data, $id_ekstra) {
        foreach ($data as $item) {
            if ($item->id_ekstra == $id_ekstra) {
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

    function getfile($id_catatan){
        $data_file = $this->LaporanMengaji->getLaporanMengajiFile($id_catatan);

        $data['preview'] = $data['config'] = [];
        foreach ($data_file as $row){
            $fileId = $row->id_file; // some unique key to identify the file
            $data['preview'][] = base_url().$row->download_url;
            $data['config'][] = [
                'key' => $fileId,
                'caption' => $row->file_name,
                'size' => $row->size,
                'downloadUrl' => base_url().$row->download_url, // the url to download the file
            ];
        }

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }
}
