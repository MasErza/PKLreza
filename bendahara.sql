-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Des 2024 pada 15.03
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bendahara`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','viewer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_user`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'reza@gmail.com', 'reza12345', 'admin', '2024-11-27 08:05:55'),
(2, 'naura@gmail.com', 'naura12345', 'admin', '2024-12-08 06:35:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbbulan`
--

CREATE TABLE `tbbulan` (
  `nourut` int(15) NOT NULL,
  `namakaryawan` varchar(100) NOT NULL,
  `Jan` int(15) NOT NULL,
  `Feb` int(15) NOT NULL,
  `Mar` int(15) NOT NULL,
  `Apr` int(15) NOT NULL,
  `May` int(15) NOT NULL,
  `Jun` int(15) NOT NULL,
  `Jul` int(15) NOT NULL,
  `Aug` int(15) NOT NULL,
  `Sep` int(15) NOT NULL,
  `Oct` int(15) NOT NULL,
  `Nov` int(15) NOT NULL,
  `Des` int(15) NOT NULL,
  `total` int(15) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbbulan`
--

INSERT INTO `tbbulan` (`nourut`, `namakaryawan`, `Jan`, `Feb`, `Mar`, `Apr`, `May`, `Jun`, `Jul`, `Aug`, `Sep`, `Oct`, `Nov`, `Des`, `total`) VALUES
(1, 'Reza Agustian Kusnadi', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(2, 'Naura Marsa Salsabila', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(3, 'Wahyudin', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(4, 'Diki Arisandi', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(5, 'Muhammad Yusuf Fadlullah', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(6, 'Elan Maulana', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(7, 'Fadly Purnama', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(8, 'Riki Sukandar', 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 120000),
(9, 'Sendi Ardriansyah', 0, 0, 0, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 90000),
(10, 'Meylani', 0, 0, 0, 0, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 10000, 80000),
(11, 'Andika Galih Priadi', 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 240000),
(12, 'Aneu Nur Utami', 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 240000),
(13, 'Ari Setiawati', 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 20000, 240000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tipe` enum('pemasukan','pengeluaran') NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tipe`, `jumlah`, `keterangan`, `tanggal`, `created_by`) VALUES
(13, 'pengeluaran', '20000.00', 'kado', '2024-12-02', 0),
(14, 'pemasukan', '200000.00', 'dari Bu Infra', '2024-12-02', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `tbbulan`
--
ALTER TABLE `tbbulan`
  ADD PRIMARY KEY (`nourut`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbbulan`
--
ALTER TABLE `tbbulan`
  MODIFY `nourut` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
