<div class="container">
<div class="row">
<div class="col pt-5">
<img style="width: 100%;" src="<?php echo base_url() ?>assets/img/hospital.png" alt=""/>

</div>
<div class="col-md-4 pt-5 ">
<div class="card ">
<div class="card-header text-center">

<span class="fa fa-3x  fa-lock"></span><br>
<h3>Login Rekam Medis </h3>
</div>
<div class="card-body">
<label>Username</label>
<input type="text" id="username" value="" class="form-control" placeholder="Username . . .">
<label>Password</label>
<input type="password" id="password" value="" class="form-control" placeholder="Password  . . .">

</div>
<div class="card-footer text-muted">
<button id="login" on class="btn btn-success form-control">Login <span class="fa fa-lock"></span></button>
</div>
</div>   
</div>
</div>    
</div>
<script>
$(document).ready(function(){
$("#login").on("click keydown",function(){
var username =  $("#username").val();
var password =  $("#password").val();

if(username !='' && password !='' ){        
$.ajax({
type:"POST",   
url:"<?php echo base_url('C_login/proses_login') ?>",
data:"username="+username+"&password="+password,
success:function(data){
if(data == "berhasil"){
swal({
type:"success",
text:"Login Berhasil"
}).then(function(){
window.location.href = "<?php echo base_url('Dashboard') ?>";
});
    
 
}else{
swal({
type:"error",
text:"Email atau Password salah"
});
    
}
    
        
}

});
}else{
swal({
type:"warning",
text:"Username atau password belum di isi"
});
}
});    
});
</script>

