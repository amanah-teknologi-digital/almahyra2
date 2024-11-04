<?php 
    if ($this->session->userdata('auth')->id_role == '1' || $this->session->userdata('auth')->id_role == '2') {
        $this->load->view('layout/navigation_admin') ;
    } else if ($this->session->userdata('auth')->id_role == '4') {
        $this->load->view('layout/navigation_common');
    } else {
        $this->load->view('layout/navigation_pengasuh');
    }
?>