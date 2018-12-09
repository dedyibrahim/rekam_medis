<?php
require APPPATH.'libraries/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Ugd extends CI_Controller{
    
public function __construct() {
parent::__construct();

$this->load->library('Datatables');
$this->load->model('M_ugd');

if($this->session->userdata('bekerja') != 'UGD'){
    redirect(base_url('Dashboard'));   
}
}

public function index(){
$poli = $this->M_ugd->data_poli();
    
$this->load->view('umum/V_header');    
$this->load->view('dashboard/V_header_dashboard');
$this->load->view('dashboard/V_ugd',['poli'=>$poli]);

}

public function api_bpjs(){
if($this->input->post('nomor_bpjs')){
$hasil_cari = $this->db->get_where('api_bpjs',array('nomor_bpjs'=>$this->input->post('nomor_bpjs')));
$data = $hasil_cari->row_array();
if($hasil_cari->num_rows() >0){

  echo json_encode($data);  
    
}else{
echo "no_available";    
}   
}else{
redirect(404);    
}    
    
}

public function simpan_pasien(){

if($this->input->post('nama_pasien')){

$input = $this->input->post();

if($this->input->post("nomor_bpjs") != NULL){
$pembayaran = "BPJS";    
}else{
$pembayaran = "UMUM";        
}


$jumlah_pemeriksaan = $this->M_ugd->data_pemeriksaan()->num_rows();
$angka = 6;
$nomor_pemeriksaan = str_pad($jumlah_pemeriksaan+1, $angka ,"0",STR_PAD_LEFT);


  $data = array(
    'nomor_pemeriksaan'         => 'CHECK/'.$input['id_data_poli']."/".$nomor_pemeriksaan,  
    'pembayaran'                => $pembayaran,
    'nama_pasien'               => $input['nama_pasien'],
    'nomor_bpjs'                => $input['nomor_bpjs'],
    'nama_poli'                 => $input['nama_poli'],
    'id_data_poli'              => $input['id_data_poli'],
    'nama_kerabat'              => $input['nama_kerabat'],
    'nomor_kontak_kerabat'      => $input['nomor_kontak_kerabat'],
    'alamat_lengkap_kerabat'    => $input['alamat_lengkap_kerabat'],
    'alamat_pasien'             => $input['alamat_pasien'],
    'tanggal_masuk_ugd'         => date('Y-m-d H:i:s')  
);

$this->M_ugd->simpan_pemeriksaan($data);

echo "berhasil";
}else{
redirect(404);    
}    
    
}
public function json_data_pasien(){
echo $this->M_ugd->json_data_pasien();       
}
public function print_ugd(){

 $data = $this->db->get_where('data_pemeriksaan',array('id_data_pemeriksaan'=> base64_decode($this->uri->segment(3))))->row_array();
 
 $html = "<h2 align='center'>DATA FORM UNIT GAWAT DARURAT (UGD)</h2><hr><br>"
         . "<table>"
         . "<tr>"
         . "<td>Nomor Pemeriksaan</td>"
         . "<td> : ".$data['nomor_pemeriksaan']."</td>"
         . "</tr>"
         . "<tr>"
         . "<td>Ruangan</td>"
         . "<td> : ".$data['nama_poli']."</td>"
         . "</tr>"
         . "<tr>"
         . "<td>Pembayaran</td>"
         . "<td> : ".$data['pembayaran']."</td>"
         . "</tr>"
         . "";
        if($data['pembayaran'] =="BPJS"){
     $html  .= "<tr><td>Nomor BPJS</td>"
         . "<td> : ".$data['nomor_bpjs']."</td>"
         . "</tr>";
            
        }
         
     $html  .= "<tr><td>Nama Pasien</td>"
         . "<td> : ".$data['nama_pasien']."</td>"
         . "</tr>"
         . "<tr><td>Alamat Pasien</td>"
         . "<td> : ".$data['alamat_pasien']."</td>"
         . "</tr>"
    
         . "</tr>"
         . "<tr><td>Nama Kerabat</td>"
         . "<td> : ".$data['nama_kerabat']."</td>"
         . "</tr>"
         . "</tr>"
         . "<tr><td>Nomor Kontak Kerabat</td>"
         . "<td> : ".$data['nomor_kontak_kerabat']."</td>"
         . "</tr>"
         . "</tr>"
         . "<tr><td>Alamat Kerabat</td>"
         . "<td> : ".$data['alamat_lengkap_kerabat']."</td>"
         . "</tr>"
         . "</tr>"
         . "<tr><td>Tanggal Masuk</td>"
         . "<td> : ".$data['tanggal_masuk_ugd']."</td>"
         . "</tr>"
        
         . "</table>"
         . "";
 
$dompdf = new Dompdf(array('enable_remote'=>true));
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream('INV.pdf',array('Attachment'=>0));


    
}




}
