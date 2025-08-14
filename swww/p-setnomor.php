<?php 
include "../lib/configuration.php";
session_start();
$nomor=mysqli_real_escape_string($db,$_GET['nomorid']);
$_SESSION['nomor']=$nomor;
echo "1";
?>