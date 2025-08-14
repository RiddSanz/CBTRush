<?php
include "../lib/configuration.php";
session_start();
include "tgl.php";
if(isset($_SESSION['nomor']))
{
	$nomor=$_SESSION['nomor'];
}
else
{
	$nomor=0;
}
if (isset($_GET['ajax']) && $_GET['ajax']!='' && $_GET['ajax']=='10') {
	$pid = $_SESSION['pid'];
	$kdtest = $_SESSION['kdtest'];

	$sql = "select * from v_test_siswa where id_peserta='$pid' and id_test='$kdtest' limit 1";
	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$rtime= $br['remaining_time'];
	$kuncisiswa = $br['kunci_login'];
	$ts = $br['tingkat_test'];

	$tgl_login = $br['last_login'];
	$totsoal = $br['jumlah_soal'];

	$rtgl2 = strtotime($tgl) - strtotime($tgl_login);
	$wl = $rtime - $rtgl2;

	if(($wl/60) < $ts)
	{
		$_SESSION['tminus'] = true;
	}
	else{
		$_SESSION['tminus'] = false;
	}

	$su = "update t_test_peserta set last_login='$tgl',remaining_time='$wl' where id_test='$kdtest' and id_peserta='$pid' limit 1";
	$ru = mysqli_query($db,$su);
	mysqli_close($db);
	echo "1";
}
else
{
	mysqli_close($db);
	echo "2";
}
?>
