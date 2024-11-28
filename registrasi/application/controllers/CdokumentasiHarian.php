<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CdokumentasiHarian extends CI_Controller {

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
            'controller'=>'cdokumentasiharian',
            'redirect'=>'dokumentasi-harian',
            'title'=>'Dokumentasi Harian',
            'parent'=>'absensi'
        );
		## load model here 
		$this->load->model('MdokumentasiHarian', 'DokumentasiHarian');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_dokumentasi', $_POST['tahun']);
            $this->session->set_userdata('id_rincianjadwal_mingguan_session_dokumentasi', $_POST['id_rincianjadwal_mingguan']);
            $this->session->set_userdata('id_jadwalharian_session_dokumentasi', $_POST['id_jadwalharian']);
        }

        $tahun = $this->session->userdata('tahun_session_dokumentasi');
        $id_rincianjadwal_mingguan = $this->session->userdata('id_rincianjadwal_mingguan_session_dokumentasi');
        $id_jadwalharian = $this->session->userdata('id_jadwalharian_session_dokumentasi');

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['tahun'] = $this->DokumentasiHarian->getListTahun();
        if (empty($tahun)) {
            foreach ($data['tahun'] as $key => $value) {
                if ($value->is_aktif == 1) {
                    $tahun = $value->tahun;
                }
            }
        }

        $data['tahun_selected'] = $tahun;

        $data['tanggal'] = $this->DokumentasiHarian->getListTanggalByTahun($tahun);
        if (empty($id_rincianjadwal_mingguan)) {
            $id_rincianjadwal_mingguan = $data['tanggal'][0]->id_rincianjadwal_mingguan;
        }
        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['kelas'] = $this->DokumentasiHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);
        if (!empty($data['kelas'])) {
            if (empty($id_jadwalharian)) {
                $id_jadwalharian = $data['kelas'][0]->id_jadwalharian;
            }
            $data['aktivitas'] = $this->DokumentasiHarian->getAktivitasHarianByIdJadwal($id_jadwalharian);
            $data['jumlah_kegiatan'] = $this->DokumentasiHarian->getJumlahKegiatan($id_jadwalharian);
            $data['id_jadwalharian'] = $id_jadwalharian;
        }else{
            $data['aktivitas'] = [];
            $data['jumlah_kegiatan'] = 0;
            $data['id_jadwalharian'] = 0;
        }

		$data['column'] = $this->DokumentasiHarian->getColumn();

		$this->load->view('inc/aktivitasharian/list', $data);
	}

    public function getDataTanggal(){
        $tahun = $_POST['tahun'];

        $data = $this->DokumentasiHarian->getListTanggalByTahun($tahun);
        if (!empty($data)) {
            $id_rincianjadwal_mingguan = $data[0]->id_rincianjadwal_mingguan;
            $kelas = $this->DokumentasiHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);

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

    public function getDataKelas(){
        $id_rincianjadwal_mingguan =  $_POST['id_rincianjadwal_mingguan'];

        $data['kelas'] = $this->DokumentasiHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;

    }

    function uploadfile(){
        header('Content-Type: application/json'); // set json response headers
        $outData = $this->uploadfiles(); // a function to upload the bootstrap-fileinput files
        echo json_encode($outData); // return json data
        exit(); // terminate
    }

    function uploadfiles() {
        $preview = $config = $errors = [];
        $input = 'file_dukung'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        $total = count($_FILES[$input]['name']); // multiple files
        $path = './uploads/dokumentasi_harian/'; // your upload path
        $temp_filename = date('dmyhis').rand(1, 1000000);

        for ($i = 0; $i < $total; $i++) {
            $temp_filename = $temp_filename.$i;
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = $_FILES[$input]['name'][$i]; // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            $ext = pathinfo($_FILES[$input]['name'][$i], PATHINFO_EXTENSION);

            //Make sure we have a file path
            if ($tmpFilePath != ""){
                //Setup our new file path
                $newFilePath = $path . $temp_filename.'.'.$ext;
                $newFileUrl = base_url() . 'uploads/aktivitas_harian/' . $temp_filename.'.'.$ext;

                //Upload the file into the new path
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $id_file = $this->DokumentasiHarian->insertCapaianIndikatorFile($temp_filename, $ext, $fileName, $fileSize, $_POST['id_capaianindikator']);
                    if (!empty($id_file)) {
                        $fileId = $id_file; // some unique key to identify the file
                        $preview[] = $newFileUrl;
                        $config[] = [
                            'key' => $fileId,
                            'caption' => $fileName,
                            'size' => $fileSize,
                            'downloadUrl' => $newFileUrl, // the url to download the file
                            'url' => base_url() . $this->data['controller'] . '/hapusfile', // server api to delete the file based on key
                        ];
                    }else{
                        @unlink($newFilePath);
                        $errors[] = $fileName;
                    }
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $errors[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }
        return $out;
    }

    function hapusfile(){
        header('Content-Type: application/json'); // set json response headers

        $err = $this->DokumentasiHarian->hapusCapaianIndikatorFile($_POST['key']);

        $out = ['initialPreview' => [], 'initialPreviewConfig' => [], 'initialPreviewAsData' => true];
        if ($err === FALSE) {
            $out['error'] = 'Oh snap! We could not delete the file now. Please try again later.';
        }

        echo json_encode($out); // return json data
        exit(); // terminate
    }

    function getfile($id_capaianindikator){
        $data_file = $this->DokumentasiHarian->getCapaianIndikatorFile($id_capaianindikator);

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
}
