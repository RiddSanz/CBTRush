<?php
include "../lib/configuration.php";
session_start();
//$session_id='1'; // User session id
//$_SESSION['idmapel']=$br['id'];
$id = $_SESSION['idmapel'];
$oleh = $_SESSION['userid'];
// time server
$timestamp = time();
$tgl = date("Y-m-d H:i:s",$timestamp);

$s = "select * from t_mapel where mid=".$_SESSION['idmapel']."";
$r = mysqli_query($db,$s);
$b = mysqli_fetch_array($r,MYSQLI_ASSOC);
$folder = trim($b['nama_mapel']);
$path = "../mapel/".$folder."/";
$path2 = "mapel/".$folder."/";
/*if($b['pic']!="")
{
  if(file_exists("../$path/".$b['pic'].""))
  {
    unlink("../$path/".$b['pic']);
  }
  
}*/
if (!file_exists($path)) {
    mkdir("../mapel/" . $folder, 0777);
    //echo "The directory $folder was successfully created.";
    //exit;
}

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG","PNG","GIF","BMP","JPEG");
$extensionList = array("jpg", "png", "gif", "bmp","jpeg","JPG","PNG","GIF","BMP","JPEG");

$cekEks = basename( $_FILES['photoimg']['name']) ;

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

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
  $name = $_FILES['photoimg']['name'];
  $size = $_FILES['photoimg']['size'];
  if(strlen($name))
  {
    //list($txt, $ext) = explode(".", $name);
    if(in_array($ekstensi, $extensionList))
    {
      if($size<(1024*1024)) // Image size max 1 MB
      {
        
        $tmp = $_FILES['photoimg']['tmp_name'];
        //$actual_image_name = "pic".$_SESSION['idmapel']."-".$name;
        $actual_image_name = $name;
        $besar = $_FILES['photoimg']['size'];
        if(move_uploaded_file($tmp, $path.$actual_image_name))
        {
          $s = "insert into t_image values('','$id','$actual_image_name','$besar','$tgl','$oleh')";
          mysqli_query($db,$s);
          //echo "<br><img src='".$path2."".$actual_image_name."' class='preview' width='100px'>";
          echo "<meta http-equiv='refresh' content='0;url=../index.php?pg=img-up'>";
        }
        else
          echo "failed";
      }
      else
        echo "Image file size max 1 MB"; 
      }
    else{
      echo "Invalid file format.."; 
      echo "File bertipe : ".$_FILES['photoimg']['type'];
    }
  }
  else
    echo "Please select image..!";
  exit;
}
?>