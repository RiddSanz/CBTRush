<?php
session_start();
include "../lib/configuration.php";
include "tgl.php";
$sv = "select * from t_ujian limit 1";
$rv = mysqli_query($db,$sv);
$bv = mysqli_fetch_array($rv,MYSQLI_ASSOC);
$nmKep = $bv['kepsek'];
$nipKep = $bv['nip_kepsek'];
$tglval = $bv['tgl_ujian'];
$ketF = $bv['keterangan'];
$logoF = $bv['logo_sekolah'];
$jk = $bv['judul_kartu'];

if ($logoF=='') {
	$logoF = "tutuwuri.jpg";
}
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}

if (isset($_GET["mulai"]))
{
	$hal  = $_GET["mulai"];

}
else
{
	$hal=1;
}

$start_from = $hal;

if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from t_peserta a where a.tingkat='2' and a.pengguna like '%$crdata%' union
	select * from t_peserta b where b.tingkat='2' and b.nama_pengguna like '%$crdata%' union
	select * from t_peserta c where c.tingkat='2' and c.kelompok like '%$crdata%' order by pengguna ASC
	LIMIT $start_from, $jumlah_per_page ";
}
else{
	$crdata = 'SEMUA';
	$sql = "select * from t_peserta where tingkat='2' order by pengguna ASC LIMIT $start_from, $jumlah_per_page ";
}

$rs = mysqli_query($db,$sql);

$tp = date("Y",$timestamp);
$btp = date("m",$timestamp);
list($tt,$tj) = explode(" ", $tgl);
list($tahun,$bulan,$tanggal)= explode("-", $tt);
$db = array('01' => "Januari",'02' => "Februari",'03' => "Maret",'04' => "April",'05' => "Mei",
	'06' => "Juni",'07' => "Juli",'08' => "Agustus",'09' => "September",'10' => "Oktober",'11' => "November",'12' => "Desember" );
if ($btp <= 6 ) {
	$tahunmapel = ($tp-1)."/".$tp;
}
else
{
	$tahunmapel = $tp."/".($tp+1);
}
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']) && $_SESSION['tingkat']!='0')
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	<link rel="stylesheet" type="text/css" href="../css/printerset.css">
	<style type="text/css">
	@page {
	  margin-top: 1cm;
	  margin-left: 1cm;
	  margin-bottom: 1cm;
	  margin-right: 1cm;
	  height: 297mm;
	}
	table {
		width: 100%;
		border: 1px solid #000;
	}
	th {
		font-size: 10px;
	}
	td {
		font-size: 10px;
	}
	.kartu {
		float: left;
		height: 4cm;
		width: 47%;
		margin-left: 0.25cm;
		margin-right: 0.25cm;
		margin-bottom: 1.5cm;
	}
	.pinggir {
		width: 60%;
	}
	.im {
		float: left;
		padding-left: 5px;
	}
	.penyelenggara {
		float: right;
	}
	.ruangsesi {
		float: left;
		margin-left: 10px;
		margin-top: 10px;
		padding: 5px;
		border-radius: 0px;
		border: 1px solid lightgrey;
	}
	.rsatas{
		font-size: 10px;
		text-decoration: underline;
	}
	.rsbawah{
		font-size: 14px;
	}
	.spasip{
		clear: both;
		float: left;
	}
	</style>
	<div>
		<?php
		$x=0;
		$username = array();
		$password = array();
		$nama = array();
		$kelas = array();

		while ($br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) {
			?>
			<?php
			/*if ($x % 10 == 0 && $x!=0) {
				echo "<div class='spasip'><div>";
			}*/
		$peng = strlen($br['pengguna']);
		if ($peng>20) {
			$username[$x] = substr($br['pengguna'], 0,20 ).".";
		}
		else
		{
			$username[$x] = $br['pengguna'];
		}

		$kun = strlen($br['kunci']);
		if ($kun>20) {
			$password[$x] = substr($br['kunci'], 0,20 ).".";
		}
		else
		{
			$password[$x] = $br['kunci'];
		}

		$tpeng = strlen($br['nama_pengguna']);
		if ($tpeng>20) {
			$nama[$x] = substr($br['nama_pengguna'], 0,32 ).".";
			//echo $br['nama_pengguna'];
		}
		else
		{
			$nama[$x] = $br['nama_pengguna'];
		}

		$kel[$x] = $br['kelompok'];
		$ruang[$x] = $br['ruang'];
		$sesi[$x] = $br['sesi'];

		$x++;
	}
	//$totalhalaman = $jumlah_per_page / 10;
	$totalhalaman = $x / 10;
	$totalhalaman = $totalhalaman+1;
	?>
	<?
	$ab =0;
	for ($i=0; $i < $totalhalaman; $i++) {
		echo "<div class='cpanel'>";
		for ($j=0; $j < 10 ; $j++)
		{
			if ($ab<$x) {
				?>
				<div class='kartu'>
					<table>
						<tr>
							<th colspan='3'>
								<div class="im">
									<img src="../logo/<?=$logoF;?>" height="40" width="40px" align="absmiddle">
								</div>
								<div>
									<?=$jk;?> <br>
									<?=$_SESSION['namaSEKOLAH'];?> <br>
									TAHUN PELAJARAN <?=$tahunmapel;?>
								</div>
							</th>
						</tr>
						<tr>
							<td colspan='3' style="border-top:1px solid #000;">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td width="20%" style="padding-left:5px;">
								No. Peserta
							</td>
							<td>
								:
							</td>
							<td>
								<?php
								echo $username[$ab];
								?>
							</td>
						</tr>
						<tr>
							<td style="padding-left:5px;">
								Password
							</td>
							<td>
								:
							</td>
							<td>
								<?php
								echo $password[$ab];
								?>

							</td>
						</tr>
						<tr>
							<td style="padding-left:5px;">
								Nama
							</td>
							<td>
								:
							</td>
							<td>
								<?php
								echo $nama[$ab];
								?>
							</td>
						</tr>
						<tr>
							<td style="padding-left:5px;">
								Kelas
							</td>
							<td>
								:
							</td>
							<td>
								<?=$kel[$ab];?>
							</td>
						</tr>
						<tr>
							<td colspan='3'>

								<div class='ruangsesi'>
									<span class='rsatas'>Ruang dan Sesi</span><br>
									<span class='rsbawah'><?=$ruang[$ab];?>-<?=$sesi[$ab];?></span>
								</div>

								<div class="penyelenggara">
									<?php
									$filettd = "../logo/ttd.jpg";
									if(file_exists($filettd))
									{
										echo "<img src='".$filettd."' height='50px;'>";
									}
									else
									{
									?>
										<?=$tglval;?><br>
										Kepala Sekolah <br>
										<br>
										<?=$nmKep;?> <br>
										<?=$nipKep;?>
									<?php
									}
									?>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<?php
			}
			else
			{
				continue;
			}
			$ab++;
		}
		echo "</div>";
	}
	?>
</div>
<?php
}
?>
