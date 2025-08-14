<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['kd']))
{
	$idmapel=mysqli_real_escape_string($db,$_POST['idmapel']);
	$kd=mysqli_real_escape_string($db,$_POST['kd']);
	$sub=mysqli_real_escape_string($db,$_POST['sub']);
	$indikator=mysqli_real_escape_string($db,$_POST['indikator']);
	
	$fedit=mysqli_real_escape_string($db,$_POST['fedit']);

	$oleh = $_SESSION['userid'];
					// time server
	$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);

	if (isset($_POST['fedit']) && $_POST['fedit']!='') 
	{
		$sql = "update t_kd set nama_kd='$kd',kd_sub='$sub',kd_indikator='$indikator' where kdid='$fedit'
		";
	}
	else
	{
		$sql = "insert into t_kd values('','$kd','$sub','$indikator','$idmapel','$oleh')";
	}

	$result=mysqli_query($db,$sql);

	if($result)
	{
		echo "1";
	}
	else
	{
		echo "$sql";
	}
	// username and password sent from Form
	
}

?>