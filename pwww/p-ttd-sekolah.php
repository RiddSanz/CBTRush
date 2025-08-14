<?php
session_start();
$folder = "../logo/";
$target = $folder . basename( $_FILES['file_tugas3']['name']) ;

$extensionList = array("JPG","jpg");

$cekEks = basename( $_FILES['file_tugas3']['name']) ;

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
	//echo "file kosong";
}
else
{
	//echo $target;
	if(in_array($ekstensi, $extensionList))
	{
		unlink($folder."/ttd.jpg");
		//unlink($folder."/ttd.JPG");
		$temp = explode(".", $_FILES['file_tugas3']['tmp_name']);
		$newfilename = 'ttd.' . $ekstensi;
		if(move_uploaded_file($_FILES['file_tugas3']['tmp_name'], $folder."" . $newfilename))
		{

			echo "<meta http-equiv='refresh' content='0;url=../index.php?pg=infot'>";
		}
	}
	else
	{
		//echo "Ekstensi file salah!";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?pg=infot'>";
	}
}
?>
