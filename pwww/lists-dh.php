<?php
session_start();
include "../lib/configuration.php";
if((isset($_SESSION['ftest']) && $_SESSION['ftest']!='') || (isset($_SESSION['fruang']) && $_SESSION['fruang']!='') || (isset($_SESSION['fkelas']) && $_SESSION['fkelas']!='')) {
	//$sql1 = "select * from ";
	$crdata = $_SESSION['ftest'];
	$crdata2 = $_SESSION['fruang'];
	$crdata3 = $_SESSION['fkelas'];

	if ($crdata2!='kosong') {
		$sqldata = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2'";
	}

	if ($crdata3!='kosong') {
		$sqldata = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2' and b.kelompok='$crdata3'";
	}

	if($crdata3=='')
	{
		$sqldata = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2'";
	}
	else
	{
		if ($crdata3=='kosong') {
			$sqldata = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2'";

		}
		else
		{
			$sqldata = "SELECT b.pengguna,b.nama_pengguna,b.kelompok,b.ruang,a.id_test FROM t_test_peserta a,t_peserta b WHERE a.id_peserta=b.pid and a.id_test='$crdata' and b.ruang='$crdata2' and b.kelompok='$crdata3'";

		}

	}

	$rs = mysqli_query($db,$sqldata);
	//echo $sqldata;
	$pengguna = array();
	$nama_pengguna = array();
	$kelompok = array();
	$jdata = 0;
	while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
	{
		$pengguna[] = $br['pengguna'];
		$nama_pengguna[] = $br['nama_pengguna'];
		$kelompok[] = $br['kelompok'];
		$jdata++;
	}
	$ceiled = ceil($jdata/20);
	//echo $ceiled;

	?>

<STYLE TYPE="text/css">
table {
	width:100%;
	border: 1px solid #000;
}
table, th, td {
	border-collapse: collapse;
}
th, td {
	padding-top: 5px;
	padding-bottom: 5px;
	padding-left: 10px;
	padding-right: 10px;
	text-align: left;
	font-size: 12px;
}
.h00{
	text-align: center;
	font-weight: bold;
	font-size: 18px;
}
.spasi{
	height: 20px;
}
.nmkiri{
	width: 22%;
	float: left;
	height: 10px;
}
.t1{
	width: 50%;
	float: left;height: 20px;
	border-bottom: 1px solid gray;
}
.t11 {
	width: 28%;
	float: left;height: 20px;
}
.t2{
	width: 50%;
	float: left;height: 20px;
	border-bottom: 1px solid gray;
}
.t3{
	width: 14%;
	float: left;height: 20px;
	padding-left: 1%;
}
.t4{
	width: 12%;
	float: left;height: 20px;
	border-bottom: 1px solid gray;
}
.spasi2{
	clear: both;
	height: 20px;
}
.spasi3{
	clear: both;
	height: 0px;
}
.cpanel{
	font-size: 14px;
    border-bottom: 1px solid blue;
    padding-top: 5px;
    padding-bottom: 5px;
}
p {
    font-family: "Times New Roman";
}
</STYLE>
<?php
require_once("konversi-tgl.php");
$namasekolah = $_SESSION['namaSEKOLAH'];
$pisah = explode(" ", $namasekolah);

$s = "select a.idmapel,a.nama_test,a.keterangan,a.tgl_awal_test as tanggal,a.waktu_test,b.ket_mapel,b.kelas from t_test a,t_mapel b where a.idmapel=b.mid and a.id='$crdata'";
//echo $s;
$r = mysqli_query($db,$s);
$b = mysqli_fetch_array($r,MYSQLI_ASSOC);
$mapel = $b['ket_mapel'];
$tingkat = $b['kelas'];
$test = $b['nama_test'];
$ket = $b['keterangan'];
$tgltest = $b['tanggal'];
$lamatest = $b['waktu_test'];

list($date,$pukul) = explode(" ",$tgltest);
list($thn,$bln,$day) = explode("-",$date);

$pukuls = strtotime($pukul);
$akhirtest = date("H:i:s", strtotime('+'.$lamatest.' minutes', $pukuls));


$dtBln = array('01' => 1,'02' => 2,'03' => 3,'04' => 4,'05' => 5,'06' => 6,'07' => 7,'08' => 8,'09' => 9,'10' => 10,'11' => 11,'12' => 12);
if ($dtBln[$bln]<7) {
	$thnNew = ($thn-1)."/".$thn;
}
else
{
	$thnNew = $thn."/".($thn+1);
}
if ($test=='uas') {
	$ntest = 'UJIAN AKHIR SEMESTER';
}
elseif ($test=='uts') {
	$ntest = 'UJIAN TENGAH SEMESTER';
}
elseif ($test=='uh') {
	$ntest = 'ULANGAN HARIAN';
}
else
{
	$ntest = 'UJIAN';
}

$x=0;
$loop = 0;
$warna = '#f5f5f0';
  for ($k=0; $k < $ceiled; $k++)
  {
  	if (($k+1)< $ceiled || $jdata==20) {
  		$loop=20;
  	}
  	else
  	{
  		$loop =($jdata%20);
			if($loop==0)
			{
				$loop=20;
			}

  	}
//echo $loop."\n";
//echo $ceiled;
?>
<link rel="stylesheet" type="text/css" href="../css/printerset.css">
<div class="cpanel">
	<div class='h00'>
		DAFTAR HADIR PESERTA<br>
		<?=$ntest;?> <?=strtoupper($ket);?> <?=$pisah[0];?><br>
		TAHUN PELAJARAN <?=$thnNew;?>
	</div>
	<div class="spasi"></div>
	<div class="nmkiri">
		SEKOLAH/MADRASAH
	</div>
	<div class="t1">
		: <?=$namasekolah;?>
	</div>
	<div class="t11">
		&nbsp;
	</div>
	<div class="spasi3"></div>
	<div class="nmkiri">
		RUANG
	</div>
	<div class="t2">
		: <?=strtoupper($crdata2);?>
	</div>
	<div class="t3">
		KELOMPOK
	</div>
	<div class="t4">
		: <?=strtoupper($crdata3);?>
	</div>
	<div class="nmkiri">
		HARI/TANGGAL
	</div>
	<div class="t2">
		: <?php echo konversi_tanggal("D",$date);?>, <?php echo konversi_tanggal("j M Y",$date);?>
	</div>
	<div class="t3">
		PUKUL
	</div>
	<div class="t4">
		: <?=strtoupper($pukul);?>
	</div>
	<div class="nmkiri">
		MATA PELAJARAN
	</div>
	<div class="t1">
		: <?=strtoupper($mapel);?>
	</div>
	<div class="t11">
		&nbsp;
	</div>
	<br>
	<div class="spasi2"></div>
	<table width="100%" border='1'>
		<tr style='background:#ebebe0;color:#000;'>
			<th width="5%" style="padding:5px;">
				<center>NO</center>
			</th>
			<th width="15%" style="padding:5px;">
				<center>NOMOR UJIAN</center>
			</th>
			<th>
				<center>NAMA PESERTA</center>
			</th>
			<th width="10%">
				<center>KELOMPOK</center>
			</th>
			<th width="150px">
				<center>TANDA TANGAN</center>
			</th>

		</tr>
		<?php
		for($i=0;$i<$loop;$i++)
		{
			$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
		?>
		<tr bgcolor="<? echo($warna);?>" title="<?=strtoupper($nama_pengguna[$x]);?>">
			<td class="isi">
				<center><?=$x+1;?></center>
			</td>
			<td style="padding:5px;"><center><?=strtoupper($pengguna[$x]);?></center>
			</td>
			<td>
				<?=strtoupper($nama_pengguna[$x]);?>
			</td>
			<td>
				<center><?=strtoupper($kelompok[$x]);?></center>
			</td>
			<td style="padding:5px;">
				<?php
				if (($x+1)%2==0) {
					echo "<center>".($x+1)."</center>";
				}
				else
				{
					echo ($x+1);
				}
				?>

			</td>
		</tr>
		<?php
		$x++;
		}
		?>
	</table>
	<div><p>
		<pre>Jumlah Peserta yang Seharusnya Hadir	:_____ orang
Jumlah Peserta yang Tidak Hadir		:_____ orang
Jumlah Peserta Hadir				:_____ orang


      Pengawas I 								Pengawas II


(					)                               	(					)
NIP.										NIP.
</pre>
	</p>
	</div>
</div>

	<?php
	}
	?>
<div class='cpanel'>
	<div class='h00'>
		BERITA ACARA PELAKSANAAN<br>
		<?=$ntest;?> <?=strtoupper($ket);?> <?=$pisah[0];?><br>
		TAHUN PELAJARAN <?=$thnNew;?>
	</div>
	<div class="spasi"></div>
	<div class="spasi"></div>
	<div>
		<div class='bisi'>
		Pada hari ini <?php echo konversi_tanggal("D",$date);?>, <?php echo konversi_tanggal("j M Y",$date);?>, di <?=$namasekolah;?>
		telah diselenggarakan <?=$ntest;?> <?=strtoupper($ket);?>, untuk Mata Pelajaran <?=$mapel;?> dari pukul <?=$pukul;?> sampai dengan pukul <?=$akhirtest;?>
		</div>
		<div class='bno'>1.</div>
		<div class="bc2">
			Sekolah / Madrasah
		</div>
		<div class='bc3'>: <?=$namasekolah;?></div>
		<div class="bc2">
			Ruang
		</div>
		<div class='bc3'>: <?=$crdata2;?></div>
		<div class="bc2">
			Jumlah Peserta seharusnya
		</div>
		<div class='bc3'>: <?=$jdata;?></div>
		<div class="bc2">
			Jumlah yang Hadir
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class="bc2">
			Jumlah yang Tidak Hadir
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class="bc2">
			Yakni Nomor
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class="bc2">
			&nbsp;
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class='spasi2'></div>

		<div class='bno'>2.</div>
		<div class="bcatatan">
			Catatan selama Ujian :
		</div>
		<div class='bstrip'>&nbsp;</div>
		<div class='bstrip'>&nbsp;</div>
		<div class='bstrip'>&nbsp;</div>
		<div class='bstrip'>&nbsp;</div>
		<div class='bstrip'>&nbsp;</div>
		<div class='spasi2'></div>
		<div class='byang'>
			Yang membuat berita acara :
		</div>
		<div class='bno'>1.</div>
		<div class="bc2">
			Pengawas I
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class="bc2">
			NIP
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class="bc2">
			Tanda Tangan
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class='bno'>2.</div>
		<div class="bc2">
			Pengawas I
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class="bc2">
			NIP
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class="bc2">
			Tanda Tangan
		</div>
		<div class='bc3'>: &nbsp;</div>
		<div class='spasi2'></div>
	</div>
	<div class='note'>
		<pre>Catatan:
- Dibuat rangkap 2 (dua), masing-masing untuk Sekolah.
- Mohon berita acara diisi dengan sebenar-benarnya.</pre>
	</div>
</div>

	<?php
}
else
{
	echo "<h3>UNTUK CETAK DAFTAR HADIR DAN BERITA ACARA <br>SILAHKAN PILIH NAMA TEST DAN KELAS</h3>";
}
?>
