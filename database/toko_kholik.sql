-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jun 2022 pada 10.53
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
('B2200005', 10, 'gayung', 5000, 8000, 30);

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
(1, '2022-06-09', 'Piutang Pegawai', 10000, 0, 'gaji'),
(2, '2022-06-09', 'Kas', 0, 10000, 'gaji'),
(7, '2022-06-12', 'Kas', 16199000, 0, 'Penjualan'),
(8, '2022-06-12', 'Penjualan', 0, 16199000, ''),
(9, '2022-06-12', 'Pembelian', 172000, 0, 'Tunai'),
(10, '2022-06-12', 'Kas', 0, 172000, 'Pembelian'),
(11, '2022-06-13', 'Kas', 16157000, 0, 'Penjualan'),
(12, '2022-06-13', 'Penjualan', 0, 16157000, ''),
(13, '2022-06-13', 'Pembelian', 16000, 0, 'Tunai'),
(14, '2022-06-13', 'Kas', 0, 16000, 'Pembelian'),
(15, '2022-06-13', 'Piutang Pegawai', 10000, 0, ''),
(16, '2022-06-13', 'Kas', 0, 10000, ''),
(17, '2022-06-20', 'Kas', 32080000, 0, 'Penjualan'),
(18, '2022-06-20', 'Penjualan', 0, 32080000, ''),
(19, '2022-06-20', 'Pembelian', 8000, 0, 'Tunai'),
(20, '2022-06-20', 'Kas', 0, 8000, 'Pembelian');

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
(12, 'ALAT TULIS');

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
('P220613003', '2022-06-13', 'U004', 20000, 'Y'),
('P220620002', '2022-06-20', 'U004', 25000, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `idPembelian` char(10) NOT NULL,
  `kdBarang` char(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian_detail`
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
('P220613003', 'B2200004', 10, 20000),
('P220620001', 'B2200005', 5, 25000),
('P220620002', 'B2200005', 5, 25000);

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
('T220613002', '2022-06-13', 'U004', '123', '13', '13', 70000, 70000, 30000, 0),
('T220620001', '2022-06-20', 'U004', 'andre', 'asdas', '08934243', 16000, 20000, 6000, 4000),
('T220620002', '2022-06-20', 'U004', 'dina', 'asldkajs', '08934243', 24000, 25000, 9000, 1000),
('T220620003', '2022-06-20', 'U004', 'miftah', 'sadasdas', '08934243', 40000, 50000, 15000, 10000);

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
('T220613002', 'B2200004', 20, 70000, 30000),
('T220620001', 'B2200005', 2, 16000, 6000),
('T220620002', 'B2200005', 3, 24000, 9000),
('T220620003', 'B2200005', 5, 40000, 15000);

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
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idKategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idPelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
