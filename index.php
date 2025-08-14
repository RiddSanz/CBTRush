<?php
session_start();
ini_set("display_errors", "off");
include "pwww/validasi-sekolah.php";
include "pwww/get-browser.php";
include "pwww/version.php";
$qdes = "select * from t_ujian Limit 1";
$rsdes = mysqli_query($db,$qdes);
$brdes = mysqli_fetch_array($rsdes,MYSQLI_ASSOC);
$des = $brdes['desain'];

if($des=='2' && (!isset($_SESSION['user_nama']) || $_SESSION['user_nama']==NULL))
{
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
}
else
{


//echo $_SESSION['tingkat_user'];
if (isset($_GET['pg'])) {
	$hal = $_GET['pg'];
	$page = $_GET['pg'];
}
else{
	$hal = "awal";
	$page = "awal";
}
if (!isset($_SESSION['ipku'])) {
	include "pwww/check-ip.php";
	$_SESSION['ipku'] = $lip;
	$_SESSION['host'] = $lhip;
	$_SESSION['mac'] = $lmac;
}
$ua=getBrowser();

//$yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
//print_r($yourbrowser);
//echo $ua['userAgent'];

if (!isset($_SESSION['browser']) || $_SESSION['browser']=='' || $_SESSION['os']=='' || $_SESSION['system']=='') {
	$_SESSION['browser'] = $ua['name'];
	$_SESSION['os'] = $ua['platform'];

	/*if (strpos($ua['userAgent'],'Win') !== false) {
	    $sys = "Windows";
	}
	elseif(strpos($ua['userAgent'],'Android') !== false)
	{
		$sys = "Android";
	}
	else
	{
		$sys = "Linux";
	}*/
	$_SESSION['system'] = $ua['userAgent'];

}
//echo "Yang dipakai ".$_SESSION['system'];

date_default_timezone_set('Asia/Jakarta');
$timestamp = time();
$thn = date("Y",$timestamp);
$bln = date("m",$timestamp);
$hr = date("d",$timestamp);
$jm = date("H",$timestamp);
$min = date("i",$timestamp);
$sec = date("s",$timestamp);

$dtBln = array('01' => 1,'02' => 2,'03' => 3,'04' => 4,'05' => 5,'06' => 6,'07' => 7,'08' => 8,'09' => 9,'10' => 10,'11' => 11,'12' => 12);
if ($dtBln[$bln]<7) {
	$thnNew = ($thn-1)."/".$thn;
}
else
{
	$thnNew = $thn."/".($thn+1);
}

include "cek-dir.php";



?>
<!DOCTYPE html>
<html>
<head>
	<title>Computer based Test - <?=$sekNm;?></title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<meta http-equiv="Cache-control" content="public">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php /*
	<link rel="stylesheet" type="text/css" href="css/stylesheet-image-based.css">
	*/
	if(!isset($_SESSION['user_nama']))
	{
		?>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<?php
	}
	else{
		?>
		<link rel="stylesheet" type="text/css" href="css/style_b.css">
		<?php
	}
	?>

	<link rel="icon" type="image/png" href="logo/cbtIcon.png" />
	<script src="bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="bower_components/sweetalert2/dist/sweetalert2.min.css">
	<script src="js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<script type="text/javascript" src="js/popup-window.js"></script>
	<?php include "css/modal.css";?>
	<script src="js/cek.js"></script>
<style>
@media all and (min-width: 601px) {
	#nomorsoal
	{
		position:fixed;
		top:80px;
		right:20px;
		width:240px;
		z-index:1000;
	}

}
@media all and (max-width: 600px) {
	#nomorsoal
	{
		position:fixed;
    top:80px;
    right:20px;
    width:50%;
		z-index:1000;
	}
	#btnmenu{
		width:25px;
	}
	#btnmenu2{
		width:25px;
	}
	.namasekolah{
		display:none;
	}
}
	#ifsoal{
		height: 350px;
		background-color: #fff;
	}
	#pnote{
		-moz-border-radius: 6px;
     -webkit-border-radius: 6px;
     background-color: #f0f7fb;
     border: solid 1px #3498db;
     border-radius: 6px;
     line-height: 18px;
     overflow: hidden;
     padding: 15px;
	}
	</style>
</head>
<body>
	<?php
	if (!isset($_SESSION['soals'])) {
	?>
	<header>
		<div class="hword">
			<?php
			$logosek = "CBT.png";
			if (isset($_SESSION['trueValKey'])) {
				include "lib/configuration.php";
				$sql = "select * from t_ujian limit 1";

				$rs = mysqli_query($db,$sql);
				$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

				$logoS = $br['logo_sekolah'];
				$ww = $br['welcome_front'];
				if ($logoS=='') {
					$logosek = 'CBT.png';
				}
				else
				{
					$logosek = $logoS;
				}
				mysqli_close($db);
				echo '<img src="logo/'.$logosek.'" height="50px" align="absmiddle"> <span class="namasekolah">'.$sekNm.'</span>';
			}
			else
			{
				echo '<img src="logo/'.$logosek.'" height="50px" align="absmiddle"> SEKOLAH CONTOH SURABAYA';
			}
			?> <?php /*<sup><?=$thnNew;?></sup> */?>
		</div>
		<?php
		/*
		if (!isset($_SESSION['user_nama']) || $_SESSION['user_nama']==NULL) {
			##echo '<div class="headerdiv"><span class="tengah">APLIKASI UJIAN SEKOLAH</span></div>';
			?>
			<style type="text/css">
			header {
				display: none;
			}
			</style>
			<?
		}*/
		if (isset($_SESSION['user_nama']) || $_SESSION['user_nama']!=NULL) {
			include "pwww/bio-login.php";
		}
		?>

	</header>
	<?php
	}
	?>
	<article>
		<section>
			<div class="welcome" id="specialstuff">
				<?php
				if (isset($_SESSION['tingkat_user'])) {
					if($_SESSION['tingkat_user']!='2') {
					 	include "pwww/list-menu.php";
					}
					elseif($_SESSION['tingkat_user']=='2')
					{
						if ($hal=='chpass') {
							include "pwww/ch-password.php";
						}
						else{

							if (isset($_SESSION['wtfinish']) || isset($_SESSION['pidlock'])) {
								if (isset($_SESSION['wtfinish']) && $_SESSION['wtfinish']!=NULL && $_SESSION['wtfinish']!='') {
									include "swww/waktu-selesai.php";
									//echo "TESTING 2";
									//echo $_SESSION['wtfinish'];
									//include "pwww/list-ujian.php";
								}
								elseif(isset($_SESSION['pidlock'])){
									include "swww/logout.php";
								}
								else
								{
									$_SESSION['kdtest']=NULL;
									$_SESSION['wtfinish']=NULL;
									include "pwww/list-ujian.php";
								}
							}
							else
							{
								if(isset($_SESSION['soals']))
								{
									include "swww/f-cbt-test.php";
								}
								else
								{
									if (isset($_SESSION['kdtest']) && $_SESSION['kdtest']!='') {
										include "swww/fdt-validasi-test.php";
									}
									else
									{
										if($hal=='mulaiujian') {
											include "pwww/cek-ujian.php";
										}
										else if($hal=='nilaiku')
										{
											include "pwww/list-nilaiku.php";
										}
										else
										{
											include "pwww/list-ujian.php";
										}
									}
								}
							}
						}
					}
				}
				else{include "pwww/prakata.php";}
				$updatedb = "pwww/updatedb.txt";
				if (file_exists($updatedb)) {
					include "pwww/updatedb.php";
					unlink($updatedb);
				}
				?>
			</div>
			<div class="spasi"></div>
		</section>
		<?php
		//echo $page;
			if($_SESSION['tingkat_user']!='3' && !empty($_SESSION['user_nama'])) {
				$windowlebar = array("cpanel","users", "lsekolah", "lmapel", "infot","lsubmapel","lsub2mapel","kd","f-addkd","q","previewsoal",
					"f-addsoal","img-up","f-addpic","av-up","f-addav","faiken","fexcel","backupS","ltest","f-addtest","menutest","menutestq",
					"menutestp","analisaP","analisaPS","analisa-butir","dh","jadwalu","status","kartuP","ms","analisa-jawaban",
					"setip","dbR","setTM","sysmon","chpass","f-addusers","importusers","f-addmapel","f-picmapel","updater","kumpulanNilai","awal","nilaiku","rtoken"
					);
				//echo $hal;
				if (in_array($page, $windowlebar)) {
					?>
					<script>
					$(document).ready(function(){
						$("aside").hide();
						$("#nomorsoal").hide();
						$("#btnmenu2").hide();
						$("section").width('99%');
							$("body").on( "click", "#btnmenu", function (e){
									//$("aside").toggle();
									$("#nomorsoal").toggle();
									$("#btnmenu2").show();
									$("#btnmenu").hide();
									//$("section").width('78.125%');
							});
							$("body").on( "click", "#btnmenu2", function (e){
									//$("aside").toggle();
									$("#nomorsoal").toggle();
									$("#btnmenu").show();
									$("#btnmenu2").hide();
									//$("section").width('99%');
							});
					});
					</script>
					<?php
				}
			}

		 ?>
		<aside>
			<div class="login">
				<?php
					if(empty($_SESSION['user_nama']))
					{
					?>
						<div class="nm-list">LOGIN PESERTA</div>
					<?php
						include "pwww/login-form.php";
					}
					else {
						include "pwww/bio-peserta.php";

					 	if($_SESSION['tingkat_user']!='2') {
					 		include "pwww/panel-user.php";
					 	}
					 	if(isset($_SESSION['soals']) && !isset($_SESSION['wtfinish']))
					 	{
					 		if ($_SESSION['kdtest']!=NULL) {
					 			include "swww/iframe-nomor.php";
					 		}

					 	}
					 }

				?>
			</div>
			<?php
			/*
			if($_SESSION['tingkat_user']!='2') {
			?>
			<div class='login'>
				<?php include "pwww/panel-user.php";?>
			</div>
			<?php
			}
			*/
			?>
			<div class="spasi"></div>
			<div class="spasi"></div>
			<div class="spasi"></div>
		</aside>
		<div id="nomorsoal">
			<?php
			if(isset($_SESSION['soals']) && !isset($_SESSION['wtfinish']))
			{
				if ($_SESSION['kdtest']!=NULL) {
					include "swww/iframe-nomor.php";
				}

			}
			?>
		</div>
	</article>
	<?php
	if (!isset($_SESSION['soals'])) {
	?>
	<footer>
		<?php
		/*
		if (isset($_SESSION['tingkat_user']) && $_SESSION['tingkat_user']!='2') {
			?>
			<div class="wkt">
				<?php //include "time-server.php";?>
			</div>

			<?php
		}*/
		?>
		<?php include "pwww/info.php";?>
		CBTRush <?=$_SESSION['versicbt'];?> &copy;2015 <?=$sekNm;?> - <?=$almt;?>
		<span style="float:right;padding-right:20px;"><?=$ketF;?> -
			<?php
			if (isset($_SESSION['tingkat_user']) && $_SESSION['tingkat_user']!='2') {
				include "time-server.php";
			}
			?>
		</span>
	</footer>
	<?php
	}

	include "pwww/warning-lisensi.php";
	?>
</body>
</html>
<?php
}
?>
