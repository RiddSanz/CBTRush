<?php
include("../lib/configuration.php");
session_start();
if(isset($_POST['kd']))
{
	$idmapel=mysqli_real_escape_string($db,$_POST['idmapel']);
	$kd=mysqli_real_escape_string($db,$_POST['kd']);
	$jns_test = mysqli_real_escape_string($db,$_POST['jns_test']);
	$namatest=mysqli_real_escape_string($db,$_POST['namatest']);
	$waktutest=mysqli_real_escape_string($db,$_POST['waktutest']);
	$jumlahsoal=mysqli_real_escape_string($db,$_POST['jumlahsoal']);
	$tombolwaktu=mysqli_real_escape_string($db,$_POST['tombolselesai']);
	$tglmulai=mysqli_real_escape_string($db,$_POST['tglmulai']);
	$tglakhir=mysqli_real_escape_string($db,$_POST['tglakhir']);
	$tgltutup = $tglakhir;
	/*
	$tglakhir = new DateTime("$tglmulai");
	$tglakhir->add(new DateInterval('PT10H30S'));
	$tgltutup = $tglakhir->format('Y-m-d H:i:s');
	*/


	$soal_opsi=mysqli_real_escape_string($db,$_POST['soal_opsi']);
	$soal_esay=mysqli_real_escape_string($db,$_POST['soal_esay']);
	$soal_sulit = mysqli_real_escape_string($db,$_POST['soal_sulit']);
	$soal_sedang = mysqli_real_escape_string($db,$_POST['soal_sedang']);
	$soal_mudah = mysqli_real_escape_string($db,$_POST['soal_mudah']);
	$acak_soal = mysqli_real_escape_string($db,$_POST['acak_soal']);
	$acak_jawaban = mysqli_real_escape_string($db,$_POST['acak_jawaban']);
	$hasil_jawab = mysqli_real_escape_string($db,$_POST['hasil_jawab']);
	$bobot = mysqli_real_escape_string($db,$_POST['bobot']);

	$fedit=mysqli_real_escape_string($db,$_POST['fedit']);

	$oleh = $_SESSION['userid'];
	// time server
	$timestamp = time();
	$tgl = date("Y-m-d H:i:s",$timestamp);

	$t = date("Y-m-d H:i:s",$timestamp);
	//$dbdate_seconds = strtotime($fil['starting_date']);
	//$inputdate_seconds = strtotime($t);
	$rt = $waktutest*60*1000;
	$row_cnt = 0;
	//$time_diff = $dbdate_seconds - $inputdate_seconds;

	if (isset($_POST['fedit']) && $_POST['fedit']!='')
	{
		$sqlbobot= "select count(*) as data from t_hsl_test where idtest='$fedit'";
		$cekbobot=mysqli_query($db,$sqlbobot);
		$row_cnt = mysqli_fetch_array($cekbobot,MYSQLI_ASSOC);
		if($row_cnt['data'] > 0 && $bobot != 0)
		{
			$sql = "update t_test set kode_test='$kd', nama_test='$jns_test',waktu_test='$waktutest',
			jumlah_soal='$jumlahsoal',tingkat_test='$tombolwaktu', tgl_awal_test='$tglmulai', tgl_akhir_test='$tgltutup',
			soal_opsi='$soal_opsi',soal_esay='$soal_esay',acak_soal='$acak_soal',acak_jawaban='$acak_jawaban',
			soal_sulit='$soal_sulit',soal_sedang='$soal_sedang',soal_mudah='$soal_mudah',keterangan='$namatest',oleh='$oleh',publish_test_to_other='$hasil_jawab'
			where id='$fedit'
			";

			$result=mysqli_query($db,$sql);
			if($result)
			{
				echo "3";
			}
			else
			{
				echo "2";
			}
		}
		else {
			$sql = "update t_test set kode_test='$kd', nama_test='$jns_test',waktu_test='$waktutest',
			jumlah_soal='$jumlahsoal',tingkat_test='$tombolwaktu', tgl_awal_test='$tglmulai', tgl_akhir_test='$tgltutup',
			soal_opsi='$soal_opsi',soal_esay='$soal_esay',acak_soal='$acak_soal',acak_jawaban='$acak_jawaban',
			soal_sulit='$soal_sulit',soal_sedang='$soal_sedang',soal_mudah='$soal_mudah',keterangan='$namatest',oleh='$oleh',publish_test_to_other='$hasil_jawab',pembobotan='$bobot'
			where id='$fedit'
			";

			$result=mysqli_query($db,$sql);
			if($result)
			{
				echo "1";
			}
			else
			{
				echo "2";
			}
		}

	}
	else
	{
		$sql = "insert into t_test values('','$idmapel','$kd','$jns_test','$tglmulai',
			'$tgltutup','$waktutest','$jumlahsoal','$tombolwaktu','$hasil_jawab','$tgl','$oleh','0','0'
			,'$soal_opsi','$soal_esay','$acak_soal','$acak_jawaban',
			'$soal_sulit','$soal_sedang','$soal_mudah','$namatest','$bobot')";

			$result=mysqli_query($db,$sql);
			if($result)
			{
				echo "1";
			}
			else
			{
				echo "2";
			}
	}

}
mysqli_close($db);
?>
