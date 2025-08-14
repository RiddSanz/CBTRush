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

<style type="text/css">
/* style sheet for "A4" printing */
body {
	font-size: 1vw;
}
table {
	width: 8.3cm;
	border: 1px solid #000;
}
th {
	font-size: 10px;
}
td {
	font-size: 10px;
}
hr{
	height:1px; border:none; color:#000; background-color:#000;
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
@-moz-document url-prefix() {
    .kartu {
		float: left;
		height: 4cm;
		margin-left: 0.2cm;
		margin-right: 0.2cm;
		margin-bottom: 1.4cm;
	}
	@media print and (width: 21cm) and (height: 29.7cm) {
	    @page {
	       	margin-left: 2cm;
	       	margin-right: 2cm;
	       	margin-top: 1.35cm;
	       	margin-bottom: 1.35cm;
	    }   
	 }

	 /* style sheet for "letter" printing */
	 @media print and (width: 8.5in) and (height: 11in) {
	    @page {
	        margin: 1in;
	    }
	 }
}
.im {
	float: left;
	padding-left: 5px;
}
.penyelenggara {
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
	<?php
	$x=0;
	while ($br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) {		
	?>
	<?php 
		/*if ($x % 10 == 0 && $x!=0) {
			echo "<div class='spasip'><div>";
		}*/
	?>
	<div class="kartu">		
		<table>
			<tr>
				<th colspan='3'>
					<div class="im">
						<img src="../logo/<?=$logoF;?>" height="40" width="40px" align="absmiddle">
					</div>
					<div>					 
					KARTU PESERTA UJIAN <br> 
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
					$peng = strlen($br['pengguna']);
					if ($peng>20) {
						echo substr($br['pengguna'], 0,20 ).".";
					}
					else
					{
						echo $br['pengguna'];
					}
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
					$kun = strlen($br['kunci']);
					if ($kun>20) {
						echo substr($br['kunci'], 0,20 ).".";
					}
					else
					{
						echo $br['kunci'];
					}
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
					$tpeng = strlen($br['nama_pengguna']);
					if ($tpeng>20) {
						echo substr($br['nama_pengguna'], 0,20 ).".";
					}
					else
					{
						echo $br['nama_pengguna'];
					}
					
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
					<?=$br['kelompok'];?>
				</td>
			</tr>			
			<tr>				
				<td colspan='3'>					
					<div class="penyelenggara">
						<?=$tglval;?><br>
						Kepala Sekolah <br>
						<br>
						<?=$nmKep;?> <br>
						<?=$nipKep;?>
					</div>	
				</td>
			</tr>
		</table>
	</div>
	<?php 
	$x++;
	}
	?>
</div>
<?php
}
?>