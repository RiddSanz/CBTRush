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

$idtest = $_SESSION['idtest'];

if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	/*$sql = "select * from hsl_score_akhir a where a.kelompok like '%$crdata%' and a.idmapel='$idmapel' and a.idtest='$idtest'
	union select * from hsl_score_akhir b where b.nama_pengguna like '%$crdata%' and b.idmapel='$idmapel' and b.idtest='$idtest'
	union select * from hsl_score_akhir c where c.kode_test like '%$crdata%' and c.idmapel='$idmapel' and c.idtest='$idtest'
	ORDER BY score DESC LIMIT $start_from, $jumlah_per_page ";
	*/

	$sql = "select pid,pengguna,nama_pengguna,kelompok,AVG (CASE WHEN score <> 0 THEN (score*100/jumlah_soal) ELSE NULL END) as rata2,idmapel from hsl_score_akhir 
	where idmapel='$idmapel' and idtest='$idtest' and kelompok like '%$crdata%'
	group by pid,idmapel order by kelompok,pengguna asc LIMIT $start_from, $jumlah_per_page";
}
else{
	$crdata ='';
	/*$sql = "select * from hsl_score_akhir where idmapel='$idmapel' and idtest='$idtest' and kelompok='$crdata' order by score desc 
			LIMIT $start_from, $jumlah_per_page ";*/
	$sql = "select pid,pengguna,nama_pengguna,kelompok,AVG (CASE WHEN score <> 0 THEN (score*100/jumlah_soal) ELSE NULL END) as rata2,idmapel from hsl_score_akhir 
	where idmapel='$idmapel' and idtest='$idtest' and kelompok='$crdata'
	group by pid,idmapel order by kelompok,pengguna asc LIMIT $start_from, $jumlah_per_page";
}

$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$tp = date("Y",$timestamp);
$btp = date("m",$timestamp);
if ($btp <= 6 ) {
	$tahunmapel = ($tp-1)."/".$tp;
}
else
{
	$tahunmapel = $tp."/".($tp+1);
}

$id=mysqli_real_escape_string($db,$_SESSION['idtest']);
$sqltest = "select * from t_test where id='$id' limit 1";

$rstest = mysqli_query($db,$sqltest);
$brtest = mysqli_fetch_array($rstest,MYSQLI_ASSOC);
$kodetest = $brtest['kode_test'];
$unittest = $brtest['nama_test'];
//header("Content-type: application/vnd-ms-excel"); 
//header("Content-Disposition: attachment; filename=hasil-test-$nm_mapel.xls");

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
						<h3>HASIL UJIAN SISWA<br>
						<?=$_SESSION['namaSEKOLAH'];?><br>
						TAHUN <?=$tahunmapel;?>
						</h3>
						<hr>
					</div>
				</td>
			</tr>
			<tr>
				<td>MATA PELAJARAN</td>
				<td>: <?=strtoupper($nm_mapel);?></td>
			</tr>
			<tr>
				<td>UNIT TEST</td>
				<td>: <?=strtoupper($unittest);?></td>
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
			<th>
				NAMA PENGGUNA
			</th>			
			<th width="12%">
				KELAS
			</th>
			<th width="10%">
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
			<td>
				<center><?=strtoupper($br['kelompok']);?></center>
			</td>
			<td>
				<center><?=strtoupper($br['rata2']);?></center>
			</td>
		</tr>
		<?php 
		$x++;
		}
		?>
	</table>
</div>
<?php
}
?>