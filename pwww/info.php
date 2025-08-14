<?php
include "lib/configuration.php";
$sql = "select * from t_ujian limit 1";

$rs = mysqli_query($db,$sql);
$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
$nmKep = $br['kepsek'];
$nipKep = $br['nip_kepsek'];
$tglval = $br['tgl_ujian'];
$ketF = $br['keterangan'];
$jk = $br['judul_kartu'];
$almt = $br['alamat'];
//echo $ketF;
?>
