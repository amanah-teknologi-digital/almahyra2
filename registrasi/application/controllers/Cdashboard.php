<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require 'vendor/phpspreadsheet/autoload.php';

class CDashboard extends CI_Controller {
    private $role;
    function __construct() {
        parent::__construct();

        if (empty($this->session->userdata['auth'])) {
            $this->session->set_flashdata('failed', 'Anda Harus Login');

            redirect('login');
        }

        if ($this->session->userdata['auth']->id_role == 5) { // absensi
            redirect('absensi-anak');
        }

        $this->role = $this->session->userdata['auth']->id_role;

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

            $data['list_anak'] = $this->Dashboard->getListAnak($this->role);
            if (!empty($data['list_anak'])) {
                $data['id_anak'] = $data['list_anak'][0]->id;
            }else{
                $data['id_anak'] = 0;
            }

            $this->load->view('inc/dashboard/user', $data);
        }elseif ($this->session->userdata['auth']->id_role == 6) { //medical checkup
            $data = $this->data;
            $data['parent'] = 'checkup';
            $data['list_anak'] = $this->Dashboard->getListAnak($this->role);
            if (!empty($data['list_anak'])) {
                $data['id_anak'] = $data['list_anak'][0]->id;
            }else{
                $data['id_anak'] = 0;
            }

            $this->load->view('inc/dashboard/medic', $data);
        }elseif ($this->session->userdata['auth']->id_role == 7) { //ustadzah
            $data = $this->data;
            $data['parent'] = 'mengaji';
            $data['list_anak'] = $this->Dashboard->getListAnak($this->role);
            $data['list_jilid'] = $this->Dashboard->getListJilid();
            if (!empty($data['list_anak'])) {
                $data['id_anak'] = $data['list_anak'][0]->id;
            }else{
                $data['id_anak'] = 0;
            }

            $this->load->view('inc/dashboard/ustadzah', $data);
        }elseif ($this->session->userdata['auth']->id_role == 8) { //kepala tpq
            $data = $this->data;
            $data['parent'] = 'mengaji';
            $data['list_anak'] = $this->Dashboard->getListAnak($this->role);
            $data['list_jilid'] = $this->Dashboard->getListJilid();
            if (!empty($data['list_anak'])) {
                $data['id_anak'] = $data['list_anak'][0]->id;
            }else{
                $data['id_anak'] = 0;
            }

            $this->load->view('inc/dashboard/ustadzah', $data);
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

            $data['list_anak'] = $this->Dashboard->getListAnak($this->role);
            if (!empty($data['list_anak'])) {
                $data['id_anak'] = $data['list_anak'][0]->id;
            }else{
                $data['id_anak'] = 0;
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

            $data['list_anak'] = $this->Dashboard->getListAnak($this->role);
            if (!empty($data['list_anak'])) {
                $data['id_anak'] = $data['list_anak'][0]->id;
            }else{
                $data['id_anak'] = 0;
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

    public function getDataMedicalCheckup($id_anak){
        $data_medic = $this->Dashboard->getDataMedicalCheckup($id_anak);

        $data_form = [];
        $data_inside_from = [];

        $color = [1=>'#FF0000', 2=>'#00FF00', 3=>'#0000FF', 4=>'#FFFF00'];
        $dom = [1=>'chart_bb', 2=>'chart_tb', 3=>'chart_lila', 4=>'chart_lk'];
        $nama_kolom = [1=>'Berat Badan', 2=>'Tinggi Badan', 3=>'Lingkar Lengan', 4=>'Lingkar Kepala'];

        foreach ($data_medic as $medic){
            $temp_id_form = array_column($data_form, 'id_formmedical');
            if (empty($data_form) OR !in_array($medic->id_formmedical, $temp_id_form)){
                $data_form[] =[
                    'id_formmedical' => $medic->id_formmedical,
                    'nama_form' => $medic->nama_kolom,
                    'satuan' => $medic->satuan,
                    'color' => $color[$medic->id_formmedical],
                    'dom' => $dom[$medic->id_formmedical]
                ];
            }

            $data_inside_from[$medic->id_formmedical][] = [
                'tanggal' => $medic->tanggal,
                'nilai' => $medic->nilai,
                'satuan' => $medic->satuan
            ];
        }

        foreach ($data_form as $key => $form){
            $data_form[$key]['data'] = $data_inside_from[$form['id_formmedical']];
        }

        if (empty($data_form)){
            foreach ($color as $key => $col){
                $data_form[] =[
                    'id_formmedical' => $key,
                    'nama_form' => $nama_kolom[$key],
                    'satuan' => '',
                    'color' => $col,
                    'dom' => $dom[$key],
                    'data' => []
                ];
            }
        }

        $data = $data_form;

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function getDataCatatanMengaji($id_anak){
        $data_mengaji = $this->Dashboard->getDataCatatanMengaji($id_anak);
        $list_jilid = $this->Dashboard->getListJilid();

        foreach ($data_mengaji as $mengaji){
            $data_graph[$mengaji->id_jilidmengaji][] = [
                'tanggal' => $mengaji->tanggal,
                'halaman' => $mengaji->halaman_tertinggi,
            ];
        }

        foreach ($list_jilid as $jilid){
            if (empty($data_graph[$jilid->id_jilidmengaji])){
                $data_graph[$jilid->id_jilidmengaji] = [];
            }

            $data_final[] = [
                'dom' => 'graph_'.$jilid->id_jilidmengaji,
                'color' => $jilid->color,
                'nama_form' => $jilid->nama,
                'data' => $data_graph[$jilid->id_jilidmengaji]
            ];
        }

        $data = $data_final;

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

}
