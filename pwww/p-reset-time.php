<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['id'])) {
	$id=mysqli_real_escape_string($db,$_GET['id']);
	list($iduser,$idtest) = explode(":", $id);
	
	$sql = "update t_test_peserta set remaining_time='' where id_peserta='$iduser' and id_test='$idtest' LIMIT 1";
	
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