<?php
include "../lib/configuration.php";
// paging record
session_start();
if (isset($_GET['ajax']) && $_GET['ajax']!='') {
	$_SESSION['fdata']=NULL;
	$_SESSION['fdata2']=NULL;
	$_SESSION['fdata3']=NULL;
	echo "1";
}
else
{
	echo "Data pencarian belum diisi!";
}
?>
