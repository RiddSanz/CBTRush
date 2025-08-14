<?php
include "../lib/configuration.php";
// paging record
session_start();
$j = mysqli_query($db,"UPDATE t_peserta set pengguna = TRIM(Replace(Replace(Replace(pengguna,'\t',''),'\n',''),'\r','')) ");
if ($j) {
  echo "1";
}
else {
  echo "2";
}
?>
