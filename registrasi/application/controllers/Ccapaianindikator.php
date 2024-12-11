<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccapaianindikator extends CI_Controller {

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
            'controller'=>'ccapaianindikator',
            'redirect'=>'capaian-indikator',
            'title'=>'Capaian Indikator',
            'parent'=>'laporan',
            'categori_image' => ['jpg', 'jpeg', 'png', 'gif'],
            'categori_video' => ['mp4', '3gp', 'avi', 'mkv'],
        );
		## load model here 
		$this->load->model('McapaianIndikator', 'CapaianIndikator');
		$this->load->model('MaktivitasHarian', 'AktivitasHarian');
	}

	public function index()	{
        $data = $this->data;

        $data['list_siswa_indikator'] = $this->CapaianIndikator->getListSiswaIndikator($this->role);

		$data['column'] = $this->CapaianIndikator->getColumn();

		$this->load->view('inc/capaianindikator/list', $data);
	}

    public function detailcapaian($id_anak){
        $data = $this->data;
        $data['data_anak'] = $this->CapaianIndikator->getDataAnakById($id_anak);
        $data['capaian_indikator'] = $this->CapaianIndikator->getCapaianIndikatorAnak($id_anak);

        $this->load->view('inc/capaianindikator/lihat_data', $data);
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
            ];
        }

        $this->output->set_content_type('application/json');

        $this->output->set_output(json_encode($data));

        return $data;
    }

    public function cetakcapaian(){
        $data = $this->data;

        $id_anak = $_POST['id_anak'];
        $data['data_anak'] = $this->CapaianIndikator->getDataAnakById($id_anak);
        $data['capaian_indikator'] = $this->CapaianIndikator->getCapaianIndikatorAnak($id_anak);

        $this->load->view('inc/capaianindikator/cetak_capaian', $data);
    }
}
