<?php 
include "../lib/configuration.php";
session_start();
$pid = $_SESSION['pid'];
if (isset($_GET['oldp']) && $_GET['oldp']!='') {
	$newp=mysqli_real_escape_string($db,$_GET['newp']);
	$oldp=mysqli_real_escape_string($db,$_GET['oldp']);
	$s = "select * from t_peserta where pid='$pid' limit 0,1";
	$r = mysqli_query($db,$s);
	$b = mysqli_fetch_array($r,MYSQLI_ASSOC);

	if(trim($b['kunci'])==trim($oldp)) {
		$su = "update t_peserta set kunci='$newp' where pid='$pid'";
		$ru = mysqli_query($db,$su);
		if ($ru) {
			echo "1";
		}
		else
		{
			echo "2";
		}
	}
	else{
		echo '3';
	}
	
}
else
{
	echo "4";
}
?>