<?php
include "../lib/configuration.php";
//time server
include "tgl.php";

if(isset($_GET['ajax']) && $_GET['ajax']!='')
{
	
	$sval = "select * from t_sekolah Limit 1";
	$rsval = mysqli_query($db,$sval);
	$brval = mysqli_fetch_array($rsval,MYSQLI_ASSOC);
	
	
	$sekNm = $brval['nama_sekolah'];
	$sekId = $brval['sid'];
	$valKey = md5($sekId."M4541NUN".$sekNm);
	echo $valKey;
}
?>