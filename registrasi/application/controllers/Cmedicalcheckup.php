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
        var_dump($id_checkup); exit();
    }

    public function insert() {

        $err = $this->Absensianak->insert();

        if ($err['code'] == '0') {
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Data');
        } else {
            $this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
        }

        redirect($this->data['redirect']);
    }

    public function edit($id) {
        $data = $this->Absensieducator->getDataAbsenByIdAbsensi($id);

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function absenmasuk(){
        $err = $this->Absensieducator->absenMasuk();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Mohon memulangkan absen sebelumnya, jika ingin absen masuk kembali');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Absen Masuk');
        }

        redirect($this->data['redirect']);
    }

    public function absenpulang(){
        $err = $this->Absensieducator->absenPulang();

        if ($err === FALSE) {
            $this->session->set_flashdata('failed', 'Gagal Absen Pulang');
        }else{
            $this->session->set_flashdata('success', 'Berhasil Absen Pulang');
        }

        redirect($this->data['redirect']);
    }
}
