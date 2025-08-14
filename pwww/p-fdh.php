<?php 
include "../lib/configuration.php";
// paging record
session_start();
if ((isset($_GET['ftest']) && $_GET['ftest']!='') || (isset($_GET['fruang']) && $_GET['fruang']!='') || (isset($_GET['fkelas']) && $_GET['fkelas']!='')) {
	
	if (isset($_GET['ftest']) && $_GET['ftest']!=''){
		$ftest=mysqli_real_escape_string($db,$_GET['ftest']);
		$_SESSION['ftest']=$ftest;
	}
	if (isset($_GET['fruang']) && $_GET['fruang']!=''){
		$fruang=mysqli_real_escape_string($db,$_GET['fruang']);
		$_SESSION['fruang']=$fruang;
	}
	else
	{
		$_SESSION['fruang']=NULL;
	}
	if (isset($_GET['fkelas']) && $_GET['fkelas']!=''){
		$fkelas=mysqli_real_escape_string($db,$_GET['fkelas']);
		$_SESSION['fkelas']=$fkelas;
	}
	else
	{
		$_SESSION['fkelas']=NULL;
	}
	echo "1";
}
else
{
	echo "Data pencarian belum diisi!";
}
?>