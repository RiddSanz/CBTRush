<?php
include "../lib/configuration.php";
include "tgl.php";
if(isset($_POST['ajax']) && isset($_POST['idtest']))
{
	$idtest = mysqli_real_escape_string($db,$_POST['idtest']);
	$hslclone = $_POST['hslclone'];
	$idsoals = mysqli_real_escape_string($db,$_POST['idsoals']);
	$idpengguna = mysqli_real_escape_string($db,$_POST['idpengguna']);
	/*get user pid*/
	$getid = "select pid from t_peserta where pengguna='$idpengguna' limit 1";
	$rget = mysqli_query($db,$getid);
	$bget = mysqli_fetch_array($rget,MYSQLI_ASSOC);
	$pid = $bget['pid'];

	$dataclone = unserialize($hslclone);

	if (!empty($pid)) {
		$ceka = "select * from t_test_peserta where id_test='$idtest' and id_peserta='$pid' limit 1";
		$rceka = mysqli_query($db,$ceka);
		$tceka = mysqli_num_rows($rceka);
		if ($tceka>0) {
			$s = "update t_test_peserta set soal_test='$idsoals',remaining_time='0',last_login='$tgl' where id_test='$idtest' and id_peserta='$pid' limit 1";
			$r = mysqli_query($db,$s);
		}
		else {
			$s = "insert into t_test_peserta values('$idtest','$pid','$idsoals','$tgl','0','0','0','1','','','','')";
			$r = mysqli_query($db,$s);
		}
		$totaldata = count($dataclone);
		for ($i=0; $i < $totaldata; $i++) {
			list($qid,$pli,$nil) = explode("-", $dataclone[$i]);
			$s = "insert into t_hsl_test values('$idtest','$qid','$pid','$pli','$tgl','$nil')";
			mysqli_query($db,$s);
		}

		//$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
		if ($r) {
			echo "1";
		}
		else
		{
			echo "2";
		}
	}
	else{
		echo '3';

	}

}
?>
