<?php
session_start();
$idmapel = $_SESSION['idmapel'];
$nm_mapel = $_SESSION['mapelnya'];
$dataimg="";

// image extensions
$extensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
$result = array();
$directory = new DirectoryIterator('../mapel/'.$nm_mapel.'/');
foreach ($directory as $fileinfo) {
    if ($fileinfo->isFile()) {
        $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
        if (in_array($extension, $extensions)) {
            $result[] = $fileinfo->getFilename();
        }
    }
}

if (count($result)==0) {
	$dataimg="";
}
else
{
  sort($result);
	for ($i=0; $i < count($result); $i++) {
		$dt = "mapel/".$nm_mapel."/".$result[$i];
		$dataimg .= '["'.$result[$i].'", "'.$dt.'"]';
		if ($i!=(count($result)-1)) {
			$dataimg .= ",";
		}
	}

}

echo '
	var tinyMCEImageList = [';
	echo $dataimg;
	echo '];';

//header('Content-type: text/javascript'); // browser will now recognize the file as a valid JS file
?>
