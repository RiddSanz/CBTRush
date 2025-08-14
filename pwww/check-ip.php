<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	
	/*
	echo "<h2>Client IP Demo</h2>";
	echo "Your IP address : " . $ip;
	echo "<br>Your hostname : ". gethostbyaddr($ip) ;
		
	$ipAddress=$_SERVER['REMOTE_ADDR'];
	$macAddr=false;

	$arp=`arp -a $ipAddress`;
	$lines=explode("\n", $arp);

	foreach($lines as $line)
	{
	   $cols=preg_split('/\s+/', trim($line));
	   if ($cols[0]==$ipAddress)
	   {
	       $macAddr=$cols[1];
	   }
	}
	echo $macAddr;*/
	/*$lhip = gethostbyaddr($ip);
	$lip = $ip;					
	$lmac = "";*/
	
	$ip = "";
	$lhip = "";
	$lip = "";
	$lmac = "";
?>