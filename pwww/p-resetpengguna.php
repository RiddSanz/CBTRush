<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['ajax']) && $_POST['ajax']==1)
{
	//$sql = "TRUNCATE TABLE t_peserta";
	$sql = "delete from t_peserta where tingkat not in('0','1')";
	mysqli_query($db,$sql);

	//$sql = "insert into t_peserta values('','admin','admin','Administrator','admin','0','','admin','')";
	//$result=mysqli_query($db,$sql);

	$DB_NAME = "tryout";
	$TABLE_NAME = "t_peserta";
	$satuan = "KB";
	$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
	$rs4 = mysqli_query($db,$sql4);
	$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
	$upengguna= $br4['ukuran_kb'];

	if ($upengguna>1024) {
			$upengguna = $upengguna / 1024;
			$satuan = "MB";
	}
	else if($upengguna>(1024*1024)){
			$upengguna = $upengguna / (1024*1024);
			$satuan = "GB";
	}
	echo "Total data: 1 data , $upengguna $satuan";
	/*
	if($result)
	{
		mysqli_close($db);
		echo "Total data: 1 data , $upengguna $satuan";
	}
	else
	{
		mysqli_close($db);
		echo "$sql";
	}*/
}
?>