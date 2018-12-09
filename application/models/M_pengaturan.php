<?php 

class M_pengaturan extends CI_Model{
    
    
public function data_poli(){
$query = $this->db->get('data_poli');

return $query;
}

public function simpan_poli($data){
    
$this->db->insert('data_poli',$data);    
}
public function hapus_poli($id_departemen){
$this->db->delete('data_poli',array('id_poli'=>base64_decode($id_departemen)));    
}

public function data_akun(){
$query = $this->db->get('akun');
return $query;    
}

public function simpan_akun($data){

$this->db->insert("akun",$data);    
}

public function data_obat(){
$query = $this->db->get('data_obat');
return $query;    
}
public function simpan_obat($data){

$this->db->insert('data_obat',$data);    
}
function json_data_obat(){
$this->datatables->select('id_obat,'
. 'data_obat.id_data_obat as id_data_obat,'
. 'data_obat.nama_obat as nama_obat,'
. 'data_obat.harga_obat as harga_obat,'
. 'data_obat.stok_obat as stok_obat,'
);

$this->datatables->from('data_obat');
$this->datatables->add_column('view','<a class="btn btn-sm btn-danger fa fa-trash " href="'.base_url().'Pengaturan/hapus_obat/$1"></a>', 'base64_encode(id_obat)');
return $this->datatables->generate();

}    
}