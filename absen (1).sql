-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jul 2024 pada 14.48
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen`
--

CREATE TABLE `absen` (
  `id` int(11) NOT NULL,
  `nis` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktudatang` time NOT NULL,
  `keterangandatang` varchar(255) NOT NULL,
  `waktupulang` time NOT NULL,
  `keteranganpulang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absen`
--

INSERT INTO `absen` (`id`, `nis`, `tanggal`, `waktudatang`, `keterangandatang`, `waktupulang`, `keteranganpulang`) VALUES
(112, 220170, '2024-02-28', '13:05:21', '', '00:00:00', ''),
(113, 210187, '2024-02-29', '06:56:05', 'Tepat Waktu', '00:00:00', ''),
(114, 210389, '2024-02-27', '13:10:04', '', '00:00:00', ''),
(115, 520901, '2024-02-29', '13:55:40', '', '00:00:00', ''),
(117, 210188, '2024-02-29', '22:58:38', 'Terlambat', '00:00:00', ''),
(118, 210200, '2024-02-29', '02:22:12', 'Absen Cepat', '00:00:00', ''),
(120, 520901, '2024-03-01', '02:26:57', 'Absen Cepat', '00:00:00', ''),
(123, 210187, '2024-03-01', '07:26:40', 'Tepat Waktu', '00:00:00', ''),
(124, 210188, '2024-03-01', '07:27:19', 'Tepat Waktu', '00:00:00', ''),
(125, 210200, '2024-03-01', '07:27:55', 'Tepat Waktu', '00:00:00', ''),
(129, 210193, '2024-03-01', '13:25:37', 'Terlambat', '00:00:00', ''),
(130, 123456, '2024-03-01', '13:31:01', 'Terlambat', '00:00:00', ''),
(131, 210389, '2024-03-01', '22:38:31', 'Terlambat', '00:00:00', ''),
(132, 210187, '2024-03-02', '06:30:32', 'Tepat Waktu', '00:00:00', ''),
(133, 210205, '2024-03-02', '06:30:46', 'Tepat Waktu', '00:00:00', ''),
(134, 210389, '2024-03-02', '06:30:56', 'Tepat Waktu', '00:00:00', ''),
(135, 210193, '2024-03-02', '08:08:29', 'Terlambat', '00:00:00', ''),
(136, 210200, '2024-03-02', '08:08:40', 'Terlambat', '00:00:00', ''),
(137, 210188, '2024-03-02', '08:08:56', 'Terlambat', '00:00:00', ''),
(138, 210389, '2024-06-28', '10:28:32', 'Terlambat', '00:00:00', ''),
(139, 210205, '2024-06-28', '10:28:44', 'Terlambat', '00:00:00', ''),
(143, 210187, '2024-07-04', '06:51:14', 'Tepat Waktu', '15:42:01', 'Pulang Tepat Waktu'),
(144, 210188, '2024-07-04', '06:52:06', 'Tepat Waktu', '00:00:00', ''),
(145, 210189, '2024-07-04', '00:00:00', '', '15:13:00', 'Pulang Tepat Waktu'),
(147, 210193, '2024-07-04', '08:52:06', 'Terlambat', '00:00:00', ''),
(148, 210195, '2024-07-04', '00:00:00', '', '15:13:00', 'Pulang Tepat Waktu'),
(149, 210199, '2024-07-04', '08:52:06', 'Terlambat', '00:00:00', ''),
(150, 210200, '2024-07-04', '00:00:00', '', '17:13:00', 'Pulang Terlambat'),
(151, 210205, '2024-07-04', '00:00:00', '', '15:13:00', 'Pulang Tepat Waktu'),
(152, 210206, '2024-07-04', '00:00:00', '', '17:13:00', 'Pulang Terlambat'),
(165, 520901, '2024-07-04', '13:51:14', 'Terlambat', '15:42:01', 'Pulang Terlambat'),
(169, 210187, '2024-07-08', '00:00:00', '', '17:30:51', 'Pulang Terlambat'),
(170, 210389, '2024-07-08', '00:00:00', '', '17:31:02', 'Pulang Terlambat'),
(171, 1, '2024-07-08', '00:00:00', '', '17:31:11', 'Pulang Terlambat'),
(172, 210205, '2024-07-08', '00:00:00', '', '17:31:27', 'Pulang Terlambat'),
(175, 210187, '2024-07-09', '08:09:38', 'Terlambat', '16:06:54', 'Pulang Tepat Waktu'),
(176, 210389, '2024-07-09', '08:10:26', 'Terlambat', '16:16:30', 'Pulang Tepat Waktu'),
(177, 1, '2024-07-09', '08:11:19', 'Terlambat', '16:16:59', 'Pulang Tepat Waktu'),
(178, 210205, '2024-07-09', '08:12:23', 'Terlambat', '16:17:23', 'Pulang Tepat Waktu'),
(179, 210188, '2024-07-09', '08:16:28', 'Terlambat', '16:17:56', 'Pulang Tepat Waktu'),
(180, 210200, '2024-07-09', '00:00:00', '', '16:19:39', 'Pulang Tepat Waktu'),
(181, 210193, '2024-07-09', '00:00:00', '', '16:20:17', 'Pulang Tepat Waktu'),
(182, 210187, '2024-07-11', '07:17:36', 'Tepat Waktu', '00:00:00', ''),
(183, 210389, '2024-07-11', '07:18:04', 'Tepat Waktu', '00:00:00', ''),
(184, 1, '2024-07-11', '07:18:21', 'Tepat Waktu', '00:00:00', ''),
(185, 210205, '2024-07-11', '07:18:45', 'Tepat Waktu', '00:00:00', ''),
(186, 210188, '2024-07-11', '07:19:17', 'Tepat Waktu', '00:00:00', ''),
(187, 210193, '2024-07-11', '07:19:30', 'Tepat Waktu', '00:00:00', ''),
(188, 210200, '2024-07-11', '07:20:13', 'Tepat Waktu', '00:00:00', ''),
(189, 520901, '2024-07-11', '07:20:46', 'Tepat Waktu', '00:00:00', ''),
(190, 220170, '2024-07-11', '07:20:53', 'Tepat Waktu', '00:00:00', ''),
(193, 210189, '2024-07-14', '00:00:00', '', '16:13:09', 'Pulang Tepat Waktu'),
(194, 210187, '2024-07-14', '00:00:00', '', '16:13:17', 'Pulang Tepat Waktu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses`
--

CREATE TABLE `akses` (
  `aksesid` int(11) NOT NULL,
  `kodeakses` varchar(255) NOT NULL,
  `qrcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akses`
--

INSERT INTO `akses` (`aksesid`, `kodeakses`, `qrcode`) VALUES
(5, '12345678', '1588762993_qrcode (6).png'),
(7, 'qazwsxed', '295966891_qrcode.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `jurusanid` int(11) NOT NULL,
  `namajurusan` varchar(255) NOT NULL,
  `kepanjangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`jurusanid`, `namajurusan`, `kepanjangan`) VALUES
(1, 'RPL', 'Rekayasa Perangkat Lunak'),
(2, 'TKJ', 'Teknik Komputer dan Jaringan'),
(5, 'TAV', 'Teknik Audio dan Video'),
(6, 'PPLG', 'Pengembangan Perangkat Lunak dan Gim'),
(7, 'DKV', 'Desain Komunikasi Visual'),
(10, 'MM', 'MultiMedia'),
(11, 'TSM', 'Teknik Sepeda Motor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kelasid` int(11) NOT NULL,
  `namakelas` varchar(255) NOT NULL,
  `jurusanid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kelasid`, `namakelas`, `jurusanid`) VALUES
(1, 'XII RPL', 1),
(3, 'XI RPL', 1),
(4, 'XII TJKT A', 2),
(10, 'XII DKV', 7),
(15, 'X PPLG', 6),
(16, 'XII TJKT B', 2),
(17, 'XII TSM A', 11),
(18, 'XII TSM B', 11),
(52, 'XII TAV', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `idsiswa` int(11) NOT NULL,
  `nis` int(33) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `fotosiswa` varchar(255) NOT NULL,
  `kelasid` int(11) NOT NULL,
  `jurusanid` int(11) NOT NULL,
  `jk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`idsiswa`, `nis`, `nama`, `fotosiswa`, `kelasid`, `jurusanid`, `jk`) VALUES
(15, 210187, 'A. Irgi Irwan. A', '1315121202_irgi.png', 1, 1, 'Laki-Laki'),
(16, 210389, 'Abdul Wahab S.T', '1613735594_Gambar WhatsApp 2024-02-28 pukul 14.48.52_2ae08e11.jpg', 4, 2, 'Laki-Laki'),
(17, 210200, 'Nurul Asya Azzahra', '2058467753_IMG_6109.png', 1, 1, 'Perempuan'),
(18, 220170, 'Taufik', '397188041_Gambar WhatsApp 2024-02-24 pukul 16.16.03_91c5d344.jpg', 3, 1, 'Laki-Laki'),
(19, 520901, 'Dian Bahari', '51459794_Gambar WhatsApp 2024-02-28 pukul 16.23.08_ee6f6d10.jpg', 3, 1, 'Perempuan'),
(20, 210188, 'Adham Zaquan Kamaruddin', '619317511_sgsvsefs.png', 1, 1, 'Laki-Laki'),
(21, 210205, 'Taufik', '2115226298_sdfsdfsf.png', 1, 1, 'Laki-Laki'),
(22, 210193, 'Depri', '457368012_SDGSDGGGG.png', 1, 1, 'Laki-Laki'),
(23, 210199, 'Nurmayanti', '138751257_IMG-20230705-WA0053.jpg', 1, 1, 'Perempuan'),
(25, 210206, 'Masdar', '1275454682_HRHFGRTH.png', 1, 1, 'Laki-Laki'),
(26, 210189, 'Ali Sandronesta', '204016176_dhfgffnbdfn.png', 1, 1, 'Laki-Laki'),
(28, 210191, 'Aslam', '968892855_yerhhtrhhrt.png', 1, 1, 'Laki-Laki'),
(29, 210195, 'Mohd. Yusuf', '427645234_fghfghfghf.png', 1, 1, 'Laki-Laki'),
(33, 1, 'jack', '290176897_1664369713035.jpg', 10, 7, 'Laki-Laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `fotouser` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `hakakses` varchar(255) NOT NULL,
  `kelasid` int(11) NOT NULL,
  `jurusanid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`, `fotouser`, `role`, `hakakses`, `kelasid`, `jurusanid`) VALUES
(24, 'luke', '1', 'luke@gmail.com', 'Luke', 'Puppole eheck :)', '2043298683_1666609685574.jpg', 'Admin', 'Diizinkan', 0, 0),
(32, 'darwis', '123', 'darwis@gmail.com', 'Darwis, S.S., M. Pd.', 'testing 123', '2042838593_4636.jpg', 'Kepala Sekolah', 'Diizinkan', 0, 0),
(33, 'wahab', '123', 'wahab@gmail.com', 'Abdul Wahab S.T', 'Desa Suruang', '1406930735_Gambar WhatsApp 2024-02-28 pukul 14.48.52_2ae08e11.jpg', 'Wali Kelas', 'Diizinkan', 1, 1),
(40, 'jack', '1', 'jack@gmail.com', 'Jack Frost', 'Di Dimensi  Lain', '477513147_1664369713035.jpg', 'Wali Kelas', 'Dilarang', 6, 10);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`aksesid`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`jurusanid`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelasid`),
  ADD KEY `jurusanid` (`jurusanid`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`idsiswa`),
  ADD KEY `jurusanid` (`jurusanid`),
  ADD KEY `kelasid` (`kelasid`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `kelasid` (`kelasid`,`jurusanid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen`
--
ALTER TABLE `absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT untuk tabel `akses`
--
ALTER TABLE `akses`
  MODIFY `aksesid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `jurusanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelasid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `idsiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`jurusanid`) REFERENCES `jurusan` (`jurusanid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`jurusanid`) REFERENCES `jurusan` (`jurusanid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`kelasid`) REFERENCES `kelas` (`kelasid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
