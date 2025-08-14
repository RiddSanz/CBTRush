<?php
include "../lib/configuration.php";
session_start();
include "tgl.php";
if(isset($_SESSION['nomor']))
{
	$nomor=$_SESSION['nomor'];
}
else
{
	$nomor=0;
}
if (isset($_GET['ajax']) && $_GET['ajax']=='9') {
	$_SESSION['nomor'] = $nomor-1;
	mysqli_close($db);
	echo "1";
}
else if (isset($_GET['ajax']) && $_GET['ajax']!='' && $_GET['ajax']!='9') {
	$pid = $_SESSION['pid'];
	$kdtest = $_SESSION['kdtest'];
	if (isset($_GET['jwb'])) {
		$jwb=mysqli_real_escape_string($db,$_GET['jwb']);
		if ($jwb=='undefined') {
			$jwb='';
		}
	}

####### awal ambil data dari view ################
/*
	$sql = "select * from v_test_siswa where id_peserta='$pid' and id_test='$kdtest' limit 1";
	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$rtime= $br['remaining_time'];
	$kuncisiswa = $br['kunci_login'];

	$tgl_login = $br['last_login'];
	$totsoal = $br['jumlah_soal'];
	$bobot = $br['pembobotan'];
	*/
######## akhir view test_siswa ########################

### terjemahan dari atas #####
	$sqlt = "select jumlah_soal,pembobotan from t_test where id='$kdtest' limit 1";
	$rst = mysqli_query($db,$sqlt);
	$brt = mysqli_fetch_array($rst,MYSQLI_ASSOC);

	$totsoal = $brt['jumlah_soal'];
	$bobot = $brt['pembobotan'];

	$sqltp = "select remaining_time,kunci_login,last_login from t_test_peserta where id_test='$kdtest' and id_peserta='$pid' limit 1";
	$rstp = mysqli_query($db,$sqltp);
	$brtp = mysqli_fetch_array($rstp,MYSQLI_ASSOC);

	$rtime = $brtp['remaining_time'];
	$kuncisiswa = $brtp['kunci_login'];
	$tgl_login = $brtp['last_login'];
#######################################

	$rtgl2 = strtotime($tgl) - strtotime($tgl_login);
	$wl = $rtime - $rtgl2;
	$su = "update t_test_peserta set last_login='$tgl',remaining_time='$wl' where id_test='$kdtest' and id_peserta='$pid' limit 1";
	$ru = mysqli_query($db,$su);
	if ($_GET['ajax']=='1') {
		if ($nomor < ($totsoal-1)) {
			$_SESSION['nomor'] = $nomor+1;
		}
	}
	else if($_GET['ajax']=='3')
	{
		$_SESSION['nomor'] = $nomor+1;
	}
	else if($_GET['ajax']=='4')
	{
		$su = "update t_test_peserta set diselesaikan='1' where id_test='$kdtest' and id_peserta='$pid' limit 1";
		$ru = mysqli_query($db,$su);
		//$_SESSION['wtfinish'] = '1';
		$_SESSION['wtfinish']=NULL;
		$_SESSION['kdtest']=NULL;
		$_SESSION['nomor'] = NULL;
		$_SESSION['soals'] = NULL;
		$_SESSION['tminus'] = NULL;
	}
	else if($_GET['ajax']=='11')
	{
		$_SESSION['nomor'] = $nomor;
	}
	else
	{
		$_SESSION['nomor'] = $nomor-1;
	}

	$ts = count($_SESSION['soals']);
	if (isset($_GET['jwb'])) {
		if ($nomor<$ts) {
			$qid = $_SESSION['soals'][$nomor];
			$sql = "select idpeserta from t_hsl_test where idpeserta='$pid' and idtest='$kdtest' and idsoal='$qid' limit 1";
			$rs = mysqli_query($db,$sql);
			$total_records = mysqli_num_rows($rs);
			if ($total_records==0) {
				$sql = "insert into t_hsl_test values('$kdtest','$qid','$pid','$jwb','$tgl')";
			}
			else
			{
				$sql = "select benar,point_soal,opsi_esay from t_soal where qid='$qid' limit 1";
				$rs = mysqli_query($db,$sql);
				$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
				if ($br['opsi_esay']=='0') {
					if($bobot=='1'){
						if ($jwb==$br['benar']) {
							$nilai = '2';
						}
						else{
							$nilai = '-1';
						}
					}
					else{
						if ($jwb==$br['benar']) {
							$nilai = $br['point_soal'];
						}
						else{
							$nilai = '0';
						}
					}

				}
				else {
					/*similar_text($jwb, strip_tags($br['benar']), $percent);
					$nilai = round(($br['point_soal']*$percent)/100);
					*/
					$nilai = '0';
				}
				$sql = "update t_hsl_test set pilihan='$jwb', tgl_submit='$tgl',nilai='$nilai' where idpeserta='$pid' and idtest='$kdtest' and idsoal='$qid'";
			}
			mysqli_query($db,$sql);
		}
		else
		{
			$_SESSION['nomor'] = $ts;
			mysqli_close($db);
			echo "1";
		}
	}

	if($kuncisiswa=='1')
	{
		$_SESSION['pidlock'] = '1';
		mysqli_close($db);
		echo "1";
	}
	else{
		echo "1";
	}
}
else
{
	mysqli_close($db);
	echo "2";
}
?>
