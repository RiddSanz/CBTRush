<?php
include "lib/configuration.php";

$id=mysqli_real_escape_string($db,$_GET['s']);
$sql = "select * from t_mapel where mid=".$id." limit 0,1";
//echo $sql;
$rs = mysqli_query($db,$sql);
$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
$_SESSION['idmapel']=$br['mid'];
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>
<script type="text/javascript" src="js/jquery.min.img.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() 
{ 
	$('#photoimg').live('change', function() 
	{ 
		$("#preview").html('');
		$("#nameimg").val(this.value);
		$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
		$("#imageform").ajaxForm(
		{
			target: '#preview'
		}).submit();
	});
}); 
</script>
<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li><a href='#' onclick="window.location='?pg=lmapel'"><?=$site2;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site3;?> <?=strtoupper($br['ket_mapel']);?></a></li>
	</ul>
<div class='spasi'></div>
<form id="imageform" method="post" enctype="multipart/form-data" action='pwww/ajaximage.php'>	
	<input id="nameimg" name="nameimg" placeholder="Choose File" class="input5"/>
	<div class="fileUpload btnFile">
    	<span>Upload</span>
    	<input type="file" name="photoimg" id="photoimg" class="upload" />
	</div>
</form>
<div id='preview'>
</div>
<div class='spasi'></div>
<div class='spasi'></div>
<div class='btnback' onclick="window.location='?pg=lmapel'">
	<img src="images/back.png" width="20px" align='absmiddle' class="imglink"> Kembali
</div>
<div class='spasi'></div>
<?php 
}
?>