<?php
class M_login extends CI_Model{

public function  proses_login($cek){
$query = $this->db->get_where('akun',$cek);
return $query;
    
}


}