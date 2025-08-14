<?php
$_SESSION['fdata']='';
$_SESSION['fdata2']='';
include "lib/configuration.php";
include"tgl.php";

$bulan = array("January","Pebruary","Maret","April","Mei","Juni","Juli","Agustus","September","Okotober","Nopember","Desember");

$hari  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");

$sql = "select * from t_token limit 0,1";

$rs = mysqli_query($db,$sql);


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
		$("#ena_token").click(function(){		   	   
		   $("#preview").fadeIn("slow");
		   $("#preview").html('');
			$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
			$.post( "pwww/p-ena-token.php",{ ena_token:"ok"})
			.done(function(data) {			 
			  if (data==1) {
			  	$("#preview").html('<img src="images/success.png" alt="Uploading...." width="15px"/>');			  	
			  }else
			  {
			  	$("#preview").html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');			  	
			  }
			})
			.fail(function() {
			   $("#preview").html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
			})
			.always(function() {
				$("#preview").fadeOut(3000);
			});
		 });

		$("#rilistoken").click(function(){
			
			var fdata = $('#fdata').val();
			
			$.ajax({
				type:'GET',
				url:'pwww/p-updatetoken.php',
				data:'ajax=1&fdata='+fdata,
				success:function(data) {
					if(data==1){	
						$("body").load("index.php?pg=rtoken").hide().fadeIn(1500).delay(6000);
					}else{ 
						
						alert(data);
					}
				}
			});
		});
	});
	</script>
	<div class="cpanel">
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
		</ul>
		<div class='spasi'></div>		
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '
				<center>DATA UNIT KD MASIH KOSONG</center>
				';
			} 
			else
			{
				$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
				$texp = $br['tgl_exp'];
				$ena_token = $br['enable_token'];
				list($date1,$time1) = explode(" ",$texp);
				list($y,$m,$t) =  explode("-",$date1);
				
				/*echo $time1.' , '.$t.' '.$bulan[intval(date('m',strtotime($tgl1))) - 1].' '.$y;*/
				?>
				<div class='rtoken'>
					<input type='text' value='<?=$br['token'];?>' id='fdata' class='input2 wd25 prakatanew' placeholder='Masukkan Token'>
					<br>
					<div class='prakatanew2'>Berlaku sampai : <?php echo $time1.' , '.$t.' '.$bulan[intval(date('m',strtotime($texp))) - 1].' '.$y;?>
					</div>
					<br>
					<input type='button' value='RILIS TOKEN' id='rilistoken' class='prakatanew'> <br>					
				</div>
				<div class='spasi'></div>
				<input type="checkbox" id="ena_token" name='ena_token' value="<?=$ena_token;?>"  class='ena_token'  <?php if($ena_token=='1'){echo "checked";}?>> 
				<label for="ena_token">Aktifkan Token</label><div class="checkUser" id='pre-ena_token'></div>
				<div id="preview"></div>
			<?php 
			}
			?>
		<div class='spasibesar'></div>
	</div>
<?php
	
}
?>