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

$idmapel = $_SESSION['idmapel'];
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	/*$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_pengguna like '%$crdata%' group by a.id,pengguna 
	union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and kode_test like '%$crdata%' group by a.id,pengguna 
	union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_test like '%$crdata%' group by a.id,pengguna 
	union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and pengguna like '%$crdata%' group by a.id,pengguna 
	order by score desc LIMIT $start_from, $jumlah_per_page ";*/
	$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";

}
else
{
	$crdata = '';
	$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna order by score desc LIMIT $start_from, $jumlah_per_page ";
}
$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];

$sqlKelompok = "select distinct(kelompok) as kel from hsl_score_akhir where idmapel='$idmapel' order by kel asc  
			 ";
$rmKel = mysqli_query($db,$sqlKelompok);
/* $bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC);*/

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
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata,
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
		<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> | 
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a> | 
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$nm_mapel;?></a> | 
		Analisa Test
		</div>
		<div class='spasi'></div>
		<div class='findp'>
			<?php
			/*
			?><input type='text' value='<?=$crdata;?>' id='fdata' class='input2 wd50' placeholder='Filter data'>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
			<?php
			*/
			?>
			<label>Pilih Kelas : </label>
			<select id="fdata">
				<option value="kosong">------</option>
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
		</div>
		<br><br>
		<table width="100%" id="t01">
			<tr>
				<th width="5%">
					<center>NO</center>
				</th>				
				<th>
					<center>NAMA SISWA</center>
				</th>
				<th width="10%">
					<center>GROUP</center>
				</th>
				<th width="10%">
					<center>T-ID</center>
				</th>
				<th width="8%">
					<center>&Sigma;SOAL</center>
				</th>				
				<th width="3%">
					<center>B</center>
				</th>
				<th width="3%">
					<center>S</center>
				</th>
				<th width="5%">
					<center>&sum;NA
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
					?>
					<tr>
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<div class='linktest'  onclick="window.location='?pg=analisaPS&idtot=<?=$br['tid'];?>:<?=$br['pid'];?>:<?=$br['jumlah_soal'];?>:<?=$br['score'];?>'">
								<?=$br['nama_pengguna'];?>
							</div>
						</td>
						<td>
							<?=$br['kelompok'];?>
						</td>
						<td>
							<?=$br['kode_test'];?>
						</td>
						<td>
							<?=$br['jumlah_soal'];?>
						</td>
						<td>
							<?=$br['score'];?>
						</td>
						<td>
							<?=$br['jumlah_soal']-$br['score'];?>
						</td>
						<td>
							<?=number_format(($br['score']/$br['jumlah_soal'])*100,2);?>
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
	
	if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
		$crdata = $_SESSION['fdata'];
		/*$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_pengguna like '%$crdata%' group by a.id,pengguna 
		union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and kode_test like '%$crdata%' group by a.id,pengguna 
		union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and nama_test like '%$crdata%' group by a.id,pengguna 
		union select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and pengguna like '%$crdata%' group by a.id,pengguna 
		";
		*/
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna";
	
	}
	else
	{
		$crdata = '';
		$sql = "select a.id as tid,c.pid,c.pengguna,c.nama_pengguna,c.kelompok,a.idmapel,a.kode_test,a.nama_test,a.waktu_test,a.jumlah_soal,a.tgl_awal_test,a.tgl_akhir_test ,d.idsoal,e.benar , d.pilihan ,sum(if(e.benar=d.pilihan,1,0)) as score from t_test a,t_test_peserta b, t_peserta c, t_hsl_test d, t_soal e where a.id=b.id_test and b.id_peserta=c.pid and a.id=d.idtest and c.pid=d.idpeserta and d.idsoal=e.qid and a.idmapel='$idmapel' and c.kelompok='$crdata' group by a.id,pengguna";
	}
	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page);

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

