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
		$tujuan = "#!/bin/sh";
		$tujuan .="\n";
		
		$ourFileName = "../stime.sh";
		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		$ck = fwrite($ourFileHandle, $tujuan);
		fclose($ourFileHandle);
		
		if($_POST['action'] == 'setwaktu'){
			echo "1";
		}
		else
		{
			echo "gagal";
		}
		
	}
}
/*
cara penggunaan :
- ganti file menjadi file sudoers dengan cara 
	#chmod 6755 time.sh
- ijinka file /sbin/reboot agar bisa diakses user normal dengan cara
	#chmod u+s /bin/date
*/
?>
