<?php 
include "../lib/configuration.php";
session_start();
if(isset($_SESSION['nomor']))
{
	$nomor=$_SESSION['nomor'];
}
else
{
	$nomor=0;
}
if (isset($_GET['ajax']) && $_GET['ajax']!='')
{
	$tombol=mysqli_real_escape_string($db,$_GET['ajax']);
	if ($tombol=='1') {
		$_SESSION['nomor']=$nomor+1;
	}
	else
	{
		$_SESSION['nomor']=$nomor-1;
	}
	
	echo "1";
}

?>