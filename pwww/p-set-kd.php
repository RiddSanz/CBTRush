<?php
include "../lib/configuration.php";
if(isset($_GET['ajax']) && isset($_GET['idkd']) && isset($_GET['tmpqid']))
{
	$id=mysqli_real_escape_string($db,$_GET['idkd']);
	$tmpqid=mysqli_real_escape_string($db,$_GET['tmpqid']);
	
	$sql = "update t_soal set id_submapel='$id' where qid in(".$tmpqid.")";

	$rs = mysqli_query($db,$sql);

	if ($rs) {
		echo "1";
	}
	else
	{
		echo "$sql";
	}
}
?>