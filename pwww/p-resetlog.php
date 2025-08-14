<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['ajax']) && $_POST['ajax']==1)
{
	$sql = "TRUNCATE TABLE t_activity";
	
	$result=mysqli_query($db,$sql);

	$DB_NAME = "tryout";
	$TABLE_NAME = "t_activity";
	$satuan = "KB";
	$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
	$rs4 = mysqli_query($db,$sql4);
	$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
	$ulog= $br4['ukuran_kb'];
	if ($ulog>1024) {
			$ulog = $ulog / 1024;
			$satuan = "MB";
	}
	else if($ulog>(1024*1024)){
			$ulog = $ulog / (1024*1024);
			$satuan = "GB";
	}

	if($result)
	{
		mysqli_close($db);
		echo "Total data: 0 data , $ulog $satuan";
	}
	else
	{
		mysqli_close($db);
		echo "$sql";
	}
}
?>