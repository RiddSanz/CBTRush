<?php
include "pwww/tgl.php";
$tanggal_now = date("Y-m-d",$timestamp);
$jam_now = date("H:i:s",$timestamp);

if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if($_SESSION['tingkat_user']=='0')
	{
		$wkt = exec('date');
		
	?>
	<?php 
		if (isset($_SESSION['trueValKey']) && $_SESSION['tingkat_user']=='0') 
		{
		?>
		<script>
		$(document).ready(function(){
			$("#btnsave").click(function()
			{
				var tanggal=$("#tanggal").val();
				var jam=$("#jam").val();
				
				if ($.trim(tanggal).length>0 && $.trim(jam).length>0) {
					$.ajax({
						type:'POST',
						url:'pwww/p-set-time.php',
						data:'action=setwaktu&tanggal='+tanggal+'&jam='+jam,
						success:function(data) {
							if(data==1){
								$("#error").html('setting waktu berhasil! tunggu <span id="count">120</span> detik');
								//window.setTimeout( show_popup, 90000 );
								var counter=120;
								window.setInterval(
									function() {
									    counter--;
									    if (counter >= 0) {
									      span = document.getElementById("count");
									      span.innerHTML = counter;
									    }
									    // Display 'counter' wherever you want to display it.
									    if (counter === 0) {
									        //alert('this is where it happens');
									        clearInterval(counter);
									        show_popup();
									    }

									  }, 1000);
							}else{
								$("#error").html(data);
							}							
						}
					});
				}
				
			});
			$("#btnnull").click(function()
			{
					$.ajax({
						type:'POST',
						url:'pwww/p-set-null.php',
						data:'action=setwaktu&tanggal='+tanggal+'&jam='+jam,
						success:function(data) {
							if(data==1){
								$("#error").html('simpan waktu berhasil!');								
							}else{
								$("#error").html(data);
							}							
						}
					});				
			});

			function show_popup(){
      			window.location='?pg=setTM';
   			};
		});
		</script>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=ms'"><?=$site1;?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
		</ul>
		<div class="cpanel">
			<h3>KONFIGURASI WAKTU SERVER</h3>		
			<form style="padding-left:20px;">
				<label>Tanggal</label><br>
				<input name="tanggal" id="tanggal" value="<?=$tanggal_now;?>" type="date" class="input2 wd25"><br>
				<label>Jam</label><br>
				<input name="jam" id="jam" value="<?=$jam_now;?>" type="time" class="input2 wd25"><br>
				<input type="button" value="set waktu" id="btnsave">
				<input type="button" value="Simpan konfigurasi" id="btnnull">
				<input type="button" value="Batal" class="tombol" onclick="window.location='?pg=ms'">
			</form>				
		</div>
		<div id="error"></div>
		<div class="spasi"></div>			
	<?php 
		}
	?>		
	<?php 
	}
	else
	{
		echo "<div class='nm-list-section'>SYSTEM PANEL CBT</div>";
		echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR SEBAGAI ADMIN</h3>";
		echo "<div class='spasi'></div>";
	}
}
?>