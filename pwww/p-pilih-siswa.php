<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['pil_id']))
{
	$pid=mysqli_real_escape_string($db,$_POST['pil_id']);
	$kondisi=mysqli_real_escape_string($db,$_POST['kondisi']);
	$oleh = $_SESSION['userid'];
	$idtest = $_SESSION['idtest'];

	$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);
	$scek = "select * from t_test_peserta where id_test='$idtest' and id_peserta='$pid' limit 0,1";
	$rcek = mysqli_query($db,$scek);
	$tcek = mysqli_num_rows($rcek);

	if($kondisi=='cek')
	{
		if ($tcek==0) {
			$sql = "insert into t_test_peserta values('$idtest','$pid','','','','0','0','0','','','','','')";
		}
	}else if($kondisi=='uncek'){
		if ($tcek==1) {
			$sql = "delete from t_test_peserta where id_peserta='$pid' and id_test='$idtest'";
			$st = "delete from t_hsl_test where idpeserta='$pid' and idtest='$idtest'";
			mysqli_query($db,$st);
		}
	}else
	{
		if ($tcek==0) {
			$sql = "insert into t_test_peserta values('$idtest','$pid','','','','0','0','0','','','','','')";
		}
		else
		{
			$sql = "delete from t_test_peserta where id_peserta='$pid' and id_test='$idtest'";
			$st = "delete from t_hsl_test where idpeserta='$pid' and idtest='$idtest'";
			mysqli_query($db,$st);
		}
	}
	$result=mysqli_query($db,$sql);

	if($result)
	{
		echo "1";
	}
	else
	{
		echo "2";
	}
}

?>
