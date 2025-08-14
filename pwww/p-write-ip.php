<?php
session_start();
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if($_SESSION['tingkat_user']=='0')
	{
		$ip=$_POST['ip'];
		$netmask=$_POST['netmask'];
		$gw=$_POST['gw'];
		$tujuan = "#!/bin/sh";
		$tujuan .="\n";
		if ($ip!='' && $netmask!='' || $ip!='0') {			
			$tujuan .= "ifconfig eth0 ".$ip." netmask ".$netmask." up";
			if ($gw!='') {
				$tujuan .="\n";
				$tujuan .= "route add default gw ".$gw;
			}
			$tujuan .="\n";
			//$tujuan .= "ifconfig eth1 192.168.34.1 netmask 255.255.255.0 up";
		}
		else{
			$tujuan .="\n";
		}		
		$ourFileName = "../ipconf.sh";
		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		$ck = fwrite($ourFileHandle, $tujuan);
		fclose($ourFileHandle);
		if ($ck) {
			echo "1";
		}
		else{
			echo "$ck";
		}
		
	}
}
?>
