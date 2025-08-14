<?php
include "lib/configuration.php";
include "tgl.php";
require_once("pwww/konversi-tgl.php");
?>
<?php
$siswaid = $_SESSION['pid'];
	//echo "Kondisi : ".$_SESSION['tminus'];
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
    border: 0px solid black;
}
tr:hover {
	background: #CDEDF6;
	cursor: pointer;
}
</style>
<script>
	$(document).ready(function(){
		$(".pilihujian").click(function(){
			var pil_id = $(this).attr('id');
			$.ajax({
				type:'GET',
				url:'pwww/p-pilih-ujian.php',
				data:'ajax=1&pil_id='+pil_id,
				success:function(data) {
					if(data){
						//$("body").load("index.php").hide().fadeIn(1500).delay(6000);
						window.location.reload();
					}else{

						alert(data);
					}
				}
			});
		});
});
</script>
<h1>DAFTAR UJIAN HARI INI</h1>
Untuk tampilan HP/Smartphone , silahkan geser ke kanan untuk melihat status ujian.
<div class="spasi"></div>
<div class="cpanel" style="overflow-x:auto;">
	<div class="spasi"></div>
	<?php
	$sql = "select b.id_test,a.nama_test,a.tgl_awal_test,a.tgl_akhir_test,a.jumlah_soal,a.soal_opsi,a.soal_esay,a.waktu_test,
			a.keterangan,a.publish_test_to_other,b.last_login,b.remaining_time,b.kunci_login,diselesaikan,
			c.ket_mapel,c.kelas from t_test a,t_test_peserta b,t_mapel c where a.id=b.id_test and a.idmapel=c.mid
			and b.id_peserta='$siswaid' and a.tgl_awal_test like '$tglnow%' order by a.tgl_awal_test;
			";
			//echo $sql;
	$rs = mysqli_query($db,$sql);
	$xdata=1;
	$warna = "#f5f5f0";
	echo "
	<table id='t10'>
	<tr style='background:#ebebe0;color:#000;'>
    	<th width='5%'><center>No</center></th>
    	<th><center>MAPEL</center></th>
    	<th width='5%'><center>KELAS</center></th>
    	<th width='10%'><center>UJIAN</center></th>
    	<th width='15%'><center>PUKUL</center></th>
    	<th width='15%'><center>SISA WAKTU<br>(M)</center></th>
    	<th width='15%'><center>STATUS</center></th>
  	</tr>";
	while ( $br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) {
		$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
		if ($br['diselesaikan']=='1') {
			$warna = 'lightgreen';
		}
	?>
	<tr bgcolor="<? echo($warna);?>" class='pilihujian' id="<?=$br['id_test'];?>">
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="20px"><center><?=$xdata;?></center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;">
    		<?=strtoupper($br['ket_mapel']);?><br>
    		<?=$br['jumlah_soal'];?> Pertanyaan , <?=$br['waktu_test'];?> Menit
    	</td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="150px"><center><?=$br['kelas'];?></center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="80px"><center><?=strtoupper($br['nama_test']." ".$br['keterangan']);?></center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<center>
    			<?php echo konversi_tanggal("H:i:s",$br['tgl_awal_test']);?> - <?php echo konversi_tanggal("H:i:s",$br['tgl_akhir_test']);?>
    		</center>
    	</td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px"><center>
    		<?php
    		if ($br['remaining_time']=='') {
    			echo $br['waktu_test'];
    		}
    		else
    		{
    			if (($br['remaining_time']/60) < 0) {
					echo '0';
				}
				else
				{
					echo floor($br['remaining_time']/60);
				}
    		}
    		?>
    		</center></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;" width="50px">
    		<?php
    		if ($br['diselesaikan']=='1') {
    			echo '<b>Telah dikerjakan</b>';
    		}
    		else
    		{
    			if ($br['last_login']=='0000-00-00 00:00:00') {
    				echo "Belum dikerjakan";
    			}
    			else
    			{
    				echo "Sedang dikerjakan";
    			}
    			//echo $_SESSION['kdtest'];
    		}
    		?>
    	</td>
  	</tr>
	<?php
	$xdata=$xdata+1;
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
