<nav class="navbar navbar-expand-lg" style="background:#17a2b8; color: #fff;" >
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<div class="col">
    <h3>Rekam Medis</h3> 
</div>
<div class="col text-right">
<button class="btn btn-light" id="keluar">Keluar <span class="fa fa-sign-out"></span></button> 
</div>
</div>
</nav>



<script type="text/javascript">
$(document).ready(function(){

$("#keluar").click(function(){
$.ajax({
 type:"POST",
 url:"<?php echo base_url('Dashboard/keluar') ?>",
 data:"",
 success:function(){
  swal({
type:"success",
text:"Logout Berhasil"
}).then(function(){
window.location.href = "<?php echo base_url('') ?>";
});
      
 }
});
});        

});
</script>    
