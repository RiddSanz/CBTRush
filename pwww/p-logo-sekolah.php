<?php
session_start();
include "../lib/configuration.php";

$folder = "../logo/"; 
$target = $folder . basename( $_FILES['file_tugas']['name']) ;

$extensionList = array("GIF","JPG","PNG","BMP","png", "jpg", "jpeg", "gif", "bmp");

$cekEks = basename( $_FILES['file_tugas']['name']) ;

$jmldot = substr_count($cekEks, '.');
$pecah = explode(".", $cekEks);

if($jmldot==1)
{
	$ekstensi = $pecah[1];
}
else
{
	$ekstensi = $pecah[$jmldot];
}
// time server
$timestamp = time();
$tgl = date("Y-m-d H:i:s",$timestamp);

if(empty($cekEks))
{
	echo "<meta http-equiv='refresh' content='0;url=../index.php?pg=infot'>";	
}
else
{
	//echo $target;
	if(in_array($ekstensi, $extensionList))
	{
		if(move_uploaded_file($_FILES['file_tugas']['tmp_name'], $target)) 
		{ 
			$namafile2 = basename($_FILES['file_tugas']['name']);

			$sql = "update t_ujian set logo_sekolah='$namafile2'";
			//echo "$sql";
			//unlink($folder."/".$photoLama);

			$rs = mysqli_query($db,$sql);
			mysqli_close($db);
			echo "<meta http-equiv='refresh' content='0;url=../index.php?pg=infot'>";		
		}
	}
	else
	{
		echo "Ekstensi file salah!";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?pg=infot'>";	
	}
}
?>