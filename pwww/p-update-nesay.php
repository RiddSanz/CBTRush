<?php 
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && isset($_GET['tid']) ) {
	
	$kirim=mysqli_real_escape_string($db,$_GET['tid']);
	list($tid,$pid,$qid,$nilai) = explode(":", $kirim);

	$sql = "update t_hsl_test set nilai='$nilai' where idtest='$tid' and idsoal='$qid' and idpeserta='$pid'";
	
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