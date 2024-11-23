<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CaktivitasHarian extends CI_Controller {

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
            'controller'=>'caktivitasharian',
            'redirect'=>'aktivitas-harian',
            'title'=>'Aktivitas Harian',
            'parent'=>'absensi'
        );
		## load model here 
		$this->load->model('MaktivitasHarian', 'AktivitasHarian');
	}

	public function index()	{	

		$data = $this->data;
        $data['tahun'] = $this->AktivitasHarian->getListTahun();
        foreach ($data['tahun'] as $key => $value) {
            if ($value->is_aktif == 1) {
                $tahun = $value->tahun;
            }
        }

        $data['tanggal'] = $this->AktivitasHarian->getListTanggalByTahun($tahun);
        $id_rincianjadwal_mingguan = $data['tanggal'][0]->id_rincianjadwal_mingguan;
        $data['kelas'] = $this->AktivitasHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);
        if (!empty($data['kelas'])) {
            $data['aktivitas'] = $this->AktivitasHarian->getAktivitasHarianByIdJadwal($data['kelas'][0]->id_jadwalharian);
            $data['jumlah_kegiatan'] = $this->AktivitasHarian->getJumlahKegiatan($data['kelas'][0]->id_jadwalharian);
            $data['id_jadwalharian'] = $data['kelas'][0]->id_jadwalharian;
        }else{
            $data['aktivitas'] = [];
            $data['jumlah_kegiatan'] = 0;
            $data['id_jadwalharian'] = 0;
        }

		$data['column'] = $this->AktivitasHarian->getColumn();

		$this->load->view('inc/aktivitasharian/list', $data);
	}

    public function checkAktivitas(){
        $id_jadwalharian = $this->input->post('id_jadwalharian');
        $id_anak = $this->input->post('id_anak');

        $id_aktivitas  = $this->AktivitasHarian->checkAktivitas($id_jadwalharian, $id_anak);

        redirect($this->data['redirect'].'/lihat-data/'.$id_aktivitas);
    }

    public function lihatAktivitas($id_aktivitas){
        $data = $this->data;
        $data['data_subtema'] = $this->AktivitasHarian->getDataSubtemaByAktivitas($id_aktivitas);
        $id_rincianjadwal_mingguan = $data['data_subtema']->id_rincianjadwal_mingguan;
        $data['id_aktivitas'] = $id_aktivitas;
        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['list_kegiatan'] = $this->AktivitasHarian->getKegiatanByAktivitas($id_aktivitas);
        $data['data_stimulus'] = $this->AktivitasHarian->getDataStimulusByAktivitas($id_aktivitas);
        $data['capaian_indikator'] = $this->AktivitasHarian->getDataCapaianIndikator($id_aktivitas);
        $data['data_anak'] = $this->AktivitasHarian->getDataAnakByAktivitas($id_aktivitas);

        $this->load->view('inc/aktivitasharian/lihat_data', $data);
    }

    public function simpan(){
        $err = $this->AktivitasHarian->simpanAktivitas($_POST['id_aktivitas']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menyimpan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menyimpan Data');
        }

        redirect($this->data['redirect'].'/lihat-data/'.$_POST['id_aktivitas']);
    }

	public function insert() {
		
		$err = $this->Tahun->insert();

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
		}

		redirect($this->data['redirect']);
	}

	public function edit($id) {
		$data = $this->data;

		$data['list_edit'] = $this->Tahun->getByID($id) ;

	    $this->output->set_content_type('application/json');
	    
	    $this->output->set_output(json_encode($data));

	    return $data;
	}

	public function update() {
		$err = $this->Tahun->update($this->input->post('id'));

		if ($err['code'] == '0') {
			$this->session->set_flashdata('success', 'Berhasil Merubah Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Merubah Data');
		}	

		redirect($this->data['redirect']);
	}

	public function delete($id) {
		$err = $this->Tahun->delete($id);

		if ($err > 0) {
			$this->session->set_flashdata('success', 'Berhasil Menghapus Data');
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data, Data Digunakan');
		}	

		redirect($this->data['redirect']);
	}
}
