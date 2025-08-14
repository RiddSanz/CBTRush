<?php
include "lib/configuration.php";
include "tgl.php";
$skid = $_SESSION['sid_user'];
$_SESSION['fadduser'] = $tgl;
?>
<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function(){

	if ($('#id').val()=='') {
		$('#login').hide();
	}else
	{
		$('#login').show();
	}

	$('#uid').change(function()
	{
		var uid = $('#uid').val();
		$("#preview").html('');
		$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
		$.post( "pwww/p-checkAddpengguna.php",{ uid:""+uid })
		.done(function(data) {

		  if (data==0) {
		  	$("#preview").html('<img src="images/success.png" alt="Uploading...." width="25px"/>');
		  	$('#login').show();
		  }else
		  {
		  	$("#preview").html('<img src="images/fail.png" alt="Uploading...." width="25px"/>');
		  	$('#login').hide();
		  }
		})
		.fail(function() {
		    alert( "Error" );
		})
		.always(function() {

		});
	});

	$("#login").click(function()
	{
		//alert("test");
		var uid=$("#uid").val();
		var pengguna=$("#pengguna").val();
		var kunci=$("#kunci").val();
		var tingkat=$("#tingkat").val();
		var agama=$("#agama").val();
		var ruang=$("#ruang").val();
		var sesi=$("#sesi").val();
		var kelompok=$("#kelompok").val();
		var sekolah=$("#sekolah").val();
		var id=$("#id").val();
		var dataString = 'uid='+uid+'&pengguna='+pengguna+'&agama='+agama+'&ruang='+ruang+'&kunci='+kunci+'&tingkat='+tingkat+'&kelompok='+kelompok+'&id='+id+'&sekolah='+sekolah+'&sesi='+sesi;
		if($.trim(uid).length>0 && $.trim(pengguna).length>0 && $.trim(kunci).length>0)
		{
			$.ajax({
				type: "POST",
				url: "pwww/p-addpengguna.php",
				data: dataString,
				cache: false,
				success: function(data){
					if(data=="1")
					{
						/*$("body").load("index.php?pg=users").hide().fadeIn(1500).delay(6000);*/
						$("#error").html("<span style='color:green'>Sukses!!!!</span> ");
						window.location="index.php?pg=users";

					}
					else if(data=="2")
					{
						$("#login").val('Simpan Pengguna');
						$("#error").html("<span style='color:#cc0000'>Proses penyimpanan gagal!!!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);
					}
					/*$("#error").html(data);*/
				}
			});

		}
		return false;
	});

});
</script>
<?php
$ses_tingkatU = $_SESSION['tingkat_user'];
$ses_kelU = $_SESSION['kelompok_user'];
if (isset($_GET['s'])) {

	$sql = "select * from t_peserta where pid='".$_GET['s']."' limit 0,1";

	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$pid = $br['pid'];
	$uid = $br['pengguna'];
	$nmpengguna = $br['nama_pengguna'];
	$pass = $br['kunci'];
	$tingkatU = $br['tingkat'];
	$agama = strtolower($br['agama']);
	$ruang = $br['ruang'];
	$sesiU = $br['sesi'];
	$kelU = $br['kelompok'];
	$sekU = $br['sekolah'];

}
else
{

	$pid = '';
	$uid = '';
	$nmpengguna = '';
	$pass = '';
	$tingkatU = '';
	$agama = '0';
	$ruang = '';
	$sesiU = '1';
	$kelU = '';
	$sekU = '';
}
$list_agama  = array('-','islam','katholik',
	'kristen','hindu','budha','khonghucu'
	,'lainnya' );
?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=users'"><?=$site2;?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
</ul>
<div class='spasi'></div>
<form method="POST">
	<table id="t02">
		<tr>
			<td>Username</td>
			<td>
				<input type="hidden" name="id" value="<?=$pid;?>" id="id">
				<input type="text" name="uid" value="<?=$uid;?>" id="uid" placeholder="User ID" class="style-3 wd25" <?php if(!empty($br['pengguna'])) echo "readonly='yes'";?>>
				<div class="checkUser" id='preview'></div>
			</td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="text" name="kunci" value="<?=$pass;?>" id="kunci" placeholder="Password" class="style-3 wd25"></td>
		</tr>
		<tr>
			<td>Nama Pengguna</td>
			<td><input type="text" name="pengguna" value="<?=$nmpengguna;?>" id="pengguna" placeholder="Pengguna" class="style-3 wd50"></td>
		</tr>
		<tr>
			<td>Agama</td>
			<td>
				<select name="agama" id="agama" class="style-3 wd15">
					<?php
					for ($i=0; $i < count($list_agama); $i++) {
						?>
						<option value="<?=$list_agama[$i];?>" <?php if($agama==$list_agama[$i]) echo 'selected';?>><?=$list_agama[$i];?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status Pengguna</td>
			<td>
				<select name="tingkat" id="tingkat" class="style-3 wd15">
					<option value="2" <?php if($tingkatU=='2') echo 'selected';?>>Siswa</option>
					<?php
					if($ses_tingkatU=='0' && $ses_kelU=='admin')
					{
						?>
						<option value="1" <?php if($tingkatU=='1') echo 'selected';?>>Guru</option>
						<?php
					}
					if ($ses_tingkatU=='0' && $ses_kelU=='su') {
						?>
						<option value="1" <?php if($tingkatU=='1') echo 'selected';?>>Guru</option>
						<option value="0" <?php if($tingkatU=='0') echo 'selected';?>>Admin</option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Kelas</td>
			<td>
				<input type="text" name="kelompok" id="kelompok" value="<?=$kelU;?>" placeholder="Misal : XII APK 1" class="style-3 wd25">
			</td>
		</tr>
		<tr>
			<td>Ruang Ujian</td>
			<td>
				<input type="text" name="ruang" value="<?=$ruang;?>" id="ruang" placeholder="Ruang Ujian" class="style-3 wd525">
				<span class="note">Note: tidak perlu diisi jika tingkat user adalah Guru</span>
			</td>
		</tr>
		<tr>
			<td>Sesi Ujian</td>
			<td>
				<select name="sesi" id="sesi" class="style-3 wd15">
					<option value="1" <?php if($sesiU=='1') echo 'selected';?>>Sesi 1</option>
					<option value="2" <?php if($sesiU=='2') echo 'selected';?>>Sesi 2</option>
					<option value="3" <?php if($sesiU=='3') echo 'selected';?>>Sesi 3</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Instansi</td>
			<td>
				<select name="sekolah" id="sekolah" class="style-3">
					<?php
					if($ses_tingkatU=='0' && $ses_kelU=='admin')
					{
						$s = "select * from t_sekolah order by nama_sekolah asc";
						?>
						<option value="" <?php if($sekU=='') echo 'selected';?>>---------</option>
						<?php
					}
					else
					{
						$s = "select * from t_sekolah where sid='$skid' order by nama_sekolah asc";
					}
					$r = mysqli_query($db,$s);
					$cr = mysqli_num_rows($r);
					while ( $b = mysqli_fetch_array($r,MYSQLI_ASSOC))
					{
					?>
						<option value="<?=$b['sid'];?>" <?php if($b['sid']==$skid) echo 'selected';?>><?=$b['nama_sekolah'];?></option>
					<?php
					}
					?>

				</select>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<input type="button" class="tombol" value="Simpan Pengguna" name="save" id="login">
				<input type="button" value="Batal" class="tombol" onclick="window.location='?pg=users'">
				<div id="error"></div>
			</td>
		</tr>
	</table>
</form>
