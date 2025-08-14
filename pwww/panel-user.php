<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if($_SESSION['tingkat_user']!='2') {
		include "pwww/c-adminoperator.php";
	}
}
/*
?>
<br>
<a href="pwww/logout.php" id="logout" class="tombol">Keluar CBT</a>				
<?php 
*/
?>