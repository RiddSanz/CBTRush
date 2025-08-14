<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['mapel']))
{
	//echo $_POST['mapel'];
	$id=mysqli_real_escape_string($db,$_POST['id']);
	$mapel=mysqli_real_escape_string($db,$_POST['mapel']);
	$kelas=mysqli_real_escape_string($db,$_POST['kelas']);
	$group=mysqli_real_escape_string($db,$_POST['group']);
	$oleh=mysqli_real_escape_string($db,$_POST['oleh']);
	$fedit=mysqli_real_escape_string($db,$_POST['fedit']);

	//$oleh = $_SESSION['userid'];
	// time server
	$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);
	$folder = date("YmdHis",$timestamp);
	if ($group=='produktif') {
		$jid=mysqli_real_escape_string($db,$_POST['jid']);
	}
	else
	{
		$jid='0';
	}

	if (isset($_POST['fedit']) && $_POST['fedit']!='') 
	{
		$sql = "update t_mapel set ket_mapel='$mapel',kelas='$kelas',oleh='$oleh', nm_group='$group', jid='$jid' where mid='$fedit'
		";
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
	else
	{
		
		$sql = "insert into t_mapel values('','$folder','','$oleh','$group','$jid','$mapel','$kelas')";
		$fd = "../mapel/$folder";
		if (!is_dir($fd)) {
			mkdir("../mapel/$folder");
			$tujuan = "";
			$tujuan.= "<meta http-equiv='refresh' content='0;url=../index.php'>";            
			$ourFileName = "../mapel/".$folder."/index.html";
        	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
        	$ck = fwrite($ourFileHandle, $tujuan);
        	fclose($ourFileHandle);
        	/*if ($ck) {
            	echo "sukses";
        	}
        	else{
            	echo "$ck";
        	}*/
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
		else
		{
			echo "3";
		}						
	}
}
?>