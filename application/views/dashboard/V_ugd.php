<div class="container">

<div class="row">
<div class="col-md-8">
<div class="card p-3 mt-3">
<h4 align="center">Metode pembayaran</h4><hr>
<div class="row">
<div class="col">  <button id="umum" class="btn btn-success form-control">UMUM</button></div>   
<div class="col"> <button id="bpjs" class="btn btn-success form-control">BPJS</button>
</div>   
</div>


</div>

<div class="card p-3 mt-2">
<table id="data_pasien" class="table table-striped table-condensed  table-hover table-sm"><thead>
<tr role="row">
<th  align="center"    aria-controls="datatable-fixed-header"  >No</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >No.Pemeriksaan</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Nama Pasien</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Tanggal masuk</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody align="center">
</table>
</div>


</div>
<div class="col">
<div class="card p-3 mt-3">
<h4 align="center">DATA FORM UGD</h4><hr>
<div id="tampil_bpjs" style="display: none;">
<label>Nomor BPJS</label>
<input id="nomor_bpjs" onchange="tampilkan_bpjs();" type="text" class="form-control">    
</div>

<label>Nama Pasien</label>
<input type="text" id="nama_pasien" value="" class="form-control">
<label>Alamat Lengkap</label>
<textarea id="alamat_pasien" value="" class="form-control"></textarea>
<label>Dibawa ke</label>
<select id="nama_poli" value=""  class="form-control">
<?php foreach ($poli->result_array() as $pol ){ ?>
<option value="<?php echo $pol['id_data_poli'] ?>"><?php echo $pol['nama_poli'] ?></option>
<?php } ?>
</select>
<hr>
<label>Nama Kerabat</label>
<input id="nama_kerabat" type="text" value="" class="form-control">
<label>Nomor Kontak kerabat</label>
<input id="nomor_kontak_kerabat" value="" type="text" class="form-control">
<label>Alamat Lengkap kerabat</label>
<textarea id="alamat_lengkap_kerabat" value="" class="form-control"></textarea>
<hr>
<button class="btn btn-success" id="simpan_pasien">Simpan Pasien</button>
</div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$("#umum").click(function(){

$("#nama_pasien").val("");
$("#alamat_pasien").val("");
$("#nomor_bpjs").val("");

$("#nama_pasien").attr("readonly",false);
$("#alamat_pasien").attr("readonly",false);
$("#tampil_bpjs").hide();
});   
$("#bpjs").click(function(){
$("#nama_pasien").attr("readonly",true);
$("#alamat_pasien").attr("readonly",true);
$("#tampil_bpjs").show();

    
});



$("#simpan_pasien").click(function(){
var nama_pasien   = $("#nama_pasien").val();
var alamat_pasien = $("#alamat_pasien").val();
var nomor_bpjs    = $("#nomor_bpjs").val();
var nama_poli     = $("#nama_poli option:selected").text();
var id_data_poli  = $("#nama_poli").val();
var nama_kerabat            = $("#nama_kerabat").val();
var nomor_kontak_kerabat    = $("#nomor_kontak_kerabat").val();
var alamat_lengkap_kerabat  = $("#alamat_lengkap_kerabat").val();

if( nama_pasien !='' && alamat_pasien !='' && nama_poli !='' && nama_kerabat !='' && nomor_kontak_kerabat !='' && alamat_lengkap_kerabat !='' ){
 
$.ajax({
type:"POST",
url:"<?php echo base_url('Ugd/simpan_pasien') ?>",
data:"nama_pasien="+nama_pasien+"&nomor_bpjs="+nomor_bpjs+"&nama_poli="+nama_poli+"&id_data_poli="+id_data_poli+"&nama_kerabat="+nama_kerabat+"&nomor_kontak_kerabat="+nomor_kontak_kerabat+"&alamat_lengkap_kerabat="+alamat_lengkap_kerabat+"&alamat_pasien="+alamat_pasien,
success:function(response){
if(response == "berhasil"){

swal({
type:"success",
text:"Simpan Pasien Berhasil"
});    
    
            
}else{
    
swal({
type:"error",
text:response
});    
    
}
}
});

}else{
swal({
type:"warning",
text:"Masih ada data yang harus disi"
});    
}



});

});

function tampilkan_bpjs(){
var nomor_bpjs = $("#nomor_bpjs").val();
$.ajax({
type:"POST",
url:"<?php echo base_url('Ugd/api_bpjs') ?>",
data:"nomor_bpjs="+nomor_bpjs,
success:function(response){
if(response == "no_available"){
swal({
type:"warning",
text:"Nomor BPJS Tidak ditemukan"
});    
}else{
var z = JSON.parse(response);

$("#nama_pasien").val(z.nama_lengkap);
$("#alamat_pasien").val(z.alamat_lengkap);

swal({
type:"success",
text:"Nomor BPJS ditambahkan"
});
} 
}
    
});

}


</script>
<script type="text/javascript">
 $(document).ready(function() {
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
{
return {
"iStart": oSettings._iDisplayStart,
"iEnd": oSettings.fnDisplayEnd(),
"iLength": oSettings._iDisplayLength,
"iTotal": oSettings.fnRecordsTotal(),
"iFilteredTotal": oSettings.fnRecordsDisplay(),
"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
};
};

var t = $("#data_pasien").dataTable({
    
    
initComplete: function() {
var api = this.api();
$('#data_pasien')
.off('.DT')
.on('keyup.DT', function(e) {
if (e.keyCode == 13) {
api.search(this.value).draw();
}
});
},
oLanguage: {
sProcessing: "loading..."
},
processing: true,
serverSide: true,
ajax: {
 "url": "<?php echo base_url('Ugd/json_data_pasien') ?> ", 
"type": "POST",
data: function ( d ) {
}
},
columns: [
{
"data": "id_data_pemeriksaan",
"orderable": false
},
{"data": "nomor_pemeriksaan"},
{"data": "nama_pasien"},
{"data": "tanggal_masuk_ugd"},
{"data": "view"},


],
order: [[1, 'desc']],
rowCallback: function(row, data, iDisplayIndex) {
var info = this.fnPagingInfo();
var page = info.iPage;
var length = info.iLength;
var index = page * length + (iDisplayIndex + 1);
$('td:eq(0)', row).html(index);
}
});
});</script>   
