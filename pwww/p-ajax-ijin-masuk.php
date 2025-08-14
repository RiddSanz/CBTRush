<?php
include("../lib/configuration.php");
session_start();
include "tgl.php";
/*
include "check-ip.php";
*/
if(isset($_POST['username']) && isset($_POST['password']))
{
	/*$timestamp = time();*/
	$tgll = date("Y-m-d",$timestamp);
	$tglnow = date("Y-m-d H:i:s",$timestamp);
	$username=mysqli_real_escape_string($db,$_POST['username']); 
	 
	$password=mysqli_real_escape_string($db,$_POST['password']);
	$code=mysqli_real_escape_string($db,$_POST['user_code']); 
	$_SESSION['fadduser'] ="";

	if(isset($_POST['user_code']))
	{
		if($code == $_SESSION['kode_captcha'])
		{
			$sql = "select * FROM t_peserta WHERE pengguna='$username' and kunci='$password'";

			$result=mysqli_query($db,$sql);
			$count=mysqli_num_rows($result);
			$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			
			if($count==1)
			{
				$_SESSION['user_nama']=$row['nama_pengguna']; 
				$_SESSION['userid']=$row['pengguna'];
				$_SESSION['kelompok_user']=$row['kelompok'];
				$_SESSION['tingkat_user']=$row['tingkat'];
				//$_SESSION['sid_user']=$row['sekolah'];
				$_SESSION['pid']=$row['pid'];
				$lpid = $row['pid'];
				$lip = $_SESSION['ipku'];	
				$lhip = $_SESSION['host'];
				$lmac = $_SESSION['mac'];
				$browser = $_SESSION['browser'];	
				$os = $_SESSION['os'];
				$sys = $_SESSION['system'];			
				$cookie_name = $row['pid'];
				$cookie_value = $sys;

				$cek_log = "select * from t_activity where t_who='".$row['pid']."' and t_jam_log like '$tgll%' limit 1";
				$rs = mysqli_query($db,$cek_log);
				$jdata = mysqli_num_rows($rs);
				
				if ($jdata==0) {
					if (isset($_COOKIE[$cookie_name])) {
						$_COOKIE[$cookie_name]==NULL;
					}				
					setcookie($cookie_name, $cookie_value, time() + (18000), "/"); /* 5 jam cookie*/
					$logcookie = $cookie_value;
					$slog = "insert into t_activity values('','$lpid','$lip','$lhip','$lmac','$tgl','$browser','$os','$sys','$logcookie')";
					mysqli_query($db,$slog);
					
					mysqli_close($db);
					echo "1";
				}
				else{					
					if ($_SESSION['tingkat_user']=='2') {
						$sqlkunci = "select a.* from t_test_peserta a,t_test b where a.id_test=b.id and id_peserta='".$row['pid']."' and b.tgl_awal_test like '$tgll%' and a.kunci_login='1'";
						$rskunci = mysqli_query($db,$sqlkunci);
						$jkunci = mysqli_num_rows($rskunci);
						//echo $sqlkunci;

						if($jkunci==0)
						{
							$siswaid = $_SESSION['pid'];						
							$brcookie = mysqli_fetch_array($rs,MYSQLI_ASSOC);
							//cek ada log cookie atau tidak
							if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name]==$brcookie['log_cookie']) {
								mysqli_close($db);
								echo '1';
							}
							else{
								$_SESSION['kelompok_user']=NULL;
								$_SESSION['tingkat_user']=NULL;
								$_SESSION['user_nama']=NULL;
								$_SESSION["userid"]=NULL;
								/*$_SESSION['sid_user']='';*/
								$_SESSION['pid']=NULL;
								$_SESSION['kdtest']=NULL;
								$_SESSION['idmapel']=NULL;
								$_SESSION['token']=NULL;
								$_SESSION['pid']=NULL;
								$_SESSION['jmlhal']=NULL;
								$_SESSION['fdata']=NULL;
								$_SESSION['soals']=NULL;
								$_SESSION['wtfinish']=NULL;
								$_SESSION['pidlock']=NULL;
								$_SESSION['enable_token']=NULL;
								$_SESSION['nomor']=NULL;
								$_SESSION['acjwb']=NULL;
								mysqli_close($db);
								echo '6';
							}	
						}
						else{
							$_SESSION['kelompok_user']=NULL;
							$_SESSION['tingkat_user']=NULL;
							$_SESSION['user_nama']=NULL;
							$_SESSION["userid"]=NULL;
							/*$_SESSION['sid_user']='';*/
							$_SESSION['pid']=NULL;
							$_SESSION['kdtest']=NULL;
							$_SESSION['idmapel']=NULL;
							$_SESSION['token']=NULL;
							$_SESSION['pid']=NULL;
							$_SESSION['jmlhal']=NULL;
							$_SESSION['fdata']=NULL;
							$_SESSION['soals']=NULL;
							$_SESSION['wtfinish']=NULL;
							$_SESSION['pidlock']=NULL;
							$_SESSION['enable_token']=NULL;
							$_SESSION['nomor']=NULL;
							$_SESSION['acjwb']=NULL;
							mysqli_close($db);
							echo "8";
						}								
					}
					else
					{
						mysqli_close($db);
						echo "1";
					}
				}
								
				//mysqli_close($db);
				//echo "1";
				
			}
			else
			{
				mysqli_close($db);
				echo "2";
			}
		}
		else
		{
			mysqli_close($db);
			echo "4";
		}
		
	}
	else
	{
		mysqli_close($db);
		echo "3";
	}

}
?>