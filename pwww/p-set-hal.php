<?php 
include "../lib/configuration.php";
// paging record
session_start();
$hal=mysqli_real_escape_string($db,$_GET['jmlhal']);
$_SESSION['jmlhal']=$hal;
echo "1";
?>