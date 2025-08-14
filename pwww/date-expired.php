<?php
date_default_timezone_set('Asia/Jakarta');
$timestamp = time();
$date1 = strtotime('2030-12-30 23:55'); // hanya 14 tahun
$date2 = strtotime(date("Y-m-d",$timestamp));
$date3 = strtotime('2016-10-15 23:55');
$diff= $date1 - $date2; //-2592000
//echo $diff;
if ($diff > 2678400) { //7948500
	$counterlisensi = true;
}
else
{
	$counterlisensi = false;
}
?>