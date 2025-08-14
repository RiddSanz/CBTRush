<?php
include "pwww/date-expired.php";
if($date1 >= $date2)
{
	$valid = true;
}
else
{
	$valid = false;
}
$_SESSION['fdata']='';
$_SESSION['fdata2']='';
//echo "testing user ".$_SESSION['tingkat_user'];
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if((isset($_SESSION['sid_user']) && $_SESSION['sid_user']!="") || $_SESSION['tingkat_user']!='2')
	{
?>
	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
	<?php
	if ($valid==true) {
	?>
	<div class="cpanel">
		<h3>LAYANAN KHUSUS</h3>
		<?php
		if ($_SESSION['tingkat_user']=='0') {
		?>
		<div class="cpanelMenu" onclick="window.location='?pg=lsekolah'">
			<img src="<?=$menuhome;?>" height="100" width="100" class="imglink"/> <center>Sekolah</center>
		</div>
		<?php
		}
		?>
		<?php
		if (isset($_SESSION['trueValKey'])) {
		?>
		<div class="cpanelMenu" onclick="window.location='?pg=users'">
			<img src="<?=$menupengguna;?>" height="100" width="100" class="imglink"/> <center>Pengguna</center>
		</div>
		<div class="cpanelMenu" onclick="window.location='?pg=lmapel'">
			<img src="<?=$menumapel;?>" height="100" width="100" class="imglink"/> <center>Master Pelajaran</center>
		</div>
		<?php
		if ($_SESSION['tingkat_user']=='0') {
		?>
		<div class="cpanelMenu" onclick="window.location='?pg=infot'">
			<img src="<?=$menuinfo;?>" height="100" width="100" class="imglink"/> <center>Informasi Tambahan</center>
		</div>
		<?php
		}
		?>
		<?php /*?>
		<div class="cpanelMenu">
			<img src="images/report.png" height="100" width="100" class="imglink"/> <center>LAPORAN</center>
		</div>
		<?php */?>
	</div>
	<div class="cpanel">
		<div class="spasi"></div>
	</div>
	<div class="cpanel">
		<h3>LAYANAN UMUM</h3>
		<div class="cpanelMenu" onclick="window.location='?pg=lsubmapel'">
			<img src="<?=$menusetujian;?>" height="100" width="100" class="imglink"/>
			<center>Seting Ujian</center>
		</div>
		<div class="cpanelMenu" onclick="window.location='?pg=jadwalu'">
			<img src="<?=$menujadwal;?>" height="100" width="100" class="imglink"/>
			<center>Jadwal Ujian</center>
		</div>
		<div class="cpanelMenu" onclick="window.location='?pg=kumpulanNilai'">
			<img src="<?=$menukumpulannilai;?>" height="100" width="100" class="imglink"/>
			<center>Kumpulan Nilai</center>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	}
	else {
		?>
	<div class="cpanel">
		<h3>LAYANAN KHUSUS</h3>
		<?php
		if ($_SESSION['tingkat_user']=='0') {
		?>
		<div class="cpanelMenu">
			<img src="images/home2.png" height="100" width="100" class="imglink"/> <center>Sekolah</center>
		</div>
		<?php
		}
		?>
		<?php
		if (isset($_SESSION['trueValKey'])) {
		?>
		<div class="cpanelMenu" >
			<img src="images/users.png" height="100" width="100" class="imglink"/> <center>Pengguna</center>
		</div>
		<div class="cpanelMenu">
			<img src="images/stickies2.png" height="100" width="100" class="imglink"/> <center>Master Pelajaran</center>
		</div>
		<?php
		if ($_SESSION['tingkat_user']=='0') {
		?>
		<div class="cpanelMenu">
			<img src="images/get_info.png" height="100" width="100" class="imglink"/> <center>Info tambahan</center>
		</div>
		<?php
		}
		?>
		<?php /*?>
		<div class="cpanelMenu">
			<img src="images/report.png" height="100" width="100" class="imglink"/> <center>LAPORAN</center>
		</div>
		<?php */?>
	</div>
	<div class="cpanel">
		<div class="spasi"></div>
	</div>
	<div class="cpanel">
		<h3>LAYANAN UMUM</h3>
		<div class="cpanelMenu">
			<img src="images/textedit.png" height="100" width="100" class="imglink"/>
			<center>Seting Ujian</center>
		</div>
		<div class="cpanelMenu">
			<img src="images/schedule_icon.png" height="100" width="100" class="imglink"/>
			<center>Jadwal Ujian</center>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	}
	?>
	<div class="cpanel">
		<div class="spasi"></div>
	</div>
<?php
	}
	else
	{
		echo "<div class='nm-list-section'>CONTROL PANEL CBT 2015</div>";
		echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR DI SALAH SATU SEKOLAH , HUBUNGI ADMIN</h3>";
	}
}
?>
