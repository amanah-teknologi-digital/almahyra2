<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabsensieducator extends CI_Controller {

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

        if ($this->role == 7) {
            $parent = 'mengaji';
            $label = "Ustadzah";
            $title = 'Absensi Ustadzah';
        }else{
            $parent = 'absensi';
            $label = "Educator";
            $title = 'Absensi Educator';
        }

        $this->data = array(
            'controller'=>'cabsensieducator',
            'redirect'=>'absensi-educator',
            'title'=>$title,
            'parent'=>$parent,
            'label'=>$label,
            'role' => $this->session->userdata['auth']->id_role,
        );
        ## load model here 
        $this->load->model('Mabsensieducator', 'Absensieducator');
    }

    public function index() {
        $data = $this->data;

        $data['list_educator'] = $this->Absensieducator->getListEducator($this->role);
        $data['absensi'] = $this->Absensieducator->getAbsensiEducator($this->role);

        $data['list_jenisabsensi'] = $this->Absensieducator->getListJenisAbsensi($this->role);
        $data['list_jenislembur'] = $this->Absensieducator->getListJenisLembur();

        $this->load->view('inc/absensieducator/list', $data);
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
        $data->tgl_absen = format_date_indonesia(date('Y-m-d', strtotime($data->tanggal))).', '.date('d-m-Y', strtotime($data->tanggal));

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
