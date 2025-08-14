<?php 
include "../lib/configuration.php";
// paging record
session_start();
if (isset($_GET['ajax']) && isset($_GET['id'])) {
	$id=mysqli_real_escape_string($db,$_GET['id']);
	list($iduser,$idtest) = explode(":", $id);
	$sc = "select * from t_test_peserta where id_peserta='$iduser' 
		and id_test='$idtest' LIMIT 1";
	$rc = mysqli_query($db,$sc);
	$bc = mysqli_fetch_array($rc,MYSQLI_ASSOC);

	if ($bc['kunci_login']=='0') {
		$sql = "update t_test_peserta set kunci_login='1' where id_peserta='$iduser' 
		and id_test='$idtest' LIMIT 1";
	}
	else
	{
		$sql = "update t_test_peserta set kunci_login='0' where id_peserta='$iduser' 
		and id_test='$idtest' LIMIT 1";
	}	
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