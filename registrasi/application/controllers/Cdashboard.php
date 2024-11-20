<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require 'vendor/phpspreadsheet/autoload.php';

class CDashboard extends CI_Controller {
    function __construct() {
        parent::__construct();

        if (empty($this->session->userdata['auth'])) {
            $this->session->set_flashdata('failed', 'Anda Harus Login');

            redirect('login');
        } 

        $this->data = array(
            'controller'=>'cdashboard',
            'redirect'=>'dahsboard',
            'title'=>'Dahsboard',
            'parent'=>'dashboard'
        );

        ## load model here 
        $this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mobservasizona', 'Observasizona');
        $this->load->model('Mregisterpengasuh', 'RegisterPengasuh');
        $this->load->model('MTematikBulan', 'TematikBulan');
    }

    public function index() {
        // print_r($data);die();
        if ($this->session->userdata['auth']->id_role == 4) {
            // orang tua
            $data = $this->data;

            $tahun = date('Y');

            $bulan = date('m');

            $data['detail_anak'] = [];

            $data['detail_pengasuh'] = [];

            $data['anak'] = $this->RegisterAnak->getByIDorangtua($this->session->userdata['auth']->id);

            $data['pengasuh'] = $this->RegisterPengasuh->getByIDorangtua($this->session->userdata['auth']->id);

            // print_r($data['anak']);die ;

            if(!empty($data['anak'])) {
                foreach ($data['anak'] as $key => $a) {
                    // print_r($a);die ;
                    $temp = $this->RegisterAnak->getDetails($a->id);
                    if(!empty($temp)) {
                        $data['detail_anak'][$key] = $temp;
                    }

                }

            }

            if(!empty($data['pengasuh'])) {
                foreach ($data['pengasuh'] as $key => $a) {
                    // print_r($a);die ;
                    $temp = $this->RegisterPengasuh->getDetails($a->id);
                    if(!empty($temp)) {
                        $data['detail_pengasuh'][$key] = $temp;
                    }

                }

            }

            if(!empty($data['detail_anak'])) {
                foreach ($data['detail_anak'] as $key => $da) {
                    // print_r($da);die();
                    $data['detail_anak'][$key]->bulan = 12 + $bulan - date('m', strtotime($da->tanggal_lahir));
                    $data['detail_anak'][$key]->tahun = $tahun - date('Y', strtotime($da->tanggal_lahir));

                    $now = date('Y-m-d');

                    $tgl1 = new DateTime($da->tanggal_lahir);
                    $tgl2 = new DateTime($now);
                    $jarak = $tgl2->diff($tgl1);

                    $data['detail_anak'][$key]->bulan = $jarak->m;
                    $data['detail_anak'][$key]->tahun = $jarak->y;
                    $data['detail_anak'][$key]->hari = $jarak->d;

//                $zona = $this->Observasizona->getByID($da->id);
//                var_dump($zona);exit();
                    $data['detail_anak'][$key]->zona = null;
                    $data['detail_anak'][$key]->pengajar = null;

                }
            }

            if(!empty($data['detail_pengasuh'])) {
                foreach ($data['detail_pengasuh'] as $key => $da) {
                    // print_r($da);die();
                    //$data['detail_pengash'][$key]->bulan = 12 + $bulan - date('m', strtotime($da->tanggal_lahir));
                    $data['detail_pengasuh'][$key]->tahun = $tahun - date('Y', strtotime($da->tanggal_lahir));

                    $now = date('Y-m-d');

                    $tgl1 = new DateTime($da->tanggal_lahir);
                    $tgl2 = new DateTime($now);
                    $jarak = $tgl2->diff($tgl1);

                    $data['detail_pengasuh'][$key]->bulan = $jarak->m;
                    $data['detail_pengasuh'][$key]->tahun = $jarak->y;
                    $data['detail_pengasuh'][$key]->hari = $jarak->d;

                }
            }
            $this->load->view('inc/dashboard/user', $data);
        } else if ($this->session->userdata['auth']->id_role == 3) {
            // pengasuh

            $data = $this->data;

            $tahun = date('Y');

            $bulan = date('m');

            $data['detail_anak'] = [];

            $data['detail_pengasuh'] = [];

            $data['anak'] = $this->RegisterAnak->getByIDorangtua($this->session->userdata['auth']->id);

            $data['pengasuh'] = $this->RegisterPengasuh->getByIDorangtua($this->session->userdata['auth']->id);

            // print_r($data['anak']);die ;

            if(!empty($data['anak'])) {
                foreach ($data['anak'] as $key => $a) {
                    // print_r($a);die ;
                    $temp = $this->RegisterAnak->getDetails($a->id);
                    if(!empty($temp)) {
                        $data['detail_anak'][$key] = $temp;
                    }

                }

            }

            if(!empty($data['pengasuh'])) {
                foreach ($data['pengasuh'] as $key => $a) {
                    // print_r($a);die ;
                    $temp = $this->RegisterPengasuh->getDetails($a->id);
                    if(!empty($temp)) {
                        $data['detail_pengasuh'][$key] = $temp;
                    }

                }

            }

            if(!empty($data['detail_anak'])) {
                foreach ($data['detail_anak'] as $key => $da) {
                    // print_r($da);die();
                    $data['detail_anak'][$key]->bulan = 12 + $bulan - date('m', strtotime($da->tanggal_lahir));
                    $data['detail_anak'][$key]->tahun = $tahun - date('Y', strtotime($da->tanggal_lahir));

                    $now = date('Y-m-d');

                    $tgl1 = new DateTime($da->tanggal_lahir);
                    $tgl2 = new DateTime($now);
                    $jarak = $tgl2->diff($tgl1);

                    $data['detail_anak'][$key]->bulan = $jarak->m;
                    $data['detail_anak'][$key]->tahun = $jarak->y;
                    $data['detail_anak'][$key]->hari = $jarak->d;

//                $zona = $this->Observasizona->getByID($da->id);
//                var_dump($zona);exit();
                    $data['detail_anak'][$key]->zona = null;
                    $data['detail_anak'][$key]->pengajar = null;

                }
            }

            if(!empty($data['detail_pengasuh'])) {
                foreach ($data['detail_pengasuh'] as $key => $da) {
                    // print_r($da);die();
                    //$data['detail_pengash'][$key]->bulan = 12 + $bulan - date('m', strtotime($da->tanggal_lahir));
                    $data['detail_pengasuh'][$key]->tahun = $tahun - date('Y', strtotime($da->tanggal_lahir));

                    $now = date('Y-m-d');

                    $tgl1 = new DateTime($da->tanggal_lahir);
                    $tgl2 = new DateTime($now);
                    $jarak = $tgl2->diff($tgl1);

                    $data['detail_pengasuh'][$key]->bulan = $jarak->m;
                    $data['detail_pengasuh'][$key]->tahun = $jarak->y;
                    $data['detail_pengasuh'][$key]->hari = $jarak->d;

                }
            }

            $this->load->view('inc/dashboard/pengasuh', $data);
        } else {
            $data = $this->data;
            $tanggal_sekarang = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');

            $data['data_kelas'] = $this->TematikBulan->getKelas();
            $data['data_tema'] = $this->TematikBulan->getDataTema($tahun, $bulan);
            if (!empty($data['data_tema'])){
                $data['data_subtema'] = $this->TematikBulan->getDataSubtema($data['data_tema']->id_temabulanan, $tanggal_sekarang);
            }else{
                $data['data_subtema'] = [];
            }

            if (!empty($data['data_subtema'])){
                $list_jadwalharian = $this->TematikBulan->getJadwalHarianById($data['data_subtema']->id_rincianjadwal_mingguan);
                $list_jadwalstimulus = $this->TematikBulan->getJadwalStimulus($data['data_subtema']->id_rincianjadwal_mingguan);
                $temp_jadwal_harian = [];
                $temp_jadwal_stimulus = [];
                foreach ($list_jadwalharian as $jadwal){
                    $temp_jadwal_harian[$jadwal->id_kelas][] = $jadwal;
                }
                foreach ($list_jadwalstimulus as $stimulus) {
                    $temp_jadwal_stimulus[$stimulus->id_kelas] = $stimulus;
                }

                $data['data_jadwal_harian'] = $temp_jadwal_harian;
                $data['data_jadwal_stimulus'] = $temp_jadwal_stimulus;
                $data['id_rincianjadwal_mingguan'] = $data['data_subtema']->id_rincianjadwal_mingguan;
            }else{
                $data['data_jadwal_harian'] = [];
                $data['data_jadwal_stimulus'] = [];
                $data['id_rincianjadwal_mingguan'] = '';
            }

            $data['view_jadwal'] = 'inc/laporan/harian_full';

            $this->load->view('inc/dashboard/admin', $data);
        }
        
    }

    public function cetakjadwalharian(){
        var_dump($_POST);exit();
    }

}
