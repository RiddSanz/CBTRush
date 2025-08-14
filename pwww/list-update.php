<?php
require_once "pwww/cek-koneksi.php";
?>
<script>
$(document).ready(function(){
	$("#btdownload").click(function()
	{
		var sf = document.getElementById("sf").value;
		//alert(sf);

		var link = document.getElementById('btdownload');
		link.style.display = 'none';
		$("#confirmData").html('<br><span class="updateheader">Starting checking and downloading data!</span><br>');
		$("#frame").attr("src", "pwww/cek-update.php?sf="+sf);
		//$( "form" ).submit();
	});

});
</script>
<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=ms'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
<div class="spasi"></div>
<?php
/*echo $st_baru;*/
echo "Current Version :".$versi_cur;
echo " Rev.".$rev_cur;
echo "<br><br>";
/*echo (floatval($rev_baru) > floatval($rev_cur));*/
if (floatval($versi_baru) > floatval($versi_cur) || floatval($rev_baru) > floatval($rev_cur)) {
	echo "Available Version ";
	echo "CBTRush Versi ".$versi_baru;
	echo " Rev.".$rev_baru;
	echo "<br>File size : ".ubah($size_file);
	echo "<br>".$data_update;
	echo ' <img src="images/new.png" height="20px" class="imglink" align="absmiddle"/><br><br>';
	?>
	<?php /*<form action="<?php echo $_SERVER['PHP_SELF'];?>?pg=updater&sf=<?php echo $size_file;?>" method="post">*/?>
		<input type='hidden' id='sf' value='<?php echo $size_file;?>'>
		<input type='button' name='download' value='Download files' id='btdownload'>
	<?php /*</form>*/?>
	<div id='confirmData'></div>
	<div id="mydiv">
		<iframe id="frame" src="" width="100%" frameborder="0" scrolling="no" onload="resizeIframe(this)" >
   		</iframe>
	</div>
	<?php
	/*echo '<meter id="pmeter" class="ph_meter" value="0" min="0" max="'.$size_file.'">2 out of 10</meter>';
	*/

	/*
	echo "<br>Total data yang diupdate : ".($filesize/1024)." KB <br>";
	*/
}
else
{
	echo "Update CBTRush belum tersedia!";
}
function ubah($sf)
{
    $size = $sf;
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
?>
