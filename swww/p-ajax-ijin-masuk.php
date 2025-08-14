<?php
include("../lib/configuration.php");
session_start();
include "tgl.php";
if(isset($_POST['username']) && isset($_POST['password']))
{
	/*$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);*/
	$username=mysqli_real_escape_string($db,$_POST['username']); 
	 
	$password=mysqli_real_escape_string($db,$_POST['password']);
	$code=mysqli_real_escape_string($db,$_POST['user_code']); 

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
				$_SESSION['sid_user']=$row['sekolah'];
				$_SESSION['pid']=$row['pid'];
				if ($_SESSION['tingkat_user']=='2') {
					$siswaid = $_SESSION['pid'];
					$sql2 = "select * from v_test_siswa where id_peserta='$siswaid' and diselesaikan='0' order by tgl_awal_test asc limit 0,1";

					$rs = mysqli_query($db,$sql2);
					$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
					$tot_test = mysqli_num_rows($rs);
					$durasi = $br['waktu_test'];
					$rtime= $br['remaining_time'];
					$tgl2 = $br['tgl_akhir_test'];
					$rtgl2 = strtotime($tgl2) - strtotime($tgl);

					if ($tot_test==0) {
						$_SESSION['user_nama']=''; 
						$_SESSION['userid']='';
						$_SESSION['kelompok_user']='';
						$_SESSION['tingkat_user']='';
						$_SESSION['sid_user']='';
						$_SESSION['pid']='';
						mysqli_close($db);
						echo '5'; /*tidak memiliki test*/
					}
					else
					{
						if ($br['kunci_login']=='1') {
							$_SESSION['user_nama']=''; 
							$_SESSION['userid']='';
							$_SESSION['kelompok_user']='';
							$_SESSION['tingkat_user']='';
							$_SESSION['sid_user']='';
							$_SESSION['pid']='';
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
								$_SESSION['sid_user']='';
								$_SESSION['pid']='';
								mysqli_close($db);
								echo '6'; /*kondisi msh login*/
							}
							else
							{
								$_SESSION['kdtest']=$br['id_test'];
								$kdtest = $br['id_test'];
								if ($rtime=='') {
									$ts = $durasi*60;
									if ($ts<$rtgl2) {
										$ts = $ts;
									}
									else
									{
										$ts = $rtgl2;
									}
									$s = "update t_test_peserta set remaining_time='$ts' where id_test='$kdtest' and id_peserta='$siswaid' limit 1";
									$r = mysqli_query($db,$s);
								}				
								mysqli_close($db);
								echo '1';
							}
						}						
					}
				}
				else
				{
					mysqli_close($db);
					echo "1";
				}
				
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