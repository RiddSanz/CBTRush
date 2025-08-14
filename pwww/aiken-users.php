<?php 
include "lib/configuration.php";

$skid = $_SESSION['sid_user'];
$oleh = $_SESSION['userid'];
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
	var dt = $('preview').text();
	
	if(dt=='')
	{
		$('#fSaveAiken').hide();
	}	
	$('#uploadfile').live('change', function() 
	{ 
		$("#preview").html('');
		$("#nameupload").val(this.value);
		$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
		$("#uploadform").ajaxForm(
		{
			target: '#preview'
		}).submit();
		$('#fSaveAiken').show();
	});
	$('#btnSaveAiken').click(function() 
	{ 
		$("#preview").html('');
		$("#nameupload").val(this.value);
		$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
		$("#frmAikenSave").ajaxForm(
		{
			target: '#preview'
		}).submit();
		$('#fSaveAiken').hide();
	});
}); 
</script>
<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li><a href='#' onclick="window.location='?pg=users'"><?=$site2;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
	</ul>
<div class="cpanel">
	<h3>Klik tombol import untuk pilih file!</h3>
	<form class='spUpload' id="uploadform" action="pwww/p-aikenusers.php" method="post" enctype="multipart/form-data">
		<input id="nameupload" name="nameupload" placeholder="Nama File yang diimport!" class="input5" readonly='yes'/>
		<div class='downloaduser'onclick="window.location='import_user.csv'">Contoh file csv</div>
		<div class="fileUpload btnFile">
			<span>Import</span>
			<input type="file" name="file" id="uploadfile"  class="upload" />
		</div> 	
		
	</form>
</div>
<div class='spUpload' id='preview'>	
</div>
<?php 
}
?>
