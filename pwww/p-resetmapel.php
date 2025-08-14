<?php
include("../lib/configuration.php");
include "fdel-dir.php";
session_start();
if(isset($_POST['ajax']) && $_POST['ajax']==1)
{
	$pdel = "";
	$s = "select * from t_mapel where 1";	
	$r = mysqli_query($db,$s);
	while ( $b = mysqli_fetch_array($r,MYSQLI_ASSOC) ) {
		$mapel = $b['nama_mapel'];
		$path = "../mapel/$mapel";
		if (delete_directory($path)) {
			$pdel .= $mapel." Y; ";
		}
		else
		{
			$pdel .= $mapel." N; ";
		}
	}	

	if(file_exists("../mapel"))
	{
		echo "status OK! ";
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
	$sql = "TRUNCATE TABLE t_test";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_test_pertanyaan";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_test_peserta";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_hsl_test";	
	$result=mysqli_query($db,$sql);

	$sql = "TRUNCATE TABLE t_kd";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_image";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_soal";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_mapel";
	$result=mysqli_query($db,$sql);

	if($result)
	{
		mysqli_close($db);
		/*echo "Total data: 0 data , $utest $satuan";*/
		echo $pdel;
	}
	else
	{
		mysqli_close($db);
		echo "$sql";
	}
}
?>