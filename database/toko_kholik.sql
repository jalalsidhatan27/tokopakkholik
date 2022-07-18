-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jul 2022 pada 14.04
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Struktur dari tabel `barang`
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
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kdBarang`, `idKategori`, `namaBarang`, `hargaBeli`, `harga`, `stok`) VALUES
('B2200004', 9, 'PULPEN PILOT', 2000, 3500, 250),
('B2200005', 10, 'gayung', 5000, 8000, 30),
('B2200006', 13, 'Softex A', 4000, 15000, 55),
('B2200008', 11, 'Emeron1', 10000, 25000, 35),
('B2200009', 12, 'Ketepak', 8000, 15000, 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `beli_update_minus`
--

CREATE TABLE `beli_update_minus` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `beli_update_minus`
--
DELIMITER $$
CREATE TRIGGER `bupdate_minus` AFTER INSERT ON `beli_update_minus` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok + NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `beli_update_plus`
--

CREATE TABLE `beli_update_plus` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `beli_update_plus`
--
DELIMITER $$
CREATE TRIGGER `bupdate_plus` AFTER INSERT ON `beli_update_plus` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok - NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jual_update_minus`
--

CREATE TABLE `jual_update_minus` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `jual_update_minus`
--
DELIMITER $$
CREATE TRIGGER `jupdate_minus` AFTER INSERT ON `jual_update_minus` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok - NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jual_update_plus`
--

CREATE TABLE `jual_update_plus` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `jual_update_plus`
--
DELIMITER $$
CREATE TRIGGER `jupdate_plus` AFTER INSERT ON `jual_update_plus` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok + NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_umum`
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
-- Dumping data untuk tabel `jurnal_umum`
--

INSERT INTO `jurnal_umum` (`no`, `tanggal`, `nama_perkiraan`, `debet`, `kredit`, `keterangan`) VALUES
(33, '2022-07-02', 'Pembelian', 40000, 0, 'Tunai'),
(34, '2022-07-02', 'Kas', 0, 40000, 'Pembelian'),
(35, '2022-07-02', 'Kas', 75000, 0, 'Penjualan'),
(36, '2022-07-02', 'Penjualan', 0, 75000, ''),
(39, '2022-07-02', 'Pembelian', 50000, 0, 'Tunai'),
(40, '2022-07-02', 'Kas', 0, 50000, 'Pembelian'),
(41, '2022-07-02', 'Pembelian', 24000, 0, 'Tunai'),
(42, '2022-07-02', 'Kas', 0, 24000, 'Pembelian'),
(43, '2022-07-02', 'Kas', 40000, 0, 'Penjualan'),
(44, '2022-07-02', 'Penjualan', 0, 40000, ''),
(45, '2022-07-02', 'Kas', 40000, 0, 'Penjualan'),
(46, '2022-07-02', 'Penjualan', 0, 40000, ''),
(47, '2022-07-18', 'Kas', 50000, 0, ''),
(48, '2022-07-18', 'Inventaris', 20000, 0, ''),
(49, '2022-07-18', 'Persediaan Barang', 15000, 0, ''),
(50, '2022-07-18', 'Perlengkapan', 10000, 0, ''),
(51, '2022-07-18', 'Kendaraan', 10000, 0, ''),
(52, '2022-07-18', 'Modal Owner', 0, 105000, ''),
(53, '2022-07-18', 'Beban Persediaan', 20000, 0, ''),
(54, '2022-07-18', 'Persediaan Barang', 0, 20000, 'Akhir'),
(61, '2022-08-10', 'Kas', 100000, 0, ''),
(62, '2022-08-10', 'Inventaris', 30000, 0, ''),
(63, '2022-08-10', 'Persediaan Barang', 20000, 0, ''),
(64, '2022-08-10', 'Perlengkapan', 15500, 0, ''),
(65, '2022-08-10', 'Kendaraan', 14500, 0, ''),
(66, '2022-08-10', 'Modal Owner', 0, 180000, ''),
(67, '2022-08-10', 'Beban Persediaan', 20000, 0, ''),
(68, '2022-08-10', 'Persediaan Barang', 0, 20000, 'Akhir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `idKategori` int(11) NOT NULL,
  `namaKategori` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idKategori`, `namaKategori`) VALUES
(9, 'ROKOK'),
(10, 'SABUN'),
(11, 'SHAMPO'),
(12, 'ALAT TULIS'),
(13, 'Kebutuhan Wanita');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `keranjang`
--
DELIMITER $$
CREATE TRIGGER `kurang_stok` AFTER INSERT ON `keranjang` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok - NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjangb`
--

CREATE TABLE `keranjangb` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `keranjangb`
--
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER INSERT ON `keranjangb` FOR EACH ROW UPDATE barang SET stok = stok + NEW.qty WHERE kdBarang = NEW.kdBarang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjangb_reset`
--

CREATE TABLE `keranjangb_reset` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `keranjangb_reset`
--
DELIMITER $$
CREATE TRIGGER `resetb` AFTER INSERT ON `keranjangb_reset` FOR EACH ROW BEGIN
	UPDATE barang SET stok = stok - NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang_reset`
--

CREATE TABLE `keranjang_reset` (
  `noItem` int(11) NOT NULL,
  `kdBarang` char(10) NOT NULL,
  `idUser` char(4) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `keranjang_reset`
--
DELIMITER $$
CREATE TRIGGER `reset` AFTER INSERT ON `keranjang_reset` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok + NEW.qty WHERE kdBarang = NEW.kdBarang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idPelanggan` int(11) NOT NULL,
  `namaPelanggan` varchar(255) NOT NULL,
  `alamatPelanggan` text NOT NULL,
  `noTelp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`idPelanggan`, `namaPelanggan`, `alamatPelanggan`, `noTelp`) VALUES
(1, 'Jalal', 'jember', '08197384864');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `idPembelian` char(10) NOT NULL,
  `tanggal` date NOT NULL,
  `idUser` char(4) NOT NULL,
  `totalHargaBeli` int(11) NOT NULL,
  `konfirmasi` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`idPembelian`, `tanggal`, `idUser`, `totalHargaBeli`, `konfirmasi`) VALUES
('P220702001', '2022-07-02', 'U004', 40000, 'YA'),
('P220702002', '2022-07-02', 'U004', 50000, 'YA'),
('P220702003', '2022-07-02', 'U004', 24000, 'YA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id_pembdetail` int(11) NOT NULL,
  `idPembelian` char(10) NOT NULL,
  `kdBarang` char(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id_pembdetail`, `idPembelian`, `kdBarang`, `qty`, `subtotal`) VALUES
(43, 'P220702001', 'B2200009', 5, 40000),
(45, 'P220702002', 'B2200008', 5, 50000),
(46, 'P220702003', 'B2200009', 3, 24000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reference`
--

CREATE TABLE `reference` (
  `id` int(11) NOT NULL,
  `no_ref` int(11) NOT NULL,
  `nama_perkiraan` varchar(100) NOT NULL,
  `posisi` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `reference`
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
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `idSupplier` int(11) NOT NULL,
  `namaSupplier` varchar(255) NOT NULL,
  `alamatSupplier` text NOT NULL,
  `noTelp` varchar(15) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`idSupplier`, `namaSupplier`, `alamatSupplier`, `noTelp`, `keterangan`) VALUES
(2, 'Fendy', 'Balung', '08197384864', 'rokok');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
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
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`idTransaksi`, `tanggal`, `idUser`, `namaPelanggan`, `alamatPelanggan`, `noTelp`, `totalHarga`, `uangBayar`, `untung`, `kembalian`) VALUES
('T220702001', '2022-07-02', 'U004', 'andre', 'Jl wuruh', '08934243', 75000, 100000, 35000, 25000),
('T220702002', '2022-07-02', 'U004', 'miftah', 'Jl Soli', '08934243', 40000, 50000, 15000, 10000),
('T220702003', '2022-07-02', 'U004', 'dina', 'Jl lohor', '08934243', 40000, 60000, 15000, 20000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `idTransaksi` char(10) NOT NULL,
  `kdBarang` char(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `untung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`idTransaksi`, `kdBarang`, `qty`, `subtotal`, `untung`) VALUES
('T220702001', 'B2200009', 5, 75000, 35000),
('T220702002', 'B2200005', 5, 40000, 15000),
('T220702003', 'B2200005', 5, 40000, 15000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`, `level`, `nama`, `noTelp`, `foto`) VALUES
('U001', 'admin', '$2y$10$R/ZJxF0U31Uq4IXhfMVE6OSG1h2efszpNiZP1RjRI9ifShCAU//Cy', 'administrator', 'Super Admin', '081212830909', 'c1b9b51347a0f82814a433282c601311.png'),
('U004', 'jalal', '$2y$10$eIkymKLUH3SiTKvqtiwpTeJwjW4pcubXUaM0ukhk8yiDcsdOR5ABK', 'kepala toko', 'Jalal Sidhatan', '08197384864', '325bdd8fdef671a525e5d18f0993f542.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kdBarang`),
  ADD KEY `idKategori` (`idKategori`);

--
-- Indeks untuk tabel `beli_update_minus`
--
ALTER TABLE `beli_update_minus`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `beli_update_plus`
--
ALTER TABLE `beli_update_plus`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `jual_update_minus`
--
ALTER TABLE `jual_update_minus`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `jual_update_plus`
--
ALTER TABLE `jual_update_plus`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idKategori`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `keranjangb`
--
ALTER TABLE `keranjangb`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBaranng` (`kdBarang`);

--
-- Indeks untuk tabel `keranjangb_reset`
--
ALTER TABLE `keranjangb_reset`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBaranng` (`kdBarang`);

--
-- Indeks untuk tabel `keranjang_reset`
--
ALTER TABLE `keranjang_reset`
  ADD PRIMARY KEY (`noItem`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idPelanggan`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`idPembelian`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id_pembdetail`),
  ADD KEY `idPembelian` (`idPembelian`,`kdBarang`);

--
-- Indeks untuk tabel `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`idSupplier`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idTransaksi`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD KEY `idTransaksi` (`idTransaksi`),
  ADD KEY `kdBarang` (`kdBarang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idKategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idPelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id_pembdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `reference`
--
ALTER TABLE `reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `idSupplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`idKategori`) REFERENCES `kategori` (`idKategori`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`kdBarang`) REFERENCES `barang` (`kdBarang`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`kdBarang`) REFERENCES `barang` (`kdBarang`),
  ADD CONSTRAINT `transaksi_detail_ibfk_3` FOREIGN KEY (`idTransaksi`) REFERENCES `transaksi` (`idTransaksi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
