-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2020 at 07:25 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ketam_mp`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
--

CREATE TABLE `data_barang` (
  `id_barang` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_merk` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `denda_hilang` int(11) NOT NULL,
  `denda_lewat` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `tgl_awal_diskon` date NOT NULL,
  `tgl_akhir_diskon` date NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi_barang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`id_barang`, `id_kategori`, `id_toko`, `id_merk`, `nama_barang`, `stok`, `harga_sewa`, `denda_hilang`, `denda_lewat`, `diskon`, `tgl_awal_diskon`, `tgl_akhir_diskon`, `foto`, `deskripsi_barang`) VALUES
(1, 1, 0, 1, 'Tenda (4 Orang)', 1, 50000, 550000, 10000, 0, '0000-00-00', '0000-00-00', '', '<p>Tenda berkapasitas 4 orang...</p>\r\n'),
(2, 2, 2, 2, 'Kerel Rei R-384', 1, 1000, 10000, 1000, 0, '0000-00-00', '0000-00-00', '', '<p>Tas Kerel&nbsp;Rei tipe&nbsp;R-384...</p>\r\n'),
(3, 1, 0, 2, 'Tenda (2 Orang)', 2, 25000, 320000, 3000, 0, '0000-00-00', '0000-00-00', '', '<p>Tenda berkapasitas 2 orang...</p>\r\n'),
(4, 2, 3, 1, 'Kerel Eiger A775', 2, 100000, 250000, 10000, 0, '0000-00-00', '0000-00-00', '', '<p>Kerel Eiger A775...</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `data_barang_foto`
--

CREATE TABLE `data_barang_foto` (
  `id_barang_foto` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_barang_foto`
--

INSERT INTO `data_barang_foto` (`id_barang_foto`, `id_barang`, `foto`) VALUES
(1, 3, 'assets/img/barang/b4661a27c8b70b8827d26d6731761e24981df061.png'),
(2, 3, 'assets/img/barang/c3f0745951c46bfef8f6e5bd7d3cf35091358ee8.jpeg'),
(3, 4, 'assets/img/barang/014f7d7e34de36d393637b13ae9061fdbc4ffa43.png');

-- --------------------------------------------------------

--
-- Table structure for table `data_bintang_toko`
--

CREATE TABLE `data_bintang_toko` (
  `id_ranking_toko` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah_bintang` int(11) NOT NULL,
  `ulasan_toko` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_bukti_pembayaran`
--

CREATE TABLE `data_bukti_pembayaran` (
  `id_bukti_pembayaran` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `foto` varchar(255) NOT NULL,
  `jenis_pembayaran` enum('panjar','lunas') NOT NULL DEFAULT 'panjar',
  `jumlah_pembayaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_kategori`
--

CREATE TABLE `data_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_kategori`
--

INSERT INTO `data_kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Tenda', 'Tenda..'),
(2, 'Tas Kerel', 'Tas Kerel...'),
(3, 'Tas Ransel', 'Tas Ransel...'),
(4, 'Kompor', 'Kompor...'),
(5, 'Matras', 'Matras...');

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_umum`
--

CREATE TABLE `data_konfigurasi_umum` (
  `id_konfigurasi_umum` int(11) NOT NULL,
  `nama_konfigurasi` varchar(100) NOT NULL,
  `nilai_konfigurasi` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `data_merk` (
  `id_merk` int(11) NOT NULL,
  `nama_merk` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `data_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_pengguna`
--

CREATE TABLE `data_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `jenis_akun` enum('admin','toko') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `data_toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(50) NOT NULL,
  `nama_pemilik` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `deskripsi_toko` text NOT NULL,
  `status_akun` enum('aktif','non_aktif','blokir') NOT NULL DEFAULT 'non_aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_toko`
--

INSERT INTO `data_toko` (`id_toko`, `nama_toko`, `nama_pemilik`, `alamat`, `telepon`, `email`, `foto`, `username`, `password`, `deskripsi_toko`, `status_akun`) VALUES
(1, 'Akbar Rent', 'Akbar Mulyadi', 'Jakarta', '081xxxxxxxxx', 'akbar.mulyadi@gmail.com', 'assets/img/toko/394ce2365634370e390f49a1f0fca4276ccaa55c.png', 'akbar', '4f033a0a2bf2fe0b68800a3079545cd1', 'Blablabla', 'blokir'),
(2, 'Seno Rent', 'Suseno', 'Surabaya, Jawa Timur', '0821xxxxxxxx', 'seno.rent@gmail.com', 'assets/img/toko/e87ef67ace1bbd8833c2f66acdcd2753f7e7d508.jpeg', '', '21232f297a57a5a743894a0e4a801fc3', 'Seno Rent...', 'non_aktif'),
(3, 'Reza Outdor Equipment Rent', 'Muhammad Reza Anugrah', 'Gowa, Sulawesi Selatan.', '082195005513', 'rezamuhmmmd@gmail.com', 'assets/img/toko/e87ef67ace1bbd8833c2f66acdcd2753f7e7d508.jpeg', 'reza', 'bb98b1d0b523d5e783f931550d7702b6', 'Reza Outdor Equipment Rent punya nya Muhammad Reza Anugrah dkk...', 'aktif'),
(4, 'Coba 1', 'Coba 1', 'Coba 1', '081xxxxxxxxx', 'coba1@gmail.com', '', 'coba1', 'bf0c95ff56e3b2598456cd455a8684c1', 'Coba 1...', 'non_aktif'),
(5, 'Coba 2', 'Coba 2', 'Coba 2', '081xxxxxxxxx', 'coba2@gmail.com', '', 'coba2', '17146a464726f22dc5ff649fca94761e', 'Coba 2', 'non_aktif'),
(6, 'Coba 3', 'Coba 3', 'Coba 3', '081xxxxxxxxx', 'coba3@gmail.com', '', 'coba3', 'fb1b8e85a800886adeadb7cccf12a524', 'Coba 3...', 'non_aktif');

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi`
--

CREATE TABLE `data_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `no_transaksi` varchar(255) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `longlat` varchar(255) NOT NULL,
  `status_transaksi` enum('tunggu','proses','selesai','batal') NOT NULL DEFAULT 'tunggu',
  `tgl_awal_transaksi` date NOT NULL,
  `tgl_akhir_transaksi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_detail`
--

CREATE TABLE `data_transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `jumlah_barang_sewa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_tambah`
--

CREATE TABLE `data_transaksi_tambah` (
  `id_transaksi_tambah` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `info_transaksi` enum('ongkir','denda') NOT NULL DEFAULT 'ongkir',
  `harga` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `data_barang_foto`
--
ALTER TABLE `data_barang_foto`
  ADD PRIMARY KEY (`id_barang_foto`);

--
-- Indexes for table `data_bintang_toko`
--
ALTER TABLE `data_bintang_toko`
  ADD PRIMARY KEY (`id_ranking_toko`);

--
-- Indexes for table `data_bukti_pembayaran`
--
ALTER TABLE `data_bukti_pembayaran`
  ADD PRIMARY KEY (`id_bukti_pembayaran`);

--
-- Indexes for table `data_kategori`
--
ALTER TABLE `data_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `data_konfigurasi_umum`
--
ALTER TABLE `data_konfigurasi_umum`
  ADD PRIMARY KEY (`id_konfigurasi_umum`);

--
-- Indexes for table `data_merk`
--
ALTER TABLE `data_merk`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indexes for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `data_toko`
--
ALTER TABLE `data_toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- Indexes for table `data_transaksi`
--
ALTER TABLE `data_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `data_transaksi_detail`
--
ALTER TABLE `data_transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`);

--
-- Indexes for table `data_transaksi_tambah`
--
ALTER TABLE `data_transaksi_tambah`
  ADD PRIMARY KEY (`id_transaksi_tambah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_barang_foto`
--
ALTER TABLE `data_barang_foto`
  MODIFY `id_barang_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_bintang_toko`
--
ALTER TABLE `data_bintang_toko`
  MODIFY `id_ranking_toko` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_bukti_pembayaran`
--
ALTER TABLE `data_bukti_pembayaran`
  MODIFY `id_bukti_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_kategori`
--
ALTER TABLE `data_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `data_konfigurasi_umum`
--
ALTER TABLE `data_konfigurasi_umum`
  MODIFY `id_konfigurasi_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_merk`
--
ALTER TABLE `data_merk`
  MODIFY `id_merk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_toko`
--
ALTER TABLE `data_toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_transaksi`
--
ALTER TABLE `data_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_transaksi_detail`
--
ALTER TABLE `data_transaksi_detail`
  MODIFY `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_transaksi_tambah`
--
ALTER TABLE `data_transaksi_tambah`
  MODIFY `id_transaksi_tambah` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
