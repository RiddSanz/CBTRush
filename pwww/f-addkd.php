<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>
<script>
$(document).ready(function(){

	$("#btnsave").click(function()
	{
		var id=$("#id").val();
		var kd=$("#kd").val();
		var kd_sub=$("#kd_sub").val();
		var kd_indikator=$("#kd_indikator").val();
		var fedit=$("#fedit").val();
		//alert (fedit);
		var dataString = 'kd='+kd+'&fedit='+fedit+'&idmapel='+id+'&sub='+kd_sub+'&indikator='+kd_indikator;
		if($.trim(kd).length>0)
		{
			$.ajax({
				type: "POST",
				url: "pwww/p-addkd.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnsave").val('Waiting to save...');},
				success: function(data){
					if(data=="1")
					{

						window.location.href = "index.php?pg=kd";

					}
					else if(data=="2")
					{

						$("#btnsave").val('Simpan mapel');
						$("#error").html("<span style='color:#cc0000'>Proses penyimpanan gagal!!!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}

				}
			});

		}
		return false;
	});

});
</script>
<?php
include "lib/configuration.php";
$idmapel = $_SESSION['idmapel'];
$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];

if (isset($_GET['s'])) {

	$sql = "select * from t_kd where kdid='".$_GET['s']."' limit 0,1";

	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$kdid = $br['kdid'];
	$nmkd = $br['nama_kd'];
	$nmsub = $br['kd_sub'];
	$nmindikator = $br['kd_indikator'];
}
else
{
	$kdid = '';
	$nmkd = '';
	$nmsub = '';
	$nmindikator = '';
}
?>
<?php /*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
	<a href='#' onclick="window.location='?pg=kd'">Unit KD</a> | Tambah Unit
</div>
*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li><a href='#' onclick="window.location='?pg=kd'"><?=$site3;?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site4;?></a></li>
</ul>
<div class='spasi'></div>
<form method="POST" enctype="multipart/form-data">
	<input type="hidden" name="fedit" value="<?=$kdid;?>" id="fedit">
	<input type="hidden" name="id" value="<?=$idmapel;?>" id="id">
	<label>KODE KD</label><br>
	<input type="text" name="kd" value="<?=$nmkd;?>" id="kd" class="input2"><br>
	<label>KOMPTENSI DASAR</label><br>
	<textarea name="kd_sub" id="kd_sub" class="input2 wdp90" rows="5"><?=$nmsub;?></textarea>	
	<input type="hidden" name="kd_indikator" value="<?=$nmindikator;?>" id="kd_indikator">	<br>
	<input type="button" value="Simpan" name="save" id="btnsave" class="tombol">
	<input type="button" value="Batal" class="tombol" onclick="window.location='?pg=kd'">
</form>
<div id="error"></div>
<?php
mysqli_close($db);
}
?>
