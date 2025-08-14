<?php
include "pwww/list-iconmenu.php";
$site1 = "CPANEL";
$site2 = "";
$site3 = "";
$site4 = "";
$site5 = "";
$site6 = "";
$site7 = "";

if($hal=="awal")
{
	//include "pwww/prakata.php";
	$site2 = "CBTRUSH";
	include "pwww/cpanel-user.php";
}
elseif($hal == "cpanel")
{
	$site2 = "CBTRUSH";
	include "pwww/cpanel-user.php";
}
elseif($hal == "lsekolah")
{
	$site2 = "SEKOLAH";
	include "pwww/lists-sekolah.php";
}
elseif($hal == "f-addsekolah")
{
	$site2 = "SEKOLAH";
	$site3 = "TAMBAH SEKOLAH";
	include "pwww/f-addsekolah.php";
}
elseif($hal=="fvalKey")
{
	$site2 = "SEKOLAH";
	$site3 = "VALKEY SEKOLAH";
	include "pwww/f-valKey.php";
}
elseif ($hal=='keluar') {
	include "pwww/logout.php";
}
if (isset($_SESSION['trueValKey'])) {
	if($_SESSION['valid']==true)
	{
		if($hal == "users")
		{
			$site2 = "PENGGUNA";
			include "pwww/lists-user.php";
		}
		elseif($hal == "importusers")
		{
			$site2 = "PENGGUNA";
			$site3 = "IMPORT PENGGUNA";
			include "pwww/aiken-users.php";
		}
		elseif($hal == "f-addusers")
		{
			$site2 = "PENGGUNA";
			if (!empty($_GET['s'])) {
				$site3 = "KELOLA PENGGUNA";
			}
			else
			{
				$site3 = "TAMBAH PENGGUNA";
			}
			include "pwww/f-addusers.php";
		}
		elseif($hal == "lmapel")
		{
			$site2 = "MASTER PELAJARAN";
			include "pwww/lists-mapel.php";
		}
		elseif($hal == "f-addmapel")
		{
			$site2 = "MASTER PELAJARAN";
			if (!empty($_GET['s'])) {
				$site3 = "KELOLA PELAJARAN";
			}
			else
			{
				$site3 = "TAMBAH PELAJARAN";
			}
			include "pwww/f-addmapel.php";
		}
		elseif($hal == "f-picmapel")
		{
			$site2 = "MASTER PELAJARAN";
			$site3 = "ICON ";
			include "pwww/f-uploadmapelpic.php";
		}
		elseif($hal == "infot")
		{
			$site2 = "INFO TAMBAHAN";
			include "pwww/lists-info.php";
		}
		elseif($hal == "jadwalu")
		{
			$site2 = "JADWAL UJIAN";
			include "pwww/jadwal-ujian.php";
		}
		elseif($hal == "kumpulanNilai")
		{
			$site2 = "KUMPULAN NILAI UJIAN";
			include "pwww/kumpulan-nilai.php";
		}
		elseif($hal == "lsubmapel")
		{
			$site2 = "SETING UJIAN";
			include "pwww/lsub-mapel.php";
		}
		elseif($hal == "lsub2mapel")
		{
			$site2 = "SETING UJIAN";
			include "pwww/lsub2-mapel.php";
		}
		elseif($hal == "kd")
		{
			$site2 = "SETING UJIAN";
			$site3 = "UNIT KD";
			include "pwww/lists-kd.php";
		}
		elseif($hal == "f-addkd")
		{
			$site2 = "SETING UJIAN";
			$site3 = "UNIT KD";
			if (!empty($_GET['s'])) {
				$site4 = "KELOLA KD";
			}
			else
			{
				$site4 = "TAMBAH KD";
			}
			include "pwww/f-addkd.php";
		}
		elseif($hal == "q")
		{
			$site2 = "SETING UJIAN";
			$site3 = "BANK SOAL";
			include "pwww/lists-questions.php";
		}
		elseif($hal == "f-addsoal")
		{
			$site2 = "SETING UJIAN";
			$site3 = "BANK SOAL";
			if (!empty($_GET['s'])) {
				$site4 = "KELOLA PERTANYAAN";
			}
			else
			{
				$site4 = "TAMBAH PERTANYAAN";
			}
			include "pwww/f-addsoal.php";
		}
		elseif($hal == "previewsoal")
		{
			$site2 = "SETING UJIAN";
			$site3 = "BANK SOAL";
			$site4 = "PREVIEW PERTANYAAN";
			include "pwww/preview-pertanyaan.php";
		}
		elseif($hal == "img-up")
		{
			$site2 = "SETING UJIAN";
			$site3 = "FILE GAMBAR";
			include "pwww/list-images.php";
		}
		elseif($hal == "av-up")
		{
			$site2 = "SETING UJIAN";
			$site3 = "FILE AUDIO VIDEO";
			include "pwww/list-audiovideo.php";
		}
		elseif($hal == "f-addpic")
		{
			$site2 = "SETING UJIAN";
			$site3 = "FILE GAMBAR";
			$site4 = "TAMBAH GAMBAR";
			include "pwww/f-addpic.php";
		}
		elseif($hal == "f-addav")
		{
			$site2 = "SETING UJIAN";
			$site3 = "FILE AUDIO VIDEO";
			$site4 = "TAMBAH FILE AUDIO VIDEO";
			include "pwww/f-addav.php";
		}
		elseif($hal == "faiken")
		{
			$site2 = "SETING UJIAN";
			$site3 = "IMPORT FORMAT NOTEPAD";
			include "pwww/aiken-question.php";
		}
		elseif($hal == "fexcel")
		{
			$site2 = "SETING UJIAN";
			$site3 = "IMPORT FORMAT EXCEL";
			include "pwww/aiken-excel.php";
		}
		elseif($hal == "ltest")
		{
			$site2 = "SETING UJIAN";
			$site3 = "DAFTAR TEST";
			include "pwww/lists-test.php";
		}
		elseif($hal == "f-addtest")
		{
			$site2 = "SETING UJIAN";
			$site3 = "DAFTAR TEST";
			if (!empty($_GET['s'])) {
				$site4 = "UBAH TEST";
			}
			else
			{
				$site4 = "BUAT TEST BARU";
			}
			include "pwww/f-addtest.php";
		}
		elseif($hal == "menutest")
		{
			$site2 = "SETING UJIAN";
			$site3 = "DAFTAR TEST";
			$site4 = "KELOLA TEST ";
			include "pwww/menu-test.php";
		}
		elseif($hal == "menutestq")
		{
			$site2 = "SETING UJIAN";
			$site3 = "DAFTAR TEST";
			$site4 = "KELOLA TEST ";
			$site5 = "PILIH SOAL ";
			include "pwww/pilih-questions.php";
		}
		elseif($hal == "menutestp")
		{
			$site2 = "SETING UJIAN";
			$site3 = "BUAT TEST";
			$site4 = "KELOLA TEST ";
			$site5 = "PILIH PESERTA ";
			include "pwww/pilih-peserta.php";
		}
		elseif($hal == "laporant")
		{
			$site2 = "SETING UJIAN";
			$site3 = "LAPORAN HASIL TEST";
			include "pwww/iframe-report-hasil-test.php";
		}
		elseif($hal == "laporantU")
		{
			$site2 = "SETING UJIAN";
			$site3 = "LAPORAN HASIL TEST USER";
			include "pwww/iframe-report-hasil-testU.php";
		}
		elseif($hal == "analisaP")
		{
			$site2 = "SETING UJIAN";
			$site3 = "HASIL TEST";
			include "pwww/lists-analisa.php";
		}
		elseif($hal == "analisaPS")
		{
			$site2 = "SETING UJIAN";
			$site3 = "HASIL TEST";
			$site4 = "HISTORY TEST";
			include "pwww/show-history-test.php";
		}
		elseif($hal == "analisa-butir")
		{
			$site2 = "SETING UJIAN";
			$site3 = "ANALISA BUTIR SOAL";
			include "pwww/analisa-butirsoal.php";
		}
		elseif($hal == "analisa-jawaban")
		{
			$site2 = "SETING UJIAN";
			$site3 = "ANALISA JAWABAN SISWA";
			include "pwww/lists-analisajawaban.php";
		}
		elseif($hal == "dh")
		{
			$site2 = "SETING UJIAN";
			$site3 = "BERITA ACARA DAN DAFTAR HADIR";
			include "pwww/daftar-hadir.php";
		}
		elseif($hal == "backupS")
		{
			$site2 = "SETING UJIAN";
			$site3 = "BACKUP DAN RESTORE";
			include "pwww/list-backup.php";
		}
		elseif($hal == "rata2Nilai")
		{
			include "pwww/list-rata2nilai.php";
		}
		elseif($hal == "rtoken")
		{
			$site2 = "RILIS TOKEN";
			include "pwww/rilis-token.php";
		}
		elseif($hal == "status")
		{
			$site2 = "STATUS PENGGUNA";
			include "pwww/status-user.php";
		}
		elseif($hal == "kartuP")
		{
			$site2 = "KARTU PESERTA";
			include "pwww/iframe-kartu-peserta.php";
		}
		elseif($hal=='chpass') {
			$site2 = "GANTI PASSWORD";
			include "pwww/ch-password.php";
		}
		elseif($hal=='ms') {
			$site1 = "MENU SYSTEM";
			$site2 = "CBTRUSH";
			include "pwww/ms-panel.php";
		}
		elseif($hal=='updater') {
			$site1 = "UPDATER";
			$site2 = "CBTRUSH";
			include "pwww/list-update.php";
		}
		elseif($hal=='setip') {
			$site1 = "MENU SYSTEM";
			$site2 = "IP ADDRESS";
			include "pwww/f-read-ip.php";
		}
		elseif($hal=='psetip') {
			include "pwww/p-write-ip.php";
		}
		elseif($hal=='setTM') {
			$site1 = "MENU SYSTEM";
			$site2 = "SETING WAKTU";
			include "pwww/f-read-waktu.php";
		}
		elseif($hal=='restart') {
			include "pwww/p-restart.php";
		}
		elseif($hal=='matikan') {
			include "pwww/p-shutdown.php";
		}
		elseif($hal=='sysmon') {
			$site1 = "MENU SYSTEM";
			$site2 = "MONITORING LOGIN";
			include "pwww/lists-activity.php";
		}
		elseif($hal=='dbR') {
			$site1 = "MENU SYSTEM";
			$site2 = "RESET DATABASE";
			include "pwww/lists-dbreset.php";
		}

	}
    else
    {
		echo "MAAF LISENSI TELAH BERAKHIR";
    }
}
?>
