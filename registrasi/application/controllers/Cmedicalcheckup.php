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
}
