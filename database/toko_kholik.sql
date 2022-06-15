-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2022 at 02:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_kholik`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kdBarang` char(8) NOT NULL,
  `idKategori` int(11) NOT NULL,
  `namaBarang` varchar(64) NOT NULL,
  `hargaBeli` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kdBarang`, `idKategori`, `namaBarang`, `hargaBeli`, `harga`, `stok`) VALUES
('B2200004', 9, 'PULPEN PILOT', 2000, 3500, 250),
('B2200005', 10, 'gayung', 10000, 8000000, 30);

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_umum`
--

CREATE TABLE `jurnal_umum` (
  `no` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_perkiraan` varchar(45) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_umum`
--

INSERT INTO `jurnal_umum` (`no`, `tanggal`, `nama_perkiraan`, `debet`, `kredit`, `keterangan`) VALUES
(1, '2022-06-09', 'Piutang Pegawai', 10000, 0, 'gaji'),
(2, '2022-06-09', 'Kas', 0, 10000, 'gaji'),
(7, '2022-06-12', 'Kas', 119000, 0, 'Penjualan'),
(8, '2022-06-12', 'Penjualan', 0, 119000, ''),
(9, '2022-06-12', 'Pembelian', 168000, 0, 'Tunai'),
(10, '2022-06-12', 'Kas', 0, 168000, 'Pembelian'),
(11, '2022-06-13', 'Kas', 77000, 0, 'Penjualan'),
(12, '2022-06-13', 'Penjualan', 0, 77000, ''),
(13, '2022-06-13', 'Pembelian', 12000, 0, 'Tunai'),
(14, '2022-06-13', 'Kas', 0, 12000, 'Pembelian'),
(15, '2022-06-13', 'Piutang Pegawai', 10000, 0, ''),
(16, '2022-06-13', 'Kas', 0, 10000, '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idKategori` int(11) NOT NULL,
  `namaKategori` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idKategori`, `namaKategori`) VALUES
(9, 'ROKOK'),
(10, 'SABUN'),
(11, 'SHAMPO'),
(12, 'ALAT TULIS');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `keranjang`
--
DELIMITER $$
CREATE TRIGGER `kurang_stok` AFTER INSERT ON `keranjang` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok - NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reset` BEFORE DELETE ON `keranjang` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok + OLD.qty WHERE kdBarang = OLD.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keranjangb`
--

CREATE TABLE `keranjangb` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `keranjangb`
--
DELIMITER $$
CREATE TRIGGER `resetstok` AFTER DELETE ON `keranjangb` FOR EACH ROW UPDATE barang SET stok = stok - OLD.qty WHERE barang.kdBarang = OLD.kdBarang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER INSERT ON `keranjangb` FOR EACH ROW UPDATE barang SET stok = stok + NEW.qty WHERE kdBarang = NEW.kdBarang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idPelanggan` int(11) NOT NULL,
  `namaPelanggan` varchar(255) NOT NULL,
  `alamatPelanggan` text NOT NULL,
  `noTelp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idPelanggan`, `namaPelanggan`, `alamatPelanggan`, `noTelp`) VALUES
(1, 'Jalal', 'jember', '08197384864');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `idPembelian` char(10) NOT NULL,
  `tanggal` date NOT NULL,
  `idUser` char(4) NOT NULL,
  `totalHargaBeli` int(11) NOT NULL,
  `konfirmasi` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`idPembelian`, `tanggal`, `idUser`, `totalHargaBeli`, `konfirmasi`) VALUES
('P220612001', '2022-06-12', 'U004', 4000, 'Y'),
('P220612002', '2022-06-12', 'U004', 4000, 'Y'),
('P220612003', '2022-06-12', 'U004', 10000, 'Y'),
('P220612004', '2022-06-12', 'U004', 10000, 'Y'),
('P220612005', '2022-06-12', 'U004', 20000, 'Y'),
('P220612006', '2022-06-12', 'U004', 4000, 'Y'),
('P220612007', '2022-06-12', 'U004', 4000, 'Y'),
('P220612008', '2022-06-12', 'U004', 4000, 'Y'),
('P220613001', '2022-06-13', 'U004', 100000, 'Y'),
('P220613002', '2022-06-13', 'U004', 20000, 'Y'),
('P220613003', '2022-06-13', 'U004', 20000, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `idPembelian` char(10) NOT NULL,
  `kdBarang` char(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`idPembelian`, `kdBarang`, `qty`, `subtotal`) VALUES
('P220602001', 'B2200004', 10, 20000),
('P220603001', 'B2200004', 2, 4000),
('P220603002', 'B2200004', 6, 12000),
('P220603003', 'B2200004', 2, 4000),
('P220603003', 'B2200004', 10, 20000),
('P220603004', 'B2200004', 20, 40000),
('P220603005', 'B2200004', 10, 20000),
('P220603006', 'B2200004', 10, 20000),
('P220603007', 'B2200004', 10, 20000),
('P220603008', 'B2200004', 50, 100000),
('P220603009', 'B2200004', 50, 100000),
('P220603010', 'B2200004', 50, 100000),
('P220603011', 'B2200004', 50, 100000),
('P220603012', 'B2200004', 50, 100000),
('P220603013', 'B2200004', 100, 200000),
('P220603014', 'B2200004', 100, 200000),
('P220603015', 'B2200004', 50, 100000),
('P220603016', 'B2200004', 50, 100000),
('P220603017', 'B2200004', 50, 100000),
('P220603018', 'B2200004', 50, 100000),
('P220603019', 'B2200005', 5, 50000),
('P220603020', 'B2200005', 10, 100000),
('P220603020', 'B2200004', 50, 100000),
('P220603021', 'B2200005', 20, 200000),
('P220603022', 'B2200005', 10, 100000),
('P220612001', 'B2200004', 2, 4000),
('P220612002', 'B2200004', 2, 4000),
('P220612003', 'B2200004', 5, 10000),
('P220612005', 'B2200004', 10, 20000),
('P220612006', 'B2200004', 2, 4000),
('P220612007', 'B2200004', 2, 4000),
('P220612008', 'B2200004', 2, 4000),
('P220613001', 'B2200004', 50, 100000),
('P220613002', 'B2200004', 10, 20000),
('P220613003', 'B2200004', 10, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `id` int(11) NOT NULL,
  `no_ref` int(11) NOT NULL,
  `nama_perkiraan` varchar(100) NOT NULL,
  `posisi` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`id`, `no_ref`, `nama_perkiraan`, `posisi`) VALUES
(1, 101, 'Kas', 'Aktiva Lancar'),
(2, 102, 'Piutang Pegawai', ''),
(3, 103, 'Piutang Dagang', 'Aktiva Lancar'),
(4, 104, 'Persediaan Barang', 'Aktiva Lancar'),
(5, 105, 'Sewa dibayar di muka ', 'Aktiva Lancar'),
(6, 106, 'Perlengkapan', 'Aktiva Lancar'),
(7, 107, 'Inventaris', 'Aktiva Tetap'),
(8, 108, 'Kendaraan', 'Aktiva Tetap'),
(9, 109, 'Akum.Peny.Inventaris', ''),
(10, 110, 'Akum.Peny.Kendaraan', ''),
(11, 201, 'Hutang Dagang', 'Pasiva'),
(12, 202, 'Hutang Bank', 'Pasiva'),
(13, 203, 'Hutang Gaji', 'Pasiva'),
(14, 301, 'Modal Owner', ''),
(15, 302, 'Prive Owner', ''),
(16, 501, 'Biaya Pembelian', 'Rugi-Laba'),
(17, 502, 'Biaya Servis Kendaraan', 'Rugi-Laba'),
(18, 503, 'Biaya Gaji', 'Rugi-Laba'),
(25, 504, 'Biaya Rek Air', 'Rugi-Laba'),
(20, 505, 'Biaya Peny.Inventaris', 'Rugi-Laba'),
(21, 506, 'Biaya Peny.Kendaraan', 'Rugi-Laba'),
(22, 507, 'Biaya Listrik & Telepon', 'Rugi-Laba'),
(23, 508, 'Biaya lain-lain', 'Rugi-Laba'),
(24, 401, 'Pembelian', ''),
(26, 402, 'Penjualan', ''),
(27, 509, 'Beban Persediaan', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `idSupplier` int(11) NOT NULL,
  `namaSupplier` varchar(255) NOT NULL,
  `alamatSupplier` text NOT NULL,
  `noTelp` varchar(15) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`idSupplier`, `namaSupplier`, `alamatSupplier`, `noTelp`, `keterangan`) VALUES
(2, 'Fendy', 'Balung', '08197384864', 'rokok');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idTransaksi` char(10) NOT NULL,
  `tanggal` date NOT NULL,
  `idUser` char(4) NOT NULL,
  `namaPelanggan` varchar(64) NOT NULL,
  `alamatPelanggan` varchar(128) NOT NULL,
  `noTelp` varchar(15) NOT NULL,
  `totalHarga` int(11) NOT NULL,
  `uangBayar` int(11) NOT NULL,
  `untung` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idTransaksi`, `tanggal`, `idUser`, `namaPelanggan`, `alamatPelanggan`, `noTelp`, `totalHarga`, `uangBayar`, `untung`, `kembalian`) VALUES
('T220601002', '2022-06-01', 'U001', 'Arka', 'Grenden', '08197388675', 6000, 10000, 0, 4000),
('T220602001', '2022-06-02', 'U001', 'Jalal', 'kl', '08197384864', 7000, 50000, 0, 43000),
('T220608001', '2022-06-08', 'U004', 'Jalal', '123', '123', 7000, 7000, 3000, 0),
('T220608002', '2022-06-08', 'U004', 'Jalal', '123', '123', 7000, 7000, 3000, 0),
('T220608003', '2022-06-08', 'U004', 'Jalal', 're', 'uy', 3500, 3500, 1500, 0),
('T220608004', '2022-06-08', 'U004', 'rd', 'ff', 'hr', 7000, 7000, 3000, 0),
('T220608005', '2022-06-08', 'U004', 'dg', 'gd', 'gfd', 7000, 7000, 3000, 0),
('T220608006', '2022-06-08', 'U004', 'ew', 'df', 'hd', 7000, 7000, 3000, 0),
('T220612001', '2022-06-12', 'U004', 'Jalal', '12', '12', 7000, 7000, 3000, 0),
('T220612002', '2022-06-12', 'U004', 'Jalal', '12', '12', 7000, 7000, 3000, 7000),
('T220612003', '2022-06-12', 'U004', 'DEWAA', '21', 'qw', 35000, 35000, 15000, 0),
('T220612004', '2022-06-12', 'U004', '12', '21', '21', 35000, 35000, 15000, 0),
('T220612005', '2022-06-12', 'U004', 'DEWAA', 'e', 'ds', 7000, 7000, 3000, 0),
('T220612006', '2022-06-12', 'U004', 'Jalal', '12', '12', 7000, 7000, 3000, 0),
('T220613001', '2022-06-13', 'U004', 'Jalal', 'rer', 'e', 7000, 7000, 3000, 0),
('T220613002', '2022-06-13', 'U004', '123', '13', '13', 70000, 70000, 30000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `idTransaksi` char(10) NOT NULL,
  `kdBarang` char(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `untung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`idTransaksi`, `kdBarang`, `qty`, `subtotal`, `untung`) VALUES
('T220601002', 'B2200004', 2, 6000, 0),
('T220602001', 'B2200004', 2, 7000, 0),
('T220608002', 'B2200004', 2, 7000, 7000),
('T220608003', 'B2200004', 1, 3500, 3500),
('T220608004', 'B2200004', 2, 7000, 7000),
('T220608005', 'B2200004', 2, 7000, 3500),
('T220608006', 'B2200004', 2, 7000, 3000),
('T220612001', 'B2200004', 2, 7000, 3000),
('T220612003', 'B2200004', 10, 35000, 15000),
('T220612004', 'B2200004', 10, 35000, 15000),
('T220612005', 'B2200004', 2, 7000, 3000),
('T220612006', 'B2200004', 2, 7000, 3000),
('T220613001', 'B2200004', 2, 7000, 3000),
('T220613002', 'B2200004', 20, 70000, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` char(4) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(128) NOT NULL,
  `level` enum('administrator','kepala toko') NOT NULL,
  `nama` varchar(64) NOT NULL,
  `noTelp` varchar(20) NOT NULL,
  `foto` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`, `level`, `nama`, `noTelp`, `foto`) VALUES
('U001', 'admin', '$2y$10$R/ZJxF0U31Uq4IXhfMVE6OSG1h2efszpNiZP1RjRI9ifShCAU//Cy', 'administrator', 'Super Admin', '081212830909', 'c1b9b51347a0f82814a433282c601311.png'),
('U004', 'jalal', '$2y$10$eIkymKLUH3SiTKvqtiwpTeJwjW4pcubXUaM0ukhk8yiDcsdOR5ABK', 'kepala toko', 'Jalal Sidhatan', '08197384864', '325bdd8fdef671a525e5d18f0993f542.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kdBarang`),
  ADD KEY `idKategori` (`idKategori`);

--
-- Indexes for table `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idKategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indexes for table `keranjangb`
--
ALTER TABLE `keranjangb`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBaranng` (`kdBarang`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idPelanggan`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`idPembelian`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD KEY `idPembelian` (`idPembelian`,`kdBarang`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`idSupplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idTransaksi`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD KEY `idTransaksi` (`idTransaksi`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idKategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idPelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `idSupplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`idKategori`) REFERENCES `kategori` (`idKategori`);

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`kdBarang`) REFERENCES `barang` (`kdBarang`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`kdBarang`) REFERENCES `barang` (`kdBarang`),
  ADD CONSTRAINT `transaksi_detail_ibfk_3` FOREIGN KEY (`idTransaksi`) REFERENCES `transaksi` (`idTransaksi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
