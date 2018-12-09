<div class="container">
<div class="row">
<div class="col ">
<div class="card p-2 mr-2">
<label>Nama Poliklinik:</label>
<input type="text" id="poliklinik" value="" class="form-control">

<hr>
<button id="simpan_poliklinik" class="btn btn-primary">Simpan</button>
</div>
</div>
<div class="col-md-7 card p-2">
<table class="table table-hover table-condensed table-striped">
<tr>
<th>ID Poliklinik</th>
<th>Nama Poli</th>
<th>Aksi</th>
</tr>
<?php 
foreach ($poli->result_array() as $data_poli){
?>    
<tr>
<td><?php echo $data_poli['id_data_poli'] ?></td>   
<td><?php echo $data_poli['nama_poli'] ?></td>   
<td><a href="<?php echo base_url('Pengaturan/hapus_poli/'. base64_encode($data_poli['id_poli'])) ?>"><button class="btn btn-danger"><span class="fa fa-close"></span></button></a></td>
</tr>
<?php } ?>
</table>


</div>
</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
$("#simpan_poliklinik").click(function(){
    
var nama_poli = $("#poliklinik").val();    
if(nama_poli !=''){
        
 $.ajax({
type:"POST",
url:"<?php echo base_url('Pengaturan/simpan_poli') ?>",
data:"nama_poli="+nama_poli,
success:function(data){
if(data == "berhasil"){
 
 swal({
type:"success",
text:"Nama Poliklnik berhasil tersimpan"
}).then(function(){
window.location.href = "<?php echo base_url('Pengaturan/nama_poli') ?>";
});
 
}else{
swal({
type:"error",
text:"Terjadi Kesalahan"
});   
}    

}
});  
}else{
swal({
type:"warning",
text:"Nama Poli Belum di isi"
});
}   
}); 
});    
</script>    
