<?php
$target_dir = "../logo/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$idtest=$_POST['idtest'];
$pid=$_POST['pid'];

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";

  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType || "doc" || $imageFileType != "docx" || $imageFileType == "pdf" ) {

}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  echo "<meta http-equiv='refresh' content='0;url=index.php'>";
// if everything is ok, try to upload file
} else {

  $temp = explode(".", $_FILES["fileToUpload"]["name"]);
  $newfilename = $idtest."_".$pid.'.' . end($temp);
  if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../logo/".$newfilename))
  {
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
  }
  else{
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
  }


}

?>
