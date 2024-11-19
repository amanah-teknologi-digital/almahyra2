<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CTematikBulanan extends CI_Controller {

	var $data = array();
    var $active_accordion_bulan = 0;
    var $active_tab_kelas = 0;
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
            'controller'=>'ctematikbulanan',
            'redirect'=>'tematik-bulanan',
            'title'=>'Tematik Bulanan',
            'parent'=>'rencana'
        );

        $this->active_accordion_bulan = $this->session->userdata('active_accordion_bulan');
        $this->active_tab_kelas = $this->session->userdata('active_tab_kelas');

		## load model here 
		$this->load->model('MTematikbulan', 'TematikBulan');
		$this->load->model('MTahun', 'Tahun');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->TematikBulan->getAll();
		$data['column'] = $this->TematikBulan->getColumn();
        $this->session->unset_userdata('active_accordion_bulan');
        $this->session->unset_userdata('active_tab_kelas');

		$this->load->view('inc/tematikbulan/list', $data);
	}

    public function lihatdata($tahun){
        $data = $this->data;

        $data['tema_tahun'] = $this->Tahun->getByID($tahun);
        $data['list_bulan'] = $this->TematikBulan->getAllBulanByTahun($tahun);
        $data_mingguan = $this->TematikBulan->getJadwalMingguanByTahun($tahun);
        $data_tanggal_disabled = $this->TematikBulan->getTanggalSelected($tahun);
        $data_tanggal_disabled = array_column($data_tanggal_disabled, 'tanggal');
        $this->session->unset_userdata('active_tab_kelas');

        $data_subtema = [];
        $data_tanggal_pelaksana = [];
        $data_is_hapus = [];
        foreach ($data_mingguan as $subtema){
            if (!empty($data_subtema)) {
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

        $data['tahun_tematik'] = $tahun;
        $data['data_subtema'] = $data_subtema;
        $data['data_mingguan'] = $data_tanggal_pelaksana;
        $data['data_tanggal_disabled'] = $data_tanggal_disabled;
        $data['data_is_hapus'] = $data_is_hapus;
        $data['active_accordion_bulan'] = empty($this->active_accordion_bulan)? 0 : $this->active_accordion_bulan;

        $this->load->view('inc/tematikbulan/lihat_data', $data);
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

        $this->load->view('inc/tematikbulan/lihat_dataharian', $data);
    }

	public function insert() {
		$err = $this->TematikBulan->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan']);
	}

    public function insertsubtema() {
		$err = $this->TematikBulan->insertSubTema();
        $bulan = $this->TematikBulan->getBulanBySubTema($_POST['id_temabulanan']);
        $this->session->set_userdata('active_accordion_bulan', $bulan);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        }

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan']);
	}

    public function insertkegiatan() {
		$err = $this->TematikBulan->insertKegiatan();
        $this->session->set_userdata('active_tab_kelas', $_POST['id_kelas']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        }

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
	}

    public function updatekegiatan() {
		$err = $this->TematikBulan->updateKegiatan();
        $this->session->set_userdata('active_tab_kelas', $_POST['id_kelas']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        }

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
	}

    public function updatesubtema() {
		$err = $this->TematikBulan->updateSubTema();
        $bulan = $this->TematikBulan->getBulanByIdJadwalMingguan($_POST['id_jadwalmingguan']);
        $this->session->set_userdata('active_accordion_bulan', $bulan);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Mengupdate Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Mengupdate Data');
        }

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->TematikBulan->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

    public function editsubtema($id) {
		$data = $this->data;

		$data['list_edit'] = $this->TematikBulan->getJadwalMingguanById($id) ;
        $tahun = $this->TematikBulan->getTahunByIdJadwalMingguan($id);
		$data_tanggal = $this->TematikBulan->getTanggalJadwalMingguan($id) ;
        $data_tanggal_disabled = $this->TematikBulan->getTanggalSelectedExcludeIdMingguan($tahun, $id);
        $data_tanggal_disabled = array_column($data_tanggal_disabled, 'tanggal');
        $data['data_tanggal_disabled'] = $data_tanggal_disabled;
        $data['list_jadwal_noneditable'] = [];
        $data['list_jadwal_editable'] = [];

        foreach ($data_tanggal as $tgl){
            if (empty($tgl->is_inputjadwalharian)){
                $data['list_jadwal_editable'][] = $tgl->tanggal;
            }else{
                $data['list_jadwal_noneditable'][] = $tgl->tanggal;
            }
        }

	    $this->output->set_content_type('application/json');

	    $this->output->set_output(json_encode($data));

	    return $data;
	}

    public function editkegiatan($id) {
		$data = $this->data;
        $data['list_edit'] = $this->TematikBulan->getJadwalKegiatanHarianById($id) ;

	    $this->output->set_content_type('application/json');

	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->TematikBulan->update($this->input->post('id_temabulanan'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan']);
	}

	public function hapussubtema() {
        $bulan = $this->TematikBulan->getBulanByIdJadwalMingguan($_POST['id_jadwalmingguan']);
        $err = $this->TematikBulan->hapusSubTema($_POST['id_jadwalmingguan']);
        $this->session->set_userdata('active_accordion_bulan', $bulan);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan']);
	}

    public function hapuskegiatan() {
        $err = $this->TematikBulan->hapusKegiatan($_POST['id_rincianjadwal_harian']);
        $this->session->set_userdata('active_tab_kelas', $_POST['id_kelas']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
	}

    public function simpanstimulus() {
        $err = $this->TematikBulan->simpanStimulus($_POST['id_kelas']);
        $this->session->set_userdata('active_tab_kelas', $_POST['id_kelas']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menyimpan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menyimpan Data');
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
        $err = $this->TematikBulan->terapkanTemplateJadwal();
        $this->session->set_userdata('active_tab_kelas', $_POST['id_kelas']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menerapkan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menerapkan Data');
        }

        redirect($this->data['redirect'].'/'.$_POST['tahun_penentuan'].'/jadwalharian/'.$_POST['id_rincianjadwal_mingguan']);
    }
}
