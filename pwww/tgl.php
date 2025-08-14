<?php
date_default_timezone_set('Asia/Jakarta'); 
$timestamp = time();
$t = date("Y-m-d H:i:s",$timestamp);
$newTime = strtotime("$t 0 hours");
$tgl = date("Y-m-d H:i:s", $newTime);
?>