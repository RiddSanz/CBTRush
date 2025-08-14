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
$totc = 0;
$okc = 0;
$totdata = 0;
if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; };
$start_from = ($hal-1) * $jumlah_per_page;

$idmapel = $_SESSION['idmapel'];

if((isset($_SESSION['fdata']) && $_SESSION['fdata']!='') || (isset($_SESSION['fdata2']) && $_SESSION['fdata2']!='') || (isset($_SESSION['fdata3']) && $_SESSION['fdata3']!='')) {
	$crdata = $_SESSION['fdata'];
	$crdata2 = $_SESSION['fdata2'];
	$crdata3 = $_SESSION['fdata3'];
	if (!empty($crdata)) {
		$takelompok = "and a.kelompok like '%$crdata%'";
		$tbkelompok = "and b.kelompok like '%$crdata%'";
	}
	else{
		$takelompok = "";
		$tbkelompok = "";
	}

	if (!empty($crdata2) && $crdata2!='Semua Agama') {
		$taagama = "and a.agama='$crdata2'";
		$tbagama = "and b.agama='$crdata2'";
	}
	else
	{
		$taagama = "";
		$tbagama = "";
	}

	if (!empty($crdata3) && $crdata3!='0') {
		$tasesi = "and a.sesi='$crdata3'";
		$tbsesi = "and b.sesi='$crdata3'";
	}
	else
	{
		$tasesi = "";
		$tbsesi = "";
	}

	if ($crdata!='kosong' || $crdata2!='kosong' || $crdata3!='kosong') {
		$sql = "select * from t_peserta a where a.tingkat='2' $takelompok $taagama $tasesi
		union select * from t_peserta b where b.tingkat='2' $tbkelompok $tbagama $tbsesi
		ORDER BY pengguna ASC LIMIT $start_from, $jumlah_per_page ";

		$sql2 = "select * from t_peserta a where a.tingkat='2' $takelompok $taagama $tasesi
		union select * from t_peserta b where b.tingkat='2' $tbkelompok $tbagama $tbsesi
		ORDER BY pengguna ASC";
	}
	else
	{
		$sql = "select * from t_peserta a where tingkat='2' $taagama ORDER BY pengguna ASC
		LIMIT $start_from, $jumlah_per_page ";

		$sql2 = "select * from t_peserta a where tingkat='2' $taagama ORDER BY pengguna ASC";
	}
}
else{
	$crdata = '';
	$crdata2 = '';
	$crdata3 = '0';
	$sql = "select * from t_peserta where tingkat='2' ORDER BY pengguna ASC
			LIMIT $start_from, $jumlah_per_page ";
	$sql2 = "select * from t_peserta where tingkat='2' ORDER BY pengguna ASC
			";
}
//echo $sql;
$rs = mysqli_query($db,$sql);
/* menghitung halaman */
$rs2 = mysqli_query($db,$sql2);
$total_records = mysqli_num_rows($rs2);
$total_pages = ceil($total_records / $jumlah_per_page);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);

$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];

$id=mysqli_real_escape_string($db,$_SESSION['idtest']);
$sqltest = "select * from t_test where id='$id' limit 1";

$rstest = mysqli_query($db,$sqltest);
$brtest = mysqli_fetch_array($rstest,MYSQLI_ASSOC);
$kodetest = $brtest['kode_test'];
$nmtest = strtoupper($brtest['nama_test']." ".$brtest['keterangan']);
$tid = $id;

$sqlKelompok = "select distinct(kelompok) as kel from t_peserta where kelompok not in('admin','operator') order by kel asc
			 ";
$rmKel = mysqli_query($db,$sqlKelompok);
/* $bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC);*/

$list_agama  = array('Semua Agama','islam','katholik',
	'kristen','hindu','budha','khonghucu'
	,'lainnya' );

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

		$(".pilih_peserta").click(function(){
		   var pil_id = $(this).attr('id');
		   $("#preview"+pil_id).fadeIn("slow");
		   $("#preview"+pil_id).html('');
			$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
			$.post( "pwww/p-pilih-siswa.php",{ pil_id:""+pil_id, kondisi:"satu" })
			.done(function(data) {
			  if (data==1) {
			  	$("#preview"+pil_id).html('<img src="images/success.png" alt="Uploading...." width="15px"/>');
			  }else
			  {
			  	$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');
			  }
			})
			.fail(function() {
			   $("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
			})
			.always(function() {
				$("#preview"+pil_id).fadeOut(3000);
			});
		 });

		$("#pilihAll").click(function(){
			if(this.checked){
				$('.pilih_peserta').each(function() {
				this.checked = true;
				var pil_id = $(this).attr('id');
				   $("#preview"+pil_id).fadeIn("slow");
				   $("#preview"+pil_id).html('');
					$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
					$.post( "pwww/p-pilih-siswa.php",{ pil_id:""+pil_id, kondisi:"cek" })
					.done(function(data) {
					  if (data==1) {
					  	$("#preview"+pil_id).html('<img src="images/success.png" alt="Uploading...." width="15px"/>');
					  }else
					  {
						$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');
					  }
					})
					.fail(function() {
						$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
					})
					.always(function() {
						$("#preview"+pil_id).fadeOut(3000);
					});
				});
			}else{
				$('.pilih_peserta').each(function() {
					this.checked = false;
					var pil_id = $(this).attr('id');
				   $("#preview"+pil_id).fadeIn("slow");
				   $("#preview"+pil_id).html('');
					$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
					$.post( "pwww/p-pilih-siswa.php",{ pil_id:""+pil_id ,kondisi:"uncek"})
					.done(function(data) {
					  if (data==1) {
					  	$("#preview"+pil_id).html('<img src="images/success.png" alt="Uploading...." width="15px"/>');

					  }else
					  {
					  	$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');

					  }
					})
					.fail(function() {
						$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
					})
					.always(function() {
						$("#preview"+pil_id).fadeOut(3000);
					});
			});
		}
		});
		$("#setpage").click(function(){

			var jmlhal = $('#jmlhal').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-hal.php',
				data:'ajax=1&jmlhal='+jmlhal,
				success:function(data) {
					if(data){
						$("body").load("index.php?pg=menutestp").hide().fadeIn(1500).delay(6000);
					}else{

						alert(data);
					}
				}
			});
		});
		$("#findData").click(function(){

			var fdata = $('#fdata').val();
			var fdata2 = $('#fdata2').val();
			var fdata3 = $('#fdata3').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata+'&fdata2='+fdata2+'&fdata3='+fdata3,
				success:function(data) {
					if(data){
						$("body").load("index.php?pg=menutestp").hide().fadeIn(1500).delay(6000);
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
			<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
			<a href='#' onclick="window.location='?pg=ltest'">Test</a>
			<a href='#' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'">Atur Soal dan Peserta <?=$nmtest;?></a> |
			Pilih Peserta
		</div>*/?>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li><a href='#' onclick="window.location='?pg=ltest'"><?=$site3;?></a></li>
			<li><a href='#' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'"><?=$site4;?><?=strtoupper($nmtest);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site5;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class='btnback letakKanan lebartombol50' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'">
			Kembali
		</div>
		<div class='findp'>
			<?php
			/*
			?>
			<input type='text' value='<?=$crdata;?>' id='fdata' class='input2 wd50' placeholder='Filter data'>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
			<?php
			*/
			?>
			<select id="fdata"  class='pilihan'>
				<option value="">PILIH KELAS</option>
			<?php
				while ($bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC))
				{
				?>
				<option value="<?php echo $bmKel['kel'];?>" <?php if($bmKel['kel']==$crdata) echo "selected";?>><?php echo $bmKel['kel'];?></option>
				<?php
				}
			?>
			</select>
			<select name="agama" id="fdata2" class="pilihan">
			<?php
			for ($i=0; $i < count($list_agama); $i++) {
			?>
				<option value="<?=$list_agama[$i];?>" <?php if($crdata2==$list_agama[$i]) echo 'selected';?>><?=strtoupper($list_agama[$i]);?></option>
			<?php
			}
			?>
			</select>
			<select name="sesi" id="fdata3" class="pilihan">
				<option value="0" <?php if($crdata3=='0') echo 'selected';?>>SEMUA SESI</option>
				<option value="1" <?php if($crdata3=='1') echo 'selected';?>>SESI 1</option>
				<option value="2" <?php if($crdata3=='2') echo 'selected';?>>SESI 2</option>
				<option value="3" <?php if($crdata3=='3') echo 'selected';?>>SESI 3</option>
			</select>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
		</div>
		<br>
		<table width="100%">
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%">
					<center>NO</center>
				</th>
				<th width="65%">
					NAMA SISWA
				</th>
				<th>
					AGAMA
				</th>
				<th>
					KELAS
				</th>
				<th>
					RUANG
				</th>
				<th>
					SESI
				</th>
				<th width="70px">
					PILIH
				</th>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="7">
				<center>DATA PERTANYAAN MASIH KOSONG</center>
				</td>';
			}
			else
			{
				$x=$start_from+1;
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{
					$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
					$totdata++;
					$pid = $br['pid'];
				?>
					<tr bgcolor="<? echo($warna);?>">
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?php
							if (strlen(strip_tags($br['nama_pengguna']))<50) {
								$siswa = substr(strip_tags($br['nama_pengguna']), 0,50);
								echo $siswa;
							}
							else
							{
								$siswa = substr(strip_tags($br['nama_pengguna']), 0,50);
								echo $siswa.'...';
							}

							?>
						</td>
						<td><?=$br['agama'];?></td>
						<td><?=$br['kelompok'];?></td>
						<td><center><?=$br['ruang'];?></center></td>
						<td><center><?=$br['sesi'];?></center></td>
						<td>
							<?php
							$sc = "select * from t_test_peserta where id_peserta='$pid' and id_test='$tid' limit 0,1";

							$rc = mysqli_query($db,$sc);
							$tc = mysqli_num_rows($rc);
							if ($tc==1) {
								$totc++;
							}
							?>
							<input class='pilih_peserta' type="checkbox" name="lsiswa[]" id="<?=$pid;?>" value="<?=$pid;?>" <?php if($tc==1){echo "checked";}?>>
							<label for="<?=$pid;?>">&nbsp;</label><div class="checkUser" id='preview<?=$pid;?>'></div>
						</td>
					</tr>
					<?php
					$x++;
				}
			}
			?>
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%">
					&nbsp;
				</th>
				<th width="55%">
					&nbsp;
				</th>
				<th>
					&nbsp;
				</th>
				<th>
					Pilih semua
				</th>
				<th>
					&nbsp;
				</th>
				<th>
					&nbsp;
				</th>
				<th>
					<?php
						if ($totc==$totdata) {
							$okc = 1;
						}
						else
						{
							$okc = 0;
						}
					?>
					<input class='pilihsemua' type="checkbox" id="pilihAll" value='all' <?php if($okc==1) echo 'checked';?>/><label for="all">&nbsp;</label>
				</th>
			</tr>
		</table>
		<br>
		<div class='btnback letakKanan lebartombol50' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'">
			Kembali
		</div>
	</div>
<?php
/*
	if ((isset($_SESSION['fdata']) && $_SESSION['fdata']!='') || (isset($_SESSION['fdata2']) && $_SESSION['fdata2']!='') || (isset($_SESSION['fdata3']) && $_SESSION['fdata3']!='')) {
		$sql = "select * from t_peserta a where a.tingkat='2' and a.kelompok like '%$crdata%'
		union select * from t_peserta b where b.tingkat='2' and b.agama ='$crdata2'
		union select * from t_peserta c where c.tingkat='2' and c.sesi ='$crdata3'
		ORDER BY pengguna ASC";
	}
	else{
		$sql = "select * from t_peserta where tingkat='2' ORDER BY pengguna ASC";
	}

	$rs = mysqli_query($db,$sql);
	$total_records = mysqli_num_rows($rs);
	$total_pages = ceil($total_records / $jumlah_per_page);
*/
	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
	</div>";

	echo "<a href='?pg=menutestp&hal=1' class='lpg'>".'|<'."</a> ";

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
		echo "<a href='?pg=menutestp&hal=".$i."' class='$rgb'>".$i."</a> ";
	};
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=menutestp&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	}
	echo "<a href='?pg=menutestp&hal=$total_pages' class='lpg'>".'>|'."</a> ";
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>
