<?php
$cekID = '0';
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	$sekolahku = strtolower($_SESSION['namaSEKOLAH']);
	if(strpos($sekolahku, 'smp') !== false)
	{
		$a = '7';
		$b = '8';
		$c = '9';
	}
	elseif(strpos($sekolahku, 'mts') !== false)
	{
		$a = '7';
		$b = '8';
		$c = '9';
	}
	else
	{
		$kode = explode(" ",$sekolahku);
		if(strpos($kode[0], 'mi') !== false)
		{
			$a = '1';
			$b = '2';
			$c = '3';
			$d = '4';
			$e = '5';
			$f = '6';
			$cekID = '1';
		}
		else if(strpos($kode[0], 'sd') !== false)
		{
			$a = '1';
			$b = '2';
			$c = '3';
			$d = '4';
			$e = '5';
			$f = '6';
			$cekID = '1';
		}
		else{
			$a = '10';
			$b = '11';
			$c = '12';
		}

	}

	//echo $sekolahku;
	//echo (strpos($sekolahku, "sma"));
?>

<script>
$(document).ready(function(){
	//alert('Test');

	$("#btnsavemapel").click(function()
	{
		var id=$("#id").val();
		var mapel=$("#mapel").val();
		var kelas = $("input[name='kelas']:checked").val();
		//var group=$("#group").val();
		var group="umum";
		var oleh=$("#oleh").val();

		var jid=$("#jid").val();
		var fedit=$("#fedit").val();

		var dataString = 'id='+id+'&mapel='+mapel+'&fedit='+fedit+'&group='+group+'&jid='+jid+'&kelas='+kelas+'&oleh='+oleh;

		if($.trim(mapel).length>0)
		{
			$.ajax({
				type: "POST",
				url: "pwww/p-addmapel.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnsave").val('Waiting to save...');},
				success: function(data){
					if(data=="1")
					{
						window.location.href = "index.php?pg=lmapel";
					}
					else if(data=="2")
					{
						$("#btnsave").val('Simpan mapel');
						$("#error").html("<span style='color:#cc0000'>Proses penyimpanan gagal!!!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else if(data=="3")
					{
						$("#btnsave").val('Simpan mapel');
						$("#error").html("<br><span style='color:#cc0000'>Matapelajaran ini sudah ada!.</span> ");
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
if (isset($_GET['s'])) {

	$sql = "select mid,ket_mapel,oleh,nm_group,nama_mapel,kelas from t_mapel where mid='".$_GET['s']."' limit 0,1";

	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$mid = $br['mid'];
	$nmmapel = $br['ket_mapel'];
	if ($nmmapel=='') {
		$nmmapel = $br['nama_mapel'];
	}
	$nmgroup = $br['nm_group'];
	$kelas = $br['kelas'];
	$pengguna = $br['oleh'];
	//echo $sql;
}
else
{
	$mid = '';
	$nmmapel = '';
	$nmgroup = '';
	$kelas = '';
	$pengguna = $_SESSION['userid'];
}
?>
<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li><a href='#' onclick="window.location='?pg=lmapel'"><?=$site2;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
	</ul>
<div class='spasi'></div>
<form method="POST" enctype="multipart/form-data">
	<input type="hidden" name="fedit" value="<?=$mid;?>" id="fedit">
	<label>Nama Pelajaran</label><br>
	<input type="text" name="mapel" value="<?=$nmmapel;?>" id="mapel" class="input2 wdp75 wh25" <?php if(!empty($br['sid'])) echo "readonly='yes'";?>><br>
		<input type="radio" name="kelas" value="<?=$a;?>" class='pilih_soal' <?php if($kelas==$a) echo 'checked ';?>> <label for="X">&nbsp;</label>Kelas <?=$a;?>
  	<input type="radio" name="kelas" value="<?=$b;?>" class='pilih_soal' <?php if($kelas==$b) echo 'checked ';?>> <label for="XI">&nbsp;</label>Kelas <?=$b;?>
  	<input type="radio" name="kelas" value="<?=$c;?>" class='pilih_soal' <?php if($kelas==$c) echo 'checked ';?>> <label for="XII">&nbsp;</label>Kelas <?=$c;?>
		<?php
		if($cekID == '1')
		{
		?>
		<input type="radio" name="kelas" value="<?=$d;?>" class='pilih_soal' <?php if($kelas==$d) echo 'checked ';?>> <label for="X">&nbsp;</label>Kelas <?=$d;?>
  	<input type="radio" name="kelas" value="<?=$e;?>" class='pilih_soal' <?php if($kelas==$e) echo 'checked ';?>> <label for="XI">&nbsp;</label>Kelas <?=$e;?>
  	<input type="radio" name="kelas" value="<?=$f;?>" class='pilih_soal' <?php if($kelas==$f) echo 'checked ';?>> <label for="XII">&nbsp;</label>Kelas <?=$f;?>
		<?php
		}
		?>
		<input type="radio" name="kelas" value="-" class='pilih_soal' <?php if($kelas=='-') echo 'checked ';?>> <label for="lainnya">&nbsp;</label>Lainnya<br>
	<select name="oleh" id="oleh" class="input2" style="clear:both;float:right;">
		<?php
		if ($_SESSION['tingkat_user']=='0') {
			$sp = "select pengguna,nama_pengguna from t_peserta where tingkat in(0,1) and pengguna not in('cbtreset') order by tingkat,nama_pengguna asc";
		}
		elseif($_SESSION['tingkat_user']=='1')
		{
			$sp = "select pengguna,nama_pengguna from t_peserta where pengguna='$pengguna' order by tingkat,nama_pengguna asc";
		}

		$rp = mysqli_query($db,$sp);
		while ($bp = mysqli_fetch_array($rp,MYSQLI_ASSOC)) {
		?>
		<option value="<?=$bp['pengguna'];?>" <?php if($bp['pengguna']==$pengguna) echo 'selected';?>> <?=$bp['nama_pengguna'];?> </option>
		<?php
		}
		?>
	</select>
	<br>
	<input type="button" value="Simpan mapel" name="save" id="btnsavemapel" class="tombol">
	<input type="button" value="Batal" class="tombol" onclick="window.location='?pg=lmapel'">
</form>
<div id="error"></div>
<?php
}
?>
