<script src="js/jquery.min.js"></script>
<script>
window.onload = function(){
	$("#btnsave").click(function()
	{
		var sid=$("#sid").val();
		var sekolah=$("#sekolah").val();
		var fedit=$("#fedit").val();
		
		var dataString = 'sid='+sid+'&sekolah='+sekolah+'&fedit='+fedit;
		if($.trim(sid).length>0 && $.trim(sekolah).length>0)
		{
			$.ajax({
				type: "POST",
				url: "pwww/p-addsekolah.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnsave").val('Waiting to save...');},
				success: function(data){
					if(data=="1")
					{
						$("body").load("index.php?pg=lsekolah").hide().fadeIn(1500).delay(6000);
						
					}
					else if(data=="2")
					{
						
						$("#btnsave").val('Simpan Sekolah');
						$("#error").html("<span style='color:#cc0000'>Proses penyimpanan gagal!!!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					
				}
			});

		}
		return false;
	});

}
</script>
<?php 
if (isset($_GET['s'])) {
	include "lib/configuration.php";
	$sql = "select * from t_sekolah where sid='".$_GET['s']."' limit 0,1";
	
	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$sid = $br['sid'];
	$nms = $br['nama_sekolah'];
}
else{
	$sid = "";
	$nms = "";
}

?>
<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> | 
		<a href='#' onclick="window.location='?pg=lsekolah'">SEKOLAH TEST CBT</a> | 
		Tambah sekolah
</div>
<div class='spasi'></div>
<form method="POST">
	<input type="hidden" name="fedit" value="<?=$sid;?>" id="fedit">
	<label>KODE SEKOLAH (SID)</label><br>
	<input type="text" name="sid" value="<?=$sid;?>" id="sid" placeholder="Sekolah ID" class="input2 wd25" <?php if(!empty($br['sid'])) echo "readonly='yes'";?>><br>
	<label>Nama SEKOLAH</label><br>
	<input type="text" name="sekolah" value="<?=$nms;?>" id="sekolah" placeholder="Nama sekolah" class="input2 wd50"><br>
	<input type="submit" value="Simpan Sekolah" name="save" id="btnsave"> 
	<input type="button" value="Batal" class="tombol" onclick="window.location='?pg=lsekolah'">
</form>
<div id="error"></div>