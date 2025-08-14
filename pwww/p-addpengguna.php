<?php
include("../lib/configuration.php");
session_start();
include "tgl.php";
$oleh = $_SESSION['userid'];

if(isset($_POST['uid']) && isset($_POST['pengguna'])  && isset($_POST['kunci']) && isset($_SESSION['fadduser']))
{
	$tvalid = strtotime($tgl) - strtotime($_SESSION['fadduser']);

		$uid=mysqli_real_escape_string($db,$_POST['uid']);
		$id=mysqli_real_escape_string($db,$_POST['id']);
		$pengguna=mysqli_real_escape_string($db,$_POST['pengguna']);
		$agama=mysqli_real_escape_string($db,$_POST['agama']);
		$ruang=mysqli_real_escape_string($db,$_POST['ruang']);
		$sesi=mysqli_real_escape_string($db,$_POST['sesi']);
		$kunci=mysqli_real_escape_string($db,$_POST['kunci']);
		$tingkat=mysqli_real_escape_string($db,$_POST['tingkat']);
		$sekolah = mysqli_real_escape_string($db,$_POST['sekolah']);

		if($tingkat=='0')
		{
			if ($_SESSION['kelompok_user']=='su') {
				$kelompok = 'admin';
				$tingkat = '0';
			}
			else
			{
				$kelompok = 'operator';
				$tingkat = '1';
			}

		}
		elseif($tingkat=='1')
		{
			$kelompok = 'operator';
		}
		elseif($tingkat=='2')
		{
			$kelompok = mysqli_real_escape_string($db,$_POST['kelompok']);
		}

		if (isset($_POST['id']) && $_POST['id']!='')
		{
			$sql = "update t_peserta set kunci='$kunci',nama_pengguna='$pengguna',kelompok='$kelompok',tingkat='$tingkat',
					sekolah='$sekolah',ruang='$ruang',sesi='$sesi',agama='$agama' where pid=$id
			";
		}
		else
		{
			$sql = "insert into t_peserta values(NULL,'$uid','$kunci','$pengguna','$kelompok','$tingkat','$sekolah','$oleh','$tgl','$ruang','$agama','$sesi')";
		}

		$result=mysqli_query($db,$sql);

		if($result)
		{
			echo "1";
		}
		else
		{
			echo "$sql";
		}

}

?>
