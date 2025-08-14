<?php
include "../lib/configuration.php";
session_start();
$oleh = $_SESSION['userid'];

$timestamp = time();
$tgl = date("Y-m-d H:i:s",$timestamp);

$id = $_SESSION['idmapel'];;
$sql = "select * from t_mapel where mid='$id' limit 1";
$rs = mysqli_query($db,$sql);
$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
$_SESSION['idmapel']=$br['mid'];
$nmp = $br['nama_mapel'];
$namefolder= 'mapel/'.$nmp;
	if(isset($_POST['nameupload'])) {
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {
			/*read file*/
			$temp ='';
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			if ($handle) {
				while ($baris = fgets($handle, 4096)) {
					$temp .= $baris;
				}
			} else {
				die ("Cannot read the file");
			}
		} else {
			die ("File not uploaded");
		}
		//$arr = unserialize(urldecode($temp));

		//echo "$temp";
		//$arr = base64_decode($temp);
		$arr = unserialize(base64_decode($temp));
		//var_dump($arr);
		//echo count($arr);
		$nilai = 0;
		for ($i=0; $i < count($arr); $i++) {
			$question = $arr[$i]['q'];
			$a = $arr[$i]['a'];
			$b = $arr[$i]['b'];
			$c = $arr[$i]['c'];
			$d = $arr[$i]['d'];
			$e = $arr[$i]['e'];
			$benar = $arr[$i]['ans'];
			$opsi_esay = $arr[$i]['opsi_esay'];
            $point_soal = $arr[$i]['point_soal'];
            $tingkat_kesulitan = $arr[$i]['tingkat_kesulitan'];

			/* untuk mendapatkan source image*/
            preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $question , $rsl);
            if (isset($rsl[1])) {
                list($f,$m,$im)=explode("/",$rsl[1]);
                //echo $rsl[1];
                $nf = $namefolder.'/'.strtolower($im);
                $question = str_replace($rsl[1], $nf, $question);
            }

            preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $a , $rsl);
            if (isset($rsl[1])) {
                list($f,$m,$im)=explode("/",$rsl[1]);
                $nf = $namefolder.'/'.strtolower($im);
                $a = str_replace($rsl[1], $nf, $a);
            }
            preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $b , $rsl);
            if (isset($rsl[1])) {
                list($f,$m,$im)=explode("/",$rsl[1]);
                $nf = $namefolder.'/'.strtolower($im);
                $b = str_replace($rsl[1], $nf, $b);
            }
            preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $c , $rsl);
            if (isset($rsl[1])) {
                list($f,$m,$im)=explode("/",$rsl[1]);
                $nf = $namefolder.'/'.strtolower($im);
                $c = str_replace($rsl[1], $nf, $c);
            }
            preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $d , $rsl);
            if (isset($rsl[1])) {
                list($f,$m,$im)=explode("/",$rsl[1]);
                $nf = $namefolder.'/'.strtolower($im);
                $d = str_replace($rsl[1], $nf, $d);
            }
            preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $e , $rsl);
            if (isset($rsl[1])) {
                list($f,$m,$im)=explode("/",$rsl[1]);
                $nf = $namefolder.'/'.strtolower($im);
                $e = str_replace($rsl[1], $nf, $e);
            }


			$sql = "insert into t_soal values('','$question','$a','$b','$c','$d','$e',
				'$benar','','$id','$tgl','$oleh','$opsi_esay','$point_soal',
				'$tingkat_kesulitan')";
			$result=mysqli_query($db,$sql);
			if ($result) {
				$nilai++;
			}
			//echo $sql;

		}
		mysqli_close($db);
		echo "$nilai,".count($arr);
	}
?>
