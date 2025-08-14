<?php
include "../lib/configuration.php";
if(isset($_POST['ena_token']))
{
	$sql = "select enable_token from t_token limit 1";

	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$ena_token = $br['enable_token'];

	if ($ena_token=='0') {
		$sql = "update t_token set enable_token='1'";
		$rs = mysqli_query($db,$sql);
		if ($rs) {
			echo "1";
		}
		else
		{
			echo "2";
		}
	}
	else
	{
		$sql = "update t_token set enable_token='0'";
		$rs = mysqli_query($db,$sql);
		if ($rs) {
			echo "1";
		}
		else
		{
			echo "2";
		}
	}
}
?>