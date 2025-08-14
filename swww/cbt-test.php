<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include("../lib/configuration.php");
if(isset($_GET['sw']))
{
	$sw = $_GET['sw'];
}
else
{
	$sw = '0';
}
//echo $sw;
include "tgl.php";

$bulan = array("January","Pebruary","Maret","April","Mei","Juni","Juli","Agustus","September","Okotober","Nopember","Desember");

$hari  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$abc = array('0' => 'A','1' => 'B','2' => 'C','3' => 'D','4' => 'E' );
if(isset($_SESSION['nomor']))
{
	$nomor=$_SESSION['nomor'];
}
else
{
	$nomor=0;
}

if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>

	<script>
	$(document).ready(function(){
		$('.radio').click(function() {
		   var jwb= $('input[type="radio"]:checked').val();
		   //alert(jwb);
		   $.ajax({
				type:'GET',
				url:'swww/p-simpan-nomor.php',
				data:'ajax=11&jwb='+jwb,
				success:function(data) {
					console.log("Simpan jawaban = '" + jwb + "'");
				}
			});
		});
		$('.opsiku').click(function() {
		   var jwb = $(this).attr('id');
		   //alert(jwb);
		   $('.opsiku').css({"background-color":"#ffffff","color":"#000"});
		   $('#'+jwb).css({"background-color":"#000","color":"#fff"});
		   $.ajax({
				type:'GET',
				url:'swww/p-simpan-nomor.php',
				data:'ajax=11&jwb='+jwb,
				success:function(data) {
					console.log("Simpan jawaban = '" + jwb + "'");
				}
			});
		});
		$('#save_esay').click(function() {
		   var jwb= $.trim($('#jawabku').val());
		   //alert(jwb);
		   $.ajax({
				type:'GET',
				url:'swww/p-simpan-nomor.php',
				data:'ajax=11&jwb='+jwb,
				success:function(data) {
					$("#save_state").html("<span style='color:#cc0000'>Saved</span> ");
					console.log("Simpan jawaban = '" + jwb + "'");
				}
			});
		});
		$("#btnNext").click(function()
		{
			/*var jwb = $('input[name=radios]:checked').val();*/

			$.ajax({
				type:'GET',
				url:'swww/p-setnomor2.php',
				data:'ajax=1',
				success:function(data) {
					if(data==1){
						location.reload();
					}
					else
					{
						data=2;
					}
				}
			});
		});
		$("#btnPrev").click(function()
		{
			/*var jwb = $('input[name=radios]:checked').val();*/

			$.ajax({
				type:'GET',
				url:'swww/p-setnomor2.php',
				data:'ajax=2',
				success:function(data) {
					if(data==1){
						location.reload();
					}
					else
					{
						data=2;
					}
				}
			});
		});
		$("#btnPrev2").click(function()
		{
			$.ajax({
				type:'GET',
				url:'swww/p-simpan-nomor.php',
				data:'ajax=9',
				success:function(data) {
					if(data==1){
						location.reload();
					}
					else
					{
						data=2;
					}

				}
			});
		});
		$("#btnFin").click(function()
		{
			//var jwb = $('input[name=radios]:checked').val();
			$.ajax({
				type:'GET',
				url:'swww/p-simpan-nomor.php',
				data:'ajax=3',
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
		$("#btnFin2").click(function()
		{
			$.ajax({
				type:'GET',
				url:'swww/p-simpan-nomor.php',
				data:'ajax=4&jwb=1',
				success:function(data) {
					if(data==1){
						location.reload();
					}
					else
					{
						/*alert(data);*/
						location.reload();
					}
				}
			});
		});

		$("#btnPerbesar").click(function()
		{
			$('.pilihanopsi').css("font-size", "20px");
		});
		$("#btnNormal").click(function()
		{
			$('.pilihanopsi').css("font-size", "15px");
		});
		$("#btnPerkecil").click(function()
		{
			$('.pilihanopsi').css("font-size", "12px");
		});

	});
	</script>
	<script type="text/javascript">
	function perbesar(){
		var span = document.getElementById("pilsoal");
		span.style.fontSize = "20px";
		var span2 = document.getElementById("pilabc");
		span2.style.fontSize = "20px";

	}
	function normal(){
		var span = document.getElementById("pilsoal");
		span.style.fontSize = "15px";
		var span2 = document.getElementById("pilabc");
		span2.style.fontSize = "15px";
	}
	function perkecil(){
		var span = document.getElementById("pilsoal");
		span.style.fontSize = "12px";
		var span2 = document.getElementById("pilabc");
		span2.style.fontSize = "12px";
	}
	</script>
<style type="text/css">
@media all and (min-width: 601px) {
	.kotakSoal{
		height: 430px;
		overflow-y: scroll;
	}
	.pilsoal {
		clear: both;
		margin: 0 0px;
		font-size: 15px;
		padding-right: 15px;
		text-align: justify;
	}
	.pilujian {
		clear: both;
		margin: 0 0px;
	}
	#pilabc{
		font-size: 15px;
	}
	label {
	  width: 90%;
	  height: auto;
	  border-radius: 3px;
	  /*border: 1px solid #D1D3D4;*/
	}

	/* hide input */
	input.radio:empty {
		margin-left: -999px;
	}

	/* style label */
	input.radio:empty ~ label {
		position: relative;
		float: left;
		font-family: "Times New Roman", Times, serif;
		line-height: 1.5em;
		padding-left: 3em;
		padding-top: 5px;
		padding-bottom: 5px;
		margin-top: 10px;
		margin-left: 0px;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	input.radio:empty ~ label:before {
		position: absolute;
		display: block;
		top: 0;
		bottom: 0;
		left: 0;
		content: '';
		width: 2.5em;
		background: #D1D3D4;
		border-radius: 3px 0 0 3px;
	}

	/* toggle hover */
	input.radio:hover:not(:checked) ~ label:before {
		content:'\2714';
		text-indent: .9em;
		color: #C2C2C2;
	}

	input.radio:hover:not(:checked) ~ label {
		color: #888;
	}

	/* toggle on */
	input.radio:checked ~ label:before {
		content:'\2714'; /* check mark */
		text-indent: .9em;
		color: #9CE2AE;
		background-color: #4DCB6D;
	}
	input.radio:checked ~ label {
		color: #777;
		background-color: #80ff80;
	}
	input.radio:checked ~ .pilujian {
		background-color: #80ff80;
	}
	#jawabku{
		width: calc(100% - 45px);
	}
}
@media only screen and (max-width: 600px) {
	.kotakSoal{
		height: 430px;
		overflow-y: scroll;
	}
	.pilsoal {
		clear: both;
		margin: 0 0px;
		font-size: 11px;
	}
	.pilujian {
		clear: both;
		margin: 0 0px;
	}
	#pilabc{
		font-size: 11px;
	}
	label {
	  width: 80%;
	  height: auto;
	  border-radius: 3px;
	  /*border: 1px solid #D1D3D4;*/
	}

	/* hide input */
	input.radio:empty {
		margin-left: -999px;
	}

	/* style label */
	input.radio:empty ~ label {
		position: relative;
		float: left;
		font-family: "Times New Roman", Times, serif;
		line-height: 1em;
		padding-left: 3em;
		padding-top: 5px;
		padding-bottom: 5px;
		margin-top: 5px;
		margin-left: 0px;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	input.radio:empty ~ label:before {
		position: absolute;
		display: block;
		top: 0;
		bottom: 0;
		left: 0;
		content: '';
		width: 2.5em;
		background: #D1D3D4;
		border-radius: 3px 0 0 3px;
	}

	/* toggle hover */
	input.radio:hover:not(:checked) ~ label:before {
		content:'\2714';
		text-indent: .9em;
		color: #C2C2C2;
	}

	input.radio:hover:not(:checked) ~ label {
		color: #888;
	}

	/* toggle on */
	input.radio:checked ~ label:before {
		content:'\2714'; /* check mark */
		text-indent: .9em;
		color: #9CE2AE;
		background-color: #4DCB6D;
	}
	input.radio:checked ~ label {
		color: #777;
		background-color: #80ff80;
	}
	input.radio:checked ~ .pilujian {
		background-color: #80ff80;
	}
	#jawabku{
		width: calc(100% - 45px);
	}
}
.fontU {
	border: 1px solid #000;
	border-radius: 2px;
	width: 25px;
	height: 25px;
}
.fontU:hover{
	border: 2px solid #000;
	width: 20px;
	height: 20px;
	cursor: pointer;
}

.opsiku {
	float: left;
	border: 1px solid grey;
	height: 25px;
	width: 25px;
	border-radius: 50%;
	text-align: center;
	vertical-align: middle;
	line-height: 25px;
	cursor: pointer;
	color: #000;
}
.pilihanopsi{
	width: 80%;
}
.pilsoal{
	margin-top: 10px;
}
#topsi
{
	clear: both;
	border-style: none;
	width: 100%;
}
table#topsi td{
	padding: 5px;
	margin:0;
}
.tdopsi {
	width: 40px;
}
.mnfont {
	border: 1px solid grey;
	width: 25px;
	cursor: pointer;
	transition: all 0.5s ease;
}
.mnfont:hover {
	background: #ffbe00;
}
.bgputih {
	background-color: #ffffff;
}
.bghijau {
	background-color: #83FE86;
}
.bghitam {
	background-color: #000;
	color: #fff;
}
.kotakP{
	height: calc(100vh - 65px);
}
#btnPrev {
	padding: 15px 15px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
}
#btnNext {
	padding: 15px 15px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
}
#btnFin {
	background-color: red;
	padding: 15px 15px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
}
#btnFin:hover{
	background-color: #ff9933;
}
#konfirmasiSelesai{
		position:fixed;
    top: 50%;
    left: 50%;
    width:300px;
    height:100px;
    /* margin-top: -9em; /*set to a negative number 1/2 of your height*/
    /* margin-left: -15em; /*set to a negative number 1/2 of your width*/
		margin-top: -50px;
    margin-left: -50px;
}
</style>

	<div class="kotakP">
	<?php
	$siswaid = $_SESSION['pid'];
	$kdtest = $_SESSION['kdtest'];
	$totData = count($_SESSION['soals']);
	//echo $_SESSION['tminus'];

	if ($nomor==$totData && $_SESSION['tminus']==true) {
		echo "<div id='konfirmasiSelesai'>";
		echo "<div class=spasi></div><table id=t02><tr><td>";
		echo "<h1>KONFIRMASI UJIAN</h1>";
		echo "<span style='font-size:12px;'>Untuk menyelesaikan ujian ini, silahkan tekan tombol <strong><font color=BLUE>&nbsp;&nbsp;&nbsp;YA&nbsp;&nbsp;&nbsp;</font></strong> dan untuk kembali ke pertanyaan silahkan tekan tombol <strong><font color=BLUE>TIDAK</font></strong>.</span><br>";
		echo "<span style='font-size:12px;'>Anda yakin ingin menyelesaikan ujian ini ?</span><br><br><br>";
		echo "<div class='btnNextPrev letakKiri' id='btnFin2'>&nbsp;&nbsp;&nbsp;YA&nbsp;&nbsp;&nbsp;</div> <div class='btnNextPrev letakKanan' id='btnPrev2'>TIDAK</div> ";
		echo "<div class=spasi></div>";
		echo "</td></tr></table><div class=spasi></div>";
		echo "</div>";
	}
	else
	{

		echo '<b>NO SOAL : '.($nomor+1).' / '.$totData.'</b><br><br>';
		echo '<img class="fontU" src="images/larger.png" width="25px" onclick="perbesar();" id="btnPerbesar">&nbsp;';
		echo '<img class="fontU" src="images/normal.png" width="25px" onclick="normal();" id="btnNormal">&nbsp;';
		echo '<img class="fontU" src="images/smaller.png" width="25px" onclick="perkecil();" id="btnPerkecil">';
		echo '

				';
				?>

			<div class="kotakSoal">

				<?php
				$qid = $_SESSION['soals'][$nomor];

				/*$sbaning = "select pilihan from t_hsl_test where idsoal='$qid' and idtest='$kdtest' and idpeserta='$siswaid' limit 1";
				$rbanding = mysqli_query($db,$sbaning);
				$bbanding = mysqli_fetch_array($rbanding,MYSQLI_ASSOC);
				$cjawab = $bbanding['pilihan'];
				$sq = "select qid,isi_soal,pilihan1,pilihan2,
				pilihan3,pilihan4,pilihan5,opsi_esay
				from t_soal where qid='$qid' limit 1";*/
				$sq = "SELECT qid, isi_soal, pilihan1, pilihan2, pilihan3, pilihan4, pilihan5, opsi_esay, pilihan
						FROM t_soal a, t_hsl_test b
						WHERE a.qid = b.idsoal and b.idsoal='$qid' and
						b.idtest='$kdtest' and b.idpeserta='$siswaid' limit 1";
				$rq = mysqli_query($db,$sq);
				$bq = mysqli_fetch_array($rq,MYSQLI_ASSOC);
				$cjawab = $bq['pilihan'];

				$dpil = array(1=>'a',2=>'b',3=>'c',4=>'d',5=>'e');
				$p = array(1,2,3,4,5);
				$kar = array('a','b','c','d','e');
				if ($_SESSION['acjwb']=='1') {
					shuffle($p);
				}


				?>
				<div class="pilsoal"><b><u>Pertanyaan</u></b></div>
				<div id="pilsoal" class="pilsoal" onclick="setHeight()">
				<?=nl2br(trim(str_replace(array("<p>","</p>"),array("","\n"),$bq["isi_soal"])));?>
				</div><br>
				<?php
				if ($bq['opsi_esay']=='1') {
					if ($cjawab=='x') {
						$cjawab='';
					}
					?>
					<div class="pilsoal"><b><u>Jawaban Anda:</u></b></div>
					<div class="pilujian" id="pilujian">
						<textarea id="jawabku" name="jawabku" rows="4"><?=$cjawab;?></textarea> <br>
						<input type="button" id="save_esay" value="simpan jawaban">
						<div id="save_state"></div>
					</div>
					<?php
				}
				else
				{
				?>
				<div class="pilsoal"><b><u>Pilihan jawaban</u></b></div>
				<div class="radio-toolbar" id="pilabc">
					<table id='topsi'>
				<?php
					$j=0;
					for ($i=0; $i < 5; $i++) {
						if ($bq['pilihan'.($p[$i])]!='') {
						if($dpil[$p[$i]]==$cjawab)
							{
								$opsiwarna = "bghitam";
							}
							else{
								$opsiwarna = "bgputih";
							}
						?>
						<tr>
						<div class="pilujian" id="pilujian">
							<td class="tdopsi">
								<div class='opsiku <?=$opsiwarna;?>' id='<?=$dpil[$p[$i]];?>'><?=$abc[$j];?></div>
							</td>
							<td>
								<div class='pilihanopsi'>
							   		<label for="radio<?=$i;?>">
							    		<?=nl2br(trim(str_replace(array("<p>","</p>"),array("","\n"),$bq['pilihan'.($p[$i])])));?>

							    	</label>
								</div>
							</td>
						</div>
						</tr>
						<?php
						/*?>
						<div class="pilujian" id="pilujian">
						    <input type="radio" id="radio<?=$i;?>" class="radio" name="radios" value="<?=$dpil[$p[$i]];?>" <?php if($dpil[$p[$i]]==$cjawab) echo 'checked';?>>
						    <label for="radio<?=$i;?>">
						    	<?=nl2br(trim(str_replace(array("<p>","</p>"),array("","\n"),$bq['pilihan'.($p[$i])])));?>
						    	<?php /*<img src="images/<?=$kar[$j];?>.png" width="20px" align="absmiddle" class='imglink'> */?>
						    	<?php /*

						    </label>
					    </div>
						<?php
						*/
						$j++;
						}

					}
				?>
					</table>
				</div>
				<?php
				}
				?>
				</div>
				<div class='spasi'></div>
				<?php
				echo '

			<div class=spasi></div>';
			if ($nomor>0)
			{
			?>
			<div class="btnNextPrev letakKiri" id='btnPrev'>
				&#8592; Sebelumnya
			</div>
			<?php
			}
			if($nomor<($totData-1))
			{
				?>
				<div class="btnNextPrev letakKanan" id='btnNext'>
					Berikutnya &#8594;
				</div>
				<?php
			}
			else
			{
				if(isset($_SESSION['tminus']) && $_SESSION['tminus']==true)
				{
				?>
				<div class="btnNextPrev letakKanan" id='btnFin'>
					[ Selesai ]
				</div>
				<?php
				}
			}
			?>
			<div class="spasi"></div>
			<div class="spasi"></div>
			<div class="spasi"></div>
	</div>
	<?php
	}
}
mysqli_close($db);
?>
