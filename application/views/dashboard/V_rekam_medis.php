<body onload="halaman_resep();"></body>
<div class="container p-3">
<h2 align="center"> Selamat datang Dokter <?php echo $this->session->userdata('nama_lengkap') ?></h2><hr>
<div class="row">

<div class="col-md-8 ">
    <div class="card p-3 mt-3">    
<h4><?php echo $this->session->userdata('nama_poli') ?></h4><hr>
<table id="data_rekam_medis" class="table table-striped table-condensed  table-hover table-sm"><thead>
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
<div class="card col  p-3 mt-3  ml-2" >
<input type="text"  id="cari_obat" class="form-control" placeholder="Cari Obat . . ."><hr>

<div id="halaman_resep">

</div>

</div>  

</div>
</div>

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

var t = $("#data_rekam_medis").dataTable({


initComplete: function() {
var api = this.api();
$('#data_rekam_medis')
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
"url": "<?php echo base_url('Rekam_medis/json_data_rekam_medis') ?> ", 
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
{"data": "view"}


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

var t = $("#data_pasien_selesai").dataTable({


initComplete: function() {
var api = this.api();
$('#data_pasien_selesai')
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
"url": "<?php echo base_url('Rekam_medis/json_data_pasien_selesai') ?> ", 
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
{"data": "status_pemeriksaan"},
{"data": "view"}


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

<script type="text/javascript">

function buat_resep(param){

$.ajax({
type:"POST",
url:"<?php echo base_url('Rekam_medis/buat_resep') ?>",
data:"id_data_pemeriksaan="+param,
success:function(response){
halaman_resep();   
}

});

}

function halaman_resep(){
$.ajax({
type:"POST",
url:"<?php echo base_url('Rekam_medis/halaman_resep') ?>",
data:"",
success:function(response){
$("#halaman_resep").html(response);

}

});
}




$(function () {

$("#cari_obat").autocomplete({
minLength:0,
delay:0,
source:'<?php echo base_url('Rekam_medis/cari_obat') ?>',
select:function(event, ui){

$.ajax({
type:"POST",
url:"<?php echo base_url('Rekam_medis/set_obat') ?>",
data:"id_data_obat="+ui.item.id_data_obat,
success:function(response){
 halaman_resep();   
}
        


});

}

});

});

function hapus_obat(z){
$.ajax({
type:"POST",
url:"<?php echo base_url('Rekam_medis/hapus_obat') ?>",
data:"id_hapus="+z,
success:function(response){
 halaman_resep();   
}
});

}

function update_obat(i){
var jumlah = $("#id_obat"+i).val();


$.ajax({
type:"POST",
url:"<?php echo base_url('Rekam_medis/update_obat') ?>",
data:"jumlah="+jumlah+"&id_obat="+i,
success:function(response){
 halaman_resep();   
}
});

}

</script> 
<style>
.ui-autocomplete{position:absolute;z-index:1000;cursor:default;padding:10px;margin-top:2px;color:#fff;list-style:none;background-color:#2c3e50;border:1px solid #ccc;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 5px 10px rgba(0,0,0,.2);-moz-box-shadow:0 5px 10px rgba(0,0,0,.2);box-shadow:0 5px 10px rgba(0,0,0,.2)}.ui-autocomplete>li{padding:3px 20px}.ui-autocomplete>li.ui-state-focus{background-color:#ec971f;color:#fff}.ui-helper-hidden-accessible{display:none}.cover{width:252px;height:185px}.cover2{width:348px;height:314px}
</style>


<div class="container">

<div class="card p-3">
    <h4 align="center">Data Pasien <?php echo $this->session->userdata('nama_poli') ?></h4>    

<table id="data_pasien_selesai" class="table table-striped table-condensed  table-hover table-sm"><thead>
<tr role="row">
<th  align="center"    aria-controls="datatable-fixed-header"  >No</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >No.Pemeriksaan</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Nama Pasien</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Tanggal masuk</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Status Periksa</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody align="center">
</table>
    
</div>
</div>
</div>