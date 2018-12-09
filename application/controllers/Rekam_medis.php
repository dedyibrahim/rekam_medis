<?php
require APPPATH.'libraries/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Rekam_medis extends CI_Controller{
public function __construct() {
parent::__construct();

$this->load->library('Datatables');
$this->load->model('M_rekam_medis');

if($this->session->userdata('bekerja') != 'REKAM MEDIS'){
redirect(base_url('Dashboard'));   
}
}

public function index(){
$this->load->view('umum/V_header');    
$this->load->view('dashboard/V_header_dashboard');
$this->load->view('dashboard/V_rekam_medis');
    
}

public function json_data_rekam_medis(){
echo $this->M_rekam_medis->json_data_rekam_medis();       
}

public function json_data_pasien_selesai(){
echo $this->M_rekam_medis->json_data_pasien_selesai();       
}

public function buat_resep(){
if($this->input->post('id_data_pemeriksaan')){
$data = $this->db->get_where('data_pemeriksaan',array('id_data_pemeriksaan'=>$this->input->post('id_data_pemeriksaan')))->row_array();
$data2 = array(
'id_pemeriksaan' =>$data['id_data_pemeriksaan'],
'nama_pasien'    => $data['nama_pasien'],    
);
$this->session->set_userdata($data2);
}else{
redirect(404);    
}    
 
}
public function halaman_resep(){

if($this->session->userdata('nama_pasien')){
$html ="<h4 align='center'>Buatkan Resep Pasien ".$this->session->userdata('nama_pasien')."</h4><hr>";    
    
}else{
$html ="<h4 align='center'>Nama Pasien Belum di tentukan </h4><hr>";    
}
$loop = $this->session->userdata('obat');


$ht= count($loop);


if($ht >0 ){
$html .= "<table class='table table-striped table-sm table-bordered table-condensed table-hover'>"
        . "<tr>"
        . "<th style='width: 90%;' >Nama Obat</th>"
        . "<th  style='width: 5%;'>Jumlah</th>"
        . "<th>Aksi</th>"
        . "</tr>"
        . "";

foreach ($loop as $i=>$ht){
$html   .= "<tr>"
        . "<td>".$loop[$i]['nama_obat']."</td>"
        . "<td><input class='form-control' id='id_obat".$i."' onchange='update_obat(".$i.");'  type='text' value=".$loop[$i]['jumlah']."></td>"
        . "<td><button onclick='hapus_obat(".$i.");' class='btn btn-danger'><span class='fa fa-close'></span></button></td>"
        . "</tr>";
}

$html .="</table>";

if($this->session->userdata('nama_pasien')){

$html.="<hr>"
        . "<a href='".base_url('Rekam_medis/print_resep')."'><button class='btn btn-success  btn-save form-control'> Save & Print <span class='fa fa-print'></span></button></a>";


}


echo $html;
}
}

public function cari_obat(){
$term = strtolower($this->input->get('term'));
         $this->db->like('nama_obat',$term);
$query = $this->db->get('data_obat')->result();
foreach ($query as $d) {
$json[]= array(
'label'                     => $d->nama_obat,
'id_data_obat'              => $d->id_data_obat,   
);   
}
echo json_encode($json);
}
public function set_obat(){
if($this->input->post('id_data_obat')){
$query = $this->db->get_where('data_obat',array('id_data_obat'=>$this->input->post('id_data_obat')))->row_array();
    
 
if(!$this->session->userdata('obat')){
$obat['obat'][] = [
 'id_data_obat' =>$query['id_data_obat'] ,  
 'nama_obat'  =>$query['nama_obat'] ,  
 'harga_obat' =>$query['harga_obat'],
 'stok_obat'  =>$query['stok_obat'],    
 'jumlah'     =>"1",    
'jumlah_total' => $query['harga_obat']
];
$this->session->set_userdata($obat);

}else{
$obat_lama = $this->session->userdata('obat');    
$obat2 = array(
 'id_data_obat' =>$query['id_data_obat'] ,  
 'nama_obat'  =>$query['nama_obat'] ,  
 'harga_obat' =>$query['harga_obat'],
 'stok_obat'  =>$query['stok_obat'],    
 'jumlah'     =>"1",
'jumlah_total' => $query['harga_obat']   
);
$this->session->set_userdata($obat2);

array_push($obat_lama, $obat2);    
$this->session->set_userdata('obat',$obat_lama);    


}  


echo print_r($this->session->userdata());
}else{
redirect(404);    
}
    
}

function hapus_obat(){
$id_hapus = $this->input->post('id_hapus');
unset($_SESSION['obat'][$id_hapus]);


}

function update_obat(){

if($this->input->post('jumlah')){    

    
$id_obat    = $this->input->post('id_obat');
$jumlah     = $this->input->post('jumlah');
$detailsdata = $this->session->userdata('obat');

$d =  $detailsdata[$id_obat];

$obat2 = array(
 'id_data_obat' =>$d['id_data_obat'] ,  
 'nama_obat'  =>$d['nama_obat'] ,  
 'harga_obat' =>$d['harga_obat'],
 'stok_obat'  =>$d['stok_obat'],    
 'jumlah'     =>$jumlah,
 'jumlah_total' => $jumlah * $d['harga_obat']   
);
$this->session->set_userdata($obat2);

array_push($detailsdata, $obat2);

$this->session->set_userdata('obat',$detailsdata);

unset($_SESSION['obat'][$id_obat]);


}else{
 redirect(404);  
}

}

public function print_resep(){
$loop = $this->session->userdata('obat');
$b=1;
$ht= count($loop);
$total=0;

 $data = $this->db->get_where('data_pemeriksaan',array('id_data_pemeriksaan'=>$this->session->userdata('id_pemeriksaan') ))->row_array();
 
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
         . "<td> : ".$this->session->userdata('nama_lengkap')."</td>"
         . "</tr>"
        
         . "</table>"
         . "<hr>";
     
if(is_array($loop)){
$html .= "<table style='width:100%' border='1' cellspacing='0' cellpading='0' class='table table-striped table-sm table-bordered table-condensed table-hover'>"
        . "<tr>"
        . "<th>No</th>"
        . "<th>Nama Obat</th>"
        . "<th>Harga</th>"
        . "<th >Jumlah</th>"
        . "<th>Jumlah Total</th>"
        . "</tr>"
        . "";

foreach ($loop as $i=>$ht){
$total +=$loop[$i]['jumlah_total'];
$html   .= "<tr>"
        . "<td>".$b++."</td>"
        . "<td>".$loop[$i]['nama_obat']."</td>"
        . "<td>Rp.".number_format($loop[$i]['harga_obat'])."</td>"
        . "<td>".$loop[$i]['jumlah']."</td>"
        . "<td>Rp.".number_format($loop[$i]['jumlah_total'])."</td>"
        . "</tr>";

$hasil_resep = array(
'nomor_pemeriksaan' => $data['nomor_pemeriksaan'],   
'nama_obat'         =>$loop[$i]['nama_obat'],
'harga_obat'        =>$loop[$i]['harga_obat'],
'jumlah'            =>$loop[$i]['jumlah'],
'jumlah_total'      =>$loop[$i]['jumlah_total'],    
);

$this->db->insert('hasil_resep',$hasil_resep);
}

$html   .="<tr>"
        . "<td colspan='4'>Total Bayar</td>"
        . "<td colspan='4'>Rp.".number_format($total)."</td>"
        . "</tr>";
$html .="</table>";


$update = array(
'pemeriksa'          =>$this->session->userdata('nama_lengkap'),
'status_pemeriksaan' =>"Selesai",
'total_bayar'        =>$total,    
);
$this->db->update('data_pemeriksaan',$update,array('id_data_pemeriksaan'=>$this->session->userdata('id_pemeriksaan')));


$array_items = array('obat', 'id_pemeriksaan','nama_pasien');

$this->session->unset_userdata($array_items);


$dompdf = new Dompdf(array('enable_remote'=>true));
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream('INV.pdf',array('Attachment'=>0));

}
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
}
