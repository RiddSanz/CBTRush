<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['id'])) {
	$id=mysqli_real_escape_string($db,$_GET['id']);
	list($iduser,$idtest) = explode(":", $id);
	$timestamp = time();
	$tgl = date("Y-m-d",$timestamp);

	//$sql = "update t_test_peserta set browser_type='',os_type='',system_type='' where id_peserta='$iduser' and id_test='$idtest' LIMIT 1";
	$sql = "delete from t_activity where t_who=".$iduser." and t_jam_log like '$tgl%' limit 1";
	//echo $sql;
	$rs = mysqli_query($db,$sql);
	if ($rs) {
		$sql = "update t_test_peserta set system_type='' where id_test='$idtest' and id_peserta='$iduser' limit 1";
		$rs = mysqli_query($db,$sql);
		if ($rs) {
			//echo $sql;
			echo "1";
		}
		else
		{
			echo "3";
		}
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