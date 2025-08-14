<?php
error_reporting(0);
ini_set('display_errors', 0);
include "../lib/configuration.php";
session_start();
include "tgl.php";
include "212encrypt.php";
include "addr-server.php";
$pid = $_SESSION['pid'];

if (isset($_GET['ajax']) && $_GET['ajax']!='' && isset($_GET['valKEY']) && $_GET['valKEY']!='')
{
	$valKEY=mysqli_real_escape_string($db,$_GET['valKEY']);

	// maximum execution time in seconds
	set_time_limit (24 * 60 * 60);

	if (!isset($_GET['url'])) die();


    // folder to save downloaded files to. must end with slash
	$destination_folder = '../soal/';
	
	$url = $addr."".$valKEY.".txt";
	$newfname = $destination_folder . basename($url);

    $response = get_headers($url);
    //print_r($response);
	if($response[0] === 'HTTP/1.1 200 OK')
	{
    	$file = fopen ($url, "rb");
		if ($file)
		{
			      /*$newf = fopen ($newfname, "wb");

			      if ($newf)
			      while(!feof($file)) {
			        fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
			        $newf.="\n";
			    }*/
		    while ($baris = fgets($file, 4096))
		    {
		    	if (empty($baris) or trim($baris)=="") {
		    		continue;
		    	}
		    	/*/echo strip_tags($baris)."<br/>";*/
		    	$temp[] = trim($baris);
		    }

			    /*
			    if ($newf) {
			      fclose($newf);
			  }*/
			 //print_r($temp);
			$sekId = $temp[0];
			$sekNm = $temp[1];
			$valKey = de212($temp[2]);
				//$valKey = md5($sekId."M4541NUN".$sekNm);
			$indicator = $sekId.$sekNm;
			if ($valKey==$indicator) {
				$cs = "select * from t_sekolah";
				$rc = mysqli_query($db,$cs);
				$jc = mysqli_num_rows($rc);
				if ($jc==0) {
					$su = "insert into t_sekolah VALUES('$temp[0]', '$temp[1]', 'admin', '$tgl', ADDTIME('$tgl','1825 00:00:00'), '$temp[2]')";
					/*$sbackup = "insert into t_peserta(pengguna,kunci,nama_pengguna,kelompok,tingkat)
								values('cbtreset','$valKEY','User Backup','admin','0')";
					mysqli_query($db,$sbackup);*/
				}
				else
				{
					$su = "update t_sekolah set sid='$temp[0]',nama_sekolah='$temp[1]',validasi_key='$temp[2]',tgl_exp_validasi=ADDTIME('$tgl','1825 00:00:00') where 1";
				}
				$ru = mysqli_query($db,$su);
				if ($ru) {
					$_SESSION['trueValKey'] = $temp[2];
					$_SESSION['namaSEKOLAH'] = $sekNm;
					$_SESSION['sid_user'] = $sekId;
					echo "1";
				}
				else
				{
					echo "Maaf data tidak berhasil divalidasi!";
				}
			}
			else
			{
				echo "Maaf data tidak berhasil divalidasi(0)!";
			}
			if ($file) {
				fclose($file);
			}
		}
		else {
			echo "PIN not Valid!";
		}
	}
	else
	{
		echo "Chek your valkey or Check your connections !!!";
	}
}
else
{
	echo "PIN is Wrong";
}
?>
