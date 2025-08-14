<?php
include "../lib/configuration.php";
//time server
include "tgl.php";
function randomText($j)
{
    $hslRandom = '';
    $data = array('0','1','2','3','4','5','6','7','8','9',
    	'A','B','C','D','E','F','G','H','I','J','K','L'
    	,'M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    
    for($i=0;$i<$j;$i++)
    {
        $hslRandom .= $data[rand(0,35)];
    }

    return $hslRandom;
}

if(isset($_GET['ajax']) && isset($_GET['fdata']))
{
	//$word =  randomText(rand(1,6));
	$word =  randomText(6);

	$id=mysqli_real_escape_string($db,$_GET['fdata']);
	$sql = "update t_token set token='$id' , tgl_exp=ADDTIME('$tgl','0 00:30:00') where 1";
	//echo $sql;
	$rs = mysqli_query($db,$sql);
	//$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	if ($rs) {
		echo "1";
	}
	else
	{
		echo "$sql";
	}
}
?>