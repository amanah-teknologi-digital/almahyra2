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
        $this->load->model('Mtematikbulan', 'TematikBulan');
        $this->load->model('Mdashboard', 'Dashboard');
    }

    public function index() {
        // print_r($data);die();
        if ($this->session->userdata['auth']->id_role == 4) {
            // orang tua
            $data = $this->data;
            $tanggal_sekarang = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
            $id_orangtua = $this->session->userdata['auth']->id;

            $data_anak = $this->Dashboard->getAnakByOrangtua($id_orangtua);
            if (!empty($data_anak)){
                $data['data_anak'] = $data_anak;
                $list_id_kelas = [];
                foreach ($data_anak as $anak){
                    if (empty($list_id_kelas) OR !in_array($anak->id_kelas, $list_id_kelas)){
                        $list_id_kelas[] = $anak->id_kelas;
                    }
                }

                $data['data_tema'] = $this->TematikBulan->getDataTema($tahun, $bulan);
                if (!empty($data['data_tema'])){
                    $data['data_subtema'] = $this->TematikBulan->getDataSubtema($data['data_tema']->id_temabulanan, $tanggal_sekarang);
                }else{
                    $data['data_subtema'] = [];
                }

                if (!empty($data['data_subtema'])){
                    $list_jadwalharian = $this->TematikBulan->getJadwalHarianById($data['data_subtema']->id_rincianjadwal_mingguan);
                    $list_jadwalstimulus = $this->TematikBulan->getJadwalStimulus($data['data_subtema']->id_rincianjadwal_mingguan);
                    $list_feedingmenu = $this->TematikBulan->getFeedingMenu($data['data_subtema']->id_rincianjadwal_mingguan);

                    $temp_jadwal_harian = [];
                    $temp_jadwal_stimulus = [];
                    $temp_feeding_menu = [];
                    foreach ($list_jadwalharian as $jadwal){
                        $temp_jadwal_harian[$jadwal->id_kelas][] = $jadwal;
                    }
                    foreach ($list_jadwalstimulus as $stimulus) {
                        $temp_jadwal_stimulus[$stimulus->id_kelas] = $stimulus;
                    }
                    foreach ($list_feedingmenu as $feeding) {
                        $temp_feeding_menu[$feeding->id_kelas] = $feeding;
                    }

                    $data['data_feeding_menu'] = $temp_feeding_menu;
                    $data['data_jadwal_harian'] = $temp_jadwal_harian;
                    $data['data_jadwal_stimulus'] = $temp_jadwal_stimulus;
                    $data['id_rincianjadwal_mingguan'] = $data['data_subtema']->id_rincianjadwal_mingguan;
                }else{
                    $data['data_feeding_menu'] = [];
                    $data['data_jadwal_harian'] = [];
                    $data['data_jadwal_stimulus'] = [];
                    $data['id_rincianjadwal_mingguan'] = '';
                }

            }else{
                $data['data_anak'] = [];
            }

            $this->load->view('inc/dashboard/user', $data);
        } else if ($this->session->userdata['auth']->id_role == 3) {
            // pengasuh

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
                $list_feedingmenu = $this->TematikBulan->getFeedingMenu($data['data_subtema']->id_rincianjadwal_mingguan);

                $temp_jadwal_harian = [];
                $temp_jadwal_stimulus = [];
                $temp_feeding_menu = [];
                foreach ($list_jadwalharian as $jadwal){
                    $temp_jadwal_harian[$jadwal->id_kelas][] = $jadwal;
                }
                foreach ($list_jadwalstimulus as $stimulus) {
                    $temp_jadwal_stimulus[$stimulus->id_kelas] = $stimulus;
                }
                foreach ($list_feedingmenu as $feeding) {
                    $temp_feeding_menu[$feeding->id_kelas] = $feeding;
                }

                $data['data_feeding_menu'] = $temp_feeding_menu;
                $data['data_jadwal_harian'] = $temp_jadwal_harian;
                $data['data_jadwal_stimulus'] = $temp_jadwal_stimulus;
                $data['id_rincianjadwal_mingguan'] = $data['data_subtema']->id_rincianjadwal_mingguan;
            }else{
                $data['data_feeding_menu'] = [];
                $data['data_jadwal_harian'] = [];
                $data['data_jadwal_stimulus'] = [];
                $data['id_rincianjadwal_mingguan'] = '';
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
                $list_feedingmenu = $this->TematikBulan->getFeedingMenu($data['data_subtema']->id_rincianjadwal_mingguan);

                $temp_jadwal_harian = [];
                $temp_jadwal_stimulus = [];
                $temp_feeding_menu = [];
                foreach ($list_jadwalharian as $jadwal){
                    $temp_jadwal_harian[$jadwal->id_kelas][] = $jadwal;
                }
                foreach ($list_jadwalstimulus as $stimulus) {
                    $temp_jadwal_stimulus[$stimulus->id_kelas] = $stimulus;
                }
                foreach ($list_feedingmenu as $feeding) {
                    $temp_feeding_menu[$feeding->id_kelas] = $feeding;
                }

                $data['data_feeding_menu'] = $temp_feeding_menu;
                $data['data_jadwal_harian'] = $temp_jadwal_harian;
                $data['data_jadwal_stimulus'] = $temp_jadwal_stimulus;
                $data['id_rincianjadwal_mingguan'] = $data['data_subtema']->id_rincianjadwal_mingguan;
            }else{
                $data['data_feeding_menu'] = [];
                $data['data_jadwal_harian'] = [];
                $data['data_jadwal_stimulus'] = [];
                $data['id_rincianjadwal_mingguan'] = '';
            }

            $this->load->view('inc/dashboard/admin', $data);
        }
        
    }

    public function cetakjadwalharian(){
        $data = $this->data;

        $list_jadwalharian = $this->TematikBulan->getJadwalHarianById($_POST['id_rincianjadwal_mingguan']);
        $list_jadwalstimulus = $this->TematikBulan->getJadwalStimulus($_POST['id_rincianjadwal_mingguan']);
        $list_feedingmenu = $this->TematikBulan->getFeedingMenu($_POST['id_rincianjadwal_mingguan']);

        $temp_jadwal_harian = [];
        $temp_jadwal_stimulus = [];
        $temp_feeding_menu = [];
        foreach ($list_jadwalharian as $jadwal){
            $temp_jadwal_harian[$jadwal->id_kelas][] = $jadwal;
        }
        foreach ($list_jadwalstimulus as $stimulus) {
            $temp_jadwal_stimulus[$stimulus->id_kelas] = $stimulus;
        }
        foreach ($list_feedingmenu as $feeding) {
            $temp_feeding_menu[$feeding->id_kelas] = $feeding;
        }

        $data['data_feeding_menu'] = $temp_feeding_menu;
        $data['data_jadwal_harian'] = $temp_jadwal_harian;
        $data['data_jadwal_stimulus'] = $temp_jadwal_stimulus;
        $data['id_rincianjadwal_mingguan'] = $_POST['id_rincianjadwal_mingguan'];
        $data['id_kelas'] = $_POST['id_kelas'];
        $data['data_kelas'] = $this->TematikBulan->getKelasById($_POST['id_kelas']);

        $this->load->view('inc/dashboard/cetak_jadwalharian', $data);
    }

}
