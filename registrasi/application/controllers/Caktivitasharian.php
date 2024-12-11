<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caktivitasharian extends CI_Controller {

	var $data = array();
    private $role;
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

        $this->role = $this->session->userdata['auth']->id_role;

		$this->data = array(
            'controller'=>'caktivitasharian',
            'redirect'=>'aktivitas-harian',
            'title'=>'Aktivitas Harian',
            'parent'=>'absensi'
        );
		## load model here 
		$this->load->model('Maktivitasharian', 'AktivitasHarian');
	}

	public function index()	{
        if (!empty($_POST)) {
            $this->session->set_userdata('tahun_session_aktivitas', $_POST['tahun']);
            $this->session->set_userdata('id_rincianjadwal_mingguan_session_aktivitas', $_POST['id_rincianjadwal_mingguan']);
            $this->session->set_userdata('id_jadwalharian_session_aktivitas', $_POST['id_jadwalharian']);
        }

        $tahun = $this->session->userdata('tahun_session_aktivitas');
        $id_rincianjadwal_mingguan = $this->session->userdata('id_rincianjadwal_mingguan_session_aktivitas');
        $id_jadwalharian = $this->session->userdata('id_jadwalharian_session_aktivitas');

		$data = $this->data;

        if (!empty($_POST)) {
            redirect(base_url().$this->data['redirect']);
        }

        $data['tahun'] = $this->AktivitasHarian->getListTahun();
        if (empty($tahun)) {
            foreach ($data['tahun'] as $key => $value) {
                if ($value->is_aktif == 1) {
                    $tahun = $value->tahun;
                }
            }
        }

        $data['tahun_selected'] = $tahun;

        $data['tanggal'] = $this->AktivitasHarian->getListTanggalByTahun($tahun);
        if (empty($id_rincianjadwal_mingguan)) {
            $id_rincianjadwal_mingguan = $data['tanggal'][0]->id_rincianjadwal_mingguan;
        }
        $data['id_rincianjadwal_mingguan'] = $id_rincianjadwal_mingguan;
        $data['kelas'] = $this->AktivitasHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);
        if (!empty($data['kelas'])) {
            if (empty($id_jadwalharian)) {
                $id_jadwalharian = $data['kelas'][0]->id_jadwalharian;
            }
            $data['aktivitas'] = $this->AktivitasHarian->getAktivitasHarianByIdJadwal($this->role, $id_jadwalharian);
            $data['jumlah_kegiatan'] = $this->AktivitasHarian->getJumlahKegiatan($id_jadwalharian);
            $data['id_jadwalharian'] = $id_jadwalharian;
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
        $data['konklusi'] = $this->AktivitasHarian->getDataKonklusi($id_aktivitas);
        $data['indikator'] = $this->AktivitasHarian->getDataIndikator($id_aktivitas);

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

    public function hapusindikator(){
        $err = $this->AktivitasHarian->hapusCapaianIndikator($_POST['id_capaianindikator']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menghapus Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menghapus Data');
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

    public function getDataTanggal(){
        $tahun = $_POST['tahun'];

        $data = $this->AktivitasHarian->getListTanggalByTahun($tahun);
        if (!empty($data)) {
            $id_rincianjadwal_mingguan = $data[0]->id_rincianjadwal_mingguan;
            $kelas = $this->AktivitasHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);

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

        $data['kelas'] = $this->AktivitasHarian->getKelasByIdRincian($id_rincianjadwal_mingguan);

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;

    }

    function tambahcapaian(){
        $err = $this->AktivitasHarian->tambahCapaian($_POST['id_aktivitas']);

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Tambah Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Tambah Data');
        }

        redirect($this->data['redirect'].'/lihat-data/'.$_POST['id_aktivitas']);
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
        $path = './uploads/aktivitas_harian/'; // your upload path
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
                    $id_file = $this->AktivitasHarian->insertCapaianIndikatorFile($temp_filename, $ext, $fileName, $fileSize, $_POST['id_capaianindikator']);
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

        $err = $this->AktivitasHarian->hapusCapaianIndikatorFile($_POST['key']);

        $out = ['initialPreview' => [], 'initialPreviewConfig' => [], 'initialPreviewAsData' => true];
        if ($err === FALSE) {
            $out['error'] = 'Oh snap! We could not delete the file now. Please try again later.';
        }

        echo json_encode($out); // return json data
        exit(); // terminate
    }

    function getfile($id_capaianindikator){
        $data_file = $this->AktivitasHarian->getCapaianIndikatorFile($id_capaianindikator);

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
