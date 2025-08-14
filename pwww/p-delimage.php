<?php
/*
include "../lib/configuration.php";
session_start();
$idmaple = $_SESSION['idmapel'];
$nmmaple = $_SESSION['nama_mapel'];
if(isset($_GET['ajax']) && isset($_GET['id']))
{
	$id=mysqli_real_escape_string($db,$_GET['id']);
	
	if ($id) {
		$s = "select * from t_image where id='$id' limit 1";
		$rs = mysqli_query($db,$s);
		$b = mysqli_fetch_array($rs,MYSQLI_ASSOC);
		unlink("../mapel/".$nmmaple."/".$b['nama_image']);
		$sql = "delete from t_image where id=".$id." limit 1";
		//echo $sql;
		$rs = mysqli_query($db,$sql);
		//$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
		echo "1";
	}
	else
	{
		echo "$sql";
	}
}*/

session_start();
$idmaple = $_SESSION['idmapel'];
$nmmaple = $_SESSION['nama_mapel'];
if(isset($_GET['ajax']) && isset($_GET['id']))
{
	$id=$_GET['id'];
	
	if ($id) {
		unlink("../mapel/".$nmmaple."/".$id);
		echo "1";
	}
	else
	{
		echo "Delete file $id , gagal!";
	}
}
?>