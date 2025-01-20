-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 20, 2025 at 04:19 PM
-- Server version: 5.7.33-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kalima`
--

-- --------------------------------------------------------

--
-- Table structure for table `cbt_jawaban`
--

CREATE TABLE `cbt_jawaban` (
  `jawaban_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban_soal_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban_detail` text COLLATE utf8_unicode_ci NOT NULL,
  `jawaban_benar` tinyint(1) NOT NULL DEFAULT '0',
  `jawaban_aktif` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_konfigurasi`
--

CREATE TABLE `cbt_konfigurasi` (
  `konfigurasi_id` int(11) NOT NULL,
  `konfigurasi_kode` varchar(50) NOT NULL,
  `konfigurasi_isi` varchar(500) NOT NULL,
  `konfigurasi_keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cbt_konfigurasi`
--

INSERT INTO `cbt_konfigurasi` (`konfigurasi_id`, `konfigurasi_kode`, `konfigurasi_isi`, `konfigurasi_keterangan`) VALUES
(1, 'link_login_operator', 'ya', 'Menampilkan Link Login Operator'),
(2, 'cbt_nama', 'KALIMA TEST', 'Nama Penyelenggara ZYACBT'),
(3, 'cbt_keterangan', 'PENILAIAN SUMATIF AKHIR SEMESTER', 'Keterangan Penyelenggara ZYACBT'),
(4, 'cbt_mobile_lock_xambro', 'tidak', 'Melakukan Lock pada browser mobile agar menggunakan Xambro Saja'),
(5, 'cbt_informasi', '<p>Jika terjadi kendala terkait sistem KALIMA TEST segera hubungi pengawas ujian</p>\r\n', 'Informasi yang diberika di Dashboard peserta tes\'');

-- --------------------------------------------------------

--
-- Table structure for table `cbt_modul`
--

CREATE TABLE `cbt_modul` (
  `modul_id` bigint(20) UNSIGNED NOT NULL,
  `modul_nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modul_aktif` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cbt_modul`
--

INSERT INTO `cbt_modul` (`modul_id`, `modul_nama`, `modul_aktif`) VALUES
(9, 'Uji Coba', 1),
(10, 'PSAJ', 0),
(11, 'SAS', 1),
(12, 'Ulangan Harian', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cbt_sessions`
--

CREATE TABLE `cbt_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_soal`
--

CREATE TABLE `cbt_soal` (
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `soal_topik_id` bigint(20) UNSIGNED NOT NULL,
  `soal_detail` text COLLATE utf8_unicode_ci NOT NULL,
  `soal_tipe` smallint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Pilihan ganda, 2=essay, 3=jawaban singkat',
  `soal_kunci` text COLLATE utf8_unicode_ci COMMENT 'Kunci untuk soal jawaban singkat',
  `soal_difficulty` smallint(6) NOT NULL DEFAULT '1',
  `soal_aktif` tinyint(1) NOT NULL DEFAULT '0',
  `soal_audio` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `soal_audio_play` int(11) NOT NULL DEFAULT '0',
  `soal_timer` smallint(10) DEFAULT NULL,
  `soal_inline_answers` tinyint(1) NOT NULL DEFAULT '0',
  `soal_auto_next` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_tes`
--

CREATE TABLE `cbt_tes` (
  `tes_id` bigint(20) UNSIGNED NOT NULL,
  `tes_nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tes_detail` text COLLATE utf8_unicode_ci NOT NULL,
  `tes_begin_time` datetime DEFAULT NULL,
  `tes_end_time` datetime DEFAULT NULL,
  `tes_duration_time` smallint(10) UNSIGNED NOT NULL DEFAULT '0',
  `tes_ip_range` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*.*.*.*',
  `tes_results_to_users` tinyint(1) NOT NULL DEFAULT '0',
  `tes_detail_to_users` tinyint(1) NOT NULL DEFAULT '0',
  `tes_score_right` decimal(10,2) DEFAULT '1.00',
  `tes_score_wrong` decimal(10,2) DEFAULT '0.00',
  `tes_score_unanswered` decimal(10,2) DEFAULT '0.00',
  `tes_max_score` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tes_token` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_tesgrup`
--

CREATE TABLE `cbt_tesgrup` (
  `tstgrp_tes_id` bigint(20) UNSIGNED NOT NULL,
  `tstgrp_grup_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_tes_soal`
--

CREATE TABLE `cbt_tes_soal` (
  `tessoal_id` bigint(20) UNSIGNED NOT NULL,
  `tessoal_tesuser_id` bigint(20) UNSIGNED NOT NULL,
  `tessoal_user_ip` varchar(39) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tessoal_soal_id` bigint(20) UNSIGNED NOT NULL,
  `tessoal_jawaban_text` text COLLATE utf8_unicode_ci,
  `tessoal_nilai` decimal(10,2) DEFAULT NULL,
  `tessoal_creation_time` datetime DEFAULT NULL,
  `tessoal_display_time` datetime DEFAULT NULL,
  `tessoal_change_time` datetime DEFAULT NULL,
  `tessoal_reaction_time` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `tessoal_ragu` int(1) NOT NULL DEFAULT '0' COMMENT '1=ragu, 0=tidak ragu',
  `tessoal_order` smallint(6) NOT NULL DEFAULT '1',
  `tessoal_num_answers` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `tessoal_comment` text COLLATE utf8_unicode_ci,
  `tessoal_audio_play` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_tes_soal_jawaban`
--

CREATE TABLE `cbt_tes_soal_jawaban` (
  `soaljawaban_tessoal_id` bigint(20) UNSIGNED NOT NULL,
  `soaljawaban_jawaban_id` bigint(20) UNSIGNED NOT NULL,
  `soaljawaban_selected` smallint(6) NOT NULL DEFAULT '-1',
  `soaljawaban_order` smallint(6) NOT NULL DEFAULT '1',
  `soaljawaban_position` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_tes_token`
--

CREATE TABLE `cbt_tes_token` (
  `token_id` int(11) NOT NULL,
  `token_isi` varchar(20) NOT NULL,
  `token_user_id` int(11) NOT NULL,
  `token_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token_aktif` int(11) NOT NULL DEFAULT '1' COMMENT 'Umur Token dalam menit, 1 = 1 hari penuh',
  `token_tes_id` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_tes_topik_set`
--

CREATE TABLE `cbt_tes_topik_set` (
  `tset_id` bigint(20) UNSIGNED NOT NULL,
  `tset_tes_id` bigint(20) UNSIGNED NOT NULL,
  `tset_topik_id` bigint(20) UNSIGNED NOT NULL,
  `tset_tipe` smallint(6) NOT NULL DEFAULT '1',
  `tset_difficulty` smallint(6) NOT NULL DEFAULT '1',
  `tset_jumlah` smallint(6) NOT NULL DEFAULT '1',
  `tset_jawaban` smallint(6) NOT NULL DEFAULT '0',
  `tset_acak_jawaban` int(11) NOT NULL DEFAULT '1',
  `tset_acak_soal` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_tes_user`
--

CREATE TABLE `cbt_tes_user` (
  `tesuser_id` bigint(20) UNSIGNED NOT NULL,
  `tesuser_tes_id` bigint(20) UNSIGNED NOT NULL,
  `tesuser_user_id` bigint(20) UNSIGNED NOT NULL,
  `tesuser_status` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `tesuser_creation_time` datetime NOT NULL,
  `tesuser_comment` text COLLATE utf8_unicode_ci,
  `tesuser_token` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_topik`
--

CREATE TABLE `cbt_topik` (
  `topik_id` bigint(20) UNSIGNED NOT NULL,
  `topik_modul_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `topik_nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `topik_detail` text COLLATE utf8_unicode_ci,
  `topik_aktif` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cbt_topik`
--

INSERT INTO `cbt_topik` (`topik_id`, `topik_modul_id`, `topik_nama`, `topik_detail`, `topik_aktif`) VALUES
(39, 10, 'Pendidikan Pancasila & Kewarganegaraan', 'PSAJ 2024', 1),
(40, 10, 'Pendidikan Agama Katolik dan Budi Pekerti', 'PSAJ 2024', 1),
(41, 10, 'Bahasa Indonesia', 'PSAJ 2024', 1),
(42, 10, 'Bahasa Inggris', 'PSAJ 2024', 1),
(43, 10, 'Sejarah', 'PSAJ 2024', 1),
(44, 10, 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'PSAJ 2024', 1),
(45, 10, 'Seni Rupa', 'PSAJ 2024', 1),
(46, 10, 'Muatan Lokal Bahasa Jawa', 'PSAJ 2024', 1),
(48, 10, 'Informatika', 'PSAJ 2024', 1),
(49, 10, 'Dasar Dasar Desain dan Produksi Kriya - Tekstil', 'PSAJ 2024', 1),
(50, 10, 'Projek IPAS', 'PSAJ 2024', 1),
(51, 10, 'Pendidikan Agama Islam dan Budi Pekerti', 'PSAJ 2024', 1),
(52, 10, 'Pendidikan Agama Kristen dan Budi Pekerti', 'PSAJ 2024', 1),
(53, 10, 'Pendidikan Agama Hindu dan Budi Pekerti', 'PSAJ 2024', 1),
(55, 10, 'Matematika', 'PSAJ 2024', 1),
(56, 10, 'Dasar Dasar Desain dan Produksi Kriya - Kayu', 'PSAJ 2024', 1),
(57, 10, 'Dasar Dasar Desain dan Produksi Kriya - Keramik', 'PSAJ 2024', 1),
(58, 10, 'Dasar Dasar Animasi', 'PSAJ 2024', 1),
(59, 10, 'Dasar Dasar Busana', 'PSAJ 2024', 1),
(60, 10, 'Dasar Dasar Desain Komunikasi Visual', 'PSAJ 2024', 1),
(61, 10, 'Dasar Dasar Pengembangan Perangkat Lunak dan Gim', 'PSAJ 2024', 1),
(62, 10, 'Dasar Dasar Teknik Jaringan Komputer dan Telekomunikasi', 'PSAJ 2024', 1),
(64, 10, 'Projek Kreatif dan Kewirausahaan - Desain Komunikasi Visual', 'PSAJ 2024', 1),
(65, 10, 'Projek Kreatif dan Kewirausahaan - Desain dan Produksi Busana', 'PSAJ 2024', 1),
(66, 10, 'Projek Kreatif dan Kewirausahaan - Kriya Kreatif Batik dan Tekstil', 'PSAJ 2024', 1),
(67, 10, 'Projek Kreatif dan Kewirausahaan - Kriya Kreatif Kayu dan Rotan', 'PSAJ 2024', 1),
(68, 10, 'Projek Kreatif dan Kewirausahaan - Kriya Kreatif Keramik', 'PSAJ 2024', 1),
(69, 10, 'Projek Kreatif dan Kewirausahaan - Rekayasa Perangkat Lunak', 'PSAJ 2024', 1),
(70, 10, 'Projek Kreatif dan Kewirausahaan - Teknik Komputer dan Jaringan', 'PSAJ 2024', 1),
(71, 10, 'Mapel Pilihan - Teknik Kerja Bangku', 'PSAJ 2024', 1),
(72, 10, 'Mapel Pilihan - Desain Produk', 'PSAJ 2024', 1),
(73, 10, 'Mapel Pilihan - Teknik Furnitur', 'PSAJ 2024', 1),
(74, 10, 'Mapel Pilihan - Pembentukan Keramik dengan Teknik Cetak', 'PSAJ 2024', 1),
(75, 10, 'Mapel Pilihan - Sketsa', 'PSAJ 2024', 1),
(76, 10, 'Mapel Pilihan - Animasi 2D', 'PSAJ 2024', 1),
(77, 10, 'Mapel Pilihan - Sablon', 'PSAJ 2024', 1),
(78, 10, 'Mapel Pilihan - Batik', 'PSAJ 2024', 1),
(80, 10, 'Projek Kreatif dan Kewirausahaan - Animasi', 'PSAJ 2024', 1),
(81, 10, 'Mapel Pilihan - Pembuatan Pola (Busana)', 'PSAJ 2024', 1),
(82, 10, 'Mapel Pilihan - Teknologi Menjahit', 'PSAJ 2024', 1),
(83, 10, 'Mapel Pilihan - Teknologi Layanan Jaringan', 'PSAJ 2024', 1),
(84, 10, 'Mapel Pilihan - Desain Publikasi', 'PSAJ 2024', 1),
(85, 10, 'Mapel Pilihan - Matematika Lanjutan', 'PSAJ 2024', 1),
(87, 9, 'Uji Coba', 'Uji Coba', 1),
(89, 11, 'Pendidikan Agama dan Budi Pekerti (Islam) Kelas X', 'Pendidikan Agama dan Budi Pekerti (Islam)', 1),
(90, 11, 'Pendidikan Agama dan Budi Pekerti (Katolik) Kelas X', 'Pendidikan Agama dan Budi Pekerti (Katolik)', 1),
(91, 11, 'Pendidikan Agama dan Budi Pekerti (Kristen) Kelas X', 'Pendidikan Agama dan Budi Pekerti (Kristen)', 1),
(92, 11, 'Pendidikan Agama dan Budi Pekerti (Hindu) Kelas X', 'Pendidikan Agama dan Budi Pekerti (Hindu)', 1),
(93, 11, 'Bahasa Indonesia Kelas X', 'Bahasa Indonesia', 1),
(94, 11, 'Matematika Kelas X', 'Matematika', 1),
(95, 11, 'Sejarah Kelas X', 'Sejarah', 1),
(96, 11, 'Bahasa Inggris Kelas X', 'Bahasa Inggris', 1),
(97, 11, 'Seni Budaya Kelas X', 'Seni Budaya', 1),
(99, 11, 'Pendidikan Jasmani Olahraga dan Kesehatan Kelas XI', 'Pendidikan Jasmani Olahraga dan Kesehatan', 1),
(101, 11, 'Proyek IPAS Kelas X', 'Proyek IPAS', 1),
(102, 11, 'Informatika Kelas X', 'Informatika', 1),
(103, 11, 'Produktif PPLG Kelas X', 'Produktif PPLG', 1),
(104, 11, 'Produktif TJKT Kelas X', 'Produktif TJKT', 1),
(105, 11, 'Produktif DKV Kelas X', 'Produktif DKV', 1),
(106, 11, 'Produktif DPB Kelas X', 'Produktif DPB', 1),
(107, 11, 'Produktif Animasi Kelas X', 'Produktif Animasi', 1),
(109, 11, 'Dasar Dasar Kriya', 'Dasar Dasar Kriya', 1),
(111, 11, 'Soal Simulasi', 'Soal Simulasi PAS Ganjil 24/25', 1),
(112, 11, 'Pendidikan Pancasila dan Kewarganegaraan Kelas XI', 'Pendidikan Pancasila dan Kewarganegaraan', 1),
(113, 11, 'Pendidikan Agama dan Budi Pekerti (Islam) Kelas XI', 'Pendidikan Agama dan Budi Pekerti (Islam)', 1),
(114, 11, 'Pendidikan Agama dan Budi Pekerti (Katolik) Kelas XI', 'Pendidikan Agama dan Budi Pekerti (Katolik)', 1),
(115, 11, 'Pendidikan Agama dan Budi Pekerti (Kristen) Kelas XI', 'Pendidikan Agama dan Budi Pekerti (Kristen)', 1),
(116, 11, 'Pendidikan Agama dan Budi Pekerti (Hindu) Kelas XI', 'Pendidikan Agama dan Budi Pekerti (Hindu)', 1),
(117, 11, 'Bahasa Indonesia Kelas XI', 'Bahasa Indonesia', 1),
(118, 11, 'Matematika Kelas XI', 'Matematika', 1),
(119, 11, 'Bahasa Inggris Kelas XI', 'Bahasa Inggris', 1),
(120, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - TKJ', 'Projek Kreatif dan Kewirausahaan Kelas XI - TKJ', 1),
(121, 11, 'Pendidikan Jasmani Olahraga dan Kesehatan Kelas X', 'Pendidikan Jasmani Olahraga dan Kesehatan', 1),
(122, 11, 'Muatan Lokal Bahasa Jawa Kelas XI', 'Muatan Lokal Bahasa Jawa', 1),
(123, 11, 'Produktif PPLG Kelas XI', 'Produktif PPLG', 1),
(124, 11, 'Produktif TJKT Kelas XI', 'Produktif TJKT', 1),
(125, 11, 'Produktif DKV Kelas XI', 'Produktif DKV', 1),
(126, 11, 'Produktif DPB Kelas XI', 'Produktif DPB', 1),
(127, 11, 'Produktif Animasi Kelas XI', 'Produktif Animasi', 1),
(128, 11, 'Produktif KKR Kelas XI', 'Produktif KKR', 1),
(129, 11, 'Produktif KKA Kelas XI', 'Produktif KKA', 1),
(130, 11, 'Produktif KTK Kelas XI', 'Produktif KTK', 1),
(131, 11, 'MAPIL Administrasi Sistem Jaringan Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(132, 11, 'MAPIL Teknologi Layanan Jaringan Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(133, 11, 'MAPIL Animasi 2D Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(134, 11, 'MAPIL Animasi 3D Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(135, 11, 'MAPIL Batik Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(136, 11, 'MAPIL Sablon Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(137, 11, 'MAPIL Fashion Industry Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(138, 11, 'MAPIL Custom Made Fashion Lanjutan Kelas XI', 'MAPIL Lanjutan', 1),
(139, 11, 'MAPIL Desain Publikasi LanjutanKelas XI', 'MAPIL Lanjutan', 1),
(140, 11, 'MAPIL Animasi 2D Umum Kelas XI', 'MAPIL Umum', 1),
(141, 11, 'MAPIL Teknik Furnitur 1 Umum Kelas XI', 'MAPIL Umum', 1),
(142, 11, 'MAPIL Teknik Furnitur 2 Umum Kelas XI', 'MAPIL Umum', 1),
(143, 11, 'MAPIL Pembentukan keramik dengan Teknik Cetak (PdTC) - 1 Umum Kelas XI', 'MAPIL Umum', 1),
(144, 11, 'MAPIL Pembentukan keramik dengan Teknik Cetak (PdTC) - 2 Umum Kelas XI', 'MAPIL Umum', 1),
(145, 11, 'MAPIL Sketsa -1 Umum Kelas XI', 'MAPIL Umum', 1),
(146, 11, 'MAPIL Sketsa -2 Umum Kelas XI', 'MAPIL Umum', 1),
(147, 11, 'MAPIL Desain Publikasi Umum Kelas XI', 'MAPIL Umum', 1),
(148, 11, 'MAPIL Pemrograman Web Umum Kelas XI', 'MAPIL Umum', 1),
(149, 11, 'MAPIL Matematika Tingkat Umum Kelas XI', 'MAPIL Umum', 1),
(150, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - DKV', 'Projek Kreatif dan Kewirausahaan Kelas XI - DKV', 1),
(151, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - RPL', 'Projek Kreatif dan Kewirausahaan Kelas XI - RPL', 1),
(152, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - DPB', 'Projek Kreatif dan Kewirausahaan Kelas XI - DPB', 1),
(153, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - ANIMASI', 'Projek Kreatif dan Kewirausahaan Kelas XI - ANIMASI', 1),
(154, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - KTK', 'Projek Kreatif dan Kewirausahaan Kelas XI - KTK', 1),
(155, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - KKA', 'Projek Kreatif dan Kewirausahaan Kelas XI - KKA', 1),
(156, 11, 'Projek Kreatif dan Kewirausahaan Kelas XI - KKR', 'Projek Kreatif dan Kewirausahaan Kelas XI - KKR', 1),
(157, 11, 'Pendidikan Pancasila dan Kewarganegaraan Kelas X', 'Pendidikan Pancasila dan Kewarganegaraan Kelas X', 1),
(159, 11, 'Muatan Lokal Bahasa Jawa Kelas X', 'Muatan Lokal Bahasa Jawa Kelas X', 1),
(160, 11, 'Sejarah Kelas XI', 'Sejarah Kelas XI', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cbt_user`
--

CREATE TABLE `cbt_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_grup_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_ip` varchar(39) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_birthplace` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_level` smallint(3) UNSIGNED NOT NULL DEFAULT '1',
  `user_detail` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cbt_user`
--

INSERT INTO `cbt_user` (`user_id`, `user_grup_id`, `user_name`, `user_password`, `user_email`, `user_regdate`, `user_ip`, `user_firstname`, `user_birthdate`, `user_birthplace`, `user_level`, `user_detail`) VALUES
(1, 10, '13842/1016.127', 'SHLJYU', 'email', '2024-11-11 07:41:31', NULL, 'ADI CAKRA MAULANA', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(2, 10, '13844/1018.127', 'ODJBKN', NULL, '2024-11-11 07:41:31', NULL, 'AISYAFA SABRINATUS SALWA', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(3, 10, '13846/1020.127', 'OOBDSX', NULL, '2024-11-11 07:41:31', NULL, 'ALDY PRASETYO', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(4, 10, '13848/1022.127', 'JHFKZE', NULL, '2024-11-11 07:41:31', NULL, 'ANDRA FACHRI FALSIFAH', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(5, 10, '13850/1024.127', 'JVUVOQ', NULL, '2024-11-11 07:41:31', NULL, 'ASHYMAH ZALFA WAFIYAH', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(6, 10, '13852/1026.127', 'KILEAJ', NULL, '2024-11-11 07:41:31', NULL, 'BINTANG ADI NUGROHO', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(7, 10, '13854/1028.127', 'MWMPAT', NULL, '2024-11-11 07:41:31', NULL, 'DINAR JECONIA', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(8, 10, '13856/1030.127', 'QTKNVG', NULL, '2024-11-11 07:41:31', NULL, 'FARAH FEBRIANTI KUSNUL KHOTIMAH', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(9, 10, '13858/1032.127', 'VWVPXX', NULL, '2024-11-11 07:41:31', NULL, 'GADIS NUR LAILA', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(10, 10, '13860/1034.127', 'AINHAW', NULL, '2024-11-11 07:41:31', NULL, 'HAYDAR AZKA CIELLO HERMANSYAH', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(11, 10, '13862/1036.127', 'SLPOMW', NULL, '2024-11-11 07:41:31', NULL, 'KAKA AKHBAR ANANDA', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(12, 10, '13864/1038.127', 'JYGWVP', NULL, '2024-11-11 07:41:31', NULL, 'LEGINA KHANZA', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(13, 10, '13866/1040.127', 'CFJDEA', NULL, '2024-11-11 07:41:31', NULL, 'M NAFI NIZAM ATTAQLANI', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(14, 10, '13868/1042.127', 'LOUSMP', NULL, '2024-11-11 07:41:31', NULL, 'MOCH RIZKI ANDIKA SAPUTRA', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(15, 10, '13870/1044.127', 'JTACPR', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMAD ILHAM HAKIKI', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(16, 10, '13872/1046.127', 'BSMJRQ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD DIMAS MUKASYAFAH', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(17, 10, '13874/1048.127', 'FYFXVC', NULL, '2024-11-11 07:41:31', NULL, 'NANDA RAGIL RABBANI', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(18, 10, '13876/1050.127', 'OHHXJR', NULL, '2024-11-11 07:41:31', NULL, 'NAYLA DWI WAHYUNI', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(19, 10, '13878/1052.127', 'SPLPDA', NULL, '2024-11-11 07:41:31', NULL, 'PUTRI RIFKA WULAN SARI', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(20, 10, '13880/1054.127', 'EXVIRX', NULL, '2024-11-11 07:41:31', NULL, 'RAFA ANUGERAH WAKUM', NULL, NULL, 1, 'Ruang 1, Sesi 1'),
(21, 10, '13882/1056.127', 'MGULUM', NULL, '2024-11-11 07:41:31', NULL, 'RAMEKKAH RONA JANNAH', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(22, 10, '13884/1058.127', 'WYSUAH', NULL, '2024-11-11 07:41:31', NULL, 'RAVENALA AUCKY ZAFRANI MALISYA', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(23, 10, '13886/1060.127', 'KEJFNX', NULL, '2024-11-11 07:41:31', NULL, 'RIZAL BUMI PANJAWA', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(24, 10, '13888/1062.127', 'DOVZGU', NULL, '2024-11-11 07:41:31', NULL, 'SHAFIRA NUR NOVIANTI', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(25, 10, '13890/1064.127', 'ZNYUHK', NULL, '2024-11-11 07:41:31', NULL, 'STEFANUS JALU WAWOROJATI', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(26, 10, '13892/1066.127', 'OVZPVJ', NULL, '2024-11-11 07:41:31', NULL, 'TIFANY FARADILLA HERNIAWAN', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(27, 10, '13894/1068.127', 'ZUGOQO', NULL, '2024-11-11 07:41:31', NULL, 'ZAHWA ARIFATUZZAKIYA', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(28, 10, '13896/1070.127', 'CXGSDE', NULL, '2024-11-11 07:41:31', NULL, 'ZHIYA ATHIR RAMADHAN', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(29, 11, '13843/1017.127', 'NQRXCY', NULL, '2024-11-11 07:41:31', NULL, 'AFIF FAUZAN SAPUTRA', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(30, 11, '13845/1019.127', 'ILHRUB', NULL, '2024-11-11 07:41:31', NULL, 'AISYAH NUR RAMADHANI', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(31, 11, '13847/1021.127', 'YNRNZG', NULL, '2024-11-11 07:41:31', NULL, 'ALVIANDRA TEGAR MAULANA', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(32, 11, '13849/1023.127', 'EUDUZC', NULL, '2024-11-11 07:41:31', NULL, 'ANMAMIA DZAKI', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(33, 11, '13851/1025.127', 'TSLAVX', NULL, '2024-11-11 07:41:31', NULL, 'BILQIS SABRINA CAROLIN', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(34, 11, '13853/1027.127', 'VOFGCZ', NULL, '2024-11-11 07:41:31', NULL, 'DAVA SANDI SURYANTO', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(35, 11, '13855/1029.127', 'YXKYQY', NULL, '2024-11-11 07:41:31', NULL, 'EXCELLUNA ROSRIMARTA MAULIDA', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(36, 11, '13857/1031.127', 'TDBFZN', NULL, '2024-11-11 07:41:31', NULL, 'FIKA NANDA LESTARI', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(37, 11, '13859/1033.127', 'ZEBRIC', NULL, '2024-11-11 07:41:31', NULL, 'GALIH NIZAR ATHA FAUZAN', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(38, 11, '13861/1035.127', 'PJTHFU', NULL, '2024-11-11 07:41:31', NULL, 'HIKMAL DANA F', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(39, 11, '13863/1037.127', 'UQMONC', NULL, '2024-11-11 07:41:31', NULL, 'KHUMAIRA SAYENZA ALAIKA W', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(40, 11, '13865/1039.127', 'FVUNUJ', NULL, '2024-11-11 07:41:31', NULL, 'LYLYANA PYTHA LOKA', NULL, NULL, 1, 'Ruang 2, Sesi 1'),
(41, 11, '13867/1041.127', 'VOQMLC', NULL, '2024-11-11 07:41:31', NULL, 'MARVALIO MATAHATI ENO', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(42, 11, '13869/1043.127', 'JGCMYP', NULL, '2024-11-11 07:41:31', NULL, 'MUCHAMAD NUR ALAMSYAH', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(43, 11, '13871/1045.127', 'FPESHD', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD AKBAR SAPUTRA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(44, 11, '13873/1047.127', 'TJYMZC', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD NURUL JADID', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(45, 11, '13875/1049.127', 'DFVTBB', NULL, '2024-11-11 07:41:31', NULL, 'NAURA AYU VERLINA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(46, 11, '13877/1051.127', 'NTFIMW', NULL, '2024-11-11 07:41:31', NULL, 'NEYSILLA DWI CAROLLINA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(47, 11, '13879/1053.127', 'WBUNFB', NULL, '2024-11-11 07:41:31', NULL, 'RADEN MAS RAHADIAN RASYA YULISTAMA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(48, 11, '13881/1055.127', 'HQGFHF', NULL, '2024-11-11 07:41:31', NULL, 'RAHMAD MAULANA ANDIKA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(49, 11, '13883/1057.127', 'LQINHA', NULL, '2024-11-11 07:41:31', NULL, 'RARAS KIRANA AZ ZAHRA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(50, 11, '13885/1059.127', 'XTZJOS', NULL, '2024-11-11 07:41:31', NULL, 'RAYHAN DYAH ANANDA ANWAR', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(51, 11, '13887/1061.127', 'ZUMDNW', NULL, '2024-11-11 07:41:31', NULL, 'SAHLA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(52, 11, '13889/1063.127', 'HUNTRG', NULL, '2024-11-11 07:41:31', NULL, 'SORAYA NISRINA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(53, 11, '13891/1065.127', 'RHCKLL', NULL, '2024-11-11 07:41:31', NULL, 'TEGAR DWI JULIANSYAH', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(54, 11, '13893/1067.127', 'ELMWRP', NULL, '2024-11-11 07:41:31', NULL, 'VANIA AHNAF AMANDA ACHMAD', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(55, 11, '13895/1069.127', 'TDPBQL', NULL, '2024-11-11 07:41:31', NULL, 'ZAKY ALFIANSYAH SUHARTO PRATAMA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(56, 17, '13784/1139.128', 'FEXGDS', NULL, '2024-11-11 07:41:31', NULL, 'AISATUL PUTRI CANTIKA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(57, 17, '13786/1141.128', 'GWYHDT', NULL, '2024-11-11 07:41:31', NULL, 'ALVINA CAHYASARI', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(58, 17, '13788/1143.128', 'ISETYQ', NULL, '2024-11-11 07:41:31', NULL, 'AMEERA ASHRAF JAHAN', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(59, 17, '13790/1145.128', 'RVDJYI', NULL, '2024-11-11 07:41:31', NULL, 'ANISA EKA RAMADHANI', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(60, 17, '13792/1147.128', 'GUBDRP', NULL, '2024-11-11 07:41:31', NULL, 'AURELIA SAFINA PUTRI FEBRIANA', NULL, NULL, 1, 'Ruang 3, Sesi 1'),
(61, 17, '13794/1149.128', 'XPBTJX', '', '2024-11-11 07:41:31', NULL, 'AZARIA RIFDAH RAMADHANI [OUT]', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(62, 17, '13796/1151.128', 'EKZBSU', NULL, '2024-11-11 07:41:31', NULL, 'CAHYA INDRIASTUTI', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(63, 17, '13798/1153.128', 'QBTLEA', NULL, '2024-11-11 07:41:31', NULL, 'CHOLIFAH INDRIANA', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(64, 17, '13800/1155.128', 'PPPNGN', NULL, '2024-11-11 07:41:31', NULL, 'CHYNTIA WINDI ZALIANTY', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(65, 17, '13802/1157.128', 'EZTDQT', NULL, '2024-11-11 07:41:31', NULL, 'DENNA SELVA PARAMADINA', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(66, 17, '13804/1159.128', 'WDEFWY', NULL, '2024-11-11 07:41:31', NULL, 'ELISA DWI LESTARI', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(67, 17, '13806/1161.128', 'HWYWKE', NULL, '2024-11-11 07:41:31', NULL, 'FILZAH SAFFA ADABY', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(68, 17, '13808/1163.128', 'LUUOWU', NULL, '2024-11-11 07:41:31', NULL, 'HANUR SHALIA KUSUMA PUTRI', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(69, 17, '13810/1165.128', 'OFBYEO', NULL, '2024-11-11 07:41:31', NULL, 'ISMIYATUL FADHILA', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(70, 17, '13812/1167.128', 'TXWKKK', NULL, '2024-11-11 07:41:31', NULL, 'KHAIZAH PRASMONO', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(71, 17, '13814/1169.128', 'QKLSBE', NULL, '2024-11-11 07:41:31', NULL, 'LISKA LENITA ISMAWATI', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(72, 17, '13816/1171.128', 'EWEVQZ', NULL, '2024-11-11 07:41:31', NULL, 'NABILA UMIROHIQOMATUL HAQ', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(73, 17, '13818/1173.128', 'TZDGEO', '', '2024-11-11 07:41:31', NULL, 'NADIA PUTRI AMBAR WATI [OUT]', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(74, 17, '13820/1175.128', 'RVZJZH', NULL, '2024-11-11 07:41:31', NULL, 'NAILATUL MEILANI', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(75, 17, '13822/1177.128', 'FFDDLM', NULL, '2024-11-11 07:41:31', NULL, 'NESSA JUAN AURELLIA', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(76, 17, '13824/1179.128', 'HWCBYK', NULL, '2024-11-11 07:41:31', NULL, 'REHANA AULIA PUTRI', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(77, 17, '13826/1181.128', 'NUZRMV', NULL, '2024-11-11 07:41:31', NULL, 'REVI HERNA SABILLA', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(78, 17, '13828/1183.128', 'STUBNF', NULL, '2024-11-11 07:41:31', NULL, 'SAHIRA AZZAHRA', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(79, 17, '13830/1185.128', 'XTQDCF', NULL, '2024-11-11 07:41:31', NULL, 'SEFIA AULIA PUTRI', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(80, 17, '13832/1187.128', 'JFYLYG', NULL, '2024-11-11 07:41:31', NULL, 'SHANIA MARETA DINANTIN', NULL, NULL, 1, 'Ruang 4, Sesi 1'),
(81, 17, '13834/1189.128', 'HVRUFP', NULL, '2024-11-11 07:41:31', NULL, 'STELA YUNITA ANASTASYA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(82, 17, '13836/1191.128', 'ORFQBT', NULL, '2024-11-11 07:41:31', NULL, 'TIYAS VADHILAH RAMADHANI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(83, 17, '13838/1193.128', 'CJYJUI', NULL, '2024-11-11 07:41:31', NULL, 'VIA RISKY RAHMADHANI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(84, 17, '13840/1195.128', 'RPOOSY', NULL, '2024-11-11 07:41:31', NULL, 'VITA DAMAYANTI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(85, 18, '13787/1142.128', 'XVZYOA', NULL, '2024-11-11 07:41:31', NULL, 'AMANDA ALISYA PUTRI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(86, 18, '13789/1144.128', 'MSWKLS', NULL, '2024-11-11 07:41:31', NULL, 'ANDINI SETYO PRAMESTY', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(87, 18, '13791/1146.128', 'ESSMSK', NULL, '2024-11-11 07:41:31', NULL, 'ARTALITA MASAYU', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(88, 18, '13793/1148.128', 'ANZSQC', NULL, '2024-11-11 07:41:31', NULL, 'AVRILLIA DWI PUTRI WAHYU WIJAYANTI ARIESTA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(89, 18, '13795/1150.128', 'KWOKLD', NULL, '2024-11-11 07:41:31', NULL, 'BUNGA DWI VARDIA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(90, 18, '13797/1152.128', 'BJWHTB', NULL, '2024-11-11 07:41:31', NULL, 'CHELLIAN PUTRI ASTIANTI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(91, 18, '13799/1154.128', 'AZNABN', NULL, '2024-11-11 07:41:31', NULL, 'CHOLIFATUL CHOIRUNNISA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(92, 18, '13801/1156.128', 'XWBOQK', NULL, '2024-11-11 07:41:31', NULL, 'DAVINA ANGGRAENI ANJANA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(93, 18, '13803/1158.128', 'ILXRHP', NULL, '2024-11-11 07:41:31', NULL, 'ECANSHA ZIDZE VEYYA AMUMURUA LAVENA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(94, 18, '13805/1160.128', 'AYHTYI', NULL, '2024-11-11 07:41:31', NULL, 'EVILIANI RIZKA PUTRI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(95, 18, '13807/1162.128', 'TRBUFH', NULL, '2024-11-11 07:41:31', NULL, 'GEESEL RANIA LATHIFA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(96, 18, '13809/1164.128', 'SVHBKQ', NULL, '2024-11-11 07:41:31', NULL, 'HARTI SULISTIOWATI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(97, 18, '13811/1166.128', 'AFBESC', NULL, '2024-11-11 07:41:31', NULL, 'JELITA MAULIDYA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(98, 18, '13813/1168.128', 'XCODSA', NULL, '2024-11-11 07:41:31', NULL, 'KHOLIFATUL IZZAH', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(99, 18, '13815/1170.128', 'XTRXHD', NULL, '2024-11-11 07:41:31', NULL, 'MASAYU INDRIA NABILA', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(100, 18, '13817/1172.128', 'ABUEPE', NULL, '2024-11-11 07:41:31', NULL, 'NADIA PRAMESWARI SISWATI', NULL, NULL, 1, 'Ruang 5, Sesi 1'),
(101, 18, '13819/1174.128', 'TVTWXY', NULL, '2024-11-11 07:41:31', NULL, 'NADYA RAHMATIKA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(102, 18, '13821/1176.128', 'SGGJIU', NULL, '2024-11-11 07:41:31', NULL, 'NASYACITRA ALLYA PUTRI', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(103, 18, '13823/1178.128', 'SWXALA', NULL, '2024-11-11 07:41:31', NULL, 'NUR AZIZAH', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(104, 18, '13825/1180.128', 'CZWPIP', NULL, '2024-11-11 07:41:31', NULL, 'REVA NOVALIA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(105, 18, '13827/1182.128', 'MCCJJI', NULL, '2024-11-11 07:41:31', NULL, 'REYVA ARDYANI', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(106, 18, '13829/1184.128', 'IFSUFJ', NULL, '2024-11-11 07:41:31', NULL, 'SALWA AQILAH', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(107, 18, '13831/1186.128', 'JMQITC', NULL, '2024-11-11 07:41:31', NULL, 'SELLA KARISMA PUSPITA SARI', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(108, 18, '13833/1188.128', 'AJDVHD', NULL, '2024-11-11 07:41:31', NULL, 'SILFIA EKA NOFIANTI', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(109, 18, '13835/1190.128', 'VZFJOF', NULL, '2024-11-11 07:41:31', NULL, 'TALITHA KHUMAIROTUL MAULIDIAH', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(110, 18, '13837/1192.128', 'ZALSHH', NULL, '2024-11-11 07:41:31', NULL, 'VELOVE CINDY SALSABILA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(111, 18, '13839/1194.128', 'MMKCKZ', NULL, '2024-11-11 07:41:31', NULL, 'VIRZINIA CAINANDA BILLA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(112, 18, '13841/1196.128', 'RPRAZN', NULL, '2024-11-11 07:41:31', NULL, 'ZAHRO FIRDAUSIN NUZULA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(113, 1, '13306/2012.111', 'IHKFYC', NULL, '2024-11-11 07:41:31', NULL, 'ARYA BAGASKARA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(114, 1, '13899/2096.111', 'YIXGOW', NULL, '2024-11-11 07:41:31', NULL, 'ADDINULANA YAFI ISLAMIAH', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(115, 1, '13902/2099.111', 'TUIYIH', NULL, '2024-11-11 07:41:31', NULL, 'ADINDA SYIFA NUR RAHMA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(116, 1, '13905/2102.111', 'ODVNLF', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD TAJJUDIN TAMAM', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(117, 1, '13908/2105.111', 'HZFHQO', NULL, '2024-11-11 07:41:31', NULL, 'ALDO\\\'A RAMADHAN', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(118, 1, '13911/2108.111', 'XEYUMS', NULL, '2024-11-11 07:41:31', NULL, 'AMABEL SYAHARANIE PUTRI', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(119, 1, '13914/2111.111', 'ECGHNH', NULL, '2024-11-11 07:41:31', NULL, 'ANDRA NOVIAN PRATAMA', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(120, 1, '13917/2114.111', 'CWJBLA', NULL, '2024-11-11 07:41:31', NULL, 'AULIA RIBBY ANDINI', NULL, NULL, 1, 'Ruang 6, Sesi 1'),
(121, 1, '13920/2117.111', 'GFXDTC', NULL, '2024-11-11 07:41:31', NULL, 'CINTA AULIA PUTRI', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(122, 1, '13923/2120.111', 'OJOQUG', NULL, '2024-11-11 07:41:31', NULL, 'DAVE ARYADHANI KINARYA SANTOSO', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(123, 1, '13926/2123.111', 'WAKDQO', NULL, '2024-11-11 07:41:31', NULL, 'DHEINDRAIKA DIKRI SUSANTA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(124, 1, '13929/2126.111', 'XCZCJN', NULL, '2024-11-11 07:41:31', NULL, 'DWI RIZALDIN', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(125, 1, '13932/2129.111', 'UHGXEF', NULL, '2024-11-11 07:41:31', NULL, 'ERSA NADHIF AZZAKY', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(126, 1, '13935/2132.111', 'MGXDUS', NULL, '2024-11-11 07:41:31', NULL, 'FILZAH HANIFAH SALSABILA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(127, 1, '13938/2135.111', 'MEHIMN', NULL, '2024-11-11 07:41:31', NULL, 'GILANG MAULANA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(128, 1, '13941/2138.111', 'WSRBPV', NULL, '2024-11-11 07:41:31', NULL, 'HANANIA NAILA KHANZA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(129, 1, '13944/2141.111', 'KIZQWW', NULL, '2024-11-11 07:41:31', NULL, 'HUMAYROH RASHSYA ARGYANTI', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(130, 1, '13947/2144.111', 'JYXBLU', NULL, '2024-11-11 07:41:31', NULL, 'IKE AULIA SUBEKTI', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(131, 1, '13950/2147.111', 'ZMZGKK', NULL, '2024-11-11 07:41:31', NULL, 'IVAYANTI DEWI KARTINI', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(132, 1, '13953/2150.111', 'XYOOKM', NULL, '2024-11-11 07:41:31', NULL, 'KEYSHA SALSADINI MEYLA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(133, 1, '13956/2153.111', 'TFGZIF', NULL, '2024-11-11 07:41:31', NULL, 'MAULIDYA ZULFIDA AGUSTIN', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(134, 1, '13959/2156.111', 'XPNRET', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMAD FAHRUL MUZAKI', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(135, 1, '13962/2159.111', 'CATFDU', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD DAVIN ARDIAN RAMADHAN', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(136, 1, '13965/2162.111', 'CICXON', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD OKTAVINO PRATAMA HALIM', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(137, 1, '13968/2165.111', 'BTLYNZ', NULL, '2024-11-11 07:41:31', NULL, 'NADIEN TRI KARTIKA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(138, 1, '13971/2168.111', 'ECSFNL', NULL, '2024-11-11 07:41:31', NULL, 'NASTRI AURORA DEWI NUR', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(139, 1, '13974/2171.111', 'OLAZTK', NULL, '2024-11-11 07:41:31', NULL, 'NEYSA NABILLA KALINDA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(140, 1, '13977/2174.111', 'YGUXPP', NULL, '2024-11-11 07:41:31', NULL, 'NURY AULIA KHOIRUNISSA', NULL, NULL, 1, 'Ruang 7, Sesi 1'),
(141, 1, '13980/2177.111', 'QOHPLD', NULL, '2024-11-11 07:41:31', NULL, 'RAFA DWI ANDIKA', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(142, 1, '13983/2180.111', 'BOPZWM', NULL, '2024-11-11 07:41:31', NULL, 'RENDRA ZACKY IRWANSYAH', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(143, 1, '13986/2183.111', 'RGZPPA', NULL, '2024-11-11 07:41:31', NULL, 'RIZKY IHSAN FADILLAH', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(144, 1, '13989/2186.111', 'FGTQNJ', NULL, '2024-11-11 07:41:31', NULL, 'SAIDA RAHMADANI KURNIAWATI', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(145, 1, '13992/2189.111', 'ATRVIW', NULL, '2024-11-11 07:41:31', NULL, 'SHALMAYRA EDINA RAMADIGNA', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(146, 1, '13995/2192.111', 'GETYWM', NULL, '2024-11-11 07:41:31', NULL, 'SULTAN RAFI NASHWAN JAYA', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(147, 1, '13998/2195.111', 'QKGUZC', NULL, '2024-11-11 07:41:31', NULL, 'VIKA KHARISMA PUTRI', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(148, 1, '14001/2198.111', 'RFYHYP', NULL, '2024-11-11 07:41:31', NULL, 'ZALVA ADELIA RISDIANTI', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(149, 2, '13897/2094.111', 'TYEVUO', NULL, '2024-11-11 07:41:31', NULL, 'ABYAN NAUFAL WIDYADANA', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(150, 2, '13900/2097.111', 'LMPLPX', NULL, '2024-11-11 07:41:31', NULL, 'ADEAYAWASSOFAH AL KYROMY', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(151, 2, '13903/2100.111', 'VSSQHO', NULL, '2024-11-11 07:41:31', NULL, 'AGALIH SANDI PRAMANA PUTRA', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(152, 2, '13906/2103.111', 'RUWFBQ', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD TEGAR NUR ZAKI', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(153, 2, '13909/2106.111', 'OYZBRO', NULL, '2024-11-11 07:41:31', NULL, 'ALFARICHI ARYAPUTRA', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(154, 2, '13912/2109.111', 'WHXWWS', NULL, '2024-11-11 07:41:31', NULL, 'ANAND IRSYAD ARKANA ZUFAR', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(155, 2, '13915/2112.111', 'QSCBEF', NULL, '2024-11-11 07:41:31', NULL, 'ANGGA ANUGRAH', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(156, 2, '13918/2115.111', 'AEUZAB', NULL, '2024-11-11 07:41:31', NULL, 'AURA IMELDA LUSSYANTI', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(157, 2, '13921/2118.111', 'FOVXWO', NULL, '2024-11-11 07:41:31', NULL, 'CLAUDIO ABOUBACHAR HAQQ', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(158, 2, '13924/2121.111', 'VDNDRI', NULL, '2024-11-11 07:41:31', NULL, 'DEARLY LUNA JAQUALINNE DZIKRI', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(159, 2, '13927/2124.111', 'RLJWET', NULL, '2024-11-11 07:41:31', NULL, 'DIAN PRATAMA PUTRI', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(160, 2, '13930/2127.111', 'UTVTDG', '', '2024-11-11 07:41:31', NULL, 'DWI WAHYUDI PUTRA', NULL, NULL, 1, 'Ruang 8, Sesi 1'),
(161, 2, '13933/2130.111', 'ZVKDTR', NULL, '2024-11-11 07:41:31', NULL, 'ESTI MULEANI HERNAWATI', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(162, 2, '13936/2133.111', 'AITCCU', NULL, '2024-11-11 07:41:31', NULL, 'FITRA TANIA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(163, 2, '13939/2136.111', 'RCFCDV', NULL, '2024-11-11 07:41:31', NULL, 'HAMZAH ARSAVIN ROMADHONI', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(164, 2, '13942/2139.111', 'OVCCUR', NULL, '2024-11-11 07:41:31', NULL, 'HANIF ADJI MUHAMMAD YAHYA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(165, 2, '13945/2142.111', 'PAHMMQ', NULL, '2024-11-11 07:41:31', NULL, 'HUSNIATUL MAJIDA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(166, 2, '13948/2145.111', 'SKIYMF', NULL, '2024-11-11 07:41:31', NULL, 'IMANUEL ABSYALOM', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(167, 2, '13951/2148.111', 'RTXISX', NULL, '2024-11-11 07:41:31', NULL, 'IZZ RAFIE PUTRA WIJAYA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(168, 2, '13954/2151.111', 'MSSMDX', NULL, '2024-11-11 07:41:31', NULL, 'KIRANI ALICIA PUTRI', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(169, 2, '13957/2154.111', 'BKPAUE', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD FAUZAN SULIYANTO', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(170, 2, '13960/2157.111', 'LWIWGY', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD ABIL ADZIM ZAKARIYA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(171, 2, '13963/2160.111', 'GPZNUZ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD KHOSYI RAFIF NASIROH', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(172, 2, '13966/2163.111', 'ZGEAIE', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD RASYA ALRASYID HARIANTO', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(173, 2, '13969/2166.111', 'WOSBTX', NULL, '2024-11-11 07:41:31', NULL, 'NADIN EVA SELIA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(174, 2, '13972/2169.111', 'DKBFHZ', NULL, '2024-11-11 07:41:31', NULL, 'NATANIA DWI ALTHAF', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(175, 2, '13975/2172.111', 'FGRQLX', NULL, '2024-11-11 07:41:31', NULL, 'NIKO FANDY WICAKSONO', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(176, 2, '13978/2175.111', 'QZNRVF', NULL, '2024-11-11 07:41:31', NULL, 'ORLANDO YEFINIDAS EXONERO', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(177, 2, '13981/2178.111', 'UDZFGP', NULL, '2024-11-11 07:41:31', NULL, 'RAFA MAHESWARA NURDIANSYAH', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(178, 2, '13984/2181.111', 'GRWHWQ', NULL, '2024-11-11 07:41:31', NULL, 'RIFA HIDAYATULLOH', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(179, 2, '13987/2184.111', 'XGFCQP', NULL, '2024-11-11 07:41:31', NULL, 'RIZQI SEKAR KUSUMA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(180, 2, '13990/2187.111', 'NYJBQK', NULL, '2024-11-11 07:41:31', NULL, 'SEBASTIAN FERDINAND MAHARDIKA', NULL, NULL, 1, 'Ruang 9, Sesi 1'),
(181, 2, '13993/2190.111', 'RLQJOQ', NULL, '2024-11-11 07:41:31', NULL, 'SHELYA YUMA RAMADHANI', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(182, 2, '13996/2193.111', 'RLICVN', NULL, '2024-11-11 07:41:31', NULL, 'TIARA DINDA AGUSTINA', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(183, 2, '13999/2196.111', 'VEEYNG', NULL, '2024-11-11 07:41:31', NULL, 'VIOLIEN TIARA KASIH AZZAHRA', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(184, 2, '14002/2199.111', 'UVBVPI', NULL, '2024-11-11 07:41:31', NULL, 'ZASKIA RAHMA PUTRI', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(185, 3, '13898/2095.111', 'NCHERS', NULL, '2024-11-11 07:41:31', NULL, 'ACHMAD SHOBAHUS SURUR', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(186, 3, '13901/2098.111', 'KMOCYX', NULL, '2024-11-11 07:41:31', NULL, 'ADELIA EKASYAM RAMADHANI', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(187, 3, '13904/2101.111', 'KEVLRU', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD BISSRI', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(188, 3, '13907/2104.111', 'RSGIIK', NULL, '2024-11-11 07:41:31', NULL, 'ALDI PRATAMA DINATA', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(189, 3, '13910/2107.111', 'BIKYZY', NULL, '2024-11-11 07:41:31', NULL, 'ALVINO MAULANA HERDANSYAH', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(190, 3, '13913/2110.111', 'YDZFWB', NULL, '2024-11-11 07:41:31', NULL, 'ANANDA NURUL AZIZAH', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(191, 3, '13916/2113.111', 'DJVCNU', NULL, '2024-11-11 07:41:31', NULL, 'ANINDYA ANGGIE PUTRI ISWANTO', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(192, 3, '13919/2116.111', 'MJRFRD', NULL, '2024-11-11 07:41:31', NULL, 'CALISTA SALSABILA NURENDRA', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(193, 3, '13922/2119.111', 'OWUNIB', NULL, '2024-11-11 07:41:31', NULL, 'CYBELE CALISTA PUTRI AYKO', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(194, 3, '13925/2122.111', 'SXIKCE', NULL, '2024-11-11 07:41:31', NULL, 'DEVIS PUTRI NABILA', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(195, 3, '13928/2125.111', 'XUUZGP', NULL, '2024-11-11 07:41:31', NULL, 'DONNI ARDIANSYAH', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(196, 3, '13931/2128.111', 'VYSZOU', NULL, '2024-11-11 07:41:31', NULL, 'EFENDI KUSUMA WARDANA', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(197, 3, '13934/2131.111', 'FYJOCG', NULL, '2024-11-11 07:41:31', NULL, 'FAISAL ANUGERAH RAMADHAN', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(198, 3, '13937/2134.111', 'AEKVZT', NULL, '2024-11-11 07:41:31', NULL, 'GENDIS DARA PERTIWI', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(199, 3, '13940/2137.111', 'AWUHRY', NULL, '2024-11-11 07:41:31', NULL, 'HANA EVANTHE BERYL AFIYAH', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(200, 3, '13943/2140.111', 'ZDCSLR', NULL, '2024-11-11 07:41:31', NULL, 'HASEANO SATRIA MOVIC', NULL, NULL, 1, 'Ruang 10, Sesi 1'),
(201, 3, '13946/2143.111', 'OZAYCZ', NULL, '2024-11-11 07:41:31', NULL, 'IIN ICNACIA KENDI', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(202, 3, '13949/2146.111', 'GOJMZF', NULL, '2024-11-11 07:41:31', NULL, 'ISNAINI NUR AZIZAH', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(203, 3, '13952/2149.111', 'TGIYPJ', NULL, '2024-11-11 07:41:31', NULL, 'JOVINE KAYLLA DWI PRANIA', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(204, 3, '13955/2152.111', 'MNHKSN', NULL, '2024-11-11 07:41:31', NULL, 'LMIRA RAHMANIA PUTRI', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(205, 3, '13958/2155.111', 'NLHHMG', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD RAFFY AFIF AFRIYANTO', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(206, 3, '13961/2158.111', 'YVTNXA', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD ASHRAFY AUZAN FIRMANSYAH', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(207, 3, '13964/2161.111', 'ZDWVQK', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD MAKHRUS', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(208, 3, '13967/2164.111', 'PVNZNY', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD REJA ANDIKA', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(209, 3, '13970/2167.111', 'XNPTRE', NULL, '2024-11-11 07:41:31', NULL, 'NANDA YULIANA RAHMA', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(210, 3, '13973/2170.111', 'YZWQAB', NULL, '2024-11-11 07:41:31', NULL, 'NAUFALIAN AZHAR KARIM', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(211, 3, '13976/2173.111', 'YVPRTE', NULL, '2024-11-11 07:41:31', NULL, 'NINDYA CARISSA MARWAH', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(212, 3, '13979/2176.111', 'MATTAO', NULL, '2024-11-11 07:41:31', NULL, 'RACHMADI ANANDA MAHARDIKA', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(213, 3, '13982/2179.111', 'EJGYZV', NULL, '2024-11-11 07:41:31', NULL, 'REFAND ADITYA', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(214, 3, '13985/2182.111', 'NESTUP', NULL, '2024-11-11 07:41:31', NULL, 'RIZKI AMINALDI FIRDAUS', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(215, 3, '13988/2185.111', 'SACUQV', NULL, '2024-11-11 07:41:31', NULL, 'ROSALIA NOVENA DAYU PUTRI', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(216, 3, '13991/2188.111', 'RSNLRY', NULL, '2024-11-11 07:41:31', NULL, 'SENA PUTRI PERTIWI', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(217, 3, '13994/2191.111', 'HWQKXW', NULL, '2024-11-11 07:41:31', NULL, 'SHEZA DEVITA PITALOKA', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(218, 3, '13997/2194.111', 'NXCWBS', NULL, '2024-11-11 07:41:31', NULL, 'VENUS NAJWA AZZNAR', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(219, 3, '14000/2197.111', 'OWTEAJ', NULL, '2024-11-11 07:41:31', NULL, 'YOLANDA AVRIZA SARASWATI', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(220, 12, '13502/834.117', 'GVMGDE', NULL, '2024-11-11 07:41:31', NULL, 'ACHMAD BAGUS AKAPRIANTO', NULL, NULL, 1, 'Ruang 11, Sesi 1'),
(221, 12, '13507/839.117', 'YMMEKF', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD ZIDANUL HIKAM', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(222, 12, '13512/844.117', 'SEVEIT', NULL, '2024-11-11 07:41:31', NULL, 'AQILLA REYHAN ZICIO WAHYUDI', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(223, 12, '13517/849.117', 'QFEQIA', NULL, '2024-11-11 07:41:31', NULL, 'CAHYA ISA MAULANA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(224, 12, '13522/854.117', 'OMZZED', NULL, '2024-11-11 07:41:31', NULL, 'GAGA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(225, 12, '13527/859.117', 'RGJAJL', NULL, '2024-11-11 07:41:31', NULL, 'IQBAL ADITYA PRATAMA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(226, 12, '13532/864.117', 'OBPARM', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMAD ABEE FAIRUZ FALA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(227, 12, '13537/869.117', 'ONSZNF', NULL, '2024-11-11 07:41:31', NULL, 'MOHAMAD RENO FERDIANSYAH', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(228, 12, '13542/874.117', 'DDRKHX', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FAIROZI ASSYIDIQI', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(229, 12, '13547/879.117', 'OQMECW', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD NUR WAHYU', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(230, 12, '13552/884.117', 'QOVNUS', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD RIFKI RAMADHANI', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(231, 12, '13557/889.117', 'USFMXJ', NULL, '2024-11-11 07:41:31', NULL, 'RAFI AHMAD DIANSYAH', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(232, 12, '13567/899.117', 'LJDDDV', NULL, '2024-11-11 07:41:31', NULL, 'VINO WIDIANSYAH', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(233, 12, '13570/965.113', 'XCKRYF', NULL, '2024-11-11 07:41:31', NULL, 'AFRIZATUL NAFSIYAH', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(234, 12, '13572/967.113', 'VKKDAF', NULL, '2024-11-11 07:41:31', NULL, 'AILA SILVANIA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(235, 12, '13574/969.113', 'UORTOC', NULL, '2024-11-11 07:41:31', NULL, 'ALIF NUR ANGGRAINI', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(236, 12, '13577/972.113', 'VFILHH', NULL, '2024-11-11 07:41:31', NULL, 'AMELIA DEWI CINTA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(237, 12, '13587/982.113', 'PFMIAO', NULL, '2024-11-11 07:41:31', NULL, 'DANERA KANA LIVESA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(238, 12, '13597/992.113', 'ZJTUJZ', NULL, '2024-11-11 07:41:31', NULL, 'KEYSA MARTHA AGUSTINA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(239, 12, '13602/997.113', 'KBXGIP', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD ANNAS ARROHIM', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(240, 12, '13607/1002.113', 'AWRZAR', NULL, '2024-11-11 07:41:31', NULL, 'NADIA AULIA ZAHRA', NULL, NULL, 1, 'Ruang 12, Sesi 1'),
(241, 12, '13612/1007.113', 'MERWFB', NULL, '2024-11-11 07:41:31', NULL, 'NOVITA ANGGRAINI', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(242, 12, '13617/1012.113', 'RNWGOB', NULL, '2024-11-11 07:41:31', NULL, 'RAULA SEPTIANA RAMADHAN', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(243, 12, '13627/1022.113', 'HHWPXC', NULL, '2024-11-11 07:41:31', NULL, 'YOSY YOLANDA NATHANIA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(244, 12, '13631/707.115', 'KMOOLQ', NULL, '2024-11-11 07:41:31', NULL, 'ACHMAD FADLY ZAKI IMANI', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(245, 12, '13632/708.115', 'IPKROO', NULL, '2024-11-11 07:41:31', NULL, 'ALFA SURYA GUMILANG', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(246, 12, '13637/713.115', 'REEMKE', NULL, '2024-11-11 07:41:31', NULL, 'AUFA BIMA AHADA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(247, 12, '13642/718.115', 'ZNFSRY', NULL, '2024-11-11 07:41:31', NULL, 'DAFFA SAPUTRA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(248, 12, '13647/723.115', 'OBKXMM', NULL, '2024-11-11 07:41:31', NULL, 'ELFAHRI TRISTAN ADITYA YUSUF', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(249, 12, '13652/728.115', 'UZGVRB', NULL, '2024-11-11 07:41:31', NULL, 'JERRY SETYO PAMUNGKAS', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(250, 12, '13657/733.115', 'RUFWPS', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMAD IRQAM ALMUZAKI', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(251, 12, '13662/738.115', 'UYCEBJ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD ABDILLAH ABY FASHIN', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(252, 12, '13667/743.115', 'HACSWN', NULL, '2024-11-11 07:41:31', NULL, 'NIKO PRATAMA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(253, 12, '13672/748.115', 'XPILXI', NULL, '2024-11-11 07:41:31', NULL, 'REZA MAULANA PUTRA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(254, 12, '13677/753.115', 'MHPROD', NULL, '2024-11-11 07:41:31', NULL, 'SYAHRIAL ASRORI', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(255, 13, '13503/835.117', 'WIROYC', NULL, '2024-11-11 07:41:31', NULL, 'ADNAN ARIF SIUDAN', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(256, 13, '13508/840.117', 'HXQJOT', NULL, '2024-11-11 07:41:31', NULL, 'ALDI SURYA SAPUTRA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(257, 13, '13513/845.117', 'MIHUGM', NULL, '2024-11-11 07:41:31', NULL, 'AZZAHRA ULFAYANI ILMIRA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(258, 13, '13518/850.117', 'JRIBFI', NULL, '2024-11-11 07:41:31', NULL, 'DIKA PUTRA PRATAMA', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(259, 13, '13523/855.117', 'XHSTZX', NULL, '2024-11-11 07:41:31', NULL, 'GAVINZOE KENNETH WIBOWO', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(260, 13, '13528/860.117', 'TYEHFO', NULL, '2024-11-11 07:41:31', NULL, 'KARUNIA SALAMAH', NULL, NULL, 1, 'Ruang 13, Sesi 1'),
(261, 13, '13533/865.117', 'MHCBKA', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMAD FAHRI SYAIFULILAH SASI MARHABAN', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(262, 13, '13538/870.117', 'DKETFE', NULL, '2024-11-11 07:41:31', NULL, 'MUCHAMAD ADITIYA GALANG SAPUTRA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(263, 13, '13543/875.117', 'QQOICQ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FIKRI NURROFI', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(264, 13, '13548/880.117', 'MDHKYP', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD RAFFI DWI CAHYA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(265, 13, '13553/885.117', 'AWZVWZ', NULL, '2024-11-11 07:41:31', NULL, 'NUGRAHA EKA YANUAR', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(266, 13, '13558/890.117', 'FNTAGL', NULL, '2024-11-11 07:41:31', NULL, 'RENDI DIMAS SAPUTRA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(267, 13, '13563/895.117', 'BABUPW', NULL, '2024-11-11 07:41:31', NULL, 'SURYA ANANTA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(268, 13, '13568/900.117', 'IOZZUM', NULL, '2024-11-11 07:41:31', NULL, 'YOSHUA ABDY SULTHAN ARKAMIL', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(269, 13, '13573/968.113', 'YDUTIM', NULL, '2024-11-11 07:41:31', NULL, 'AISYAH SAFINA SALSA B.G.', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(270, 13, '13578/973.113', 'NFEOVF', NULL, '2024-11-11 07:41:31', NULL, 'AMELIA INPRIANTI', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(271, 13, '13583/978.113', 'PSYMUK', NULL, '2024-11-11 07:41:31', NULL, 'BEMBY PUAN MAHARANI', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(272, 13, '13588/983.113', 'LYETLU', NULL, '2024-11-11 07:41:31', NULL, 'DENNYSA AURELYA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(273, 13, '13593/988.113', 'WHEAMH', NULL, '2024-11-11 07:41:31', NULL, 'GISELA DANAYA CAHYANTI', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(274, 13, '13598/993.113', 'DIPVDF', NULL, '2024-11-11 07:41:31', NULL, 'KHILWAH RAHAYU', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(275, 13, '13603/998.113', 'HJPRNJ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD HAMZAZIDAN', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(276, 13, '13608/1003.113', 'JOIIPC', NULL, '2024-11-11 07:41:31', NULL, 'NASYWA NITYA IKA SABELA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(277, 13, '13613/1008.113', 'STEPVV', NULL, '2024-11-11 07:41:31', NULL, 'NUR AZELLIN CINDY ARSITA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(278, 13, '13618/1013.113', 'IFFRDQ', NULL, '2024-11-11 07:41:31', NULL, 'REVA MAULIDIYA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(279, 13, '13623/1018.113', 'HRKNHW', NULL, '2024-11-11 07:41:31', NULL, 'TALITA NAVA AILSA', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(280, 13, '13633/709.115', 'YWZLXI', NULL, '2024-11-11 07:41:31', NULL, 'AMANDA LARASATI', NULL, NULL, 1, 'Ruang 14, Sesi 1'),
(281, 13, '13638/714.115', 'GEPFZU', NULL, '2024-11-11 07:41:31', NULL, 'BALQIS DEWI KEISYA', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(282, 13, '13643/719.115', 'TJVHVE', NULL, '2024-11-11 07:41:31', NULL, 'DICHA ARDIAN CHANAFI', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(283, 13, '13648/724.115', 'JWWYCS', NULL, '2024-11-11 07:41:31', NULL, 'FANNESA MANIQCA ANGEL', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(284, 13, '13653/729.115', 'VPYRJQ', NULL, '2024-11-11 07:41:31', NULL, 'KEVIN AL AVEIRO', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(285, 13, '13658/734.115', 'CDTLAH', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD RAFI YANUAR', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(286, 13, '13663/739.115', 'AOZUPQ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FELIX MUZAKKI', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(287, 13, '13668/744.115', 'AJBMQM', NULL, '2024-11-11 07:41:31', NULL, 'OCTAVIANA PUTRI CAHYA NINGRUM', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(288, 13, '13673/749.115', 'TIXAXR', NULL, '2024-11-11 07:41:31', NULL, 'RISDIANA WULANDARI', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(289, 13, '13678/754.115', 'OJGILC', NULL, '2024-11-11 07:41:31', NULL, 'UBAI DILLA MAULANA BAKTI', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(290, 14, '13504/836.117', 'FITBSG', NULL, '2024-11-11 07:41:31', NULL, 'ADRIAN LEXSA APRIANTA', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(291, 14, '13509/841.117', 'VUWKBV', NULL, '2024-11-11 07:41:31', NULL, 'ALDI WAHYU SAPUTRO', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(292, 14, '13514/846.117', 'HSTEAO', NULL, '2024-11-11 07:41:31', NULL, 'BAGUS SAPUTRA RAMADHAN', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(293, 14, '13519/851.117', 'HYKOLU', NULL, '2024-11-11 07:41:31', NULL, 'FEBRI KURNIAWAN', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(294, 14, '13524/856.117', 'MGZIWM', NULL, '2024-11-11 07:41:31', NULL, 'GRHISTIAN ARIANTO', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(295, 14, '13529/861.117', 'TDGNIZ', NULL, '2024-11-11 07:41:31', NULL, 'M IRSYAD DWI SATRIA', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(296, 14, '13534/866.117', 'LZPEBZ', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMAD RESTU PRASETYA', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(297, 14, '13539/871.117', 'CXZGAN', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMAD FAJAR SODIK', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(298, 14, '13544/876.117', 'XIQJNP', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD IQBAL AZZAHIR', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(299, 14, '13549/881.117', 'SYUQHI', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD RASYA TETUKO GALLANTRY', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(300, 14, '13554/886.117', 'VSXTVW', NULL, '2024-11-11 07:41:31', NULL, 'PRADITA AYU NUR FAUZIA', NULL, NULL, 1, 'Ruang 15, Sesi 1'),
(301, 14, '13559/891.117', 'KJSAMC', NULL, '2024-11-11 07:41:31', NULL, 'RENDI ARDIANSYAH', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(302, 14, '13564/896.117', 'DBWKZM', NULL, '2024-11-11 07:41:31', NULL, 'SYAHPUTRA DWI AGUS PRASETYO', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(303, 14, '13569/901.117', 'BJXXIQ', NULL, '2024-11-11 07:41:31', NULL, 'ZAMIR AZZAMY SYAUQI RASYID', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(304, 14, '13579/974.113', 'VFYCBQ', NULL, '2024-11-11 07:41:31', NULL, 'ANY HIDAYAH AGUSTINAH', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(305, 14, '13584/979.113', 'OQMMON', NULL, '2024-11-11 07:41:31', NULL, 'CHOIRUS SAADAH', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(306, 14, '13589/984.113', 'RQBDVQ', NULL, '2024-11-11 07:41:31', NULL, 'EKA ZAHRA NUR RAHMADHANI', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(307, 14, '13594/989.113', 'RBAUYT', NULL, '2024-11-11 07:41:31', NULL, 'HAPPY VICTORIA SALSABILAH', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(308, 14, '13599/994.113', 'RGKBYE', NULL, '2024-11-11 07:41:31', NULL, 'MAFITA FETRI DIANTI', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(309, 14, '13604/999.113', 'EGPDYD', NULL, '2024-11-11 07:41:31', NULL, 'NABILA RIZKI SALSABILA V', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(310, 14, '13609/1004.113', 'DOUBJV', NULL, '2024-11-11 07:41:31', NULL, 'NATHASYA PUTRI APRILIA', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(311, 14, '13614/1009.113', 'VQGALG', NULL, '2024-11-11 07:41:31', NULL, 'NURUL ISTIQOMAH', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(312, 14, '13619/1014.113', 'MYQTKW', NULL, '2024-11-11 07:41:31', NULL, 'REVALITA ANDANSARI', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(313, 14, '13624/1019.113', 'OVNNFC', NULL, '2024-11-11 07:41:31', NULL, 'VANESSA EKA PUTRI RAMADANI', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(314, 14, '13629/1024.113', 'AFVKDX', NULL, '2024-11-11 07:41:31', NULL, 'ZAHRA TALITA DZAKIRA', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(315, 14, '13634/710.115', 'LTZQQK', NULL, '2024-11-11 07:41:31', NULL, 'AMELIA HANNY KIRANA', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(316, 14, '13639/715.115', 'RYSWSK', NULL, '2024-11-11 07:41:31', NULL, 'BANYU BIRU ANDRA SIDHARTA', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(317, 14, '13644/720.115', 'WJCIKZ', NULL, '2024-11-11 07:41:31', NULL, 'DIKY OKTAVIANTO', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(318, 14, '13649/725.115', 'VLEMBV', NULL, '2024-11-11 07:41:31', NULL, 'FERY CHANDRA ADITRI', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(319, 14, '13654/730.115', 'UUPHTB', NULL, '2024-11-11 07:41:31', NULL, 'KEVIN VARIO PRATAMA HIDAYAT', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(320, 14, '13659/735.115', 'FKLXTY', NULL, '2024-11-11 07:41:31', NULL, 'MOH. IHSAN AZMI R.', NULL, NULL, 1, 'Ruang 16, Sesi 1'),
(321, 14, '13664/740.115', 'OIILUK', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD HABIB AL AZIZ', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(322, 14, '13669/745.115', 'IMFIIC', NULL, '2024-11-11 07:41:31', NULL, 'PUTRI SEKAR ARUM', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(323, 14, '13674/750.115', 'IKDLAB', NULL, '2024-11-11 07:41:31', NULL, 'RIZKY SYARIFFUDIN IBADI', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(324, 14, '13679/755.115', 'LYHVHA', NULL, '2024-11-11 07:41:31', NULL, 'VALLEN HAKAMSYAH VAHLEVI', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(325, 15, '13505/837.117', 'ORQGHA', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD FURQON ABDILLAH', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(326, 15, '13510/842.117', 'WUHWHS', NULL, '2024-11-11 07:41:31', NULL, 'ALFARO ENDRIAN PRATAMA', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(327, 15, '13515/847.117', 'LLTPAW', NULL, '2024-11-11 07:41:31', NULL, 'BAMBANG EKO PUTRANTO', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(328, 15, '13520/852.117', 'JFRGZT', NULL, '2024-11-11 07:41:31', NULL, 'FEBRIAN ADI FIRMANSAH', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(329, 15, '13525/857.117', 'DREHJB', NULL, '2024-11-11 07:41:31', NULL, 'HANIF AINUN IHSAN', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(330, 15, '13530/862.117', 'WYWIYT', NULL, '2024-11-11 07:41:31', NULL, 'MAHESA PUTRA NARENDRA', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(331, 15, '13535/867.117', 'RBQPGT', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD ALFATH PUTRA SUSANTO', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(332, 15, '13540/872.117', 'KPLUEW', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMAD YUSUF RHISWANDOYO', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(333, 15, '13545/877.117', 'SLYJMF', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD KHOIRUL RAMADHANI', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(334, 15, '13550/882.117', 'VHLBTR', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD REHAN', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(335, 15, '13555/887.117', 'MOSVKM', NULL, '2024-11-11 07:41:31', NULL, 'PUTRA RAMADHANI', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(336, 15, '13560/892.117', 'JXNKAY', NULL, '2024-11-11 07:41:31', NULL, 'RIDHO FIRMANSYAH', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(337, 15, '13565/897.117', 'VTCZYL', NULL, '2024-11-11 07:41:31', NULL, 'VAJAR MAULANA RIZKI', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(338, 15, '13575/970.113', 'LKMSVT', NULL, '2024-11-11 07:41:31', NULL, 'ALIVIA NUR AZIZA', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(339, 15, '13580/975.113', 'MPRHDT', NULL, '2024-11-11 07:41:31', NULL, 'ARIKA DIAH PUSPITASARI', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(340, 15, '13582/977.113', 'WJOHTG', '', '2024-11-11 07:41:31', NULL, 'BANYU SEKAR WANGI', NULL, NULL, 1, 'Ruang 17, Sesi 1'),
(341, 15, '13585/980.113', 'KZIRRO', NULL, '2024-11-11 07:41:31', NULL, 'CINDY PUSPITASARI', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(342, 15, '13590/985.113', 'YCWJBN', NULL, '2024-11-11 07:41:31', NULL, 'ERLINDA ZAHRA RAMADHANI', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(343, 15, '13595/990.113', 'WVJUJR', NULL, '2024-11-11 07:41:31', NULL, 'IMA NUR KHUSNA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(344, 15, '13600/995.113', 'EDWVMZ', NULL, '2024-11-11 07:41:31', NULL, 'MARSELITA ADITYA LAURA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(345, 15, '13605/1000.113', 'VFXKVC', NULL, '2024-11-11 07:41:31', NULL, 'NADIA ALMAFIRA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(346, 15, '13610/1005.113', 'SVQVCP', NULL, '2024-11-11 07:41:31', NULL, 'NAYSILLA CAESAR RATRI', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(347, 15, '13615/1010.113', 'QSOCXO', NULL, '2024-11-11 07:41:31', NULL, 'PINKAN PUTRI RAHMADANI', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(348, 15, '13620/1015.113', 'XZRMGC', NULL, '2024-11-11 07:41:31', NULL, 'SINDY PUTRI AMELIA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(349, 15, '13625/1020.113', 'TQSCHW', NULL, '2024-11-11 07:41:31', NULL, 'WASIS SURYA MUKTI', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(350, 15, '13630/706.115', 'AIULDJ', NULL, '2024-11-11 07:41:31', NULL, 'ABDI BAYU NUGRAHA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(351, 15, '13635/711.115', 'YSAXEE', NULL, '2024-11-11 07:41:31', NULL, 'ANDIKA DWI SUTANSAH', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(352, 15, '13640/716.115', 'WSMXJM', NULL, '2024-11-11 07:41:31', NULL, 'BERIL AVINZA TRISNANDA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(353, 15, '13645/721.115', 'JQYGKY', NULL, '2024-11-11 07:41:31', NULL, 'DIMAS ALFIAN PRANATA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(354, 15, '13650/726.115', 'TRMIPX', NULL, '2024-11-11 07:41:31', NULL, 'FRISCO IQBAL PRATAMA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(355, 15, '13655/731.115', 'BXEDBO', NULL, '2024-11-11 07:41:31', NULL, 'MEKHA AZZAHRA PRASETYO', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(356, 15, '13660/736.115', 'ISKFMF', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMAD REFAN MAULANA PRANATA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(357, 15, '13670/746.115', 'DLAMJZ', NULL, '2024-11-11 07:41:31', NULL, 'RAFI AZRIEL SYAFRIZAL', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(358, 15, '13675/751.115', 'INFPGP', NULL, '2024-11-11 07:41:31', NULL, 'SHAKA CATUR ATHALLAH', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(359, 15, '13680/756.115', 'SZYJCE', NULL, '2024-11-11 07:41:31', NULL, 'YOVI APRIYANSYAH PUTRA', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(360, 16, '13506/838.117', 'FRCFKW', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD RISKI ABDULLOH', NULL, NULL, 1, 'Ruang 18, Sesi 1'),
(361, 16, '13511/843.117', 'XYQDEV', NULL, '2024-11-11 07:41:31', NULL, 'ANDHIKA FAREL MUHAMMADI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(362, 16, '13516/848.117', 'LLPBJS', NULL, '2024-11-11 07:41:31', NULL, 'BAYU REZA RAHMA DANI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(363, 16, '13521/853.117', 'JQYSSI', NULL, '2024-11-11 07:41:31', NULL, 'FIKA YULIANTI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(364, 16, '13526/858.117', 'VANYOU', NULL, '2024-11-11 07:41:31', NULL, 'IBNU SINA MUJAHIDIN', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(365, 16, '13531/863.117', 'PPRBCS', NULL, '2024-11-11 07:41:31', NULL, 'MASAYU KEYSHA KIRANA', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(366, 16, '13536/868.117', 'SNYFLT', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD KHADAVI RADITYA', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(367, 16, '13541/873.117', 'VDRDEC', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD AGUS SETYAWAN', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(368, 16, '13546/878.117', 'MOUVPM', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD MEHISYAM', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(369, 16, '13551/883.117', 'EBNELD', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD RIDHO', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(370, 16, '13556/888.117', 'MVBZLM', '', '2024-11-11 07:41:31', NULL, 'RAFA ARDIAN PRATAMA', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(371, 16, '13561/893.117', 'ONNGGL', NULL, '2024-11-11 07:41:31', NULL, 'RISKY PRADANA ADISTIRA', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(372, 16, '13566/898.117', 'OMWBQF', NULL, '2024-11-11 07:41:31', NULL, 'VERDY AHMAD FIRMANSYAH', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(373, 16, '13571/966.113', 'BZHVMU', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD MAULANA HIDAYAT', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(374, 16, '13576/971.113', 'VNKJAS', NULL, '2024-11-11 07:41:31', NULL, 'AMANDA LILA RAMADHANTI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(375, 16, '13581/976.113', 'BBVSYV', NULL, '2024-11-11 07:41:31', NULL, 'AYESHA MUMTAZ QABEELA RAMADHANI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(376, 16, '13586/981.113', 'QJKDXZ', NULL, '2024-11-11 07:41:31', NULL, 'CLARA SION', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(377, 16, '13591/986.113', 'JVHCJD', NULL, '2024-11-11 07:41:31', NULL, 'ESTER KUSUMA WARDHANI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(378, 16, '13592/987.113', 'SXRGFP', NULL, '2024-11-11 07:41:31', NULL, 'EVI SULISTYOWATI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(379, 16, '13596/991.113', 'HEDJKE', NULL, '2024-11-11 07:41:31', NULL, 'KARINA KUS SUWANDARI', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(380, 16, '13601/996.113', 'DTYPIO', NULL, '2024-11-11 07:41:31', NULL, 'MARSYA TABITA KAMILA', NULL, NULL, 1, 'Ruang 19, Sesi 1'),
(381, 16, '13606/1001.113', 'RRBFJT', NULL, '2024-11-11 07:41:31', NULL, 'NADIA AMANDA PUTRI LESTARI', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(382, 16, '13611/1006.113', 'OYQLJX', NULL, '2024-11-11 07:41:31', NULL, 'NAZWA CANTIKA AZZAHRA', NULL, NULL, 1, 'Ruang 20, Sesi 1');
INSERT INTO `cbt_user` (`user_id`, `user_grup_id`, `user_name`, `user_password`, `user_email`, `user_regdate`, `user_ip`, `user_firstname`, `user_birthdate`, `user_birthplace`, `user_level`, `user_detail`) VALUES
(383, 16, '13616/1011.113', 'FYRNDE', NULL, '2024-11-11 07:41:31', NULL, 'RAFIAN ARYA SADEWA', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(384, 16, '13621/1016.113', 'KUWNTM', NULL, '2024-11-11 07:41:31', NULL, 'SITI AISYAH', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(385, 16, '13622/1017.113', 'NWGWNE', NULL, '2024-11-11 07:41:31', NULL, 'SYAFA SALSABILA', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(386, 16, '13626/1021.113', 'FZGNXT', NULL, '2024-11-11 07:41:31', NULL, 'YOSEPHA AMANDASARI DUA DELANG ', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(387, 16, '13636/712.115', 'BFVHUU', NULL, '2024-11-11 07:41:31', NULL, 'AQVA AFRIZAL SAFINDHI', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(388, 16, '13641/717.115', 'PWTXYX', NULL, '2024-11-11 07:41:31', NULL, 'CALVIN VILLA VAN DEE SAR', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(389, 16, '13646/722.115', 'ZXEFGD', NULL, '2024-11-11 07:41:31', NULL, 'DODIK SETIAWAN', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(390, 16, '13651/727.115', 'OEUINJ', NULL, '2024-11-11 07:41:31', NULL, 'HAFIDZ MAULANA', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(391, 16, '13656/732.115', 'NMFIUW', NULL, '2024-11-11 07:41:31', NULL, 'MOCH FADOL HIJA', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(392, 16, '13661/737.115', 'TFGMAJ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMAD ROBIL PUTRA ARIYONO', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(393, 16, '13666/742.115', 'HMVGNH', NULL, '2024-11-11 07:41:31', NULL, 'NADILAH AURA FARHA', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(394, 16, '13671/747.115', 'WVGLJW', NULL, '2024-11-11 07:41:31', NULL, 'RENDY ANDREYAS SAPUTRA', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(395, 16, '13676/752.115', 'OCBOWJ', NULL, '2024-11-11 07:41:31', NULL, 'SILFI DWI PRATIWI', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(396, 7, '14003/1664.063', 'XFGFNS', NULL, '2024-11-11 07:41:31', NULL, 'ABDURRAHMAN AHMAD AL GHIFFARI', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(397, 7, '14006/1667.063', 'ZQQCKJ', NULL, '2024-11-11 07:41:31', NULL, 'ADEL FITRI RAHMASARI', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(398, 7, '14009/1670.063', 'IETXVZ', NULL, '2024-11-11 07:41:31', NULL, 'AGUS RUBIANTO', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(399, 7, '14012/1673.063', 'LAZCFQ', NULL, '2024-11-11 07:41:31', NULL, 'ANDREA PRAMINDA SACHI', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(400, 7, '14015/1676.063', 'THPCQK', NULL, '2024-11-11 07:41:31', NULL, 'ATHIYA QURROTA AINA', NULL, NULL, 1, 'Ruang 20, Sesi 1'),
(401, 7, '14018/1679.063', 'RFIYKJ', NULL, '2024-11-11 07:41:31', NULL, 'BAYU RAMA PRIHAMBODO', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(402, 7, '14021/1682.063', 'SMSGJX', NULL, '2024-11-11 07:41:31', NULL, 'BUNGA CLARA OCTOBER', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(403, 7, '14024/1685.063', 'KXJQLB', NULL, '2024-11-11 07:41:31', NULL, 'DANIS MARCEL PUTRA WAHYU', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(404, 7, '14027/1688.063', 'MLJLCZ', NULL, '2024-11-11 07:41:31', NULL, 'ERINNA DIAN KRISTIANTI', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(405, 7, '14030/1691.063', 'NVKNTO', NULL, '2024-11-11 07:41:31', NULL, 'FAGAN BISMA ARKANANTA', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(406, 7, '14033/1694.063', 'AOGFUZ', NULL, '2024-11-11 07:41:31', NULL, 'FICO EKA RAMADHAN', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(407, 7, '14036/1697.063', 'AJXOQQ', NULL, '2024-11-11 07:41:31', NULL, 'HILMY INDRAWAN YUDHISTIRA', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(408, 7, '14039/1700.063', 'DIYIUE', NULL, '2024-11-11 07:41:31', NULL, 'ISAM HASIB AIDAN', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(409, 7, '14042/1703.063', 'PGRMSZ', NULL, '2024-11-11 07:41:31', NULL, 'KELVIN ALFATTAMA', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(410, 7, '14045/1706.063', 'MVTZMR', NULL, '2024-11-11 07:41:31', NULL, 'KIKI DWI SETYANINGRUM', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(411, 7, '14048/1709.063', 'GQGFTX', NULL, '2024-11-11 07:41:31', NULL, 'MAY SYESA RAHMAWATI', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(412, 7, '14051/1712.063', 'YEIAMS', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD DAFFA SAFRIUDIN', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(413, 7, '14054/1715.063', 'CRIQXF', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD BAIHAQQI NUR RISQI', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(414, 7, '14057/1718.063', 'MSFFLF', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FANDY FADHILLAH', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(415, 7, '14060/1721.063', 'INRLKR', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD SAFRIY NAAFIK', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(416, 7, '14063/1724.063', 'PPIHSO', NULL, '2024-11-11 07:41:31', NULL, 'NANCY AKISYA NURWIJAYANTI', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(417, 7, '14066/1727.063', 'UVMLFA', NULL, '2024-11-11 07:41:31', NULL, 'RADYA ERICK FEBRIANSYAH', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(418, 7, '14069/1730.063', 'YGRELE', NULL, '2024-11-11 07:41:31', NULL, 'RAYNA DEA KIRANA', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(419, 7, '14072/1733.063', 'HYWMQT', NULL, '2024-11-11 07:41:31', NULL, 'RIZQI CAHYA MAULIDA', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(420, 7, '14075/1736.063', 'BYQLWA', NULL, '2024-11-11 07:41:31', NULL, 'SEBASTIAN FREY', NULL, NULL, 1, 'Ruang 21, Sesi 1'),
(421, 7, '14078/1739.063', 'NXCHIA', NULL, '2024-11-11 07:41:31', NULL, 'SILVIA PUTRI ANGGRAINI', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(422, 7, '14081/1742.063', 'ZFVAOL', NULL, '2024-11-11 07:41:31', NULL, 'TASYA CHELSYA OLIVIA PUTRI', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(423, 7, '14084/1745.063', 'OJUVZF', NULL, '2024-11-11 07:41:31', NULL, 'VIKA AMELIA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(424, 7, '14087/1748.063', 'SZHWMA', NULL, '2024-11-11 07:41:31', NULL, 'ZAKHY YUNAN FANANI', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(425, 8, '13445/1614.063', 'PLAMFY', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD HAYCAL AKBAR', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(426, 8, '14004/1665.063', 'FPBGKG', NULL, '2024-11-11 07:41:31', NULL, 'ACHMAD ADAM SAJJAD ARIFIN', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(427, 8, '14007/1668.063', 'AJTTSD', NULL, '2024-11-11 07:41:31', NULL, 'ADHITAMA AZAR WICAKSONO ZEIN', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(428, 8, '14010/1671.063', 'TWLSUL', NULL, '2024-11-11 07:41:31', NULL, 'AISHEL SEVA OKTAVIA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(429, 8, '14013/1674.063', 'XZGMYD', NULL, '2024-11-11 07:41:31', NULL, 'ANGEL VERONIKA MEYLANIA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(430, 8, '14016/1677.063', 'NHJQXP', NULL, '2024-11-11 07:41:31', NULL, 'AZZAHRA CAHYA DESYIENTA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(431, 8, '14019/1680.063', 'IZQKXB', NULL, '2024-11-11 07:41:31', NULL, 'BAYU SATRYA PUTRA AREMA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(432, 8, '14022/1683.063', 'BRFVOH', NULL, '2024-11-11 07:41:31', NULL, 'BUNGA KIRANA EIFFEL OKAFILA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(433, 8, '14025/1686.063', 'QHCYAG', NULL, '2024-11-11 07:41:31', NULL, 'DAVID NAFISY', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(434, 8, '14028/1689.063', 'LUFCCI', NULL, '2024-11-11 07:41:31', NULL, 'EVAN DWIKA ISFANDRA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(435, 8, '14031/1692.063', 'ZKNNGX', NULL, '2024-11-11 07:41:31', NULL, 'FARDHAN VACCARI PRADIASYAH', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(436, 8, '14034/1695.063', 'CPTSUH', NULL, '2024-11-11 07:41:31', NULL, 'GALANG ARDIANSAH', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(437, 8, '14037/1698.063', 'EOASMC', NULL, '2024-11-11 07:41:31', NULL, 'HIRZI AQIILAH ANNAFI HEVA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(438, 8, '14040/1701.063', 'TQSMBV', NULL, '2024-11-11 07:41:31', NULL, 'JIBREEL BENJAMIN', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(439, 8, '14043/1704.063', 'CYIDHN', NULL, '2024-11-11 07:41:31', NULL, 'KEYSHA AZZAHRA ULFITRIA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(440, 8, '14046/1707.063', 'BFEHMM', NULL, '2024-11-11 07:41:31', NULL, 'LINDA ANGELLINA', NULL, NULL, 1, 'Ruang 22, Sesi 1'),
(441, 8, '14049/1710.063', 'YBLRCI', NULL, '2024-11-11 07:41:31', NULL, 'MOCH DAFFA ATHAILLAH ARIFIN', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(442, 8, '14052/1713.063', 'MYAVPX', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD SATRIA AGUNG', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(443, 8, '14055/1716.063', 'LVVXRG', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FADHLUR ROHMAN THORIQ', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(444, 8, '14058/1719.063', 'MURMBP', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FATTAH GIRI GHARSINA', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(445, 8, '14061/1722.063', 'UKDBBI', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD SAJIDAN FAHRI JUNAIDI', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(446, 8, '14064/1725.063', 'QDYMCS', NULL, '2024-11-11 07:41:31', NULL, 'NELGA AMANDA PUTRI ADI WIBOWO', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(447, 8, '14067/1728.063', 'NZETRX', NULL, '2024-11-11 07:41:31', NULL, 'RAFFI GANI JABBAARU', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(448, 8, '14070/1731.063', 'TLQKDT', NULL, '2024-11-11 07:41:31', NULL, 'REZA EKA SAPUTRA', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(449, 8, '14073/1734.063', 'YCZYYP', NULL, '2024-11-11 07:41:31', NULL, 'SATRIA ANUGRAH PRATAMA', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(450, 8, '14076/1737.063', 'AWXZMV', NULL, '2024-11-11 07:41:31', NULL, 'SELY ALJANNATA', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(451, 8, '14079/1740.063', 'JZMWNY', NULL, '2024-11-11 07:41:31', NULL, 'SURYA ADI NUGRAHA', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(452, 8, '14082/1743.063', 'LTOVAN', NULL, '2024-11-11 07:41:31', NULL, 'TRIAJI MITRAMAS FARELLI', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(453, 8, '14085/1746.063', 'XTRFRN', NULL, '2024-11-11 07:41:31', NULL, 'VIONA SEPTIASA LAILATUL RAMADHANI', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(454, 8, '14088/1749.063', 'VXDODY', NULL, '2024-11-11 07:41:31', NULL, 'ZAKI ADINATA PUTRA SETIAWAN', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(455, 9, '14005/1666.063', 'UZTMCC', NULL, '2024-11-11 07:41:31', NULL, 'ACHMAD RHOMADHON', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(456, 9, '14008/1669.063', 'DSOUQH', NULL, '2024-11-11 07:41:31', NULL, 'ADITYA NUR MAJID', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(457, 9, '14011/1672.063', 'EQZECK', NULL, '2024-11-11 07:41:31', NULL, 'ALJANNABI BIMA WICAKSONO', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(458, 9, '14014/1675.063', 'MLYXLB', NULL, '2024-11-11 07:41:31', NULL, 'ATHALLAH AZZAM LABIB', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(459, 9, '14017/1678.063', 'OWOTGT', NULL, '2024-11-11 07:41:31', NULL, 'BARBY CLARIZA OKVINASYA', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(460, 9, '14023/1684.063', 'XOVJHH', NULL, '2024-11-11 07:41:31', NULL, 'CANDRA QORIUL UMMA', NULL, NULL, 1, 'Ruang 23, Sesi 1'),
(461, 9, '14026/1687.063', 'WZBXGP', NULL, '2024-11-11 07:41:31', NULL, 'DURRATUL DAKA PAMUNGKAS', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(462, 9, '14029/1690.063', 'VYGTFR', NULL, '2024-11-11 07:41:31', NULL, 'FADLI AKBAR', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(463, 9, '14032/1693.063', 'ISRIXA', NULL, '2024-11-11 07:41:31', NULL, 'FERI FERDIANTO', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(464, 9, '14035/1696.063', 'IRFXUY', NULL, '2024-11-11 07:41:31', NULL, 'HAFIZH HISBULLAH', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(465, 9, '14038/1699.063', 'FNTVTI', NULL, '2024-11-11 07:41:31', NULL, 'IRMAN MAULANA SAPUTRA', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(466, 9, '14041/1702.063', 'UVWQOC', NULL, '2024-11-11 07:41:31', NULL, 'JOVAN LIONEL GEORGIO', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(467, 9, '14044/1705.063', 'QVZBAX', NULL, '2024-11-11 07:41:31', NULL, 'KHAILA FARHAN ABADAN', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(468, 9, '14047/1708.063', 'DHJZFD', NULL, '2024-11-11 07:41:31', NULL, 'MAULANA MIZWAR SYARIF AL MUAFA', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(469, 9, '14050/1711.063', 'IPTLUQ', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMAD BIMA MAULANA PUTRA', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(470, 9, '14053/1714.063', 'SNLYEH', NULL, '2024-11-11 07:41:31', NULL, 'MUCHAMMAD ZAYYAAN AQEEL', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(471, 9, '14056/1717.063', 'ZGRWJB', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FADIL ZACKYANSYAH', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(472, 9, '14059/1720.063', 'OLNZVW', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD RIZKY ALVARO', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(473, 9, '14062/1723.063', 'PFRVHX', NULL, '2024-11-11 07:41:31', NULL, 'NADIA SHEIRA DEWI', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(474, 9, '14065/1726.063', 'NCKVQC', NULL, '2024-11-11 07:41:31', NULL, 'OKTAVIA PUTRI BUDIANSYAH', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(475, 9, '14068/1729.063', 'DZLZBX', NULL, '2024-11-11 07:41:31', NULL, 'RAGA FITRAH BANYU NABALA', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(476, 9, '14071/1732.063', 'VPBLWA', NULL, '2024-11-11 07:41:31', NULL, 'RIFENSA RENATA MAULIDAH', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(477, 9, '14074/1735.063', 'SSLTYK', NULL, '2024-11-11 07:41:31', NULL, 'SATRIYA BUMI HARJA PURWANTO', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(478, 9, '14077/1738.063', 'OFUPZT', NULL, '2024-11-11 07:41:31', NULL, 'SILVIA AZZARAH PUTRI NASZWAH', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(479, 9, '14080/1741.063', 'OBHRBE', NULL, '2024-11-11 07:41:31', NULL, 'SYIFA NASYIRA SALSABILA', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(480, 9, '14083/1744.063', 'NOOCBV', NULL, '2024-11-11 07:41:31', NULL, 'TRIO ZALDIYANSYAH HERLAMBANG', NULL, NULL, 1, 'Ruang 24, Sesi 1'),
(481, 9, '14086/1747.063', 'ACDFNA', NULL, '2024-11-11 07:41:31', NULL, 'YUWAN REZA RAMADHAN', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(482, 9, '14089/1750.063', 'PAPKVB', NULL, '2024-11-11 07:41:31', NULL, 'ZIDAN ALFA PERMANA', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(483, 4, '13683/2263.066', 'NEMOOB', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD ABIGAIL', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(484, 4, '13686/2266.066', 'ZHGKYE', NULL, '2024-11-11 07:41:31', NULL, 'ALLAN MAULANA RIZKY', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(485, 4, '13689/2269.066', 'ZTUZRR', NULL, '2024-11-11 07:41:31', NULL, 'APRIONO TRITIO ALVINO', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(486, 4, '13692/2272.066', 'NOMUBL', NULL, '2024-11-11 07:41:31', NULL, 'ARDIKA RAMA PUTRA WARDANA', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(487, 4, '13695/2275.066', 'XWLCIS', NULL, '2024-11-11 07:41:31', NULL, 'ARYA BAYU SUTA', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(488, 4, '13698/2278.066', 'PUOBXG', NULL, '2024-11-11 07:41:31', NULL, 'ATHAYLAH ZAKKI SATRIO', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(489, 4, '13701/2281.066', 'LUARRM', NULL, '2024-11-11 07:41:31', NULL, 'AZEL UBAIDILLAH', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(490, 4, '13704/2284.066', 'TGHCRM', NULL, '2024-11-11 07:41:31', NULL, 'CAHYO WIJAYANTO', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(491, 4, '13707/2287.066', 'YOSPJF', NULL, '2024-11-11 07:41:31', NULL, 'CHRISTHIAN ANTON WIBISONO', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(492, 4, '13710/2290.066', 'LZCIKO', NULL, '2024-11-11 07:41:31', NULL, 'DAVISTA UMAH DANI', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(493, 4, '13713/2293.066', 'GLJFNN', NULL, '2024-11-11 07:41:31', NULL, 'DZIBAN DERIS FAEZYA', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(494, 4, '13716/2296.066', 'DJCNWD', NULL, '2024-11-11 07:41:31', NULL, 'FAUZAN AHMAD FIRDAUS', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(495, 4, '13719/2299.066', 'TRTHOU', NULL, '2024-11-11 07:41:31', NULL, 'FIRDAFIF AHSAN', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(496, 4, '13722/2302.066', 'RZUAVH', NULL, '2024-11-11 07:41:31', NULL, 'HANDIKA NUR TOHA', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(497, 4, '13725/2305.066', 'SJXNPW', NULL, '2024-11-11 07:41:31', NULL, 'JAVIER ARKA IRSY RAMADHAN', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(498, 4, '13728/2308.066', 'QMUHXE', NULL, '2024-11-11 07:41:31', NULL, 'LENY MAISAROH', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(499, 4, '13731/2311.066', 'GZOBIF', NULL, '2024-11-11 07:41:31', NULL, 'MAZIYYATUN NISWAH', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(500, 4, '13734/2314.066', 'JYKAKD', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMAD NUR HAMID', NULL, NULL, 1, 'Ruang 25, Sesi 1'),
(501, 4, '13737/2317.066', 'IVJFWI', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD THARIQ AL JANABI', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(502, 4, '13740/2320.066', 'AVNRIQ', NULL, '2024-11-11 07:41:31', NULL, 'MUCHAMMAD IBRAM ABDULLAH', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(503, 4, '13743/2323.066', 'XWILRV', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FIKRIE AL DIEN SHABILILLAH', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(504, 4, '13746/2326.066', 'BPZZOW', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD IRSYAD PRATAMA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(505, 4, '13749/2329.066', 'XHUWZM', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD SHOHIBAL QURANA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(506, 4, '13752/2332.066', 'HOUTRI', NULL, '2024-11-11 07:41:31', NULL, 'NESHYA VIRGINIA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(507, 4, '13755/2335.066', 'FHYWKR', NULL, '2024-11-11 07:41:31', NULL, 'NUR AFIFATUL RODIYAH', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(508, 4, '13758/2338.066', 'VPZPSX', NULL, '2024-11-11 07:41:31', NULL, 'PARAS CHOLIFA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(509, 4, '13761/2341.066', 'EJEGNG', NULL, '2024-11-11 07:41:31', NULL, 'PRASETYO OKTA ERIANTO', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(510, 4, '13764/2344.066', 'WCHGSU', NULL, '2024-11-11 07:41:31', NULL, 'RADIT FERDINAND IMSYADEWA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(511, 4, '13767/2347.066', 'VUULSF', NULL, '2024-11-11 07:41:31', NULL, 'REVANDRA ADITYA DEVANO', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(512, 4, '13770/2350.066', 'YSCKFS', NULL, '2024-11-11 07:41:31', NULL, 'RIDHO SANJAYA PUTRA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(513, 4, '13773/2353.066', 'IPTNAK', NULL, '2024-11-11 07:41:31', NULL, 'SANDI PRATAMA PUTRA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(514, 4, '13776/2356.066', 'FCSCTR', NULL, '2024-11-11 07:41:31', NULL, 'SURYA AFLAH ERDIANPUTRA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(515, 4, '13779/2359.066', 'MKPBZD', NULL, '2024-11-11 07:41:31', NULL, 'YUSUF ADI WIBOWO', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(516, 4, '13782/2362.066', 'CTBPCX', NULL, '2024-11-11 07:41:31', NULL, 'ZAKARIA ABDUL RIZKI', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(517, 5, '13681/2261.066', 'VZLZKV', NULL, '2024-11-11 07:41:31', NULL, 'ABIM MAULANA RAGA MULYA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(518, 5, '13684/2264.066', 'ACXXRX', NULL, '2024-11-11 07:41:31', NULL, 'AHMAD DAFIN MAULANA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(519, 5, '13687/2267.066', 'JWLIII', NULL, '2024-11-11 07:41:31', NULL, 'ALVA RAMADHAN', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(520, 5, '13690/2270.066', 'KZPDSY', NULL, '2024-11-11 07:41:31', NULL, 'AQILA OKTA FATIM AZZAHRA', NULL, NULL, 1, 'Ruang 26, Sesi 1'),
(521, 5, '13693/2273.066', 'GCJDOV', NULL, '2024-11-11 07:41:31', NULL, 'ARIA EKA SAPUTRA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(522, 5, '13696/2276.066', 'UMLJDF', NULL, '2024-11-11 07:41:31', NULL, 'ARYA BINTANG MAULANA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(523, 5, '13699/2279.066', 'TKYOGH', NULL, '2024-11-11 07:41:31', NULL, 'AULIA LUKCY FEBIANA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(524, 5, '13702/2282.066', 'KYUWCE', NULL, '2024-11-11 07:41:31', NULL, 'AZZA NUR RAFI FADILAH HARSONO', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(525, 5, '13705/2285.066', 'ZWQMCX', NULL, '2024-11-11 07:41:31', NULL, 'CARIA DWITA MAYURA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(526, 5, '13708/2288.066', 'RWHTTY', NULL, '2024-11-11 07:41:31', NULL, 'CRISNA PUTRA YULIANSYAH', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(527, 5, '13711/2291.066', 'VJRNWM', NULL, '2024-11-11 07:41:31', NULL, 'DEVITA AYU NUR INDAH SARI', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(528, 5, '13714/2294.066', 'QLARIN', NULL, '2024-11-11 07:41:31', NULL, 'ERZA NAZRIL ATHAARIQSYAH', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(529, 5, '13717/2297.066', 'OBGGPF', NULL, '2024-11-11 07:41:31', NULL, 'FERLINDIANSYAH FAHRIL ZAKARIA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(530, 5, '13720/2300.066', 'RTSUDL', NULL, '2024-11-11 07:41:31', NULL, 'GALIH CANDRA KUSUMA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(531, 5, '13723/2303.066', 'EMTJXS', NULL, '2024-11-11 07:41:31', NULL, 'ILHAM SYAHPUTRA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(532, 5, '13726/2306.066', 'LLPPTZ', NULL, '2024-11-11 07:41:31', NULL, 'JHYHAN NOER RIANTY OKTAVIA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(533, 5, '13729/2309.066', 'UBLLVN', NULL, '2024-11-11 07:41:31', NULL, 'M NAUFAL AL HAQQI', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(534, 5, '13732/2312.066', 'AYCZTX', NULL, '2024-11-11 07:41:31', NULL, 'MIFTA HUS SYIFA ALMA MISCHA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(535, 5, '13735/2315.066', 'PKMXAM', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD BAGAS SAPUTRA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(536, 5, '13738/2318.066', 'QXGBVA', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD ZIDANE MAHARDHIKA', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(537, 5, '13741/2321.066', 'HWWUQE', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMAD THORIQ RISWANTORO', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(538, 5, '13744/2324.066', 'IRNLUJ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD FIRMAN ALAMSYAH', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(539, 5, '13747/2327.066', 'MUFCZA', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD PUTRA HARUN', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(540, 5, '13750/2330.066', 'GBJNRY', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD TSULLASIL MUKARROMI', NULL, NULL, 1, 'Ruang 27, Sesi 1'),
(541, 5, '13753/2333.066', 'PGPQII', NULL, '2024-11-11 07:41:31', NULL, 'NOVIANA KHANSA EKA SAVIRA', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(542, 5, '13756/2336.066', 'SGZDEO', NULL, '2024-11-11 07:41:31', NULL, 'OKKY RIZKY MAULANA', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(543, 5, '13759/2339.066', 'YAUOIR', NULL, '2024-11-11 07:41:31', NULL, 'PEFFY DWI PRAYUDO', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(544, 5, '13762/2342.066', 'CIKOEV', NULL, '2024-11-11 07:41:31', NULL, 'QESYA MAULIDINA ARIANTI', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(545, 5, '13765/2345.066', 'MGFKPP', NULL, '2024-11-11 07:41:31', NULL, 'RENO MAULANA SUBEKTI', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(546, 5, '13768/2348.066', 'HZDVJV', NULL, '2024-11-11 07:41:31', NULL, 'RIDHO INDRA ARDIANSYAH', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(547, 5, '13771/2351.066', 'RSBNCX', NULL, '2024-11-11 07:41:31', NULL, 'SAFAREL RENOVAN SAPUTRA', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(548, 5, '13774/2354.066', 'TNSWEJ', NULL, '2024-11-11 07:41:31', NULL, 'SATRIA DAMAR PAMUNGKAS', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(549, 5, '13777/2357.066', 'LWYPPE', NULL, '2024-11-11 07:41:31', NULL, 'TIARA SYAUQIYAH BILLAH', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(550, 5, '13780/2360.066', 'IEVXSO', NULL, '2024-11-11 07:41:31', NULL, 'ZAHRANI ANASTASYA', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(551, 5, '13783/2363.066', 'LAEPSW', NULL, '2024-11-11 07:41:31', NULL, 'ZHACKY ALVY RAMADHANI', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(552, 6, '13682/2262.066', 'KQGXWG', NULL, '2024-11-11 07:41:31', NULL, 'ACHMAD DARIL ANWAR', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(553, 6, '13685/2265.066', 'LIRDOB', NULL, '2024-11-11 07:41:31', NULL, 'ALDO REIHAN FIRMANSYAH', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(554, 6, '13688/2268.066', 'GDHFBR', NULL, '2024-11-11 07:41:31', NULL, 'APRILIA CANTIKA', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(555, 6, '13691/2271.066', 'ANZQEB', NULL, '2024-11-11 07:41:31', NULL, 'ARDIANSYAH RAMADHANI', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(556, 6, '13694/2274.066', 'BVYAVU', NULL, '2024-11-11 07:41:31', NULL, 'ARIANY DWI OKTAVIANI', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(557, 6, '13697/2277.066', 'TZAZUI', NULL, '2024-11-11 07:41:31', NULL, 'ATAYA FIKRI KRISYANTO', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(558, 6, '13700/2280.066', 'FDQFPD', NULL, '2024-11-11 07:41:31', NULL, 'AXZELL PRAMUDIKA', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(559, 6, '13703/2283.066', 'UOIWAR', NULL, '2024-11-11 07:41:31', NULL, 'BRILLIAN SINGGIH NUR ROHMAD', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(560, 6, '13706/2286.066', 'ATUKOC', NULL, '2024-11-11 07:41:31', NULL, 'CHESYA WIDYA SETIAWAN', NULL, NULL, 1, 'Ruang 28, Sesi 1'),
(561, 6, '13709/2289.066', 'LKWHTE', NULL, '2024-11-11 07:41:31', NULL, 'DASCHA DIAMANTHARA PUTRI ARINDI', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(562, 6, '13712/2292.066', 'JOGSKE', NULL, '2024-11-11 07:41:31', NULL, 'DIAZ ARINDA TRISTANTI', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(563, 6, '13715/2295.066', 'VZTVKH', NULL, '2024-11-11 07:41:31', NULL, 'FATTAH RIZKY ANDHIKA PUTRA HARSONO', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(564, 6, '13718/2298.066', 'DQHCZX', NULL, '2024-11-11 07:41:31', NULL, 'FIKRI BARIQ PRATAMA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(565, 6, '13721/2301.066', 'QZYTNA', NULL, '2024-11-11 07:41:31', NULL, 'GIO ALFA DEWANTARA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(566, 6, '13724/2304.066', 'OTKHSJ', NULL, '2024-11-11 07:41:31', NULL, 'IRSYAD ZUHDI SYAIFULLAH', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(567, 6, '13727/2307.066', 'YNBNOT', NULL, '2024-11-11 07:41:31', NULL, 'LAILATUN NISFHI SYAHRAINI', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(568, 6, '13730/2310.066', 'CAFFVD', NULL, '2024-11-11 07:41:31', NULL, 'MAULIDIA HAMIDA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(569, 6, '13733/2313.066', 'DAHRDB', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMAD HISYAM ARKA RAFERTY', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(570, 6, '13736/2316.066', 'SLAHAT', NULL, '2024-11-11 07:41:31', NULL, 'MOCHAMMAD DICKY CHANDRA SYAPUTRA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(571, 6, '13739/2319.066', 'RVMSSV', NULL, '2024-11-11 07:41:31', NULL, 'MOHAMMAD DEKKA WAHYU PUTRANTOMO', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(572, 6, '13742/2322.066', 'LFFHDZ', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD ABDURRAHMAN AUFI', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(573, 6, '13745/2325.066', 'SCDNRB', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD IRSYAD ARAS', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(574, 6, '13748/2328.066', 'JZBKNK', NULL, '2024-11-11 07:41:31', NULL, 'MUHAMMAD REZA ESA NANDA PUTRA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(575, 6, '13751/2331.066', 'CMEYVG', NULL, '2024-11-11 07:41:31', NULL, 'MUTIARA PUTRI ZIVANA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(576, 6, '13754/2334.066', 'ZGIQUH', NULL, '2024-11-11 07:41:31', NULL, 'NOVIANTI TRI WARDHANI', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(577, 6, '13757/2337.066', 'CQZFBQ', NULL, '2024-11-11 07:41:31', NULL, 'OLIVIA MELITA MARGARETA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(578, 6, '13760/2340.066', 'RVUHUS', NULL, '2024-11-11 07:41:31', NULL, 'PRANANDA CHARIS YULIANTO', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(579, 6, '13763/2343.066', 'QDPTAQ', NULL, '2024-11-11 07:41:31', NULL, 'RACHMAD AKBAR ARIEVIANSYAH', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(580, 6, '13766/2346.066', 'OBJSMZ', NULL, '2024-11-11 07:41:31', NULL, 'REVAN MAYLANDRO DJANGKARO PRATAMA', NULL, NULL, 1, 'Ruang 29, Sesi 1'),
(581, 6, '13769/2349.066', 'WJOCEJ', NULL, '2024-11-11 07:41:31', NULL, 'RIDHO MUSAFAK GUNAWAN', NULL, NULL, 1, 'Ruang 30, Sesi 1'),
(582, 6, '13772/2352.066', 'UOKCWA', NULL, '2024-11-11 07:41:31', NULL, 'SALMA KHAIRUN NISA', NULL, NULL, 1, 'Ruang 30, Sesi 1'),
(583, 6, '13775/2355.066', 'YCXZRH', NULL, '2024-11-11 07:41:31', NULL, 'SEBASTIAN NAVARO FAZARI', NULL, NULL, 1, 'Ruang 30, Sesi 1'),
(584, 6, '13778/2358.066', 'CSIHXZ', NULL, '2024-11-11 07:41:31', NULL, 'WISNU FITRAH PRATAMA', NULL, NULL, 1, 'Ruang 30, Sesi 1'),
(585, 6, '13781/2361.066', 'YAMXBN', NULL, '2024-11-11 07:41:31', NULL, 'ZAHRATUS SADIYAH', NULL, NULL, 1, 'Ruang 30, Sesi 1'),
(586, 38, '123456', '123456', '', '2024-11-13 14:49:05', NULL, 'Dian Purwanto', NULL, NULL, 1, 'Kelas Uji Coba'),
(587, 28, '13214/946.127', 'UAWRFW', NULL, '2024-11-19 13:08:55', NULL, 'ABDA ABDILLAH', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(588, 28, '13215/947.127', 'AKYLGG', NULL, '2024-11-19 13:08:55', NULL, 'ABDURRAHMAN WAHID', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(589, 28, '13216/948.127', 'ZQYXST', NULL, '2024-11-19 13:08:55', NULL, 'ACHMAD FABIAN YUGO YULIANTO', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(590, 28, '13217/949.127', 'RCBMIE', NULL, '2024-11-19 13:08:55', NULL, 'AHMAD DAFFA JIBRIL MARUF', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(591, 28, '13218/950.127', 'YEIIHL', NULL, '2024-11-19 13:08:55', NULL, 'AHMAD DAVIN AFRIANSYAH', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(592, 28, '13219/951.127', 'ZQLEZY', NULL, '2024-11-19 13:08:55', NULL, 'AHMAD RODHI GIBRAN ALFARROS', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(593, 28, '13220/952.127', 'TXOJRJ', NULL, '2024-11-19 13:08:55', NULL, 'ALMAGHFIRA PUTRI HANJONO', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(594, 28, '13221/953.127', 'KAMACA', NULL, '2024-11-19 13:08:55', NULL, 'AMANDA KRISNA XAVERIA SARASWATI', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(595, 28, '13222/954.127', 'JFQSZD', NULL, '2024-11-19 13:08:55', NULL, 'ANDINA HARI MARISHA', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(596, 28, '13223/955.127', 'CIMDZT', NULL, '2024-11-19 13:08:55', NULL, 'ANDREA DEVYNA SISY', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(597, 28, '13224/956.127', 'FTQLCU', NULL, '2024-11-19 13:08:55', NULL, 'ARAFFI GALIH BAGUS NUGROHO', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(598, 28, '13225/957.127', 'NUIVZQ', NULL, '2024-11-19 13:08:55', NULL, 'ARDANA HARI MARCELA', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(599, 28, '13226/958.127', 'CHWUNV', NULL, '2024-11-19 13:08:55', NULL, 'ARDIANSYAH SURYA PRATAMA', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(600, 28, '13227/959.127', 'ZYEKLX', NULL, '2024-11-19 13:08:56', NULL, 'ARINDI PUTRISARI SALSABILAH', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(601, 28, '13228/960.127', 'AJAMSY', NULL, '2024-11-19 13:08:56', NULL, 'ARIZAL PUTRA RAMADHAN', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(602, 28, '13229/961.127', 'GEGDXG', NULL, '2024-11-19 13:08:56', NULL, 'CANNAVARO GILBERT NATHANAEL NUGROHO', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(603, 28, '13230/962.127', 'YYRZLC', NULL, '2024-11-19 13:08:56', NULL, 'CANTIKA ZAHRA JOAQUEEN', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(604, 28, '13231/963.127', 'ZJHURI', NULL, '2024-11-19 13:08:56', NULL, 'CELENA EL FARETTA', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(605, 28, '13232/964.127', 'RCSAQR', NULL, '2024-11-19 13:08:56', NULL, 'DICKY SAPUTRA', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(606, 28, '13233/965.127', 'QUDTJB', NULL, '2024-11-19 13:08:56', NULL, 'ELSA AZULA', NULL, NULL, 1, 'Ruang 1, Sesi 2'),
(607, 28, '13234/966.127', 'CVKZPQ', NULL, '2024-11-19 13:08:56', NULL, 'FAIZ ABDULLAH MUTI\\\'', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(608, 28, '13235/967.127', 'XZMSVO', NULL, '2024-11-19 13:08:56', NULL, 'FAJAR HIDAYATURAHMAD DHANI', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(609, 28, '13236/968.127', 'GITOHO', NULL, '2024-11-19 13:08:56', NULL, 'FARIAN NUR ROCHMAN', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(610, 28, '13237/969.127', 'TPYKQK', NULL, '2024-11-19 13:08:56', NULL, 'FIRMANSYAH ALFANUR AZIZ', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(611, 28, '13238/970.127', 'WKVTUN', NULL, '2024-11-19 13:08:56', NULL, 'GALANG SAPUTRA WENI', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(612, 28, '13239/971.127', 'ICGJBY', NULL, '2024-11-19 13:08:56', NULL, 'GAYATRI CITRA SARASWATI', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(613, 28, '13240/972.127', 'BSFFME', NULL, '2024-11-19 13:08:56', NULL, 'HAFIZ FEBRIAN PUTRA SETYAWAN', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(614, 28, '13241/973.127', 'DDZNBV', NULL, '2024-11-19 13:08:56', NULL, 'HANIFAH AJENG PRATIWI', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(615, 28, '13242/974.127', 'YUOMMU', NULL, '2024-11-19 13:08:56', NULL, 'JAUZA MAULIDIANI IMAMI', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(616, 28, '13243/975.127', 'ICZCID', NULL, '2024-11-19 13:08:56', NULL, 'JELITA MAY JILAN', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(617, 28, '13244/976.127', 'XLOWEE', NULL, '2024-11-19 13:08:56', NULL, 'KENZA CHAVIA CUCU HARYONO', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(618, 28, '13245/977.127', 'FEPDQL', NULL, '2024-11-19 13:08:56', NULL, 'KHANSA ZAKIYYAH NAFISAH', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(619, 28, '13246/978.127', 'ZSPCJQ', NULL, '2024-11-19 13:08:56', NULL, 'MIFTAHUL AULIA', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(620, 28, '13247/979.127', 'UHYCDB', NULL, '2024-11-19 13:08:56', NULL, 'MOCH ANAS ABDUL LATIEF', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(621, 28, '13500/1014.127', 'KYTOWM', NULL, '2024-11-19 13:08:56', NULL, 'DANIEL', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(622, 29, '12580/888.127', 'LJOGKS', NULL, '2024-11-19 13:08:56', NULL, 'BRASRIYALOKA LUDMASDIRA', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(623, 29, '12608/916.127', 'DZTCIZ', NULL, '2024-11-19 13:08:56', NULL, 'MUCH NOVAL SAPUTRA', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(624, 29, '13249/981.127', 'GKZFIK', NULL, '2024-11-19 13:08:56', NULL, 'MUHAMMAD FACHRIEL DWI SAPUTRA', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(625, 29, '13250/982.127', 'JSVOVR', NULL, '2024-11-19 13:08:56', NULL, 'MUHAMMAD LANANG ABDILLAH', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(626, 29, '13251/983.127', 'FTSTSA', NULL, '2024-11-19 13:08:56', NULL, 'MUHAMMAD NABIL SADEWO', NULL, NULL, 1, 'Ruang 2, Sesi 2'),
(627, 29, '13252/984.127', 'MVTDIO', NULL, '2024-11-19 13:08:56', NULL, 'MUKHAMMAD KHARIES KHABIBUR ROHMAN', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(628, 29, '13253/985.127', 'ZQKFGB', NULL, '2024-11-19 13:08:56', NULL, 'MUTIARA AZZAHRANI DWI NUR IFADA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(629, 29, '13254/986.127', 'IRPUWM', NULL, '2024-11-19 13:08:56', NULL, 'NABIL IRFANYUDI', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(630, 29, '13255/987.127', 'RWVZVT', NULL, '2024-11-19 13:08:56', NULL, 'NADYA MERLIN PURI AGUSTIN', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(631, 29, '13256/988.127', 'FECPJZ', NULL, '2024-11-19 13:08:56', NULL, 'NAYSWA INDRIENI ASZARA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(632, 29, '13257/989.127', 'VWDBIT', NULL, '2024-11-19 13:08:56', NULL, 'OLIVIA PUTRI OKTAVIANI', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(633, 29, '13258/990.127', 'MMZVMU', NULL, '2024-11-19 13:08:57', NULL, 'R MUHAMMAD NAUVAL ALFADHIL', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(634, 29, '13259/991.127', 'XHJILG', NULL, '2024-11-19 13:08:57', NULL, 'RADO KURNIA NUSAPUTRA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(635, 29, '13260/992.127', 'GHILTF', NULL, '2024-11-19 13:08:57', NULL, 'RAFANDHA TITO PRATAMA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(636, 29, '13261/993.127', 'CWALQW', NULL, '2024-11-19 13:08:57', NULL, 'RAFHAEL ADI SANJAYA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(637, 29, '13262/994.127', 'HHWRFL', NULL, '2024-11-19 13:08:57', NULL, 'RAHMAT MULIA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(638, 29, '13263/995.127', 'XBLFJM', NULL, '2024-11-19 13:08:57', NULL, 'RATU AYU BERLIANA AGUSTA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(639, 29, '13264/996.127', 'IPAXEL', NULL, '2024-11-19 13:08:57', NULL, 'REIHAN ADRIAN MAULANA SAPUTRA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(640, 29, '13265/997.127', 'XHDVWZ', NULL, '2024-11-19 13:08:57', NULL, 'REVAN AKIA PRABASWARA TAQI', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(641, 29, '13266/998.127', 'EJLAOI', NULL, '2024-11-19 13:08:57', NULL, 'RICKY MAULANA BAIHAQI', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(642, 29, '13267/999.127', 'XVWTQG', NULL, '2024-11-19 13:08:57', NULL, 'RIFAT MAULANA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(643, 29, '13268/1000.127', 'FSIIET', NULL, '2024-11-19 13:08:57', NULL, 'ROBIATUL ADAWIYYAH', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(644, 29, '13269/1001.127', 'JYEFGL', NULL, '2024-11-19 13:08:57', NULL, 'SHELIN ADNAN ANGGITA YASMINE', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(645, 29, '13270/1002.127', 'FXQXBV', NULL, '2024-11-19 13:08:57', NULL, 'SISKA SIWI ARNELIA', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(646, 29, '13271/1003.127', 'WTCIPY', NULL, '2024-11-19 13:08:57', NULL, 'SITI NUR FADILAH', NULL, NULL, 1, 'Ruang 3, Sesi 2'),
(647, 29, '13272/1004.127', 'XYCKRY', NULL, '2024-11-19 13:08:57', NULL, 'SYAFINA ARIN NAFEEZA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(648, 29, '13273/1005.127', 'RAIRGT', NULL, '2024-11-19 13:08:57', NULL, 'TIFARA LAVINIA HERMOSA PUTRI', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(649, 29, '13274/1006.127', 'HBYKJI', NULL, '2024-11-19 13:08:57', NULL, 'VALENTINO ZAKI AMAR', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(650, 29, '13275/1007.127', 'CJXWYS', NULL, '2024-11-19 13:08:57', NULL, 'VANY AGUSTINA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(651, 29, '13277/1009.127', 'UWIXPV', NULL, '2024-11-19 13:08:57', NULL, 'WAHYU SAMUDRA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(652, 29, '13278/1010.127', 'QMERYW', NULL, '2024-11-19 13:08:57', NULL, 'ZAHRA VALENTINA NUR SALSABIL', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(653, 29, '13280/1012.127', 'DCUCLZ', NULL, '2024-11-19 13:08:57', NULL, 'ZELDA VIRNA ALISHYA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(654, 29, '13281/1013.127', 'FAMBVE', NULL, '2024-11-19 13:08:57', NULL, 'ZIA FICO FAHRIZAL', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(655, 29, '13501/1015.127', 'STUNXC', NULL, '2024-11-19 13:08:57', NULL, 'MARIA RINDIANI', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(656, 19, '13282/1988.111', 'SXAKSN', NULL, '2024-11-19 13:08:57', NULL, 'ACHMAD FAREL FERDIAN FRANCO UTINA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(657, 19, '13283/1989.111', 'AIEHEK', NULL, '2024-11-19 13:08:57', NULL, 'ACHMAD MARVEL IRWANSYAH', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(658, 19, '13284/1990.111', 'NMROKH', NULL, '2024-11-19 13:08:57', NULL, 'ACHMAD ZAKY FARRASYAH', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(659, 19, '13285/1991.111', 'BHMDGD', NULL, '2024-11-19 13:08:57', NULL, 'ADHELIA RAHMA YULIA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(660, 19, '13286/1992.111', 'RQUJHY', NULL, '2024-11-19 13:08:57', NULL, 'ADINDA NABILA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(661, 19, '13287/1993.111', 'EPINXW', NULL, '2024-11-19 13:08:57', NULL, 'AFRIZA BUNGA LESTARI', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(662, 19, '13288/1994.111', 'QEASRA', NULL, '2024-11-19 13:08:57', NULL, 'AHMAD BERYL SAPUTRA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(663, 19, '13290/1996.111', 'FTOZBE', NULL, '2024-11-19 13:08:58', NULL, 'AHMAD YUSRIL HAMDANI', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(664, 19, '13291/1997.111', 'JMGTLN', NULL, '2024-11-19 13:08:58', NULL, 'AIRIN YASYIFA NUR ANNISA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(665, 19, '13292/1998.111', 'GKFSJP', NULL, '2024-11-19 13:08:58', NULL, 'ALDO FIREZA', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(666, 19, '13293/1999.111', 'KBVQTL', NULL, '2024-11-19 13:08:58', NULL, 'ALFIN YUSTINA PUTRI ANGGIARTI', NULL, NULL, 1, 'Ruang 4, Sesi 2'),
(667, 19, '13294/2000.111', 'HMVQQA', NULL, '2024-11-19 13:08:58', NULL, 'ALICIA EVRILLIANA SANDY', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(668, 19, '13295/2001.111', 'XJLEEA', NULL, '2024-11-19 13:08:58', NULL, 'AMANDA FAIRUS RAINAH SETYABUDI', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(669, 19, '13296/2002.111', 'SBTYVT', NULL, '2024-11-19 13:08:58', NULL, 'ANANDA AFUW PURNOMO', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(670, 19, '13297/2003.111', 'PZZKAF', NULL, '2024-11-19 13:08:58', NULL, 'ANASTASYA PUTRI HIRAWAN', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(671, 19, '13298/2004.111', 'ZCGGCF', NULL, '2024-11-19 13:08:58', NULL, 'ANGGA JAYA NEGARA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(672, 19, '13299/2005.111', 'MDBXZU', NULL, '2024-11-19 13:08:58', NULL, 'ANNGITA PUTRI SAVIRA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(673, 19, '13300/2006.111', 'ILWQGZ', NULL, '2024-11-19 13:08:58', NULL, 'ANNISA SHOFIA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(674, 19, '13301/2007.111', 'PZVKWG', NULL, '2024-11-19 13:08:58', NULL, 'APRILIA SITI FATIMAH', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(675, 19, '13302/2008.111', 'KQFIJX', NULL, '2024-11-19 13:08:58', NULL, 'ARDELIA MEIDYTA MARELLA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(676, 19, '13303/2009.111', 'OHSBWZ', NULL, '2024-11-19 13:08:58', NULL, 'AREMA DIANDRA PRANATA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(677, 19, '13304/2010.111', 'VGECIX', NULL, '2024-11-19 13:08:58', NULL, 'ARFANDO DWI KURNIA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(678, 19, '13305/2011.111', 'KYZXLG', NULL, '2024-11-19 13:08:58', NULL, 'ARINA EKA PUTRI NURJANNAH', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(679, 19, '13308/2014.111', 'XGEAOB', NULL, '2024-11-19 13:08:58', NULL, 'AYU NIKEN KUSUMANINGTYAS', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(680, 19, '13309/2015.111', 'ALIYDU', NULL, '2024-11-19 13:08:58', NULL, 'AZHARTA ALVINSKIE', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(681, 19, '13310/2016.111', 'AOHCTZ', NULL, '2024-11-19 13:08:58', NULL, 'BENEDICTUS BHAGASKARA PUTRA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(682, 19, '13311/2017.111', 'EEPBGS', NULL, '2024-11-19 13:08:58', NULL, 'BERYL AUF RADIN MAHARDIKA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(683, 19, '13312/2018.111', 'UAGUEK', NULL, '2024-11-19 13:08:58', NULL, 'BIMO PANJI KAILANY AHMAD', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(684, 19, '13313/2019.111', 'BYKEDZ', NULL, '2024-11-19 13:08:58', NULL, 'BUNGA EVA APRILIA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(685, 19, '13314/2020.111', 'UJVZZY', NULL, '2024-11-19 13:08:58', NULL, 'CARISSA AUDREY ZSA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(686, 19, '13315/2021.111', 'IFDMHT', NULL, '2024-11-19 13:08:58', NULL, 'CHELSEA OLIVERA', NULL, NULL, 1, 'Ruang 5, Sesi 2'),
(687, 19, '13316/2022.111', 'WUHIBV', NULL, '2024-11-19 13:08:58', NULL, 'CHIKA NAFISA VERONICA', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(688, 19, '13317/2023.111', 'LDASGA', NULL, '2024-11-19 13:08:58', NULL, 'DARIUS KRISNA FIRMANSYAH', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(689, 20, '13318/2024.111', 'FVALHJ', NULL, '2024-11-19 13:08:58', NULL, 'DAVINA RADIN MAHARANI', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(690, 20, '13319/2025.111', 'NCLMOE', NULL, '2024-11-19 13:08:58', NULL, 'DINDA PUTRI ANGGRAENI', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(691, 20, '13320/2026.111', 'SXIQFY', NULL, '2024-11-19 13:08:58', NULL, 'DJAGAD ANANTA WIKRAMA', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(692, 20, '13321/2027.111', 'NABKMG', NULL, '2024-11-19 13:08:58', NULL, 'EKA DIAH CAHYANINGRUM', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(693, 20, '13322/2028.111', 'URNZPM', NULL, '2024-11-19 13:08:58', NULL, 'EKA SEPTIANA AULIYA', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(694, 20, '13323/2029.111', 'GEDBXR', NULL, '2024-11-19 13:08:58', NULL, 'ELSA INDRA TRI FLADITA', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(695, 20, '13324/2030.111', 'ACPKBA', NULL, '2024-11-19 13:08:58', NULL, 'ERICO FARRAS UBAIDILLAH', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(696, 20, '13325/2031.111', 'EZTIPK', NULL, '2024-11-19 13:08:58', NULL, 'FAIZA NURHAMIDA', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(697, 20, '13326/2032.111', 'KMJCHI', NULL, '2024-11-19 13:08:58', NULL, 'FAKHRIY ATHTHAR MUZAKKI', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(698, 20, '13327/2033.111', 'HIUAZP', NULL, '2024-11-19 13:08:58', NULL, 'FARIZ RAHMAT SUBEKTI', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(699, 20, '13328/2034.111', 'SXNWMB', NULL, '2024-11-19 13:08:58', NULL, 'FERDIKA YUDA PRADANA', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(700, 20, '13329/2035.111', 'WGGDQV', NULL, '2024-11-19 13:08:58', NULL, 'FERRY SETYAWAN', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(701, 20, '13330/2036.111', 'ZYVMVQ', NULL, '2024-11-19 13:08:59', NULL, 'GADIS AMBARWATI', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(702, 20, '13331/2037.111', 'IUVDHX', NULL, '2024-11-19 13:08:59', NULL, 'GARI AHMAD BALDI', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(703, 20, '13333/2039.111', 'MFZBTD', NULL, '2024-11-19 13:08:59', NULL, 'HANIF RABBANI NAJAM', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(704, 20, '13334/2040.111', 'REQTSC', NULL, '2024-11-19 13:08:59', NULL, 'IRWAN DUWI PRABOWO', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(705, 20, '13335/2041.111', 'WHBPFU', NULL, '2024-11-19 13:08:59', NULL, 'ISTADARRA SASI AL MAJID', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(706, 20, '13336/2042.111', 'YRAJKY', NULL, '2024-11-19 13:08:59', NULL, 'IVAN BAKTI SAPUTERA', NULL, NULL, 1, 'Ruang 6, Sesi 2'),
(707, 20, '13337/2043.111', 'EBQQTQ', NULL, '2024-11-19 13:08:59', NULL, 'IVAN REGAN ORLANDO', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(708, 20, '13338/2044.111', 'VKNVVL', NULL, '2024-11-19 13:08:59', NULL, 'KAYLA ASRI PRAMESWARI', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(709, 20, '13339/2045.111', 'JLDKCJ', NULL, '2024-11-19 13:08:59', NULL, 'KENNO IRZIE ZILQWIN', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(710, 20, '13340/2046.111', 'JKFOQX', NULL, '2024-11-19 13:08:59', NULL, 'KENZA RESTIANTI PRAMBANDARI', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(711, 20, '13341/2047.111', 'UWPTEL', NULL, '2024-11-19 13:08:59', NULL, 'KHOFIFAH NUR AMALIA', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(712, 20, '13342/2048.111', 'CFCEOL', NULL, '2024-11-19 13:08:59', NULL, 'MAIDATUL MUAROFAH', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(713, 20, '13343/2049.111', 'QSFWCK', NULL, '2024-11-19 13:08:59', NULL, 'MOCHAMAD VALEN RAMADHAN', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(714, 20, '13344/2050.111', 'JKQZAQ', NULL, '2024-11-19 13:08:59', NULL, 'MOCHAMMAD RIFKY ILMAN MAULANA', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(715, 20, '13345/2051.111', 'DXLVCR', NULL, '2024-11-19 13:08:59', NULL, 'MUCHAMMAD HAIDAR ALFIANSYAH BLIT', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(716, 20, '13346/2052.111', 'KRDVAP', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD AKMAL KHADAFFI', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(717, 20, '13347/2053.111', 'GHNQDP', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD ARDHAN ARHZY', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(718, 20, '13348/2054.111', 'EKFYEG', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD ARIF RIDWAN', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(719, 20, '13349/2055.111', 'WQUEUR', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD DAFA ALIF FIANTO', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(720, 20, '13350/2056.111', 'EVARCL', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD FAHRI PRATAMA', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(721, 20, '13351/2057.111', 'BUESWB', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD FAISAL YUNIANTO', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(722, 20, '13352/2058.111', 'MYFHWP', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD FAJAR IZDIHAR', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(723, 21, '13353/2059.111', 'GJKNJD', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD FIRMAN MAULANA PUTRA', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(724, 21, '13354/2060.111', 'CBUQPF', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD NASWAN RASYID AL FAHRI', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(725, 21, '13355/2061.111', 'EJMGOI', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD RISQI EKA SAPUTRA', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(726, 21, '13356/2062.111', 'NRIGKN', NULL, '2024-11-19 13:08:59', NULL, 'MUHAMMAD YUSUF HAFIDZ', NULL, NULL, 1, 'Ruang 7, Sesi 2'),
(727, 21, '13357/2063.111', 'HZRMUJ', NULL, '2024-11-19 13:08:59', NULL, 'NABILA OKTAVIANI SHAFIRA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(728, 21, '13358/2064.111', 'QXSYHI', NULL, '2024-11-19 13:08:59', NULL, 'NAFESA HAFNA ILMY MUHALLA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(729, 21, '13359/2065.111', 'ZNZDER', NULL, '2024-11-19 13:08:59', NULL, 'NAILAH CHASBIAH ACHMAD', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(730, 21, '13360/2066.111', 'DDUQSJ', NULL, '2024-11-19 13:08:59', NULL, 'NAZIRA TABRINA RYNDZA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(731, 21, '13361/2067.111', 'WWDGHI', NULL, '2024-11-19 13:08:59', NULL, 'NINDIA KHALISHA NAILA PUTRI', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(732, 21, '13362/2068.111', 'WGWYTJ', NULL, '2024-11-19 13:08:59', NULL, 'NUUR AZIZAH AL FATH', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(733, 21, '13363/2069.111', 'YZZCUX', NULL, '2024-11-19 13:09:00', NULL, 'OLIVIA RAHMADHANI', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(734, 21, '13364/2070.111', 'GLCXYX', NULL, '2024-11-19 13:09:00', NULL, 'PRAMESTIA ANDINI', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(735, 21, '13365/2071.111', 'CVPCRG', NULL, '2024-11-19 13:09:00', NULL, 'PUTRI KHOFIFAH INDRASWARA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(736, 21, '13366/2072.111', 'JHDUAE', NULL, '2024-11-19 13:09:00', NULL, 'PUTRI NAGAYU SATMIKA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(737, 21, '13367/2073.111', 'FYNFHO', NULL, '2024-11-19 13:09:00', NULL, 'RACHEL AYU APRILIA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(738, 21, '13368/2074.111', 'GNJDKE', NULL, '2024-11-19 13:09:00', NULL, 'RADITYA ELECTRA WAHYU RAMADHAN', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(739, 21, '13369/2075.111', 'YQQJHI', NULL, '2024-11-19 13:09:00', NULL, 'RAMADHIAN PRADIPA BAGASKARA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(740, 21, '13370/2076.111', 'CUAPDT', NULL, '2024-11-19 13:09:00', NULL, 'RAYYA AULIA PASHA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(741, 21, '13371/2077.111', 'GDIACG', NULL, '2024-11-19 13:09:00', NULL, 'RENA WAHYUDI', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(742, 21, '13372/2078.111', 'EUYWMM', NULL, '2024-11-19 13:09:00', NULL, 'RIO ADI SETIAWAN', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(743, 21, '13373/2079.111', 'VZKTRQ', NULL, '2024-11-19 13:09:00', NULL, 'SAFIRA RISANDRA ZAHRANI', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(744, 21, '13374/2080.111', 'BNEBSG', NULL, '2024-11-19 13:09:00', NULL, 'SANIYYAH ZULFAA', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(745, 21, '13375/2081.111', 'SLIALE', NULL, '2024-11-19 13:09:00', NULL, 'SATYA PANDYA SUKARYADI', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(746, 21, '13376/2082.111', 'YQWGQM', NULL, '2024-11-19 13:09:00', NULL, 'SELLA FITRI AZIZAH', NULL, NULL, 1, 'Ruang 8, Sesi 2'),
(747, 21, '13377/2083.111', 'RVCPRU', NULL, '2024-11-19 13:09:00', NULL, 'SHEYLLA NAURA JELITA AZZAHRA', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(748, 21, '13378/2084.111', 'NEXPUM', NULL, '2024-11-19 13:09:00', NULL, 'SOFYA PUTRI MAULIDYA', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(749, 21, '13379/2085.111', 'LFLAHY', NULL, '2024-11-19 13:09:00', NULL, 'SOLEHA AYU SAFITRI', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(750, 21, '13381/2087.111', 'QVWZQS', NULL, '2024-11-19 13:09:00', NULL, 'STEVEN ARDIANSYAH BASNAPAL', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(751, 21, '13382/2088.111', 'GYFJMT', NULL, '2024-11-19 13:09:00', NULL, 'TABITA ANUGRAH PARIBEKTI', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(752, 21, '13383/2089.111', 'RNWRTS', NULL, '2024-11-19 13:09:00', NULL, 'TALITHA ANINDYA', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(753, 21, '13384/2090.111', 'XTYAXZ', NULL, '2024-11-19 13:09:00', NULL, 'VALENCIA SAFIRA HERMAWAN', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(754, 21, '13385/2091.111', 'XECGZG', NULL, '2024-11-19 13:09:00', NULL, 'VIRLY VAHLEVI NURDIANSYAH', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(755, 21, '13386/2092.111', 'HFYZXQ', NULL, '2024-11-19 13:09:00', NULL, 'YAQUTATUL FARDIYATUZZAHROH', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(756, 21, '13387/2093.111', 'WLRJCS', NULL, '2024-11-19 13:09:00', NULL, 'YHORDAN FEBIAN SETIAWAN', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(757, 36, '13142/1066.128', 'EXKSBH', NULL, '2024-11-19 13:09:00', NULL, 'ABELFI LOVELY SANDA HERLIANTI', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(758, 36, '13143/1067.128', 'MYOYLK', NULL, '2024-11-19 13:09:00', NULL, 'ABIR ATIRA', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(759, 36, '13144/1068.128', 'KRQIGO', NULL, '2024-11-19 13:09:00', NULL, 'AGNES EKA SAFIRA', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(760, 36, '13145/1069.128', 'HBTQOZ', NULL, '2024-11-19 13:09:00', NULL, 'AGRIVENA ZEYRA SALLIZA IRNANDO', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(761, 36, '13147/1071.128', 'MCANOA', NULL, '2024-11-19 13:09:00', NULL, 'AMANDA DWI NOVITA', NULL, NULL, 1, 'Ruang 9, Sesi 2');
INSERT INTO `cbt_user` (`user_id`, `user_grup_id`, `user_name`, `user_password`, `user_email`, `user_regdate`, `user_ip`, `user_firstname`, `user_birthdate`, `user_birthplace`, `user_level`, `user_detail`) VALUES
(762, 36, '13148/1072.128', 'CEODDP', NULL, '2024-11-19 13:09:00', NULL, 'AMANDA ROSSALIA PUTRI', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(763, 36, '13149/1073.128', 'YEBSQJ', NULL, '2024-11-19 13:09:00', NULL, 'AMELDA DIVA MAHARANI', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(764, 36, '13150/1074.128', 'TYGFEJ', NULL, '2024-11-19 13:09:00', NULL, 'AMELIA AYU KRISTIANINGRUM', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(765, 36, '13151/1075.128', 'LBSTNI', NULL, '2024-11-19 13:09:01', NULL, 'ASHILAH HUSNA ZAHRA', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(766, 36, '13152/1076.128', 'QYYQAJ', NULL, '2024-11-19 13:09:01', NULL, 'ASMAUL HUSNA', NULL, NULL, 1, 'Ruang 9, Sesi 2'),
(767, 36, '13153/1077.128', 'YIWKTJ', NULL, '2024-11-19 13:09:01', NULL, 'ASYA HERNISASKIA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(768, 36, '13154/1078.128', 'CDVKOD', NULL, '2024-11-19 13:09:01', NULL, 'AYU NOVITASARI', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(769, 36, '13155/1079.128', 'HDWGDK', NULL, '2024-11-19 13:09:01', NULL, 'AZZAHRA OLIVIA WISDJANI', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(770, 36, '13156/1080.128', 'ADVILI', NULL, '2024-11-19 13:09:01', NULL, 'BILGIS SYARSIRA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(771, 36, '13157/1081.128', 'XTARQP', NULL, '2024-11-19 13:09:01', NULL, 'CAHAYA BUNGA KRISYLIA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(772, 36, '13158/1082.128', 'XULHOF', NULL, '2024-11-19 13:09:01', NULL, 'CINTYA DEVI PERMATASARI', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(773, 36, '13159/1083.128', 'YMLDFP', NULL, '2024-11-19 13:09:01', NULL, 'DEA SHELLAMITA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(774, 36, '13160/1084.128', 'CLHFCL', NULL, '2024-11-19 13:09:01', NULL, 'DEVA AULIA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(775, 36, '13161/1085.128', 'PMWWXC', NULL, '2024-11-19 13:09:01', NULL, 'DHECA APRILIANI', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(776, 36, '13162/1086.128', 'IQBAWL', NULL, '2024-11-19 13:09:01', NULL, 'DIAH AYU NAWANG WULAN', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(777, 36, '13163/1087.128', 'CDBEJG', NULL, '2024-11-19 13:09:01', NULL, 'DINI SABILATUS SHOLIKHA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(778, 36, '13164/1088.128', 'GFKGFP', NULL, '2024-11-19 13:09:01', NULL, 'DINY ELFAYZA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(779, 36, '13165/1089.128', 'HQAUDP', NULL, '2024-11-19 13:09:01', NULL, 'DWI AYU RAHMADHANI', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(780, 36, '13166/1090.128', 'OSBWMD', NULL, '2024-11-19 13:09:01', NULL, 'DWI SUCI MUNIKA SARI', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(781, 36, '13167/1091.128', 'VSSOMN', NULL, '2024-11-19 13:09:01', NULL, 'ELENT PUTRI ZANIA ZEIN', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(782, 36, '13168/1092.128', 'TYGTYS', NULL, '2024-11-19 13:09:01', NULL, 'FEBI AMALIA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(783, 36, '13169/1093.128', 'KKQUVR', NULL, '2024-11-19 13:09:01', NULL, 'FIRYAL AULIA FATIN', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(784, 36, '13170/1094.128', 'RMMXMH', NULL, '2024-11-19 13:09:01', NULL, 'FRAMITA AYU ANINDIA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(785, 36, '13171/1095.128', 'KICSJR', NULL, '2024-11-19 13:09:01', NULL, 'FRISKA FAAIZAH FITHROTUN NISA', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(786, 36, '13172/1096.128', 'QHGKAU', NULL, '2024-11-19 13:09:01', NULL, 'ISLAHUN NAJAH', NULL, NULL, 1, 'Ruang 10, Sesi 2'),
(787, 36, '13173/1097.128', 'ZMWGUH', NULL, '2024-11-19 13:09:01', NULL, 'JAUHARA RATU SALSABILLAH', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(788, 36, '13174/1098.128', 'WISHCS', NULL, '2024-11-19 13:09:01', NULL, 'JELITA CAHAYA KIRANA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(789, 36, '13175/1099.128', 'DWSTKD', NULL, '2024-11-19 13:09:01', NULL, 'JUWITA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(790, 36, '13176/1100.128', 'WGBHDX', NULL, '2024-11-19 13:09:01', NULL, 'KARINDA AYU MAULIDYA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(791, 36, '13177/1101.128', 'QGENMZ', NULL, '2024-11-19 13:09:01', NULL, 'KHANZA PUTRI AZIZAH', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(792, 36, '13499/1138.128', 'BWXDGZ', '', '2024-11-19 13:09:01', NULL, 'HERLINA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(793, 37, '13178/1102.128', 'EQTXIQ', NULL, '2024-11-19 13:09:01', NULL, 'KHOFIFAH SAHARANI WAHAB', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(794, 37, '13179/1103.128', 'KCHHVJ', NULL, '2024-11-19 13:09:01', NULL, 'KYNTANN CLAUDIA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(795, 37, '13180/1104.128', 'RDJMBP', NULL, '2024-11-19 13:09:01', NULL, 'MARSHA KIRANA PUTRI RAMADHANEINA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(796, 37, '13181/1105.128', 'AJWZUB', NULL, '2024-11-19 13:09:01', NULL, 'MEILITHA DHEA HERAWATI SUSANTI', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(797, 37, '13182/1106.128', 'WLYYGS', NULL, '2024-11-19 13:09:01', NULL, 'MIFTA NANCY OKTAVIA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(798, 37, '13183/1107.128', 'QCADAB', NULL, '2024-11-19 13:09:01', NULL, 'MUKAROMAH LAILATUL FITRI', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(799, 37, '13184/1108.128', 'FYMXRM', NULL, '2024-11-19 13:09:01', NULL, 'NADHIFAH SHOFI SALSABILA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(800, 37, '13185/1109.128', 'HKRCXQ', NULL, '2024-11-19 13:09:01', NULL, 'NADIA SASHIKARANI', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(801, 37, '13186/1110.128', 'IYXDYI', NULL, '2024-11-19 13:09:02', NULL, 'NADIRA YASMIN ATTAUR RAHMA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(802, 37, '13187/1111.128', 'IFFIOA', NULL, '2024-11-19 13:09:02', NULL, 'NAFIESHA FIARA RAMADHANI', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(803, 37, '13189/1113.128', 'XFKFPY', NULL, '2024-11-19 13:09:02', NULL, 'NAVIDA ALIVIA', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(804, 37, '13190/1114.128', 'RPTOFF', NULL, '2024-11-19 13:09:02', NULL, 'NEYZA BILQIIS', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(805, 37, '13191/1115.128', 'FHQHGG', NULL, '2024-11-19 13:09:02', NULL, 'NIMAS AULIA AGUSTIN', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(806, 37, '13192/1116.128', 'VGQDAV', NULL, '2024-11-19 13:09:02', NULL, 'NOVITA AJENG PRATIWI', NULL, NULL, 1, 'Ruang 11, Sesi 2'),
(807, 37, '13193/1117.128', 'LMQKKT', NULL, '2024-11-19 13:09:02', NULL, 'QHOIR HIDAYATI OKTAVIANI', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(808, 37, '13194/1118.128', 'DWTNUD', NULL, '2024-11-19 13:09:02', NULL, 'RAIHANAH HUWAIDAH', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(809, 37, '13195/1119.128', 'TIUKOW', NULL, '2024-11-19 13:09:02', NULL, 'REGINA APRILIA BEBUD', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(810, 37, '13196/1120.128', 'YGSQVF', NULL, '2024-11-19 13:09:02', NULL, 'REVALIA NESWA AZZAHRA', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(811, 37, '13197/1121.128', 'GOETRR', NULL, '2024-11-19 13:09:02', NULL, 'RHANIA PUTRI WAHYUNINGTYAS', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(812, 37, '13199/1123.128', 'WPJKZD', NULL, '2024-11-19 13:09:02', NULL, 'RIZKA YUNIARTI WULANDARI', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(813, 37, '13200/1124.128', 'IGRAIZ', NULL, '2024-11-19 13:09:02', NULL, 'RIZKY ARINDA DEWI', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(814, 37, '13201/1125.128', 'EQRZRH', NULL, '2024-11-19 13:09:02', NULL, 'SANIA APRILIANTI', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(815, 37, '13202/1126.128', 'ZBYWEE', NULL, '2024-11-19 13:09:02', NULL, 'SELVI APRILIA', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(816, 37, '13203/1127.128', 'WKEOAB', NULL, '2024-11-19 13:09:02', NULL, 'SHERLY DIAN ANJANI', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(817, 37, '13204/1128.128', 'PCTGPW', NULL, '2024-11-19 13:09:02', NULL, 'SHERLY DWIYANTI', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(818, 37, '13205/1129.128', 'EOJSWM', NULL, '2024-11-19 13:09:02', NULL, 'SITI ALIZA', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(819, 37, '13206/1130.128', 'BKRZQU', NULL, '2024-11-19 13:09:02', NULL, 'SITI NABILATUS ZAHRO', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(820, 37, '13207/1131.128', 'PVKFLE', NULL, '2024-11-19 13:09:02', NULL, 'SITI SALSABILA MIFTACHUL JANNAH', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(821, 37, '13208/1132.128', 'URMBZQ', NULL, '2024-11-19 13:09:02', NULL, 'VAHSTI VOLETTA AZ ZAHRA VANIA', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(822, 37, '13209/1133.128', 'QUSUBR', NULL, '2024-11-19 13:09:02', NULL, 'VIOLINA AYUNDA PERMATA SARY', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(823, 37, '13210/1134.128', 'SDVBUL', NULL, '2024-11-19 13:09:02', NULL, 'WILDA SALVA CITRA KHARISMA', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(824, 37, '13211/1135.128', 'YPVKEK', NULL, '2024-11-19 13:09:02', NULL, 'YERIL ANANDA AFRILIA', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(825, 37, '13212/1136.128', 'DRMMTS', NULL, '2024-11-19 13:09:02', NULL, 'ZASKIA FAIRUZ AMALIA', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(826, 37, '13213/1137.128', 'GLUIIW', NULL, '2024-11-19 13:09:03', NULL, 'ZULAIKAH RAHMAJANI', NULL, NULL, 1, 'Ruang 12, Sesi 2'),
(827, 34, '12199/707.117', 'AFJUYA', NULL, '2024-11-19 13:09:03', NULL, 'ANDRIAN RIFA DWI SAPUTRA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(828, 34, '12826/767.117', 'VRPZWD', NULL, '2024-11-19 13:09:03', NULL, 'ABIYYU RIFQI IRWANDA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(829, 34, '12827/768.117', 'NCJUDE', NULL, '2024-11-19 13:09:03', NULL, 'ACHMAD BAGOS ALFAUZI', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(830, 34, '12829/770.117', 'RPYMAA', NULL, '2024-11-19 13:09:03', NULL, 'AFGAN TIGO IBRAHIMOVIC', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(831, 34, '12830/771.117', 'IJKZVG', NULL, '2024-11-19 13:09:03', NULL, 'AHMAD ARZHI SURYA JULIANSYAH', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(832, 34, '12835/776.117', 'VIFLPJ', NULL, '2024-11-19 13:09:03', NULL, 'AMANDA DIAH AYU LARASATI', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(833, 34, '12836/777.117', 'MWGBSY', NULL, '2024-11-19 13:09:03', NULL, 'ANANDA IKHYA MAULANA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(834, 34, '12837/778.117', 'WKCSEP', NULL, '2024-11-19 13:09:03', NULL, 'ANDRIKA JAMA\\\'ALI', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(835, 34, '12838/779.117', 'FWYPBT', NULL, '2024-11-19 13:09:03', NULL, 'ANSHORI ZAKARIA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(836, 34, '12839/780.117', 'BDXZHI', NULL, '2024-11-19 13:09:03', NULL, 'APRILIANO SATRIA MAULANA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(837, 34, '12840/781.117', 'QAHYIZ', NULL, '2024-11-19 13:09:03', NULL, 'ARIEL BAGAS TYAN RIDHO RAMADHAN', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(838, 34, '12841/782.117', 'WODVSD', NULL, '2024-11-19 13:09:03', NULL, 'ARYA RIZKYANSYAH RAMADHAN', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(839, 34, '12842/783.117', 'MKGCPT', NULL, '2024-11-19 13:09:03', NULL, 'BAGUS FAJAR DWINATA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(840, 34, '12843/784.117', 'CUNOGW', NULL, '2024-11-19 13:09:03', NULL, 'BENING AWANG NUGROHO', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(841, 34, '12844/785.117', 'RXFKWD', NULL, '2024-11-19 13:09:03', NULL, 'BINTANG WASKITA AJI', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(842, 34, '12845/786.117', 'HXRZTQ', NULL, '2024-11-19 13:09:03', NULL, 'BRIAN JULI MAULANA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(843, 34, '12846/787.117', 'AGLYMM', NULL, '2024-11-19 13:09:03', NULL, 'DIDAN MAULANA AKBAR', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(844, 34, '12847/788.117', 'ZDPEHY', NULL, '2024-11-19 13:09:03', NULL, 'DIHARD AHMAD KHAFI ALAYUDIN TUSSOF', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(845, 34, '12848/789.117', 'PYNOVI', NULL, '2024-11-19 13:09:03', NULL, 'ERLANGGA PUTRA PRATAMA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(846, 34, '12849/790.117', 'KLZJRJ', NULL, '2024-11-19 13:09:03', NULL, 'FADILA DWI NOVITA ANGELA', NULL, NULL, 1, 'Ruang 13, Sesi 2'),
(847, 34, '12850/791.117', 'EQPMQI', NULL, '2024-11-19 13:09:03', NULL, 'FAREL ADITYA', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(848, 34, '12851/792.117', 'UJRALU', NULL, '2024-11-19 13:09:03', NULL, 'FATKHUR REZA SETIAWAN', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(849, 34, '12852/793.117', 'UNZQDD', NULL, '2024-11-19 13:09:03', NULL, 'FAUDILLA PUTRI CAESAR', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(850, 34, '12853/794.117', 'CCUACR', NULL, '2024-11-19 13:09:03', NULL, 'FIQIH HARIANTO', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(851, 34, '12854/795.117', 'VAZNFO', NULL, '2024-11-19 13:09:03', NULL, 'FIRMANSAH WIJAYANTO', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(852, 34, '12855/796.117', 'GMDUIO', NULL, '2024-11-19 13:09:03', NULL, 'HAFIDH AHMAD AL HAKIM', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(853, 34, '12856/797.117', 'IAKPKJ', '', '2024-11-19 13:09:03', NULL, 'HERI YUWONO', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(854, 34, '12857/798.117', 'BVTKPG', NULL, '2024-11-19 13:09:03', NULL, 'IRSYAD THEODORA FIRDAUS', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(855, 34, '12858/799.117', 'CMRHKU', NULL, '2024-11-19 13:09:03', NULL, 'JEHAN ALFARIZA AHURA MAZDA', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(856, 35, '12241/749.117', 'JEQEFV', NULL, '2024-11-19 13:09:03', NULL, 'RAFLI DWI KURNIAWAN', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(857, 35, '12859/800.117', 'DIOGIJ', NULL, '2024-11-19 13:09:03', NULL, 'JIMLY HABIBURRAHMAN SUNARYA', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(858, 35, '12861/802.117', 'KZYDFX', NULL, '2024-11-19 13:09:03', NULL, 'M. SAMSUL MA\\\'ARIF', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(859, 35, '12862/803.117', 'JNPFKA', NULL, '2024-11-19 13:09:03', NULL, 'MAHESA FERI FIRMANSYAH', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(860, 35, '12864/805.117', 'RSPEXM', NULL, '2024-11-19 13:09:04', NULL, 'MOCHAMMAD NELOGIO HARLINO', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(861, 35, '12865/806.117', 'HNGGCI', NULL, '2024-11-19 13:09:04', NULL, 'MUCHAMAD YAFI MAULANA JUNIAR', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(862, 35, '12866/807.117', 'XDXDCC', NULL, '2024-11-19 13:09:04', NULL, 'MUHAMAD REIHAN SAPUTRA', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(863, 35, '12868/809.117', 'NMNWZM', NULL, '2024-11-19 13:09:04', NULL, 'MUHAMMAD FIKRI ARDIYANSAH', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(864, 35, '12869/810.117', 'KVBZGK', '', '2024-11-19 13:09:04', NULL, 'MUHAMMAD PUTRA RIZKI', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(865, 35, '12870/811.117', 'VCKJSU', NULL, '2024-11-19 13:09:04', NULL, 'MUHAMMAD RAFLI PUTRA PRIWIDA', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(866, 35, '12871/812.117', 'XPMCYQ', NULL, '2024-11-19 13:09:04', NULL, 'MUHAMMAD RENGGA NUR AGUSTIO', NULL, NULL, 1, 'Ruang 14, Sesi 2'),
(867, 35, '12872/813.117', 'MJIGSR', NULL, '2024-11-19 13:09:04', NULL, 'MUKHAMMAD RIZKY RAMADHANI', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(868, 35, '12873/814.117', 'JDABJF', NULL, '2024-11-19 13:09:04', NULL, 'NURUL IBAT', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(869, 35, '12874/815.117', 'BSMSQY', NULL, '2024-11-19 13:09:04', NULL, 'PANJI PUTRA RAMA ARDIANSYAH', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(870, 35, '12875/816.117', 'BQZLUW', NULL, '2024-11-19 13:09:04', NULL, 'RAFI ACHMAD RAMADHAN', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(871, 35, '12876/817.117', 'HOULZT', NULL, '2024-11-19 13:09:04', NULL, 'RAFLI IRWANSYAH', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(872, 35, '12877/818.117', 'QPZVCU', NULL, '2024-11-19 13:09:04', NULL, 'RAHMADANI ABDUL KHODIR JAILANI', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(873, 35, '12878/819.117', 'GYEBBU', NULL, '2024-11-19 13:09:04', NULL, 'RASYA EVAN PUTRA SETYAWAN', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(874, 35, '12879/820.117', 'UCLZRX', NULL, '2024-11-19 13:09:04', NULL, 'RASYA ZAIDAN SYAFIQ AZIS', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(875, 35, '12880/821.117', 'GRFDNF', NULL, '2024-11-19 13:09:04', NULL, 'REYHAN KAKA IBRAHIMMA', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(876, 35, '12881/822.117', 'RFOAVD', NULL, '2024-11-19 13:09:04', NULL, 'RIO PRATAMA SYAH PUTRA', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(877, 35, '12882/823.117', 'SZUJUX', NULL, '2024-11-19 13:09:04', NULL, 'RIVALDO AINUR MULYA SAPUTRA', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(878, 35, '12883/824.117', 'TIJSDQ', NULL, '2024-11-19 13:09:04', NULL, 'RIZKY AKBAR RAMADHAN', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(879, 35, '12884/825.117', 'SEMLGF', NULL, '2024-11-19 13:09:04', NULL, 'ROSSYHAN DWI HENDRAWAN', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(880, 35, '12885/826.117', 'TSUHIT', NULL, '2024-11-19 13:09:04', NULL, 'SANDY ADI SUSANTO', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(881, 35, '12886/827.117', 'CVWNYU', NULL, '2024-11-19 13:09:04', NULL, 'SHARIL ORIZA ALIFA', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(882, 35, '12887/828.117', 'CWMVBV', NULL, '2024-11-19 13:09:04', NULL, 'TYAS LINGGO YUWONO', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(883, 35, '12888/829.117', 'VYAYVR', NULL, '2024-11-19 13:09:04', NULL, 'WAHYU TRI ARDISAPUTRA', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(884, 35, '12889/830.117', 'ZZHQPE', NULL, '2024-11-19 13:09:04', NULL, 'WILI SANTOSO', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(885, 35, '12890/831.117', 'DWNTMU', NULL, '2024-11-19 13:09:04', NULL, 'YANUAR FENDIKA BAGASKORO', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(886, 35, '12891/832.117', 'WEWQOQ', NULL, '2024-11-19 13:09:04', NULL, 'YUDHISTIRA AR FARIZZY', NULL, NULL, 1, 'Ruang 15, Sesi 2'),
(887, 35, '12892/833.117', 'DDGIPZ', NULL, '2024-11-19 13:09:04', NULL, 'ZAKY ARRIZAL', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(888, 32, '12371/619.115', 'FGKAAC', NULL, '2024-11-19 13:09:04', NULL, 'RAMADHANI EKA PRASETYA AJI', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(889, 32, '12964/634.115', 'DRTUFC', NULL, '2024-11-19 13:09:04', NULL, 'ADAM YOGIESTHA IMAN', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(890, 32, '12965/635.115', 'FDPPOZ', NULL, '2024-11-19 13:09:04', NULL, 'ADICHA VIRANI', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(891, 32, '12966/636.115', 'WMHWKN', NULL, '2024-11-19 13:09:04', NULL, 'AHMAD REYHAN', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(892, 32, '12967/637.115', 'ZMWMJZ', NULL, '2024-11-19 13:09:04', NULL, 'ALDE VAVA ANGGA SAPUTRO', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(893, 32, '12968/638.115', 'EDIUCX', NULL, '2024-11-19 13:09:04', NULL, 'ALDO AHMAD IRWANSYAH', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(894, 32, '12969/639.115', 'KEBKDF', NULL, '2024-11-19 13:09:05', NULL, 'ANANTASYA PUTRI NURHALISAH', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(895, 32, '12970/640.115', 'IJPZYM', NULL, '2024-11-19 13:09:05', NULL, 'ANASTASYA LAILATUL RAMADHANI', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(896, 32, '12971/641.115', 'NHIGXE', NULL, '2024-11-19 13:09:05', NULL, 'ANGEL LINA KLARITA SARI', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(897, 32, '12973/643.115', 'FPVJJR', NULL, '2024-11-19 13:09:05', NULL, 'ANGGER SATRIA WIJAYA', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(898, 32, '12974/644.115', 'WKEVRG', NULL, '2024-11-19 13:09:05', NULL, 'ANGKASA GENTA ISLAM', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(899, 32, '12975/645.115', 'ZDLMKC', NULL, '2024-11-19 13:09:05', NULL, 'ANNISA WIDIA RIZKI AGUSTIN', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(900, 32, '12976/646.115', 'JNULVL', NULL, '2024-11-19 13:09:05', NULL, 'ANTONI ARIYA SADEWA', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(901, 32, '12977/647.115', 'NGZWEU', NULL, '2024-11-19 13:09:05', NULL, 'ARIS REZA FERDIANSYAH', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(902, 32, '12978/648.115', 'DORRUN', NULL, '2024-11-19 13:09:05', NULL, 'ARIYA ROSADI', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(903, 32, '12979/649.115', 'RNEOUW', NULL, '2024-11-19 13:09:05', NULL, 'BARUNA FAWWAS BASCELLO ACHMAD JAYA', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(904, 32, '12980/650.115', 'SWTNVC', NULL, '2024-11-19 13:09:05', NULL, 'CINDY NUR SALSABILA', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(905, 32, '12981/651.115', 'FHAOWO', NULL, '2024-11-19 13:09:05', NULL, 'DAVIN PUTRA RAMADHANI', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(906, 32, '12983/653.115', 'JTTUUK', NULL, '2024-11-19 13:09:05', NULL, 'DIAN SAH TRI ATMOJO', NULL, NULL, 1, 'Ruang 16, Sesi 2'),
(907, 32, '12984/654.115', 'WPXZDH', NULL, '2024-11-19 13:09:05', NULL, 'DIMAS SURYA RAMADHANI', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(908, 32, '12985/655.115', 'KHTSXM', NULL, '2024-11-19 13:09:05', NULL, 'DWI PRASETYO', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(909, 32, '12986/656.115', 'DLSJNO', NULL, '2024-11-19 13:09:05', NULL, 'DZIKRI AGUS SALIM', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(910, 32, '12987/657.115', 'ZIZKXG', NULL, '2024-11-19 13:09:05', NULL, 'ELOK KURNIAWATI MAHARANI', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(911, 32, '12988/658.115', 'EPCENM', NULL, '2024-11-19 13:09:05', NULL, 'ELVINA WARDAH YUNIA FITONI', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(912, 32, '12989/659.115', 'RBYXTK', NULL, '2024-11-19 13:09:05', NULL, 'FANY RISKI CINDI AMELIA', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(913, 32, '12990/660.115', 'YWCORP', NULL, '2024-11-19 13:09:05', NULL, 'FATIMAH AZZAHRO', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(914, 32, '12991/661.115', 'BEABZF', NULL, '2024-11-19 13:09:05', NULL, 'FATKHUR RAHMAN ABIDIN', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(915, 32, '12992/662.115', 'SAZNDA', NULL, '2024-11-19 13:09:05', NULL, 'FAUZI MUCH RIDWAN', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(916, 32, '12993/663.115', 'VBVANY', NULL, '2024-11-19 13:09:05', NULL, 'FAVIAN BAYU SYAHPUTRA', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(917, 32, '12994/664.115', 'LTSPPX', NULL, '2024-11-19 13:09:05', NULL, 'GALUH RUKMI SAMEKTA', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(918, 32, '12995/665.115', 'ZEBWAE', NULL, '2024-11-19 13:09:05', NULL, 'GHANI RIZQI FIRASAH', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(919, 32, '12996/666.115', 'NNHLKL', NULL, '2024-11-19 13:09:05', NULL, 'HOYA FIRMANSYAH RAMADHAN', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(920, 32, '12998/668.115', 'JVQREO', NULL, '2024-11-19 13:09:05', NULL, 'JUMROTUL AULIA SAVIRA', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(921, 32, '12999/669.115', 'SIQVIV', NULL, '2024-11-19 13:09:05', NULL, 'KHOIRUNISA DIYAULHAQ ILMI', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(922, 33, '12326/574.115', 'JOEOCU', NULL, '2024-11-19 13:09:06', NULL, 'ALFAN DWI ERLANGGA PUTRA', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(923, 33, '13000/670.115', 'BXFKFQ', NULL, '2024-11-19 13:09:06', NULL, 'KINANTHI SEPTIARATRI NOVIANDARI', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(924, 33, '13001/671.115', 'QPUILW', NULL, '2024-11-19 13:09:06', NULL, 'LIONDRA GIBI PRADANA WICAKSONO', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(925, 33, '13002/672.115', 'GJKSYA', NULL, '2024-11-19 13:09:06', NULL, 'MALICHA', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(926, 33, '13003/673.115', 'TDVSFK', NULL, '2024-11-19 13:09:06', NULL, 'MOCH IRFAN HAKIM', NULL, NULL, 1, 'Ruang 17, Sesi 2'),
(927, 33, '13004/674.115', 'EXRVYO', NULL, '2024-11-19 13:09:06', NULL, 'MOCH SALMAN ALFARIZI', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(928, 33, '13008/678.115', 'CCJPCC', NULL, '2024-11-19 13:09:06', NULL, 'MUHAMMAD AL AYYUBI', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(929, 33, '13009/679.115', 'LGAFKP', NULL, '2024-11-19 13:09:06', NULL, 'MUHAMMAD FATHAN THARIQ', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(930, 33, '13010/680.115', 'FWSACN', NULL, '2024-11-19 13:09:06', NULL, 'MUHAMMAD RANGGA FADILLAH', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(931, 33, '13011/681.115', 'SBOHZB', NULL, '2024-11-19 13:09:06', NULL, 'MUHAMMAD SOFYAN FEBRIANTO', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(932, 33, '13012/682.115', 'RRGOHJ', NULL, '2024-11-19 13:09:06', NULL, 'MUKHAMMAD FARDHAN AINURROHMAN', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(933, 33, '13013/683.115', 'CTXRGB', NULL, '2024-11-19 13:09:06', NULL, 'MUTIARA HAMIFAH', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(934, 33, '13014/684.115', 'RJLSST', NULL, '2024-11-19 13:09:06', NULL, 'NATASYA FEBRIANA PUTRI', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(935, 33, '13015/685.115', 'UVJNAZ', NULL, '2024-11-19 13:09:06', NULL, 'NOVI PUTRI AULIA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(936, 33, '13016/686.115', 'XUQBJX', NULL, '2024-11-19 13:09:06', NULL, 'NUR WULAN RAHMAT DANI', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(937, 33, '13017/687.115', 'XGFSDR', NULL, '2024-11-19 13:09:06', NULL, 'NURUL SAIBATUL ISLAMIYAH MAWADHANA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(938, 33, '13018/688.115', 'TWAOBQ', NULL, '2024-11-19 13:09:06', NULL, 'RADYT EKA PUTRA WIJAYA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(939, 33, '13019/689.115', 'RJSFFM', NULL, '2024-11-19 13:09:06', NULL, 'RAFIE AKMA DZAKY', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(940, 33, '13020/690.115', 'VLLMEC', NULL, '2024-11-19 13:09:06', NULL, 'RANI AZALIA AGATHA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(941, 33, '13021/691.115', 'SXJOJC', NULL, '2024-11-19 13:09:06', NULL, 'RAVAEL ARBI ZULIANT', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(942, 33, '13022/692.115', 'YDSRMD', NULL, '2024-11-19 13:09:06', NULL, 'REHAN ABITRI SETIANSA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(943, 33, '13023/693.115', 'AAOFQP', NULL, '2024-11-19 13:09:06', NULL, 'RENATA KEISYA AZZAHRA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(944, 33, '13024/694.115', 'RHVDGY', NULL, '2024-11-19 13:09:06', NULL, 'REYFAN ANDRYANO PUTRA PRATAMA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(945, 33, '13025/695.115', 'FFWJJO', NULL, '2024-11-19 13:09:06', NULL, 'REYHAN ALIF SAPUTRA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(946, 33, '13026/696.115', 'CRHLGR', NULL, '2024-11-19 13:09:06', NULL, 'SABIAN AKBAR PUTRA', NULL, NULL, 1, 'Ruang 18, Sesi 2'),
(947, 33, '13028/698.115', 'SCMEHI', NULL, '2024-11-19 13:09:06', NULL, 'SERA CITA MAHARANI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(948, 33, '13029/699.115', 'WJJJRA', NULL, '2024-11-19 13:09:06', NULL, 'SORAYA AININTYAS SUSANTO', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(949, 33, '13030/700.115', 'VDVUIF', NULL, '2024-11-19 13:09:06', NULL, 'SYAFIRA AULIA PUTRI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(950, 33, '13032/702.115', 'XCTRDK', NULL, '2024-11-19 13:09:06', NULL, 'TAQIYUDIN', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(951, 33, '13033/703.115', 'FSFDKS', NULL, '2024-11-19 13:09:06', NULL, 'TEGAR FITRAH NAFFIZAH', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(952, 33, '13034/704.115', 'UCUSTR', NULL, '2024-11-19 13:09:06', NULL, 'TEZAR SAKA SABIL SADEWA', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(953, 33, '13035/705.115', 'QGIZIB', NULL, '2024-11-19 13:09:07', NULL, 'WAHYU CHONDRO LUCKYTO', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(954, 30, '12893/894.113', 'RGZKXF', NULL, '2024-11-19 13:09:07', NULL, 'ADINDA AYU WULANDARI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(955, 30, '12894/895.113', 'LZVKNG', NULL, '2024-11-19 13:09:07', NULL, 'ADINDA ELISYA PUTRI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(956, 30, '12895/896.113', 'PDVAAX', NULL, '2024-11-19 13:09:07', NULL, 'ADINDA ZAHRA NUR ISLAMI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(957, 30, '12896/897.113', 'HVLYVX', NULL, '2024-11-19 13:09:07', NULL, 'AHMAD DANI SYAHLANI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(958, 30, '12897/898.113', 'JTLZCC', NULL, '2024-11-19 13:09:07', NULL, 'AISYAH AZZAHRA RAMADHANI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(959, 30, '12898/899.113', 'NXYCPM', NULL, '2024-11-19 13:09:07', NULL, 'ALEXA VELOVIE RAMADHANI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(960, 30, '12899/900.113', 'IGAOPO', NULL, '2024-11-19 13:09:07', NULL, 'ALIFIA AZZARAH RAMADHANI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(961, 30, '12900/901.113', 'BLMKPQ', NULL, '2024-11-19 13:09:07', NULL, 'ALISYAH ANGGUN WARDANI', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(962, 30, '12901/902.113', 'ZGLRWQ', NULL, '2024-11-19 13:09:07', NULL, 'ANANDA MUTIARA IZZAH', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(963, 30, '12902/903.113', 'JCYNZQ', NULL, '2024-11-19 13:09:07', NULL, 'ANDHIKA REZA ARDHIANSYA', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(964, 30, '12903/904.113', 'UDIMLT', NULL, '2024-11-19 13:09:07', NULL, 'ANDIKA WIRADINATA RIYANTO', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(965, 30, '12904/905.113', 'WJYGWH', NULL, '2024-11-19 13:09:07', NULL, 'APRILIA KHALIFATUS SAKDIAH', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(966, 30, '12905/906.113', 'VAACGX', NULL, '2024-11-19 13:09:07', NULL, 'ARINI SUGONDO', NULL, NULL, 1, 'Ruang 19, Sesi 2'),
(967, 30, '12906/907.113', 'SQIIBA', NULL, '2024-11-19 13:09:07', NULL, 'BINTANG NURSAVANA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(968, 30, '12907/908.113', 'AVFUXG', NULL, '2024-11-19 13:09:07', NULL, 'CANTIKA NATALIA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(969, 30, '12909/910.113', 'DNZNRJ', NULL, '2024-11-19 13:09:07', NULL, 'CINTA MAIA SAFITRI ANDRIANI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(970, 30, '12910/911.113', 'ZWYBZP', NULL, '2024-11-19 13:09:07', NULL, 'CLARISSA ANINDYA MUSTOFA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(971, 30, '12912/913.113', 'MXMQRF', NULL, '2024-11-19 13:09:07', NULL, 'DELLA MAHARANI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(972, 30, '12913/914.113', 'KKKUKS', NULL, '2024-11-19 13:09:07', NULL, 'DINI APRILIA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(973, 30, '12915/916.113', 'JFCPBZ', NULL, '2024-11-19 13:09:07', NULL, 'EMI INDAH LAURA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(974, 30, '12916/917.113', 'USWEFE', NULL, '2024-11-19 13:09:07', NULL, 'FEBRIANA VIANDITA PURI ANDINI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(975, 30, '12918/919.113', 'QWUNCE', NULL, '2024-11-19 13:09:07', NULL, 'FIRDA AULIA AINUL ALYA RUSITA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(976, 30, '12919/920.113', 'BQPRBB', NULL, '2024-11-19 13:09:07', NULL, 'FLORA TRISNE HAQY', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(977, 30, '12920/921.113', 'GSCEDL', NULL, '2024-11-19 13:09:07', NULL, 'GADIS BUNGA CITRA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(978, 30, '12921/922.113', 'MEJKTW', NULL, '2024-11-19 13:09:07', NULL, 'GALUH AZALEA HALIMATUS SA\\\'DIYAH', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(979, 30, '12922/923.113', 'MHOLUQ', NULL, '2024-11-19 13:09:07', NULL, 'IDA ISNIATUL ULAVIA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(980, 30, '12924/925.113', 'PTHORJ', NULL, '2024-11-19 13:09:07', NULL, 'KARMEL NOVALEZA OLLYVIA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(981, 30, '12926/927.113', 'UHRXQZ', NULL, '2024-11-19 13:09:07', NULL, 'LARISA DEVINA MAHARANI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(982, 30, '12927/928.113', 'FWMBRV', NULL, '2024-11-19 13:09:07', NULL, 'MARISCA ANGGITA HENDRAWATI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(983, 31, '12928/929.113', 'JHHOBI', NULL, '2024-11-19 13:09:08', NULL, 'MARTSEL NURUL VIKA', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(984, 31, '12929/930.113', 'RLUTES', NULL, '2024-11-19 13:09:08', NULL, 'MIESEL DHEA PRASTIWI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(985, 31, '12930/931.113', 'SUSKNB', NULL, '2024-11-19 13:09:08', NULL, 'MONIKA SASKIA PUTRI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(986, 31, '12932/933.113', 'AOUAFI', NULL, '2024-11-19 13:09:08', NULL, 'NADIA BINTANG MAHARANI', NULL, NULL, 1, 'Ruang 20, Sesi 2'),
(987, 31, '12933/934.113', 'NQBCQO', NULL, '2024-11-19 13:09:08', NULL, 'NADINE RAISYA BILQIS', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(988, 31, '12934/935.113', 'HYYVDG', NULL, '2024-11-19 13:09:08', NULL, 'NASTARI ROSALINDA', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(989, 31, '12935/936.113', 'APHEXU', NULL, '2024-11-19 13:09:08', NULL, 'NAZILA DIFIYA AGUSTIN', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(990, 31, '12936/937.113', 'NLRKDI', NULL, '2024-11-19 13:09:08', NULL, 'NIKEN AISYAH FITRI', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(991, 31, '12937/938.113', 'DYQUKZ', NULL, '2024-11-19 13:09:08', NULL, 'NINDI NOVITASARI WIJAYA', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(992, 31, '12938/939.113', 'PWBQVG', NULL, '2024-11-19 13:09:08', NULL, 'NINIS RAMANDANI', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(993, 31, '12939/940.113', 'LZHFRO', NULL, '2024-11-19 13:09:08', NULL, 'NIRA ANDHITA NAHRIYAH', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(994, 31, '12940/941.113', 'VHORKI', NULL, '2024-11-19 13:09:08', NULL, 'NUR AINI', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(995, 31, '12941/942.113', 'UDLSHR', NULL, '2024-11-19 13:09:08', NULL, 'PALUPI CAHYA NINGTYAS', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(996, 31, '12943/944.113', 'CXQUYZ', NULL, '2024-11-19 13:09:08', NULL, 'REGITA SYAFITRI ARNATA', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(997, 31, '12944/945.113', 'LJXAHR', NULL, '2024-11-19 13:09:08', NULL, 'REVALYNA DIYANTI', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(998, 31, '12946/947.113', 'XFMLCD', NULL, '2024-11-19 13:09:08', NULL, 'RICHARD CHRISTIAN ANDREANSYAH', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(999, 31, '12947/948.113', 'NTWRRK', NULL, '2024-11-19 13:09:08', NULL, 'SAFIRA BAGUS DEWI SANTOSO', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1000, 31, '12948/949.113', 'BWICBD', NULL, '2024-11-19 13:09:08', NULL, 'SALSABILA RASYA HADI PARISYA', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1001, 31, '12949/950.113', 'NJJZVL', NULL, '2024-11-19 13:09:08', NULL, 'SALSABILLAH JULIASISAH', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1002, 31, '12950/951.113', 'GYLYNR', NULL, '2024-11-19 13:09:08', NULL, 'SHAKILA LAUDIA RENGGANIS', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1003, 31, '12951/952.113', 'HUDOOP', NULL, '2024-11-19 13:09:08', NULL, 'SHELOMITA AVRILIA', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1004, 31, '12952/953.113', 'AGCDUS', NULL, '2024-11-19 13:09:08', NULL, 'SHINTIA PUSPA AYU ANGGREANI', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1005, 31, '12953/954.113', 'ENBGDB', NULL, '2024-11-19 13:09:08', NULL, 'SINDI RAHMA SARI', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1006, 31, '12954/955.113', 'WSKKCF', NULL, '2024-11-19 13:09:08', NULL, 'SISKA TRI WARDANI PUTRI', NULL, NULL, 1, 'Ruang 21, Sesi 2'),
(1007, 31, '12955/956.113', 'NUMUVJ', NULL, '2024-11-19 13:09:08', NULL, 'SITI ARTIKA SARI AFRELIYANTI', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1008, 31, '12956/957.113', 'DSJUDJ', NULL, '2024-11-19 13:09:08', NULL, 'TADZKIROTUN NISWAH', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1009, 31, '12957/958.113', 'CNNAOQ', NULL, '2024-11-19 13:09:08', NULL, 'TYAS AYU RUSDIANA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1010, 31, '12958/959.113', 'WOKIRA', NULL, '2024-11-19 13:09:08', NULL, 'VIDY AGATHA PUTRI', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1011, 31, '12959/960.113', 'NUIHNE', NULL, '2024-11-19 13:09:08', NULL, 'VINZZA ENGELINA RAHMADHANI', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1012, 31, '12960/961.113', 'ZJBYDK', NULL, '2024-11-19 13:09:09', NULL, 'VIRSYA YAHYA DWI AGUSTIN', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1013, 31, '12961/962.113', 'HJPVSW', NULL, '2024-11-19 13:09:09', NULL, 'WINNA MARITZA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1014, 31, '12962/963.113', 'QYMQYT', NULL, '2024-11-19 13:09:09', NULL, 'YENI PUTRI DWI ANGGRAINI', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1015, 31, '12963/964.113', 'FRXHLS', NULL, '2024-11-19 13:09:09', NULL, 'YULIANTI TRI AGISTA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1016, 25, '13388/1557.063', 'MYDBZI', NULL, '2024-11-19 13:09:09', NULL, 'ABINAYA WIRA ANARGYA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1017, 25, '13389/1558.063', 'HEWPUR', NULL, '2024-11-19 13:09:09', NULL, 'ACHMAD FAHRI GALANG CAHYONO', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1018, 25, '13390/1559.063', 'WTNOIG', NULL, '2024-11-19 13:09:09', NULL, 'ACHMAD SYAMS FARUQ', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1019, 25, '13391/1560.063', 'SZPJED', NULL, '2024-11-19 13:09:09', NULL, 'ADHE BAGUS WAHYU SHAPUTRA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1020, 25, '13392/1561.063', 'BGTBNU', NULL, '2024-11-19 13:09:09', NULL, 'ALDO RAMADANI', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1021, 25, '13394/1563.063', 'OFJBLU', NULL, '2024-11-19 13:09:09', NULL, 'ALISA QOTRUN NADA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1022, 25, '13395/1564.063', 'CZUPQG', NULL, '2024-11-19 13:09:09', NULL, 'AMIR MUBIEN SUTISNA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1023, 25, '13396/1565.063', 'MZCIUH', NULL, '2024-11-19 13:09:09', NULL, 'ANDHINA RASTI DWI NUR AZHIZHI', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1024, 25, '13397/1566.063', 'PJANYD', NULL, '2024-11-19 13:09:09', NULL, 'ANISA INTANOVITA PURWANTI', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1025, 25, '13398/1567.063', 'VXZDOC', NULL, '2024-11-19 13:09:09', NULL, 'ARSYAD EDO PRATAMA', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1026, 25, '13399/1568.063', 'JQMBKB', NULL, '2024-11-19 13:09:09', NULL, 'ATAYA FIKRI RIZQULLAH PRAMONO', NULL, NULL, 1, 'Ruang 22, Sesi 2'),
(1027, 25, '13400/1569.063', 'GHTBRW', NULL, '2024-11-19 13:09:09', NULL, 'AUREL AMALIA PUTRI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1028, 25, '13401/1570.063', 'RHRPVP', NULL, '2024-11-19 13:09:09', NULL, 'AUREL MESSI NUZULUL PRATAMA', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1029, 25, '13402/1571.063', 'AFYABI', NULL, '2024-11-19 13:09:09', NULL, 'AURELY DESITA SYANDHI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1030, 25, '13403/1572.063', 'RZJIES', NULL, '2024-11-19 13:09:09', NULL, 'AXEL KARREM JABBAR', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1031, 25, '13404/1573.063', 'OMZGXY', NULL, '2024-11-19 13:09:09', NULL, 'AYU NANDARIKA SEPTYASHA', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1032, 25, '13405/1574.063', 'MOQGYE', NULL, '2024-11-19 13:09:09', NULL, 'AZ ZAHRA ELEVANY YANUARY', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1033, 25, '13406/1575.063', 'KTWVBV', NULL, '2024-11-19 13:09:09', NULL, 'BAGUS PANDU SADEWO', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1034, 25, '13407/1576.063', 'IZZKLI', NULL, '2024-11-19 13:09:09', NULL, 'BILLIE AGUNG RAMADHANI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1035, 25, '13409/1578.063', 'WFSVMV', NULL, '2024-11-19 13:09:09', NULL, 'CHANDRA KARUNIA HUTAMA', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1036, 25, '13410/1579.063', 'TWHOIO', NULL, '2024-11-19 13:09:09', NULL, 'CHELSEA ANATASYA RIYADI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1037, 25, '13411/1580.063', 'QTWBQW', NULL, '2024-11-19 13:09:09', NULL, 'CHRISTIAN AKASA PUTRA', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1038, 25, '13412/1581.063', 'FXBGJR', NULL, '2024-11-19 13:09:09', NULL, 'DAFFA THUFAIL ABIYYI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1039, 25, '13413/1582.063', 'VOGKBM', NULL, '2024-11-19 13:09:09', NULL, 'DIANA RISA ANGGREINI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1040, 25, '13414/1583.063', 'MIJTRT', NULL, '2024-11-19 13:09:09', NULL, 'DIVA FEBRI AMALIA', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1041, 25, '13415/1584.063', 'UWWYPM', NULL, '2024-11-19 13:09:09', NULL, 'DIZZA MIFIANTI SUBEKTI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1042, 25, '13416/1585.063', 'TUPLJM', NULL, '2024-11-19 13:09:09', NULL, 'DUNDA ARYA SUTA', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1043, 25, '13417/1586.063', 'AWDYEH', NULL, '2024-11-19 13:09:09', NULL, 'EDBERT FARRANT ALFARO', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1044, 25, '13418/1587.063', 'XHIARC', NULL, '2024-11-19 13:09:10', NULL, 'EVI SETYOWATI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1045, 25, '13419/1588.063', 'CTEREB', NULL, '2024-11-19 13:09:10', NULL, 'FADHLILAH ARGA SAPUTRA', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1046, 25, '13421/1590.063', 'ZPEFIW', NULL, '2024-11-19 13:09:10', NULL, 'FAHRIL AZIZ ALHUSAINI', NULL, NULL, 1, 'Ruang 23, Sesi 2'),
(1047, 25, '13422/1591.063', 'QXMIRQ', NULL, '2024-11-19 13:09:10', NULL, 'FAKHRI TAJUSA FARRAS', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1048, 26, '13423/1592.063', 'VGLIHZ', NULL, '2024-11-19 13:09:10', NULL, 'FAREL SATRIA ABISEKA', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1049, 26, '13424/1593.063', 'UDCASC', NULL, '2024-11-19 13:09:10', NULL, 'FARIS RAGIL WIJAYA', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1050, 26, '13425/1594.063', 'EOINUH', NULL, '2024-11-19 13:09:10', NULL, 'FARREL NADHIF HERAWANTO', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1051, 26, '13426/1595.063', 'AODSHZ', NULL, '2024-11-19 13:09:10', NULL, 'FAYAZA RYAS FAHRIZA PUTRI', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1052, 26, '13427/1596.063', 'JFMVRS', NULL, '2024-11-19 13:09:10', NULL, 'GALIH ARUNA NATA SUBEKTI', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1053, 26, '13428/1597.063', 'VEWCMM', NULL, '2024-11-19 13:09:10', NULL, 'GRACE KIRAISHA', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1054, 26, '13429/1598.063', 'PSJRHX', NULL, '2024-11-19 13:09:10', NULL, 'HAFIEZ DWI ALDRIEN', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1055, 26, '13430/1599.063', 'SZWPVD', NULL, '2024-11-19 13:09:10', NULL, 'HANAN FAIQLIL YAFI', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1056, 26, '13431/1600.063', 'VMIIBE', NULL, '2024-11-19 13:09:10', NULL, 'HANYAIKO APRILIA WIDIANSYAH', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1057, 26, '13432/1601.063', 'EIYCBC', NULL, '2024-11-19 13:09:10', NULL, 'HERALD ABDIEL SHALOM', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1058, 26, '13433/1602.063', 'PYQJBZ', NULL, '2024-11-19 13:09:10', NULL, 'HYUGA ARYA ZIDANE HARIYANTO', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1059, 26, '13434/1603.063', 'ICVAQR', NULL, '2024-11-19 13:09:10', NULL, 'ICHA AISYAH', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1060, 26, '13435/1604.063', 'HQOBUC', NULL, '2024-11-19 13:09:10', NULL, 'JIHAN FARA IRAWAN', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1061, 26, '13436/1605.063', 'PCSMPL', NULL, '2024-11-19 13:09:10', NULL, 'JUSTIN WINANDA WICAKSONO', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1062, 26, '13437/1606.063', 'VLMCGG', NULL, '2024-11-19 13:09:10', NULL, 'KAEYSA VIKA AULIA', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1063, 26, '13438/1607.063', 'BDEAQU', NULL, '2024-11-19 13:09:10', NULL, 'KAYLA DEXTRANIA AZALIA', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1064, 26, '13439/1608.063', 'VCIVGP', NULL, '2024-11-19 13:09:10', NULL, 'KEITARO DIOR PURNOMO', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1065, 26, '13440/1609.063', 'AVCRQV', NULL, '2024-11-19 13:09:10', NULL, 'KEVIN MAULANA IBRAHIM SETYAWAN', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1066, 26, '13441/1610.063', 'JULLVF', NULL, '2024-11-19 13:09:10', NULL, 'KEYSHA PUTRI ARINSA', NULL, NULL, 1, 'Ruang 24, Sesi 2'),
(1067, 26, '13443/1612.063', 'DHAESE', NULL, '2024-11-19 13:09:10', NULL, 'KHARISMA QUROTA A\\\'YUN', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1068, 26, '13444/1613.063', 'YMNKCF', NULL, '2024-11-19 13:09:10', NULL, 'MARSHELL TRI SUSANTO', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1069, 26, '13446/1615.063', 'VAHJFV', NULL, '2024-11-19 13:09:10', NULL, 'MOHAMMAD AXEL LINGGAR ALIF KHAN', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1070, 26, '13447/1616.063', 'IOIJFU', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD ALI FIRAZ PRATAMA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1071, 26, '13448/1617.063', 'WVMYII', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD ARIEL FATHONI', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1072, 26, '13449/1618.063', 'YWLXFZ', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD FAJRI HASAN FIRDAUS', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1073, 26, '13450/1619.063', 'AGCGES', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD MUZAKKIY SHIHAB', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1074, 26, '13451/1620.063', 'LYNJHK', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD NUR MUJIANTO', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1075, 26, '13452/1621.063', 'UULTRR', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD RANDY SYAHRUL HIDAYA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1076, 26, '13453/1622.063', 'TUGUMY', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD RIZKI DHAIFULLAH', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1077, 26, '13454/1623.063', 'ANRGQM', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD SHIFAK SATRIA PUTRA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1078, 26, '13455/1624.063', 'ANDNDX', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD WILDAN', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1079, 26, '13456/1625.063', 'UFRQKK', NULL, '2024-11-19 13:09:10', NULL, 'MUHAMMAD ZILDAN FIRMANSYAH', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1080, 26, '13457/1626.063', 'PFZRAQ', NULL, '2024-11-19 13:09:10', NULL, 'MULKI BISMA PRATAMA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1081, 26, '13458/1627.063', 'TPWBQN', NULL, '2024-11-19 13:09:11', NULL, 'NABILA NUR FARADILA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1082, 27, '13459/1628.063', 'TJVBRS', NULL, '2024-11-19 13:09:11', NULL, 'NADIVA ALMAGHFIRA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1083, 27, '13460/1629.063', 'BRSSOP', NULL, '2024-11-19 13:09:11', NULL, 'NANA SUPRIATNA SAPUTRA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1084, 27, '13461/1630.063', 'GBQKVM', NULL, '2024-11-19 13:09:11', NULL, 'NASWA NADHIA VEGA', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1085, 27, '13462/1631.063', 'YPKZBO', NULL, '2024-11-19 13:09:11', NULL, 'NAUFAL IMAM AINURROBBY', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1086, 27, '13463/1632.063', 'CYXCDJ', NULL, '2024-11-19 13:09:11', NULL, 'NAYLA RAIHANUN DEWI NURHAMIDAH', NULL, NULL, 1, 'Ruang 25, Sesi 2'),
(1087, 27, '13464/1633.063', 'ZPJXQA', NULL, '2024-11-19 13:09:11', NULL, 'NAYSELLA YUAN MARSHA', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1088, 27, '13465/1634.063', 'ANMBUT', NULL, '2024-11-19 13:09:11', NULL, 'NAYSILA AURURA', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1089, 27, '13466/1635.063', 'DUECQY', NULL, '2024-11-19 13:09:11', NULL, 'NIRWASITA DWI ARDIYANTI', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1090, 27, '13467/1636.063', 'DOYEZW', NULL, '2024-11-19 13:09:11', NULL, 'NOVA RISKA NAVASARI', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1091, 27, '13468/1637.063', 'XRYLEH', NULL, '2024-11-19 13:09:11', NULL, 'NUR AISYAH', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1092, 27, '13469/1638.063', 'TVJRGZ', NULL, '2024-11-19 13:09:11', NULL, 'NURHANDI ATHAR ROEMADI', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1093, 27, '13470/1639.063', 'KLZEPZ', NULL, '2024-11-19 13:09:11', NULL, 'OMAR MAULANA RAFAY SYAHMI', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1094, 27, '13471/1640.063', 'KIGKBD', NULL, '2024-11-19 13:09:11', NULL, 'PUTRI ROHMATUL KHASANAH', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1095, 27, '13472/1641.063', 'MWRVKX', NULL, '2024-11-19 13:09:11', NULL, 'QUEEN MALIKA RAMADANI', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1096, 27, '13473/1642.063', 'XGJFRW', NULL, '2024-11-19 13:09:11', NULL, 'RADITYA ADRIEL ADAM PRAMANA', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1097, 27, '13474/1643.063', 'WOLLLE', NULL, '2024-11-19 13:09:11', NULL, 'RADITYA RAVELINO ALEXANDRIA', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1098, 27, '13476/1645.063', 'SLCVEE', NULL, '2024-11-19 13:09:11', NULL, 'REZA NUR FITRAH ISLAMY', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1099, 27, '13477/1646.063', 'WALLTB', NULL, '2024-11-19 13:09:11', NULL, 'RIBY MASRUROH', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1100, 27, '13478/1647.063', 'YBSVMU', NULL, '2024-11-19 13:09:11', NULL, 'RIRIS SHABILLA ALVRI REYRA', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1101, 27, '13479/1648.063', 'NUMBTG', NULL, '2024-11-19 13:09:11', NULL, 'ROHMAH CINTA ANGGRAINI', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1102, 27, '13480/1649.063', 'TMLUHM', NULL, '2024-11-19 13:09:11', NULL, 'ROSYYAD FIRDAUS AL HAFIZ', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1103, 27, '13481/1650.063', 'VNGBZW', NULL, '2024-11-19 13:09:11', NULL, 'SALA HUDIN', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1104, 27, '13482/1651.063', 'DHTUNU', NULL, '2024-11-19 13:09:11', NULL, 'SANINDYA ARKANANTA', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1105, 27, '13483/1652.063', 'AWFHHB', NULL, '2024-11-19 13:09:11', NULL, 'SHEILA MAHARANI', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1106, 27, '13484/1653.063', 'LGXZGH', NULL, '2024-11-19 13:09:11', NULL, 'SOFIA DEWI AZ ZAHRO', NULL, NULL, 1, 'Ruang 26, Sesi 2'),
(1107, 27, '13485/1654.063', 'RPNDJI', NULL, '2024-11-19 13:09:11', NULL, 'STEVEN THOMAS SAMON', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1108, 27, '13486/1655.063', 'MPZSDY', NULL, '2024-11-19 13:09:11', NULL, 'SUBHAN KARIM', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1109, 27, '13487/1656.063', 'AYNVWX', NULL, '2024-11-19 13:09:11', NULL, 'TAZKIYA KHURFATUNNISA', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1110, 27, '13488/1657.063', 'VDCDXG', NULL, '2024-11-19 13:09:12', NULL, 'VANISSA PUTRI ANGGRAENI', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1111, 27, '13490/1659.063', 'IFNFWD', NULL, '2024-11-19 13:09:12', NULL, 'YANDRI NIRWANSYAH', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1112, 27, '13491/1660.063', 'KYYGOJ', NULL, '2024-11-19 13:09:12', NULL, 'YOGA SADEWA', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1113, 27, '13492/1661.063', 'ZGZYWH', NULL, '2024-11-19 13:09:12', NULL, 'YOHAN HADI BRODJOWIRUNO', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1114, 27, '13493/1662.063', 'JGXTMC', NULL, '2024-11-19 13:09:12', NULL, 'YOSUA GAVRILLA SANTOSO', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1115, 27, '13494/1663.063', 'EOOVZG', NULL, '2024-11-19 13:09:12', NULL, 'ZAKKIYYAH MELANNIE PUTRIE VIOLETTA', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1116, 22, '13036/2152.066', 'YNVZAB', NULL, '2024-11-19 13:09:12', NULL, 'ABD RAFI', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1117, 22, '13044/2160.066', 'EMXAFG', NULL, '2024-11-19 13:09:12', NULL, 'ALBI RIWALDI MAULANA', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1118, 22, '13045/2161.066', 'GPYIVZ', NULL, '2024-11-19 13:09:12', NULL, 'ALDA SELSI FIRDAUS', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1119, 22, '13049/2165.066', 'ZDQLCX', NULL, '2024-11-19 13:09:12', NULL, 'ALTHOFILAH ASLAM SYUJA HIDAYAT', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1120, 22, '13062/2178.066', 'IHXCYG', NULL, '2024-11-19 13:09:12', NULL, 'BURHANUDDIN', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1121, 22, '13065/2181.066', 'HKRMWO', NULL, '2024-11-19 13:09:12', NULL, 'DEVANA AURELYA AGUSTIN', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1122, 22, '13071/2187.066', 'XXFROU', NULL, '2024-11-19 13:09:12', NULL, 'FAHREZI INZAGHI', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1123, 22, '13073/2189.066', 'PAKDQI', NULL, '2024-11-19 13:09:12', NULL, 'FANNY VIOLITA RAHMANIA', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1124, 22, '13078/2194.066', 'YJWJLT', NULL, '2024-11-19 13:09:12', NULL, 'GENTA SATRIA NIRWANA', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1125, 22, '13079/2195.066', 'KGDQGK', NULL, '2024-11-19 13:09:12', NULL, 'HAMDAN NAUFAL BAHRUL ULUM', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1126, 22, '13080/2196.066', 'PBSQRS', NULL, '2024-11-19 13:09:12', NULL, 'HAVIZ FARHEZI WIBISONO', NULL, NULL, 1, 'Ruang 27, Sesi 2'),
(1127, 22, '13088/2204.066', 'JHTGQF', NULL, '2024-11-19 13:09:12', NULL, 'IVANA GRACIA ARBILITA OMEGA', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1128, 22, '13093/2209.066', 'VPKVQV', NULL, '2024-11-19 13:09:12', NULL, 'MEISILA MADILA DIANTI', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1129, 22, '13094/2210.066', 'SVSWTF', NULL, '2024-11-19 13:09:12', NULL, 'MELODY CECILIA PUTRI', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1130, 22, '13099/2215.066', 'LJIDRF', NULL, '2024-11-19 13:09:12', NULL, 'MOHAMAD RAZA KAYZAN KURNIAWAN', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1131, 22, '13109/2225.066', 'ZHDZXW', NULL, '2024-11-19 13:09:12', NULL, 'MUHAMMAD RIZKY NURFIRMANSYAH', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1132, 22, '13110/2226.066', 'JDOXAG', NULL, '2024-11-19 13:09:12', NULL, 'MUHAMMAD SULTAN AZZAM ALHAFIZD', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1133, 22, '13112/2228.066', 'MSIWZU', NULL, '2024-11-19 13:09:12', NULL, 'MUKHAMMAD FAUZAN NUR AFRIZA', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1134, 22, '13113/2229.066', 'DMOEMW', NULL, '2024-11-19 13:09:12', NULL, 'MUSTOFA ABDUL RAFI', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1135, 22, '13114/2230.066', 'AIEENC', NULL, '2024-11-19 13:09:12', NULL, 'NANDA AGUSTIN PUTRI FAWZYAH', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1136, 22, '13115/2231.066', 'DCXWYQ', NULL, '2024-11-19 13:09:12', NULL, 'NAYLA NUGRAHENY LESTARY ARDHIANY', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1137, 22, '13118/2234.066', 'QVJYGE', NULL, '2024-11-19 13:09:12', NULL, 'NIKI ANUGERAH TRISANDI', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1138, 22, '13121/2237.066', 'VBJDTF', NULL, '2024-11-19 13:09:12', NULL, 'NOVIA ANGELA ARIADI', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1139, 22, '13123/2239.066', 'GKLHOQ', NULL, '2024-11-19 13:09:12', NULL, 'NUR HALIFAH', NULL, NULL, 1, 'Ruang 28, Sesi 2');
INSERT INTO `cbt_user` (`user_id`, `user_grup_id`, `user_name`, `user_password`, `user_email`, `user_regdate`, `user_ip`, `user_firstname`, `user_birthdate`, `user_birthplace`, `user_level`, `user_detail`) VALUES
(1140, 22, '13125/2241.066', 'JUUSVB', NULL, '2024-11-19 13:09:12', NULL, 'PRISKILA ARDA CHRISTIAN', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1141, 22, '13126/2242.066', 'IGTJNC', NULL, '2024-11-19 13:09:12', NULL, 'R. AJI GALIH HIDAYATULLAH', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1142, 22, '13128/2244.066', 'DZYZHY', NULL, '2024-11-19 13:09:12', NULL, 'RAISYAH CAMEILA AZ ZAHRA', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1143, 22, '13131/2247.066', 'HXKIJJ', NULL, '2024-11-19 13:09:13', NULL, 'RIFQI APRELINO JETZADA', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1144, 22, '13135/2251.066', 'RXPIXC', NULL, '2024-11-19 13:09:13', NULL, 'SURYA SETA AJI WIDIGDYA', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1145, 22, '13136/2252.066', 'CPBAMI', NULL, '2024-11-19 13:09:13', NULL, 'VIVIT PUTRI NOVELA', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1146, 22, '13496/2258.066', 'WPZOUW', NULL, '2024-11-19 13:09:13', NULL, 'IVY IVANA YAKUB', NULL, NULL, 1, 'Ruang 28, Sesi 2'),
(1147, 22, '13497/2259.066', 'YRIMAL', NULL, '2024-11-19 13:09:13', NULL, 'SIONG FAH CIN', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1148, 22, '13498/2260.066', 'XKQYLC', NULL, '2024-11-19 13:09:13', NULL, 'PATRICIA', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1149, 23, '13037/2153.066', 'WDBHZC', NULL, '2024-11-19 13:09:13', NULL, 'ACHMAD JAZULI', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1150, 23, '13038/2154.066', 'LGAYJC', NULL, '2024-11-19 13:09:13', NULL, 'ADELINA DWI CITRA LESTARI', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1151, 23, '13039/2155.066', 'NDQGNV', NULL, '2024-11-19 13:09:13', NULL, 'ADITYA IBRA SYAHPUTRA', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1152, 23, '13040/2156.066', 'OCFIGK', NULL, '2024-11-19 13:09:13', NULL, 'AGIL FERDINAN', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1153, 23, '13041/2157.066', 'KPGJLF', NULL, '2024-11-19 13:09:13', NULL, 'AHMAD FADILAH', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1154, 23, '13043/2159.066', 'FWFIXW', NULL, '2024-11-19 13:09:13', NULL, 'AKHMAD IGO KURNIAWAN', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1155, 23, '13047/2163.066', 'VZWVAO', NULL, '2024-11-19 13:09:13', NULL, 'ALIFKA JOAN ARSITHA', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1156, 23, '13048/2164.066', 'MAUWMY', NULL, '2024-11-19 13:09:13', NULL, 'ALLEANDRO DEWO PASKALIS', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1157, 23, '13050/2166.066', 'NOSPNH', NULL, '2024-11-19 13:09:13', NULL, 'ANANTHA KURNIAWAN', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1158, 23, '13051/2167.066', 'FTEHQJ', NULL, '2024-11-19 13:09:13', NULL, 'ANDI MUHAMMAD ISYAFIFATHIR DAVA ARASHA', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1159, 23, '13052/2168.066', 'OPTXVM', NULL, '2024-11-19 13:09:13', NULL, 'ANGGA SAPUTRA', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1160, 23, '13053/2169.066', 'XPNNIW', NULL, '2024-11-19 13:09:13', NULL, 'ANGGUN PRIA MAVIKA SARI', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1161, 23, '13054/2170.066', 'BWNXXN', NULL, '2024-11-19 13:09:13', NULL, 'ANIN DITA NABILLAH PUTRI', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1162, 23, '13058/2174.066', 'ADVKJY', NULL, '2024-11-19 13:09:13', NULL, 'ARYA MAULANA AL AMIN', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1163, 23, '13061/2177.066', 'GXQFSM', NULL, '2024-11-19 13:09:13', NULL, 'BHILQIZ ARTCHANGGIE', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1164, 23, '13067/2183.066', 'DVKVPP', NULL, '2024-11-19 13:09:13', NULL, 'DIVA RAISYA NURIETA', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1165, 23, '13068/2184.066', 'EUHBFM', NULL, '2024-11-19 13:09:13', NULL, 'EBZAN TERTIANO PRADYGTA', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1166, 23, '13069/2185.066', 'IRMHVE', NULL, '2024-11-19 13:09:13', NULL, 'EPAN', NULL, NULL, 1, 'Ruang 29, Sesi 2'),
(1167, 23, '13074/2190.066', 'UQZRCW', NULL, '2024-11-19 13:09:13', NULL, 'FARHAN ALI AHMADA', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1168, 23, '13075/2191.066', 'SPEBDC', NULL, '2024-11-19 13:09:13', NULL, 'FELIX DAVA UMAURI', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1169, 23, '13081/2197.066', 'QYKSQC', NULL, '2024-11-19 13:09:13', NULL, 'HELMI DIAS RAMAHDANI', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1170, 23, '13083/2199.066', 'ZZOPAN', NULL, '2024-11-19 13:09:13', NULL, 'HUGO RAVAEL IBRAHIM', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1171, 23, '13086/2202.066', 'ZPYLOF', NULL, '2024-11-19 13:09:13', NULL, 'IQBAL BAYU NAGERI', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1172, 23, '13087/2203.066', 'GIIUSA', NULL, '2024-11-19 13:09:13', NULL, 'ISHAAM FERDIANSYAH EKA SATRIA', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1173, 23, '13089/2205.066', 'TAVVPE', NULL, '2024-11-19 13:09:13', NULL, 'JUAN ARDIYAS FIRANSYAH', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1174, 23, '13091/2207.066', 'OZVHIP', NULL, '2024-11-19 13:09:13', NULL, 'M HAIDAR ZAIM AL KAMAL', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1175, 23, '13092/2208.066', 'LPFBCQ', NULL, '2024-11-19 13:09:13', NULL, 'M RAFLI ADI SAPUTRA', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1176, 23, '13095/2211.066', 'MBUYAH', NULL, '2024-11-19 13:09:13', NULL, 'MELVANO DEVAN ALBANI', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1177, 23, '13098/2214.066', 'DXXSJM', NULL, '2024-11-19 13:09:13', NULL, 'MOH. AINOR YAQIN', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1178, 23, '13103/2219.066', 'IHLIBW', NULL, '2024-11-19 13:09:13', NULL, 'MUHAMMAD FAUZAN ABDILLAH', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1179, 23, '13104/2220.066', 'KUHPPD', NULL, '2024-11-19 13:09:13', NULL, 'MUHAMMAD IKHSAN SUBEKTI', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1180, 23, '13119/2235.066', 'YZDDME', NULL, '2024-11-19 13:09:14', NULL, 'NINA AMELIYA PUTRI', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1181, 23, '13132/2248.066', 'ZWWRLK', NULL, '2024-11-19 13:09:14', NULL, 'SANIA IZROTUL AZIZAH', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1182, 23, '13133/2249.066', 'QGDGXK', NULL, '2024-11-19 13:09:14', NULL, 'SARIFUDIN DAROJATUN', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1183, 23, '13139/2255.066', 'SOSYGZ', NULL, '2024-11-19 13:09:14', NULL, 'YOGA ZEN ZAHRURRIZAL', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1184, 24, '13046/2162.066', 'MFLLHC', NULL, '2024-11-19 13:09:14', NULL, 'ALIF ZULFI QISTIAN', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1185, 24, '13055/2171.066', 'TCFIOK', NULL, '2024-11-19 13:09:14', NULL, 'AQNI IKA CAHYANI', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1186, 24, '13056/2172.066', 'THGJXP', NULL, '2024-11-19 13:09:14', NULL, 'AQSHAL ABID ATHORIQ', NULL, NULL, 1, 'Ruang 30, Sesi 2'),
(1187, 24, '13060/2176.066', 'FAOLEP', NULL, '2024-11-19 13:09:14', NULL, 'BELA NUR JANAH', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1188, 24, '13063/2179.066', 'ZSUJNU', NULL, '2024-11-19 13:09:14', NULL, 'CHOLIN ARYA PUTRA NOVANTO', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1189, 24, '13064/2180.066', 'SYMANZ', NULL, '2024-11-19 13:09:14', NULL, 'DAFFA SURYA FADILLA', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1190, 24, '13066/2182.066', 'NVYWWY', NULL, '2024-11-19 13:09:14', NULL, 'DEVI PUTRI ANGGRAINI', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1191, 24, '13070/2186.066', 'JRREAF', NULL, '2024-11-19 13:09:14', NULL, 'FAHREL DWI NUGROHO', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1192, 24, '13072/2188.066', 'ZQTKJV', NULL, '2024-11-19 13:09:14', NULL, 'FANDY ABDILLAH AKBAR', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1193, 24, '13076/2192.066', 'CZTAVT', NULL, '2024-11-19 13:09:14', NULL, 'FRANS MARVIN MAULANA', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1194, 24, '13077/2193.066', 'ZYJWBD', NULL, '2024-11-19 13:09:14', NULL, 'GALANG DHUHA APRILIO', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1195, 24, '13082/2198.066', 'MLDVTY', NULL, '2024-11-19 13:09:14', NULL, 'HENDRAWAN ARI WIBAWA', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1196, 24, '13084/2200.066', 'CABSND', NULL, '2024-11-19 13:09:14', NULL, 'HUMA ISNA FATAH', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1197, 24, '13085/2201.066', 'YYWTVT', NULL, '2024-11-19 13:09:14', NULL, 'ICHLASSUL MUHFID', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1198, 24, '13090/2206.066', 'PCFHWL', NULL, '2024-11-19 13:09:14', NULL, 'KHALID ABIZIA', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1199, 24, '13097/2213.066', 'OIWXMT', NULL, '2024-11-19 13:09:14', NULL, 'MOCHAMAD TRISTAN ATHALLAH WIBAWA', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1200, 24, '13101/2217.066', 'NVVDYU', NULL, '2024-11-19 13:09:14', NULL, 'MUHAMMAD DAVA AKBAR AR RASYID', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1201, 24, '13102/2218.066', 'RXAIUT', NULL, '2024-11-19 13:09:14', NULL, 'MUHAMMAD FAKHRI AL IHSAN', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1202, 24, '13105/2221.066', 'FGKHLY', NULL, '2024-11-19 13:09:14', NULL, 'MUHAMMAD ILHAM UBAIDILLAH', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1203, 24, '13106/2222.066', 'IBRKJZ', NULL, '2024-11-19 13:09:14', NULL, 'MUHAMMAD IMRON FERDIANSYAH', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1204, 24, '13107/2223.066', 'RFOIZP', NULL, '2024-11-19 13:09:14', NULL, 'MUHAMMAD JAFAR SHODIQ', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1205, 24, '13108/2224.066', 'CXGMFT', NULL, '2024-11-19 13:09:14', NULL, 'MUHAMMAD RIZKY HIDAYATULLOH', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1206, 24, '13111/2227.066', 'YIBGSW', NULL, '2024-11-19 13:09:14', NULL, 'MUHAMMAD YAHYA SABIL ALHAMDULILAH', NULL, NULL, 1, 'Ruang 31, Sesi 2'),
(1207, 24, '13116/2232.066', 'JOBQIG', NULL, '2024-11-19 13:09:14', NULL, 'NAZRIL REFKIAN RIFKI', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1208, 24, '13117/2233.066', 'ZJONLB', NULL, '2024-11-19 13:09:15', NULL, 'NEVITO FEBRIANO ALAMSYAH', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1209, 24, '13122/2238.066', 'SDQHGH', NULL, '2024-11-19 13:09:15', NULL, 'NOVIA NABILA', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1210, 24, '13124/2240.066', 'IJWVPP', NULL, '2024-11-19 13:09:15', NULL, 'OCTAVIO PRATAMA', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1211, 24, '13127/2243.066', 'PZVJGK', NULL, '2024-11-19 13:09:15', NULL, 'RAFLI RAFA PRAMANA ARDIANSYAH', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1212, 24, '13130/2246.066', 'ZBNJST', NULL, '2024-11-19 13:09:15', NULL, 'RASYA RADITYA FANDYNANDA', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1213, 24, '13134/2250.066', 'HSMXOU', NULL, '2024-11-19 13:09:15', NULL, 'SULTAN FAREL ANELKA', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1214, 24, '13137/2253.066', 'GBTZSM', NULL, '2024-11-19 13:09:15', NULL, 'WINDRA AJI TEO FAIRUZ', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1215, 24, '13138/2254.066', 'BIMLYB', NULL, '2024-11-19 13:09:15', NULL, 'WIRYO AHMAD SYAFII', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1216, 24, '13140/2256.066', 'LBJLTV', NULL, '2024-11-19 13:09:15', NULL, 'YULIA ANANDA CHOIRIYAH', NULL, NULL, 1, 'Ruang 32, Sesi 2'),
(1217, 24, '13141/2257.066', 'LYNKDC', NULL, '2024-11-19 13:09:15', NULL, 'ZENA ZINAR DIAN IFANKA', NULL, NULL, 1, 'Ruang 32, Sesi 2');

-- --------------------------------------------------------

--
-- Table structure for table `cbt_user_backup`
--

CREATE TABLE `cbt_user_backup` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_grup_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_ip` varchar(39) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_birthplace` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_level` smallint(3) UNSIGNED NOT NULL DEFAULT '1',
  `user_detail` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_user_grup`
--

CREATE TABLE `cbt_user_grup` (
  `grup_id` bigint(20) UNSIGNED NOT NULL,
  `grup_nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cbt_user_grup`
--

INSERT INTO `cbt_user_grup` (`grup_id`, `grup_nama`) VALUES
(38, 'Uji Coba'),
(10, 'X ANIM 1'),
(11, 'X ANIM 2'),
(17, 'X BUSANA 1'),
(18, 'X BUSANA 2'),
(1, 'X DKV 1'),
(2, 'X DKV 2'),
(3, 'X DKV 3'),
(12, 'X DPK 1'),
(13, 'X DPK 2'),
(14, 'X DPK 3'),
(15, 'X DPK 4'),
(16, 'X DPK 5'),
(7, 'X PPLG 1'),
(8, 'X PPLG 2'),
(9, 'X PPLG 3'),
(4, 'X TJKT 1'),
(5, 'X TJKT 2'),
(6, 'X TJKT 3'),
(28, 'XI ANIM 1'),
(29, 'XI ANIM 2'),
(19, 'XI DKV 1'),
(20, 'XI DKV 2'),
(21, 'XI DKV 3'),
(36, 'XI DPB 1'),
(37, 'XI DPB 2'),
(34, 'XI KKA 1'),
(35, 'XI KKA 2'),
(32, 'XI KKR 1'),
(33, 'XI KKR 2'),
(30, 'XI KTK 1'),
(31, 'XI KTK 2'),
(25, 'XI RPL 1'),
(26, 'XI RPL 2'),
(27, 'XI RPL 3'),
(22, 'XI TKJ 1'),
(23, 'XI TKJ 2'),
(24, 'XI TKJ 3');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `opsi1` varchar(75) NOT NULL,
  `opsi2` varchar(75) NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `level` varchar(50) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `opsi1`, `opsi2`, `keterangan`, `level`, `ts`) VALUES
(1, 'admin', '2b3adcb9913c509fa9535aa9865acbb03e8a6d43', 'Administrator', '', '', '', 'admin', '2015-07-29 18:12:03'),
(4, 'operator', 'fe96dd39756ac41b74283a9292652d366d73931f', 'Operator', '', '', 'Operator', 'operator-soal', '2018-03-30 12:58:55'),
(7, '198603252023212029', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Maria Kristanti, S.E., S.Pd.K', '', '', 'Koord. MGMPS Pendidikan Agama dan Budi Pekerti (Kristen)', 'operator-soal', '2024-03-21 07:53:53'),
(8, '197202052022212004', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Modesta Sihombing, S.Ag.', '', '', 'Koord. MGMPS Pendidikan Agama Katholik', 'operator-soal', '2024-03-21 07:56:48'),
(9, 'Kustiani', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Kustiani, S.Ag, M.Pd.', '92', '', 'Koord. MGMPS Pendidikan Agama dan Budi Pekerti (Hindu)', 'operator-soal', '2024-03-21 07:59:12'),
(10, '198203302006042025', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Yayuk Srisuyanti, S.Pd.', '', '', 'Koord. MGMPS Pendidikan Pancasila dan Kewarganegaraan ', 'operator-soal', '2024-03-21 08:01:15'),
(13, '199009152023212032', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Septriana Nurhadiyanti, S.Pd', '', '', 'Koord. MGMPS Sejarah Indonesia', 'operator-soal', '2024-03-22 01:50:25'),
(15, '199202072022212018', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Anggie Lestantiya Febriyanti, M.Pd.', '', '', 'Koord. MGMPS Bahasa Jawa', 'operator-soal', '2024-03-22 01:57:29'),
(16, '199110212022211011', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Dian Purwanto, S.Pd', '', '', 'Koord. MGMPS Informatika', 'operator-soal', '2024-11-13 06:18:38'),
(17, '199001102014032001', '9096fdfab00e91fa1d1095a932c23a36bd123e86', 'Ellysa Rusdiyana,S.Pd', '', '', 'Wakil Kepala Sekolah I Bidang Kurikulum', 'admin', '2024-11-13 06:26:14'),
(18, '198810082022211009', 'c5ccb6f5374e06e3a7b03d916b2b6692503ba7a1', 'Qaharrudin Widyarto,S.Pd', '', '', 'Penjab Perencanaan dan Pelaksanaan KBM', 'admin', '2024-11-13 06:27:27'),
(19, '199210082022212019', 'f7f664ca8a128592b2aa13e8713d5b77db2100ba', 'Nita Oktiningsih, S,Pd.', '', '', 'Penjab Penilaian dan Evaluasi KBM', 'admin', '2024-11-13 06:28:15'),
(20, '197806102010012017', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Ahsana Amala, S.Ag.,M.Si.', '', '', 'Koord. MGMPS Pendidikan Agama dan Budi Pekerti (Islam)', 'operator-soal', '2024-11-13 06:29:41'),
(21, '196806121999031010', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Suwandi, S.Pd', '', '', 'Koord. MGMPS Bahasa Indonesia', 'operator-soal', '2024-11-13 06:33:45'),
(22, '197003102000122003', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Siti Mursidah, S.Pd.', '', '', 'Koord. MGMPS Matematika', 'operator-soal', '2024-11-13 06:34:54'),
(24, '197308012022212013', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Pinasthi Wilujeng, S.Pd', '', '', 'Koord. MGMPS Seni Budaya', 'operator-soal', '2024-11-13 06:37:09'),
(25, '196703121997032002', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Rustika Christiantari, S.Pd', '', '', 'Koord. MGMPS Projek Kreatifdan Kewirausahaan', 'operator-soal', '2024-11-13 06:38:10'),
(26, '198610102023211018', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Wahyu Prabowo, S.Pd', '', '', 'Koord. MGMPS Pendidikan Jasmani Olahraga dan Kesehatan', 'operator-soal', '2024-11-13 06:39:06'),
(27, '198710312011012003', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Hanie Vidya Christie, S.Pd.', '', '', 'Koord. MGMPS Proyek IPAS', 'operator-soal', '2024-11-13 06:39:58'),
(28, '198511222010011019', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Mahali, S.ST', '', '', 'Koord. MGMPS PPLG', 'operator-soal', '2024-11-13 06:40:54'),
(29, '199101282022211010', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Bayu Andi Sulistiya, S.Pd', '', '', 'Koord. MGMPS TJKT', 'operator-soal', '2024-11-13 06:41:57'),
(30, '199010302022212018', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Oktarica Pratiwi S, S.Kom., M.Pd.', '', '', 'Koord. MGMPS DKV', 'operator-soal', '2024-11-13 06:42:56'),
(31, '198105122014072003', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Nidya Sasando, S.Pd', '', '', 'Koord. MGMPS DPB', 'operator-soal', '2024-11-13 06:44:02'),
(32, '199303032022211014', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Dennys Rizky Eldian, S.Pd., M.Kom', '107,127,153', '', 'Koord. MGMPS Animasi', 'operator-soal', '2024-11-13 06:46:35'),
(33, '196804101994021002', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Aryono, S.Pd.', '', '', 'Koord. MGMPS KKR', 'operator-soal', '2024-11-13 06:47:32'),
(34, '196906271996011001', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Dwi Purnomo, S.Sn.', '', '', 'Koord. MGMPS KKA', 'operator-soal', '2024-11-13 06:48:27'),
(35, '196902131994122004', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Dra. Risdwi Soenoe W.', '', '', 'Koord. MGMPS KTK', 'operator-soal', '2024-11-13 06:49:25'),
(36, '196510121990031013', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Rasidi, ST, S.Pd, MM.', '', '', 'Kaprogli Kriya', 'operator-soal', '2024-11-19 02:27:38'),
(37, '196801051990031009', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Hariadi, S.Pd.', '', '', 'MAPIL FURNITURE 2 Kelas XI', 'operator-soal', '2024-11-19 03:12:54'),
(38, '197504022005011013', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Abdul Basith P S.P., M.Pd.', '', '', 'MAPIL Administrasi Sistem Jaringan', 'operator-soal', '2024-11-19 12:37:20'),
(39, '196604201990031017', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Soepardi, S.Pd.', '', '', 'MAPIL Teknologi Layanan Jaringan Lanjutan Kelas XI', 'operator-soal', '2024-11-19 12:38:30'),
(40, '199003312022212010', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Rosaria Astri Dewi, S.Sn.', '', '', 'MAPIL Animasi 2D Lanjutan Kelas XI ', 'operator-soal', '2024-11-19 12:39:51'),
(41, '198801292022212010', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Arie Widiyanita, S.ST., S.Pd.', '', '', 'MAPIL Animasi 3D Lanjutan Kelas XI', 'operator-soal', '2024-11-19 12:40:52'),
(42, '197105162006041022', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Suroso, S. Pd', '', '', 'MAPIL Batik Lanjutan Kelas XI', 'operator-soal', '2024-11-19 12:41:43'),
(43, '196509221996011001', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Nusa Setiawan Bahari, S.Sn.', '', '', 'MAPIL Sablon Lanjutan Kelas XI', 'operator-soal', '2024-11-19 12:42:35'),
(44, '197005152005012012', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Sri Sulistyorini, M.Pd', '', '', 'MAPIL Custom Made Fashion Lanjutan Kelas XI', 'operator-soal', '2024-11-19 12:44:37'),
(45, '196804161994021001', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Drs. Isnur Wahyudi', '', '', 'MAPIL Pembentukan keramik dengan Teknik Cetak (PdTC) - 1 Umum Kelas XI', 'operator-soal', '2024-11-19 12:51:09'),
(46, '196703061996011002', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Icuk Trisetyanto, S.Sn.', '', '', 'MAPIL Pembentukan keramik dengan Teknik Cetak (PdTC) - 2 Umum Kelas XI', 'operator-soal', '2024-11-19 12:52:01'),
(47, '196606261994021003', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Drs. Agung Pamudjihardjo, S.ST.', '', '', 'MAPIL Sketsa -1 Umum Kelas XI', 'operator-soal', '2024-11-19 12:52:56'),
(48, '197911032022211006', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Riza Habiby, S.Sn.', '', '', 'MAPIL Sketsa -2 Umum Kelas XI, MAPIL Desain Publikasi Lanjutan Kelas XI', 'operator-soal', '2024-11-19 12:54:31'),
(49, '197808062006041025', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'M. Agus Salim, S.Pd.', '', '', 'MAPIL Desain Publikasi Umum Kelas XI', 'operator-soal', '2024-11-19 12:56:36'),
(50, '198701222009031001', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Tiyas Hendra Saputra, SST.', '', '', 'MAPIL Pemrograman Web Umum Kelas XI', 'operator-soal', '2024-11-19 12:57:23'),
(51, '199105292020121009', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Bagus Triantono, S. Pd', '', '', 'MAPIL Matematika Tingkat Umum Kelas XI ', 'operator-soal', '2024-11-19 12:58:16'),
(52, '199112042020122021', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Miftachul Rohmah, S.Pd', '', '', 'Koord. MGMPS Bahasa Inggris', 'operator-soal', '2024-11-20 10:47:59'),
(53, '199409032024211002', 'd0ee06ad905b4b8a6cc30262243e59bc23d5b48f', 'Achmad Rizky Smaraq Dina, S.Pd', '', '', 'MAPIL Animasi 2D Umum Kelas XI ', 'operator-soal', '2024-11-20 12:35:52'),
(54, '123456', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Admin dian', '', '', 'Admin dian', 'operator-soal', '2024-11-29 02:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_akses`
--

CREATE TABLE `user_akses` (
  `id` int(11) NOT NULL,
  `level` varchar(75) NOT NULL,
  `kode_menu` varchar(50) NOT NULL,
  `add` int(2) NOT NULL DEFAULT '1' COMMENT '0=false, 1=true',
  `edit` int(2) NOT NULL DEFAULT '1' COMMENT '0=false, 1=true'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_akses`
--

INSERT INTO `user_akses` (`id`, `level`, `kode_menu`, `add`, `edit`) VALUES
(513, 'operator-tes', 'peserta-kartu', 1, 1),
(514, 'operator-tes', 'peserta-group', 0, 0),
(515, 'operator-tes', 'peserta-daftar', 1, 1),
(516, 'operator-tes', 'modul-daftar', 0, 0),
(517, 'operator-tes', 'tes-daftar', 1, 1),
(518, 'operator-tes', 'tes-evaluasi', 1, 1),
(519, 'operator-tes', 'modul-filemanager', 0, 0),
(520, 'operator-tes', 'tes-hasil', 1, 1),
(521, 'operator-tes', 'tes-hasil-operator', 1, 1),
(522, 'operator-tes', 'peserta-import', 1, 1),
(523, 'operator-tes', 'modul-soal', 0, 0),
(524, 'operator-tes', 'tes-tambah', 1, 1),
(525, 'operator-tes', 'tes-token', 1, 1),
(535, 'admin', 'laporan-analisis-butir-soal', 1, 1),
(537, 'admin', 'peserta-kartu', 1, 1),
(538, 'admin', 'peserta-group', 1, 1),
(539, 'admin', 'peserta-daftar', 1, 1),
(540, 'admin', 'modul-daftar', 1, 1),
(541, 'admin', 'tes-daftar', 1, 1),
(542, 'admin', 'tool-backup', 1, 1),
(543, 'admin', 'tes-evaluasi', 1, 1),
(544, 'admin', 'tool-exportimport-soal', 1, 1),
(545, 'admin', 'modul-filemanager', 1, 1),
(546, 'admin', 'tes-hasil', 1, 1),
(547, 'admin', 'peserta-import', 1, 1),
(548, 'admin', 'modul-import', 1, 1),
(549, 'admin', 'modul-import-word', 1, 1),
(550, 'admin', 'modul-topik', 1, 1),
(551, 'admin', 'user_level', 1, 1),
(552, 'admin', 'user_menu', 1, 1),
(553, 'admin', 'user-zyacbt', 1, 1),
(554, 'admin', 'user_atur', 1, 1),
(555, 'admin', 'laporan-rekap', 1, 1),
(556, 'admin', 'modul-soal', 1, 1),
(557, 'admin', 'tes-tambah', 1, 1),
(558, 'admin', 'tes-token', 1, 1),
(594, 'operator-soal', 'laporan-analisis-butir-soal', 0, 0),
(595, 'operator-soal', 'modul-daftar', 1, 1),
(596, 'operator-soal', 'modul-filemanager', 1, 1),
(597, 'operator-soal', 'tes-hasil', 1, 1),
(598, 'operator-soal', 'modul-import', 1, 1),
(599, 'operator-soal', 'modul-import-word', 1, 1),
(600, 'operator-soal', 'tes-evaluasi', 1, 1),
(601, 'operator-soal', 'laporan-rekap', 0, 0),
(602, 'operator-soal', 'modul-soal', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `id` int(11) NOT NULL,
  `level` varchar(50) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`id`, `level`, `keterangan`) VALUES
(1, 'admin', 'Administrator'),
(7, 'operator-soal', 'Operator Soal'),
(8, 'operator-tes', 'Operator Tes');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `log` varchar(250) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `tipe` int(11) NOT NULL DEFAULT '1' COMMENT '0=parent, 1=child',
  `parent` varchar(50) DEFAULT NULL,
  `kode_menu` varchar(50) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL DEFAULT '#',
  `icon` varchar(75) NOT NULL DEFAULT 'fa fa-circle-o',
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `tipe`, `parent`, `kode_menu`, `nama_menu`, `url`, `icon`, `urutan`) VALUES
(1, 0, '', 'user', 'Pengaturan', '#', 'fa fa-user', 20),
(3, 1, 'user', 'user_atur', 'Pengaturan User', 'manager/useratur', 'fa fa-circle-o', 5),
(4, 1, 'user', 'user_level', 'Pengaturan Level', 'manager/userlevel', 'fa fa-circle-o', 6),
(5, 1, 'user', 'user_menu', 'Pengaturan Menu', 'manager/usermenu', 'fa fa-circle-o', 7),
(6, 0, '', 'modul', 'Data Modul', '#', 'fa fa-book', 2),
(7, 1, 'modul', 'modul-daftar', 'Daftar Soal', 'manager/modul_daftar', 'fa fa-circle-o', 5),
(8, 1, 'modul', 'modul-topik', 'Mata Pelajaran', 'manager/modul_topik', 'fa fa-circle-o', 2),
(10, 0, '', 'peserta', 'Data Peserta', '#', 'fa fa-users', 3),
(11, 1, 'peserta', 'peserta-daftar', 'Daftar Peserta', 'manager/peserta_daftar', 'fa fa-circle-o', 2),
(12, 1, 'peserta', 'peserta-group', 'Daftar Kelas', 'manager/peserta_group', 'fa fa-circle-o', 1),
(13, 1, 'peserta', 'peserta-import', 'Import Data Peserta', 'manager/peserta_import', 'fa fa-circle-o', 3),
(14, 0, '', 'tes', 'Data Tes', '#', 'fa fa-tasks', 4),
(15, 1, 'tes', 'tes-tambah', 'Tambah Tes', 'manager/tes_tambah', 'fa fa-circle-o', 1),
(16, 1, 'tes', 'tes-daftar', 'Daftar Tes', 'manager/tes_daftar', 'fa fa-circle-o', 2),
(17, 1, 'tes', 'tes-hasil', 'Hasil Tes', 'manager/tes_hasil', 'fa fa-circle-o', 6),
(18, 1, 'modul', 'modul-soal', 'Soal', 'manager/modul_soal', 'fa fa-circle-o', 3),
(19, 1, 'tes', 'tes-token', 'Token', 'manager/tes_token', 'fa fa-circle-o', 8),
(22, 1, 'modul', 'modul-filemanager', 'File Manager', 'manager/modul_filemanager', 'fa fa-circle-o', 6),
(24, 1, 'modul', 'modul-import', 'Import Soal Spreadsheet', 'manager/modul_import', 'fa fa-circle-o', 4),
(25, 1, 'tes', 'tes-evaluasi', 'Koreksi Jawaban', 'manager/tes_evaluasi', 'fa fa-circle-o', 5),
(28, 1, 'tes', 'tes-hasil-operator', 'Hasil Tes Operator', 'manager/tes_hasil_operator', 'fa fa-circle-o', 10),
(30, 0, '', 'tool', 'Tool', '#', 'fa fa-wrench', 6),
(31, 1, 'tool', 'tool-backup', 'Database', 'manager/tool_backup', 'fa fa-database', 1),
(32, 1, 'tes-laporan', 'laporan-rekap', 'Rekap Hasil Tes', 'manager/laporan_rekap_hasil', 'fa fa-circle-o', 7),
(33, 1, 'tool', 'tool-exportimport-soal', 'Export / Import Soal', 'manager/tool_exportimport_soal', 'fa fa-circle-o', 2),
(34, 1, 'user', 'user-zyacbt', 'Pengaturan', 'manager/pengaturan_zyacbt', 'fa fa-circle-o', 1),
(37, 1, 'peserta', 'peserta-kartu', 'Cetak Kartu', 'manager/peserta_kartu', 'fa fa-circle-o', 5),
(38, 0, '', 'tes-laporan', 'Laporan', '#', 'fa fa-print', 5),
(41, 1, 'tes-laporan', 'laporan-analisis-butir-soal', 'Analisis Butir Soal', 'manager/laporan_analisis_butir_soal', 'fa fa-circle-o', 1),
(43, 1, 'modul', 'modul-import-word', 'Import Soal Word', 'manager/modul_import_word', 'fa fa-circle-o', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cbt_jawaban`
--
ALTER TABLE `cbt_jawaban`
  ADD PRIMARY KEY (`jawaban_id`),
  ADD KEY `p_answer_question_id` (`jawaban_soal_id`);

--
-- Indexes for table `cbt_konfigurasi`
--
ALTER TABLE `cbt_konfigurasi`
  ADD PRIMARY KEY (`konfigurasi_id`),
  ADD UNIQUE KEY `konfigurasi_kode` (`konfigurasi_kode`);

--
-- Indexes for table `cbt_modul`
--
ALTER TABLE `cbt_modul`
  ADD PRIMARY KEY (`modul_id`),
  ADD UNIQUE KEY `ak_module_name` (`modul_nama`);

--
-- Indexes for table `cbt_sessions`
--
ALTER TABLE `cbt_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `cbt_soal`
--
ALTER TABLE `cbt_soal`
  ADD PRIMARY KEY (`soal_id`),
  ADD KEY `p_question_subject_id` (`soal_topik_id`);

--
-- Indexes for table `cbt_tes`
--
ALTER TABLE `cbt_tes`
  ADD PRIMARY KEY (`tes_id`),
  ADD UNIQUE KEY `ak_test_name` (`tes_nama`);

--
-- Indexes for table `cbt_tesgrup`
--
ALTER TABLE `cbt_tesgrup`
  ADD PRIMARY KEY (`tstgrp_tes_id`,`tstgrp_grup_id`),
  ADD KEY `p_tstgrp_test_id` (`tstgrp_tes_id`),
  ADD KEY `p_tstgrp_group_id` (`tstgrp_grup_id`);

--
-- Indexes for table `cbt_tes_soal`
--
ALTER TABLE `cbt_tes_soal`
  ADD PRIMARY KEY (`tessoal_id`),
  ADD UNIQUE KEY `ak_testuser_question` (`tessoal_tesuser_id`,`tessoal_soal_id`),
  ADD KEY `p_testlog_question_id` (`tessoal_soal_id`),
  ADD KEY `p_testlog_testuser_id` (`tessoal_tesuser_id`);

--
-- Indexes for table `cbt_tes_soal_jawaban`
--
ALTER TABLE `cbt_tes_soal_jawaban`
  ADD PRIMARY KEY (`soaljawaban_tessoal_id`,`soaljawaban_jawaban_id`),
  ADD KEY `p_logansw_answer_id` (`soaljawaban_jawaban_id`),
  ADD KEY `p_logansw_testlog_id` (`soaljawaban_tessoal_id`);

--
-- Indexes for table `cbt_tes_token`
--
ALTER TABLE `cbt_tes_token`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `token_user_id` (`token_user_id`);

--
-- Indexes for table `cbt_tes_topik_set`
--
ALTER TABLE `cbt_tes_topik_set`
  ADD PRIMARY KEY (`tset_id`),
  ADD KEY `p_tsubset_test_id` (`tset_tes_id`),
  ADD KEY `tsubset_subject_id` (`tset_topik_id`);

--
-- Indexes for table `cbt_tes_user`
--
ALTER TABLE `cbt_tes_user`
  ADD PRIMARY KEY (`tesuser_id`),
  ADD UNIQUE KEY `ak_testuser` (`tesuser_tes_id`,`tesuser_user_id`,`tesuser_status`),
  ADD KEY `p_testuser_user_id` (`tesuser_user_id`),
  ADD KEY `p_testuser_test_id` (`tesuser_tes_id`);

--
-- Indexes for table `cbt_topik`
--
ALTER TABLE `cbt_topik`
  ADD PRIMARY KEY (`topik_id`),
  ADD UNIQUE KEY `ak_subject_name` (`topik_modul_id`,`topik_nama`);

--
-- Indexes for table `cbt_user`
--
ALTER TABLE `cbt_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `ak_user_name` (`user_name`),
  ADD KEY `user_groups_id` (`user_grup_id`),
  ADD KEY `user_detail` (`user_detail`);

--
-- Indexes for table `cbt_user_backup`
--
ALTER TABLE `cbt_user_backup`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `ak_user_name` (`user_name`),
  ADD KEY `user_groups_id` (`user_grup_id`),
  ADD KEY `user_detail` (`user_detail`);

--
-- Indexes for table `cbt_user_grup`
--
ALTER TABLE `cbt_user_grup`
  ADD PRIMARY KEY (`grup_id`),
  ADD UNIQUE KEY `group_name` (`grup_nama`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `level` (`level`);

--
-- Indexes for table `user_akses`
--
ALTER TABLE `user_akses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akses_kode_menu` (`kode_menu`),
  ADD KEY `akses_level` (`level`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level` (`level`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_menu` (`kode_menu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cbt_jawaban`
--
ALTER TABLE `cbt_jawaban`
  MODIFY `jawaban_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13846;
--
-- AUTO_INCREMENT for table `cbt_konfigurasi`
--
ALTER TABLE `cbt_konfigurasi`
  MODIFY `konfigurasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cbt_modul`
--
ALTER TABLE `cbt_modul`
  MODIFY `modul_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cbt_soal`
--
ALTER TABLE `cbt_soal`
  MODIFY `soal_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3179;
--
-- AUTO_INCREMENT for table `cbt_tes`
--
ALTER TABLE `cbt_tes`
  MODIFY `tes_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `cbt_tes_soal`
--
ALTER TABLE `cbt_tes_soal`
  MODIFY `tessoal_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=535017;
--
-- AUTO_INCREMENT for table `cbt_tes_token`
--
ALTER TABLE `cbt_tes_token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `cbt_tes_topik_set`
--
ALTER TABLE `cbt_tes_topik_set`
  MODIFY `tset_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `cbt_tes_user`
--
ALTER TABLE `cbt_tes_user`
  MODIFY `tesuser_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14760;
--
-- AUTO_INCREMENT for table `cbt_topik`
--
ALTER TABLE `cbt_topik`
  MODIFY `topik_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `cbt_user`
--
ALTER TABLE `cbt_user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1218;
--
-- AUTO_INCREMENT for table `cbt_user_backup`
--
ALTER TABLE `cbt_user_backup`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cbt_user_grup`
--
ALTER TABLE `cbt_user_grup`
  MODIFY `grup_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `user_akses`
--
ALTER TABLE `user_akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=603;
--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cbt_jawaban`
--
ALTER TABLE `cbt_jawaban`
  ADD CONSTRAINT `cbt_jawaban_ibfk_1` FOREIGN KEY (`jawaban_soal_id`) REFERENCES `cbt_soal` (`soal_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_soal`
--
ALTER TABLE `cbt_soal`
  ADD CONSTRAINT `cbt_soal_ibfk_1` FOREIGN KEY (`soal_topik_id`) REFERENCES `cbt_topik` (`topik_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_tesgrup`
--
ALTER TABLE `cbt_tesgrup`
  ADD CONSTRAINT `cbt_tesgrup_ibfk_1` FOREIGN KEY (`tstgrp_tes_id`) REFERENCES `cbt_tes` (`tes_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `cbt_tesgrup_ibfk_2` FOREIGN KEY (`tstgrp_grup_id`) REFERENCES `cbt_user_grup` (`grup_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_tes_soal`
--
ALTER TABLE `cbt_tes_soal`
  ADD CONSTRAINT `cbt_tes_soal_ibfk_1` FOREIGN KEY (`tessoal_tesuser_id`) REFERENCES `cbt_tes_user` (`tesuser_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `cbt_tes_soal_ibfk_2` FOREIGN KEY (`tessoal_soal_id`) REFERENCES `cbt_soal` (`soal_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_tes_soal_jawaban`
--
ALTER TABLE `cbt_tes_soal_jawaban`
  ADD CONSTRAINT `cbt_tes_soal_jawaban_ibfk_1` FOREIGN KEY (`soaljawaban_tessoal_id`) REFERENCES `cbt_tes_soal` (`tessoal_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `cbt_tes_soal_jawaban_ibfk_2` FOREIGN KEY (`soaljawaban_jawaban_id`) REFERENCES `cbt_jawaban` (`jawaban_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_tes_token`
--
ALTER TABLE `cbt_tes_token`
  ADD CONSTRAINT `cbt_tes_token_ibfk_1` FOREIGN KEY (`token_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cbt_tes_topik_set`
--
ALTER TABLE `cbt_tes_topik_set`
  ADD CONSTRAINT `cbt_tes_topik_set_ibfk_1` FOREIGN KEY (`tset_tes_id`) REFERENCES `cbt_tes` (`tes_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `cbt_tes_topik_set_ibfk_2` FOREIGN KEY (`tset_topik_id`) REFERENCES `cbt_topik` (`topik_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_tes_user`
--
ALTER TABLE `cbt_tes_user`
  ADD CONSTRAINT `cbt_tes_user_ibfk_1` FOREIGN KEY (`tesuser_tes_id`) REFERENCES `cbt_tes` (`tes_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cbt_tes_user_ibfk_2` FOREIGN KEY (`tesuser_user_id`) REFERENCES `cbt_user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_topik`
--
ALTER TABLE `cbt_topik`
  ADD CONSTRAINT `cbt_topik_ibfk_1` FOREIGN KEY (`topik_modul_id`) REFERENCES `cbt_modul` (`modul_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cbt_user`
--
ALTER TABLE `cbt_user`
  ADD CONSTRAINT `cbt_user_ibfk_1` FOREIGN KEY (`user_grup_id`) REFERENCES `cbt_user_grup` (`grup_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`level`) REFERENCES `user_level` (`level`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_akses`
--
ALTER TABLE `user_akses`
  ADD CONSTRAINT `user_akses_ibfk_2` FOREIGN KEY (`kode_menu`) REFERENCES `user_menu` (`kode_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_akses_ibfk_3` FOREIGN KEY (`level`) REFERENCES `user_level` (`level`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
