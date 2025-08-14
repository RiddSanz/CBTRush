<?php
include "../lib/configuration.php";
session_start();
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}

if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; }; 
$start_from = ($hal-1) * $jumlah_per_page; 

$idmapel = $_SESSION['idmapel'];
$sktest = "select id,nama_test,keterangan from t_test where idmapel='$idmapel'";
$rktest = mysqli_query($db,$sktest);
$bktest = mysqli_fetch_array($rktest,MYSQLI_ASSOC);
$wk = "";
//echo $sktest;
if((isset($_SESSION['fdata']) && $_SESSION['fdata']!='') && (isset($_SESSION['fdata2']) && $_SESSION['fdata2']!='')) {
	$crdata = $_SESSION['fdata'];
	$crdata2 = $_SESSION['fdata2'];
	/*$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_pengguna like '%$crdata%' group by a.id,pengguna 
	union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and kode_test like '%$crdata%' group by a.id,pengguna 
	union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_test like '%$crdata%' group by a.id,pengguna 
	union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and pengguna like '%$crdata%' group by a.id,pengguna 
	order by score desc LIMIT $start_from, $jumlah_per_page ";*/
	if ($crdata2=='kosong') {
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";

	}
	elseif($crdata=='kosong')
	{
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and a.id='$crdata2' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";

	}
	elseif($crdata2!='kosong' && $crdata!='kosong')
	{
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and a.id='$crdata2' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";

	}
	
}
else
{
	$crdata = '';
	$crdata2 = '';
	$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";
}
//echo $crdata;
//echo $crdata2;
//echo $sql;
$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];

$sqlKelompok = "select distinct(kelompok) as kel from hsl_score_akhir where idmapel='$idmapel' order by kel asc  
			 ";
$rmKel = mysqli_query($db,$sqlKelompok);
/* $bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC);*/
header("Content-type: application/vnd-ms-excel"); 
header("Content-Disposition: attachment; filename=Nilai-$ket_mapel-$kelas.xls");

?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	
	<link rel="stylesheet" type="text/css" href="../css/popup-window.css" />
	<div class="cpanel">
		<div class="nm-list-section">
		<br>
		
		</div>
		<div class='spasi'></div>
		<br><br>
		<table width="100%" id="t01" border='1'>
			<tr>
				<th colspan='8'>
					<center>HASIL TEST SISWA</center>
				</th>				
			</tr>
			<tr>
				<th colspan='8'>
					<center><?=strtoupper($bktest['nama_test']." ".$bktest['keterangan']);?> <?=$_SESSION['namaSEKOLAH'];?></center>
				</th>				
			</tr>			
			<tr>
				<th colspan='8'>
					<center>PELAJARAN <?=strtoupper($ket_mapel);?> TINGKAT <?=$kelas;?></center>
				</th>				
			</tr>
			<tr>
				<th colspan='8'>
					<center>&nbsp;</center>
				</th>				
			</tr>
			<tr>
				<th width="5%">
					<center>NO</center>
				</th>
				<th width="10%">
					<center>USER</center>
				</th>				
				<th>
					<center>NAMA PESERTA</center>
				</th>
				<th width="10%">
					<center>KELOMPOK</center>
				</th>				
				<th width="8%">
					<center>&Sigma;SOAL</center>
				</th>				
				<th width="3%">
					<center>B</center>
				</th>
				<th width="3%">
					<center>S</center>
				</th>
				<th width="5%">
					<center>&sum;NA
				</th>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="8">
				<center>DATA MASIH KOSONG</center>
				</td>';
			} 
			else
			{
				$x=$start_from+1;
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{
					?>
					<tr>
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?=$br['pengguna'];?>
						</td>
						<td>
							<div class='linktest'  onclick="window.location='?pg=analisaPS&idtot=<?=$br['tid'];?>:<?=$br['pid'];?>:<?=$br['jumlah_soal'];?>:<?=$br['score'];?>'">
								<?=$br['nama_pengguna'];?>
							</div>
						</td>
						<td>
							<center><?=$br['kelompok'];?></center>
						</td>						
						<td>
							<center><?=$br['jumlah_soal'];?></center>
						</td>
						<td>
							<center><?=$br['score'];?></center>
						</td>
						<td>
							<center><?=$br['jumlah_soal']-$br['score'];?></center>
						</td>
						<td>
							<center><?=number_format(($br['score']/$br['jumlah_soal'])*100,2);?></center>
						</td>
					</tr>
					<?php 
					$wk=$br['tgl_awal_test'];
					$x++;
				}
			}
			?>
		</table>
		waktu test : <?=$wk;?>
	</div>
<?php
}
mysqli_close($db);
?>

