-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2020 at 01:17 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ketam_mp`
--
CREATE DATABASE IF NOT EXISTS `db_ketam_mp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_ketam_mp`;

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
--

DROP TABLE IF EXISTS `data_barang`;
CREATE TABLE IF NOT EXISTS `data_barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_merk` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `denda_hilang` int(11) NOT NULL,
  `denda_lewat` int(11) NOT NULL,
  `diskon` int(11) DEFAULT NULL,
  `tgl_awal_diskon` date DEFAULT NULL,
  `tgl_akhir_diskon` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi_barang` text,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`id_barang`, `id_kategori`, `id_toko`, `id_merk`, `nama_barang`, `stok`, `harga_sewa`, `denda_hilang`, `denda_lewat`, `diskon`, `tgl_awal_diskon`, `tgl_akhir_diskon`, `foto`, `deskripsi_barang`) VALUES
(1, 1, 1, 1, 'Tenda (4 Orang)', 1, 50000, 550000, 10000, 0, '0000-00-00', '0000-00-00', '', '<p>Tenda berkapasitas 4 orang...</p>\r\n'),
(2, 2, 2, 2, 'Kerel Rei R-384', 1, 1000, 10000, 1000, 0, '0000-00-00', '0000-00-00', '', '<p>Tas Kerel&nbsp;Rei tipe&nbsp;R-384...</p>\r\n'),
(3, 1, 1, 2, 'Tenda (2 Orang)', 2, 25000, 320000, 3000, 0, '0000-00-00', '0000-00-00', '', '<p>Tenda berkapasitas 2 orang...</p>\r\n'),
(4, 2, 3, 1, 'Kerel Eiger A775', 2, 100000, 250000, 10000, 0, '0000-00-00', '0000-00-00', '', '<p>Kerel Eiger A775...</p>\r\n'),
(5, 6, 4, 3, 'Sepatu Consina A', 2, 10000, 325000, 7000, NULL, NULL, NULL, NULL, '<p>vsdvsd klcl jkj JBFKww bfcjwhsb sdvbaj&nbsp;</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `data_barang_foto`
--

DROP TABLE IF EXISTS `data_barang_foto`;
CREATE TABLE IF NOT EXISTS `data_barang_foto` (
  `id_barang_foto` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_barang_foto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_barang_foto`
--

INSERT INTO `data_barang_foto` (`id_barang_foto`, `id_barang`, `foto`) VALUES
(1, 3, 'assets/img/barang/b4661a27c8b70b8827d26d6731761e24981df061.png'),
(2, 3, 'assets/img/barang/c3f0745951c46bfef8f6e5bd7d3cf35091358ee8.jpeg'),
(3, 4, 'assets/img/barang/014f7d7e34de36d393637b13ae9061fdbc4ffa43.png'),
(4, 5, 'assets/img/barang/ceddedb3ddfbb17899b6aa618f4bd787be4f8069.png'),
(5, 5, 'assets/img/barang/b7a71f3db87cff5f9eb30f1bfdb263cf3672b25e.png'),
(6, 5, 'assets/img/barang/2d8f97389cada89e73202cbd3b93b0b30ae482d3.png');

-- --------------------------------------------------------

--
-- Table structure for table `data_bintang_toko`
--

DROP TABLE IF EXISTS `data_bintang_toko`;
CREATE TABLE IF NOT EXISTS `data_bintang_toko` (
  `id_ranking_toko` int(11) NOT NULL AUTO_INCREMENT,
  `id_toko` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah_bintang` int(11) NOT NULL,
  `ulasan_toko` text NOT NULL,
  PRIMARY KEY (`id_ranking_toko`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_bukti_pembayaran`
--

DROP TABLE IF EXISTS `data_bukti_pembayaran`;
CREATE TABLE IF NOT EXISTS `data_bukti_pembayaran` (
  `id_bukti_pembayaran` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `foto` varchar(255) NOT NULL,
  `jenis_pembayaran` enum('panjar','lunas') NOT NULL DEFAULT 'panjar',
  `jumlah_pembayaran` int(11) NOT NULL,
  PRIMARY KEY (`id_bukti_pembayaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_informasi_tambahan`
--

DROP TABLE IF EXISTS `data_informasi_tambahan`;
CREATE TABLE IF NOT EXISTS `data_informasi_tambahan` (
  `id_informasi_tambahan` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_toko` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id_informasi_tambahan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_kategori`
--

DROP TABLE IF EXISTS `data_kategori`;
CREATE TABLE IF NOT EXISTS `data_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_kategori`
--

INSERT INTO `data_kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Tenda', 'Tenda..'),
(2, 'Tas Kerel', 'Tas Kerel...'),
(3, 'Tas Ransel', 'Tas Ransel...'),
(4, 'Kompor', 'Kompor...'),
(5, 'Matras', 'Matras...'),
(6, 'Sepatu', ''),
(7, 'Lain-lain', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_keranjang`
--

DROP TABLE IF EXISTS `data_keranjang`;
CREATE TABLE IF NOT EXISTS `data_keranjang` (
  `id_keranjang` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `tgl_sewa_awal` date NOT NULL,
  `tgl_sewa_akhir` date NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `tgl_masuk` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int(11) NOT NULL,
  PRIMARY KEY (`id_keranjang`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_keranjang`
--

INSERT INTO `data_keranjang` (`id_keranjang`, `id_pelanggan`, `id_barang`, `jumlah_barang`, `tgl_sewa_awal`, `tgl_sewa_akhir`, `jumlah_hari`, `tgl_masuk`, `total_harga`) VALUES
(20, 1, 5, 1, '2020-10-25', '2020-10-30', 5, '2020-12-07 23:18:17', 50000),
(21, 1, 5, 1, '2020-10-25', '2020-10-30', 5, '2020-12-15 21:00:13', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_umum`
--

DROP TABLE IF EXISTS `data_konfigurasi_umum`;
CREATE TABLE IF NOT EXISTS `data_konfigurasi_umum` (
  `id_konfigurasi_umum` int(11) NOT NULL AUTO_INCREMENT,
  `nama_konfigurasi` varchar(100) NOT NULL,
  `nilai_konfigurasi` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_konfigurasi_umum`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_konfigurasi_umum`
--

INSERT INTO `data_konfigurasi_umum` (`id_konfigurasi_umum`, `nama_konfigurasi`, `nilai_konfigurasi`, `keterangan`) VALUES
(1, 'biaya_administrasi', '20000', 'Biaya administrasi untuk setiap transaksi.'),
(2, 'no_rek_transaksi', '0901111111111111111', 'Bank BRI Atas Nama : Bla bla bla'),
(3, 'biaya_administrasi', '20000', 'Biaya panjar bagi pelanggan.'),
(4, 'office_address', 'Jl. Griya Pajjaiyang Indah Blok C No.1, Kel. Sudiang Raya, Kec. Biringkanaya, Kota Makassar, Sulawesi Selatan 90324', 'Alamat Kantor : Jl. Griya Pajjaiyang Indah Blok C No.1, Kel. Sudiang Raya, Kec. Biringkanaya, Kota Makassar, Sulawesi Selatan 90324'),
(5, 'phone_number', '+62 852 1029 1210', 'No. Telp : +62 852 1029 1210'),
(6, 'official_website', 'http://www.aryanspider.blogspot.com', 'Situs Resmi : http://www.aryanspider.blogspot.com'),
(7, 'official_email', 'aryan@stimednp.ac.id', 'Email Resmi : aryan@stimednp.ac.id'),
(8, 'open_hours', 'Senin-Jumat, pukul 08:00 AM â€“ 06:00 PM WITA', 'Jam Kerja : Senin-Jumat, pukul 08:00 AM â€“ 06:00 PM WITA');

-- --------------------------------------------------------

--
-- Table structure for table `data_merk`
--

DROP TABLE IF EXISTS `data_merk`;
CREATE TABLE IF NOT EXISTS `data_merk` (
  `id_merk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_merk` varchar(25) NOT NULL,
  PRIMARY KEY (`id_merk`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_merk`
--

INSERT INTO `data_merk` (`id_merk`, `nama_merk`) VALUES
(1, 'Eiger'),
(2, 'Rei'),
(3, 'Consina'),
(4, 'Naturehike'),
(5, 'Osprey');

-- --------------------------------------------------------

--
-- Table structure for table `data_pelanggan`
--

DROP TABLE IF EXISTS `data_pelanggan`;
CREATE TABLE IF NOT EXISTS `data_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `status_akun` enum('aktif','blokir') NOT NULL,
  `user_token` varchar(32) NOT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pelanggan`
--

INSERT INTO `data_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `email`, `telepon`, `alamat`, `username`, `password`, `foto`, `foto_ktp`, `status_akun`, `user_token`) VALUES
(1, 'Pelanggan', 'ibnu.tuharea@stimednp.ac.id', '081xxx', 'Jl. Bla bla bla', 'pelanggan', '7f78f06d2d1262a0a222ca9834b15d9d', '', '', 'aktif', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_pengguna`
--

DROP TABLE IF EXISTS `data_pengguna`;
CREATE TABLE IF NOT EXISTS `data_pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `jenis_akun` enum('admin','toko') NOT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pengguna`
--

INSERT INTO `data_pengguna` (`id_pengguna`, `nama_pengguna`, `email`, `telepon`, `foto`, `username`, `password`, `jenis_akun`) VALUES
(1, 'Admin', 'admin@gmail.com', '08100000', 'assets/img/pengguna/ef3e0bad1c7c6ab1436edff6dc585305d2729007.png', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'Muhammad Fauzan Wiradman', 'fauzan@gmail.com', '082237825226', 'assets/img/pengguna/fd7a1dde8a665fc704ea02888b2c603cd4d71e53.png', 'tio', 'b71b3e083dd4533ed48421a696890835', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `data_toko`
--

DROP TABLE IF EXISTS `data_toko`;
CREATE TABLE IF NOT EXISTS `data_toko` (
  `id_toko` int(11) NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(50) NOT NULL,
  `nama_pemilik` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `deskripsi_toko` text NOT NULL,
  `status_akun` enum('aktif','non_aktif','blokir') NOT NULL DEFAULT 'non_aktif',
  PRIMARY KEY (`id_toko`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_toko`
--

INSERT INTO `data_toko` (`id_toko`, `nama_toko`, `nama_pemilik`, `alamat`, `telepon`, `email`, `foto`, `username`, `password`, `deskripsi_toko`, `status_akun`) VALUES
(1, 'Akbar Rent', 'Akbar Mulyadi', 'Jakarta', '081xxxxxxxxx', 'akbar.mulyadi@gmail.com', 'assets/img/toko/394ce2365634370e390f49a1f0fca4276ccaa55c.png', 'akbar', '4f033a0a2bf2fe0b68800a3079545cd1', 'Blablabla', 'blokir'),
(2, 'Seno Rent', 'Suseno', 'Surabaya, Jawa Timur', '0821xxxxxxxx', 'seno.rent@gmail.com', 'assets/img/toko/e87ef67ace1bbd8833c2f66acdcd2753f7e7d508.jpeg', '', '21232f297a57a5a743894a0e4a801fc3', 'Seno Rent...', 'non_aktif'),
(3, 'Reza Outdor Equipment Rent', 'Muhammad Reza Anugrah', 'Gowa, Sulawesi Selatan.', '082195005513', 'rezamuhmmmd@gmail.com', 'assets/img/toko/e87ef67ace1bbd8833c2f66acdcd2753f7e7d508.jpeg', 'reza', 'bb98b1d0b523d5e783f931550d7702b6', 'Reza Outdor Equipment Rent punya nya Muhammad Reza Anugrah dkk...', 'aktif'),
(4, 'Coba 1', 'Coba 1', 'Coba 1', '081xxxxxxxxx', 'coba1@gmail.com', '', 'toko', 'bbb48314e5e6ee68d2d8bc1364b8599b', 'Coba 1...', 'aktif'),
(5, 'Coba 2', 'Coba 2', 'Coba 2', '081xxxxxxxxx', 'coba2@gmail.com', '', 'coba2', '17146a464726f22dc5ff649fca94761e', 'Coba 2', 'non_aktif'),
(6, 'Coba 3', 'Coba 3', 'Coba 3', '081xxxxxxxxx', 'coba3@gmail.com', '', 'coba3', 'fb1b8e85a800886adeadb7cccf12a524', 'Coba 3...', 'non_aktif');

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi`
--

DROP TABLE IF EXISTS `data_transaksi`;
CREATE TABLE IF NOT EXISTS `data_transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(32) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `no_telp` varchar(13) DEFAULT NULL,
  `keterangan` text,
  `diantarkan` enum('tidak','ya') NOT NULL DEFAULT 'tidak',
  `tgl_pengantaran` date DEFAULT NULL,
  `alamat_pengantaran` varchar(255) NOT NULL,
  `longlat` varchar(255) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `status_transaksi` enum('tunggu','proses','selesai','batal') NOT NULL DEFAULT 'tunggu',
  `tgl_awal_transaksi` date NOT NULL,
  `tgl_akhir_transaksi` date NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `status_pengembalian` enum('belum','ya','sudah') NOT NULL DEFAULT 'belum',
  `tgl_pengembalian` date DEFAULT NULL,
  `toko_check` enum('belum','sudah','selesai','tolak') NOT NULL DEFAULT 'belum',
  `pelanggan_check` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `rating` int(11) DEFAULT NULL,
  `ulasan` text,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi`
--

INSERT INTO `data_transaksi` (`id_transaksi`, `no_transaksi`, `tgl_transaksi`, `id_pelanggan`, `no_telp`, `keterangan`, `diantarkan`, `tgl_pengantaran`, `alamat_pengantaran`, `longlat`, `id_toko`, `status_transaksi`, `tgl_awal_transaksi`, `tgl_akhir_transaksi`, `jumlah_hari`, `status_pengembalian`, `tgl_pengembalian`, `toko_check`, `pelanggan_check`, `rating`, `ulasan`) VALUES
(16, 'TR--20201117401194117', '2020-11-17', 1, '081xxx', 'vfldvd', 'tidak', '2020-11-18', 'sd', '-5.147665,119.432732', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-11-22', 'selesai', 'sudah', NULL, NULL),
(17, 'TR-20201201982221846', '2020-12-01', 1, '081xxx', '', 'tidak', '2020-12-02', 'cdsc', '-5.147665,119.432732', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', NULL, NULL),
(18, 'TR-20201202417004921', '2020-12-02', 1, '081xxx', '', 'tidak', '2020-12-01', 's', '-5.150788706800275,119.43978224141526', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', NULL, NULL),
(19, 'TR-20201202103011553', '2020-12-02', 1, '081xxx', '', 'tidak', '2020-12-03', 'cds', '-5.146190491462918,119.44175389137163', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', NULL, NULL),
(20, 'TR-20201202817224421', '2020-12-02', 1, '081xxx', 'dcscds', 'tidak', '2020-12-24', 'dc', '-5.15364286974775,119.438390784598', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', 5, 'fesewf'),
(21, 'TR-20201202416233006', '2020-12-02', 1, '081xxx', 'ssc sc sccsc scs', 'tidak', '2020-12-02', 'cs', '-5.155330519260542,119.4404498036828', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', 3, 'KKK'),
(22, 'TR-20201202825233557', '2020-12-02', 1, '081xxx', 'scs', 'tidak', '2020-12-18', 'cs', '-5.147665,119.432732', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', NULL, NULL),
(23, 'TR-20201202016233748', '2020-12-02', 1, '081xxx', '', 'tidak', '2020-12-26', 'scs', '-5.150852836691099,119.43675671718003', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', 5, 'cds'),
(24, 'TR-20201207986223932', '2020-12-07', 1, '081xxx', 'dscs', 'tidak', '2020-12-08', 'Pajai', '-5.153474244602384,119.43696097943146', 4, 'selesai', '2020-10-25', '2020-10-30', 5, 'sudah', '2020-12-08', 'selesai', 'sudah', 5, 'Coba lagi');

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_detail`
--

DROP TABLE IF EXISTS `data_transaksi_detail`;
CREATE TABLE IF NOT EXISTS `data_transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `no_transaksi` varchar(32) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `jumlah_barang_sewa` int(11) NOT NULL,
  PRIMARY KEY (`id_transaksi_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi_detail`
--

INSERT INTO `data_transaksi_detail` (`id_transaksi_detail`, `id_transaksi`, `no_transaksi`, `id_barang`, `harga_sewa`, `jumlah_barang_sewa`) VALUES
(1, 1, 'TR-20201102174547', 3, 25000, 1),
(2, 2, 'TR-20201102175700', 3, 25000, 1),
(3, 3, 'TR-20201102175942', 3, 25000, 1),
(4, 4, 'TR-20201102180522', 1, 50000, 1),
(5, 4, 'TR-20201102180522', 2, 1000, 1),
(6, 6, 'TR-20201102181932', 3, 25000, 1),
(7, 7, 'TR-20201102181933', 4, 100000, 1),
(8, 8, 'TR-20201102182059', 3, 25000, 1),
(9, 8, 'TR-20201102182059', 4, 100000, 1),
(10, 10, 'TR-20201102183943', 3, 25000, 1),
(11, 10, 'TR-20201102183943', 4, 100000, 1),
(12, 12, 'TR--20201102428184050', 3, 25000, 1),
(13, 13, 'TR--20201102984184050', 4, 100000, 1),
(14, 14, 'TR--20201102947185532', 3, 25000, 1),
(15, 15, 'TR--20201102760185532', 4, 100000, 1),
(16, 16, 'TR--20201117401194117', 5, 10000, 2),
(17, 17, 'TR-20201201982221846', 5, 10000, 1),
(18, 18, 'TR-20201202417004921', 5, 10000, 1),
(19, 19, 'TR-20201202103011553', 5, 10000, 1),
(20, 20, 'TR-20201202817224421', 5, 10000, 2),
(21, 21, 'TR-20201202416233006', 5, 10000, 1),
(22, 22, 'TR-20201202825233557', 5, 10000, 1),
(23, 23, 'TR-20201202016233748', 5, 10000, 1),
(24, 24, 'TR-20201207986223932', 5, 10000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_tambah`
--

DROP TABLE IF EXISTS `data_transaksi_tambah`;
CREATE TABLE IF NOT EXISTS `data_transaksi_tambah` (
  `id_transaksi_tambah` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `no_transaksi` varchar(32) NOT NULL,
  `info_transaksi` enum('ongkir','denda') NOT NULL DEFAULT 'ongkir',
  `harga` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_transaksi_tambah`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi_tambah`
--

INSERT INTO `data_transaksi_tambah` (`id_transaksi_tambah`, `id_transaksi`, `no_transaksi`, `info_transaksi`, `harga`, `keterangan`) VALUES
(1, 1, 'TR-20201102174547', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102174547.'),
(2, 2, 'TR-20201102175700', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102175700.'),
(3, 3, 'TR-20201102175942', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102175942.'),
(4, 4, 'TR-20201102180522', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102180522.'),
(5, 4, 'TR-20201102180522', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102180522.'),
(6, 6, 'TR-20201102181932', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102181932.'),
(7, 7, 'TR-20201102181933', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102181933.'),
(8, 8, 'TR-20201102182059', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102182059.'),
(9, 8, 'TR-20201102182059', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102182059.'),
(10, 10, 'TR-20201102183943', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102183943.'),
(11, 10, 'TR-20201102183943', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201102183943.'),
(12, 12, 'TR--20201102428184050', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR--20201102428184050.'),
(13, 13, 'TR--20201102984184050', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR--20201102984184050.'),
(14, 14, 'TR--20201102947185532', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR--20201102947185532.'),
(15, 15, 'TR--20201102760185532', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR--20201102760185532.'),
(16, 16, 'TR--20201117401194117', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR--20201117401194117.'),
(17, 17, 'TR-20201201982221846', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201201982221846.'),
(18, 18, 'TR-20201202417004921', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201202417004921.'),
(19, 19, 'TR-20201202103011553', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201202103011553.'),
(20, 20, 'TR-20201202817224421', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201202817224421.'),
(21, 21, 'TR-20201202416233006', 'ongkir', 200000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201202416233006.'),
(22, 22, 'TR-20201202825233557', 'ongkir', 20000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201202825233557.'),
(23, 23, 'TR-20201202016233748', 'ongkir', 20000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201202016233748.'),
(24, 24, 'TR-20201207986223932', 'ongkir', 20000, 'Biaya pengantaran untuk transaksi dengan No. TR-20201207986223932.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
