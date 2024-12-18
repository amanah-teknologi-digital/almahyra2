<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cmedicalcheckup extends CI_Controller {

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
            'controller'=>'cmedicalcheckup',
            'redirect'=>'medical-checkup',
            'title'=>'Hasil Checkup',
            'parent'=>'checkup',
            'role' => $this->session->userdata['auth']->id_role,
            'categori_image' => ['jpg', 'jpeg', 'png', 'gif'],
            'categori_video' => ['mp4', '3gp', 'avi', 'mkv','mov'],
        );
        ## load model here
        $this->load->model('Mmedicalcheckup', 'MedicalCheckup');
    }

    public function index() {
        $data = $this->data;

        $data['hasil_checkup'] = $this->MedicalCheckup->getHasilCheckup();
        $data['role'] = $this->role;

        $this->load->view('inc/medicalcheckup/list', $data);
    }

    public function checkAktivitas(){
        $tanggal = $this->input->post('tanggal');
        $id_anak = $this->input->post('id_anak');

        $id_checkup  = $this->MedicalCheckup->checkAktivitas($tanggal, $id_anak);

        redirect($this->data['redirect'].'/lihat-data/'.$id_checkup);
    }

    public function lihatdata($id_checkup){
        $data = $this->data;

        $data['data_checkup'] = $this->MedicalCheckup->getDataCheckup($id_checkup);
        $data['data_rinciancheckup'] = $this->MedicalCheckup->getDataRincianCheckup($id_checkup);
        $data['role'] = $this->role;
        $temp_datadokumentasi = $this->MedicalCheckup->getDokumentasiFile($id_checkup);
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

        $this->load->view('inc/medicalcheckup/lihat_data', $data);
    }

    public function simpanrekammedik(){
        $err = $this->MedicalCheckup->simpanRekamMedic();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Menyimpan Data');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Menyimpan Data');
        }

        redirect($this->data['redirect'].'/lihat-data/'.$_POST['id_checkup']);
    }

    function hapusfile(){
        header('Content-Type: application/json'); // set json response headers

        $err = $this->MedicalCheckup->hapusDokumentasiFile($_POST['key']);

        $out = ['initialPreview' => [], 'initialPreviewConfig' => [], 'initialPreviewAsData' => true];
        if ($err === FALSE) {
            $out['error'] = 'Oh snap! We could not delete the file now. Please try again later.';
        }

        echo json_encode($out); // return json data
        exit(); // terminate
    }
}
