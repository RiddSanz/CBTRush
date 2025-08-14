<?php
session_start();
$folder = "../logo/"; 
$target = $folder . basename( $_FILES['file_tugas2']['name']) ;

$extensionList = array("PNG","png","JPG","jpg");

$cekEks = basename( $_FILES['file_tugas2']['name']) ;

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
		unlink($folder."/banner.jpg");
		unlink($folder."/banner.png");
		$temp = explode(".", $_FILES['file_tugas2']['tmp_name']);
		$newfilename = 'banner.' . $ekstensi;
		if(move_uploaded_file($_FILES['file_tugas2']['tmp_name'], $folder."" . $newfilename)) 
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