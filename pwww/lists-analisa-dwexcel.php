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
$total_pages = 1;
$idmapel = $_SESSION['idmapel'];
$sktest = "select id,nama_test,keterangan from t_test where idmapel='$idmapel'";
$rktest = mysqli_query($db,$sktest);
$bktest = mysqli_fetch_array($rktest,MYSQLI_ASSOC);
$wk = "";
//echo $sktest;
if((isset($_SESSION['fdata2']) && $_SESSION['fdata2']!='' && $_SESSION['fdata2']!='kosong')) {
	$crdata = $_SESSION['fdata'];
	$crdata2 = $_SESSION['fdata2'];
	//echo $sql;

	$sqlKelompok = "select a.id_test,b.kelompok from t_test_peserta a, t_peserta b where a.id_peserta=b.pid and a.id_test='$crdata2 ' GROUP BY b.kelompok";
	$rmKel = mysqli_query($db,$sqlKelompok);

	$sqlT = "select id,waktu_test,jumlah_soal,soal_opsi,soal_esay,pembobotan,tgl_awal_test as tanggalnya from t_test where id='$crdata2'";
	$rmT = mysqli_query($db,$sqlT);
	//echo $sqlT;
	$dataTest = array();
	while($brT = mysqli_fetch_array($rmT,MYSQLI_ASSOC))
	{
		$idT = $brT['id'];
		$dataTest[$idT]['waktu'] = $brT['waktu_test'];
		$dataTest[$idT]['jumlah'] = $brT['jumlah_soal'];
		$dataTest[$idT]['opsi'] = $brT['soal_opsi'];
		$dataTest[$idT]['esay'] = $brT['soal_esay'];
		$dataTest[$idT]['bobot'] = $brT['pembobotan'];
		$dataTest[$idT]['tanggal'] = $brT['tanggalnya'];
	}

	//print_r($dataTest);
	if((isset($_SESSION['fdata']) && $_SESSION['fdata']!=''))
	{
		$sql = "SELECT pid,idtest,idpeserta,tnilai,benar,salah,kosong,pengguna,nama_pengguna,kelompok FROM `rekap_hasil`,t_peserta
		where idpeserta=pid and idtest='$crdata2' and kelompok='$crdata'";
	}
	else
	{
		$crdata = '';
		$crdata2 = $_SESSION['fdata2'];
	}

}
else
{
	$crdata = '';
	$crdata2 = '';
	$sql = "SELECT pid,idtest,idpeserta,tnilai,benar,salah,kosong,pengguna,nama_pengguna,kelompok FROM `rekap_hasil`,t_peserta
	where idpeserta=pid and idtest='$crdata2' and kelompok='$crdata'";

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

$warna = "#f5f5f0";
/* $bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC);*/
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$crdata-$ket_mapel-$kelas.xls");

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
		<table width="100%" border="1">
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%" rowspan="2">
					<center>NO</center>
				</th>
				<th width="10%" rowspan="2">
					<center>USER</center>
				</th>
				<th rowspan="2">
					<center>NAMA SISWA</center>
				</th>
				<th width="10%" rowspan="2">
					<center>KELOMPOK</center>
				</th>
				<th width="5%" rowspan="2">
					<center>BOBOT</center>
				</th>
				<th width="8%" colspan="2" bgcolor="#f5f5f0">
					<center>JUMLAH SOAL</center>
				</th>
				<th width="8%" colspan="2" bgcolor="#ebebe0">
					<center>PILIHAN</center>
				</th>
				<th width="8%" colspan="2" bgcolor="#d7d7c1">
					<center>POIN</center>
				</th>
				<th width="5%" rowspan="2" bgcolor='#c0c0a5'>
					<center>NA (PP+PU)</center>
				</th>
			</tr>
			<tr style='background:#ebebe0;color:#000;'>
				<th width="8%" bgcolor='#ccccb3'>
					<center>Pilihan</center>
				</th>
				<th width="8%">
					<center>Uraian</center>
				</th>
				<th width="8%" bgcolor='#ccccb3'>
					<center>Benar</center>
				</th>
				<th width="8%">
					<center>Salah</center>
				</th>
				<th width="8%" bgcolor='#ccccb3'>
					<center>Pilihan</center>
				</th>
				<th width="8%" bgcolor="#f5f5f0">
					<center>Uraian</center>
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
					$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
					?>
					<tr bgcolor="<? echo($warna);?>"  onclick="window.location='?pg=analisaPS&idtot=<?=$crdata2;?>:<?=$br['pid'];?>:<?=$dataTest[$crdata2]['jumlah'];?>:<?=$br['tnilai'];?>'">
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?=$br['pengguna'];?>
						</td>
						<td>
							<?=$br['nama_pengguna'];?>
						</td>
						<td>
							<center><?=$br['kelompok'];?></center>
						</td>
						<td>
							<?php
							if($dataTest[$crdata2]['bobot']=='1')
							{
								echo "<center>Y</center>";
							}
							else{
								echo "<center>N</center>";
							}
							?>
						</td>
						<td>
							<center><?=$dataTest[$crdata2]['opsi'];?></center>
						</td>
						<td>
							<center><?=$dataTest[$crdata2]['esay'];?></center>
						</td>
						<td>
							<center>
								<?php
								if($dataTest[$crdata2]['bobot']=='1'){
									echo $br['benar'];
								}
								else{
									echo ($dataTest[$crdata2]['opsi']-($br['kosong']-$dataTest[$crdata2]['esay']));
								}

								?>
							</center>
						</td>
						<td>
							<center>
								<?php
								if($dataTest[$crdata2]['bobot']=='1'){
									echo $br['salah'];
								}
								else{
									echo $br['kosong'] - $dataTest[$crdata2]['esay'];
								}

								?>
							</center>
						</td>
						<td>
							<center>
								<?php
									if($dataTest[$crdata2]['esay']==0)
									{
										echo number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
										$nilaiakhir = number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
									}
									else
									{
										//echo $br['tnilai'];
										//$nilaiakhir = $br['tnilai'];
										echo number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
										$nilaiakhir = number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
									}
								?>
							</center>
						</td>
						<td>
							<center>0</center>
						</td>
						<td>
							<center><?=$nilaiakhir;?></center>
						</td>
					</tr>
					<?php
					$x++;
				}
			}
			?>
		</table>
		waktu test : <?=$dataTest[$crdata2]['tanggal'];?>
	</div>
<?php
}
mysqli_close($db);
?>
