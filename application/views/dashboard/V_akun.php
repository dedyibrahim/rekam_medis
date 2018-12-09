<div class="container">
<div class="row">
<div class="col card p-2 mr-2">
<h5 align="center">Input User</h5><hr>
<label>Nama Dokter / Nama Lengkap</label>
<input type="text" id="nama_lengkap" value="" class="form-control">
<label>Nomor Kontak</label>
<input type="text" id="nomor_kontak" value="" class="form-control">
<label>Level</label>
<select id="level" class="form-control">
<option value="Admin">Admin</option>
<option value="Super Admin">Super Admin</option>
</select>
<label>Bekerja di</label>
<select id="bekerja" name="bekerja" class="form-control">
<option value="UGD">UGD</option>
<option value="REKAM MEDIS">REKAM MEDIS</option>
<option value="APOTIK">APOTIK</option>
</select>
<div id="tampil_poli" style="display: none;">
<label>Nama Poli</label>
<select name="nama_poli" id="nama_poli"class="form-control">
<?php foreach($poli->result_array() as $data_poli){ ?>
<option value="<?php echo $data_poli['id_data_poli'] ?>"><?php echo $data_poli['nama_poli'] ?></option>
<?php } ?>
</select> 
</div>
<hr>
<label>Username:</label>
<input id="username" value="" type="text" class="form-control">
<label>Password:</label>
<input id="password" value="" type="password" class="form-control">
<label>Ulangi Password:</label>
<input id="ulangi_password" value="" type="password" class="form-control">
<hr>
<button id="simpan_akun" class="btn btn-primary">Simpan</button>

</div>
<div class="col-md-7 card p-2">
<table class="table table-sm table-hover table-striped table-bordered">
<tr>
<th>No</th>
<th>Username / Nama Lengkap </th>
<th>Level</th>
<th>Nomor Kontak</th>
<th>Bekerja</th>
<th>Aksi</th>
</tr>
<?php $b=1; foreach ($akun->result_array() as $data_akun){ ?>
<tr>
<td><?php echo $b++; ?></td>
<td><?php echo $data_akun['username'] ." / ". $data_akun['nama_lengkap'] ?></td>
<td><?php echo $data_akun['level'] ?></td>
<td><?php echo $data_akun['nomor_kontak'] ?></td>
<td><?php echo $data_akun['bekerja'] ?></td>
<td><a href="<?php echo base_url('Pengaturan/hapus_akun/'. base64_encode($data_akun['id_akun'])) ?>"<button class="btn btn-danger"><span class="fa fa-close"></span></button></a></td>
</tr>
<?php  } ?>
</table>
</div>
</div>
</div>

<script type="text/javascript">

$(document).ready(function(){
$("#bekerja").on("change",function(){
var bekerja = $("#bekerja").val();
console.log(bekerja);

if(bekerja == "REKAM MEDIS"){
$("#tampil_poli").show();    
    
}else{
$("#tampil_poli").hide();    
}

});    
 
 
$("#simpan_akun").click(function(){
 
var nama_lengkap        = $("#nama_lengkap").val();
var nomor_kontak        = $("#nomor_kontak").val();
var level               = $("#level").val();
var bekerja             = $("#bekerja").val();
var nama_poli           = $("#nama_poli option:selected").text();
var id_data_poli        = $("#nama_poli").val();
var username            = $("#username").val();
var password            = $("#password").val();
var ulangi_password     = $("#ulangi_password").val();

if(password != ulangi_password){
 swal({
  type:"warning",
  text:"Password tidak sama"   
 });   
}else{
    
if(nama_lengkap !='' && nomor_kontak !='' && level !='' && bekerja !='' && username !='' && password !='' ){
 
                
 $.ajax({
 type:"POST",
 url:"<?php echo base_url('Pengaturan/simpan_user') ?>",
 data:"nama_lengkap="+nama_lengkap+"&nomor_kontak="+nomor_kontak+"&level="+level+"&bekerja="+bekerja+"&nama_poli="+nama_poli+"&id_data_poli="+id_data_poli+"&username="+username+"&password="+password,
 success:function(response){
 console.log(response);    
 }
     
 });
 
 
swal({
type:"success",
text:"Akun Berhasil Tersimpan"
}).then(function(){
window.location.href = "<?php echo base_url('Pengaturan') ?>";
});
 
 
}else{
 swal({
  type:"warning",
  text:"Masih ada data yang harus di isi"   
 }); 
 
}    
    
    
}



});
});

</script>    

