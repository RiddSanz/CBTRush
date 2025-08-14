<?php
include "../lib/configuration.php";
if(isset($_GET['ajax']) && isset($_GET['id']))
{
	$id=mysqli_real_escape_string($db,$_GET['id']);
	$sql = "delete from t_peserta where pid=".$id." limit 1";
	//echo $sql;
	$rs = mysqli_query($db,$sql);
	//$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	if ($rs) {
		echo "1";
	}
	else
	{
		echo "2";
	}
}
?>