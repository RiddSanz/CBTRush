<?php
session_start();
include("../lib/configuration.php");
include "tgl.php";

$bulan = array("January","Pebruary","Maret","April","Mei","Juni","Juli","Agustus","September","Okotober","Nopember","Desember");
$hari  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
if(isset($_SESSION['nomor']))
{
	$nomor=$_SESSION['nomor'];
}
else
{
	$nomor=0;
}
?>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script type="text/javascript">
function passToParent(val)
{
	var testval;
	if ( (testval = window.parent) && (testval = testval.showValue) && ('function' == typeof testval || 'object' == typeof testval) )
	{
		testval(val);
	}
}
</script>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	$siswaid = $_SESSION['pid'];
	$kdtest = $_SESSION['kdtest'];
	$totData = count($_SESSION['soals']);
	$sql = "select * from v_test_siswa where id_peserta='$siswaid' and
			id_test='$kdtest' limit 1";

	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$tgl_login = $br['last_login'];
	$rtime = $br['remaining_time'];
	if ($rtime!='') {
		$rtglw = strtotime($tgl) - strtotime($tgl_login);
		$wl = $rtime - $rtglw;
		$su = "update t_test_peserta set last_login='$tgl',remaining_time='$wl' where id_test='$kdtest' and id_peserta='$siswaid' limit 1";
		$ru = mysqli_query($db,$su);

		$sql = "select * from v_test_siswa where id_peserta='$siswaid' and
				id_test='$kdtest' limit 1";
		$rs = mysqli_query($db,$sql);
		$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	}
	$pelajaran = $br['nama_mapel'];
	$nmtest = $br['nama_test'];
	$kode = $br['kode_test'];

	$tgl1 = $br['tgl_awal_test'];
	$tgl2 = $br['tgl_akhir_test'];
	$durasi = $br['waktu_test'];
	$jmlsoal = $br['jumlah_soal'];
	$rtime = $br['remaining_time'];
	$pidlock = $br['kunci_login'];
	$rtgl = strtotime($tgl1) - strtotime($tgl);
	$rtgl2 = strtotime($tgl2) - strtotime($tgl);

	if ($rtime=='') {
		if (($durasi*60) < $rtgl2) {
			$rtime = $durasi*60;
		}
		else
		{
			if ($rtgl2<0) {
				$rtime = 0;
			}
			else
			{
				$rtime=$rtgl2;
			}

		}
	}
	else
	{
		if ($rtime>$rtgl2) {
			$rtime = $rtgl2;
		}
		else
		{
			$rtime = $rtime;
		}
	}
	if ($rtgl2<0) {
		$rtime = 0;
	}
	$rtimeM = floor($rtime / 60 );
	$rtimeS = ($rtime % 60 );
	if ($rtimeM < 0) {
		$rtimeM = 0;
		$rtimeS = 0;
	}
	if ($rtimeM <=0 ) {
		$_SESSION['wtfinish'] = '1';
	}
	if ($pidlock=='1') {
		$_SESSION['pidlock'] = '1';
	}
	?>

<div class="kotaksoal">
<?php
	for($j=0;$j<$totData;$j++)
	{
		$bg = '0';
		$csq = "select * from t_hsl_test where idsoal='".$_SESSION['soals'][$j]."' and idtest='$kdtest' and idpeserta='$siswaid' limit 1";
		$rsq = mysqli_query($db,$csq);
		$total_records = mysqli_num_rows($rsq);
		if ($j==$nomor) {
			$bg = '1';
			$warna = "bgbiru";
		}
		else{
			if($total_records>0)
			{
				$brq = mysqli_fetch_array($rsq,MYSQLI_ASSOC);
				if ($brq['pilihan']!='' && strip_tags($brq['pilihan'])!='x') {
					$bg = '1';
					$warna = "bghijau";
				}
				else
				{
					$bg = '1';
					$warna = "bgputih";
				}
			}
			else
			{
				$bg = '0';
			}
		}
	?>
	<div class="nomorsoal <?php if($bg=='1'){ echo $warna;}?>" id="nmsoal<?=$j;?>" onclick="passToParent(<?=$j;?>)">
		<span><?=($j+1);?></span>
	</div>
	<?php
	}
	?>
</div>
<?php
}
mysqli_close($db);
?>
