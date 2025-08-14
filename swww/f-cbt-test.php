<?php
include("lib/configuration.php");

include "tgl.php";
$doc = "swww/cbt-test.php";

	$siswaid = $_SESSION['pid'];
	$kdtest = $_SESSION['kdtest'];
	$sql = "select * from v_test_siswa where id_peserta='$siswaid' and
			id_test='$kdtest' limit 1";
	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$tgl_login = $br['last_login'];
	$rtime = $br['remaining_time'];

	if ($rtime!='') {
		$rtglw = strtotime($tgl) - strtotime($tgl_login);
		$wl = $rtime - $rtglw;
		$su = "update t_test_peserta set last_login='$tgl',remaining_time='$wl' where id_test='$kdtest' and id_peserta='$siswaid' limit 1";
		$ru = mysqli_query($db,$su);

		$sql = "select * from v_test_siswa where id_peserta='$siswaid' and
				id_test='$kdtest' limit 1";
		$rs = mysqli_query($db,$sql);
		$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	}
	$pelajaran = $br['nama_mapel'];
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
	mysqli_close($db);
?>
	<script src="js/jquery.min.js"></script>
	<script type="text/javascript" src="lib/jquery-2.0.3.js"></script>
	<script type="text/javascript" src="js/jquery.countdownTimer.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.countdownTimer.css" />
	<script>
	$(document).ready(function(){
		$("#preview").fadeIn("slow");
		$("#preview").html('');
		$("#ReloadThis").load("<?php echo $doc;?>");
	});
	</script>
	<!--<meta http-equiv='refresh' content="90; url=index.php?sw=10">-->
<body>
<span id="m_timer"></span>
<script>
 $(function(){
 	$('#m_timer').countdowntimer({
        minutes :<?php echo $rtimeM;?>,
        seconds : <?php echo $rtimeS;?>,
        size : "md",
        timeUp : timeisUp
    });

	function timeisUp() {
		$.ajax({
				type:'GET',
				url:'swww/p-timeup.php',
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
	}
 });

var counter = 0;
CallEvery5Minutes();

 var interval = window.setInterval(function () {
	    CallEvery5Minutes();
 }, 60000);

 function CallEvery5Minutes() {
    /*console.log("5 Minutes Completed!!! = '" + counter + "'");*/
    /*if (counter == 5) {
        clearInterval(interval);
        console.log("Interval has been cleared!!!");
    }*/
    $.ajax({
		type:'GET',
		url:'swww/p-simpan-waktu.php',
		data:'ajax=10',
		success:function(data) {
			console.log("Simpan waktu ke = '" + counter + "'");
		}
	});

    counter += 1;
 }

</script>
<div class="ctime" id="btnmenu">
		<img src="images/menu2.png"/>
</div>
<div class="ctime" id="btnmenu2">
		<img src="images/menu2.png"/>
</div>
<div id="ReloadThis"></div><div id='preview' class='ctime'></div>

</body>
