<?php 

class M_ugd extends CI_Model{
    
    
public function data_poli(){
$query = $this->db->get('data_poli');

return $query;
}

function json_data_pasien(){
$this->datatables->select('id_data_pemeriksaan,'
. 'data_pemeriksaan.nomor_pemeriksaan as nomor_pemeriksaan,'
. 'data_pemeriksaan.nama_pasien as nama_pasien,'
. 'data_pemeriksaan.tanggal_masuk_ugd as tanggal_masuk_ugd,'
);

$this->datatables->from('data_pemeriksaan');
$this->datatables->add_column('view','<a class="btn btn-sm btn-success fa fa-print " href="'.base_url().'Ugd/print_ugd/$1"></a>', 'base64_encode(id_data_pemeriksaan)');
return $this->datatables->generate();

}
function data_pemeriksaan(){

$query = $this->db->get('data_pemeriksaan');
return $query;

}

function simpan_pemeriksaan($data){
$this->db->insert('data_pemeriksaan',$data);    
}

}
