<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claporanmedicalcheckup extends CI_Controller {

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
            'controller'=>'claporanmedicalcheckup',
            'redirect'=>'laporan-medicalcheckup',
            'title'=>'Laporan Medical Checkup',
            'parent'=>'laporan',
        );
		## load model here 
		$this->load->model('Mlaporanmedicalcheckup', 'LaporanMedicalCheckup');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_medicalcheckup', $_POST['tahun']);
            $this->session->set_userdata('id_anak_session_medicalcheckup', $_POST['id_anak']);
        }

        $tahun = $this->session->userdata('tahun_session_medicalcheckup');
        $id_anak = $this->session->userdata('id_anak_session_medicalcheckup');
        if (empty($id_anak)){
            $id_anak = 0;
        }

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['tahun'] = $this->LaporanMedicalCheckup->getListTahun();
        if (empty($tahun)) {
            $tahun = $data['tahun'][0]->tahun;
        }

        if (empty($tahun)){
            $tahun = 0;
        }

        $data['list_anak'] = $this->LaporanMedicalCheckup->getListAnak($this->role);

        if (!empty($id_anak)) {
            $data['data_anak'] = $this->LaporanMedicalCheckup->getDataAnak($id_anak);
            $temp_datamedic = $this->LaporanMedicalCheckup->getDataMedicalCheckup($id_anak, $tahun);
            $data['data_medical_checkup'] = [];
            foreach ($temp_datamedic as $key => $value) {
                $temp_data = array_column($data['data_medical_checkup'], 'tanggal');
                if (!in_array($value->tanggal, $temp_data)) {
                    $data['data_medical_checkup'][$value->tanggal] = [
                        'id_checkup' => $value->id_checkup,
                        'tanggal' => $value->tanggal,
                        'keterangan' => $value->keterangan,
                    ];
                }

                $data['data_medical_checkup'][$value->tanggal][$value->kolom] = $value->nilai;
                $data['data_medical_checkup'][$value->tanggal]['satuan'.$value->kolom] = $value->satuan;
            }
        }else{
            $data['data_anak'] = [];
            $data['data_medical_checkup'] = [];
        }

        $data['tahun_selected'] = $tahun;
        $data['id_anak'] = $id_anak;

		$this->load->view('inc/laporanmedicalcheckup/list', $data);
	}

    function cetakmedicalcheckup(){
        $data = $this->data;

        $id_anak = $_POST['id_anak'];
        $tahun = $_POST['tahun'];

        if (!empty($id_anak)) {
            $data['data_anak'] = $this->LaporanMedicalCheckup->getDataAnak($id_anak);
            $temp_datamedic = $this->LaporanMedicalCheckup->getDataMedicalCheckup($id_anak, $tahun);
            $data['data_medical_checkup'] = [];
            foreach ($temp_datamedic as $key => $value) {
                $temp_data = array_column($data['data_medical_checkup'], 'tanggal');
                if (!in_array($value->tanggal, $temp_data)) {
                    $data['data_medical_checkup'][$value->tanggal] = [
                        'id_checkup' => $value->id_checkup,
                        'tanggal' => $value->tanggal,
                        'keterangan' => $value->keterangan,
                    ];
                }

                $data['data_medical_checkup'][$value->tanggal][$value->kolom] = $value->nilai;
                $data['data_medical_checkup'][$value->tanggal]['satuan'.$value->kolom] = $value->satuan;
            }
        }else{
            $data['data_anak'] = [];
            $data['data_medical_checkup'] = [];
        }

        $data['tahun_selected'] = $tahun;

        $this->load->view('inc/laporanmedicalcheckup/cetak_medic', $data);
    }

    function lihatdata($id_checkup){
        $data = $this->data;

        $data['data_checkup'] = $this->LaporanMedicalCheckup->getDataCheckup($id_checkup);
        $data['data_rinciancheckup'] = $this->LaporanMedicalCheckup->getDataRincianCheckup($id_checkup);
        $data['role'] = $this->role;
        $temp_datadokumentasi = $this->LaporanMedicalCheckup->getDokumentasiFile($id_checkup);
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
                if ($row->ext == 'mov'){
                    $row->ext = 'mp4';
                }
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

        $this->load->view('inc/laporanmedicalcheckup/lihat_data', $data);
    }
}
