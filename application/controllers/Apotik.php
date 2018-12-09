<?php
require APPPATH.'libraries/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Apotik extends CI_Controller{
public function __construct() {
parent::__construct();

$this->load->library('Datatables');
$this->load->model('M_apotik');

if($this->session->userdata('bekerja') != 'APOTIK'){
redirect(base_url('Dashboard'));   
}
}

public function index(){
$this->load->view('umum/V_header');    
$this->load->view('dashboard/V_header_dashboard');
$this->load->view('dashboard/V_apotik');
    
}


public function json_data_pasien_selesai(){
echo $this->M_apotik->json_data_pasien_selesai();       
}

public function print_ulang(){
 $data = $this->db->get_where('data_pemeriksaan',array('id_data_pemeriksaan'=>$this->uri->segment(3) ))->row_array();
 
 $html = "<h2 align='center'>Data Hasil Rekam Medis</h2><hr><br>"
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
         . "<tr><td>Nama Dokter pemeriksa</td>"
         . "<td> : ".$data['pemeriksa']."</td>"
         . "</tr>"
        
         . "</table>"
         . "<hr>";
     
$html .= "<table style='width:100%' border='1' cellspacing='0' cellpading='0' class='table table-striped table-sm table-bordered table-condensed table-hover'>"
        . "<tr>"
        . "<th>No</th>"
        . "<th>Nama Obat</th>"
        . "<th>Harga</th>"
        . "<th >Jumlah</th>"
        . "<th>Jumlah Total</th>"
        . "</tr>"
        . "";

$data2 = $this->db->get_where('hasil_resep',array('nomor_pemeriksaan'=>$data['nomor_pemeriksaan']));
$b=1;
foreach ($data2->result_array()  as $i){

$html   .= "<tr>"
        . "<td>".$b++."</td>"
        . "<td>".$i['nama_obat']."</td>"
        . "<td>Rp.".number_format($i['harga_obat'])."</td>"
        . "<td>".$i['jumlah']."</td>"
        . "<td>Rp.".number_format($i['jumlah_total'])."</td>"
        . "</tr>";

}

$html   .="<tr>"
        . "<td colspan='4'>Total Bayar</td>"
        . "<td colspan='4'>Rp.".number_format($data['total_bayar'])."</td>"
        . "</tr>";
$html .="</table>";


$dompdf = new Dompdf(array('enable_remote'=>true));
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream('INV.pdf',array('Attachment'=>0));

}

public function set_selesai(){
    
$data = array(
'status_obat'=>"Selesai"    
);    
$this->db->update('data_pemeriksaan',$data,array('id_data_pemeriksaan'=>$this->uri->segment(3)));

redirect(base_url('Apotik'));
}
}
