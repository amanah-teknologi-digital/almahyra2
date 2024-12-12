<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cjadwalharian extends CI_Controller {

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
            'controller'=>'cjadwalharian',
            'redirect'=>'jadwal-harian',
            'title'=>'Jadwal Harian',
            'parent'=>'rencana',
        );
		## load model here 
		$this->load->model('Mjadwalharian', 'JadwalHarian');
		$this->load->model('Mtematikbulan', 'TematikBulan');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_jadwalharian', $_POST['tahun']);
            $this->session->set_userdata('bulan_session_jadwalharian', $_POST['bulan']);
        }

        $tahun = $this->session->userdata('tahun_session_jadwalharian');
        $bulan = $this->session->userdata('bulan_session_jadwalharian');

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['tahun'] = $this->JadwalHarian->getListTahun();
        if (empty($tahun)) {
            foreach ($data['tahun'] as $key => $value) {
                if ($value->is_aktif == 1) {
                    $tahun = $value->tahun;
                }
            }
        }

        if (empty($tahun)){
            $tahun = 0;
        }

        $data['bulan'] = $this->JadwalHarian->getListBulan();
        if (empty($bulan)) {
            if (!empty($data['bulan'])) {
                $bulan = date('m');
            }else {
                $bulan = 0;
            }
        }

        $data_mingguan = $this->TematikBulan->getJadwalMingguanByTahun($tahun, $bulan);

        $data_subtema = [];
        $data_tanggal_pelaksana = [];
        $data_is_hapus = [];
        foreach ($data_mingguan as $subtema){
            if (!empty($data_subtema[$subtema->id_temabulanan])) {
                $temp_subtema = array_column($data_subtema[$subtema->id_temabulanan], 'id_jadwalmingguan');
            }else{
                $temp_subtema = [];
            }
            if (empty($data_subtema) OR !in_array($subtema->id_jadwalmingguan, $temp_subtema)){
                $data_subtema[$subtema->id_temabulanan][] = [
                    'id_jadwalmingguan' => $subtema->id_jadwalmingguan,
                    'nama_subtema' => $subtema->nama_subtema,
                    'keterangan' => $subtema->keterangan,
                ];
            }

            if (!empty($subtema->is_inputjadwalharian)){
                $data_is_hapus[$subtema->id_jadwalmingguan] = 1;
            }

            $data_tanggal_pelaksana[$subtema->id_jadwalmingguan][] = [
                'id_rincianjadwal_mingguan' => $subtema->id_rincianjadwal_mingguan,
                'tanggal' => $subtema->tanggal,
                'is_inputjadwalharian' => $subtema->is_inputjadwalharian,
                'created_at' => $subtema->created_at,
                'updated_at' => $subtema->updated_at,
                'nama_user' => $subtema->nama_user,
                'nama_role' => $subtema->nama_role,
            ];
        }

        $data['data_bulan'] = $this->JadwalHarian->getAllBulanByTahun($tahun, $bulan);

        $data['tahun_selected'] = $tahun;
        $data['bulan_selected'] = $bulan;
        $data['data_subtema'] = $data_subtema;
        $data['data_mingguan'] = $data_tanggal_pelaksana;

		$this->load->view('inc/jadwalharian/list', $data);
	}

    public function lihatjadwalharian($tahun, $id_rincianjadwal_mingguan){
        $bulan = $this->TematikBulan->getBulanByIdRincianJadwal($id_rincianjadwal_mingguan);
        $this->session->set_userdata('active_accordion_bulan', $bulan);
        $data = $this->data;
        $data['tahun_tematik'] = $tahun;
        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['data_rincianjadwal_mingguan'] = $this->TematikBulan->getRincianJadwalMingguanById($id_rincianjadwal_mingguan);
        $data['data_subtema'] = $this->TematikBulan->getJadwalMingguanById($data['data_rincianjadwal_mingguan']->id_jadwalmingguan);
        $data['data_kelas'] = $this->TematikBulan->getKelas();
        $list_jadwalharian = $this->TematikBulan->getJadwalHarianById($id_rincianjadwal_mingguan);
        $list_jadwalstimulus = $this->TematikBulan->getJadwalStimulus($id_rincianjadwal_mingguan);
        $data_template_jadwal = $this->TematikBulan->getTemplateJadwal();
        $data_template_stimulus = $this->TematikBulan->getTemplateStimulus();
        $data['data_template_jadwal'] = $data_template_jadwal;
        $data['data_template_stimulus'] = $data_template_stimulus;

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
        $data['active_tab_kelas'] = empty($this->active_tab_kelas)? 0 : $this->active_tab_kelas;

        $this->load->view('inc/jadwalharian/lihat_dataharian', $data);
    }

    public function insertkegiatan() {
        try {
            $this->TematikBulan->insertKegiatan();

            $this->session->set_flashdata('success', 'Berhasil Tambah Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Tambah Data: ' . $e->getMessage());
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
    }

    public function updatekegiatan() {
        try {
            $this->TematikBulan->updateKegiatan();

            $this->session->set_flashdata('success', 'Berhasil Update Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Update Data: ' . $e->getMessage());
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
    }

    public function editkegiatan($id) {
        $data = $this->data;
        $data['list_edit'] = $this->TematikBulan->getJadwalKegiatanHarianById($id) ;

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function hapuskegiatan() {
        try {
            $this->TematikBulan->hapusKegiatan($_POST['id_rincianjadwal_harian']);

            $this->session->set_flashdata('success', 'Berhasil Hapus Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Hapus Data: ' . $e->getMessage());
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
    }

    public function simpanstimulus() {
        try {
            $this->TematikBulan->simpanStimulus($_POST['id_kelas']);

            $this->session->set_flashdata('success', 'Berhasil Simpan Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Simpan Data: ' . $e->getMessage());
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
    }

    public function gettemplatejadwal($id_templatejadwal){
        $data = $this->TematikBulan->getTemplateJadwalById($id_templatejadwal);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data));

    }

    public function gettemplatestimulus($id_templatestimulus){
        $data = $this->TematikBulan->getTemplateStimulusById($id_templatestimulus);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data));

    }

    public function terapkantemplatejadwal(){
        try {
            $this->TematikBulan->terapkanTemplateJadwal();

            $this->session->set_flashdata('success', 'Berhasil Menerapkan Data');
        } catch (Exception $e) {
            $this->session->set_flashdata('failed', 'Gagal Menerapkan Data: ' . $e->getMessage());
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
    }
}
