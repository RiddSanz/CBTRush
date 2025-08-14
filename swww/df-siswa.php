<?php
session_start();
include("../lib/configuration.php");
require_once("../pwww/konversi-tgl.php");
include "tgl.php";
$bulan = array("January","Pebruary","Maret","April","Mei","Juni","Juli","Agustus","September","Okotober","Nopember","Desember");
$hari  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
//echo $_SESSION['enable_token'];
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	<script src="js/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		$("#btnMulai").click(function()
		{
			var itoken=$("#itoken").val();
			$.ajax({
				type:'GET',
				url:'swww/p-mulai-test.php',
				data:'ajax=1&itoken='+itoken,
				success:function(data) {
					if(data==1){
						location.reload();
					}else if(data==2){
						$("#error").html("<span style='color:#cc0000'>Token tidak valid.</span> ");
					}
					else if(data==3){
						$("#error").html("<span style='color:#cc0000'>Token salah!.</span> ");
					}
					else
					{
						alert(data);
						console.log(data);
					}
				}
			});
		});
		$("#btnSelesai").click(function()
		{
			$.ajax({
				type:'GET',
				url:'swww/p-waktu-selesai.php',
				data:'ajax=1',
				success:function(data) {
					if(data==1){
						location.reload();
					}
					else
					{
						alert(data);
					}
				}
			});
		});
		$("#btnBatal").click(function()
		{
			$.ajax({
				type:'GET',
				url:'swww/p-batalujian.php',
				data:'ajax=1',
				success:function(data) {
					if(data==1){
						location.reload();
						//$("body").load("index.php").hide().fadeIn(1500).delay(6000);
					}
					else
					{
						alert(data);
					}
				}
			});
		});
	});

	</script>
	<?php
	if (isset($_SESSION['kdtest']) && $_SESSION['kdtest']!='' && $_SESSION['kdtest']!=NULL)
	{
		$statustest="";
		$siswaid = $_SESSION['pid'];
		$kdtest = $_SESSION['kdtest'];
		$sql = "select * from v_test_siswa where id_peserta='$siswaid' and
				id_test='$kdtest' and diselesaikan='0' limit 1";
		$rs = mysqli_query($db,$sql);
		$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
		$tot_test = mysqli_num_rows($rs);
		if ($tot_test==0) {
			$_SESSION['wtfinish'] = NULL;
			$_SESSION['kdtest']=NULL;
			echo "<h1>UJIAN TELAH DIKERJAKAN</h1>";
			echo "<h6>Otomatis akan kembali ke menu setelah 1 menit , atau tekan tombol kembali ke menu</h6>";
			echo "<div class='validasitest btnValidasiYb' id='btnBatal'>
							 Kembali ke Menu
						</div>";
			echo "<br>";
		}
		else
		{
			$pelajaran = $br['ket_mapel'];
			$kelas = $br['kelas'];
			$keterangan = $br['keterangan'];
			$nmtest = $br['nama_test'];
			$kode = $br['kode_test'];
			$tgl1 = $br['tgl_awal_test'];
			$tgl2 = $br['tgl_akhir_test'];
			$durasi = $br['waktu_test'];
			$jmlsoal = $br['jumlah_soal'];
			$rtime = $br['remaining_time'];
			$pidlock = $br['kunci_login'];
			$rtgl = strtotime($tgl1) - strtotime($tgl);
			$rtgl2 = strtotime($tgl2) - strtotime($tgl);
			if ($rtime=='') {
				if (($durasi*60) < $rtgl2) {
					$rtime = $durasi*60;
				}
				else
				{
					if ($rtgl2<0) {
						$rtime = 0;
					}
					else
					{
						$rtime=$rtgl2;
					}

				}
				$statustest = "Ujian belum dikerjakan!";
			}
			else
			{
				if ($rtime>$rtgl2) {
					$rtime = $rtgl2;
				}
				else
				{
					$rtime = $rtime;
				}
				$statustest = "Ujian sedang dikerjakan!";
			}
			if ($rtgl2<0) {
				$rtime = 0;
			}
			$rtimeM = floor($rtime / 60 );
			$rtimeS = ($rtime % 60 );
			if ($rtimeM < 0) {
				$rtimeM = 0;
				$rtimeS = 0;
			}
			if ($rtimeM <=0 ) {
				$_SESSION['wtfinish'] = '1';
				$statustest = "Silahkan menekan tombol [ konfirmasi selesai ]!";
			}
			if ($pidlock=='1') {
				$_SESSION['pidlock'] = '1';
			}
			if ($durasi==$rtimeM) {
				$statustest = "Ujian belum dikerjakan!";
			}
			echo '<div class=spasi></div>
					<table id=t02>
					<tr>
						<td width=25%>Mata Pelajaran / Tingkat </td>
						<td width=5px>:</td>
						<td>'.strtoupper($pelajaran).' / '.strtoupper($kelas).'</td>
					</tr>
					<tr>
						<td>Nama Ujian </td>
						<td>:</td>
						<td>'.strtoupper($nmtest." ".$keterangan).'</td>
					</tr>
					<tr>
						<td>Durasi </td>
						<td>:</td>
						<td>'.$durasi.' menit</td>
					</tr>
					<tr>
						<td>Sisa Waktu </td>
						<td>:</td>
						<td>'.$rtimeM.' menit '.$rtimeS.' detik</td>
					</tr>
					<tr>
						<td>Pertanyaan</td>
						<td>:</td>
						<td>'.$jmlsoal.' pertanyaan</td>
					</tr>
					<tr>
						<td>Test dibuka</td>
						<td>:</td>
						<td>';
						list($date1,$time1) = explode(" ",$tgl1);
						list($y,$m,$t) =  explode("-",$date1);

						//echo $time1.' , '.$t.' '.$bulan[intval(date('m',strtotime($tgl1))) - 1].' '.$y;
						echo konversi_tanggal("H:i:s",$time1);
						echo " - ";
						list($date2,$time2) = explode(" ",$tgl2);
						list($y,$m,$t) =  explode("-",$date2);

						//echo $time2.' , '.$t.' '.$bulan[intval(date('m',strtotime($tgl2))) - 1].' '.$y;
						echo konversi_tanggal("H:i:s",$time2)." WIB";
						echo '</td>
					</tr>
					<tr>
						<td>Waktu server</td>
						<td>:</td>
						<td>';
						list($dt,$tm) = explode(" ",$tgl);
						list($y,$m,$t) =  explode("-",$dt);

						echo $tm.' , '.$t.' '.$bulan[intval(date('m',strtotime($tgl))) - 1].' '.$y;
						echo '</td>
					</tr>
					<tr>
						<td>Status Ujian</td>
						<td>:</td>
						<td><span class="blink_text" style="font-style: italic;color:red;">'.$statustest.'</span></td>
					</tr>
					</table>
					<div class=spasi></div>
					<input type="hidden" name="itoken" id="itoken" value="mulai" class="input2 wd15">
					';
					if ($rtgl<0) {
						if ($rtgl<0 && $rtgl2>0 && !isset($_SESSION['wtfinish'])) {
						?>
						<div class="validasitest btnValidasiY" id='btnMulai'>
							 MULAI UJIAN
						</div>
						<div class="validasitest btnValidasiYb" id='btnBatal'>
							 KEMBALI KE MENU
						</div>
						<?php
						}
						else
						{
						?>
						<div class="validasitest btnValidasiG" id='btnSelesai'>
							[ Konfirmasi Selesai ]
						</div>
						<div class="validasitest btnValidasiYb" id='btnBatal'>
							 KEMBALI KE MENU
						</div>
						<?php
						}
					}
					else
					{
						?>
						<div class="validasitest btnValidasiY">
							UJIAN BELUM MULAI
						</div>
						<div class="validasitest btnValidasiYb" id='btnBatal'>
							 MENU
						</div>
						<?php
					}
					echo "<br>";

		}

	}
	else
	{
		//echo "kode test kosong";
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	}
}
mysqli_close($db);
?>
