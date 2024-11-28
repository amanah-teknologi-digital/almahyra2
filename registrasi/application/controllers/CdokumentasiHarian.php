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
            'parent'=>'absensi',
            'categori_image' => ['jpg', 'jpeg', 'png', 'gif'],
            'categori_video' => ['mp4', '3gp', 'avi', 'mkv'],
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

        $nama_tema = "";
        $nama_subtema = "";
        $tanggal = "";
        $nama_kelas = "";

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

        foreach ($data['tanggal'] as $value_tanggal) {
            if ($value_tanggal->id_rincianjadwal_mingguan == $id_rincianjadwal_mingguan) {
                $nama_tema = $value_tanggal->nama_tema;
                $nama_subtema = $value_tanggal->nama_subtema;
                $tanggal = $value_tanggal->tanggal;

                break;
            }
        }

        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['kelas'] = $this->DokumentasiHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);
        if (!empty($data['kelas'])) {
            if (empty($id_jadwalharian)) {
                $id_jadwalharian = $data['kelas'][0]->id_jadwalharian;
            }

            foreach ($data['kelas'] as $value_kelas) {
                if ($value_kelas->id_jadwalharian == $id_jadwalharian) {
                    $nama_kelas = $value_kelas->nama_kelas;
                    break;
                }
            }

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
            $data['aktivitas'] = [];
            $data['dokumentasi_file'] = [];
            $data['id_jadwalharian'] = 0;
        }

        $data['nama_tema'] = $nama_tema;
        $data['nama_subtema'] = $nama_subtema;
        $data['tanggal_selected'] = $tanggal;
        $data['nama_kelas'] = $nama_kelas;

		$data['column'] = $this->DokumentasiHarian->getColumn();

		$this->load->view('inc/dokumentasiharian/list', $data);
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
                $newFileUrl = base_url() . 'uploads/dokumentasi_harian/' . $temp_filename.'.'.$ext;

                //Upload the file into the new path
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $id_file = $this->DokumentasiHarian->insertDokumentasiHarian($temp_filename, $ext, $fileName, $fileSize, $_POST['id_jadwalharian']);
                    if (!empty($id_file)) {
                        $temp_type = strtolower($ext);
                        if (in_array(strtolower($ext), $this->data['categori_image'])) {
                            $temp_type = 'image';
                        }elseif (in_array(strtolower($ext), $this->data['categori_video'])) {
                            $temp_type = 'video';
                        }

                        $fileId = $id_file; // some unique key to identify the file
                        $preview[] = $newFileUrl;
                        if ($temp_type == 'video'){
                            $preview_file = '<video controls width="120px"><source src="'.$newFileUrl.'" type="video/mp4"></video>'; // Video preview with controls
                        }else{
                            $preview_file = ''; // Image preview
                        }

                        $config[] = [
                            'type' => $temp_type,
                            'key' => $fileId,
                            'caption' => $fileName,
                            'size' => $fileSize,
                            'filetype' => "video/".$ext,
                            'downloadUrl' => $newFileUrl, // the url to download the file
                            'url' => base_url() . $this->data['controller'] . '/hapusfile', // server api to delete the file based on key
                            'preview' => $preview_file
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

        $err = $this->DokumentasiHarian->hapusDokumentasiFile($_POST['key']);

        $out = ['initialPreview' => [], 'initialPreviewConfig' => [], 'initialPreviewAsData' => true];
        if ($err === FALSE) {
            $out['error'] = 'Oh snap! We could not delete the file now. Please try again later.';
        }

        echo json_encode($out); // return json data
        exit(); // terminate
    }
}
