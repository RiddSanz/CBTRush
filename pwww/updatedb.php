<?php
include "lib/configuration.php";

mysqli_query($db,"ALTER TABLE `t_peserta` ADD `ruang` VARCHAR(255) NOT NULL , ADD `agama` VARCHAR(255) NOT NULL");
mysqli_query($db,"ALTER TABLE `t_soal` ADD `opsi_esay` VARCHAR(1) NOT NULL DEFAULT '0'");
mysqli_query($db,"ALTER TABLE `t_soal` CHANGE `benar` `benar` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
mysqli_query($db,"ALTER TABLE `t_test_pertanyaan` ADD `tgl_pilih` DATETIME NOT NULL");
mysqli_query($db,"ALTER TABLE `t_hsl_test` ADD `nilai` VARCHAR(1) NOT NULL");
mysqli_query($db,"ALTER TABLE `t_test` ADD `soal_opsi` VARCHAR(3) NOT NULL DEFAULT '0', ADD `acak_soal` VARCHAR(1) NOT NULL DEFAULT '0', ADD `acak_jawaban` VARCHAR(1) NOT NULL DEFAULT '0', ADD `soal_sulit` VARCHAR(3) NOT NULL DEFAULT '0', ADD `soal_sedang` VARCHAR(3) NOT NULL DEFAULT '0', ADD `soal_mudah` VARCHAR(3) NOT NULL DEFAULT '0'");
mysqli_query($db,"ALTER TABLE `t_hsl_test` CHANGE `pilihan` `pilihan` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
mysqli_query($db,"ALTER TABLE `t_test` ADD `soal_esay` VARCHAR(3) NOT NULL AFTER `soal_opsi`");
mysqli_query($db,"ALTER TABLE `t_soal` ADD `point_soal` VARCHAR(2) NOT NULL DEFAULT '1' , ADD `tingkat_kesulitan` VARCHAR(1) NOT NULL DEFAULT '1'");
mysqli_query($db,"ALTER TABLE `t_test_pertanyaan` ADD `nomor` VARCHAR(10) NOT NULL");
mysqli_query($db,"ALTER TABLE `t_mapel` ADD `ket_mapel` VARCHAR(255) NOT NULL AFTER `jid`");
mysqli_query($db,"ALTER TABLE `t_mapel` ADD `kelas` VARCHAR(3) NOT NULL");
// copy data dari nama_mapel ke keterangan mapel
$confcp = "pwww/confcp.txt";
if (file_exists($confcp)) {
	$s = "select ket_mapel from t_mapel where ket_mapel=''";
	$r = mysqli_query($db,$s);
	$tc = mysqli_num_rows($r);
	if ($tc>10) {
		mysqli_query($db,"UPDATE `t_mapel` SET ket_mapel=nama_mapel where ket_mapel=''");
	}
	unlink($confcp);
}
// ------------------------------
$resetuser = "pwww/ruser.txt";
if (file_exists($resetuser)) {
	mysqli_query($db,"DELETE FROM `tryout`.`t_peserta` WHERE `t_peserta`.`pengguna` = 'cbtreset'");
	mysqli_query($db,"INSERT INTO t_peserta(pid,pengguna,kunci,nama_pengguna,kelompok,tingkat) values(2,'cbtreset','adminserver2018xxx','User Backup','admin','0')");
	unlink($resetuser);
}

mysqli_query($db,"ALTER TABLE `t_test` ADD `keterangan` VARCHAR(255) NOT NULL ");
mysqli_query($db,"ALTER TABLE `t_activity` ADD `log_cookie` VARCHAR(255) NOT NULL ");
mysqli_query($db,"ALTER TABLE `t_ujian` ADD `alamat` VARCHAR(255) NOT NULL , ADD `email` VARCHAR(255) NOT NULL , ADD `website` VARCHAR(255) NOT NULL ");
mysqli_query($db,"ALTER TABLE `t_kd` ADD `kd_sub` VARCHAR(255) NOT NULL AFTER `nama_kd`, ADD `kd_indikator` VARCHAR(255) NOT NULL AFTER `kd_sub`");
mysqli_query($db,"ALTER TABLE `t_test_peserta` ADD `acak_aktif` VARCHAR(255) NOT NULL ");
mysqli_query($db,"ALTER TABLE `t_peserta` ADD `sesi` VARCHAR(1) NOT NULL DEFAULT '1' ");
mysqli_query($db,"ALTER TABLE `t_ujian` ADD `judul_kartu` VARCHAR(255) NULL DEFAULT 'KARTU PESERTA UJIAN' ");
mysqli_query($db,"ALTER TABLE `t_test_peserta` ADD `first_login` DATETIME NOT NULL ");

mysqli_query($db,"CREATE OR REPLACE VIEW v_hsl_test AS (select `a`.`idpeserta` AS `idpeserta`,`a`.`idtest` AS `idtest`,sum(`a`.`nilai`) AS `score`,sum(`b`.`point_soal`) AS `tot_soal` from (`tryout`.`t_hsl_test` `a` join `tryout`.`t_soal` `b`) where (`a`.`idsoal` = `b`.`qid`) group by `a`.`idpeserta`,`a`.`idtest`)");
mysqli_query($db,"CREATE OR REPLACE VIEW v_butir_extend AS (select idsoal,isi_soal,benar,idtest, case when pilihan = 'a' then pilihan end as A, case when pilihan = 'b' then pilihan end as B, case when pilihan = 'c' then pilihan end as C, case when pilihan = 'd' then pilihan end as D, case when pilihan = 'e' then pilihan end as E, case when pilihan = 'x' then pilihan end as X from t_hsl_test , t_soal where qid=idsoal and opsi_esay='0' order by idsoal asc)");

#perubahan view agustus 2018
mysqli_query($db,"CREATE OR REPLACE VIEW v_test_siswa AS (select `a`.`id_test` AS `id_test`,`a`.`id_peserta` AS `id_peserta`,`a`.`soal_test` AS `soal_test`,`a`.`first_login` AS `first_login`,`a`.`last_login` AS `last_login`,`a`.`remaining_time` AS `remaining_time`,`a`.`still_login` AS `still_login`,`a`.`kunci_login` AS `kunci_login`,`a`.`browser_type` AS `browser_type`,`a`.`os_type` AS `os_type`,`a`.`system_type` AS `system_type`,`b`.`id` AS `id`,`b`.`idmapel` AS `idmapel`,`b`.`kode_test` AS `kode_test`,`b`.`nama_test` AS `nama_test`,`b`.`tgl_awal_test` AS `tgl_awal_test`,`b`.`tgl_akhir_test` AS `tgl_akhir_test`,`b`.`waktu_test` AS `waktu_test`,`b`.`jumlah_soal` AS `jumlah_soal`,`b`.`tingkat_test` AS `tingkat_test`,`b`.`publish_test_to_other` AS `publish_test_to_other`,`b`.`tgl_buat_test` AS `tgl_buat_test`,`b`.`oleh` AS `oleh`,`b`.`jumlah_peserta` AS `jumlah_peserta`,`b`.`total_soal_dicek` AS `total_soal_dicek`,`a`.`diselesaikan` AS `diselesaikan`,`b`.`soal_opsi` AS `soal_opsi`,`b`.`soal_esay` AS `soal_esay`,`b`.`soal_sulit` AS `soal_sulit`,`b`.`soal_sedang` AS `soal_sedang`,`b`.`soal_mudah` AS `soal_mudah`,`b`.`acak_soal` AS `acak_soal`,`b`.`acak_jawaban` AS `acak_jawaban`,`c`.`nama_mapel` AS `nama_mapel`,`c`.`ket_mapel` AS `ket_mapel`,`c`.`kelas` AS `kelas`,`b`.`keterangan` AS `keterangan`,`b`.`pembobotan` AS `pembobotan` from ((`tryout`.`t_test_peserta` `a` join `tryout`.`t_test` `b`) join `tryout`.`t_mapel` `c`) where ((`a`.`id_test` = `b`.`id`) and (`b`.`idmapel` = `c`.`mid`)) order by `b`.`tgl_awal_test`)");

#tambahan baru agustus-september 2017
mysqli_query($db,"ALTER TABLE `t_ujian` ADD `welcome_front` TEXT NOT NULL ");

#tambahan baru mei-agustus 2018
mysqli_query($db,"CREATE OR REPLACE VIEW rekap_hasil1 AS (SELECT idtest,idpeserta,count(idtest) as soal,coalesce(sum(nilai = '2'), 0) as benar,coalesce(sum(nilai = '-1'), 0) as salah,coalesce(sum(nilai = '0'), 0) as kosong,sum(nilai) as tnilai FROM `t_hsl_test` group by idtest,idpeserta order by idtest asc)");
mysqli_query($db,"CREATE TABLE IF NOT EXISTS `rekap_hasil` ( `idtest` varchar(255) NOT NULL,`idpeserta` varchar(255) NOT NULL,`tnilai` varchar(255) NOT NULL) ");
mysqli_query($db,"ALTER TABLE `rekap_hasil` ADD `soal` VARCHAR(255) NOT NULL AFTER `idpeserta`, ADD `benar` VARCHAR(255) NOT NULL AFTER `soal`, ADD `salah` VARCHAR(255) NOT NULL AFTER `benar`, ADD `kosong` VARCHAR(255) NOT NULL AFTER `salah`");
mysqli_query($db,"TRUNCATE TABLE `rekap_hasil`");
mysqli_query($db,"INSERT INTO rekap_hasil select * from rekap_hasil1");

#tambahan baru agustus 2018
mysqli_query($db,"ALTER TABLE `t_test` ADD `pembobotan` VARCHAR(1) NOT NULL DEFAULT '0'");
mysqli_query($db,"ALTER TABLE `t_hsl_test` CHANGE `nilai` `nilai` VARCHAR(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
mysqli_query($db,"ALTER TABLE `temp_t_hsl_test` CHANGE `nilai` `nilai` VARCHAR(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");

#oktober 2018
mysqli_query($db,"ALTER TABLE `t_soal` CHANGE `isi_soal` `isi_soal` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `pilihan1` `pilihan1` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `pilihan2` `pilihan2` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `pilihan3` `pilihan3` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `pilihan4` `pilihan4` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `pilihan5` `pilihan5` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;");
mysqli_query($db,"ALTER TABLE `t_hsl_test` ADD `nomor` INT(2) NOT NULL") ;
mysqli_query($db,"ALTER TABLE `temp_t_hsl_test` ADD `nomor` INT(2) NOT NULL") ;
#update 2019 desember
mysqli_query($db,"ALTER TABLE `t_test` CHANGE `tingkat_test` `tingkat_test` VARCHAR(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0'") ;
#update mei 2021
mysqli_query($db,"ALTER TABLE `t_ujian` ADD `desain` VARCHAR(1) NOT NULL DEFAULT '1' AFTER `welcome_front`") ;

mysqli_close($db);
?>
