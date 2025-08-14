<?php
include "lib/configuration.php";
require_once("pwww/tgl.php");
require_once("pwww/konversi-tgl.php");
$tglnow = date("Y-m-d", $newTime);
$tomorrow = date('Y-m-d',strtotime($tglnow . "+1 days"));
$ttd = "".ucwords(konversi_tanggal("j M Y",$tglnow))."";
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if(isset($_SESSION['fdata']) && !empty($_SESSION['fdata'])) {
		$crdata = $_SESSION['fdata'];
		$crdata2 = $_SESSION['fdata2'];
	}
	else
	{
		$crdata = $tglnow ;
		$crdata2 = $tomorrow;
	}
	?>
	<link rel="stylesheet" href="jquery-ui.css">
	  <script src="js/jquery-1.10.2.js"></script>
	  <script src="js/jquery-ui.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$( "#fdata2" ).datepicker({ dateFormat: 'yy-mm-dd'});
		$( "#fdata" ).datepicker({ dateFormat: 'yy-mm-dd'});
		$("#findData").click(function(){
			var fdata = $('#fdata').val();
			var fdata2 = $('#fdata2').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata+'&fdata2='+fdata2,
				success:function(data) {
					if(data){
						window.location="?pg=jadwalu";
					}else{
						alert(data);
					}
				}
			});
		});
		$("#printdiv").click(function(){
			var ujian = prompt("Tuliskan Jenis Ujian yang sedang dilakukan ?", "UAS");
			var th = '<?php echo $thnNew;?>';
			var tahun = prompt("Tahun pelajaran ?", th);
    		var sekolah = '<?php echo $sekNm;?>';
    		var ttd = '<?php echo $ttd;?>';
    		var tglabsah = prompt("Tahun pelajaran ?", ttd);
			var divContents = $(".cpanel").html();
	            var printWindow = window.open('', '', 'height=400,width=800');
	            printWindow.document.write('<html><head><title>DIV Contents</title>');
	            printWindow.document.write('<style type="text/css">h2{padding:0;margin:0;}table{width:100%;border:1px solid #e1e1d0}table,td,th{border-collapse:collapse}td,th{text-align:left;font-size:11px;padding:10px}</style>');
	            printWindow.document.write('</head><body >');
	            printWindow.document.write('<h2><center>JADWAL '+ujian+'</center></h2>');
	            printWindow.document.write('<h2><center>'+sekolah+'</center></h2>');
	            printWindow.document.write('<h2><center>TAHUN PELAJARAN '+tahun+'</center></h2><br>');
	            printWindow.document.write(divContents);
	            printWindow.document.write('<br><i>Tanggal dicetak : '+tglabsah+'</i>');
	            printWindow.document.write('</body></html>');
	            printWindow.document.close();
	            printWindow.print();
		});
	});
	</script>

	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
	<h1>JADWAL UJIAN </h1>
	<div>
		<div id="printdiv" class="btnDownload letakKanan u12" onclick="window.location='#'">
			<img src="<?=$menucetak;?>" height="20px" align='absmiddle' class="imglink2"> Cetak Jadwal
		</div>
		<div class='findp'>
			<input type='text' value='<?=$crdata;?>' id='fdata' class='style-1' placeholder='Filter data'>
			<span style="float:left;padding-left:5px;padding-right:5px;"> - </span>
			<input type='text' value='<?=$crdata2;?>' id='fdata2' class='style-1' placeholder='Filter data'>
			<input type='button' value='Cari' id='findData'>
		</div>
	</div>
	<div class="cpanel">
	<?php
	$xdata=1;
	$warna = "#f5f5f0";
	echo "
	<table border='1'>
	<tr style='background:#ebebe0;color:#000;' id='myRow'>
    	<th width='5%'><center>NO</center></th>
    	<th width='5%'><center>KELAS</center></th>
    	<th><center>MATA PELAJARAN</center></th>
    	";
    	//<th width='10%'><center>TEST</center></th>
    	echo "<th width='10%'><center>HARI</center></th>
    	<th width='20%'><center>TANGGAL</center></th>
    	<th width='20%'><center>PUKUL</center></th>
    	";
    	//<th width='5%'><center>WAKTU</center></th>
    	//<th width='5%'><center>PESERTA</center></th>
    	//<th width='5%'><center>SOAL</center></th>
  	echo "</tr>";
	$sql = "select nama_mapel,ket_mapel,kode_test,nama_test,keterangan,tgl_awal_test as tgla,
	tgl_akhir_test as tglb,waktu_test,jumlah_soal,jumlah_peserta,kelas from t_mapel a,
	t_test b where a.mid=b.idmapel and tgl_awal_test between '$crdata' and '$crdata2' order by tgl_awal_test,nama_mapel asc";
	$_SESSION['mapelnya']='';
	$rs = mysqli_query($db,$sql);
	$xdata=1;

	while ( $br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
	{
		$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
		?>
		<tr bgcolor="<? echo($warna);?>" class='pilihujian'>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="20px">
	    		<center><?=$xdata;?></center>
	    	</td>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;">
	    		<center><?=strtoupper($br['kelas']);?></center>
	    	</td>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;">
	    		<?=ucwords(strtoupper($br['ket_mapel']));?>
	    	</td>
	    	<?php /*?>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="150px">
	    		<center><?=ucwords(strtoupper($br['nama_test']." ".$br['keterangan']));?></center>
	    	</td>
	    	*/ ?>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="80px">
	    		<center><?=ucwords(strtoupper(konversi_tanggal("D",$br['tgla'])));?></center>
	    	</td>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
	    		<center>
	    			<?=ucwords(strtoupper(konversi_tanggal("j M Y",$br['tgla'])));?>
	    		</center>
	    	</td>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px"><center>
	    		<?php echo konversi_tanggal("H:i:s",$br['tgla']); /*?>
					-
					<?php echo konversi_tanggal("H:i:s",$br['tglb']); */?>
	    		</center>
	    	</td>
	    	<?php /*?>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
	    		<center><?=$br['waktu_test'];?></center>
	    	</td>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
	    		<center><?=$br['jumlah_peserta'];?></center>
	    	</td>
	    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
	    		<center><?=$br['jumlah_soal'];?></center>
	    	</td>
	    	<?php */ ?>
  		</tr>
		<?php
		$xdata=$xdata+1;
	}
	echo "</table>";
	?>

</div>
<?php
}
mysqli_close($db);
?>
