<?php 
include "lib/configuration.php";

$sql1 = "select count(pid) as j from t_peserta limit 1";
$rs1 = mysqli_query($db,$sql1);
$br1 = mysqli_fetch_array($rs1,MYSQLI_ASSOC);
$jpeserta = $br1['j'];

$sql2 = "select count(mid) as j from t_mapel limit 1";
$rs2 = mysqli_query($db,$sql2);
$br2 = mysqli_fetch_array($rs2,MYSQLI_ASSOC);
$jmapel = $br2['j'];

$sql2 = "select count(*) as j from t_kd limit 1";
$rs2 = mysqli_query($db,$sql2);
$br2 = mysqli_fetch_array($rs2,MYSQLI_ASSOC);
$jkd = $br2['j'];

$sql2 = "select count(*) as j from t_image limit 1";
$rs2 = mysqli_query($db,$sql2);
$br2 = mysqli_fetch_array($rs2,MYSQLI_ASSOC);
$jimage = $br2['j'];

$sql2 = "select count(*) as j from t_soal limit 1";
$rs2 = mysqli_query($db,$sql2);
$br2 = mysqli_fetch_array($rs2,MYSQLI_ASSOC);
$jsoal = $br2['j'];

$sql2 = "select count(*) as j from t_activity limit 1";
$rs2 = mysqli_query($db,$sql2);
$br2 = mysqli_fetch_array($rs2,MYSQLI_ASSOC);
$jlog = $br2['j'];

$sql3 = "select (select count(*) from t_test) as t1,(select count(*) from t_test_pertanyaan) as t2,(select count(*) from t_test_peserta) as t3,(select count(*) from t_hsl_test) as t4 ";
$rs3 = mysqli_query($db,$sql3);
$br3 = mysqli_fetch_array($rs3,MYSQLI_ASSOC);
$jtest = $br3['t1']+$br3['t2']+$br3['t3']+$br3['t4'];

$DB_NAME = "tryout";
$TABLE_NAME = "t_test";
$satuan = "KB";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$utest = $br4['ukuran_kb'];

$TABLE_NAME = "t_test_pertanyaan";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$utest = $utest + $br4['ukuran_kb'];

$TABLE_NAME = "t_test_peserta";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$utest = $utest + $br4['ukuran_kb'];

$TABLE_NAME = "t_hsl_test";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$utest = $utest + $br4['ukuran_kb'];

$TABLE_NAME = "t_mapel";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$umapel= $br4['ukuran_kb'];

$TABLE_NAME = "t_kd";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$ukd= $br4['ukuran_kb'];

$TABLE_NAME = "t_image";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$uimage= $br4['ukuran_kb'];

$TABLE_NAME = "t_soal";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$usoal= $br4['ukuran_kb'];

$TABLE_NAME = "t_peserta";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$upengguna= $br4['ukuran_kb'];

$TABLE_NAME = "t_activity";
$sql4 = "select table_name as nmtable,round(((data_length + index_length) / 1024 ), 2) as ukuran_kb FROM information_schema.TABLES WHERE table_schema = '$DB_NAME' AND table_name = '$TABLE_NAME'";
$rs4 = mysqli_query($db,$sql4);
$br4 = mysqli_fetch_array($rs4,MYSQLI_ASSOC);
$ulog= $br4['ukuran_kb'];

$jmlPelajaran = $jmapel + $jkd + $jimage + $jsoal;
$utPelajaran = $umapel + $ukd + $uimage + $usoal + $utest;
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if((isset($_SESSION['sid_user']) && $_SESSION['sid_user']!="") || $_SESSION['tingkat_user']=='0')
	{
?>	
<style type="text/css">
.meter-wrap{
    position: relative;
}

.meter-wrap, .meter-value, .meter-text {
    /* The width and height of your image */
    width: 100%; height: 30px;
}

.meter-wrap, .meter-value {
    background: #00D4B8 url(images/bg_meter.png) top left no-repeat;
    background-size: 0px 30px;
}

.meter-text {
    position: absolute;
    top:0; left:0;
    padding-top: 5px;
    padding-left: 5px;
    color: #fff;
    text-align: left;
    width: 100%;
}
.meter-wrap:hover {
	background-color: #0077E3;
}
.pdMeter {
	padding-left: 15px;
	margin-right: 15px;
}
#akhir {
	padding-left: 15px;	
}
#akhir a {
	color: #fff;
	margin-top: 15px;
	padding: 5px;
	background: #0077E3;
}
#akhir a:hover {
	background: #00D4B8;
}
</style>
<script type='text/javascript'>
$(document).ready(function(){
    var ex1running = false;
    var ex2running = false;
    var ex3running = false;
    var ex4running = false;

    $('#meter-ex1').click(function(){
      if(!ex1running){
        ex1running = true;
        var hsl = "";
        var $this = $(this);
        var count = 0;
        var inter = null;
        var dataString = "ajax=1";
        $.ajax({
				type: "POST",
				url: "pwww/p-resetpengguna.php",
				data: dataString,
				cache: false,
				success: function(data){
					hsl=data;					
				}
			});
        function run(){
			count++;
			$this.find('.meter-value').css('width', count+"%");
			$this.find('.meter-text').text(count+"%");
			if(count == 100){
				clearInterval(inter);
				ex1running = false;
				$("#lpeserta").html(hsl);
				$("#akhir").html("Penghapusan berhasil!");
			}
		}
		inter = setInterval(run, 50);
      }
    });

    $('#meter-ex2').click(function(){
      if(!ex2running){
        ex2running = true;
        var hsl = "";
        var $this = $(this);
        var count = 0;
        var inter = null;
        var dataString = "ajax=1";
        $.ajax({
				type: "POST",
				url: "pwww/p-resettest.php",
				data: dataString,
				cache: false,
				success: function(data){
					hsl = data;			
				}
			});
        function run(){
			count++;
			$this.find('.meter-value').css('width', count+"%");
			$this.find('.meter-text').text(count+"%");
			if(count == 100){
				clearInterval(inter);
				ex2running = false;
				$("#ltest").html(hsl);
				$("#akhir").html("Penghapusan berhasil!");
			}
		}
		inter = setInterval(run, 50);
      }
    });

    $('#meter-ex3').click(function(){
      if(!ex3running){
        ex3running = true;
        var hsl = "";
        var $this = $(this);
        var count = 0;
        var inter = null;
        var dataString = "ajax=1";
        $.ajax({
				type: "POST",
				url: "pwww/p-resetmapel.php",
				data: dataString,
				cache: false,
				success: function(data){
					hsl=data;					
				}
			});
        function run(){
			count++;
			$this.find('.meter-value').css('width', count+"%");
			$this.find('.meter-text').text(count+"%");
			if(count == 100){
				clearInterval(inter);
				ex3running = false;	
				$("#lmapel").html(hsl);			
				$("#akhir").html("Penghapusan berhasil!");
			}
		}
		inter = setInterval(run, 50);
      }
    });

    $('#meter-ex4').click(function(){
      if(!ex4running){
        ex4running = true;
        var hsl = "";
        var $this = $(this);
        var count = 0;
        var inter = null;
        var dataString = "ajax=1";
        $.ajax({
				type: "POST",
				url: "pwww/p-resetlog.php",
				data: dataString,
				cache: false,
				success: function(data){
						hsl = data;			
				}
			});
        function run(){
			count++;
			$this.find('.meter-value').css('width', count+"%");
			$this.find('.meter-text').text(count+"%");
			if(count == 100){
				clearInterval(inter);
				ex4running = false;
				$("#log").html(hsl);
				$("#akhir").html("Penghapusan berhasil!");
			}
		}
		inter = setInterval(run, 50);
      }
    });

});
</script>
	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=ms'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>	
	<div class="cpanel">
		<h3>RESET PENGGUNA</h3>
		<?php
		$satuan = "KB";
		if ($upengguna>1024) {
			$upengguna = $upengguna / 1024;
			$satuan = "MB";
		}
		else if($upengguna>(1024*1024)){
			$upengguna = $upengguna / (1024*1024);
			$satuan = "GB";
		}
		?>	
		<div class="pdMeter">
			<div class="meter-wrap">
		    	<div class='meter-wrap' id='meter-ex1' style='cursor: pointer'>
		    		<div class='meter-value' style='background-color: #4DA4F3; width: 0%;'>
		        		<div class='meter-text'>
		            		Klik disni untuk hapus semua data pengguna!
		        		</div>		        		
		    		</div><label id="lpeserta">Total data: <?=$jpeserta;?> data , <?=ceil($upengguna);?> <?=$satuan;?></label>
	    		</div>
	    	</div>
	    </div>	   		
	</div>		
	<div class="cpanel">
		<h3>RESET PELAJARAN</h3>
		<?php
		$satuan = "KB";
		if ($utest>1024) {
			$utest = $utest / 1024;
			$satuan = "MB";
		}
		else if($utest>(1024*1024)){
			$utest = $utest / (1024*1024);
			$satuan = "GB";
		}
		?>	
		<div class="pdMeter">
			<div class="meter-wrap">
		    	<div class='meter-wrap' id='meter-ex2' style='cursor: pointer'>
		    		<div class='meter-value' style='background-color: #4DA4F3; width: 0%;'>
		        		<div class='meter-text'>
		            		Klik disni untuk hapus data test!
		        		</div>
		    		</div><label id="ltest">Total data: <?=$jtest;?> data , <?=ceil($utest);?> <?=$satuan;?></label>
	    		</div>
	    	</div>
	    </div>
	    <br><br>
	    <?php
	    $satuan = "KB";	    
	    if ($utPelajaran>1024) {
			$utPelajaran = $utPelajaran / 1024;
			$satuan = "MB";
		}
		if($utPelajaran>(1024*1024)){
			$utPelajaran = $utPelajaran / (1024*1024);
			$satuan = "GB";
		}
	    ?>
	    <div class="pdMeter">
			<div class="meter-wrap">
		    	<div class='meter-wrap' id='meter-ex3' style='cursor: pointer'>
		    		<div class='meter-value' style='background-color: #4DA4F3; width: 0%;'>
		        		<div class='meter-text'>
		            		Klik disni untuk hapus semua data pelajaran!
		        		</div>
		    		</div><label id="lmapel">Total data: <?=$jmapel;?> pelajaran , <?=ceil($utPelajaran);?> <?=$satuan;?></label>
	    		</div>
	    	</div>
	    </div>	   	   	
	</div>
	<div class="cpanel">
		<h3>RESET LOG</h3>	
		<?php	
		$satuan = "KB";	
	    if ($ulog>1024) {
			$ulog = $ulog / 1024;
			$satuan = "MB";
		}
		if($ulog>(1024*1024)){
			$ulog = $ulog / (1024*1024);
			$satuan = "GB";
		}
	    ?>
		<div class="pdMeter">
			<div class="meter-wrap">
		    	<div class='meter-wrap' id='meter-ex4' style='cursor: pointer'>
		    		<div class='meter-value' style='background-color: #4DA4F3; width: 0%;'>
		        		<div class='meter-text'>
		            		Hapus semua data log!
		        		</div>
		    		</div><label id="log">Total data: <?=$jlog;?> data , <?=ceil($ulog);?> <?=$satuan;?></label>
	    		</div>
	    	</div>
	    </div>	   	
	   <div class="cpanel">
			<div class="spasi"></div>
		</div>		
	</div>
	<div id="akhir"></div>
<?php 
	}
	else
	{
		echo "<div class='nm-list-section'>MENU TEST ".$br['nama_mapel']."</div>";
		echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR DI SALAH SATU SEKOLAH , HUBUNGI ADMIN</h3>";
	}
}
mysqli_close($db);
?>