<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET["ajax"]) && $_GET["ajax"]=="1" && isset($_GET['nomorid'])) {
	$nomor=mysqli_real_escape_string($db,$_GET['nomorid']);
	$sql = "update t_test_peserta set diselesaikan='0' where id_test='$nomor'";
	$rs = mysqli_query($db,$sql);
	mysqli_close($db);
	echo "1";
}

?>