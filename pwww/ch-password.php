<?php 
//session_start();
$pid = $_SESSION['pid'];
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>
<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function(){
	//alert('Test');
	$("#btnsave").click(function()
	{
		var oldp=$("#oldp").val();
		var newp=$("#newp").val();
		var confirmp=$("#confirmp").val();
		if (newp==confirmp) {
			//alert(oldp);
			$.ajax({
				type:'GET',
				url:'pwww/p-ch-password.php',
				data:'ajax=1&oldp='+oldp+'&newp='+newp,
				success:function(data) {
					if(data==1){	// DO SOMETHING
						//$("body").load("index.php").hide().fadeIn(1500).delay(6000);
						$("#error").html('Ganti password berhasil!');
					}else{
						//alert(data);
						//DO SOMETHING 
						//$("body").load("index.php?pg=chpass").hide().fadeIn(1500).delay(6000);
						$("#error").html("<span style='color:#cc0000'>Ganti password gagal!.</span> ");
					}
				}
			});
		}
		else{
			//alert('New Password dan Confirm Password tidak sama!');
			$("#error").html("<span style='color:#cc0000'>New Password dan Confirm Password tidak sama!.</span> ");
		}
	});

});
</script>
<?php 
?>
<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
<div class='spasi'></div>
<form method="POST" enctype="multipart/form-data">
	<label>Password Lama</label><br>
	<input type="password" name="oldp" id="oldp" placeholder="Masukan Password lama anda" class="input2 wd25"><br>
	<label>Password Baru</label><br>
	<input type="password" name="newp" id="newp" placeholder="Masukan Password baru anda" class="input2 wd25"><br>
	<label>Konfirmasi Password</label><br>
	<input type="password" name="confirmp" id="confirmp" placeholder="Confirm Password anda" class="input2 wd25"><br>
	<input type="button" class='tombol' value="Ganti Password" name="save" id="btnsave"> 
</form>
<div class='spasi'></div>
<div id="error"></div>
<div class='spasi'></div>
<?php 
}
?>