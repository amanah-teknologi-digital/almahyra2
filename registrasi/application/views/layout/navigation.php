<?php 
    if ($this->session->userdata('auth')->id_role == '1' || $this->session->userdata('auth')->id_role == '2') {
        $this->load->view('layout/navigation_admin') ;
    } else if ($this->session->userdata('auth')->id_role == '4') { //OT
        $this->load->view('layout/navigation_common');
    } else if ($this->session->userdata('auth')->id_role == '3'){ //Educator
        $this->load->view('layout/navigation_pengasuh');
    } else if ($this->session->userdata('auth')->id_role == '5'){ //Absensi
        $this->load->view('layout/navigation_absensi');
    } else if ($this->session->userdata('auth')->id_role == '6'){ //Medical Checkup
        $this->load->view('layout/navigation_medic');
    }else if ($this->session->userdata('auth')->id_role == '7'){ //Ustadzah
        $this->load->view('layout/navigation_ustadzah');
    }else if ($this->session->userdata('auth')->id_role == '8'){ //Kepala TPQ
        $this->load->view('layout/navigation_kepalatpq');
    }else if ($this->session->userdata('auth')->id_role == '9'){ //Ekstra Kurikuler
        $this->load->view('layout/navigation_ekstra');
    } else {
        show_error('You are not allowed to access this page.', 403);
    }
?>