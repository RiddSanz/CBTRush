<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['qid'])) {
	$id=mysqli_real_escape_string($db,$_GET['qid']);
	$hal=mysqli_real_escape_string($db,$_GET['hal']);

	$data = explode(",", $id);
	for ($i=0; $i < count($data); $i++) { 
		if ($data[$i]!='0' || $data[$i]!=0) {
			list($iduser,$idtest) = explode(":", $data[$i]);
			$sql = "update t_test_peserta set diselesaikan='0' where id_peserta='$iduser' and id_test='$idtest' LIMIT 1";
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