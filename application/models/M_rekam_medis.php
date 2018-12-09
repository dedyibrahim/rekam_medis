<?php 

class M_rekam_medis extends CI_Model{
    
    


function json_data_rekam_medis(){
$this->datatables->select('id_data_pemeriksaan,'
. 'data_pemeriksaan.nomor_pemeriksaan as nomor_pemeriksaan,'
. 'data_pemeriksaan.nama_pasien as nama_pasien,'
. 'data_pemeriksaan.tanggal_masuk_ugd as tanggal_masuk_ugd,'
. 'data_pemeriksaan.status_pemeriksaan as status_pemeriksaan,'
);

$this->datatables->from('data_pemeriksaan');
$this->datatables->where('id_data_poli',$this->session->userdata('id_data_poli'));
$this->datatables->where('status_pemeriksaan',NULL);
$this->datatables->add_column('view','<button class="btn btn-sm btn-success fa fa-plus"  onclick="buat_resep($1);" > Resep Obat</button>', 'id_data_pemeriksaan');
return $this->datatables->generate();

}

function json_data_pasien_selesai(){
$this->datatables->select('id_data_pemeriksaan,'
. 'data_pemeriksaan.nomor_pemeriksaan as nomor_pemeriksaan,'
. 'data_pemeriksaan.nama_pasien as nama_pasien,'
. 'data_pemeriksaan.tanggal_masuk_ugd as tanggal_masuk_ugd,'
. 'data_pemeriksaan.status_pemeriksaan as status_pemeriksaan,'
);

$this->datatables->from('data_pemeriksaan');
$this->datatables->where('id_data_poli',$this->session->userdata('id_data_poli'));
$this->datatables->where('status_pemeriksaan','Selesai');

$this->datatables->add_column('view','<a href="'. base_url('Rekam_medis/print_ulang/$1').'"><button class="btn btn-sm btn-success fa fa-print"   ></button></a>', 'id_data_pemeriksaan');
return $this->datatables->generate();

}


}