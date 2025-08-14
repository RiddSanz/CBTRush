<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['sid']) && isset($_POST['sekolah']))
{
	// username and password sent from Form
	$sid=mysqli_real_escape_string($db,$_POST['sid']);
	$sekolah=mysqli_real_escape_string($db,$_POST['sekolah']);
	$fedit=mysqli_real_escape_string($db,$_POST['fedit']);
	
	$oleh = $_SESSION['userid'];
	// time server
	$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);

	if (isset($_POST['fedit']) && $_POST['fedit']!='') 
	{
		$sql = "update t_sekolah set nama_sekolah='$sekolah' where sid='$sid'
		";
	}
	else
	{
		$sql = "insert into t_sekolah values('$sid','$sekolah','$oleh','$tgl','0000-00-00 00:00:00','')";
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
}

?>