-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2015 at 09:54 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tryout`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `hsl_score_akhir`
--
CREATE TABLE IF NOT EXISTS `hsl_score_akhir` (
`pid` bigint(15)
,`pengguna` varchar(50)
,`kunci` varchar(255)
,`nama_pengguna` varchar(255)
,`kelompok` varchar(50)
,`tingkat` varchar(1)
,`sekolah` varchar(255)
,`oleh` varchar(255)
,`kode_test` varchar(255)
,`nama_test` varchar(255)
,`tgl_awal_test` datetime
,`tgl_akhir_test` datetime
,`waktu_test` varchar(255)
,`jumlah_soal` varchar(255)
,`idpeserta` varchar(255)
,`idtest` varchar(255)
,`score` decimal(23,0)
,`tot_soal` bigint(21)
,`idmapel` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `kor_vtest_ttest`
--
CREATE TABLE IF NOT EXISTS `kor_vtest_ttest` (
`kode_test` varchar(255)
,`nama_test` varchar(255)
,`tgl_awal_test` datetime
,`tgl_akhir_test` datetime
,`waktu_test` varchar(255)
,`jumlah_soal` varchar(255)
,`idpeserta` varchar(255)
,`idtest` varchar(255)
,`score` decimal(23,0)
,`tot_soal` bigint(21)
,`idmapel` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `t_hsl_test`
--

CREATE TABLE IF NOT EXISTS `t_hsl_test` (
  `idtest` varchar(255) NOT NULL,
  `idsoal` varchar(255) NOT NULL,
  `idpeserta` varchar(255) NOT NULL,
  `pilihan` varchar(1) NOT NULL,
  `tgl_submit` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_image`
--

CREATE TABLE IF NOT EXISTS `t_image` (
  `id` bigint(15) NOT NULL,
  `id_mapel` bigint(15) NOT NULL,
  `nama_image` varchar(255) NOT NULL,
  `besar` varchar(255) NOT NULL,
  `tgl` datetime NOT NULL,
  `oleh` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_jurusan`
--

CREATE TABLE IF NOT EXISTS `t_jurusan` (
  `jid` int(11) NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_jurusan`
--

INSERT INTO `t_jurusan` (`jid`, `nama_jurusan`, `group`) VALUES
(1, 'Teknik Komputer dan Jaringan', 'teknik'),
(2, 'Multimedia', 'teknik'),
(3, 'Rekayasa Perangkat Lunak', 'teknik'),
(4, 'Administrasi Perkantoran', 'pariwisata dan seni'),
(5, 'Akuntansi', 'bismen'),
(6, 'Pengelolahan Bisnis Ritel', 'bismen'),
(0, 'umum', 'umum');

-- --------------------------------------------------------

--
-- Table structure for table `t_kd`
--

CREATE TABLE IF NOT EXISTS `t_kd` (
  `kdid` bigint(15) NOT NULL,
  `nama_kd` varchar(255) NOT NULL,
  `id_mapel` int(15) NOT NULL,
  `oleh` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_mapel`
--

CREATE TABLE IF NOT EXISTS `t_mapel` (
  `mid` bigint(15) NOT NULL,
  `nama_mapel` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `oleh` varchar(255) NOT NULL,
  `nm_group` varchar(255) NOT NULL DEFAULT 'umum',
  `jid` bigint(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_peserta`
--

CREATE TABLE IF NOT EXISTS `t_peserta` (
  `pid` bigint(15) NOT NULL,
  `pengguna` varchar(50) NOT NULL,
  `kunci` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `kelompok` varchar(50) NOT NULL,
  `tingkat` varchar(1) NOT NULL,
  `sekolah` varchar(255) NOT NULL,
  `oleh` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_peserta`
--

INSERT INTO `t_peserta` (`pid`, `pengguna`, `kunci`, `nama_pengguna`, `kelompok`, `tingkat`, `sekolah`, `oleh`) VALUES
(1, 'admin', 'admin', 'Administrator', 'admin', '0', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah`
--

CREATE TABLE IF NOT EXISTS `t_sekolah` (
  `sid` varchar(255) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `oleh` varchar(255) NOT NULL,
  `tgl_buat` datetime NOT NULL,
  `tgl_exp_validasi` datetime NOT NULL,
  `validasi_key` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_soal`
--

CREATE TABLE IF NOT EXISTS `t_soal` (
  `qid` bigint(15) NOT NULL,
  `isi_soal` text NOT NULL,
  `pilihan1` text NOT NULL,
  `pilihan2` text NOT NULL,
  `pilihan3` text NOT NULL,
  `pilihan4` text NOT NULL,
  `pilihan5` text NOT NULL,
  `benar` varchar(1) NOT NULL,
  `id_submapel` varchar(15) NOT NULL,
  `id_mapel` varchar(15) NOT NULL,
  `tgl_upload` datetime NOT NULL,
  `oleh` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_test`
--

CREATE TABLE IF NOT EXISTS `t_test` (
  `id` bigint(15) NOT NULL,
  `idmapel` varchar(255) NOT NULL,
  `kode_test` varchar(255) NOT NULL,
  `nama_test` varchar(255) NOT NULL,
  `tgl_awal_test` datetime NOT NULL,
  `tgl_akhir_test` datetime NOT NULL,
  `waktu_test` varchar(255) NOT NULL,
  `jumlah_soal` varchar(255) NOT NULL,
  `tingkat_test` varchar(1) NOT NULL DEFAULT '0',
  `publish_test_to_other` varchar(1) NOT NULL DEFAULT '0',
  `tgl_buat_test` datetime NOT NULL,
  `oleh` varchar(255) NOT NULL,
  `jumlah_peserta` varchar(255) NOT NULL DEFAULT '0',
  `total_soal_dicek` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_test_pertanyaan`
--

CREATE TABLE IF NOT EXISTS `t_test_pertanyaan` (
  `id_test` varchar(255) NOT NULL,
  `id_soal` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Triggers `t_test_pertanyaan`
--
DELIMITER $$
CREATE TRIGGER `testsoal` BEFORE INSERT ON `t_test_pertanyaan`
 FOR EACH ROW BEGIN
     UPDATE t_test SET total_soal_dicek = total_soal_dicek + 1 WHERE id = NEW.id_test;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `testsoaldel` BEFORE DELETE ON `t_test_pertanyaan`
 FOR EACH ROW BEGIN
     UPDATE t_test SET total_soal_dicek = total_soal_dicek - 1 WHERE id =OLD.id_test;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_test_peserta`
--

CREATE TABLE IF NOT EXISTS `t_test_peserta` (
  `id_test` varchar(255) NOT NULL,
  `id_peserta` varchar(255) NOT NULL,
  `soal_test` text NOT NULL,
  `last_login` datetime NOT NULL,
  `remaining_time` varchar(255) NOT NULL,
  `still_login` varchar(1) NOT NULL DEFAULT '0',
  `kunci_login` varchar(1) NOT NULL DEFAULT '0',
  `diselesaikan` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Triggers `t_test_peserta`
--
DELIMITER $$
CREATE TRIGGER `testpeserta` BEFORE INSERT ON `t_test_peserta`
 FOR EACH ROW BEGIN
     UPDATE t_test SET jumlah_peserta = jumlah_peserta+ 1 WHERE id = NEW.id_test;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `testpesertadel` BEFORE DELETE ON `t_test_peserta`
 FOR EACH ROW BEGIN
     UPDATE t_test SET jumlah_peserta = jumlah_peserta - 1 WHERE id =OLD.id_test;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_token`
--

CREATE TABLE IF NOT EXISTS `t_token` (
  `id` bigint(15) NOT NULL,
  `token` varchar(255) NOT NULL,
  `tgl_exp` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_token`
--

INSERT INTO `t_token` (`id`, `token`, `tgl_exp`) VALUES
(1, '123456', '2015-05-20 14:43:21');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_hsl_test`
--
CREATE TABLE IF NOT EXISTS `v_hsl_test` (
`idpeserta` varchar(255)
,`idtest` varchar(255)
,`score` decimal(23,0)
,`tot_soal` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_test_siswa`
--
CREATE TABLE IF NOT EXISTS `v_test_siswa` (
`id_test` varchar(255)
,`id_peserta` varchar(255)
,`soal_test` text
,`last_login` datetime
,`remaining_time` varchar(255)
,`still_login` varchar(1)
,`kunci_login` varchar(1)
,`id` bigint(15)
,`idmapel` varchar(255)
,`kode_test` varchar(255)
,`nama_test` varchar(255)
,`tgl_awal_test` datetime
,`tgl_akhir_test` datetime
,`waktu_test` varchar(255)
,`jumlah_soal` varchar(255)
,`tingkat_test` varchar(1)
,`publish_test_to_other` varchar(1)
,`tgl_buat_test` datetime
,`oleh` varchar(255)
,`jumlah_peserta` varchar(255)
,`total_soal_dicek` varchar(255)
,`diselesaikan` varchar(1)
,`nama_mapel` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `hsl_score_akhir`
--
DROP TABLE IF EXISTS `hsl_score_akhir`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `hsl_score_akhir` AS select `a`.`pid` AS `pid`,`a`.`pengguna` AS `pengguna`,`a`.`kunci` AS `kunci`,`a`.`nama_pengguna` AS `nama_pengguna`,`a`.`kelompok` AS `kelompok`,`a`.`tingkat` AS `tingkat`,`a`.`sekolah` AS `sekolah`,`a`.`oleh` AS `oleh`,`b`.`kode_test` AS `kode_test`,`b`.`nama_test` AS `nama_test`,`b`.`tgl_awal_test` AS `tgl_awal_test`,`b`.`tgl_akhir_test` AS `tgl_akhir_test`,`b`.`waktu_test` AS `waktu_test`,`b`.`jumlah_soal` AS `jumlah_soal`,`b`.`idpeserta` AS `idpeserta`,`b`.`idtest` AS `idtest`,`b`.`score` AS `score`,`b`.`tot_soal` AS `tot_soal`,`b`.`idmapel` AS `idmapel` from (`t_peserta` `a` join `kor_vtest_ttest` `b`) where ((`a`.`tingkat` = '2') and (`a`.`pid` = `b`.`idpeserta`));

-- --------------------------------------------------------

--
-- Structure for view `kor_vtest_ttest`
--
DROP TABLE IF EXISTS `kor_vtest_ttest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `kor_vtest_ttest` AS select `a`.`kode_test` AS `kode_test`,`a`.`nama_test` AS `nama_test`,`a`.`tgl_awal_test` AS `tgl_awal_test`,`a`.`tgl_akhir_test` AS `tgl_akhir_test`,`a`.`waktu_test` AS `waktu_test`,`a`.`jumlah_soal` AS `jumlah_soal`,`b`.`idpeserta` AS `idpeserta`,`b`.`idtest` AS `idtest`,`b`.`score` AS `score`,`b`.`tot_soal` AS `tot_soal`,`a`.`idmapel` AS `idmapel` from (`t_test` `a` join `v_hsl_test` `b`) where (`a`.`id` = `b`.`idtest`);

-- --------------------------------------------------------

--
-- Structure for view `v_hsl_test`
--
DROP TABLE IF EXISTS `v_hsl_test`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hsl_test` AS select `a`.`idpeserta` AS `idpeserta`,`a`.`idtest` AS `idtest`,sum(if((`a`.`pilihan` = `b`.`benar`),1,0)) AS `score`,count(0) AS `tot_soal` from (`t_hsl_test` `a` join `t_soal` `b`) where (`a`.`idsoal` = `b`.`qid`) group by `a`.`idpeserta`,`a`.`idtest`;

-- --------------------------------------------------------

--
-- Structure for view `v_test_siswa`
--
DROP TABLE IF EXISTS `v_test_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_test_siswa` AS select `a`.`id_test` AS `id_test`,`a`.`id_peserta` AS `id_peserta`,`a`.`soal_test` AS `soal_test`,`a`.`last_login` AS `last_login`,`a`.`remaining_time` AS `remaining_time`,`a`.`still_login` AS `still_login`,`a`.`kunci_login` AS `kunci_login`,`b`.`id` AS `id`,`b`.`idmapel` AS `idmapel`,`b`.`kode_test` AS `kode_test`,`b`.`nama_test` AS `nama_test`,`b`.`tgl_awal_test` AS `tgl_awal_test`,`b`.`tgl_akhir_test` AS `tgl_akhir_test`,`b`.`waktu_test` AS `waktu_test`,`b`.`jumlah_soal` AS `jumlah_soal`,`b`.`tingkat_test` AS `tingkat_test`,`b`.`publish_test_to_other` AS `publish_test_to_other`,`b`.`tgl_buat_test` AS `tgl_buat_test`,`b`.`oleh` AS `oleh`,`b`.`jumlah_peserta` AS `jumlah_peserta`,`b`.`total_soal_dicek` AS `total_soal_dicek`,`a`.`diselesaikan` AS `diselesaikan`,`c`.`nama_mapel` AS `nama_mapel` from ((`t_test_peserta` `a` join `t_test` `b`) join `t_mapel` `c`) where ((`a`.`id_test` = `b`.`id`) and (`b`.`idmapel` = `c`.`mid`)) order by `b`.`tgl_awal_test`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_hsl_test`
--
ALTER TABLE `t_hsl_test`
  ADD PRIMARY KEY (`idtest`,`idsoal`,`idpeserta`);

--
-- Indexes for table `t_image`
--
ALTER TABLE `t_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_jurusan`
--
ALTER TABLE `t_jurusan`
  ADD PRIMARY KEY (`jid`);

--
-- Indexes for table `t_kd`
--
ALTER TABLE `t_kd`
  ADD PRIMARY KEY (`kdid`);

--
-- Indexes for table `t_mapel`
--
ALTER TABLE `t_mapel`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `t_peserta`
--
ALTER TABLE `t_peserta`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `t_sekolah`
--
ALTER TABLE `t_sekolah`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_soal`
--
ALTER TABLE `t_soal`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `t_test`
--
ALTER TABLE `t_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_test_pertanyaan`
--
ALTER TABLE `t_test_pertanyaan`
  ADD PRIMARY KEY (`id_test`,`id_soal`);

--
-- Indexes for table `t_test_peserta`
--
ALTER TABLE `t_test_peserta`
  ADD PRIMARY KEY (`id_test`,`id_peserta`);

--
-- Indexes for table `t_token`
--
ALTER TABLE `t_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_image`
--
ALTER TABLE `t_image`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_jurusan`
--
ALTER TABLE `t_jurusan`
  MODIFY `jid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `t_kd`
--
ALTER TABLE `t_kd`
  MODIFY `kdid` bigint(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_mapel`
--
ALTER TABLE `t_mapel`
  MODIFY `mid` bigint(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_peserta`
--
ALTER TABLE `t_peserta`
  MODIFY `pid` bigint(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_soal`
--
ALTER TABLE `t_soal`
  MODIFY `qid` bigint(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_test`
--
ALTER TABLE `t_test`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_token`
--
ALTER TABLE `t_token`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
