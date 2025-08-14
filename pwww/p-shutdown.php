<?php
session_start();
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']) && $_SESSION['tingkat_user']=='0')
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if($_SESSION['tingkat_user']=='0')
	{
		if($_GET['action'] == 'shutdown'){
			$ls = exec("./psh.sh");
			echo "1";
		}
		
	}
}
?>
