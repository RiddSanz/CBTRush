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
		$tanggal_now = $_POST['tanggal'];
		$jam_now = $_POST['jam'];
		$waktu_now = $tanggal_now." ".$jam_now;

		$tujuan = "#!/bin/sh";
		$tujuan .="\n";
		if ($tanggal_now!='' && $jam_now!='') {			
			$tujuan .= 'date --set="'.$waktu_now.'"';			
		}
		$ourFileName = "../stime.sh";
		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		$ck = fwrite($ourFileHandle, $tujuan);
		fclose($ourFileHandle);
		/*if ($ck) {
			echo "1";
		}
		else{
			echo "$ck";
		}*/

		if($_POST['action'] == 'setwaktu'){
			$ls = exec("./prst.sh");
			echo "1";
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
