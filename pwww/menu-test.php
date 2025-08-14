<?php 
include "lib/configuration.php";

$id=mysqli_real_escape_string($db,$_GET['idtest']);
$sql = "select * from t_test where id='$id' and idmapel='".$_SESSION['idmapel']."' limit 1";
//echo $sql;
$rs = mysqli_query($db,$sql);
$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
if (!empty($br['kode_test'])) {
	$kodetest = $br['kode_test'];
	$nmtest = strtoupper($br['nama_test']." ".$br['keterangan']);
	$tsoal = $br['jumlah_soal'];
	$awt = $br['tgl_awal_test'];
	$akt = $br['tgl_akhir_test'];
	$tsoaldicek = $br['total_soal_dicek'];
	$_SESSION['idtest'] = $id;

	$idmapel = $_SESSION['idmapel'];
	$_SESSION['fdata']='';

	$sm = "select * from t_mapel where mid='$idmapel' limit 1";
	$rm = mysqli_query($db,$sm);
	$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
	$nm_mapel = $bm['nama_mapel'];
	$ket_mapel = $bm['ket_mapel'];
	$kelas = $bm['kelas'];
	?>
	<script>	
		$(document).ready(function(){
			$(".btnfinall").click(function()
			{
				var nomorid = $(this).attr('id').replace('btnSetFin-','');
				$.ajax({
					type:'GET',
					url:'pwww/p-finishmapel.php',
					data:'ajax=1&nomorid='+nomorid,
					success:function(data) {
						if(data==1){
							//location.reload();
							alert("Test diset selesai semua!");
							window.location='?pg=ltest';
						}
						else
						{
							alert(data);
						}					
					}
				});
			});
		 $(".btnUnFinish").click(function()
			{
				var nomorid = $(this).attr('id').replace('btnSetUnFin-','');
				$.ajax({
					type:'GET',
					url:'pwww/p-unfinishmapel.php',
					data:'ajax=1&nomorid='+nomorid,
					success:function(data) {
						if(data==1){
							//location.reload();
							alert("Test diset belum selesai semua!");
							window.location='?pg=ltest';
						}
						else
						{
							alert(data);
						}					
					}
				});
			});
		 $(".btnRtime").click(function()
			{
				var nomorid = $(this).attr('id').replace('btnResetTime-','');
				$.ajax({
					type:'GET',
					url:'pwww/p-reset-time-all.php',
					data:'ajax=1&nomorid='+nomorid,
					success:function(data) {
						if(data==1){
							//location.reload();
							alert("Waktu ujian telah direset semua!");
							window.location='?pg=ltest';
						}
						else
						{
							alert(data);
						}					
					}
				});
			});
		});
	</script>
	<?php
	if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
	{
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	}
	else
	{
		if((isset($_SESSION['sid_user']) && $_SESSION['sid_user']!="") || $_SESSION['tingkat_user']=='0')
		{
				$twt = strtotime($akt) - strtotime($awt);
				if ($br['jumlah_soal']<=$br['total_soal_dicek']) {
					$stTest = "success.png";
				}
				else
				{
					$stTest = "fail.png";
				}
				if ($br['jumlah_peserta']>0) {
					$stPst = "success.png";
				}
				else
				{
					$stPst = "fail.png";
				}
				if ($br['waktu_test']>0) {
					$stDur = "success.png";
				}
				else
				{
					$stDur = "fail.png";
				}
				if ($twt>=1800) {
					$okwt = "success.png";
				}
				else
				{
					$okwt = "fail.png";
				}
				?>
				<?php/*
		<div class="nm-list-section">
			<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
			<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
			<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
			<a href='#' onclick="window.location='?pg=ltest'">Test</a> |
			Atur Soal dan Peserta <?=$nmtest;?>
		</div>*/?>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li><a href='#' onclick="window.location='?pg=ltest'"><?=$site3;?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site4;?><?=strtoupper($nmtest);?></a></li>
		</ul>
		<div class='spasi'></div>	
		<div class='btnback2 letakKanan' onclick="window.location='?pg=ltest'">
			<img src="images/back.png" width="10px" align='absmiddle' class="imglink"> Kembali
		</div>
		<div class="cpanel">
			<h3>PILIH PERTANYAAN DAN PESERTA TEST</h3>		
			<div class="cpanelMenu" onclick="window.location='?pg=menutestq'">
				<img src="images/checklist.png" height="100" width="100"/> 
				<center>Pilih Pertanyaan</center>
			</div>
			<?php 
			if (($tsoaldicek<$tsoal) || ($okwt == "fail.png")) {
			?>
			<div class="cpanelMenu" style="opacity:0.5;">
				<img src="images/peserta.png" width="100"/> <center>Pilih Peserta</center>
			</div>
			<?php
			}
			else
			{
			?>
			<div class="cpanelMenu" onclick="window.location='?pg=menutestp'">
				<img src="images/peserta.png" width="100"/> <center>Pilih Peserta</center>
			</div>
			<?php }
			/*
			?>
			<div class="cpanelMenu" onclick="window.location='?pg=laporantU'">
				<img src="images/analize2.png" width="100"/> <center>Lihat Hasil</center>
			</div>

			<?php */?>
			<div class="btnfinall cpanelMenu" onclick="#'" id="btnSetFin-<?=$id;?>">
				<img src="images/tutup.png" height="100" width="100"/> 
				<center>Tutup Ujian Semua Peserta</center>
			</div>	
			<div class="btnUnFinish cpanelMenu" onclick="#'" id="btnSetUnFin-<?=$id;?>">
				<img src="images/buka.png" height="100" width="100"/> 
				<center>Buka Ujian Semua Peserta</center>
			</div>	
			<div class="btnRtime cpanelMenu" onclick="#'" id="btnResetTime-<?=$id;?>">
				<img src="images/waktu.png" height="100" width="100"/> 
				<center>Reset Waktu</center>
			</div>		
		</div>
		<div class="cpanel">
			<div class="spasi"></div>
		</div>	
		<div class="cpanel">
			<h3>STATUS TEST</h3>
			<div class='ketTest'>
				<table border='1'>
					<tr>
						<td width="300px">Pertanyaan yang diberikan ke peserta</td>
						<td>: <?=$br['jumlah_soal'];?> soal</td>
					</tr>
					<tr>
						<td>Pertanyaan yang dipilih dari bank soal</td>
						<td>: <?=$br['total_soal_dicek'];?> soal <img src="images/<?=$stTest;?>" alt="Status" width="10px"/></td>
					</tr>
					<tr>
						<td>Peserta yang ikut test</td>
						<td>: <?=$br['jumlah_peserta'];?> siswa <img src="images/<?=$stPst;?>" alt="Status" width="10px"/></td>
					</tr>
					<tr>
						<td>Durasi Test</td>
						<td>: <?=$br['waktu_test'];?> menit <img src="images/<?=$stDur;?>" alt="Status" width="10px"/></td>
					</tr>
					<tr>
						<td>Waktu Test dibuka</td>
						<td>: <?=$br['tgl_awal_test'];?></td>
					</tr>
					<tr>
						<td>Waktu Test ditutup</td>
						<td>: <?=$br['tgl_akhir_test'];?> <img src="images/<?=$okwt;?>" alt="Status" width="10px"/></td>
					</tr>
					<?php 
					$sqlSelesai = "select * from t_test_peserta where id_test='$id' and diselesaikan='1'";
					//echo $sqlSelesai;
					$rsSelesai = mysqli_query($db,$sqlSelesai);
					$jdata = mysqli_num_rows($rsSelesai);
					?>
					<tr>
						<td>Peserta yang selesai mengerjakan</td>
						<td>: <?=$jdata;?> siswa</td>
					</tr>
				</table>			
			</div>				
		</div>	
		<div class="cpanel">
			<div class="spasi"></div>
		</div>
	<?php 
		}
		else
		{
			echo "<div class='nm-list-section'>MENU TEST ".$br['nama_mapel']."</div>";
			echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR DI SALAH SATU SEKOLAH , HUBUNGI ADMIN</h3>";
		}
	}
mysqli_close($db);
}
else
{
	?>
	<h1>MOHON MAAF ANDA MENCOBA UNTUK MELAKUKAN KEGIATAN YANG BERBAHAYA!</h1>
	<?php
}

?>