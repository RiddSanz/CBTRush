<?php
include "lib/configuration.php";
$pid = $_SESSION['userid'];
$id=mysqli_real_escape_string($db,$_GET['s']);
if ($pid=='admin') {
	$sql = "select * from t_mapel where mid='$id' limit 1";
}
else
{
	$sql = "select * from t_mapel where mid='$id' and oleh='".$pid."' limit 1";
}

$sekolahku = strtolower($_SESSION['namaSEKOLAH']);
	if(strpos($sekolahku, 'smp') !== false)
	{
		$statusSMP = true;
	}
	elseif(strpos($sekolahku, 'mts') !== false)
	{
		$statusSMP = true;
	}
	else
	{
		$statusSMP = false;
	}

//echo $sql;
$rs = mysqli_query($db,$sql);
$jdata = mysqli_num_rows($rs);
if ($jdata==0) {
	?>
	<h1>MOHON MAAF ANDA MENCOBA UNTUK MELAKUKAN KEGIATAN YANG BERBAHAYA!</h1>
	<?php //echo "<meta http-equiv='refresh' content='0;url=index.php?pg=lsubmapel'>";
}
else{
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$ket_mapel = $br['ket_mapel'];
	$kelas = $br['kelas'];
	$_SESSION['idmapel']=$br['mid'];
	$_SESSION['mapelnya']=$br['nama_mapel'];
	$_SESSION['ketmapelnya']=$br['ket_mapel'];
	$_SESSION['fdata'] = '';
	$_SESSION['fdata2'] = '';
	$_SESSION['fkelas']=NULL;
	$_SESSION['fruang']=NULL;
	$_SESSION['ftest']=NULL;
	//$file_name = trim($ket_mapel)."".trim($kelas);
	$file_name = trim(substr($ket_mapel, 0,50 )).trim($kelas);
	//echo $file_name;
	if(file_exists(''.$file_name.'.zip')){

	    unlink(''.$file_name.'.zip');
	}

	//if(file_exists('mapel/'.$br['nama_mapel'].'/'.$file_name.'.dat')){
	    //unlink('mapel/'.$br['nama_mapel'].'/'.$file_name.'.dat');
	    array_map('unlink', glob('mapel/'.$br['nama_mapel'].'/*.dat'));
	//}
	//echo 'mapel/'.$file_name.'/'.$file_name.'.dat';
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
	<script>
	$(document).ready(function(){
		$("aside").hide();
		$("section").width('99%');
			$("btmenu").click(function(){
					$("aside").toggle();
			});
	});
	</script>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=strtoupper($br['kelas']." ".$br['ket_mapel']);?></a></li>
		</ul>
		<div class="cpanel">
			<h3>LAYANAN UMUM</h3>
			<div class="cpanelMenu" onclick="window.location='?pg=kd'">
				<img src="images/kd.png" height="100" width="100" onclick="window.location='?pg=lsubmapel'"/>
				<center>UNIT KD</center>
			</div>
			<div class="cpanelMenu" onclick="window.location='?pg=q'">
				<img src="images/quiz_bank.png" width="100"/> <center>Bank Soal</center>
			</div>
			<div class="cpanelMenu" onclick="window.location='?pg=img-up'">
				<img src="images/pictures_folder.png" height="100" width="100"/> <center>File Gambar</center>
			</div>
			<?php
			if($statusSMP==false){
			?>
			<div class="cpanelMenu" onclick="window.location='?pg=av-up'">
				<img src="images/IconAudio.png" height="100" width="100"/> <center>File Audio Video</center>
			</div>
			<?php
			}
			?>
			<div class="cpanelMenu" onclick="window.location='?pg=faiken'">
				<img src="images/rich_text_format.png" height="100" width="100"/> <center>Upload soal format Notepad</center>
			</div>
			<div class="cpanelMenu" onclick="window.location='?pg=fexcel'">
				<img src="images/Excel-icon.png" height="100" width="100"/> <center>Upload soal format excel</center>
			</div>
			<div class="cpanelMenu" onclick="window.location='?pg=backupS&s=<?=$id;?>'">
				<img src="images/icon-backup.png" height="100" width="100"/> <center>Backup dan Restore</center>
			</div>
		</div>
		<div class="cpanel">
			<div class="spasi"></div>
		</div>
		<div class="cpanel">
			<h3>LAYANAN KHUSUS</h3>
			<div class="cpanelMenu" onclick="window.location='?pg=ltest'">
				<img src="images/addexam.png" height="100" width="100"/> <center>Buat Test</center>
			</div>
			<?PHP /*?>
			<div class="cpanelMenu" onclick="window.location='?pg=laporant'">
				<img src="images/printer1.png" height="100" width="100"/> <center>Cetak semua hasil test</center>
			</div>
			<?php */?>
			<div class="cpanelMenu" onclick="window.location='?pg=analisaP'">
				<img src="images/numbers.png" height="100" width="100"/> <center>Hasil Test</center>
			</div>
			<?PHP /*?>
			<div class="cpanelMenu" onclick="window.location='?pg=rata2Nilai'">
				<img src="images/sum.png" height="100" width="100"/> <center>Rata-rata Nilai</center>
			</div>
			<?php */?>
			<div class="cpanelMenu" onclick="window.location='?pg=analisa-butir'">
				<img src="images/abc.jpg" height="100" width="100"/> <center>Analisa soal</center>
			</div>
			<div class="cpanelMenu" onclick="window.location='?pg=analisa-jawaban'">
				<img src="images/ans_jwb.png" height="100" width="100"/> <center>Analisa Jawaban</center>
			</div>
			<div class="cpanelMenu" onclick="window.location='?pg=dh'">
				<img src="images/anteriores.png" height="100" width="100"/> <center>Daftar Hadir &<br>Berita Acara</center>
			</div>
		</div>

		<div class="cpanel">
			<div class="spasi"></div>
		</div>
	<?php
		}else{echo "<div class='nm-list-section'>MENU TEST ".$br['nama_mapel']."</div>";echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR DI SALAH SATU SEKOLAH , HUBUNGI ADMIN</h3>";}
		require_once "pwww/p_enc.php";if(enc($_SESSION['trueValKey'])!=($_SESSION['sid_user'].$_SESSION['namaSEKOLAH'])) {include "pwww/logout.php";}
		if(!file_exists('mapel/'.$br['nama_mapel'].'/index.html')){
	        $fileindex= '
	        <style>
	        .error-template {padding: 40px 15px;text-align: center;}
			.error-actions {margin-top:15px;margin-bottom:15px;}
			.error-actions .btn { background:1px solid blue;color:#fff;margin-right:10px; }
	        </style>
	        	<div class="container">
				    <div class="row">
				        <div class="col-md-12">
				            <div class="error-template">
				                <h2>
				                    404 Not Found</h2>
				                <div class="error-details">
				                    Sorry, an error has occured, Requested page not found!
				                </div>
				                <div class="error-actions">
				                    <a href="index.php" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
				                        Back To Home </a>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
	        ';
					$filename = "mapel/" . $br['nama_mapel'] . "/";

					if (!file_exists($filename)) {
					    mkdir("mapel/" . $br['nama_mapel'], 0777);
					    echo "The directory $dirname was successfully created.";
					    exit;
					} else {
					    echo "The directory $dirname exists.";
					}

	        $indexfile = "mapel/".$br['nama_mapel']."/index.html";

	        $ourFileHandle = fopen($indexfile, 'w') or die("can't open file");
	        # Now UTF-8 - Add byte order mark
	        fwrite($ourFileHandle, pack("CCC",0xef,0xbb,0xbf));
	        $ck = fwrite($ourFileHandle, $fileindex);
	        fclose($ourFileHandle);
	        if ($ck) {
	            echo "sukses";
	        }
	        else{
	            echo "$ck";
	        }
	    }
	}
	mysqli_close($db);
}
?>
