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
	if((isset($_SESSION['fdata']) && $_SESSION['fdata']!=''))
	{
		$sql = "SELECT pid,idtest,idpeserta,tnilai,benar,salah,kosong,pengguna,nama_pengguna,kelompok FROM `rekap_hasil`,t_peserta
		where idpeserta=pid and idtest='$crdata2' and kelompok='$crdata'";
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
	$sql = "SELECT pid,idtest,idpeserta,tnilai,benar,salah,kosong,pengguna,nama_pengguna,kelompok FROM `rekap_hasil`,t_peserta
	where idpeserta=pid and idtest='$crdata2' and kelompok='$crdata'";

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
		<div class="btnback3 letakKanan u12" onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'">
			<img src="images/kembali.png" height="20px" align='absmiddle' class="imglink"> Kembali
		</div>
		<?php
		if ($crdata!='' and $crdata2 !='') {
		?>
		<div id="dwFile" class="btnDownload letakKanan u12" onclick="window.location='pwww/lists-analisa-dwexcel.php'">
			<img src="images/dw.png" height="20px" align='absmiddle' class="imglink"> Download Excel
		</div>
		<div class='btn-update btnstatus2 darkbiru letakKanan'><img src="images/refresh-putih.png" width="10px"> Update Data</div>
		<?php
		}
		?>
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
				<th width="5%" rowspan="2">
					<center>BOBOT</center>
				</th>
				<th width="8%" colspan="2" bgcolor="#f5f5f0">
					<center>JUMLAH SOAL</center>
				</th>
				<th width="8%" colspan="2" bgcolor="#ebebe0">
					<center>PILIHAN</center>
				</th>
				<th width="8%" colspan="2" bgcolor="#d7d7c1">
					<center>POIN</center>
				</th>
				<th width="5%" rowspan="2" bgcolor='#c0c0a5'>
					<center>NA (PP+PU)</center>
				</th>
			</tr>
			<tr style='background:#ebebe0;color:#000;'>
				<th width="8%" bgcolor='#ccccb3'>
					<center>Pilihan</center>
				</th>
				<th width="8%">
					<center>Uraian</center>
				</th>
				<th width="8%" bgcolor='#ccccb3'>
					<center>Benar</center>
				</th>
				<th width="8%">
					<center>Salah</center>
				</th>
				<th width="8%" bgcolor='#ccccb3'>
					<center>Pilihan</center>
				</th>
				<th width="8%" bgcolor="#f5f5f0">
					<center>Uraian</center>
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
					<tr bgcolor="<? echo($warna);?>"  onclick="window.location='?pg=analisaPS&idtot=<?=$crdata2;?>:<?=$br['pid'];?>:<?=$dataTest[$crdata2]['jumlah'];?>:<?=$br['tnilai'];?>'">
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
						<td>
							<?php
							if($dataTest[$crdata2]['bobot']=='1')
							{
								echo "<center>Y</center>";
							}
							else{
								echo "<center>N</center>";
							}
							?>
						</td>
						<td>
							<center><?=$dataTest[$crdata2]['opsi'];?></center>
						</td>
						<td>
							<center><?=$dataTest[$crdata2]['esay'];?></center>
						</td>
						<td>
							<center>
								<?php
								if($dataTest[$crdata2]['bobot']=='1'){
									echo $br['benar'];
								}
								else{
									echo ($dataTest[$crdata2]['opsi']-($br['kosong'] - $dataTest[$crdata2]['esay']));
								}

								?>
							</center>
						</td>
						<td>
							<center>
								<?php
								if($dataTest[$crdata2]['bobot']=='1'){
									echo $br['salah'];
								}
								else{
									echo $br['kosong'] - $dataTest[$crdata2]['esay'];
								}

								?>
							</center>
						</td>
						<td>
							<center>
								<?php
									if($dataTest[$crdata2]['esay']==0)
									{
										echo number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
										$nilaiakhir = number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
									}
									else
									{
										//echo $br['tnilai'];
										//$nilaiakhir = $br['tnilai'];
										echo number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
										$nilaiakhir = number_format((($br['tnilai']/$dataTest[$crdata2]['opsi'])*100),2);
									}
								?>
							</center>
						</td>
						<td>
							<center>0</center>
						</td>
						<td>
							<center><?=$nilaiakhir;?></center>
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
}
mysqli_close($db);
?>
