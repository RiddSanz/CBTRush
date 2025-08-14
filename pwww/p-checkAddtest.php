<?php
include("../lib/configuration.php");
session_start();
$uid=mysqli_real_escape_string($db,$_POST['kd']);
$oleh = $_SESSION['userid'];
$sql = "select * from t_test where kode_test='$uid' limit 0,1";
$rs=mysqli_query($db,$sql);
$total_records = mysqli_num_rows($rs);  //count number of records

echo $total_records;

?>