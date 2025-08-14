<?php
include "../lib/configuration.php";
session_start();
//$session_id='1'; // User session id
//$_SESSION['idmapel']=$br['id'];
$path = "../mapelpic/";
$s = "select * from t_mapel where mid=".$_SESSION['idmapel']."";
$r = mysqli_query($db,$s);
$b = mysqli_fetch_array($r,MYSQLI_ASSOC);

if($b['pic']!="")
{
	if(file_exists("../mapelpic/".$b['pic'].""))
	{
		unlink("../mapelpic/".$b['pic']);
	}
	
}

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];
	if(strlen($name))
	{
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats))
		{
			if($size<(1024*1024)) // Image size max 1 MB
			{
				$actual_image_name = "pic".$_SESSION['idmapel'].".".$ext;
				$tmp = $_FILES['photoimg']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$actual_image_name))
				{
					mysqli_query($db,"UPDATE t_mapel SET pic='$actual_image_name' WHERE mid=".$_SESSION['idmapel']."");
					echo "<br><img src='mapelpic/".$actual_image_name."' class='preview' width='100px'>";
				}
				else
					echo "failed";
			}
			else
				echo "Image file size max 1 MB"; 
			}
		else
			echo "Invalid file format.."; 
	}
	else
		echo "Please select image..!";
	exit;
}
?>