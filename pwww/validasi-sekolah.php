<?php
include("lib/configuration.php");
include "212encrypt.php";
$sekNm = "SEKOLAH CONTOH";
$sekId = "000";
if (!isset($_SESSION['trueValKey']) || empty($_SESSION['trueValKey'])) {
	$sval = "select * from t_sekolah limit 1";
	$rsval = mysqli_query($db,$sval);
	$brval = mysqli_fetch_array($rsval,MYSQLI_ASSOC);
	$validsekolah = $brval['validasi_key'];
	$tgl_valid = $brval['tgl_exp_validasi'];
	$sekNm = $brval['nama_sekolah'];
	$sekId = $brval['sid'];
	$valKey = de212($validsekolah);

	$indicator = $sekId.$sekNm;

	if ($validsekolah!='' and $indicator==$valKey) {
		$_SESSION['trueValKey'] = $validsekolah;
		$_SESSION['namaSEKOLAH'] = $sekNm;
		$_SESSION['sid_user'] = $sekId;
	}
}
else
{
	if (isset($_SESSION['namaSEKOLAH']) || isset($_SESSION['sid_user'])) {
		$sekNm = $_SESSION['namaSEKOLAH'];
		$sekId = $_SESSION['sid_user'];
	}
	else
	{
		$sval = "select * from t_sekolah Limit 1";
		$rsval = mysqli_query($db,$sval);
		$brval = mysqli_fetch_array($rsval,MYSQLI_ASSOC);
		$validsekolah = $brval['validasi_key'];
		$tgl_valid = $brval['tgl_exp_validasi'];
		$sekNm = $brval['nama_sekolah'];
		$sekId = $brval['sid'];
		$_SESSION['trueValKey'] = $validsekolah;
		$_SESSION['sid_user'] = $sekId;
		$_SESSION['namaSEKOLAH'] = $sekNm;
	}
}
/*echo 'Validasi Key : '.$_SESSION['trueValKey'];*/
/*echo $_SESSION['sid_user'];*/
?>
