<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claporan extends CI_Controller {

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
            'controller'=>'claporan',
            'redirect'=>'laporan',
            'title'=>'Tumbuh Kembang',
            'parent'=>'laporan'
        );
        ## load model here 
        $this->load->model('Mobservasitumbuh', 'Observasitumbuh');
        $this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mobservasizona', 'Observasizona');
        $this->load->model('Mpembayarantagihan', 'Pembayarantagihan');
        $this->load->model('Mabsensiitemsitem', 'Absensiitemsitem');
        $this->load->model('Mobservasikembang', 'ObservasiKembang');
        $this->load->model('Maktivitas', 'Maktivitas');
        $this->load->model('Mpengguna', 'Mpengguna');
        
    }

    
    public function tumbuhkembangf() {   

        $data = $this->data;

        $data['list'] = $this->RegisterAnak->getAll();

        $this->load->view('inc/laporan/tumbuhkembang_f', $data);
    }

    public function tumbuhkembangrpp($id) {   

        $data = $this->data;

        $data['anak'] = $this->RegisterAnak->getDetails($id);

        $data['zona'] = $this->Observasizona->getByID($id);

        $data['observasi'] = $this->Observasitumbuh->getReportObservasi($id);

        $tahun = date('Y');

        $bulan = date('m');

        $data['bulan'] = 12 + $bulan - date('m', strtotime($data['anak']->tanggal_lahir));
        
        $data['tahun'] = $tahun - date('Y', strtotime($data['anak']->tanggal_lahir));

        $this->load->view('inc/laporan/tumbuhkembang_rpp', $data);
    }

    public function pembayaranf() {   

        $data = $this->data;

        $data['title'] = 'Pembayaran';

        $data['list'] = $this->RegisterAnak->getAll();
        
        $this->load->view('inc/laporan/pembayaran_f', $data);
    }

    public function pembayaranrpp($id) {   

        $data = $this->data;

        $data['anak'] = $this->RegisterAnak->getDetails($id);
        
        $data['rincian'] = $this->Pembayarantagihan->getByIDanakSum($id); 

        $data['riwayat'] = $this->Pembayarantagihan->getByIDanak($id); 

        $data['id'] = $id;
        
        $this->load->view('inc/laporan/pembayaran_rpp', $data);
    }

    public function pembayaranrincian() {   

        $data = $this->data;

        $data['list_tagihan'] = $this->Pembayarantagihan->getByIDanakDetail($this->input->post('id_anak'), $this->input->post('tanggal')) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
        
    }

    public function harianf() {   

        $data = $this->data;

        $data['list'] = $this->RegisterAnak->getAll();

        $this->load->view('inc/laporan/harian_f', $data);
    }

    public function harianrppform() {   

        $data = $this->data;
        
        if (empty($this->input->post('tanggal'))) {
            redirect('laporan-harian');
        }
        
        $id = $this->input->post('id');

        $data['anak'] = $this->RegisterAnak->getDetails($id);

        $data['zona'] = $this->Observasizona->getByID($id);

        $data['list_items'] = $this->Absensiitemsitem->getAllbyIdanak($id) ;
        
        $data['aktivitas'] = $this->Maktivitas->getByIDanaktanggal($id) ;

        $data['observasi'] = $this->Observasitumbuh->getReportObservasiSingle($id);

        $data['list_kembang'] = $this->ObservasiKembang->getByIDanakSingle($id) ;

        $data['kepala_sekolah'] = $this->Mpengguna->getAllKepalaSekolah() ;

        // print_r($data);die();

        $this->load->view('inc/laporan/harian_full', $data);
        
    }

    public function harianrpp($id) {   

        $data = $this->data;

        $data['anak'] = $this->RegisterAnak->getDetails($id);

        $data['zona'] = $this->Observasizona->getByID($id);

        $data['list_items'] = $this->Absensiitemsitem->getAllbyIdanak($id) ;
        
        $data['aktivitas'] = $this->Maktivitas->getByIDanaktanggal($id) ;

        $data['observasi'] = $this->Observasitumbuh->getReportObservasiSingle($id);

        $data['list_kembang'] = $this->ObservasiKembang->getByIDanakSingle($id) ;

        $data['kepala_sekolah'] = $this->Mpengguna->getAllKepalaSekolah() ;

        // print_r($data);die();

        $this->load->view('inc/laporan/harian_full', $data);
        
    }


}
