<?php
session_start();

function randomText($j)
{
    $hslRandom = '';
    $data = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e');
    
    for($i=0;$i<$j;$i++)
    {
        $hslRandom .= $data[rand(0,14)];
    }

    return $hslRandom;
}

$word =  randomText(rand(1,3));
//echo $word;
$_SESSION['kode_captcha'] = $word;

header("Content-Type: image/jpeg");
//buat ukuran image
$image = imagecreatetruecolor(40, 25);
$hitam = imagecolorallocate($image, 0, 0, 0);
$putih = imagecolorallocate($image, 255, 255, 255);
$hijau = imagecolorallocate($image, 92, 191, 74);
$hijautua = imagecolorallocate($image, 0, 134, 65);

//image buat transparant
imagealphablending($image, false);
imagesavealpha($image, true);
$tansparasi_index = imagecolorallocatealpha($image, 255, 255, 255, 127);

//gabungkan semua variable
imagefill($image, 0, 0, $hijautua);
imagefontwidth(15);
imagefontheight(15);
imagestring($image, 5, 10, 3, $word, $putih);

//buat image
imagejpeg($image);
imagedestroy($image);

?>