<?php
include "../lib/configuration.php";
include "fdel-dir.php";
if(isset($_POST['ajax']) && isset($_POST['id']))
{
	$id=mysqli_real_escape_string($db,$_POST['id']);
	
	/* get name for mapel*/
	$s = "select * from t_mapel where mid=".$id." limit 1";
	$r = mysqli_query($db,$s);
	$b = mysqli_fetch_array($r,MYSQLI_ASSOC);
	$mapel = $b['nama_mapel'];

	/* processing delete for mapel*/
	$sql = "delete from t_mapel where mid=".$id." limit 1";
	/*echo $sql;*/
	$rs = mysqli_query($db,$sql);
	/*$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);*/
	if ($rs) {
		/*unlink("../mapel/$mapel");*/
		$path = "../mapel/$mapel";
		/*echo "$mapel";*/
		/* ================ delete direktory =================
		if (delete_directory($path)) {
			if(file_exists("../mapel"))
			{
				echo "1";
			}
			else{
				mkdir("../mapel");
				$tujuan = "";
				$tujuan.= "<meta http-equiv='refresh' content='0;url=../index.php'>";            
				$ourFileName = "../mapel/index.html";
	        	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
	        	$ck = fwrite($ourFileHandle, $tujuan);
	        	fclose($ourFileHandle);
	        	echo '1';
			}
		}*/
		echo "1";
	}
	else
	{
		echo "2";
	}
}
?>