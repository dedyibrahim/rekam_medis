<?php

class C_login extends CI_Controller{
public function __construct() {
parent::__construct();

$this->load->model('M_login');
if($this->session->userdata('id_akun')){
    redirect(base_url('Dashboard'));    
}
}

public function index(){
$this->load->view('umum/V_header');
$this->load->view('V_login');
$this->load->view('umum/V_footer');
}

public function proses_login(){
if($this->input->post('username')){
$cek = array(
'username' => $this->input->post('username'),
'password' => md5($this->input->post('password'))  
);    
$query = $this->M_login->proses_login($cek);    
$data = $query->row_array();
if($query->num_rows() > 0){
$data = array(
'id_akun'       => $data['id_akun'],    
'nama_lengkap'  => $data['nama_lengkap'],    
'level'         => $data['level'],
'bekerja'       => $data['bekerja'],
'nama_poli'     => $data['nama_poli'],
'id_data_poli'  => $data['id_data_poli'],  
);
$this->session->set_userdata($data);    
    
echo "berhasil";    
}else{
echo "gagal";
}

    
}else{
redirect(404);    
}
    
}

}