<?php
include "lib/configuration.php";
include "tgl.php";
if (isset($_SESSION['tingkat_user']))
{
	if ($_SESSION['tingkat_user']=='2')
	{
		$pid=$_SESSION['pid'];
		$kdtest=$_SESSION['kdtest'];
		$sql="select * from v_test_siswa where id_peserta='$pid' and id_test='$kdtest' limit 1";
		$rs=mysqli_query($db,$sql);
		$br=mysqli_fetch_array($rs,MYSQLI_ASSOC);
		$rtime=$br['remaining_time'];
		$tgl_login=$br['last_login'];
		if ($rtime!='0' && $rtime!='' && (isset($_SESSION['soals']) || $_SESSION['soals']!=NULL))
		{
			if ($tgl_login !='0000-00-00 00:00:00')
			{
				$rtgl2=strtotime($tgl) - strtotime($tgl_login);
			}
			else{
				$rtgl2=0;
			}
			$wl=$rtime - $rtgl2;
			$su="update t_test_peserta set last_login='$tgl',remaining_time='$wl' where id_test='$kdtest' and id_peserta='$pid' limit 1";
			$ru=mysqli_query($db,$su);
		}
	}
	$_SESSION['kelompok_user']='';
	$_SESSION['tingkat_user']='';
	$_SESSION['user_nama']='';
	$_SESSION["userid"]="";
	$_SESSION['sid_user']='';
	$_SESSION['pid']='';
	$_SESSION['kdtest']='';
	$_SESSION['idmapel']='';
	$_SESSION['token']='';
	$_SESSION['pid']='';
	$_SESSION['jmlhal']='';
	$_SESSION['fdata']='';
	$_SESSION['soals']=NULL;
	$_SESSION['wtfinish']='';
	$_SESSION['pidlock']='';
	$_SESSION['nomor']=NULL;
	$_SESSION['acjwb']=NULL;
	$_SESSION['tminus'] = NULL;
	session_destroy();
}/*echo "<meta http-equiv='refresh' content='0;url=../index.php'>";*/
mysqli_close($db);
?>
