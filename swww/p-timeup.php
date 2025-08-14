<?php 
include "../lib/configuration.php";
session_start();
$pid = $_SESSION['pid'];
$kdtest = $_SESSION['kdtest'];
if (isset($_GET['ajax']) && $_GET['ajax']!='') {
	
	$su = "update t_test_peserta set diselesaikan='1',remaining_time='0' where id_test='$kdtest' and id_peserta='$pid' limit 1";
	$ru = mysqli_query($db,$su);
	mysqli_close($db);	
	echo "1"; 
}
else
{
	mysqli_close($db);
	echo "2";
}

?>