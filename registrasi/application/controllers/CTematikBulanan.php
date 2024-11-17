<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CTematikBulanan extends CI_Controller {

	var $data = array();
    var $active_accordion_bulan = 0;
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

		## load model here 
		$this->load->model('MTematikbulan', 'TematikBulan');
		$this->load->model('MTahun', 'Tahun');
	}

	public function index()	{	

		$data = $this->data;

		$data['list'] = $this->TematikBulan->getAll();
		$data['column'] = $this->TematikBulan->getColumn();
        $this->session->unset_userdata('active_accordion_bulan');

		$this->load->view('inc/tematikbulan/list', $data);
	}

    public function lihatdata($tahun){
        $data = $this->data;

        $data['tema_tahun'] = $this->Tahun->getByID($tahun);
        $data['list_bulan'] = $this->TematikBulan->getAllBulanByTahun($tahun);
        $data_mingguan = $this->TematikBulan->getJadwalMingguanByTahun($tahun);
        $data_tanggal_disabled = $this->TematikBulan->getTanggalSelected($tahun);
        $data_tanggal_disabled = array_column($data_tanggal_disabled, 'tanggal');

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

    public function lihatsubtema($tahun, $id_jadwalmingguan){
        $data = $this->data;
        $data['tahun_tematik'] = $tahun;
        $data['id_jadwalmingguan'] = $id_jadwalmingguan;
        $this->load->view('inc/tematikbulan/lihat_datasubtema', $data);
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
}
