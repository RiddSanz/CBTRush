<?php 
include "lib/configuration.php";
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
<script src="js/jquery-1.6.4.min.js"></script>
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
	/*
	$("#uploadform").submit(function (e) {
		e.preventDefault();
		var postData = $("#uploadform").serialize();
		var action = $("#uploadform").attr("action");
		$.post(action, function (data) {
			$("#preview").html(data);
		});
	});
	*/
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
<?PHP /*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> 
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a> 
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
	Soal Format Aiken
</div>*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
</ul>
<div class="cpanel">
	<h3>Pilih File Soal Notepad format UTF-8</h3>
	<form class='spUpload' id="uploadform" action="pwww/p-aiken.php" method="post" enctype="multipart/form-data">
		<input id="nameupload" name="nameupload" placeholder="Masukkan file dengan format txt!" class="input5" readonly='yes'/>
		<div class='downloaduser'onclick="window.location='pwww/download-contoh-aiken.php'">Contoh file Notepad</div>
		<div class="fileUpload btnFile">
			<span>Import</span>
			<input type="file" name="file" id="uploadfile"  class="upload" />
		</div>	
		
	</form>
</div>
<div class='spUpload' id='preview'>	
</div>
<?php
		
		$sunit = "select * from t_kd where id_mapel='$idmapel'";
		
		$runit = mysqli_query($db,$sunit);
		echo '<div id="fSaveAiken"><form id="frmAikenSave" action="pwww/p-saveaiken.php" method="post">';
		echo '<input type="hidden" name="bSave" id="bSave" value="1">';
		echo '<select name="smid" id="smid" class="input2">';
		echo '<option value="">---- Pilih Unit KD -----</option>';
		while($bunit = mysqli_fetch_array($runit,MYSQLI_ASSOC))
		{
		?>
			<option value="<?=$bunit['kdid'];?>"><?=$bunit['nama_kd'];?></option>
		<?php 
		}
		echo '</select>';
		echo "<div class='btnupload' id='btnSaveAiken'>Simpan Soal</div><br>";
		echo "<div class='spasi'></div>";	
		echo '</form></div>';
}
?>
