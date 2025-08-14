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
$sktest = "select id,nama_test,keterangan from t_test where idmapel='$idmapel'";
$rktest = mysqli_query($db,$sktest);
//echo $sktest;
if((isset($_SESSION['ftest']) && $_SESSION['ftest']!='') || (isset($_SESSION['fruang']) && $_SESSION['fruang']!='') || (isset($_SESSION['fkelas']) && $_SESSION['fkelas']!='')) {
	$crdata = $_SESSION['ftest'];
	$crdata2 = $_SESSION['fruang'];
	$crdata3 = $_SESSION['fkelas'];
	
	if ($crdata!='kosong') {
		//$sql = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata'";
		$sql = "SELECT b.ruang FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' group by id_test,ruang";
	
	}
	if ($crdata2!='kosong') {
		$sqldata = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2'";
	}
	if ($crdata3!='kosong') {
		$sqldata = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2' and b.kelompok='$crdata3'";
	}
	$sqlkelas = "SELECT b.kelompok FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2' group by id_test,ruang,kelompok";
	//echo $sqlkelas;
	$rskel = mysqli_query($db,$sqlkelas);
	//echo $sqldata;
}
else
{
	$crdata = '';
	$crdata2 = '';
	$crdata3 = 'kosong';
	$sql = "SELECT b.kelompok FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2' group by id_test,ruang,kelompok";
	
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
		
		$("#ftest").change(function(){
			
			var d1 = $('#ftest').val();	
			var d2 = '';	
			var d3 = '';			
			$.ajax({
				type:'GET',
				url:'pwww/p-fdh.php',
				data:'ajax=1&ftest='+d1+'&fruang='+d2+'&fkelas='+d3,
				success:function(data) {
					if(data){	
						location.reload();
					}else{ 
						 
						alert(data);
					}
				}
			});
		});
		$("#fruang").change(function(){
			
			var d1 = $('#ftest').val();	
			var d2 = $('#fruang').val();	
			var d3 = 'kosong';			
			$.ajax({
				type:'GET',
				url:'pwww/p-fdh.php',
				data:'ajax=1&ftest='+d1+'&fruang='+d2+'&fkelas='+d3,
				success:function(data) {
					if(data){	
						location.reload();
					}else{ 
						 
						alert(data);
					}
				}
			});
		});
		$("#fkelas").change(function(){
			
			var d1 = $('#ftest').val();	
			var d2 = $('#fruang').val();	
			var d3 = $('#fkelas').val();

			$.ajax({
				type:'GET',
				url:'pwww/p-fdh.php',
				data:'ajax=1&ftest='+d1+'&fruang='+d2+'&fkelas='+d3,
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
	<script src="js/iframe.print.js"></script>
	<div class="cpanel">
		<?PHP/*
		<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
		Daftar Hadir dan Berita Acara
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
		if ($crdata3!='kosong') {
		?>
		<div onclick="iPrint(theiframe);" id="dwFile" class="btnDownload letakKanan u12">
			<img src="images/printer.png" height="20px" align='absmiddle' class="imglink"> Daftar Hadir dan Berita Acara &nbsp;&nbsp;
		</div>		
		<?php
		}
		?>
		<div class='findp'>
			<select id="ftest" class='pilihan'>
				<option value="kosong">PILIH TEST</option>
				<?php
				while ($bktest = mysqli_fetch_array($rktest,MYSQLI_ASSOC)) 
				{
				?>
				<option value="<?php echo $bktest['id'];?>" <?php if($bktest['id']==$crdata) echo "selected";?>><?php echo strtoupper($bktest['nama_test']." ".$bktest['keterangan']);?></option>
				<?php
				}
			?>																		  
			</select>			
			<select id="fruang" class='pilihan'>
				<option value="kosong">PILIH RUANG</option>
			<?php
				while ($bs = mysqli_fetch_array($rs,MYSQLI_ASSOC)) 
				{
				?>
				<option value="<?php echo $bs['ruang'];?>" <?php if($bs['ruang']==$crdata2) echo "selected";?>><?php echo $bs['ruang'];?></option>
				<?php
				}
			?>																		  
			</select>
			<select id="fkelas" class='pilihan'>
				<option value="kosong">PILIH KELOMPOK </option>
			<?php				
				while ($bkel = mysqli_fetch_array($rskel,MYSQLI_ASSOC)) 
				{
				?>
				<option value="<?php echo $bkel['kelompok'];?>" <?php if($bkel['kelompok']==$crdata3) echo "selected";?>><?php echo $bkel['kelompok'];?></option>
				<?php
				}
			?>																		  
			</select>
						
		</div>
		<br><br>
		<iframe name="theiframe" src="pwww/lists-dh.php?ktest=<?=$crdata;?>&kelas=<?=$crdata2;?>" height='500px' width='100%' frameborder="0"></iframe>		
	</div>
<?php
}
mysqli_close($db);
?>

