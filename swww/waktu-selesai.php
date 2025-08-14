<?php
include("lib/configuration.php");
include "tgl.php";
$bulan = array("January","Pebruary","Maret","April","Mei","Juni","Juli","Agustus","September","Okotober","Nopember","Desember");
$hari  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");

if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	
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
	if ($_SESSION['kdtest']==NULL) {
		$_SESSION['wtfinish']=NULL;
		//echo "TESTING";
	}
	$statustest = "";
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
	$rselesai = $br['diselesaikan'];
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
	if($_SESSION['wtfinish']!='1' || $rselesai=='0')
	{
		$statustest = "Silahkan melakukan konfirmasi selesai!";
	}
	else
	{
		$statustest = "Ujian telah dikerjakan!";
	}
	if ($rselesai=='0') {
			
		echo '<div class=spasi></div>
			<table id=t02>
			<tr>
				<td width=25%>Pelajaran</td>
				<td width=5px>:</td>				
				<td>'.strtoupper($pelajaran).'</td>				
			</tr>
			<tr>
				<td>Kode/Nama ujian</td>
				<td>:</td>				
				<td>'.strtoupper($kode).' / '.strtoupper($nmtest).'</td>
			</tr>			
			<tr>
				<td>Durasi ujian</td>
				<td>:</td>				
				<td>'.$durasi.' MENIT</td>
			</tr>
			<tr>
				<td>Sisa waktu</td>
				<td>:</td>				
				<td>'.$rtimeM.' MENIT '.$rtimeS.' Detik</td>
			</tr>
			<tr>
				<td>Jumlah pertanyaan</td>
				<td>:</td>				
				<td>'.$jmlsoal.' SOAL</td>
			</tr>
			<tr>
				<td>Status Ujian</td>
				<td>:</td>				
				<td> <span class="blink_text" style="font-style: italic;color:red;">'.$statustest.'</span></td>
			</tr>					
			</table>
			<div class=spasi></div>
			<input type="hidden" name="itoken" id="itoken" value="mulai" class="input2 wd15">
			';	
	
			if ($rtgl<0 && $rtgl2>0 && !isset($_SESSION['wtfinish'])) {
			?>			
			<div class="validasitest btnValidasi" id='btnMulai'>
				<img src="images/Start.png" width="35px" class="imglink" align="absmiddle"> Mulai Ujian
			</div>
			<?php
			}
			else
			{
				if($_SESSION['wtfinish']!='1' || $rselesai=='0')
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
	}
	else
	{
		$_SESSION['kdtest']=NULL;
		$_SESSION['wtfinish']=NULL;
		$_SESSION['soals'] = NULL;
		echo "<h1>TERIMA KASIH ANDA TELAH MENGERJAKAN UJIAN</h1>";
		echo "<h6>silahkan klik tombol kembali ke Menu untuk menuju menu ujian anda! semoga sukses.</h6>";
		echo "<div class='imgbg'>
			  </div>
		";
		echo "<div class='validasitest btnValidasiYb' id='btnBatal'>
							 Kembali ke Menu
						</div>";
			echo "<br>";
		
		
		//include "pwww/list-ujian.php";
	}
	echo "<br>";
}
mysqli_close($db);
?>
