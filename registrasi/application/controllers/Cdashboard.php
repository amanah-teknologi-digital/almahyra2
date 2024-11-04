<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require 'vendor/phpspreadsheet/autoload.php';

class CDashboard extends CI_Controller {
    function __construct() {
        parent::__construct();

        if (empty($this->session->userdata['auth'])) {
            $this->session->set_flashdata('failed', 'Anda Harus Login');

            redirect('login');
        } 

        $this->data = array(
            'controller'=>'cdashboard',
            'redirect'=>'dahsboard',
            'title'=>'Dahsboard',
            'parent'=>'dashboard'
        );

        ## load model here 
        $this->load->model('Mregisteranak', 'RegisterAnak');
        $this->load->model('Mobservasizona', 'Observasizona');
        $this->load->model('Mregisterpengasuh', 'RegisterPengasuh');
    }

    public function index() {   

        $data = $this->data;

        $tahun = date('Y');

        $bulan = date('m');
        
        $data['detail_anak'] = [];
        
        $data['detail_pengasuh'] = [];
        
        $data['anak'] = $this->RegisterAnak->getByIDorangtua($this->session->userdata['auth']->id);
        
        $data['pengasuh'] = $this->RegisterPengasuh->getByIDorangtua($this->session->userdata['auth']->id);
        
        // print_r($data['anak']);die ;
        
        if(!empty($data['anak'])) {
            foreach ($data['anak'] as $key => $a) {
                // print_r($a);die ;
                $temp = $this->RegisterAnak->getDetails($a->id);  
                if(!empty($temp)) {
                    $data['detail_anak'][$key] = $temp;    
                }
                
            }
            
        }
        
        if(!empty($data['pengasuh'])) {
            foreach ($data['pengasuh'] as $key => $a) {
                // print_r($a);die ;
                $temp = $this->RegisterPengasuh->getDetails($a->id);  
                if(!empty($temp)) {
                    $data['detail_pengasuh'][$key] = $temp;    
                }
                
            }
            
        }
        
        if(!empty($data['detail_anak'])) {
            foreach ($data['detail_anak'] as $key => $da) {
                // print_r($da);die();
                $data['detail_anak'][$key]->bulan = 12 + $bulan - date('m', strtotime($da->tanggal_lahir));
                $data['detail_anak'][$key]->tahun = $tahun - date('Y', strtotime($da->tanggal_lahir));

                $now = date('Y-m-d');
                
                $tgl1 = new DateTime($da->tanggal_lahir);
                $tgl2 = new DateTime($now);
                $jarak = $tgl2->diff($tgl1);
                
                $data['detail_anak'][$key]->bulan = $jarak->m;
                $data['detail_anak'][$key]->tahun = $jarak->y;
                $data['detail_anak'][$key]->hari = $jarak->d;

                $zona = $this->Observasizona->getByID($da->id);
                $data['detail_anak'][$key]->zona = $zona->zona;
                $data['detail_anak'][$key]->pengajar = $zona->pengajar;
                
            }
        }  
        
        if(!empty($data['detail_pengasuh'])) {
            foreach ($data['detail_pengasuh'] as $key => $da) {
                // print_r($da);die();
                $data['detail_pengash'][$key]->bulan = 12 + $bulan - date('m', strtotime($da->tanggal_lahir));
                $data['detail_pengasuh'][$key]->tahun = $tahun - date('Y', strtotime($da->tanggal_lahir));

                $now = date('Y-m-d');
                
                $tgl1 = new DateTime($da->tanggal_lahir);
                $tgl2 = new DateTime($now);
                $jarak = $tgl2->diff($tgl1);
                
                $data['detail_pengasuh'][$key]->bulan = $jarak->m;
                $data['detail_pengasuh'][$key]->tahun = $jarak->y;
                $data['detail_pengasuh'][$key]->hari = $jarak->d;
                
            }
        }  

        // print_r($data);die();
        if ($this->session->userdata['auth']->id_role == 4) {
            // orang tua
            $this->load->view('inc/dashboard/user', $data);
        } else if ($this->session->userdata['auth']->id_role == 3) {
            $this->load->view('inc/dashboard/pengasuh', $data);
        } else {
            $this->load->view('inc/dashboard/admin', $data);
        }
        
    }   

}
