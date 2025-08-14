<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['nomorid'])) {
	$id=mysqli_real_escape_string($db,$_GET['nomorid']);
	//list($iduser,$idtest) = explode(":", $id);
	
	$sql = "update t_test_peserta set remaining_time='' where id_test='$id'";	
	$rs = mysqli_query($db,$sql);
	if ($rs) {
		echo "1";
	}
	else{
		echo "2";
	}
	
}
else
{
	echo "3";
}
?>