<?php
include("../lib/configuration.php");
session_start();

if(isset($_GET['pil_id']))
{
	$idtest=mysqli_real_escape_string($db,$_GET['pil_id']);
	$kondisi=mysqli_real_escape_string($db,$_GET['ajax']);	
	
	$siswaid = $_SESSION['pid'];
	$sql2 = "select * from v_test_siswa where id_peserta='$siswaid' and id_test='$idtest' order by tgl_awal_test asc limit 0,1";

	$rs = mysqli_query($db,$sql2);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$tot_test = mysqli_num_rows($rs);
	$durasi = $br['waktu_test'];
	$rtime= $br['remaining_time'];
	$tgl2 = $br['tgl_akhir_test'];
	$rtgl2 = strtotime($tgl2) - strtotime($tgl);
	$browsera = $br['browser_type'];
	$osa = $br['os_type'];
	$sysa = $br['system_type'];

	$stoken = "select enable_token from t_token limit 1";
	$rtoken = mysqli_query($db,$stoken);
	$btoken = mysqli_fetch_array($rtoken,MYSQLI_ASSOC);
	$_SESSION['enable_token'] = $btoken['enable_token'];
	$result = mysqli_query($db,$sql);
	if ($br['kunci_login']=='1') 
	{
		mysqli_close($db);
		echo '7';
	}
	else
	{
		if ($br['still_login']=='1') {
			$_SESSION['user_nama']=''; 
			$_SESSION['userid']='';
			$_SESSION['kelompok_user']='';
			$_SESSION['tingkat_user']='';
			//$_SESSION['sid_user']='';
			$_SESSION['pid']='';
			mysqli_close($db);
			echo '6'; /*kondisi msh login*/
		}
		else
		{
			if ($browsera=='' || $sysa=='' || $osa=='') {
				$_SESSION['kdtest']=$br['id_test'];
				$kdtest = $br['id_test'];
				$sysn = $sys.$_SESSION['userid'].$lip.$lhip.$lmac;
				if ($rtime=='') {
					$ts = $durasi*60;
					if ($ts<$rtgl2) {
						$ts = $ts;
					}
					else
					{
						$ts = $rtgl2;
					}
					$s = "update t_test_peserta set remaining_time='$ts',browser_type='$browser',os_type='$os',system_type='$sysn' where id_test='$kdtest' and id_peserta='$siswaid' limit 1";
					$r = mysqli_query($db,$s);
					//echo "1000";										
				}
				else{
					$s = "update t_test_peserta set browser_type='$browser',os_type='$os',system_type='$sysn' where id_test='$kdtest' and id_peserta='$siswaid' limit 1";
					$r = mysqli_query($db,$s);
					//echo "$s";
				}
				mysqli_close($db);
				//echo $browsera;
				echo '1';
			}	
			elseif($browser==$browsera && $os==$osa && ($sys.$_SESSION['userid'].$lip.$lhip.$lmac)==$sysa)
			{
				$_SESSION['kdtest']=$br['id_test'];
				$kdtest = $br['id_test'];
				$sysn = $sys.$_SESSION['userid'].$lip.$lhip.$lmac;
				if ($rtime=='') {
					$ts = $durasi*60;
					if ($ts<$rtgl2) {
						$ts = $ts;
					}
					else
					{
						$ts = $rtgl2;
					}
					$s = "update t_test_peserta set remaining_time='$ts',browser_type='$browser',os_type='$os',system_type='$sysn' where id_test='$kdtest' and id_peserta='$siswaid' limit 1";
					$r = mysqli_query($db,$s);
				}
				mysqli_close($db);
				echo '1';
			}							
		}
	}

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