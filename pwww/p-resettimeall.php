<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['qid'])) {
	$id=mysqli_real_escape_string($db,$_GET['qid']);
	$hal=mysqli_real_escape_string($db,$_GET['hal']);
	$wtime=mysqli_real_escape_string($db,$_GET['wtime']);

	$timestamp = time();
	$tgl = date("Y-m-d",$timestamp);

	if ($wtime=='') {
		$wtime = '';
	}
	else
	{
		$wtime = (int)$wtime*60;
	}

	$data = explode(",", $id);
	for ($i=0; $i < count($data); $i++) { 
		if ($data[$i]!='0' || $data[$i]!=0) {

			list($iduser,$idtest) = explode(":", $data[$i]);
			
			$sql = "update t_test_peserta set diselesaikan='0',remaining_time='$wtime',system_type='' where id_peserta='$iduser' and id_test='$idtest' LIMIT 1";
			$rs = mysqli_query($db,$sql);

			$sql = "delete from t_activity where t_who=".$iduser." and t_jam_log like '$tgl%' limit 1";
			$rs = mysqli_query($db,$sql);
		}		
	}
	echo "$hal";	
	//echo $data;
}
else
{
	echo "3";
}
?>