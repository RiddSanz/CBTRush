<?php
if (file_exists("logo/banner.png")) {
		$banner = "logo/banner.png";
	}
	elseif(file_exists("logo/banner.jpg"))
	{
		$banner = "logo/banner.jpg";
	}
	else
	{
		$banner = "images/piccbt2.png";
	}
?>
<div class='prakatanew'>
<p>
 <?php 
 	if($ww=='')
 	{
 		echo "CBT merupakan aplikasi berbasis web yang dapat digunakan oleh para guru untuk melakukan ujian secara online kepada siswanya.";
 	}
 	else
 	{
 		echo $ww;
 	}

 ?>
</p>
<img src="<?=$banner;?>" class="imglink" align="absmiddle" height="312px">
</div>
