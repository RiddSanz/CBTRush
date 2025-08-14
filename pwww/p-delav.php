<?php
//include "../lib/configuration.php";
session_start();
$idmaple = $_SESSION['idmapel'];
//$nmmaple = $_SESSION['nama_mapel'];
if(isset($_GET['ajax']) && isset($_GET['id']) && isset($_GET['folder']))
{
	$id=$_GET['id'];
	$folder=$_GET['folder'];
	if ($id) {
		unlink("../mapel/".$folder."/".$id);
		echo "1";
	}
	else
	{
		echo "$id";
	}
}
?>