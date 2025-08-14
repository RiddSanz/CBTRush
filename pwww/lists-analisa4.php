<?php
include "lib/configuration.php";

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
$total_pages = 1;
$idmapel = $_SESSION['idmapel'];
$sktest = "select id,nama_test,keterangan from t_test where idmapel='$idmapel'";
$rktest = mysqli_query($db,$sktest);
//echo $sktest;
if((isset($_SESSION['fdata']) && $_SESSION['fdata']!='') && (isset($_SESSION['fdata2']) && $_SESSION['fdata2']!='')) {
	$crdata = $_SESSION['fdata'];
	$crdata2 = $_SESSION['fdata2'];


	if($crdata=='kosong')
	{
		/*$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,
		a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,sum(d.nilai) as score,
		sum(e.point_soal) as tpoint from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e
		where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid
		and a.idmapel='$idmapel' and a.id='$crdata2' group by a.id,pengguna
		order by score desc LIMIT $start_from, $jumlah_per_page ";*/

		$tidtest = "and idtest='$crdata2'";
		$tkelas = "";

	}
	else
	{
		/*$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,
		a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,sum(d.nilai) as score,sum(e.point_soal) as tpoint
		from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid
		and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and a.id='$crdata2'
		and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";*/

		$tidtest = "and idtest='$crdata2'";
		$tkelas = " and kelompok='$crdata'";

	}
	$sql = "select idtest as tid,pid,pengguna,nama_pengguna,kelompok,idmapel,kode_test,nama_test,waktu_test,
	jumlah_soal,tgl_awal_test,tgl_akhir_test,score,tot_soal as tpoint from hsl_score_akhir where idmapel='$idmapel'
	$tidtest $tkelas order by pengguna,kelompok asc limit $start_from, $jumlah_per_page";

	$sql2 = "select idtest as tid,pid,pengguna,nama_pengguna,kelompok,idmapel,kode_test,nama_test,waktu_test,
	jumlah_soal,tgl_awal_test,tgl_akhir_test,score,tot_soal as tpoint from hsl_score_akhir where idmapel='$idmapel'
	and $tidtest $tkelas order by pengguna,kelompok asc ";

	$rs2 = mysqli_query($db,$sql2);
	$total_records = mysqli_num_rows($rs2);
	$total_pages = ceil($total_records / $jumlah_per_page);
	//echo $sql;
}
else
{
	$crdata = '';
	$crdata2 = '';
	/*$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,
	a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,sum(d.nilai) as score,
	sum(e.point_soal) as tpoint from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e
	where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid
	and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna
	order by score desc LIMIT $start_from, $jumlah_per_page ";*/
	$sql = "select idtest as tid,pid,pengguna,nama_pengguna,kelompok,idmapel,kode_test,nama_test,waktu_test,jumlah_soal,
	tgl_awal_test,tgl_akhir_test,score,tot_soal as tpoint from hsl_score_akhir where idmapel='$idmapel' and idtest='$crdata'
	order by pengguna,kelompok asc limit $start_from, $jumlah_per_page";
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

$sqlKelompok = "select distinct(kelompok) as kel from hsl_score_akhir where idmapel='$idmapel' order by kel asc
			 ";
$rmKel = mysqli_query($db,$sqlKelompok);
/* $bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC);*/

$warna = "#f5f5f0";
?>
<style>
table {
	width: 100%;
}
table, th, td {
    border: 0px solid black;
}
tr:hover {
	background: #CDEDF6;
	cursor: pointer;
}
</style>
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
	});
	</script>
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<div class="cpanel">
		<?PHP/*
		<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> |
		Hasil dan Analisa Test
		</div>*/?>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class="btnback3 letakKanan u12" onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'">
			<img src="images/kembali.png" height="20px" align='absmiddle' class="imglink"> Kembali
		</div>
		<?php
		if ($crdata!='' and $crdata2 !='') {
		?>
		<div id="dwFile" class="btnDownload letakKanan u12" onclick="window.location='pwww/lists-analisa-dwexcel.php'">
			<img src="images/dw.png" height="20px" align='absmiddle' class="imglink"> Download Excel
		</div>
		<?php
		}
		?>
		<div class='findp'>
			<?php
			/*
			?><input type='text' value='<?=$crdata;?>' id='fdata' class='input2 wd50' placeholder='Filter data'>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
			<?php
			*/

			?>

			<select id="fdata2" class='pilihan'>
				<option value="kosong">PILIH TEST</option>
				<?php
				while ($bktest = mysqli_fetch_array($rktest,MYSQLI_ASSOC))
				{
				?>
				<option value="<?php echo $bktest['id'];?>" <?php if($bktest['id']==$crdata2) echo "selected";?>><?php echo strtoupper($bktest['nama_test']." ".$bktest['keterangan']);?></option>
				<?php
				}
			?>
			</select>
			<select id="fdata" class='pilihan'>
				<option value="kosong">PILIH KELAS</option>
			<?php
				while ($bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC))
				{
				?>
				<option value="<?php echo $bmKel['kel'];?>" <?php if($bmKel['kel']==$crdata) echo "selected";?>><?php echo $bmKel['kel'];?></option>
				<?php
				}
			?>
			</select>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
		</div>

		<table width="100%">
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%">
					<center>NO</center>
				</th>
				<th width="10%">
					<center>USER</center>
				</th>
				<th>
					<center>NAMA SISWA</center>
				</th>
				<th width="10%">
					<center>KELOMPOK</center>
				</th>
				<th width="8%">
					<center>JUMLAH SOAL</center>
				</th>
				<th width="8%">
					<center>TOTAL POIN (TP)</center>
				</th>
				<th width="8%">
					<center>POIN PESERTA (PP)</center>
				</th>
				<th width="5%">
					<center>NA (PP/TP)
				</th>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="8">
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
					<tr bgcolor="<? echo($warna);?>"  onclick="window.location='?pg=analisaPS&idtot=<?=$br['tid'];?>:<?=$br['pid'];?>:<?=$br['jumlah_soal'];?>:<?=$br['score'];?>'">
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?=$br['pengguna'];?>
						</td>
						<td>
							<?=$br['nama_pengguna'];?>
						</td>
						<td>
							<?=$br['kelompok'];?>
						</td>
						<td>
							<center><?=$br['jumlah_soal'];?></center>
						</td>
						<td>
							<center><?=$br['tpoint'];?></center>
						</td>
						<td>
							<center><?=$br['score'];?></center>
						</td>
						<td>
							<center><?=number_format(($br['score']/$br['tpoint'])*100,2);?></center>
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
	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
	</div>";

	echo "<a href='?pg=analisaP&hal=1' class='lpg'>".'|<'."</a> ";

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
		echo "<a href='?pg=analisaP&hal=".$i."' class='$rgb'>".$i."</a> ";
	};
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=analisaP&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	}
	echo "<a href='?pg=analisaP&hal=$total_pages' class='lpg'>".'>|'."</a> ";
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>
