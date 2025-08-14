<?php
include("../lib/configuration.php");
session_start();
$nomor = $_SESSION['nomor']+1;
if(isset($_POST['pil_id']))
{
	$idsoal=mysqli_real_escape_string($db,$_POST['pil_id']);
	$kondisi=mysqli_real_escape_string($db,$_POST['kondisi']);	
	$oleh = $_SESSION['userid'];
	$idtest = $_SESSION['idtest'];
	
	$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);
	$scek = "select * from t_test_pertanyaan where id_test='$idtest' and id_soal='$idsoal' limit 0,1";
	$rcek = mysqli_query($db,$scek);
	$tcek = mysqli_num_rows($rcek);

	if($kondisi=='cek')
	{
		if ($tcek==0) {
			$sql = "insert into t_test_pertanyaan values('$idtest','$idsoal','$tgl','$nomor')";
		}
	}else if($kondisi=='uncek'){
		if ($tcek==1) {
			$sql = "delete from t_test_pertanyaan where id_soal='$idsoal' and id_test='$idtest'";
		}
	}else
	{
		if ($tcek==0) {
			$sql = "insert into t_test_pertanyaan values('$idtest','$idsoal','$tgl','$nomor')";
		}
		else
		{
			$sql = "delete from t_test_pertanyaan where id_soal='$idsoal' and id_test='$idtest'";
		}
	}
	$result=mysqli_query($db,$sql);
	

	if($result)
	{
		$_SESSION['nomor'] = $nomor;
		echo "1";
	}
	else
	{
		echo "2";
	}
	
}

?>