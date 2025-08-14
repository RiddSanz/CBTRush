<?php
include "../lib/configuration.php";
// paging record
session_start();
if ((isset($_GET['fdata']) && $_GET['fdata']!='') || (isset($_GET['fdata2']) && $_GET['fdata2']!='') || (isset($_GET['fdata3']) && $_GET['fdata3']!='')) {
	//$fdata=mysqli_real_escape_string($db,$_GET['fdata']);
	//$_SESSION['fdata']=$fdata;
	if (isset($_GET['fdata3']) && $_GET['fdata3']!=''){
		$fdata3=mysqli_real_escape_string($db,$_GET['fdata3']);
		$_SESSION['fdata3']=$fdata3;
	}
	if (isset($_GET['fdata2']) && $_GET['fdata2']!=''){
		$fdata2=mysqli_real_escape_string($db,$_GET['fdata2']);
		$_SESSION['fdata2']=$fdata2;
	}
	if (isset($_GET['fdata']) && $_GET['fdata']!=''){
		$fdata=mysqli_real_escape_string($db,$_GET['fdata']);
		$_SESSION['fdata']=$fdata;
	}

	echo "1";
}
else
{
	echo "Data pencarian belum diisi!";
}
?>
