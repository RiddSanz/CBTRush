<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['id'])) {
	$id=mysqli_real_escape_string($db,$_GET['id']);
	
	$sc = "select * from t_mapel where mid='$id' LIMIT 1";
	$rc = mysqli_query($db,$sc);
	$bc = mysqli_fetch_array($rc,MYSQLI_ASSOC);

	if ($bc['jid']=='0') {
		$sql = "update t_mapel set jid='1' where mid='$id' LIMIT 1";
	}
	else
	{
		$sql = "update t_mapel set jid='0' where mid='$id' LIMIT 1";
	}	
	$rs = mysqli_query($db,$sql);
	if ($rs) {
		mysqli_close($db);
		echo "1";
	}
	else{
		mysqli_close($db);
		echo "2";
	}
	
}
else
{
	mysqli_close($db);
	echo "3";
}
?>