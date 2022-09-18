-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2022 at 12:20 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_djoyo`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` char(8) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `ktp` char(16) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_hp` bigint(11) DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `tanggal_join` date DEFAULT NULL,
  `status` varchar(5) NOT NULL,
  `id_karyawan` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nama_anggota`, `ktp`, `alamat`, `no_hp`, `divisi_id`, `tanggal_join`, `status`, `id_karyawan`) VALUES
('A0000002', 'ANGGA PRAHMANA', '3216763657800986', 'CIKARANG', 897554531, 9, '2018-10-07', 'Aktif', '21977467'),
('A0000003', 'ARROFI MARETHA RUSIAN', '3216116803960002', 'CIKARANG', 896245508, 13, '2017-12-04', 'Aktif', '20221564'),
('A0000005', 'ADINDA MAULANI', '3212345666789043', 'BEKASI', 812764552, 5, '2021-10-10', 'Aktif', '2021456I'),
('A0000006', 'ROHMAN EFENDI', '3217654390000901', 'LAMONGAN', 865554561, 10, '2018-06-10', 'Aktif', '20198765'),
('A0000007', 'ARI YOGA KRISTIAN', '3678909876543213', 'SEMARANG', 856400487, 2, '2019-02-13', 'Aktif', '20190876'),
('A0000008', 'BASUKI', '3176820988654321', 'PEKALONGAN', 821140061, 2, '2021-01-31', 'Aktif', '20189982'),
('A0000009', 'IMAM FAUZI', '3098675432156789', 'INDRAMAYU', 896074533, 7, '2018-07-27', 'Aktif', '20187543'),
('A0000010', 'ENDAH FITRIANI', '3765432222345678', 'BEKASI', 912345678, 5, '2018-03-05', 'Aktif', '20180987'),
('A0000012', 'LUTHVHI NURL LAYLI', '3121567888876598', 'MALANG', 823339293, 3, '2021-08-01', 'Pasif', '20170669'),
('A0000013', 'SUCINING GIYATI', '3212345678900986', 'CIKARANG', 957434792, 5, '2014-02-12', 'Aktif', '20140009'),
('A0000018', '', '', '', 0, 0, '0000-00-00', 'Pasif', ''),
('A0000019', 'RIZKYANI REMONA', '3273125109790002', 'BANDUNG', 821140061, 11, '2021-08-09', 'Pasif', '20170668');

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `angsuran` int(11) DEFAULT NULL,
  `pinjaman_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jasa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `angsuran`
--

INSERT INTO `angsuran` (`id`, `tanggal`, `nominal`, `angsuran`, `pinjaman_id`, `status`, `user_id`, `jasa`) VALUES
(1, '2021-01-01', 5000, 1, 4, 'Piutang', 100, NULL),
(2, '2021-01-01', 5000, 1, 4, 'Piutang', 100, NULL),
(3, '2021-01-01', 5000, 2, 4, 'Piutang', 100, NULL),
(4, '2021-01-01', 5000, 3, 4, 'Piutang', 100, NULL),
(5, '2021-01-01', 5000, 4, 4, 'Piutang', 100, NULL),
(6, '2021-01-01', 5000, 5, 4, 'Piutang', 100, NULL),
(7, '2021-01-01', 5000, 1, 4, 'Piutang', 100, NULL),
(8, '2021-01-01', 5000, 2, 4, 'Piutang', 100, NULL),
(9, '2021-01-01', 5000, 3, 4, 'Piutang', 100, NULL),
(10, '2022-04-12', 100000, 1, 5, 'Lunas', 1, 2500),
(11, '2022-06-09', 100000, 2, 5, 'Lunas', 1, 2500),
(12, '2022-06-07', 100000, 3, 5, 'Piutang', 100, NULL),
(13, '2022-06-07', 100000, 4, 5, 'Piutang', 100, NULL),
(14, '2022-06-07', 100000, 5, 5, 'Piutang', 100, NULL),
(15, '2022-06-06', 70000, 1, 3, 'Lunas', 100, NULL),
(16, '2022-06-06', 70000, 2, 3, 'Lunas', 100, NULL),
(17, '2022-06-06', 70000, 3, 3, 'Lunas', 100, NULL),
(18, '2022-06-06', 70000, 4, 3, 'Lunas', 100, NULL),
(19, '2022-06-06', 70000, 5, 3, 'Lunas', 100, NULL),
(20, '2021-01-01', 5000, 1, 4, '$status', 100, NULL),
(21, '2021-01-01', 5000, 2, 4, 'Piutang', 100, NULL),
(22, '2021-01-01', 5000, 3, 4, 'Piutang', 100, NULL),
(23, '2021-01-01', 5000, 1, 4, 'Piutang', 100, NULL),
(24, '2021-01-01', 5000, 2, 4, 'Piutang', 100, NULL),
(25, '2021-01-01', 5000, 3, 5, 'Piutang', 100, NULL),
(26, '2022-06-09', 5000, 1, 5, 'Lunas', 1, NULL),
(27, '2021-01-01', 5000, 2, 5, 'Piutang', 100, NULL),
(28, '2021-01-01', 5000, 3, 5, 'Piutang', 100, NULL),
(29, '2022-06-21', 5000, 1, 5, 'Lunas', 1, NULL),
(30, '2022-06-08', 5000, 2, 5, 'Lunas', 1, 2500),
(31, '2021-01-01', 5000, 3, 5, 'Piutang', 100, NULL),
(32, '2022-06-09', 5000, 1, 5, 'Lunas', 1, NULL),
(33, '2021-01-01', 5000, 2, 4, 'Piutang', 100, NULL),
(34, '2021-01-01', 5000, 3, 4, 'Piutang', 100, NULL),
(35, '2021-01-01', 5000, 1, 4, 'Piutang', 100, NULL),
(36, '2021-01-01', 5000, 2, 4, 'Piutang', 100, NULL),
(37, '2021-01-01', 5000, 3, 4, 'Piutang', 100, NULL),
(38, '2022-07-28', 10000, 1, 4, 'Piutang', 100, NULL),
(39, '2022-08-28', 10000, 2, 4, 'Piutang', 100, NULL),
(40, '2022-09-28', 10000, 3, 4, 'Piutang', 100, NULL),
(41, '2022-10-28', 10000, 4, 4, 'Piutang', 100, NULL),
(42, '2022-11-28', 10000, 5, 4, 'Piutang', 100, NULL),
(43, '2021-01-01', 5000, 1, 4, 'Piutang', 100, NULL),
(44, '2021-01-01', 5000, 2, 5, 'Piutang', 100, NULL),
(45, '2021-01-01', 5000, 3, 5, 'Piutang', 100, NULL),
(46, '2022-05-28', 25000, 1, 8, 'Piutang', 100, NULL),
(47, '2022-06-28', 25000, 2, 8, 'Piutang', 100, NULL),
(48, '2022-07-28', 25000, 3, 8, 'Piutang', 100, NULL),
(49, '2022-08-28', 25000, 4, 8, 'Piutang', 100, NULL),
(50, '2022-07-28', 6250, 1, 9, 'Lunas', 1, NULL),
(51, '2022-08-28', 6250, 2, 9, 'Lunas', 1, NULL),
(52, '2022-09-28', 6250, 3, 9, 'Piutang', 100, NULL),
(53, '2022-06-15', 6250, 4, 9, 'Lunas', 1, NULL),
(54, '2022-06-09', 6250, 5, 9, 'Lunas', 1, NULL),
(55, '2022-06-22', 6250, 6, 9, 'Lunas', 1, NULL),
(56, '0000-00-00', 6250, 7, 9, 'Piutang', 100, NULL),
(57, '2022-06-22', 6250, 8, 9, 'Lunas', 1, NULL),
(63, '2022-07-28', 62500, 1, 10, 'Lunas', 1, NULL),
(64, '2022-08-28', 62500, 2, 10, 'Lunas', 1, NULL),
(65, '2022-09-28', 62500, 3, 10, 'Lunas', 1, NULL),
(66, '2022-10-28', 62500, 4, 10, 'Lunas', 1, NULL),
(67, '2022-06-14', 62500, 5, 10, 'Lunas', 1, 2500),
(68, '0000-00-00', 102500, 1, 11, 'Lunas', 1, NULL),
(69, '2022-06-13', 102500, 2, 11, 'Lunas', 1, NULL),
(70, '2022-06-16', 102500, 3, 11, 'Lunas', 1, NULL),
(71, '2022-06-27', 102500, 4, 11, 'Lunas', 1, NULL),
(72, '2022-07-01', 102500, 5, 11, 'Lunas', 1, NULL),
(73, '2022-06-19', 12500, 1, 27, 'Lunas', 1, 2500),
(74, '2022-06-25', 12500, 2, 27, 'Lunas', 1, 2500),
(75, '2022-06-26', 12500, 3, 27, 'Lunas', 1, 2500),
(76, NULL, 12500, 4, 27, 'Piutang', 100, NULL),
(77, NULL, 12500, 5, 27, 'Piutang', 100, NULL),
(78, '2022-06-30', 102500, 1, 32, 'Lunas', 2, 2500),
(79, NULL, 202500, 1, 30, 'Piutang', 100, NULL),
(80, NULL, 85833, 1, 33, 'Piutang', 100, NULL),
(81, NULL, 85833, 2, 33, 'Piutang', 100, NULL),
(82, NULL, 85833, 3, 33, 'Piutang', 100, NULL),
(83, '2022-06-22', 52500, 1, 34, 'Lunas', 1, 2500),
(84, '2022-06-23', 52500, 2, 34, 'Lunas', 1, 2500),
(85, '2022-06-24', 52500, 3, 34, 'Lunas', 1, 2500),
(86, '2022-06-25', 52500, 4, 34, 'Lunas', 1, 2500),
(87, '2022-06-26', 52500, 5, 34, 'Lunas', 1, 2500),
(88, '2022-06-27', 52500, 6, 34, 'Lunas', 1, 2500),
(89, '2022-06-28', 102500, 1, 35, 'Lunas', 1, 2500),
(90, '2022-06-29', 102500, 2, 35, 'Lunas', 1, 2500),
(91, '2022-06-30', 102500, 3, 35, 'Lunas', 1, 2500),
(92, '2022-07-01', 102500, 4, 35, 'Lunas', 1, 2500),
(93, '2022-07-04', 102500, 5, 35, 'Lunas', 1, 2500);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` char(6) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `satuan_id` varchar(15) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `stok_awal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `stok`, `satuan_id`, `harga_beli`, `harga_jual`, `stok_awal`) VALUES
('BR0001', 'Nasi Katering', 20, '1', 9000, 10000, 20),
('BR0002', 'Salad Buah 200 ML', 68, '1', 12000, 15000, 56),
('BR0003', 'Aneka Gorengan', 50, '1', 1000, 1500, 50),
('BR0004', 'Teh Pucuk', 49, '2', 4000, 5000, 50),
('BR0005', 'Krupuk', 50, '1', 700, 1000, 50),
('BR0006', 'Cilok ', 48, '1', 5000, 7000, 48),
('BR0007', 'Kripik Singkong', 10, '1', 4000, 5000, 5),
('BR0008', 'Thai Tea ', 18, '1', 10000, 15000, 20),
('BR0009', 'Teh Botol 100 ML', 40, '1', 35000, 5000, 40),
('BR0010', 'Kopi Kenangan 100 ML', 33, '1', 8000, 10000, 35),
('BR0011', 'Roti Global Cokelat', 0, '1', 3500, 5000, 0),
('BR0012', 'Roti Global Pisang Coklat', 0, '1', 3500, 5000, 0),
('BR0013', 'Roti Global Keju', 0, '1', 3500, 5000, 0),
('BR0014', 'Kripik Seblak', 0, '1', 4000, 5000, 0),
('BR0015', 'Kripik Pisang', 0, '1', 4000, 5000, 0),
('BR0016', 'Makaroni', 30, '1', 4000, 5000, 0),
('BR0017', 'Kripik Molring', 4, '1', 4000, 5000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` char(8) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `ktp` char(16) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_hp` bigint(11) DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `tanggal_join` date DEFAULT NULL,
  `status` varchar(5) NOT NULL,
  `id_karyawan` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `nama_customer`, `ktp`, `alamat`, `no_hp`, `divisi_id`, `tanggal_join`, `status`, `id_karyawan`) VALUES
('C0000002', 'ANGGA PRAHMANA', '3216763657800986', 'CIKARANG', 897554531, 9, '2018-10-07', 'Aktif', '21977467'),
('C0000003', 'ARROFI MARETHA RUSIAN', '3216116803960002', 'CIKARANG', 896245508, 13, '2017-12-04', 'Aktif', '20221564'),
('C0000005', 'ADINDA MAULANI', '3212345666789043', 'BEKASI', 812764552, 5, '2021-10-10', 'Aktif', '2021456I'),
('C0000006', 'ROHMAN EFENDI', '3217654390000901', 'LAMONGAN', 865554561, 10, '2018-06-10', 'Aktif', '20198765'),
('C0000007', 'ARI YOGA KRISTIAN', '3678909876543213', 'SEMARANG', 856400487, 2, '2019-02-13', 'Aktif', '20190876'),
('C0000008', 'BASUKI', '3176820988654321', 'PEKALONGAN', 821140061, 2, '2021-01-31', 'Aktif', '20189982'),
('C0000009', 'IMAM FAUZI', '3098675432156789', 'INDRAMAYU', 896074533, 7, '2018-07-27', 'Aktif', '20187543'),
('C0000010', 'ENDAH FITRIANI', '3765432222345678', 'BEKASI', 912345678, 5, '2018-03-05', 'Aktif', '20180987'),
('C0000012', 'LUTHVHI NURL LAYLI', '3121567888876598', 'MALANG', 823339293, 3, '2021-08-01', 'Pasif', '20170669'),
('C0000013', 'SUCINING GIYATI', '3212345678900986', 'CIKARANG', 957434792, 5, '2014-02-12', 'Aktif', '20140009'),
('C0000015', 'HAPPY RAHAYU', '3543212233345609', 'SEMARANG', 857898612, 13, '2014-06-01', 'Pasif', '20124670'),
('C0000018', '', '', '', 0, 0, '0000-00-00', 'Pasif', ''),
('C0000019', 'RIZKYANI REMONA', '3273125109790002', 'BANDUNG', 821140061, 11, '2021-08-09', 'Pasif', '20170668');

-- --------------------------------------------------------

--
-- Table structure for table `detail_beli`
--

CREATE TABLE `detail_beli` (
  `id` int(11) NOT NULL,
  `kode_barang` char(6) DEFAULT NULL,
  `pembelian_id` int(11) DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_beli`
--

INSERT INTO `detail_beli` (`id`, `kode_barang`, `pembelian_id`, `kuantitas`) VALUES
(56, 'BR0017', 1, 10),
(57, 'BR0007', 2, 15),
(58, 'BR0006', 3, 5),
(59, 'BR0002', 4, 12),
(60, 'BR0016', 4, 30);

-- --------------------------------------------------------

--
-- Table structure for table `detail_jual`
--

CREATE TABLE `detail_jual` (
  `id` int(11) NOT NULL,
  `kode_barang` char(6) DEFAULT NULL,
  `penjualan_id` int(11) DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_jual`
--

INSERT INTO `detail_jual` (`id`, `kode_barang`, `penjualan_id`, `kuantitas`) VALUES
(59, 'BR0010', 1, 2),
(60, 'BR0017', 2, 2),
(61, 'BR0017', 3, 2),
(62, 'BR0008', 3, 2),
(63, 'BR0007', 4, 10),
(64, 'BR0006', 5, 5),
(65, 'BR0017', 6, 2),
(66, 'BR0004', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `divisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `divisi`) VALUES
(1, 'IT'),
(2, 'PROJECT'),
(3, 'MARKETING'),
(4, 'LEGAL'),
(5, 'FAT'),
(6, 'HRD'),
(7, 'PRODUKSI'),
(8, 'GA'),
(9, 'AR'),
(10, 'LELANG'),
(11, 'R&D'),
(13, 'PURLOG');

-- --------------------------------------------------------

--
-- Table structure for table `global_param`
--

CREATE TABLE `global_param` (
  `id` int(11) NOT NULL,
  `nominal` int(11) DEFAULT NULL,
  `nama_param` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `global_param`
--

INSERT INTO `global_param` (`id`, `nominal`, `nama_param`) VALUES
(1, 55000, 'Simpanan Pokok'),
(2, 3000, 'Jasa');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_usaha`
--

CREATE TABLE `hasil_usaha` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_reff` varchar(50) DEFAULT NULL,
  `debet` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hasil_usaha`
--

INSERT INTO `hasil_usaha` (`id`, `tanggal`, `kode_reff`, `debet`, `kredit`, `keterangan`) VALUES
(29, '2022-06-15', 'PJ20220615-013', 4000, 0, 'Laba Penjualan dari SUCINING GIYATI'),
(30, '2022-02-16', 'PM20220216-7', 0, 0, 'Biaya Pembelian Barang'),
(31, '2022-06-01', 'PJ20220601-011', 2000, 0, 'Laba Penjualan dari BUDI SETIAWAN'),
(32, '2022-03-01', 'PJ20220301-012', 12000, 0, 'Laba Penjualan dari LUTHVHI NURL LAYLI'),
(33, '2022-06-22', 'PM20220622-7', 0, 0, 'Biaya Pembelian Barang'),
(34, '2022-06-23', 'PJ20220623-008', 10000, 0, 'Laba Penjualan dari BASUKI'),
(35, '2022-06-22', 'PM20220622-2', 0, 15000, 'Biaya Pembelian Barang'),
(36, '2022-06-22', 'PJ20220622-007', 10000, 0, 'Laba Penjualan dari ARI YOGA KRISTIAN'),
(37, '2022-06-22', 'PN202206-004', 2500, 0, 'Jasa Angsuran Ke - 1 JIHAN PARAMELA'),
(39, '2022-06-23', 'PN202206-004', 2500, 0, 'Jasa Angsuran Ke - 2 HAPPY RAHAYU'),
(40, '2022-06-24', 'PN202206-004', 2500, 0, 'Jasa Angsuran Ke - 3 HAPPY RAHAYU'),
(41, '2022-06-25', 'PN202206-004', 2500, 0, 'Jasa Angsuran Ke - 4 HAPPY RAHAYU'),
(42, '2022-06-26', 'PN202206-004', 2500, 0, 'Jasa Angsuran Ke - 5 HAPPY RAHAYU'),
(43, '2022-06-27', 'PN202206-004', 2500, 0, 'Jasa Angsuran Ke - 6 HAPPY RAHAYU'),
(44, '2022-06-26', 'PM20220626-4', 0, 10000, 'Biaya Pembelian Barang'),
(45, '2022-06-26', 'PJ20220626-002', 3000, 0, 'Laba Penjualan dari ANGGA PRAHMANA'),
(46, '2022-06-28', 'PN202206-002', 2500, 0, 'Jasa Angsuran Ke - 1 ANGGA PRAHMANA'),
(47, '2022-06-29', 'PN202206-002', 2500, 0, 'Jasa Angsuran Ke - 2 ANGGA PRAHMANA'),
(48, '2022-06-30', 'PN202206-002', 2500, 0, 'Jasa Angsuran Ke - 3 ANGGA PRAHMANA'),
(49, '2022-07-01', 'PN202206-002', 2500, 0, 'Jasa Angsuran Ke - 4 ANGGA PRAHMANA'),
(50, '2022-07-04', 'PN202206-002', 2500, 0, 'Jasa Angsuran Ke - 5 ANGGA PRAHMANA');

-- --------------------------------------------------------

--
-- Table structure for table `idanggota`
--

CREATE TABLE `idanggota` (
  `idAnggota` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `idanggota`
--

INSERT INTO `idanggota` (`idAnggota`) VALUES
('A0000019');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` char(8) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `ktp` char(16) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_hp` int(20) DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `tanggal_join` date DEFAULT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama_karyawan`, `ktp`, `alamat`, `no_hp`, `divisi_id`, `tanggal_join`, `status`) VALUES
('20111297', 'ISMAIL SALEH', '3124567891119876', 'JOGJA', 813788923, 2, '2022-01-01', 'Pasif'),
('20124670', 'HAPPY RAHAYU', '3543212233345609', 'SEMARANG', 857898612, 13, '2014-06-01', ''),
('20140009', 'SUCINING GIYATI', '3212345678900986', 'CIKARANG', 957434792, 5, '2014-02-12', ''),
('20170668', 'RIZKYANI REMONA', '3273125109790002', 'BANDUNG', 821140061, 11, '2021-08-09', 'Aktif'),
('20170669', 'LUTHVHI NURL LAYLI', '3121567888876598', 'MALANG', 823339293, 3, '2021-08-01', 'Aktif'),
('20175642', 'BUDI SETIAWAN', '3172022507700007', 'BEKASI', 812134059, 11, '2021-04-01', ''),
('20180987', 'ENDAH FITRIANI', '3765432222345678', 'BEKASI', 912345678, 5, '2018-03-05', ''),
('20187543', 'IMAM FAUZI', '3098675432156789', 'INDRAMAYU', 896074533, 7, '2018-07-27', 'Aktif'),
('20189982', 'BASUKI', '3176820988654321', 'PEKALONGAN', 821140061, 2, '2021-01-31', ''),
('20190876', 'ARI YOGA KRISTIAN', '3678909876543213', 'SEMARANG', 856400487, 2, '2019-02-13', 'Aktif'),
('20198765', 'ROHMAN EFENDI', '3217654390000901', 'LAMONGAN', 865554561, 10, '2018-06-10', ''),
('2021456I', 'ADINDA MAULANI', '3212345666789043', 'BEKASI', 812764552, 5, '2021-10-10', ''),
('20220879', 'JIHAN PARAMELA', '3272066101000001', 'SUKABUMI', 987565662, 5, '2021-01-18', ''),
('20221564', 'ARROFI MARETHA RUSIAN', '3216116803960002', 'CIKARANG', 896245508, 13, '2017-12-04', ''),
('21977467', 'ANGGA PRAHMANA', '3216763657800986', 'CIKARANG', 897554531, 9, '2018-10-07', '');

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kas_masuk` int(11) DEFAULT 0,
  `kas_keluar` int(11) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `kode_reff` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`id`, `tanggal`, `kas_masuk`, `kas_keluar`, `keterangan`, `kode_reff`) VALUES
(530, '2022-01-28', 550000, NULL, 'Simpanan Pokok', 'SM202201'),
(531, '2022-01-28', 25000, NULL, 'Simpanan Sukarela ANGGA PRAHMANA', 'SM202201'),
(532, '2022-01-28', 35000, NULL, 'Simpanan Sukarela ARROFI MARETHA RUSIAN', 'SM202201'),
(533, '2022-01-28', 150000, NULL, 'Simpanan Sukarela JIHAN PARAMELA', 'SM202201'),
(534, '2022-01-28', 125000, NULL, 'Simpanan Sukarela BASUKI', 'SM202201'),
(535, '2022-02-28', 550000, NULL, 'Simpanan Pokok', 'SM202202'),
(542, '2022-06-15', 20000, NULL, 'Penjualan kepada SUCINING GIYATI', 'PJ20220615-013'),
(543, '2022-02-16', 0, 40000, 'Pembelian Barang', 'PM20220216-7'),
(544, '2022-06-01', 10000, NULL, 'Penjualan kepada BUDI SETIAWAN', 'PJ20220601-011'),
(545, '2022-02-25', 0, 15000, 'Penarikan Simpanan Sukarela ARROFI MARETHA RUSIAN', 'TR202202'),
(546, '2022-03-01', 40000, NULL, 'Penjualan kepada LUTHVHI NURL LAYLI', 'PJ20220301-012'),
(547, '2022-02-28', 25000, NULL, 'Simpanan Sukarela ANGGA PRAHMANA', 'SM202202'),
(548, '2022-01-28', 10000, NULL, 'Simpanan Sukarela IMAM FAUZI', 'SM202201'),
(549, '2022-03-28', 550000, NULL, 'Simpanan Pokok', 'SM202203'),
(550, '2022-03-28', 35000, NULL, 'Simpanan Sukarela ENDAH FITRIANI', 'SM202203'),
(551, '2022-06-22', 0, 60000, 'Pembelian Barang', 'PM20220622-7'),
(552, '2022-06-23', 50000, NULL, 'Penjualan kepada BASUKI', 'PJ20220623-008'),
(553, '2022-06-22', 0, 40000, 'Pembelian Barang', 'PM20220622-2'),
(554, '2022-06-22', 35000, NULL, 'Penjualan kepada ARI YOGA KRISTIAN', 'PJ20220622-007'),
(555, '2022-06-22', 0, 300000, 'Pinjaman JIHAN PARAMELA', 'PN202206-004'),
(556, '2022-06-22', 52500, NULL, 'Angsuran Ke - 1 JIHAN PARAMELA', 'PN202206-004'),
(558, '2022-06-22', 0, 150000, 'Pencairan Simpanan Pokok A0000011', 'CSP20220622'),
(559, '2022-06-22', 0, 150000, 'Pencairan Simpanan Pokok A0000011', 'CSP20220622'),
(560, '2022-06-22', 0, 150000, 'Penarikan Simpanan Sukarela JIHAN PARAMELA', 'TR202206'),
(561, '2022-06-22', 0, 150000, 'Pencairan Simpanan Pokok A0000004', 'CSP20220622'),
(562, '2022-06-22', 0, 150000, 'Pencairan Simpanan Pokok A0000004', 'CSP20220622'),
(563, '2022-06-23', 52500, NULL, 'Angsuran Ke - 2 HAPPY RAHAYU', 'PN202206-004'),
(564, '2022-06-24', 52500, NULL, 'Angsuran Ke - 3 HAPPY RAHAYU', 'PN202206-004'),
(565, '2022-06-25', 52500, NULL, 'Angsuran Ke - 4 HAPPY RAHAYU', 'PN202206-004'),
(566, '2022-06-26', 52500, NULL, 'Angsuran Ke - 5 HAPPY RAHAYU', 'PN202206-004'),
(567, '2022-06-27', 52500, NULL, 'Angsuran Ke - 6 HAPPY RAHAYU', 'PN202206-004'),
(568, '2022-04-28', 495000, NULL, 'Simpanan Pokok', 'SM202204'),
(569, '2022-06-26', 0, 274000, 'Pembelian Barang', 'PM20220626-4'),
(570, '2022-06-26', 15000, NULL, 'Penjualan kepada ANGGA PRAHMANA', 'PJ20220626-002'),
(571, '2022-05-28', 495000, NULL, 'Simpanan Pokok', 'SM202205'),
(572, '2022-05-28', 75000, NULL, 'Simpanan Sukarela ANGGA PRAHMANA', 'SM202205'),
(573, '2022-06-02', 0, 100000, 'Penarikan Simpanan Sukarela ANGGA PRAHMANA', 'TR202206'),
(574, '2022-06-16', 0, 500000, 'Pinjaman ANGGA PRAHMANA', 'PN202206-002'),
(575, '2022-06-28', 102500, NULL, 'Angsuran Ke - 1 ANGGA PRAHMANA', 'PN202206-002'),
(576, '2022-06-29', 102500, NULL, 'Angsuran Ke - 2 ANGGA PRAHMANA', 'PN202206-002'),
(577, '2022-06-30', 102500, NULL, 'Angsuran Ke - 3 ANGGA PRAHMANA', 'PN202206-002'),
(578, '2022-07-01', 102500, NULL, 'Angsuran Ke - 4 ANGGA PRAHMANA', 'PN202206-002'),
(579, '2022-07-04', 102500, NULL, 'Angsuran Ke - 5 ANGGA PRAHMANA', 'PN202206-002');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kode_beli` char(14) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `biaya` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `supplier_id`, `user_id`, `kode_beli`, `tanggal`, `total`, `keterangan`, `status`, `biaya`) VALUES
(1, 7, 1, 'PM20220216-7', '2022-02-16', 40000, 'ok', 'Selesai', 0),
(2, 7, 1, 'PM20220622-7', '2022-06-22', 60000, 'ok', 'Selesai', 0),
(3, 2, 1, 'PM20220622-2', '2022-06-22', 25000, 'ok', 'Selesai', 15000),
(4, 4, 2, 'PM20220626-4', '2022-06-26', 264000, 'Acc', 'Selesai', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `penarikan`
--

CREATE TABLE `penarikan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` float DEFAULT NULL,
  `simpanan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penarikan`
--

INSERT INTO `penarikan` (`id`, `tanggal`, `nominal`, `simpanan_id`) VALUES
(1159, '2022-01-28', 0, 1),
(1160, '2022-01-28', 0, 2),
(1162, '2022-01-28', 0, 4),
(1163, '2022-01-28', 0, 5),
(1164, '2022-01-28', 0, 6),
(1165, '2022-01-28', 0, 7),
(1166, '2022-01-28', 0, 8),
(1167, '2022-01-28', 0, 9),
(1169, '2022-01-28', 0, 11),
(1170, '2022-02-28', 0, 12),
(1171, '2022-02-28', 0, 13),
(1173, '2022-02-28', 0, 15),
(1174, '2022-02-28', 0, 16),
(1175, '2022-02-28', 0, 17),
(1176, '2022-02-28', 0, 18),
(1177, '2022-02-28', 0, 19),
(1178, '2022-02-28', 0, 20),
(1180, '2022-02-28', 0, 22),
(1181, '2022-02-25', 15000, 23),
(1182, '2022-03-28', 0, 24),
(1183, '2022-03-28', 0, 25),
(1185, '2022-03-28', 0, 27),
(1186, '2022-03-28', 0, 28),
(1187, '2022-03-28', 0, 29),
(1188, '2022-03-28', 0, 30),
(1189, '2022-03-28', 0, 31),
(1190, '2022-03-28', 0, 32),
(1192, '2022-03-28', 0, 34),
(1194, '2022-04-28', 0, 35),
(1195, '2022-04-28', 0, 36),
(1196, '2022-04-28', 0, 37),
(1197, '2022-04-28', 0, 38),
(1198, '2022-04-28', 0, 39),
(1199, '2022-04-28', 0, 40),
(1200, '2022-04-28', 0, 41),
(1201, '2022-04-28', 0, 42),
(1202, '2022-04-28', 0, 43),
(1203, '2022-05-28', 0, 44),
(1204, '2022-05-28', 0, 45),
(1205, '2022-05-28', 0, 46),
(1206, '2022-05-28', 0, 47),
(1207, '2022-05-28', 0, 48),
(1208, '2022-05-28', 0, 49),
(1209, '2022-05-28', 0, 50),
(1210, '2022-05-28', 0, 51),
(1211, '2022-05-28', 0, 52),
(1212, '2022-06-02', 100000, 53);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_tarik_saldo`
--

CREATE TABLE `pengajuan_tarik_saldo` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` float DEFAULT NULL,
  `anggota_id` char(8) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tgl_cair` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengajuan_tarik_saldo`
--

INSERT INTO `pengajuan_tarik_saldo` (`id`, `tanggal`, `nominal`, `anggota_id`, `status`, `keterangan`, `tgl_cair`) VALUES
(809, '2022-02-25', 15000, 'A0000003', 'Selesai', 'ok', '2022-02-25'),
(810, '2022-06-22', 150000, 'A0000004', 'Selesai', 'ok', '2022-06-22'),
(811, '2022-06-02', 100000, 'A0000002', 'Selesai', 'ok', '2022-06-02');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `customer_id` char(8) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kode_jual` char(14) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `laba` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `customer_id`, `user_id`, `kode_jual`, `tanggal`, `total`, `keterangan`, `laba`) VALUES
(1, 'C0000013', 1, 'PJ20220615-013', '2022-06-15', 20000, 'Dibeli oleh SUCINING GIYATI', 4000),
(2, 'C0000011', 1, 'PJ20220601-011', '2022-06-01', 10000, 'Dibeli oleh BUDI SETIAWAN', 2000),
(3, 'C0000012', 1, 'PJ20220301-012', '2022-03-01', 40000, 'Dibeli oleh LUTHVHI NURL LAYLI', 12000),
(4, 'C0000008', 1, 'PJ20220623-008', '2022-06-23', 50000, 'Dibeli oleh BASUKI', 10000),
(5, 'C0000007', 1, 'PJ20220622-007', '2022-06-22', 35000, 'Dibeli oleh ARI YOGA KRISTIAN', 10000),
(6, 'C0000002', 1, 'PJ20220626-002', '2022-06-26', 15000, 'Dibeli oleh ANGGA PRAHMANA', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` int(11) NOT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `tanggal_pencairan` date DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tenor` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `anggota_id` char(8) DEFAULT NULL,
  `kode_pinjam` char(12) DEFAULT NULL,
  `nominal_acc` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `acc_by` int(11) DEFAULT NULL,
  `nominal_bayar` int(11) DEFAULT NULL,
  `dokumen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `tanggal_pengajuan`, `tanggal_pencairan`, `nominal`, `tenor`, `status`, `user_id`, `anggota_id`, `kode_pinjam`, `nominal_acc`, `keterangan`, `acc_by`, `nominal_bayar`, `dokumen`) VALUES
(34, '2022-06-21', '2022-06-22', 300000, 6, 'Selesai', 1, NULL, 'PN202206-004', 300000, 'acc', 1, 300000, '6326f093ad981.pdf'),
(35, '2022-06-15', '2022-06-16', 500000, 5, 'Selesai', 1, 'A0000002', 'PN202206-002', 500000, 'Acc', 1, 500000, '6326f093ad981.pdf'),
(42, '2022-09-14', NULL, 3423423, 234, 'Pengajuan', 2, 'A0000013', 'PN202209-013', NULL, NULL, NULL, 0, '6326f093ad981.pdf'),
(44, '2022-09-15', NULL, 5000000, 5, 'Draft', 2, 'A0000002', 'PN202209-002', NULL, NULL, NULL, 0, '6326f093ad981.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `saldo` int(11) DEFAULT 0,
  `simpanan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id`, `tanggal`, `saldo`, `simpanan_id`) VALUES
(1119, '2022-01-28', 50000, 1),
(1120, '2022-01-28', 50000, 2),
(1121, '2022-01-28', 0, NULL),
(1122, '2022-01-28', 50000, 4),
(1123, '2022-01-28', 50000, 5),
(1124, '2022-01-28', 50000, 6),
(1125, '2022-01-28', 50000, 7),
(1126, '2022-01-28', 50000, 8),
(1127, '2022-01-28', 50000, 9),
(1128, '2022-01-28', 0, NULL),
(1129, '2022-01-28', 50000, 11),
(1130, '2022-01-28', 25000, 1),
(1131, '2022-01-28', 35000, 2),
(1132, '2022-01-28', 0, NULL),
(1133, '2022-01-28', 125000, 7),
(1134, '2022-02-28', 50000, 12),
(1135, '2022-02-28', 50000, 13),
(1136, '2022-02-28', 0, NULL),
(1137, '2022-02-28', 50000, 15),
(1138, '2022-02-28', 50000, 16),
(1139, '2022-02-28', 50000, 17),
(1140, '2022-02-28', 50000, 18),
(1141, '2022-02-28', 50000, 19),
(1142, '2022-02-28', 50000, 20),
(1143, '2022-02-28', 0, NULL),
(1144, '2022-02-28', 50000, 22),
(1145, '2022-02-25', 15000, 23),
(1146, '2022-02-28', 25000, 12),
(1147, '2022-01-28', 10000, 8),
(1148, '2022-03-28', 50000, 24),
(1149, '2022-03-28', 50000, 25),
(1150, '2022-03-28', 0, NULL),
(1151, '2022-03-28', 50000, 27),
(1152, '2022-03-28', 50000, 28),
(1153, '2022-03-28', 50000, 29),
(1154, '2022-03-28', 50000, 30),
(1155, '2022-03-28', 50000, 31),
(1156, '2022-03-28', 50000, 32),
(1157, '2022-03-28', 0, NULL),
(1158, '2022-03-28', 50000, 34),
(1159, '2022-03-28', 35000, 32),
(1160, '2022-06-22', 0, NULL),
(1161, '2022-04-28', 55000, 35),
(1162, '2022-04-28', 55000, 36),
(1163, '2022-04-28', 55000, 37),
(1164, '2022-04-28', 55000, 38),
(1165, '2022-04-28', 55000, 39),
(1166, '2022-04-28', 55000, 40),
(1167, '2022-04-28', 55000, 41),
(1168, '2022-04-28', 55000, 42),
(1169, '2022-04-28', 55000, 43),
(1170, '2022-05-28', 55000, 44),
(1171, '2022-05-28', 55000, 45),
(1172, '2022-05-28', 55000, 46),
(1173, '2022-05-28', 55000, 47),
(1174, '2022-05-28', 55000, 48),
(1175, '2022-05-28', 55000, 49),
(1176, '2022-05-28', 55000, 50),
(1177, '2022-05-28', 55000, 51),
(1178, '2022-05-28', 55000, 52),
(1179, '2022-05-28', 75000, 44),
(1180, '2022-06-02', 100000, 53);

-- --------------------------------------------------------

--
-- Table structure for table `saldo_daily`
--

CREATE TABLE `saldo_daily` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `saldo` int(11) DEFAULT 0,
  `anggota_id` char(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saldo_daily`
--

INSERT INTO `saldo_daily` (`id`, `tanggal`, `saldo`, `anggota_id`) VALUES
(1168, '2018-10-07', 0, 'A0000002'),
(1169, '2017-12-04', 0, 'A0000003'),
(1171, '2021-10-10', 0, 'A0000005'),
(1172, '2018-06-10', 0, 'A0000006'),
(1173, '2019-02-13', 0, 'A0000007'),
(1174, '2021-01-31', 0, 'A0000008'),
(1175, '2018-07-27', 0, 'A0000009'),
(1176, '2018-03-05', 0, 'A0000010'),
(1178, '2021-08-01', 0, 'A0000012'),
(1179, '2014-02-12', 0, 'A0000013'),
(1183, '2022-01-28', 50000, 'A0000005'),
(1184, '2022-01-28', 50000, 'A0000006'),
(1185, '2022-01-28', 50000, 'A0000007'),
(1188, '2022-01-28', 50000, 'A0000010'),
(1190, '2022-01-28', 50000, 'A0000013'),
(1191, '2022-01-28', 75000, 'A0000002'),
(1192, '2022-01-28', 85000, 'A0000003'),
(1194, '2022-01-28', 175000, 'A0000008'),
(1196, '2022-02-28', 120000, 'A0000003'),
(1198, '2022-02-28', 100000, 'A0000005'),
(1199, '2022-02-28', 100000, 'A0000006'),
(1200, '2022-02-28', 100000, 'A0000007'),
(1201, '2022-02-28', 225000, 'A0000008'),
(1202, '2022-02-28', 110000, 'A0000009'),
(1203, '2022-02-28', 100000, 'A0000010'),
(1205, '2022-02-28', 100000, 'A0000013'),
(1207, '2014-06-01', 0, 'A0000015'),
(1208, '2022-02-25', 70000, 'A0000003'),
(1209, '2022-02-28', 150000, 'A0000002'),
(1210, '2022-01-28', 60000, 'A0000009'),
(1211, '2022-03-28', 200000, 'A0000002'),
(1212, '2022-03-28', 170000, 'A0000003'),
(1214, '2022-03-28', 150000, 'A0000005'),
(1215, '2022-03-28', 150000, 'A0000006'),
(1216, '2022-03-28', 150000, 'A0000007'),
(1217, '2022-03-28', 275000, 'A0000008'),
(1218, '2022-03-28', 160000, 'A0000009'),
(1221, '2022-03-28', 150000, 'A0000013'),
(1222, '2022-03-28', 185000, 'A0000010'),
(1225, '2022-04-28', 255000, 'A0000002'),
(1226, '2022-04-28', 225000, 'A0000003'),
(1227, '2022-04-28', 205000, 'A0000005'),
(1228, '2022-04-28', 205000, 'A0000006'),
(1229, '2022-04-28', 205000, 'A0000007'),
(1230, '2022-04-28', 330000, 'A0000008'),
(1231, '2022-04-28', 215000, 'A0000009'),
(1232, '2022-04-28', 240000, 'A0000010'),
(1233, '2022-04-28', 205000, 'A0000013'),
(1236, '2022-05-28', 280000, 'A0000003'),
(1237, '2022-05-28', 260000, 'A0000005'),
(1238, '2022-05-28', 260000, 'A0000006'),
(1239, '2022-05-28', 260000, 'A0000007'),
(1240, '2022-05-28', 385000, 'A0000008'),
(1241, '2022-05-28', 270000, 'A0000009'),
(1242, '2022-05-28', 295000, 'A0000010'),
(1243, '2022-05-28', 260000, 'A0000013'),
(1244, '2022-05-28', 385000, 'A0000002'),
(1245, '2022-06-02', 285000, 'A0000002'),
(1246, '0000-00-00', 0, 'A0000018'),
(1247, '2021-08-09', 0, 'A0000019');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama_satuan`) VALUES
(1, 'Pcs'),
(2, 'Kg'),
(3, 'Liter'),
(5, '\'.$get_id[\'id\'].\''),
(6, '1'),
(7, '5'),
(8, '6');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `id` int(11) NOT NULL,
  `anggota_id` char(8) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kode_simpanan` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id`, `anggota_id`, `user_id`, `kode_simpanan`) VALUES
(1, 'A0000002', 1, 'SM202201'),
(2, 'A0000003', 1, 'SM202201'),
(4, 'A0000005', 1, 'SM202201'),
(5, 'A0000006', 1, 'SM202201'),
(6, 'A0000007', 1, 'SM202201'),
(7, 'A0000008', 1, 'SM202201'),
(8, 'A0000009', 1, 'SM202201'),
(9, 'A0000010', 1, 'SM202201'),
(11, 'A0000013', 1, 'SM202201'),
(12, 'A0000002', 1, 'SM202202'),
(13, 'A0000003', 1, 'SM202202'),
(15, 'A0000005', 1, 'SM202202'),
(16, 'A0000006', 1, 'SM202202'),
(17, 'A0000007', 1, 'SM202202'),
(18, 'A0000008', 1, 'SM202202'),
(19, 'A0000009', 1, 'SM202202'),
(20, 'A0000010', 1, 'SM202202'),
(22, 'A0000013', 1, 'SM202202'),
(23, 'A0000003', 1, 'TR202202'),
(24, 'A0000002', 1, 'SM202203'),
(25, 'A0000003', 1, 'SM202203'),
(27, 'A0000005', 1, 'SM202203'),
(28, 'A0000006', 1, 'SM202203'),
(29, 'A0000007', 1, 'SM202203'),
(30, 'A0000008', 1, 'SM202203'),
(31, 'A0000009', 1, 'SM202203'),
(32, 'A0000010', 1, 'SM202203'),
(34, 'A0000013', 1, 'SM202203'),
(35, 'A0000002', 1, 'SM202204'),
(36, 'A0000003', 1, 'SM202204'),
(37, 'A0000005', 1, 'SM202204'),
(38, 'A0000006', 1, 'SM202204'),
(39, 'A0000007', 1, 'SM202204'),
(40, 'A0000008', 1, 'SM202204'),
(41, 'A0000009', 1, 'SM202204'),
(42, 'A0000010', 1, 'SM202204'),
(43, 'A0000013', 1, 'SM202204'),
(44, 'A0000002', 1, 'SM202205'),
(45, 'A0000003', 1, 'SM202205'),
(46, 'A0000005', 1, 'SM202205'),
(47, 'A0000006', 1, 'SM202205'),
(48, 'A0000007', 1, 'SM202205'),
(49, 'A0000008', 1, 'SM202205'),
(50, 'A0000009', 1, 'SM202205'),
(51, 'A0000010', 1, 'SM202205'),
(52, 'A0000013', 1, 'SM202205'),
(53, 'A0000002', 1, 'TR202206');

-- --------------------------------------------------------

--
-- Table structure for table `sim_pokok`
--

CREATE TABLE `sim_pokok` (
  `id` int(11) NOT NULL,
  `tanggal_simpanan` date NOT NULL,
  `nominal_simpanan` float DEFAULT NULL,
  `simpanan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sim_pokok`
--

INSERT INTO `sim_pokok` (`id`, `tanggal_simpanan`, `nominal_simpanan`, `simpanan_id`) VALUES
(1164, '2022-01-28', 50000, 1),
(1165, '2022-01-28', 50000, 2),
(1167, '2022-01-28', 50000, 4),
(1168, '2022-01-28', 50000, 5),
(1169, '2022-01-28', 50000, 6),
(1170, '2022-01-28', 50000, 7),
(1171, '2022-01-28', 50000, 8),
(1172, '2022-01-28', 50000, 9),
(1174, '2022-01-28', 50000, 11),
(1175, '2022-02-28', 50000, 12),
(1176, '2022-02-28', 50000, 13),
(1178, '2022-02-28', 50000, 15),
(1179, '2022-02-28', 50000, 16),
(1180, '2022-02-28', 50000, 17),
(1181, '2022-02-28', 50000, 18),
(1182, '2022-02-28', 50000, 19),
(1183, '2022-02-28', 50000, 20),
(1185, '2022-02-28', 50000, 22),
(1186, '2022-02-25', 0, 23),
(1187, '2022-03-28', 50000, 24),
(1188, '2022-03-28', 50000, 25),
(1190, '2022-03-28', 50000, 27),
(1191, '2022-03-28', 50000, 28),
(1192, '2022-03-28', 50000, 29),
(1193, '2022-03-28', 50000, 30),
(1194, '2022-03-28', 50000, 31),
(1195, '2022-03-28', 50000, 32),
(1197, '2022-03-28', 50000, 34),
(1199, '2022-04-28', 55000, 35),
(1200, '2022-04-28', 55000, 36),
(1201, '2022-04-28', 55000, 37),
(1202, '2022-04-28', 55000, 38),
(1203, '2022-04-28', 55000, 39),
(1204, '2022-04-28', 55000, 40),
(1205, '2022-04-28', 55000, 41),
(1206, '2022-04-28', 55000, 42),
(1207, '2022-04-28', 55000, 43),
(1208, '2022-05-28', 55000, 44),
(1209, '2022-05-28', 55000, 45),
(1210, '2022-05-28', 55000, 46),
(1211, '2022-05-28', 55000, 47),
(1212, '2022-05-28', 55000, 48),
(1213, '2022-05-28', 55000, 49),
(1214, '2022-05-28', 55000, 50),
(1215, '2022-05-28', 55000, 51),
(1216, '2022-05-28', 55000, 52),
(1217, '2022-06-02', 0, 53);

-- --------------------------------------------------------

--
-- Table structure for table `sim_sukarela`
--

CREATE TABLE `sim_sukarela` (
  `id` int(11) NOT NULL,
  `tanggal_simpanan` date NOT NULL,
  `nominal_simpanan` float DEFAULT NULL,
  `simpanan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sim_sukarela`
--

INSERT INTO `sim_sukarela` (`id`, `tanggal_simpanan`, `nominal_simpanan`, `simpanan_id`) VALUES
(1160, '2022-01-28', 25000, 1),
(1161, '2022-01-28', 35000, 2),
(1163, '2022-01-28', 0, 4),
(1164, '2022-01-28', 0, 5),
(1165, '2022-01-28', 0, 6),
(1166, '2022-01-28', 125000, 7),
(1167, '2022-01-28', 10000, 8),
(1168, '2022-01-28', 0, 9),
(1170, '2022-01-28', 0, 11),
(1171, '2022-02-28', 25000, 12),
(1172, '2022-02-28', 0, 13),
(1174, '2022-02-28', 0, 15),
(1175, '2022-02-28', 0, 16),
(1176, '2022-02-28', 0, 17),
(1177, '2022-02-28', 0, 18),
(1178, '2022-02-28', 0, 19),
(1179, '2022-02-28', 0, 20),
(1181, '2022-02-28', 0, 22),
(1182, '2022-02-25', 0, 23),
(1183, '2022-03-28', 0, 24),
(1184, '2022-03-28', 0, 25),
(1186, '2022-03-28', 0, 27),
(1187, '2022-03-28', 0, 28),
(1188, '2022-03-28', 0, 29),
(1189, '2022-03-28', 0, 30),
(1190, '2022-03-28', 0, 31),
(1191, '2022-03-28', 35000, 32),
(1193, '2022-03-28', 0, 34),
(1195, '2022-04-28', 0, 35),
(1196, '2022-04-28', 0, 36),
(1197, '2022-04-28', 0, 37),
(1198, '2022-04-28', 0, 38),
(1199, '2022-04-28', 0, 39),
(1200, '2022-04-28', 0, 40),
(1201, '2022-04-28', 0, 41),
(1202, '2022-04-28', 0, 42),
(1203, '2022-04-28', 0, 43),
(1204, '2022-05-28', 75000, 44),
(1205, '2022-05-28', 0, 45),
(1206, '2022-05-28', 0, 46),
(1207, '2022-05-28', 0, 47),
(1208, '2022-05-28', 0, 48),
(1209, '2022-05-28', 0, 49),
(1210, '2022-05-28', 0, 50),
(1211, '2022-05-28', 0, 51),
(1212, '2022-05-28', 0, 52),
(1213, '2022-06-02', 0, 53);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama_supp` varchar(50) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_telepon` bigint(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supp`, `alamat`, `no_telepon`, `email`) VALUES
(1, 'Aneka Sarana Pratama Jaya', 'Jl. Pratama Jaya No. 20 Jakarta Utara', 8123456781, 'sales@ptarama.co.id'),
(2, 'Pakde', 'Jl. Pasir Gombong No.17 , Cikarang Utara', 8787654321, 'Aderamli12@gmail.com'),
(3, 'Rusianfood', 'Jl. Rusa Blok C NO.107 , Cikarang Pusat', 8125678901, 'Rusianfood11@gmail.com'),
(4, 'Toko Agen Cemerlang', 'Jl. Pasri Konci , Pasir Sari , Cikarang Utara', 8791245666, 'Rusdy00@gmail.com'),
(5, 'Healthy Salad', 'Jl. Rengasbandung No.129, Cikarang Timur', 8951261885, 'Healtysalad99@gmail.coom'),
(6, 'Cilhoot', 'Jl. Gempol Blok F No.98, Cikarang Selatan', 8123567890, 'rumnicilhoot_7@gmail.com'),
(7, 'Happy Mealpik', 'Jl. Purinirwana Blok H No.124, Cikarang Utara', 8651789020, 'Melspikhappy6@gmail.com'),
(8, 'Global Bakery', 'Jl. Jababeka IV , Cikarang Baru', 878777912, 'Global_bakery1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama_user` varchar(30) DEFAULT NULL,
  `jabatan` varchar(30) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_user`, `jabatan`, `username`, `password`) VALUES
(1, 'Zulfa', 'ketua', 'zulfa', '12345678'),
(2, 'Balqis', 'pengurus', 'balqis', 'Balqis123$'),
(3, 'A0000002', 'anggota', 'angga', 'Angga'),
(100, '-', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`,`id_karyawan`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `pinjam_angsuran` (`pinjaman_id`) USING BTREE;

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD KEY `kode_barang` (`kode_barang`) USING BTREE;

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`,`id_karyawan`) USING BTREE;

--
-- Indexes for table `detail_beli`
--
ALTER TABLE `detail_beli`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `kode_barang` (`kode_barang`) USING BTREE,
  ADD KEY `detail_beli` (`pembelian_id`) USING BTREE;

--
-- Indexes for table `detail_jual`
--
ALTER TABLE `detail_jual`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `barang` (`kode_barang`) USING BTREE,
  ADD KEY `detail_jual` (`penjualan_id`) USING BTREE;

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `global_param`
--
ALTER TABLE `global_param`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `hasil_usaha`
--
ALTER TABLE `hasil_usaha`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`,`status`) USING BTREE;

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `pinjaman` (`kode_reff`) USING BTREE;

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `supplier` (`supplier_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `kode_beli` (`kode_beli`) USING BTREE;

--
-- Indexes for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `simpan_tarik` (`simpanan_id`) USING BTREE;

--
-- Indexes for table `pengajuan_tarik_saldo`
--
ALTER TABLE `pengajuan_tarik_saldo`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_anggota_id` (`anggota_id`) USING BTREE;

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `customer` (`customer_id`) USING BTREE,
  ADD KEY `user_jual` (`user_id`) USING BTREE,
  ADD KEY `kode_jual` (`kode_jual`) USING BTREE;

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_pinjam` (`user_id`) USING BTREE,
  ADD KEY `anggota_pinjam` (`anggota_id`) USING BTREE,
  ADD KEY `kode_pinjam` (`kode_pinjam`) USING BTREE;

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `simpan_saldo` (`simpanan_id`) USING BTREE;

--
-- Indexes for table `saldo_daily`
--
ALTER TABLE `saldo_daily`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `anggota` (`anggota_id`) USING BTREE,
  ADD KEY `user` (`user_id`) USING BTREE,
  ADD KEY `kode_simpanan` (`kode_simpanan`) USING BTREE;

--
-- Indexes for table `sim_pokok`
--
ALTER TABLE `sim_pokok`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `simpan_pokok` (`simpanan_id`) USING BTREE;

--
-- Indexes for table `sim_sukarela`
--
ALTER TABLE `sim_sukarela`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `simpan_sukarela` (`simpanan_id`) USING BTREE;

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `angsuran`
--
ALTER TABLE `angsuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `detail_beli`
--
ALTER TABLE `detail_beli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `detail_jual`
--
ALTER TABLE `detail_jual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hasil_usaha`
--
ALTER TABLE `hasil_usaha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=581;

--
-- AUTO_INCREMENT for table `penarikan`
--
ALTER TABLE `penarikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1213;

--
-- AUTO_INCREMENT for table `pengajuan_tarik_saldo`
--
ALTER TABLE `pengajuan_tarik_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=812;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1181;

--
-- AUTO_INCREMENT for table `saldo_daily`
--
ALTER TABLE `saldo_daily`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1248;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sim_pokok`
--
ALTER TABLE `sim_pokok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1218;

--
-- AUTO_INCREMENT for table `sim_sukarela`
--
ALTER TABLE `sim_sukarela`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1214;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_beli`
--
ALTER TABLE `detail_beli`
  ADD CONSTRAINT `detail_beli` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kode_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detail_jual`
--
ALTER TABLE `detail_jual`
  ADD CONSTRAINT `barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_jual` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `simpan_tarik` FOREIGN KEY (`simpanan_id`) REFERENCES `simpanan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `user_jual` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `anggota_pinjam` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_pinjam` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `saldo`
--
ALTER TABLE `saldo`
  ADD CONSTRAINT `simpan_saldo` FOREIGN KEY (`simpanan_id`) REFERENCES `simpanan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD CONSTRAINT `anggota` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sim_sukarela`
--
ALTER TABLE `sim_sukarela`
  ADD CONSTRAINT `simpan_sukarela` FOREIGN KEY (`simpanan_id`) REFERENCES `simpanan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
