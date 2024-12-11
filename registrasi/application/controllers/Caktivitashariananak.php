<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caktivitashariananak extends CI_Controller {

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
            'controller'=>'caktivitashariananak',
            'redirect'=>'aktivitasharian-anak',
            'title'=>'Aktivitas Harian Anak',
            'parent'=>'laporan',
            'categori_image' => ['jpg', 'jpeg', 'png', 'gif'],
            'categori_video' => ['mp4', '3gp', 'avi', 'mkv'],
        );
		## load model here 
		$this->load->model('MaktivitasHarianAnak', 'AktivitasHarianAnak');
		$this->load->model('MdokumentasiHarian', 'DokumentasiHarian');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_harian', $_POST['tahun']);
            $this->session->set_userdata('id_rincianjadwal_mingguan_session_harian', $_POST['id_rincianjadwal_mingguan']);
            $this->session->set_userdata('id_anak_session_harian', $_POST['id_anak']);
        }

        $tahun = $this->session->userdata('tahun_session_harian');
        $id_rincianjadwal_mingguan = $this->session->userdata('id_rincianjadwal_mingguan_session_harian');
        $id_anak = $this->session->userdata('id_anak_session_harian');
        if (empty($id_anak)){
            $id_anak = 0;
        }

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['tahun'] = $this->AktivitasHarianAnak->getListTahun();
        if (empty($tahun)) {
            foreach ($data['tahun'] as $key => $value) {
                if ($value->is_aktif == 1) {
                    $tahun = $value->tahun;
                }
            }
        }

        $data['tanggal'] = $this->AktivitasHarianAnak->getListTanggalByTahun($tahun);
        if (empty($id_rincianjadwal_mingguan)) {
            $id_rincianjadwal_mingguan = $data['tanggal'][0]->id_rincianjadwal_mingguan;
        }

        $data['list_anak'] = $this->AktivitasHarianAnak->getListAnak($this->role);

        if (!empty($id_anak)) {
            $data['data_anak'] = $this->AktivitasHarianAnak->getListAnak($this->role, $id_anak);
        }else{
            $data['data_anak'] = [];
        }

        $data_aktivitas = $this->AktivitasHarianAnak->getIdAktivitas($id_rincianjadwal_mingguan, $id_anak);
        if (!empty($data_aktivitas)) {
            $id_aktivitas = $data_aktivitas->id_aktivitas;
            $id_jadwalharian = $data_aktivitas->id_jadwalharian;

            $data['data_subtema'] = $this->AktivitasHarianAnak->getDataSubtemaByAktivitas($id_aktivitas);
            $data['list_kegiatan'] = $this->AktivitasHarianAnak->getKegiatanByAktivitas($id_aktivitas);
            $data['data_stimulus'] = $this->AktivitasHarianAnak->getDataStimulusByAktivitas($id_aktivitas);
            $data['capaian_indikator'] = $this->AktivitasHarianAnak->getDataCapaianIndikator($id_aktivitas);
            $data['konklusi'] = $this->AktivitasHarianAnak->getDataKonklusi($id_aktivitas);
            $data['indikator'] = $this->AktivitasHarianAnak->getDataIndikator($id_aktivitas);

            $data['id_jadwalharian'] = $id_jadwalharian;
            $temp_datadokumentasi = $this->DokumentasiHarian->getDokumentasiFile($id_jadwalharian);
            $data['preview'] = $data['config'] = [];
            foreach ($temp_datadokumentasi as $row){
                $temp_type = strtolower($row->ext);
                if (in_array(strtolower($row->ext), $this->data['categori_image'])) {
                    $temp_type = 'image';
                }elseif (in_array(strtolower($row->ext), $this->data['categori_video'])) {
                    $temp_type = 'video';
                }

                $fileId = $row->id_file; // some unique key to identify the file
                $data['preview'][] = base_url().$row->download_url;
                if ($temp_type == 'video'){
                    $preview_file = '<video controls width="120px"><source src="'.base_url().$row->download_url.'" type="video/mp4"></video>'; // Video preview with controls
                    $data['config'][] = [
                        'type' => $temp_type,
                        'key' => $fileId,
                        'caption' => $row->file_name,
                        'size' => $row->size,
                        'filetype' => "video/".$row->ext,
                        'downloadUrl' => base_url().$row->download_url, // the url to download the file
                        'url' => base_url() . $this->data['controller'] . '/hapusfile', // server api to delete the file based on key
                        'preview' => $preview_file
                    ];
                }else{
                    $data['config'][] = [
                        'type' => $temp_type,
                        'key' => $fileId,
                        'caption' => $row->file_name,
                        'size' => $row->size,
                        'downloadUrl' => base_url().$row->download_url, // the url to download the file
                        'url' => base_url() . $this->data['controller'] . '/hapusfile', // server api to delete the file based on key
                    ];
                }
            }

            $data['dokumentasi_file'] = [
                'preview' => $data['preview'],
                'config' => $data['config']
            ];
        }else{
            $id_aktivitas = 0;
        }

        $data['id_aktivitas'] = $id_aktivitas;
        $data['tahun_selected'] = $tahun;
        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['id_anak'] = $id_anak;

		$data['column'] = $this->AktivitasHarianAnak->getColumn();

		$this->load->view('inc/aktivitashariananak/list', $data);
	}

    public function getDataTanggal(){
        $tahun = $_POST['tahun'];

        $data = $this->AktivitasHarianAnak->getListTanggalByTahun($tahun);
        if (!empty($data)) {
            $id_rincianjadwal_mingguan = $data[0]->id_rincianjadwal_mingguan;
            $kelas = $this->AktivitasHarianAnak->getKelasByIdRincian($id_rincianjadwal_mingguan);

            $data_list = [];
            foreach ($data as $key => $value) {
                $value->nama_hari = format_date_indonesia($value->tanggal);
                $value->tanggal = date('d-m-Y', strtotime($value->tanggal));
                $data_list[] = $value;
            }
            $data['tanggal'] = $data_list;
            $data['kelas'] = $kelas;
        }else{
            $data['tanggal'] = [];
            $data['kelas'] = [];
        }

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;

    }

    function getfile($id_capaianindikator){
        $data_file = $this->AktivitasHarianAnak->getCapaianIndikatorFile($id_capaianindikator);

        $data['preview'] = $data['config'] = [];
        foreach ($data_file as $row){
            $fileId = $row->id_file; // some unique key to identify the file
            $data['preview'][] = base_url().$row->download_url;
            $data['config'][] = [
                'key' => $fileId,
                'caption' => $row->file_name,
                'size' => $row->size,
                'downloadUrl' => base_url().$row->download_url, // the url to download the file
                'url' => base_url() . $this->data['controller'] . '/hapusfile', // server api to delete the file based on key
            ];
        }

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

    function cetakaktivitas(){
        $data = $this->data;

        $id_aktivitas = $_POST['id_aktivitas'];

        $data['data_subtema'] = $this->AktivitasHarianAnak->getDataSubtemaByAktivitas($id_aktivitas);
        $id_rincianjadwal_mingguan = $data['data_subtema']->id_rincianjadwal_mingguan;
        $data['id_aktivitas'] = $id_aktivitas;
        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['list_kegiatan'] = $this->AktivitasHarianAnak->getKegiatanByAktivitas($id_aktivitas);
        $data['data_stimulus'] = $this->AktivitasHarianAnak->getDataStimulusByAktivitas($id_aktivitas);
        $data['capaian_indikator'] = $this->AktivitasHarianAnak->getDataCapaianIndikator($id_aktivitas);
        $data['data_anak'] = $this->AktivitasHarianAnak->getDataAnakByAktivitas($id_aktivitas);
        $data['konklusi'] = $this->AktivitasHarianAnak->getDataKonklusi($id_aktivitas);
        $data['indikator'] = $this->AktivitasHarianAnak->getDataIndikator($id_aktivitas);
        $data['list_file'] = $this->AktivitasHarianAnak->getDokumentasiHarian($id_aktivitas);

        $this->load->view('inc/aktivitashariananak/cetak_aktivitas', $data);
    }
}
