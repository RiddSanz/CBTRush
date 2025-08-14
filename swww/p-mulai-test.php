<?php
include "../lib/configuration.php";
session_start();
include "tgl.php";

$pid = $_SESSION['pid'];
$kdtest = $_SESSION['kdtest'];
if (isset($_GET['itoken']) && $_GET['itoken']!='')
{
	$itoken=mysqli_real_escape_string($db,$_GET['itoken']);

	$sql = "select * from v_test_siswa where id_peserta='$pid' and id_test='$kdtest' limit 1";
	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	$jmlsoal = $br['jumlah_soal'];
	$durasi = $br['waktu_test'];
	$rtime= $br['remaining_time'];
	$tgl2 = $br['tgl_akhir_test'];
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
	$angka = $rtime/60;

	$s = "select * from t_test where id='$kdtest' limit 1";
	$r = mysqli_query($db,$s);
	$b = mysqli_fetch_array($r,MYSQLI_ASSOC);
	$ts = $b['tingkat_test'];
	$soal_opsi = $b['soal_opsi'];
	$soal_esay = $b['soal_esay'];
	$soal_sulit = $b['soal_sulit'];
	$soal_sedang = $b['soal_sedang'];
	$soal_mudah = $b['soal_mudah'];
	$acak_soal = $b['acak_soal'];
	$acak_jawaban = $b['acak_jawaban'];
	$idmapel = $b['idmapel'];

	$cek = ( $angka < $ts )?'ok':'no';
	//echo "hasil :" .$cek;
	if($cek == 'ok')
	{
		$_SESSION['tminus'] = true;
	}
	else
	{
		$_SESSION['tminus'] = false;
	}

	// cek jumlah soal di bank soal
	$susah = 0;
	$sedang = 0;
	$gampang = 0;
	$tmp = 0;
	$tmp2 = 0;
	$smapel = "select count(*) as jm,tingkat_kesulitan as tk from t_soal where id_mapel='$idmapel' and opsi_esay='0' group by tingkat_kesulitan";
	$rmapel = mysqli_query($db,$smapel);
	while ( $bmapel = mysqli_fetch_array($rmapel,MYSQLI_ASSOC)) {
		$tmp = $bmapel['jm'];
		$tmp2 = $bmapel['tk'];
		if ($tmp2=='3') {
			$susah = $tmp;
		}
		if ($tmp2=='2') {
			$sedang = $tmp;
		}
		if ($tmp2=='1') {
			$gampang = $tmp;
		}
	}

	if ($susah == 0 || $susah == '') {
		$soal_sulit = 0;
	}
	else
	{
		if ($susah<$soal_sulit) {
			$soal_sulit = $susah;
		}
	}

	if ($sedang == 0 || $sedang =='') {
		$soal_sedang = 0;
	}
	else
	{
		if ($sedang<$soal_sedang) {
			$soal_sedang = $sedang;
		}
	}

	if ($gampang == 0|| $gampang =='') {
		$soal_mudah = 0;
	}
	else
	{
		if ($gampang<$soal_mudah) {
			$soal_mudah = $gampang;
		}

	}

	$soalakhir = $soal_mudah + $soal_sulit + $soal_sedang;
	if ($soalakhir <= $soal_opsi-1) {
		$soal_mudah = $soal_opsi - ($soal_sulit + $soal_sedang);
	}

	if ($acak_jawaban=='1') {
		$_SESSION['acjwb']='1';
	}
	else
	{
		$_SESSION['acjwb']='0';
	}

	if ($br['soal_test']=='')
	{
		/* --------------fungsi untuk create soal ----------------*/
			/*soal opsi = 0 , soal esay = 1*/
		if ($acak_soal=='1') {
			$srand = '';
			# acak soal #
			/*soal sulit */
			$srand .= "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='0' and tingkat_kesulitan='3' order by rand() limit $soal_sulit)";
			$srand .= " UNION ";
			/*soal sedang */
			$srand .= "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='0' and tingkat_kesulitan='2' order by rand() limit $soal_sedang)";
			/*soal mudah */
			$srand .= " UNION ";
			$srand .= "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='0' and tingkat_kesulitan='1' order by rand() limit $soal_mudah)";
			/* soal esay*/
			$srand .= " UNION ";
			$srand .= "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='1' order by rand() limit $soal_esay)";

		}
		else
		{
			/*soal sulit */
			$srand = "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='0' and tingkat_kesulitan='3' order by a.id_soal asc limit $soal_sulit)";
			/*soal sedang */
			$srand .= " UNION ";
			$srand .= "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='0' and tingkat_kesulitan='2' order by a.id_soal asc limit $soal_sedang)";
			/*soal mudah */
			$srand .= " UNION ";
			$srand .= "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='0' and tingkat_kesulitan='1' order by a.id_soal asc limit $soal_mudah)";
			/* soal esay*/
			$srand .= " UNION ";
			$srand .= "(select DISTINCT a.id_soal AS idsoal from t_test_pertanyaan a,t_soal b where a.id_soal=b.qid and a.id_test='$kdtest' and b.opsi_esay='1' order by a.id_soal asc limit $soal_esay)";

		}
			//echo $srand;
			$datasoal = array();
			$rsrand = mysqli_query($db,$srand);
			while ( $brand = mysqli_fetch_array($rsrand,MYSQLI_ASSOC)) {
				$datasoal[] = $brand['idsoal'];
			}

			for ($i=0; $i < count($datasoal) ; $i++) {
				$insert_soal = "insert into t_hsl_test values(
					'$kdtest','".$datasoal[$i]."','$pid','x','','0','".$i."')";
				mysqli_query($db,$insert_soal);
			}

			$soals = serialize($datasoal);
			/*
			$s = "update t_test_peserta set soal_test='$soals',remaining_time='$rtime',last_login='$tgl',still_login='1' where id_test='$kdtest' and id_peserta='$pid' limit 1";
			*/
			$s = "update t_test_peserta set soal_test='$soals',remaining_time='$rtime',last_login='$tgl',first_login='$tgl' where id_test='$kdtest' and id_peserta='$pid' limit 1";
			$r = mysqli_query($db,$s);
			if ($r) {
				$_SESSION['soals'] = $datasoal;
				mysqli_close($db);
				echo '1';
				//echo $srand;
			}
			else
			{
				mysqli_close($db);
				echo '2';
				//echo $srand;
			}
	}
	else
	{
		/*
		$stime = "update t_test_peserta set last_login='$tgl',still_login='1' where id_test='$kdtest' and id_peserta='$pid' limit 1";
		*/
		$stime = "update t_test_peserta set last_login='$tgl' where id_test='$kdtest' and id_peserta='$pid' limit 1";
		$rstime = mysqli_query($db,$stime);

		$s = "select soal_test from t_test_peserta where id_test='$kdtest' and id_peserta='$pid' limit 1";
		$r = mysqli_query($db,$s);
		$b = mysqli_fetch_array($r,MYSQLI_ASSOC);
		if ($r) {
			$_SESSION['soals'] = unserialize($b['soal_test']);
			mysqli_close($db);
			echo '1';
		}
		else
		{
			mysqli_close($db);
			echo '2';
		}
	}
}
else
{
	mysqli_close($db);
	echo "4";
}
?>
