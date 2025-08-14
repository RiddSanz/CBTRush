<?php 
include "../lib/configuration.php";
session_start();
include "tgl.php";

$pid = $_SESSION['pid'];
$kdtest = $_SESSION['kdtest'];

if (isset($_GET['ajax']) && $_GET['ajax']!='') {
	$su = "update t_test_peserta set diselesaikan='1' where id_test='$kdtest' and id_peserta='$pid' limit 1";
	$ru = mysqli_query($db,$su);
	if ($ru) {
		##$_SESSION['wtfinish'] = '1';
		$_SESSION['wtfinish'] = NULL;
		$_SESSION['kdtest']=NULL;
		$_SESSION['wtfinish'] = NULL;
		$_SESSION['kdtest'] = NULL;
		$_SESSION['soals'] = NULL;
		##$_SESSION['acak_aktif'] = NULL;
		$_SESSION['acjwb'] = NULL;
		$_SESSION['nomor'] = NULL;
		$_SESSION['tminus'] = NULL;
		mysqli_close($db);
		echo "1";
	}
	else
	{
		mysqli_close($db);
		echo "2";
	}
}
else
{
	mysqli_close($db);
	echo "2";
}
?>