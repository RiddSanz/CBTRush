<?php 
include "../lib/configuration.php";
session_start();
include "tgl.php";

$pid = $_SESSION['pid'];
$kdtest = $_SESSION['kdtest'];

if (isset($_GET['ajax']) && $_GET['ajax']!='') {
	$_SESSION['kdtest']=NULL;
	echo '1';
}
else
{
	mysqli_close($db);
	echo "2";
}
?>