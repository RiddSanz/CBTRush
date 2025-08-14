<?php
include "../lib/configuration.php";
session_start();
if (isset($_GET['ajax']) && $_SESSION['kelompok_user']=='admin') {
	$kepsek=mysqli_real_escape_string($db,$_GET['kepsek']);
	$nipkepsek=mysqli_real_escape_string($db,$_GET['nipkepsek']);
	$tglkartu=mysqli_real_escape_string($db,$_GET['tglkartu']);
	$ketF=mysqli_real_escape_string($db,$_GET['ketF']);
	$alamat=mysqli_real_escape_string($db,$_GET['alamat']);
	$email=mysqli_real_escape_string($db,$_GET['email']);
	$web=mysqli_real_escape_string($db,$_GET['web']);
	$jk=mysqli_real_escape_string($db,$_GET['jk']);
	$ww=mysqli_real_escape_string($db,$_GET['ww']);
	$desain=mysqli_real_escape_string($db,$_GET['desain']);
	$sql = "update t_ujian set kepsek='$kepsek',nip_kepsek='$nipkepsek',tgl_ujian='$tglkartu',keterangan='$ketF',alamat='$alamat',email='$email',website='$web',judul_kartu='$jk',welcome_front='$ww',desain='$desain' where 1";

	$rs = mysqli_query($db,$sql);
	if ($rs) {
		echo "1";
	}
	else{
		echo "$sql";
	}

}
else
{
	echo "3";
}
?>
