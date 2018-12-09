-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 09, 2018 at 01:57 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekam_medis`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `level` varchar(255) NOT NULL,
  `nomor_kontak` varchar(100) DEFAULT NULL,
  `bekerja` varchar(100) DEFAULT NULL,
  `nama_poli` varchar(100) DEFAULT NULL,
  `id_data_poli` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `username`, `password`, `nama_lengkap`, `level`, `nomor_kontak`, `bekerja`, `nama_poli`, `id_data_poli`) VALUES
(9, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Super Admin', '0877827737', 'UGD', 'Poliklinik anak', 'POLI/0001');

-- --------------------------------------------------------

--
-- Table structure for table `api_bpjs`
--

CREATE TABLE `api_bpjs` (
  `id_bpjs` int(11) NOT NULL,
  `nomor_bpjs` varchar(255) DEFAULT NULL,
  `alamat_lengkap` text,
  `nama_lengkap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api_bpjs`
--

INSERT INTO `api_bpjs` (`id_bpjs`, `nomor_bpjs`, `alamat_lengkap`, `nama_lengkap`) VALUES
(2, '12345678', 'Kp.Sumurwangi Kel.kayumanis kec.tanah sareal kota bogor', 'Dedi');

-- --------------------------------------------------------

--
-- Table structure for table `data_obat`
--

CREATE TABLE `data_obat` (
  `id_obat` int(11) NOT NULL,
  `id_data_obat` varchar(255) NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `harga_obat` varchar(255) NOT NULL,
  `stok_obat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_obat`
--

INSERT INTO `data_obat` (`id_obat`, `id_data_obat`, `nama_obat`, `harga_obat`, `stok_obat`) VALUES
(1, 'OBAT/0001', 'MIxagrib', '35000', '1000'),
(2, 'OBAT/0002', 'Oskadon', '30000', '1000');

-- --------------------------------------------------------

--
-- Table structure for table `data_pemeriksaan`
--

CREATE TABLE `data_pemeriksaan` (
  `id_data_pemeriksaan` int(11) NOT NULL,
  `nomor_pemeriksaan` varchar(255) DEFAULT NULL,
  `pembayaran` varchar(255) DEFAULT NULL,
  `nomor_bpjs` varchar(255) DEFAULT NULL,
  `nama_poli` varchar(255) DEFAULT NULL,
  `id_data_poli` varchar(255) DEFAULT NULL,
  `nama_kerabat` varchar(255) DEFAULT NULL,
  `nomor_kontak_kerabat` varchar(255) DEFAULT NULL,
  `alamat_lengkap_kerabat` text,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `alamat_pasien` text NOT NULL,
  `tanggal_masuk_ugd` varchar(255) DEFAULT NULL,
  `status_pemeriksaan` varchar(255) DEFAULT NULL,
  `pemeriksa` varchar(100) DEFAULT NULL,
  `total_bayar` varchar(255) DEFAULT NULL,
  `status_obat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pemeriksaan`
--

INSERT INTO `data_pemeriksaan` (`id_data_pemeriksaan`, `nomor_pemeriksaan`, `pembayaran`, `nomor_bpjs`, `nama_poli`, `id_data_poli`, `nama_kerabat`, `nomor_kontak_kerabat`, `alamat_lengkap_kerabat`, `nama_pasien`, `alamat_pasien`, `tanggal_masuk_ugd`, `status_pemeriksaan`, `pemeriksa`, `total_bayar`, `status_obat`) VALUES
(10, 'CHECK/POLI/0001/000001', 'BPJS', '12345678', 'Poliklinik anak', 'POLI/0001', 'Saifudin', '08433434', 'Kp.Banjar Selatan', 'Dedi', 'Kp.Sumurwangi Kel.kayumanis kec.tanah sareal kota bogor', '2018-12-09 13:05:45', 'Selesai', 'Laras Sesly Arviajis S.ag', '65000', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `data_poli`
--

CREATE TABLE `data_poli` (
  `id_poli` int(11) NOT NULL,
  `id_data_poli` varchar(100) DEFAULT NULL,
  `nama_poli` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_poli`
--

INSERT INTO `data_poli` (`id_poli`, `id_data_poli`, `nama_poli`) VALUES
(26, 'POLI/0001', 'Poliklinik anak'),
(27, 'POLI/0002', 'Poliklinik THT');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_resep`
--

CREATE TABLE `hasil_resep` (
  `id_hasil_resep` int(11) NOT NULL,
  `nomor_pemeriksaan` varchar(255) NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `harga_obat` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `jumlah_total` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_resep`
--

INSERT INTO `hasil_resep` (`id_hasil_resep`, `nomor_pemeriksaan`, `nama_obat`, `harga_obat`, `jumlah`, `jumlah_total`) VALUES
(11, 'CHECK/POLI/0001/000001', 'MIxagrib', '35000', '1', '35000'),
(12, 'CHECK/POLI/0001/000001', 'Oskadon', '30000', '1', '30000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `api_bpjs`
--
ALTER TABLE `api_bpjs`
  ADD PRIMARY KEY (`id_bpjs`);

--
-- Indexes for table `data_obat`
--
ALTER TABLE `data_obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `data_pemeriksaan`
--
ALTER TABLE `data_pemeriksaan`
  ADD PRIMARY KEY (`id_data_pemeriksaan`),
  ADD KEY `id_data_poli` (`id_data_poli`),
  ADD KEY `nomor_pemeriksaan` (`nomor_pemeriksaan`);

--
-- Indexes for table `data_poli`
--
ALTER TABLE `data_poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `id_data_poli` (`id_data_poli`);

--
-- Indexes for table `hasil_resep`
--
ALTER TABLE `hasil_resep`
  ADD PRIMARY KEY (`id_hasil_resep`),
  ADD KEY `nomor_pemeriksaan` (`nomor_pemeriksaan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `api_bpjs`
--
ALTER TABLE `api_bpjs`
  MODIFY `id_bpjs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `data_obat`
--
ALTER TABLE `data_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `data_pemeriksaan`
--
ALTER TABLE `data_pemeriksaan`
  MODIFY `id_data_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `data_poli`
--
ALTER TABLE `data_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `hasil_resep`
--
ALTER TABLE `hasil_resep`
  MODIFY `id_hasil_resep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_pemeriksaan`
--
ALTER TABLE `data_pemeriksaan`
  ADD CONSTRAINT `data_pemeriksaan_ibfk_1` FOREIGN KEY (`id_data_poli`) REFERENCES `data_poli` (`id_data_poli`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasil_resep`
--
ALTER TABLE `hasil_resep`
  ADD CONSTRAINT `hasil_resep_ibfk_1` FOREIGN KEY (`nomor_pemeriksaan`) REFERENCES `data_pemeriksaan` (`nomor_pemeriksaan`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
