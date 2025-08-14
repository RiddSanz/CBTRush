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
	//echo $idmapel;
?>
<link href="css/uploadfilemulti.css" rel="stylesheet">
<script src="js/jquery-1.8.0.min.js"></script>
<script src="js/jquery.fileuploadmulti.min.js"></script>
<?PHP /*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
	<a href='#' onclick="window.location='?pg=img-up'">Gambar</a> | Tambah gambar
</div>*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li><a href='#' onclick="window.location='?pg=img-up'"><?=$site3;?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site4;?></a></li>
</ul>
<div class='spasi'></div>
<div class="btnback3 letakKanan u12" onclick="window.location='?pg=img-up'">
	<img src="images/kembali.png" height="20px" align='absmiddle' class="imglink"> Kembali
</div>
<div id="mulitplefileuploader">Upload</div>
<div id="status"></div>
<script>

$(document).ready(function()
{

var settings = {
	url: "pwww/mfiles-upload.php",
	method: "POST",
	allowedTypes:"jpg,png,gif,doc,pdf,zip",
	fileName: "myfile",
	multiple: true,
	onSuccess:function(files,data,xhr)
	{
		$("#status").html("<font color='green'>Upload is success</font>");
		
	},
    afterUploadAll:function()
    {
        //alert("all images uploaded!!");
        //$("body").load("index.php?pg=img-up").hide().fadeIn(1500).delay(6000);
        $("#status").html("<font color='green'>All Upload is success</font>");
    },
	onError: function(files,status,errMsg)
	{		
		$("#status").html("<font color='red'>Upload is Failed</font>");
	}
}
$("#mulitplefileuploader").uploadFile(settings);

});
</script>
<div class='spasi'></div>
<div class='spasi'></div>
<div class='spasi'></div>
<?php 
}mysqli_close($db);
?>