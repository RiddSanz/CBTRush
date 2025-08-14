<?php
include("lib/configuration.php");
include "pwww/tgl.php";
include "pwww/akronim.php";
$tglnow = date("Y-m-d", $newTime);
$judultombol = 'Cari';

$datates = array();
$idtes_array = '';
$totalTest = 0;
if(isset($_SESSION['fdata2']) && !empty($_SESSION['fdata2'])) {
	$crdata2 = $_SESSION['fdata2'];
	$sqlTest = "select DISTINCT(a.id_test) as idtest FROM `t_test_peserta` a,t_peserta b WHERE a.id_peserta=b.pid and b.kelompok='".$crdata2."' order by a.id_test asc";
	##echo $sqlTest;
	$rsTest = mysqli_query($db,$sqlTest);
	while($brtest = mysqli_fetch_array($rsTest,MYSQLI_ASSOC))
	{
		$datates[] = $brtest['idtest'];
	}
	$idtes_array = join("','",$datates);
	$totalTest = mysqli_num_rows($rsTest);
}
else
{
	$crdata2 = '-' ;
}

## ambil kelas yang ikut ujian ###
$sql3 = "select DISTINCT(b.kelompok) as kelas FROM `t_test_peserta` a,t_peserta b WHERE a.id_peserta=b.pid order by b.kelompok asc";
$rs3 = mysqli_query($db,$sql3);


## ambil nama peserta dan simpan di array ###
$sql4 = "select pid,pengguna,nama_pengguna from t_peserta where kelompok = '".$crdata2."' order by pid asc";
##echo $sql4;
$rs4 = mysqli_query($db,$sql4);
$datapes = array();
$pid = array();
$pid_array = '';
$pengguna = array();
$nmpengguna = array();
while($br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC))
{
	$pid[] = $br4['pid'];
	$pengguna[] = $br4['pengguna'];
	$nmpengguna[] = $br4['nama_pengguna'];
}
$pid_array = join("','",$pid);
##echo $pid_array;
$sqlHasil = "select a.*,b.soal_opsi from rekap_hasil a,t_test b where a.idtest=b.id and idpeserta IN ('$pid_array')";
$rsHasil = mysqli_query($db,$sqlHasil);
while($br4 = mysqli_fetch_array($rsHasil,MYSQLI_ASSOC))
{
	$id = $br4['idpeserta'];
	$idt = $br4['idtest'];
	$nilai[$id][$idt] = number_format(($br4['tnilai']/$br4['soal_opsi'])*100,2);
}
##print_r($nilai);

$s = "select a.id,a.nama_test,a.keterangan,b.ket_mapel,b.kelas from t_test a,t_mapel b where a.idmapel=b.mid and a.id IN('$idtes_array') order by a.id";

$rsKet = mysqli_query($db,$s);
$idnya = array();
$jenisnya = array();
$ujiannya = array();
$mapelnya = array();
$kelasnya = array();
$akronimnya = array();
$nmakronimnya = array();
while($brKet = mysqli_fetch_array($rsKet,MYSQLI_ASSOC))
{
	$idnya[] = $brKet['id'];
	$jenisnya[] = $brKet['nama_test'];
	$ujiannya[] = $brKet['keterangan'];
	$mapelnya[] = $brKet['ket_mapel'];
	$kelasnya[] = $brKet['kelas'];
	//$akronimnya[] = preg_replace('~\b(\w)|.~', '$1', $brKet['ket_mapel'])."_".$brKet['id'];
	//$nmakronimnya[$brKet['id']] = preg_replace('~\b(\w)|.~', '$1', $brKet['ket_mapel'])."_".$brKet['id'];
	$akronimnya[] = acronym($brKet['ket_mapel'])." (".$brKet['id'].")";
	$nmakronimnya[$brKet['id']] = acronym($brKet['ket_mapel'])." (".$brKet['id'].")";
}

?>
<link rel="stylesheet" href="jquery-ui.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui.js"></script>
<script>
$(document).ready(function(){
	$( "#fdata" ).datepicker({ dateFormat: 'yy-mm-dd'});
	$("body").on( "click", "#findData", function (e){
			var fdata = $('#fdata').val();
			var fdata2 = $('#fdata2').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata+'&fdata2='+fdata2,
				success:function(data) {
					if(data){
						window.location="?pg=kumpulanNilai";
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
<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
  function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
  }
</script>
<style type="text/css">
.cari_select {
	font-size: 15px;
	width: auto;
}
.fullscreen{
	height: calc(100vh - 180px);
}
.btn-update{
	float: right;
}
.btn-download{
	float: right;
}
.btn-cetak-ket{
	float: right;
}
.fullauto{
	height: auto;
	overflow-x: scroll;
	zoom: 80%;
}
</style>
<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=awal'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
</ul>
<?php
if(count($pengguna)==0){
	$cl = 'fullscreen';
}
else{
	$cl = 'fullauto';
}

?>
<div id="printableArea2" class="<?=$cl;?>">
	<h1>REKAP HASIL UJIAN (soal pilihan)</h1>
	<div class='btn-update btnstatus2 darkbiru'><img src="images/refresh-putih.png" width="10px"> Update Data</div>
	<?php
	if($totalTest>0)
	{
	?>
	<div class='btn-download btnstatus2 hijaulumut2' onclick="window.location='pwww/kumpulan-nilai-excel.php?kelas=<?=$crdata2;?>'"><img src="images/download-excel.png" width="10px"> Download Data</div>
	<div class='btn-cetak-ket btnstatus2 orange' onclick="printDiv('printableArea')"><img src="images/printer.svg" width="10px"> Cetak Keterangan</div>
	<div class='btn-cetak-ket btnstatus2 hijau' onclick="printDiv('printableArea2')"><img src="images/printer.svg" width="10px"> Cetak Nilai</div>
	<?php
	}
	?>
	<div>
		<div class='findp'>
			<select class="style-1 cari_select" id="fdata2">
			    <option value='-' <?php if($crdata2=='-') echo 'selected';?>> --- Pilih Kelas --- </option>
			    <?php
			    while($br3 = mysqli_fetch_array($rs3,MYSQLI_ASSOC))
			    {
			    	?>
				    <option value="<?=$br3['kelas'];?>" <?php if($crdata2==$br3['kelas']) echo 'selected';?>><?=$br3['kelas'];?></option>
				    <?php
			    }
			    ?>
			</select>
			<input type='button' value='<?=$judultombol;?>' id='findData'>
		</div>

	</div>
	<?php
	$xdata=1;
	$warna = "#f5f5f0";
	echo "
	<table border='1' width='100%'>
	<tr style='background:#ebebe0;color:#000;'>
    	<th rowspan='2'>NO PESERTA</th>
    	<th rowspan='2' width='25%'>NAMA PESERTA</th>
    	<th colspan='".$totalTest."' style='text-align:center'>KODE UJIAN</th>
    </tr>";
    echo "<tr style='background:#ebebe0;color:#000;'>";
    for($i=0;$i<$totalTest;$i++)
    {
    	echo "<th style='text-align:center'>".$nmakronimnya[$datates[$i]]."</th>";
    }
  	echo "</tr>";
  	for($j=0;$j<count($pengguna);$j++)
  	{
  		echo "<tr>";
  		echo "<td>".$pengguna[$j]."</td>";
  		echo "<td>".$nmpengguna[$j]."</td>";
  		for($i=0;$i<$totalTest;$i++)
	    {
	    	echo "<td style='text-align:center;'>".$nilai[$pid[$j]][$datates[$i]]."</td>";
	    }
	    echo "</tr>";
  	}
  	echo "</table>";
  	?>
	<div class="spasi"></div>
	<div class="spasi"></div>
</div>
<?php
if($totalTest>0)
{
?>
<div id="printableArea">
	<?php
	echo "<h1>Keterangan</h1>";
	echo "
	<table border='1' width='100%'>
	<tr style='background:#ebebe0;color:#000;'>
		<th width='50px'>No</th>
    	<th width='50px'>Kode Ujian</th>
    	<th>Nama Mapel</th>
    	<th>Kode Mapel</th>
    	<th>Kelas</th>
    	<th>Nama Ujian</th>
    	<th>Jenis</th>";
    for($n=0;$n<count($idnya);$n++)
    {
    	echo "<tr>";
    	echo "<td>".($n+1)."</td>";
    	echo "<td>".$idnya[$n]."</td>";
    	echo "<td>".strtoupper($mapelnya[$n])."</td>";
    	echo "<td>".strtoupper($akronimnya[$n])."</td>";
    	echo "<td>".strtoupper($kelasnya[$n])."</td>";
    	echo "<td>".strtoupper($ujiannya[$n])."</td>";
    	echo "<td>".strtoupper($jenisnya[$n])."</td>";
    	echo "</tr>";
    }
    echo "</table>";
	?>
	<div class="spasi"></div>
	<div class="spasi"></div>
	<div class="spasi"></div>
	<div class="spasi"></div>
</div>
<?php
}
mysqli_close($db);
function ubah($sf)
{
    $size = $sf;
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
?>
