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
	if (!isset($_SESSION['idmapel'])) {
		echo "<meta http-equiv='refresh' content='0;url=?pg=lsubmapel'>";
	}

	$idt = mysqli_real_escape_string($db,$_GET['idtot']);
	list($tid,$pid,$jml,$ok) = explode(":", $idt);

	$idmapel = $_SESSION['idmapel'];
	$smapel = "select * from t_mapel where mid='$idmapel' limit 1";
	$rmapel = mysqli_query($db,$smapel);
	$bmapel = mysqli_fetch_array($rmapel,MYSQLI_ASSOC);
	$nm_mapel = $bmapel['nama_mapel'];
	$ket_mapel = $bmapel['ket_mapel'];
	$kelas = $bmapel['kelas'];

	$sql = "select pengguna,nama_pengguna,soal_test,nama_test,kode_test,keterangan from t_test_peserta a, t_peserta b,t_test c where a.id_peserta=b.pid and id_test=id and id_test='$tid' and id_peserta='$pid' limit 1";
	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	/*print_r(unserialize($br['soal_test']));*/
	$totalSoal = count(unserialize($br['soal_test']));
	/*echo $totalSoal;*/


?>
<style type="text/css">
.nilai {
	color: #000000;
	font-size: 10px;
	float: right;
	background: #ebebe0;
	padding: 5px;
}
.nilai2 {
	color: #fff;
	font-size: 10px;
	float: right;
	background: green;
	padding: 5px;
}
.nilai3 {
	color: #fff;
	font-size: 10px;
	float: right;
	background: orange;
	padding: 5px;
}
.judul {
	clear: both;
	color: #000;
	font-size: 16px;
	background: #ebebe0;
	padding: 5px;
	border: 1px gray solid;
}
.alus {
	border: 0px gray solid;
	width: 10px;
	margin: 0;
	font-size: 10.5px;
}
label{
	padding: 0;
	margin: 0;
}
</style>
<script src="js/jquery.min.js"></script>
<script>
$(document).keypress(function(e) {
    if(e.which == 13) {
        $("#btnclone").show();
    }
});
$(document).ready(function(){
	//function myFunction(pointlama,tid,val) {
	$("#btnclone").hide();
	$('.alus').change(function(e)
	{
		e.preventDefault();
		var mp = $(this).attr('id');
		var id = mp.split(",");
		var val = $(this).val();
		var pointlama = id[0];
		var tid = id[1];
		//alert("The input value has changed. The new value is: " + pointlama);
	    var plus;
	    var kirim = tid+val;
	    //alert("The input value has changed. The new value is: " + kirim);
	    var a = parseInt(val);
	    var pointtotal = parseInt(<?php echo $ok;?>);
	    var c = String(<?php echo $tid;?>);
	    var d = String(<?php echo $pid;?>);
	    var e = String(<?php echo $jml;?>);
	    var link = c+":"+d+":"+e+":";
	    $.ajax({
			type:'GET',
			url:'pwww/p-update-nesay.php',
			data:'ajax=1&tid='+kirim,
			success:function(data) {
				if(data){

					//alert(data);
					if (a < pointlama) {
						plus = pointlama - a;
						pointtotal = pointtotal - plus;
					}
					else
					{
						plus = a - pointlama;
						pointtotal = pointtotal + plus;
					}

					link = link + "" + pointtotal;
					//$("body").load("index.php?pg=analisaPS&idtot="+link).hide().fadeIn(1500).delay(6000);
					window.location.href = 'index.php?pg=analisaPS&idtot='+link;
					//window.location.reload();
					//alert(link);
				}else{
					alert(data);
				}
				//alert(data);
			}
		});
	});
	$("#printdiv").click(function(){
		var divContents = $(".cpanel").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>DIV Contents</title>');
            printWindow.document.write('<style type="text/css">.nilai{color:#000;font-size:10px;float:right;background:#ebebe0;padding:5px;margin-top:-30px;}.nilai2,.nilai3{color:#fff;font-size:10px;float:right;padding:5px}.nilai2{background:green;margin-top:-30px;}.nilai3{background:orange;margin-top:-30px;margin-right:30px;}.judul{clear:both;color:#000;font-size:16px;background:#ebebe0;padding:5px;border:1px solid gray}.alus{border:0 solid gray;width:30px;margin:0;margin-top:-30px;font-size:10.5px}label{padding:0;margin:0}</style>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
	});
	$("#btnclone").click(function(){
		var hslclone = $('#dthasilclone').val();
		var idtest = $('#idtestclone').val();
		var idsoals = $('#idsoalclone').val();
		var idpengguna = prompt("Masukkan id pengguna : ?","");
		$.ajax({
			   type: 'POST',
				 url:'pwww/p-clonenilai.php',
				 data:'ajax=1&hslclone='+hslclone+'&idtest='+idtest+'&idsoals='+idsoals+'&idpengguna='+idpengguna,
				 success: function(msg){
			    	if(msg=='3' || msg=='2'){
							alert("Cloning gagal");
						}
						//alert(msg);
			  }
     });

	});
});
</script>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li><a href='#' onclick="window.location='?pg=analisaP'"><?=$site3;?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site4;?></a></li>
</ul>
<div class='spasi'></div>
<div id="printdiv" class="btnDownload letakKanan u12">
	<img src="<?=$menucetak;?>" height="20px" align='absmiddle' class="imglink2"> Cetak Analisa
</div>
<div id="btnclone" class="btnadd letakKanan u12">
	 <img src="<?=$menuduplicate;?>" height="20px" align='absmiddle' class="imglink2">Clone Nilai
</div>
<div class="cpanel">
	<div class='judul'>
	<h5 style="margin-bottom:0px;padding-left:15px;">HISTORY TEST</h5>
	<h4 style="margin-bottom:0px;margin-top:0px;padding-left:15px;"><?=$br['nama_pengguna'];?></h4>
	<h5 style="margin-bottom:0px;margin-top:0px;padding-left:15px;">NAMA TEST : <?=strtoupper($br['nama_test']." ".$br['keterangan']);?></h5>
	<div style="clear:both;float:right;margin-top:-50px;">JUMLAH SOAL : <?=$jml;?><br>POINT : <?=$ok;?></div>
	</div>
	<div class='spasi'></div>
	<?php
		$charB = array('a'=>0,'b'=>1,'c'=>2,'d'=>3,'e'=>4);
		$dataS = unserialize($br['soal_test']);
		for ($i=0; $i < $totalSoal; $i++) {
			$qid = $dataS[$i];
			$s = "select isi_soal,pilihan1,pilihan2,pilihan3,pilihan4,pilihan5,benar,opsi_esay,point_soal from t_soal where qid='$qid' limit 1";
			$r = mysqli_query($db,$s);
			$b = mysqli_fetch_array($r,MYSQLI_ASSOC);
			$benar = $b['benar'];
			$opsi_esay = $b['opsi_esay'];
			$s2 = "select pilihan,nilai from t_hsl_test where idsoal='$qid' and idtest='$tid' and idpeserta='$pid' limit 1";
			$r2 = mysqli_query($db,$s2);
			$b2 = mysqli_fetch_array($r2,MYSQLI_ASSOC);
			$tb2 = mysqli_num_rows($r2);
			$pil = $b2['pilihan'];

			/* fungsi clone hasil nilai*/
			$dataclone[$i] = $qid."-".$pil."-".$b2['nilai'];

		?>
			<div style="padding-left:15px;"><b>SOAL <?=$i+1;?></b> (<i><?=$b['point_soal'];?> point</i>)</div>
			<div style="padding-left:15px;"><?=$b['isi_soal'];?></div>
			<div style="padding-left:15px;">
				<?php
				if ($opsi_esay=='0') {
				?>
				<ol type="A">
				<?php
					for ($j=0; $j < 5; $j++) {
						if ($tb2==0 || $pil=='') {
							$warna = "#ffbe00";
						}
						else
						{
							if ($j==$charB[$benar]) {
								$warna = "#0072C6";
							}
							else
							{
								if ($pil=='x') {
									$warna = "#ffbe00";
								}
								else
								{
									if ($j==$charB[$pil]) {
										$warna = "#FF0000";
									}
									else
									{
										$warna = "#000";
									}
								}
							}
						}

						if ($b['pilihan'.($j+1)]!='') {
							echo "<li><font color='$warna'>".$b['pilihan'.($j+1)]."</font></li>";
						}
					}
				?>
				</ol>
				<?php
				}
				else
				{
					echo "Jawab:<br>".$pil;
				}
				?>
			</div>
			<?php
			if ($b2['nilai']>0) {
				$css = 'nilai2';
			}
			else
			{
				$css = 'nilai';
			}
			?>
			<?php
			if ($opsi_esay==0) {
				?>
				<div class='<?=$css;?>'>Score : <?=$b2['nilai'];?></div>
				<?php
			}
			else
			{
				$nubah = "$tid:$pid:$qid:";
				$pointlama = $b2['nilai'];
				?>
				<input type="text" class="<?=$css;?> alus" value="<?=$b2['nilai'];?>" id="<?=$pointlama;?>,<?=$nubah;?>">
				<label class="nilai3">Score :</label>
				<?php
			}
			?>
			<div class='spasi'></div>
			<hr>
		<?php
		}
		$serialized_data = serialize($dataclone);
	?>
<input type='hidden' id='dthasilclone' value='<?=$serialized_data;?>'>
<input type='hidden' id='idtestclone' value='<?=$tid;?>'>
<input type='hidden' id='idsoalclone' value='<?=$br["soal_test"];?>'>
</div>
<div class='spUpload' id='preview'>
</div>
<?php

}
?>
