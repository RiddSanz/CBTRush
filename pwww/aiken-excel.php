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
	$idmapel = $_SESSION['idmapel'];
	$smapel = "select * from t_mapel where mid='$idmapel' limit 1";
	$rmapel = mysqli_query($db,$smapel);
	$bmapel = mysqli_fetch_array($rmapel,MYSQLI_ASSOC);
	$nm_mapel = $bmapel['nama_mapel'];
	$ket_mapel = $bmapel['ket_mapel'];
	$kelas = $bmapel['kelas'];
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
<?php /*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> 
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a> 
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
	Soal Format Excel
</div>*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
</ul>
<div class="cpanel">
	<h3>FILE BENTUK XLS!</h3>
	<form class='spUpload' id="uploadform" action="pwww/p-aikenexcel.php" method="post" enctype="multipart/form-data">
		<input id="nameupload" name="nameupload" placeholder="Nama File yang diimport!" class="input5" readonly='yes'/>
		<div class='downloaduser'onclick="window.location='contoh_formsoal.xls'">Contoh file xls</div>
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
