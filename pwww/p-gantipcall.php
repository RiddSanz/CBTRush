<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['qid'])) {

	$timestamp = time();
	$tgl = date("Y-m-d",$timestamp);

	$id=mysqli_real_escape_string($db,$_GET['qid']);
	$hal=mysqli_real_escape_string($db,$_GET['hal']);

	$data = explode(",", $id);
	for ($i=0; $i < count($data); $i++) { 
		if ($data[$i]!='0' || $data[$i]!=0) {
			list($iduser,$idtest) = explode(":", $data[$i]);
			$sql = "delete from t_activity where t_who=".$iduser." and t_jam_log like '$tgl%' limit 1";
			$rs = mysqli_query($db,$sql);
			
			$sql = "update t_test_peserta set system_type='' where id_test='$idtest' and id_peserta='$iduser' limit 1";
			$rs = mysqli_query($db,$sql);
		}		
	}
	//print_r(count($data));
	echo "$hal";	
}
else
{
	echo "3";
}
?>