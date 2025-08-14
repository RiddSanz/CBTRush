<?php 
include "../lib/configuration.php";
session_start();
if ((isset($_GET['ajax']) && $_GET['ajax']='1')) {	
	mysqli_query($db,"TRUNCATE TABLE `rekap_hasil`");
	mysqli_query($db,"INSERT INTO rekap_hasil select * from rekap_hasil1");
	mysqli_close($db);
	echo "1";
}
else
{
	echo "0";
}
?>