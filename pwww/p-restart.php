<?php
session_start();
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']) && $_SESSION['tingkat_user']=='0')
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if($_SESSION['tingkat_user']=='0')
	{
		if($_GET['action'] == 'restart'){
			$ls = exec("./prst.sh");
			echo "1";
		}
		
	}
}
/*
cara penggunaan :
- ganti file menjadi file sudoers dengan cara 
	#chmod 6755 restart.sh
- ijinka file /sbin/reboot agar bisa diakses user normal dengan cara
	#chmod u+s /sbin/sh
*/
?>
