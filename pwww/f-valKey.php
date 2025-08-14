<?php
include "lib/configuration.php";
include"tgl.php";
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	<script>
	$(document).ready(function(){
		//alert('Testing');
		$("#btnValKey").click(function(){
			//alert('Testing');
			var valKEY = $('#valKEY').val();
			var url = $('#url').val();
			//alert(valKEY);
			$.ajax({
				type:'GET',
				url:'pwww/p-valKey.php',
				data:'ajax=1&valKEY='+valKEY+'&url='+url,
				success:function(data) {
					if(data==1){	// DO SOMETHING
						//$("body").load("index.php?pg=rtoken").hide().fadeIn(1500).delay(6000);
						$("#previewkey").html('<img src="images/success.png" alt="Uploading...." width="25px"/>');
						window.location="?pg=lsekolah";
					}else{
						//DO SOMETHING
						alert(data);
					}
				}
			});
		});
		$("#btnGenKey").click(function(){
				//alert('Testing');
				//var valKEY = $('#valKEY').val();
				//alert(valKEY);
				$.ajax({
					type:'GET',
					url:'pwww/p-gen-valkey.php',
					data:'ajax=1',
					success:function(data) {
						if(data){	// DO SOMETHING
							$("#previewkey").html(data);
							//$("body").load("index.php?pg=rtoken").hide().fadeIn(1500).delay(6000);
						}
					}
				});
			});
	});
	</script>
	<div class="cpanel">
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsekolah'"><?=$site2;?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class='rtoken'>
			<input type='text' id='url' class='input2' value='server-cbt'>
			<br>
			<input type='text' value='' id='valKEY' class='input2 wd50' placeholder='Masukkan Validasi Key'>
			<br>
			<input type='button' value='Submit Key' id='btnValKey'>
		</div>
		<?php
		if ($_SESSION['kelompok_user']=='su') {
		?>
		<div class='spasi'></div>
		<div class='rtoken'>
			<input type='button' value='Generate Key' id='btnGenKey' class='prakatanew'>
		</div>
		<?php
		}
		?>
		<div id="previewkey"></div>
		<div class='spasibesar'></div>
	</div>
<?php

}
?>
