<?php
error_reporting(0);
include("../lib/configuration.php");
include "tgl.php";
include "akronim.php";
$tglnow = date("Y-m-d", $newTime);
$judultombol = 'Cari';

$datates = array();
$idtes_array = '';
$totalTest = 0;
$nilai = array();
if(isset($_GET['kelas']) && $_GET['kelas']!='') {
	$crdata2 = $_GET['kelas'];
	$sqlTest = "select DISTINCT(a.id_test) as idtest FROM `t_test_peserta` a,t_peserta b WHERE a.id_peserta=b.pid and b.kelompok='".$crdata2."' order by a.id_test asc";
	##echo $sqlTest;
	$rsTest = mysqli_query($db,$sqlTest);
	while($brtest = mysqli_fetch_array($rsTest,MYSQLI_ASSOC))
	{
		$datates[] = $brtest['idtest'];
	}
	$idtes_array = join("','",$datates);
	##echo $idtes_array;
	$totalTest = mysqli_num_rows($rsTest);

	## ambil kelas yang ikut ujian ###
	$sql3 = "select DISTINCT(b.kelompok) as kelas FROM `t_test_peserta` a,t_peserta b WHERE a.id_peserta=b.pid order by b.kelompok asc";
	$rs3 = mysqli_query($db,$sql3);


	## ambil nama peserta dan simpan di array ###
	$sql4 = "select pid,pengguna,nama_pengguna from t_peserta where kelompok = '".$crdata2."' order by pid asc";
	##echo $sql4;
	$rs4 = mysqli_query($db,$sql4);
	$datapes = array();
	$pid = array();
	$pid_array = '';
	$pengguna = array();
	$nmpengguna = array();
	while($br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC))
	{
		$pid[] = $br4['pid'];
		$pengguna[] = $br4['pengguna'];
		$nmpengguna[] = $br4['nama_pengguna'];
	}
	$pid_array = join("','",$pid);
	##echo $pid_array;
	$sqlHasil = "select a.*,b.soal_opsi from rekap_hasil a,t_test b where a.idtest=b.id and idpeserta IN ('$pid_array')";
	$rsHasil = mysqli_query($db,$sqlHasil);
	while($br4 = mysqli_fetch_array($rsHasil,MYSQLI_ASSOC))
	{
		$id = $br4['idpeserta'];
		$idt = $br4['idtest'];
		$nilai[$id][$idt] = number_format(($br4['tnilai']/$br4['soal_opsi'])*100,2);
	}

	$s = "select a.id,a.nama_test,a.keterangan,b.ket_mapel,b.kelas from t_test a,t_mapel b where a.idmapel=b.mid and a.id IN('$idtes_array') order by a.id";

	$rsKet = mysqli_query($db,$s);
	$idnya = array();
	$jenisnya = array();
	$ujiannya = array();
	$mapelnya = array();
	$kelasnya = array();
	$akronimnya = array();
	$nmakronimnya = array();
	while($brKet = mysqli_fetch_array($rsKet,MYSQLI_ASSOC))
	{
		$idnya[] = $brKet['id'];
		$jenisnya[] = $brKet['nama_test'];
		$ujiannya[] = $brKet['keterangan'];
		$mapelnya[] = $brKet['ket_mapel'];
		$kelasnya[] = $brKet['kelas'];
		//$akronimnya[] = preg_replace('~\b(\w)|.~', '$1', $brKet['ket_mapel'])."_".$brKet['id'];
		//$nmakronimnya[$brKet['id']] = preg_replace('~\b(\w)|.~', '$1', $brKet['ket_mapel'])."_".$brKet['id'];
		$akronimnya[] = acronym($brKet['ket_mapel'])." (".$brKet['id'].")";
		$nmakronimnya[$brKet['id']] = acronym($brKet['ket_mapel'])." (".$brKet['id'].")";
	}
}
else
{
	$crdata2 = '-' ;
}


##print_r($nilai);
?>

<style type="text/css">
.cari_select {
	font-size: 15px;
	width: auto;
}
.fullscreen{
	height: calc(100vh - 180px);
}
.btn-update{
	float: right;
}
.btn-download{
	float: right;
}
.fullauto{
	height: auto;
	overflow-x: scroll;
	zoom: 80%;
}
</style>

<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Nilai-$crdata2.xls");

if(count($pengguna)==0){
	$cl = 'fullscreen';
}
else{
	$cl = 'fullauto';
}

?>
<div class="<?=$cl;?>">
	<h1>REKAP HASIL UJIAN </h1>
	<h2>KELAS : <?=$crdata2;?></h2>
	<?php
	$xdata=1;
	$warna = "#f5f5f0";
	echo "
	<table border='1' width='100%'>
	<tr style='background:#ebebe0;color:#000;'>
    	<th rowspan='2'>NO PESERTA</th>
    	<th rowspan='2' width='25%'>NAMA PESERTA</th>
    	<th colspan='".$totalTest."' style='text-align:center'>KODE UJIAN</th>
    </tr>";
    echo "<tr style='background:#ebebe0;color:#000;'>";
    for($i=0;$i<$totalTest;$i++)
    {
    	echo "<th style='text-align:center'>".$nmakronimnya[$datates[$i]]."</th>";
    }
  	echo "</tr>";
  	for($j=0;$j<count($pengguna);$j++)
  	{
  		echo "<tr>";
  		echo "<td>".$pengguna[$j]."</td>";
  		echo "<td>".$nmpengguna[$j]."</td>";
  		for($i=0;$i<$totalTest;$i++)
	    {
	    	echo "<td style='text-align:center;'>".$nilai[$pid[$j]][$datates[$i]]."</td>";
	    }
	    echo "</tr>";
  	}
  	echo "</table>";
  	?>
	<div class="spasi"></div>
	<div class="spasi"></div>
</div>

<?php
mysqli_close($db);
?>
