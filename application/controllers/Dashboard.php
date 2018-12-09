<?php

class Dashboard extends CI_Controller{
public function __construct() {
parent::__construct();
if(!$this->session->userdata('id_akun')){
redirect(base_url('C_login'));    
}
}

public function index(){
$this->load->view('umum/V_header');    
$this->load->view('dashboard/V_header_dashboard');    
$this->load->view('dashboard/V_home');    
}

public function keluar(){

$this->session->sess_destroy();  
}


}