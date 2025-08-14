<?php
/**
 * Unzip File in the same directory.
 * @link http://stackoverflow.com/questions/8889025/unzip-a-file-with-php
 */
$file = '../update/cbtfile.zip';
 
$path = pathinfo( realpath( $file ), PATHINFO_DIRNAME );
 
$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
    $zip->extractTo( $path );
    $zip->close();
    /*echo "Prosessing! $file extracted to $path";*/
    $ls = exec("./prst.sh");
    echo "1";
}
else {
    echo "Sorry! I couldn't proses the update file!";
}
?>