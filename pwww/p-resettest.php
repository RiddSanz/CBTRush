<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['ajax']) && $_POST['ajax']==1)
{
	$sql = "TRUNCATE TABLE t_test";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_test_pertanyaan";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_test_peserta";
	$result=mysqli_query($db,$sql);
	$sql = "TRUNCATE TABLE t_hsl_test";	
	$result=mysqli_query($db,$sql);

	$DB_NAME = "tryout";
	$TABLE_NAME = "t_test";
	$satuan = "KB";
	$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
	$rs4 = mysqli_query($db,$sql4);
	$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
	$utest= $br4['ukuran_kb'];

	$TABLE_NAME = "t_test_pertanyaan";
	$satuan = "KB";
	$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
	$rs4 = mysqli_query($db,$sql4);
	$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
	$utest = $utest + $br4['ukuran_kb'];

	$TABLE_NAME = "t_test_peserta";
	$satuan = "KB";
	$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
	$rs4 = mysqli_query($db,$sql4);
	$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
	$utest = $utest + $br4['ukuran_kb'];

	$TABLE_NAME = "t_test_peserta";
	$satuan = "KB";
	$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
	$rs4 = mysqli_query($db,$sql4);
	$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
	$utest = $utest + $br4['ukuran_kb'];

	if ($utest>1024) {
			$utest = $utest / 1024;
			$satuan = "MB";
	}
	else if($utest>(1024*1024)){
			$utest = $utest / (1024*1024);
			$satuan = "GB";
	}

	if($result)
	{
		mysqli_close($db);
		echo "Total data: 0 data , $utest $satuan";

	}
	else
	{
		mysqli_close($db);
		echo "$sql";
	}
}
?>