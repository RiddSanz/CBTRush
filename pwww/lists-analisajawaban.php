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
if((isset($_SESSION['fdata2']) && $_SESSION['fdata2']!='' && $_SESSION['fdata2']!='kosong')) {
	$crdata = $_SESSION['fdata'];
	$crdata2 = $_SESSION['fdata2'];
	//echo $sql;

	$sqlKelompok = "select a.id_test,b.kelompok from t_test_peserta a, t_peserta b where a.id_peserta=b.pid and a.id_test='$crdata2 ' GROUP BY b.kelompok";
	$rmKel = mysqli_query($db,$sqlKelompok);

	$sqlT = "select id,waktu_test,jumlah_soal,soal_opsi,soal_esay,pembobotan from t_test where id='$crdata2'";
	$rmT = mysqli_query($db,$sqlT);
	//echo $sqlT;
	$dataTest = array();
	while($brT = mysqli_fetch_array($rmT,MYSQLI_ASSOC))
	{
		$idT = $brT['id'];
		$dataTest[$idT]['waktu'] = $brT['waktu_test'];
		$dataTest[$idT]['jumlah'] = $brT['jumlah_soal'];
		$dataTest[$idT]['opsi'] = $brT['soal_opsi'];
		$dataTest[$idT]['esay'] = $brT['soal_esay'];
		$dataTest[$idT]['bobot'] = $brT['pembobotan'];
	}

	//print_r($dataTest);
	$recdata = 0;
	if((isset($_SESSION['fdata']) && $_SESSION['fdata']!=''))
	{
		$arrPes = "select idpeserta from t_hsl_test where idtest='$crdata2' group by idtest,idpeserta";
		$rsPes = mysqli_query($db,$arrPes);
		$recdata = mysqli_num_rows($rsPes);
		$new_array = "";
		$d = 0;

		while( $row = mysqli_fetch_array($rsPes,MYSQLI_ASSOC))
		{
			if($d < ($recdata-1)){
				$new_array .= $row[idpeserta].","; // Inside while loop
			}
			else{
				$new_array .= $row[idpeserta];
			}
			$d++;
		}
		$sql = "SELECT pid,pengguna,nama_pengguna,kelompok FROM t_peserta
		where kelompok='$crdata' and pid IN ($new_array)";
	}
	else
	{
		$crdata = '';
		$crdata2 = $_SESSION['fdata2'];
	}

}
else
{
	$crdata = '';
	$crdata2 = '';
	$arrPes = "select idpeserta from t_hsl_test group by idtest,idpeserta";
	$rsPes = mysqli_query($db,$arrPes);
	while( $row = mysql_fetch_assoc($rsPes))
	{
			$new_array[] = $row; // Inside while loop
	}
	$sql = "SELECT pid,pengguna,nama_pengguna,kelompok FROM t_peserta
	where kelompok='$crdata' and pid IN ($new_array)";

}
//echo $crdata;
//echo $crdata2;
//echo $recdata;
//echo $sql;
$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];


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
.btnRefresh {
	font-family: arial;
	background-color: #ff751a;
	padding-right: 5px;
	padding-left: 5px;
	padding-top: 5px;
	padding-bottom: 5px;
	margin-bottom: 5px;
	margin-left: 5px;
	border-radius: 0px;
	color: #fff;
	cursor: pointer;
}
.btnRefresh:hover {
	background-color: green;
	color: #fff;
}
.btn-update{
	float: right;
}
.isidata {
	overflow-x: auto;
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
		$(".btn-update").click(function(){
			swal({
			  title: 'Anda Yakin Update data?',
			  text: "Data yang ada akan diperbarui dengan data baru!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ya, perbarui!'
			}).then((result) => {
			  if (result.value) {
			  	$.ajax({
					type:'GET',
					url:'pwww/p-update-kumpulan-nilai.php',
					data:'ajax=1',
					success:function(data) {
						if(data){
							swal(
						      'updated!',
						      'data sudah diperbarui.',
						      'success'
						    );
						}else{
							alert(data);
						}
					}
				});

			  }
			});
		});
	});
	</script>
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<div class="cpanel">
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
		</ul>
		<div class='spasi'></div>

		<div class='findp'>
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
				<?php
				if($crdata2!='')
				{
					?>
					<option value="kosong">PILIH KELAS</option>
					<?php
					while ($bmKel = mysqli_fetch_array($rmKel,MYSQLI_ASSOC))
					{
					?>
					<option value="<?php echo $bmKel['kelompok'];?>" <?php if($bmKel['kelompok']==$crdata) echo "selected";?>><?php echo $bmKel['kelompok'];?></option>
					<?php
					}
				}
			?>
			</select>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
		</div>
		<div class="isidata">
		<table width="100%">
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%" rowspan="2">
					<center>NO</center>
				</th>
				<th width="10%" rowspan="2">
					<center>USER</center>
				</th>
				<th rowspan="2">
					<center>NAMA SISWA</center>
				</th>
				<th width="10%" rowspan="2">
					<center>KELOMPOK</center>
				</th>
				<th colspan="<?=$dataTest[$crdata2]['jumlah'];?>">
					<center>JAWABAN</center>
				</th>
			</tr>
			<tr style='background:#ebebe0;color:#000;'>
				<?php
				for($d=0;$d<$dataTest[$crdata2]['jumlah'];$d++)
				{
					?>
					<th bgcolor='#ccccb3'>
						<center><?=$d+1;?></center>
					</th>
					<?php
				}
				?>

			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="5">
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
					<tr bgcolor="<? echo($warna);?>" >
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
							<center><?=$br['kelompok'];?></center>
						</td>
						<?php
							$pid = $br['pid'];
							$sj = "select nomor , pilihan from t_hsl_test where idtest='$crdata2' and idpeserta='$pid' order by nomor asc,tgl_submit asc";
							$rsj = mysqli_query($db,$sj);
							while($brsj = mysqli_fetch_array($rsj,MYSQLI_ASSOC))
							{
								echo "<td> <center>".strtoupper($brsj['pilihan'])."</center></td>";
							}
						?>

					</tr>
					<?php
					$x++;
				}
			}
			?>
		</table>
		</div>
	</div>
<?php
}
mysqli_close($db);
?>
