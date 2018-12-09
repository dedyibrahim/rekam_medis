<?php 
class Pengaturan extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->model('M_pengaturan');
$this->load->library('Datatables');

if($this->session->userdata('level') != "Super Admin"){
    redirect(base_url('Dashboard'));    
}

}

public function index(){
$akun = $this->M_pengaturan->data_akun();    
$poli = $this->M_pengaturan->data_poli();
$this->load->view('umum/V_header');    
$this->load->view('dashboard/V_header_dashboard');
$this->load->view('dashboard/V_menu_pengaturan');
$this->load->view('dashboard/V_akun',['poli'=>$poli,'akun'=>$akun]);
    
}


public function nama_poli(){
$poli = $this->M_pengaturan->data_poli();

$this->load->view('umum/V_header');    
$this->load->view('dashboard/V_header_dashboard');
$this->load->view('dashboard/V_menu_pengaturan');
$this->load->view('dashboard/V_nama_poli',['poli'=>$poli]);
    
}
public function simpan_poli(){
if($this->input->post('nama_poli')){
$jumlah_poli = $this->M_pengaturan->data_poli()->num_rows();
$angka = 4;
$id_data_poli = str_pad($jumlah_poli+1, $angka ,"0",STR_PAD_LEFT);

$data = array(
'id_data_poli'    => "POLI/".$id_data_poli,
 'nama_poli'      => $this->input->post('nama_poli')   
);

$this->M_pengaturan->simpan_poli($data);

echo "berhasil";
}else{
redirect(404);   

}    
}
public function hapus_poli(){
if($this->uri->segment(3)){

$this->M_pengaturan->hapus_poli($this->uri->segment(3));
redirect(base_url('Pengaturan/nama_poli'));   

}else{
redirect(404);    
}   
    
    
}
public function simpan_user(){
if($this->input->post('nama_lengkap')){

$input = $this->input->post();
$data = array(
    'nama_lengkap'      => $input['nama_lengkap'],
    'nomor_kontak'      => $input['nomor_kontak'],
    'level'             => $input['level'],
    'bekerja'           => $input['bekerja'],
    'nama_poli'         => $input['nama_poli'],
    'id_data_poli'      => $input['id_data_poli'],
    'username'          => $input['username'],
    'password'          => md5($input['password']),    
);

$this->M_pengaturan->simpan_akun($data);    
}else{
redirect(404);    
}
    
}
public function hapus_akun(){

$this->db->delete('akun',array('id_akun'=> base64_decode($this->uri->segment(3))));
redirect(base_url('Pengaturan'));
    
}
public function nama_obat(){

$this->load->view('umum/V_header');    
$this->load->view('dashboard/V_header_dashboard');
$this->load->view('dashboard/V_menu_pengaturan');
$this->load->view('dashboard/V_nama_obat');
    
}

public function simpan_obat(){
if($this->input->post('nama_obat')){
    
$input = $this->input->post();

$jumlah_obat = $this->M_pengaturan->data_obat()->num_rows();
$angka = 4;
$id_data_obat = str_pad($jumlah_obat+1, $angka ,"0",STR_PAD_LEFT);


$data = array(
'id_data_obat'      => "OBAT/".$id_data_obat, 
'nama_obat'         => $input['nama_obat'],
'harga_obat'        => $input['harga_obat'],
'stok_obat'         => $input['stok_obat']  
);  

$this->M_pengaturan->simpan_obat($data);    
 echo "berhasil";   
}else{
    redirect(404);    
}
    
}
public function json_data_obat(){
echo $this->M_pengaturan->json_data_obat();       
}

public function hapus_obat(){
$this->db->delete('data_obat',array('id_obat'=> base64_decode($this->uri->segment(3))));

redirect(base_url('Pengaturan/nama_obat'));
}
}