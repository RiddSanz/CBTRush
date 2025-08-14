<?php
session_start();
include("../lib/configuration.php");
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
	
	<script>	
	$(document).ready(function(){
		$('#itoken').focus();
		$("#btnvalid").click(function()
		{
			var itoken=$("#itoken").val();
			$.ajax({
				type:'GET',
				url:'swww/p-validasi-token.php',
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
	$siswaid = $_SESSION['pid'];
	$kdtest = $_SESSION['kdtest'];
	$sql = "select * from v_test_siswa where id_peserta='$siswaid' and 
			id_test='$kdtest' limit 1";
	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$pelajaran = $br['nama_mapel'];
	$nmtest = $br['nama_test'];
	$kode = $br['kode_test'];
	$tgl1 = $br['tgl_awal_test'];
	$tgl2 = $br['tgl_akhir_test'];
	$durasi = $br['waktu_test'];
	$jmlsoal = $br['jumlah_soal'];
	$rtime = $br['remaining_time'];
	$pidlock = $br['kunci_login'];
	$tgl_login = $br['last_login'];
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
	}
	if ($pidlock=='1') {
		$_SESSION['pidlock'] = '1';
	}
	echo '<div class=spasi></div>
			<table id=t02>
			<tr>
				<td width=25%>PELAJARAN</td>
				<td width=5px>:</td>				
				<td>'.strtoupper($pelajaran).'</td>				
			</tr>
			<tr>
				<td>KODE TEST</td>
				<td>:</td>				
				<td>'.strtoupper($kode).'</td>
			</tr>
			<tr>
				<td>NAMA TEST</td>
				<td>:</td>				
				<td>'.strtoupper($nmtest).'</td>
			</tr>
			<tr>
				<td>DURASI TEST</td>
				<td>:</td>				
				<td>'.$durasi.' MENIT</td>
			</tr>
			<tr>
				<td>SISA WAKTU</td>
				<td>:</td>				
				<td>'.$rtimeM.' MENIT '.$rtimeS.' Detik</td>
			</tr>
			<tr>
				<td>JUMLAH SOAL</td>
				<td>:</td>				
				<td>'.$jmlsoal.' SOAL</td>
			</tr>			
			<tr>
				<td>TOKEN</td>
				<td>:</td>				
				<td><input name="itoken" id="itoken" class="input2 wd15"></td>
			</tr>
			</table>
			<div class=spasi></div>';
			?>
			<div class="validasitest btnValidasiY" id='btnvalid'>
				LANJUTKAN >>
			</div>
			<div class="validasitest btnValidasiYb" id='btnBatal'>
				 Kembali ke Menu
			</div>
			<div id="error"></div>
	<?php	
		echo "<br>";
		echo "<br>";		
}
mysqli_close($db);
?>
