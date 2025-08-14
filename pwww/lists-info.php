<?php
include "lib/configuration.php";
$sql = "select * from t_ujian limit 1";

$rs = mysqli_query($db,$sql);
$totInfo = mysqli_num_rows($rs);
if (isset($_SESSION['kelompok_user'])) {
	$kelompok = $_SESSION['kelompok_user'];
}
else
{
	$kelompok = '';
}

?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']) || $_SESSION['tingkat_user']=='2')
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$nmKep = $br['kepsek'];
	$nipKep = $br['nip_kepsek'];
	$tglval = $br['tgl_ujian'];
	$ketF = $br['keterangan'];
	$logoS = $br['logo_sekolah'];
	$alamat = $br['alamat'];
	$email = $br['email'];
	$web = $br['website'];
	$jk = $br['judul_kartu'];
	$ww = $br['welcome_front'];
	$desain = $br['desain'];
	//echo $desain;
	if ($logoS=='') {
		$logo = 'crversion.png';
	}
	else
	{
		$logo = $logoS;
	}

	if (file_exists("logo/banner.png")) {
		$banner = "logo/banner.png";
	}
	elseif(file_exists("logo/banner.jpg"))
	{
		$banner = "logo/banner.jpg";
	}
	else
	{
		$banner = "images/piccbt2.png";
	}
	if (file_exists("logo/ttd.jpg")) {
		$ttd = "logo/ttd.jpg";
	}
	else
	{
		$ttd = "images/contoh-ttd.jpg";
	}
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#btSave").click(function()
		{
			var kepsek = $("#kepsek").val();
			var nipkepsek = $("#nipkepsek").val();
			var tglkartu = $("#tglkartu").val();
			var ketF = $("#ketF").val();
			var alamat = $("#alamat").val();
			var email = $("#email").val();
			var web = $("#web").val();
			var jk = $("#jk").val();
			var ww = $("#ww").val();
			var desain = $('input[name="desain"]:checked').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-update-info.php',
				data:'ajax=1&kepsek='+kepsek+'&nipkepsek='+nipkepsek+'&tglkartu='+tglkartu+'&ketF='+ketF+'&alamat='+alamat+'&email='+email+'&web='+web+'&jk='+jk+'&ww='+ww+'&desain='+desain,
				success:function(data) {
					if(data==1){
						$("#preview").html('Perubahan berhasil dilakukan!');
					}
					else
					{
						$("#preview").html('Perubahan gagal dilakukan!');
						//$("#preview").html(data);
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
		<div class="cinfo">
			<div class="pembatas"></div>
			<table>
				<tr>
					<td>Kepala Sekolah</td>
					<td>
						<input id="kepsek" name="kepsek" class="input2 wd50" placeholder="Nama kepala sekolah anda!" value="<?=$nmKep;?>">
					</td>
				</tr>
				<tr>
					<td>NIP Kepala Sekolah</td>
					<td>
						<input id="nipkepsek" name="nipkepsek" class="input2 wd25" placeholder="Contoh: NIP. 19830702 200902 1 002" value="<?=$nipKep;?>">
					</td>
				</tr>
				<tr>
					<td>Judul Kartu Peserta</td>
					<td><input id="jk" name="jk" class="input2 wd50" placeholder="UJIAN AKHIS SEMESTER" value="<?=$jk;?>"></td>
				</tr>
				<tr>
					<td>Tanggal Ujian di Kartu Peserta</td>
					<td><input id="tglkartu" name="tglkartu" class="input2 wd50" placeholder="Contoh: Surabaya , 01 Juni 2015" value="<?=$tglval;?>"></td>
				</tr>
				<tr>
					<td>Alamat Sekolah</td>
					<td><input id="alamat" name="alamat" class="input2 wd75" placeholder="Alamat sekolah" value="<?=$alamat;?>"></td>
				</tr>
				<tr>
					<td>Email Sekolah</td>
					<td><input id="email" name="email" class="input2 wd75" placeholder="Email sekolah" value="<?=$email;?>"></td>
				</tr>
				<tr>
					<td>Website Sekolah</td>
					<td><input id="web" name="web" class="input2 wd75" placeholder="Website sekolah" value="<?=$web;?>"></td>
				</tr>
				<tr>
					<td>Keterangan difooter</td>
					<td><input id="ketF" name="ketF" class="input2 wd75" placeholder="Keterangan email dan contact person!" value="<?=$ketF;?>"></td>
				</tr>
				<tr>
					<td>Kata sambutan</td>
					<td><textarea id="ww" name="ww" class="input2 wd75"><?=$ww;?></textarea></td>
				</tr>
				<tr>
					<td>Layout Login</td>
					<td>
						<img src="images/desain1.png" width="200px"><input type="radio" name="desain" value="1" <?php if($desain=='1') echo 'checked';?>> Desain 1
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<img src="images/desain2.png" width="200px"><input type="radio" name="desain" value="2" <?php if($desain=='2') echo 'checked';?>> Desain 2
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type="button" value="Simpan" id="btSave">
						<div id="preview"></div>
					</td>
				</tr>
			</table>
			<div class="pembatas"></div>
			<span class="label">Logo Sekolah</span>
			<form class="frm-tugas" name="frm-tugas" method="POST" enctype="multipart/form-data" action="pwww/p-logo-sekolah.php">
				<input type="file" name="file_tugas">
				<input type="submit" name="btn_save" value="Upload">
			</form>
			<div class="pembatas"></div>
			<span class="label">Baner Sekolah 896x312(png,jpg)</span>
			<form class="frm-tugas" name="frm-tugas2" method="POST" enctype="multipart/form-data" action="pwww/p-banner-sekolah.php">
				<input type="file" name="file_tugas2">
				<input type="submit" name="btn_save2" value="Upload">
			</form>
			<div class="pembatas"></div>
			<span class="label">Tanda tangan Kepsek dan tanggal kartu (jpg)</span>
			<form class="frm-tugas" name="frm-tugas3" method="POST" enctype="multipart/form-data" action="pwww/p-ttd-sekolah.php">
				<input type="file" name="file_tugas3">
				<input type="submit" name="btn_save3" value="Upload">
			</form>
			<div class="photoFrame" title="Gambar halaman depan">
				<img src="<?=$ttd;?>" height="53px">	<br>
				Tanda tangan dan tanggal kartu ujian
			</div>
			<div class="photoFrame" title="Gambar halaman depan">
				<img src="<?=$banner;?>" height="53px">	<br>
				Banner Halaman depan
			</div>
			<div class="photoFrame" title="Logo Sekolah">
				<img src="logo/<?=$logo;?>" height="53px"><br>
				Logo Sekolah
			</div>
		</div>

	</div>

	<div class="spasi"></div>

	<div class="spasi"></div>
	<div class="spasi"></div>
	<?php
}
?>
