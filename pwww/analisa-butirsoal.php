<?php
include "lib/configuration.php";
require_once("pwww/tgl.php");
require_once("pwww/konversi-tgl.php");
$tglnow = date("Y-m-d", $newTime);
$tomorrow = date('Y-m-d',strtotime($tglnow . "+1 days"));
$ttd = "".ucwords(konversi_tanggal("j M Y",$tglnow))."";
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}

if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; };
$start_from = ($hal-1) * $jumlah_per_page;

$idmapel = $_SESSION['idmapel'];
$sktest = "select id,nama_test,keterangan from t_test where idmapel='$idmapel'";
$rktest = mysqli_query($db,$sktest);
//echo $sktest;
if((isset($_SESSION['fdata']) && $_SESSION['fdata']!='')) {
	$crdata = $_SESSION['fdata'];

	$sql = "select idsoal,isi_soal,benar,count(A) as A,count(B) as B,count(C) as C,count(D) as D,count(E) as E,count(X) as X from v_butir_extend where idtest='$crdata' group by idsoal LIMIT $start_from, $jumlah_per_page ";
	/*
	$crdata2 = $_SESSION['fdata2'];

	if ($crdata2=='kosong') {
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";

	}
	elseif($crdata=='kosong')
	{
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and a.id='$crdata2' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";

	}
	elseif($crdata2!='kosong' && $crdata!='kosong')
	{
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and a.id='$crdata2' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";

	}*/

}
else
{
	$crdata = '';
	//$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";
	$sql = "select idsoal,isi_soal,benar,count(A) as A,count(B) as B,count(C) as C,count(D) as D,count(E) as E,count(X) as X from v_butir_extend where idtest='$crdata' group by idsoal LIMIT $start_from, $jumlah_per_page ";

}
//echo $crdata;
//echo $crdata2;
//echo $sql;
$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];

/*$sqlKelompok = "select distinct(kelompok) as kel from hsl_score_akhir where idmapel='$idmapel' order by kel asc
			 ";
$rmKel = mysqli_query($db,$sqlKelompok);
 $bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC);*/


?>
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
		$("#setpage").click(function(){
			var jmlhal = $('#jmlhal').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-hal.php',
				data:'ajax=1&jmlhal='+jmlhal,
				success:function(data) {
					if(data) {
						window.location.href = "index.php?pg=analisaP";
					}else {
						alert(data);
					}
				}
			});
		});
		$("#findData").click(function(){

			var fdata = $('#fdata').val();
			var fdata2 = $('#fdata2').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata+'&fdata2='+fdata2,
				success:function(data) {
					if(data){
						location.reload();
					}else{

						alert(data);
					}
				}
			});
		});
		$("#clearData").click(function(){
			$.ajax({
				type:'GET',
				url:'pwww/p-set-cfdata.php',
				data:'ajax=1',
				success:function(data) {
					if(data){
						location.reload();
					}else{
						alert(data);
					}
				}
			});
		});
		$("#printdiv").click(function(){
			var j = $("#fdata option:selected").text();
			var ujian = prompt("Nama Ujian ?", j);
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
	            printWindow.document.write('<h2><center>ANALISA BUTIR SOAL '+ujian+'</center></h2>');
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
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
	</ul>
	<div>
		<div class='spasi'></div>
		<div id="printdiv" class="btnDownload letakKanan u12" onclick="window.location='#'">
			<img src="<?=$menucetak;?>" height="20px" align='absmiddle' class="imglink2"> Cetak Analisa
		</div>

		<?php
		/*
		?>
		<div class="btnDownload letakKanan u12" onclick="#">
			<img src="images/dw.png" height="20px" align='absmiddle' class="imglink"> Download Excel
		</div>
		<? */?>
		<div class='findp'>
			<?php
			/*
			?><input type='text' value='<?=$crdata;?>' id='fdata' class='input2 wd50' placeholder='Filter data'>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
			<?php
			*/

			?>

			<select id="fdata" class='pilihan'>
				<option value="kosong">PILIH TEST</option>
				<?php
				while ($bktest = mysqli_fetch_array($rktest,MYSQLI_ASSOC))
				{
				?>
				<option value="<?php echo $bktest['id'];?>" <?php if($bktest['id']==$crdata) echo "selected";?>><?php echo strtoupper($bktest['nama_test'])." ".strtoupper($bktest['keterangan']);?></option>
				<?php
				}
			?>
			</select>
			<input type='button' value='Proses' id='findData'>
		</div>
	</div>
	<div class="cpanel">
		<table width="100%" border='1'>
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%" rowspan="2">
					<center>NO</center>
				</th>
				<th rowspan="2">
					<center>Pertanyaan</center>
				</th>
				<th colspan='6'>
					<center>Jawaban</center>
				</th>
				<th width="5%" rowspan="2">
					<center>Benar<br>(%)</center>
				</th>
				<th width="5%" rowspan="2">
					<center>Salah<br>(%)</center>
				</th>
				<th width="5%" rowspan="2">
					<center>Total<br>(peserta)</center>
				</th>
			</tr>
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%">
					<center>A</center>
				</th>
				<th width="5%">
					<center>B</center>
				</th>
				<th width="5%">
					<center>C</center>
				</th>
				<th width="5%">
					<center>D</center>
				</th>
				<th width="5%">
					<center>E</center>
				</th>
				<th width="5%">
					<center>X</center>
				</th>

			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="11">
				<center>DATA MASIH KOSONG</center>
				</td>';
			}
			else
			{
				$x=$start_from+1;
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{
					$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
					?>
					<tr bgcolor="<? echo($warna);?>">
						<td class="isi">
							<center><?=$x;?></center>
						</td>

						<td>
							<div onclick="#">
								<?php
								/*
								if (strlen(strip_tags($br['isi_soal']))<50) {
									$soal = substr(strip_tags($br['isi_soal']), 0,50);
									echo $soal;
								}
								else
								{
									$soal = substr(strip_tags($br['isi_soal']), 0,50);
									echo $soal.'...';
								}
									*/
								echo $br['isi_soal'];
								?>
							</div>
						</td>
						<td>
							<center><?=$br['A'];?></center>
						</td>
						<td>
							<center><?=$br['B'];?></center>
						</td>
						<td>
							<center><?=$br['C'];?></center>
						</td>
						<td>
							<center><?=$br['D'];?></center>
						</td>
						<td>
							<center><?=$br['E'];?></center>
						</td>
						<td>
							<center><?=$br['X'];?></center>
						</td>
						<td>
							<?php
								$total = ($br['X']+$br['A']+$br['B']+$br['C']+$br['D']+$br['E']);
								$benar = strtoupper($br['benar']);
								$jbenar = $br[$benar];
							?>
							<center><?=number_format(($jbenar/$total)*100,2);?></center>
						</td>
						<td>
							<?php
							$salah = $total - $jbenar;
							?>
							<center><?php echo number_format(($salah/$total)*100,2);?></center>
						</td>
						<td>
							<center><?=$total;?></center>
						</td>
					</tr>
					<?php
					$x++;
				}
			}
			?>
		</table>
	</div>
<?php
	//echo $sql;
	if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
		$crdata = $_SESSION['fdata'];
		/*$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_pengguna like '%$crdata%' group by a.id,pengguna
		union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and kode_test like '%$crdata%' group by a.id,pengguna
		union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_test like '%$crdata%' group by a.id,pengguna
		union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and pengguna like '%$crdata%' group by a.id,pengguna
		";
		*/
		$sql = "select idsoal,isi_soal,count(A) as A,count(B) as B,count(C) as C,count(D) as D,count(E) as E,count(X) as X from v_butir_extend where idtest='$crdata' group by idsoal";

	}
	else
	{
		$crdata = '';
		$sql = "select idsoal,isi_soal,count(A) as A,count(B) as B,count(C) as C,count(D) as D,count(E) as E,count(X) as X from v_butir_extend where idtest='$crdata' group by idsoal";
	}
	$rs = mysqli_query($db,$sql);
	$total_records = mysqli_num_rows($rs);
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
	</div>";

	echo "<a href='?pg=analisa-butir&hal=1' class='lpg'>".'|<'."</a> ";

	if ($hal<10) {
		$aj = 1;
		if ($total_pages<=10) {
			$aki = $total_pages;
		}
		else
		{
			$aki = 10;
		}

	}
	else
	{

		if ($total_pages<($hal+9)) {
			$aj = $hal - 5;
			$aki = $hal + ($total_pages-$hal);
			/*echo $total_pages;
			echo ($hal+10);*/
		}
		else
		{
			$aj = $hal-5;
			$aki = $hal + 5;
			/*echo $aj;
			echo $aki;*/
		}


	}

	for ($i=$aj; $i<=$aki; $i++) {
		if($hal==$i)
		{
			$rgb = 'lpgw';
		}
		else
		{
			$rgb = 'lpg';
		}
		echo "<a href='?pg=analisa-butir&hal=".$i."' class='$rgb'>".$i."</a> ";
	};
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=analisa-butir&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	}
	echo "<a href='?pg=analisa-butir&hal=$total_pages' class='lpg'>".'>|'."</a> ";
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>
