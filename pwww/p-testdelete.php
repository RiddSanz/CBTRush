<?php
include "../lib/configuration.php";
if(isset($_GET['ajax']) && isset($_GET['id']))
{
	$id=mysqli_real_escape_string($db,$_GET['id']);
	$sql = "delete from t_test where id=".$id." limit 1";

	$rs = mysqli_query($db,$sql);
	
	if ($rs) {
		echo "1";
	}
	else
	{
		echo "2";
	}
}
?>