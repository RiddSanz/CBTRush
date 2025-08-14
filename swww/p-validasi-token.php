<?php 
include "../lib/configuration.php";
session_start();
include "tgl.php";

$pid = $_SESSION['pid'];
if (isset($_GET['itoken']) && $_GET['itoken']!='') {
	$itoken=mysqli_real_escape_string($db,$_GET['itoken']);
	
	$s = "select * from t_token order by id asc limit 0,1";
	$r = mysqli_query($db,$s);
	$b = mysqli_fetch_array($r,MYSQLI_ASSOC);

	$tgl1 = $b['tgl_exp'];
	$rtgl = strtotime($tgl1) - strtotime($tgl);
	if ($rtgl<0) {
		mysqli_close($db);
		echo '2';
		/*token expired*/
	}
	else{
		if(trim($b['token'])==trim($itoken)) {
			$_SESSION['token'] = $tgl;
			$siswaid = $_SESSION['pid'];
			$kdtest = $_SESSION['kdtest'];
			$sql = "select * from v_test_siswa where id_peserta='$siswaid' and 
					id_test='$kdtest' limit 1";
			$rs = mysqli_query($db,$sql);
			$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
			$rtime = $br['remaining_time'];
			$durasi = $br['waktu_test'];
			if ($rtime=='') {
				$rtime = $durasi*60;
				$su = "update t_test_peserta set remaining_time='$rtime' where id_test='$kdtest' and id_peserta='$siswaid' limit 1";
				$ru = mysqli_query($db,$su);
			}
			mysqli_close($db);
			echo "1";
		}
		else{
			mysqli_close($db);
			echo '3';
		}
	}	
}
else
{
	mysqli_close($db);
	echo "4";
}
?>