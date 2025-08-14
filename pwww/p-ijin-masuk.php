<?php
session_start();
include "koneksi.php";

$user = $_POST['user'];
$password = $_POST['pass'];
$valid = $_POST['user_code'];

	//echo $user;
	//echo $password;
	//echo $valid;

	$sql = "select * from login where username='$user' limit 0,1";

	//echo $sql;

	//bagian validasi kode
	if($valid==$_SESSION['kode_captcha'])
	{
		//jika benar
		$rs = mysql_query($sql);
		$br = mysql_fetch_array($rs);

		$passfromDB = $br['password'];

		if($passfromDB == md5($password))
		{
			//jika benar
			$_SESSION['user_nama'] = $br['nama'];
			$_SESSION['userid'] = $user;

			//echo "Sudah benar semua";
			echo "<meta http-equiv='refresh' content='0;url=index.php'>";
		}
		else
		{
			//jika salah
			echo "<meta http-equiv='refresh' content='0;url=index.php'>";
			//echo "password salah";
		}
	}
	else
	{
		//jika salah
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
		//echo "validasi kode salah";
	}

?>