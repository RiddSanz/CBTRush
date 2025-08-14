<?php
session_start();
$id = $_SESSION['idmapel'];
$nm_mapel = $_SESSION['mapelnya'];
$oleh = $_SESSION['userid'];
// time server
$timestamp = time();
$tgl = date("Y-m-d H:i:s",$timestamp);

$folder = trim($nm_mapel);
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

$valid_formats = array("wav", "mp4", "mp3","webm");
$extensionList = array("wav", "mp4", "mp3","webm");


if (!($_FILES['photoimg']['error'] > 0)) 
{
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
      if(in_array($ekstensi, $extensionList))
      {
        if($size<(10240*1024)) // Image size max 10 MB
        {
          
          $tmp = $_FILES['photoimg']['tmp_name'];
          $actual_image_name = $name;
          $besar = $_FILES['photoimg']['size'];
          if(move_uploaded_file($tmp, $path.$actual_image_name))
          {
            echo "<meta http-equiv='refresh' content='0;url=../index.php?pg=av-up'>";
          }
          else
            echo "failed";
        }
        else
          echo "Image file size max 10 MB"; 
        }
      else{
        echo "Invalid file format.."; 
        echo "File bertipe : ".$_FILES['photoimg']['type'];
      }
    }
    else
      echo "Please select file..!";
    exit;
  }
  else
  {
    echo "Sorry failed!";
  }
}
else{
  echo "<meta http-equiv='refresh' content='0;url=../?pg=f-addav'>";
  echo "error empty file";
}
?>