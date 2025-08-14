<?php
include "lib/configuration.php";
include "tgl.php";
include "pwww/akronim.php";
require_once("pwww/konversi-tgl.php");
?>
<?php
$siswaid = $_SESSION['pid'];
##echo $siswaid;
$tglnow = date("Y-m-d",$timestamp);
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>
<style>
table {
	width: 100%;
}
table, th, td {
    border: 1px #fff black;
}
tr:hover {
	background: #CDEDF6;
	cursor: pointer;
}
</style>

<h1>HASIL UJIAN</h1>
Jika ada soal uraian , nilai diserahkan ke gurunya masing-masing.
<div class="spasi"></div>
Untuk tampilan HP/Smartphone , silahkan geser ke kanan untuk melihat nilai hasil ujian.
<div class="spasi"></div>
<div class="cpanel" style="overflow-x:auto;">
	<?php
  $datanya = array();
  $sql ="select * from rekap_hasil where idpeserta='".$siswaid."'";
  $rs = mysqli_query($db,$sql);
  while ($br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) {
    $id = $br['idtest'];
    $datanya[$id] = $br['tnilai'];
  }
  ##echo $sql;
	$sql = "select b.id_test,a.nama_test,a.tgl_awal_test,a.tgl_akhir_test,a.jumlah_soal,a.soal_opsi,a.soal_esay,a.waktu_test,
			a.keterangan,a.publish_test_to_other,b.last_login,b.remaining_time,b.kunci_login,diselesaikan,
			c.ket_mapel,c.kelas from t_test a,t_test_peserta b,t_mapel c where a.id=b.id_test and a.idmapel=c.mid
			and b.id_peserta='$siswaid' and a.publish_test_to_other='1' and diselesaikan='1' order by a.tgl_awal_test;
			";
			//echo $sql;
	$rs = mysqli_query($db,$sql);
	$xdata=1;
	$warna = "#f5f5f0";
	echo "
	<table border='1' width='100%'>
	<tr style='background:#ebebe0;color:#000;'>
    	<th width='5%' rowspan='2'><center>No</center></th>
    	<th rowspan='2'><center>MAPEL</center></th>
      <th width='5%' rowspan='2'><center>KD_UJIAN</center></th>
    	<th width='5%' rowspan='2'><center>KELAS</center></th>
    	<th width='15%' rowspan='2'><center>TANGGAL</center></th>
    	<th width='10%' rowspan='2'><center>PUKUL</center></th>
    	<th width='15%' colspan='3'><center>SOAL</center></th>
      <th width='10%' colspan='3'><center>HASIL BENAR</center></th>
  	</tr>";
    echo "<tr style='background:#ebebe0;color:#000;'>";
        ?>
        <th width='5%'><center>Pilihan</center></th>
        <th width='5%'><center>Uraian</center></th>
        <th width='5%'><center>Total</center></th>
        <th width='5%'><center>Pilihan</center></th>
        <th width='5%'><center>Uraian</center></th>
        <th width='5%'><center>Total</center></th>
        <?php
    echo "</tr>";
	while ( $br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) {
		$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
		if ($br['diselesaikan']=='1') {
			$warna = '#fff';
	?>
	<tr bgcolor="<? echo($warna);?>" class='pilihujian' id="<?=$br['id_test'];?>">
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="20px"><center><?=$xdata;?></center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;">
    		<?=strtoupper($br['ket_mapel']);?><br>
    		<?=$br['jumlah_soal'];?> Pertanyaan , <?=$br['waktu_test'];?> Menit
    	</td>
      <td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="150px">
				<center>
					<?//preg_replace('~\b(\w)|.~', '$1', $br['ket_mapel'])."_".$br['id_test'];?>
					<?=acronym($br['ket_mapel'])." (".$br['id_test'].")";?>
				</center>
			</td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="150px"><center><?=$br['kelas'];?></center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;"><center><?php echo konversi_tanggal("D, j M Y",$br['tgl_awal_test']);?></center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<center>
    			<?php echo konversi_tanggal("H:i:s",$br['tgl_awal_test']);?>
    		</center>
    	</td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px"><center>
    		<center><?php
    		echo $br['soal_opsi'];
    		?></center>
    		</center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<center><?php
    		echo $br['soal_esay'];
    		?></center>
    	</td>
      <td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<center><?php
    		echo $br['jumlah_soal'];
    		?></center>
    	</td>
      <td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<center><?php
    		echo $datanya[$br['id_test']];
    		?></center>
    	</td>
      <td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<center><?php
    		echo '0';
    		?></center>
    	</td>
      <td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<center><?php
    		//echo number_format(($datanya[$br['id_test']]/$br['soal_opsi'])*100,2);
        echo $datanya[$br['id_test']];
    		?></center>
    	</td>
  	</tr>
	<?php
    }
	$xdata++;
	}
	echo "</table>";
	?>
</div>
<div class="cpanel">
	<div class="spasi"></div>
</div>
<?php
}
mysqli_close($db);
?>
