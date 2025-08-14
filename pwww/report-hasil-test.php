<?php
session_start();
include "../lib/configuration.php";
include "tgl.php";
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}
$idmapel = $_SESSION['idmapel'];
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
	$sql = "select * from hsl_score_akhir a where a.kelompok like '%$crdata%' and a.idmapel='$idmapel'
	union select * from hsl_score_akhir b where b.nama_pengguna like '%$crdata%' and b.idmapel='$idmapel'
	union select * from hsl_score_akhir c where c.kode_test like '%$crdata%' and c.idmapel='$idmapel'
	order by kelompok,pengguna asc LIMIT $start_from, $jumlah_per_page ";
}
else{
	$crdata = 'SEMUA';
	$sql = "select * from hsl_score_akhir where idmapel='$idmapel' order by kelompok,pengguna asc 
			LIMIT $start_from, $jumlah_per_page ";
}

$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
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
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>

<style type="text/css">
/* style sheet for "A4" printing */
body {
	font-size: 1vw;
}
table {
	width: 21cm;
}
table#t02 {
	width: 21cm;
	border: 1px solid #000;
}
th {
	font-size: 12px;
}
td {
	font-size: 12px;
}
.pinggir {
	width: 60%;
}
.kartu {
	float: left;
	height: 4cm;
	margin-left: 0.2cm;
	margin-right: 0.2cm;
	margin-bottom: 1.2cm;
}
.im {
	float: left;
	padding-left: 5px;
}
.ttd {
	float: right;
}
.spasip{
	clear: both;
	float: left;
}
 @media print and (width: 21cm) and (height: 29.7cm) {
    @page {
       margin: 3cm;
    }   
 }

 /* style sheet for "letter" printing */
 @media print and (width: 8.5in) and (height: 11in) {
    @page {
        margin: 1in;
    }
 }
</style>
<div class="cpanel">	
	<div>
		<table>
			<tr>
				<td colspan="2">
					<div style="text-align:center;">
						<h3>HASIL UJIAN SISWA <br>
						<?=$_SESSION['namaSEKOLAH'];?><br>
						TAHUN <?=$tahunmapel;?>
						</h3>
						<hr>
					</div>
				</td>
			</tr>
			<tr>
				<td width="200px">MATA PELAJARAN</td>
				<td>: <?=strtoupper($nm_mapel);?></td>
			</tr>
			<tr>
				<td>KATEGORI</td>
				<td>: <?=strtoupper($crdata);?></td>
			</tr>
		</table>		 
	</div>
	<div>&nbsp;</div>	
	<table width="100%" id="t02" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<th width="5%" style="padding:5px;">
				<center>NO</center>
			</th>
			<th width="10%">
				<center>UID</center>
			</th>
			<th width="43%">
				NAMA PENGGUNA
			</th>
			<th width="23%">
				KODE TEST
			</th>
			<th width="12%">
				KELAS
			</th>
			<th width="7%">
				NILAI
			</th>
		</tr>
		<?php 
		$x=$start_from+1;
		while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
		{
		?>
		<tr>
			<td class="isi" style="padding:2px;">
				<center><?=$x;?></center>
			</td>
			<td>
				<center><?=$br['pengguna'];?></center>
			</td>
			<td style="padding:2px;">
				<?=strtoupper($br['nama_pengguna']);?>
			</td>
			<td style="padding:2px;">
				<center><?=strtoupper($br['kode_test']);?></center>
			</td>
			<td>
				<center><?=strtoupper($br['kelompok']);?></center>
			</td>
			<td>
				<center><?=strtoupper(ceil(($br['score']/$br['jumlah_soal'])*100));?></center>
			</td>
		</tr>
		<?php 
		$x++;
		}
		?>		
	</table>
	<table>
		<tr>
			<td colspan="6">
				<div class="ttd">
					Surabaya , <?=$tanggal;?> <?=$db[$bulan];?> <?=$tahun;?> <br>
					Guru Mata pelajaran<br><br><br><br>


					---------------------
				</div>				
			</td>
		</tr>
	</table>
</div>
<?php
}
?>