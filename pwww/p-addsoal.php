<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['content']) && isset($_POST['mid']))
{
	$mid=mysqli_real_escape_string($db,$_POST['mid']);
	$msg=str_replace("'", "\'", $_POST['content']);
	$smid=mysqli_real_escape_string($db,$_POST['smid']);

	$point_soal=mysqli_real_escape_string($db,$_POST['point_soal']);
	$tingkat_kesulitan=mysqli_real_escape_string($db,$_POST['tingkat_kesulitan']);
	$opsi_esay=mysqli_real_escape_string($db,$_POST['opsi_esay']);

	$a=str_replace("'", "\'", $_POST['a']);
	
/*
	$a = trim_all(strip_tags($a, '<img><span><sup><sub><ol><li><ul>'));
	$b = trim_all(strip_tags($b, '<img><span><sup><sub><ol><li><ul>'));
	$c = trim_all(strip_tags($c, '<img><span><sup><sub><ol><li><ul>'));
	$d = trim_all(strip_tags($d, '<img><span><sup><sub><ol><li><ul>'));
	$e = trim_all(strip_tags($e, '<img><span><sup><sub><ol><li><ul>'));
*/
	if (strpos($msg,'<audio') == true && strpos($msg,'controls="controls"')==false) {
    	$msg = str_replace('<audio', '<audio controls="controls"', $msg);
	}
	if (strpos($msg,'<video') == true && strpos($msg,'controls="controls"')==false) {
    	$msg = str_replace('<video', '<video controls="controls"', $msg);
	}
	

	$oleh = $_SESSION['userid'];
	$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);

	if($opsi_esay=='1') {
		$benar=$a;
		$b='';
		$c='';
		$d='';
		$e='';
	}
	else
	{
		$b=str_replace("'", "\'", $_POST['b']);
		$c=str_replace("'", "\'", $_POST['c']);
		$d=str_replace("'", "\'", $_POST['d']);
		$e=str_replace("'", "\'", $_POST['e']);
		$benar=mysqli_real_escape_string($db,$_POST['benar']);
	}
	
	$fedit=mysqli_real_escape_string($db,$_POST['fedit']);

	if (isset($_POST['fedit']) && $_POST['fedit']!='') 
	{
		$sql = "update t_soal set isi_soal='$msg', pilihan1='$a', pilihan2='$b', pilihan3='$c', pilihan4='$d',
		pilihan5='$e', benar='$benar', id_submapel='$smid' ,tingkat_kesulitan='$tingkat_kesulitan',
		point_soal='$point_soal',opsi_esay='$opsi_esay'
		where qid='$fedit'
		";
		$upd1 = "update t_hsl_test set nilai='1' where idsoal='$fedit' and TRIM(pilihan)='$benar'";
		mysqli_query($db,$upd1);
		$upd2 = "update t_hsl_test set nilai='0' where idsoal='$fedit' and TRIM(pilihan)!='$benar'";
		mysqli_query($db,$upd2);
	}
	else
	{
		$sql = "insert into t_soal values('','$msg','$a','$b','$c','$d','$e','$benar','$smid',
			'$mid','$tgl','$oleh','$opsi_esay','$point_soal','$tingkat_kesulitan')";
	}

	$result=mysqli_query($db,$sql);

	if($result)
	{
		echo "1";
		/*echo isset($_POST['fedit']);*/
	}
	else
	{
		echo "$sql";
	}
}

?>