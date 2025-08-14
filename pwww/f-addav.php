<?php
include "lib/configuration.php";
//session_start();	
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
<script type="text/javascript" src="js/jquery.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() 
{
	$('#photoimg').change(function() 
	{
		$("#preview").html('');
		$("#nameimg").val(this.value);
		//$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
		
		var f = $('imageform');
		var l = $('#loader'); // loder.gif image
		var b = $('#button'); // upload button
		var p = $('#preview'); // preview area

		
		$("#preview").html('');
		f.ajaxForm({
			beforeSend: function(){
				l.show();
				b.attr('disabled', 'disabled');
				p.fadeOut();
			},
			success: function(e){
				l.hide();
				f.resetForm();
				b.removeAttr('disabled');
				p.html(e).fadeIn();
			},
			error: function(e){
				b.removeAttr('disabled');
				p.html(e).fadeIn();
			}
		});
	});
});
</script>
<?PHP /*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
	<a href='#' onclick="window.location='?pg=av-up'">Audio Video</a> | Tambah Audio Video
</div>*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li><a href='#' onclick="window.location='?pg=av-up'"><?=$site3;?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site4;?></a></li>
</ul>
<div class='spasi'></div>
<form id="imageform" method="post" enctype="multipart/form-data" action="pwww/p-addav.php">
	<label>Tipe yang dapat diupload mp4,mp3,wav</label>	<br>
	<input id="nameimg" name="nameimg" placeholder="Choose File" class="input5"/>
	<input id="button" type="submit" value="Upload" class='fileUpload'>
	<div class="fileUpload btnFile">
    	<span>Choose</span>
    	<input type="file" name="photoimg" id="photoimg" class="upload" />    	
	</div>
</form>
<img style="display:none" id="loader" src="images/spinner.gif" alt="Loading...." title="Loading...." />
<div id='preview'>
</div>
<div class='spasi'></div>
<div class='spasi'></div>
<div class='spasi'></div>
<?php 
}mysqli_close($db);
?>