<div class="container">
<div class="row">
<div class="col ">
<div class="card p-2 mr-2">
    <h3 align="center">Input Nama Obat</h3><hr>   
<label>Nama Obat:</label>
<input type="text" id="nama_obat" class="form-control">

<label>Harga Obat:</label>
<input type="text" id="harga_obat" class="form-control">

<label>Stok Obat:</label>
<input type="text" id="stok_obat" class="form-control">

<hr>
<button id="simpan_obat" class="btn btn-primary">Simpan</button>
</div>
</div>
<div class="col-md-7 card p-2">
<table id="data_obat" class="table table-striped table-condensed  table-hover table-sm"><thead>
<tr role="row">
<th  align="center"    aria-controls="datatable-fixed-header"  >No</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Id Obat</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Nama Obat</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Harga Obat</th>
<th  align="center"     aria-controls="datatable-fixed-header"  >Stok Obat</th>
<th style="width: 20%;" align="center"     aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody align="center">
</table>


</div>
</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
$("#simpan_obat").click(function(){
    
var nama_obat  = $("#nama_obat").val();    
var harga_obat = $("#harga_obat").val();    
var stok_obat  = $("#stok_obat").val();    
if(nama_obat !='' && harga_obat !='' && stok_obat !=''){
        
 $.ajax({
type:"POST",
url:"<?php echo base_url('Pengaturan/simpan_obat') ?>",
data:"nama_obat="+nama_obat+"&harga_obat="+harga_obat+"&stok_obat="+stok_obat,
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
text:"Masih terdapat data yang perlu diisi"
});
}   
}); 
});    
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

var t = $("#data_obat").dataTable({
    
    
initComplete: function() {
var api = this.api();
$('#data_obat')
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
 "url": "<?php echo base_url('Pengaturan/json_data_obat') ?> ", 
"type": "POST",
data: function ( d ) {
}
},
columns: [
{
"data": "id_obat",
"orderable": false
},
{"data": "id_data_obat"},
{"data": "nama_obat"},
{"data": "harga_obat"},
{"data": "stok_obat"},
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
