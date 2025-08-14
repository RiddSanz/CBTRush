
<?php
include "lib/configuration.php";
$sql = "select * from t_peserta where pengguna='".$_SESSION['userid']."' limit 0,1";
//echo $sql;
$rs = mysqli_query($db,$sql);
$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
$cpeserta='0';
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if(isset($_SESSION['soals']))
	{
		$cpeserta='1';
	}
	//echo $cpeserta;
	?>
	
	<script type="text/javascript">
	$(document).ready(function() {
		var cp = <?php echo $cpeserta;?>;
		if(cp=='1')
		{
			$("#divhide").hide();
		}
		else
		{
			$("#divhide").show();
		}
				
		$("#divshow").click(function()
		{
			$("#divhide").toggle();
		});
	});
	</script>
	<div id="divshow" class="divshow">Biodata Pengguna &#65516;</div>
	<div id='divhide'>
		<div class="box">
			<label>Nama Pengguna</label>
			<div class="boxuser"><?php echo "".$_SESSION['user_nama'];?></div>
			<label>UID :</label> <?php echo " ".$_SESSION['userid'];?> , <?php echo " ".$_SESSION['kelompok_user'];?><br>
			<?php 
			if ($_SESSION['userid']!='admin') {
				?>
				<label>SID :</label> <?php echo " ".$_SESSION['sid_user'];?> <br>
				<?php
			}
			?>
			<div class='spasi'></div>
			<span class='btnLogout' onclick="window.location='pwww/logout.php'">
				Logout
			</span>&nbsp;
			<span class='btnCh' onclick="window.location='?pg=chpass'">
				Change Password
			</span>
			<br>
		</div>
	</div>
	<br>
	<?php 
}
?>
