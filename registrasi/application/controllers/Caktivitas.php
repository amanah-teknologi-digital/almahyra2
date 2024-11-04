<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caktivitas extends CI_Controller {

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
            'controller'=>'caktivitas',
            'redirect'=>'aktivitas-anak',
            'title'=>'Aktivitas Anak',
            'parent'=>'absensi'
        );
        ## load model here 
        $this->load->model('Maktivitas', 'Aktivitas');
        $this->load->model('Mregisteranak', 'RegisterAnak');
    }

    public function index() {   

        $data = $this->data;

        $data['list'] = $this->RegisterAnak->getAll();

        $this->load->view('inc/aktivitas/list', $data);
    }

    public function insert() {
        
        $err = $this->Aktivitas->insert();
      
        echo json_encode($err);
    }

    public function edit($id) {
        $data = $this->data;

        $data['list_edit'] = $this->Aktivitas->getByID($id) ;

        $data['list_hasil'] = $this->Aktivitas->getByIDanak($id) ;

        $this->output->set_content_type('application/json');
        
        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function delete($id) {
        
        $err = $this->Aktivitas->delete($id);

        echo json_encode($err);
    }

    public function do_upload() {
        $config['upload_path']          = './uploads';
        $config['allowed_types']        = '*';
        $config['max_size']             = '100000';
        $config['file_name']            = date('dmyhis');

        
        $sourcePath = $_FILES['file']['tmp_name'];
        
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        
        $full = $config['file_name'].'.'.$ext;
        
        $targetPath = $config['upload_path'] . '/aktivitas/'.$full;
        
        $result = move_uploaded_file($sourcePath,$targetPath) ;
        
        if( $result == 1) {
            $this->output->set_output($full);
        }
    }
}
