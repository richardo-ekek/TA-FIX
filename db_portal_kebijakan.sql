-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Okt 2026 pada 17.36
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
-- Database: `db_portal_kebijakan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `kategori_dokumen` varchar(255) DEFAULT NULL,
  `perihal_dokumen` varchar(255) DEFAULT NULL,
  `aksi` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `admin_name`, `kategori_dokumen`, `perihal_dokumen`, `aksi`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 'richardo', 'TIK KEMLU', 'aspek keamanan infrastruktur, manajemen risiko, dan tata kelola data', 'Approved', 'kirim utusan untuk perpanjang kontrak perjanjian', '2026-05-07 08:47:37', '2026-05-07 08:47:37'),
(2, 1, 'richardo', 'TIK NON KEMLU', 'Pengaturan dan pengelolaan kebijakan digital seluruh kementerian Republik Indonesia', 'Rejected', 'tinjau ulang dan minta pengunduran jadwal', '2026-05-07 08:48:35', '2026-05-07 08:48:35'),
(3, 1, 'richardo', 'TIK NON KEMLU', 'Tatacara pelaporan rutin kemajuan dan hambatan program kementerian ke presiden atau utusannya', 'Approved', 'cetak fisik dan bawa ke brangkas lampiran fisik di ruang Melati', '2026-05-07 15:12:19', '2026-05-07 15:12:19'),
(4, 1, 'richardo', 'MOU', 'Kerjasama 100 kapal Induk Prancis', 'Approved', 'kawal tiap proses audit keuangan tersebut', '2026-05-08 01:33:50', '2026-05-08 01:33:50'),
(5, 1, 'richardo', 'TIK KEMLU', 'Mengatur tata cara pengadaan barang inventaris ataupun barang sekali pakai yang digunakan untuk seluruh kebutuhan Kementerian Luar Negeri dan meninjau segala baarang yang boleh dan tidak diperbolehkan untuk diadakan.', 'Approved', 'minta untuk semua satuan kerja kementerian Luar Negeri untuk mematuhi peraturan ini, segala barang yang diadakan baik untuk inventaris maupun sekali pakai haruslah melalu serangkaian proses yang telah di atur oleh permenlu nomor 27 tahun 2021 dan di laporkan ke sekertariat jendral serta di arsipkan dalam bentuk dokumen dan foto barang yang disimpan dalam bentuk digital serta fisik di gedung arsip.', '2026-05-08 01:36:33', '2026-05-08 01:36:33'),
(6, 1, '', 'MOU', 'Pengamanan Bersama Wilayah Udara Inonesia-Australia', 'Approved', NULL, '2026-05-10 11:54:15', '2026-05-10 11:54:15'),
(7, 1, '', 'TIK KEMLU', 'Pengadaan Kendaraan Dinas Listrik di seluruh Kementerian guna meningkatkan perkembangan kendaraan listrik dalam negri dan menekan penggunaan BBM di dalam negeri', 'Approved', NULL, '2026-05-10 12:50:35', '2026-05-10 12:50:35'),
(8, 1, '', 'TIK NON KEMLU', 'Penjagaan gabungan wilayah udara indonesia dan australia yang dilakukan demi menjaga keamanan kedua belah negara dan juga meningkatkan kerjasama baik', 'Approved', NULL, '2026-05-10 12:50:42', '2026-05-10 12:50:42'),
(9, 1, '', 'MOU', 'PENGAMANAN BERSAMA SISTEM DAN KEBIJAKAN TEKNOLOGI INFORMASI DAN KOMUNIKASI (TIK) LINGKUP KEMENTERIAN LUAR NEGERI DENGAN SISTEM EKSTERNAL NON-KEMENTERIAN LUAR NEGERI', 'Approved', NULL, '2026-05-10 12:50:46', '2026-05-10 12:50:46'),
(10, 1, '', 'TIK KEMLU', 'aspek keamanan infrastruktur, manajemen risiko, dan tata kelola data', 'Approved', NULL, '2026-05-10 12:50:54', '2026-05-10 12:50:54'),
(11, 1, '', 'TIK NON KEMLU', 'keikutsertaan mahasiswa', 'Approved', NULL, '2026-05-10 12:51:11', '2026-05-10 12:51:11'),
(12, 1, '', 'MOU', 'PENGAMANAN BERSAMA SISTEM DAN KEBIJAKAN TEKNOLOGI INFORMASI DAN KOMUNIKASI (TIK) LINGKUP KEMENTERIAN LUAR NEGERI DENGAN SISTEM EKSTERNAL NON-KEMENTERIAN LUAR NEGERI', 'Approved', 'bagus', '2026-06-11 03:21:44', '2026-06-11 03:21:44'),
(13, 1, '', 'MOU', 'PENGAMANAN BERSAMA SISTEM DAN KEBIJAKAN TEKNOLOGI INFORMASI DAN KOMUNIKASI (TIK) LINGKUP KEMENTERIAN LUAR NEGERI DENGAN SISTEM EKSTERNAL NON-KEMENTERIAN LUAR NEGERI', 'Approved', 'bagus', '2026-06-11 03:21:45', '2026-06-11 03:21:45'),
(14, 1, '', 'TIK KEMLU', 'perihal contoh', 'Rejected', 'perbaiki', '2026-06-11 03:22:22', '2026-06-11 03:22:22'),
(15, 1, '', 'MOU', 'perihal contoh', 'Approved', 'woke acc', '2026-06-30 22:22:30', '2026-06-30 22:22:30'),
(16, 1, '', 'TIK KEMLU', 'qwwq', 'Rejected', 'ga dulu', '2026-06-30 22:22:43', '2026-06-30 22:22:43'),
(17, 1, '', 'TIK NON KEMLU', 'ayam', 'Approved', 'baiklah', '2026-06-30 22:22:54', '2026-06-30 22:22:54'),
(18, 1, '', 'MOU', 'ttd opt ataur', 'Rejected', 'ga boleh atur atur', '2026-07-02 04:52:55', '2026-07-02 04:52:55'),
(19, 1, '', 'MOU', 'opt atur pks', 'Approved', 'baiklah', '2026-07-02 05:32:31', '2026-07-02 05:32:31'),
(20, 1, '', 'TIK NON KEMLU', 'aturan', 'Rejected', 'ga dulu', '2026-07-02 05:32:47', '2026-07-02 05:32:47'),
(21, 1, '', 'MOU', 'saysaya', 'Revisi', 'buat lebih detail, tahunnya salah.', '2026-07-03 03:39:20', '2026-07-03 03:39:20'),
(22, 1, '', 'TIK KEMLU', 'opey', 'Rejected', 'jelek', '2026-07-03 03:39:33', '2026-07-03 03:39:33'),
(23, 1, '', 'TIK NON KEMLU', 'kampoung', 'Approved', 'mantap', '2026-07-03 03:39:45', '2026-07-03 03:39:45'),
(24, 1, '', 'TIK KEMLU', 'opeyk', 'Approved', 'oke', '2026-07-03 08:27:05', '2026-07-03 08:27:05'),
(25, 1, '', 'MOU', 'contoh untuk TA', 'Revisi', 'perbaiki bagian tanggal berakhir', '2026-07-19 21:24:44', '2026-07-19 21:24:44'),
(26, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'MOU', 'contoh hukum tim 1', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'semua sudah sesuai dalam kaidah hukum pak', '2026-07-26 12:13:53', '2026-07-26 12:13:53'),
(27, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'TIK KEMLU', 'buat hukum tes', 'Revisi Hukum', 'buat dasar hukumnya lebih jelas', '2026-07-26 12:14:18', '2026-07-26 12:14:18'),
(28, 1, '', 'MOU', 'contoh hukum tim 1', 'Revisi', 'cacat, buat dengan lebih jelas dasarnya', '2026-07-26 12:16:54', '2026-07-26 12:16:54'),
(29, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'TIK NON KEMLU', 'tes hukum non kemlu', 'Revisi Hukum', 'coba perjelas mengenai dasar hukumnya', '2026-07-26 12:47:29', '2026-07-26 12:47:29'),
(30, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'MOU', 'tes 2 hukum', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'sudah sangat mantap', '2026-07-26 14:39:40', '2026-07-26 14:39:40'),
(31, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'TIK KEMLU', 'tes2 tik kemlu hukum', 'Revisi Hukum', 'masih kureng bos', '2026-07-26 14:39:53', '2026-07-26 14:39:53'),
(32, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'TIK NON KEMLU', 'tes 2 non kemlu hukum', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'ini paten banget', '2026-07-26 14:40:03', '2026-07-26 14:40:03'),
(33, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'TIK NON KEMLU', 'tes hukum non kemlu sorry bang kali ini paten pasti ga neko neko lagi', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'siap mantap', '2026-07-26 15:16:14', '2026-07-26 15:16:14'),
(34, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'TIK NON KEMLU', 'tes 2 non kemlu hukum dijamin kali ini paten bos ku ga kelng kaleng', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'asli bah paten kali', '2026-07-26 15:16:25', '2026-07-26 15:16:25'),
(35, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'TIK NON KEMLU', 'tes 2 non kemlu hukum dijamin kali ini paten bos ku ga kelng kaleng', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'oke', '2026-07-26 15:36:19', '2026-07-26 15:36:19'),
(36, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'MOU', 'perihal contoh', 'Revisi Hukum (Revisi ke-1)', 'jelek', '2026-07-26 15:38:44', '2026-07-26 15:38:44'),
(37, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'MOU', 'perihal contoh', 'Revisi Hukum (Revisi ke-2)', 'maaf ya belum bisa nih bos ku', '2026-07-26 15:40:50', '2026-07-26 15:40:50'),
(38, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'MOU', 'perihal contoh', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'oke deh', '2026-07-26 15:42:02', '2026-07-26 15:42:02'),
(39, 1, 'richardo manalu', 'MOU', 'perihal contoh', 'Revisi', 'maaf belum bisa buat ulang hehe', '2026-07-26 15:43:37', '2026-07-26 15:43:37'),
(40, 18, 'tim hukum 1 (TIM Hotman) (Tim Hukum)', 'MOU', 'contoh hari senin', 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)', 'Sudah sesuai Tapoki Hukum', '2026-07-27 03:38:12', '2026-07-27 03:38:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tipe_pemohon` varchar(50) DEFAULT 'institusi',
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Admin yang menyetujui/menolak',
  `nama` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `detail_tujuan` text NOT NULL,
  `mode` enum('daring','luring') NOT NULL,
  `preferensi_waktu` datetime DEFAULT NULL,
  `status` enum('submitted','processing','approved','rejected') NOT NULL DEFAULT 'submitted',
  `file_berita_acara` varchar(255) DEFAULT NULL,
  `catatan_pertemuan` text DEFAULT NULL,
  `link_meeting` text DEFAULT NULL,
  `alamat_pertemuan` text DEFAULT NULL,
  `tanggal_waktu_pertemuan` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `keterangan_tambahan` text DEFAULT NULL,
  `link_maps` text DEFAULT NULL,
  `detail_alamat_pertemuan` varchar(255) DEFAULT NULL,
  `alasan_penolakan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `tipe_pemohon`, `admin_id`, `nama`, `instansi`, `alamat`, `tujuan`, `detail_tujuan`, `mode`, `preferensi_waktu`, `status`, `file_berita_acara`, `catatan_pertemuan`, `link_meeting`, `alamat_pertemuan`, `tanggal_waktu_pertemuan`, `created_at`, `updated_at`, `keterangan_tambahan`, `link_maps`, `detail_alamat_pertemuan`, `alasan_penolakan`) VALUES
(1, 1, 'institusi', NULL, 'richardo', 'Universitas Sebelas Maret', 'Jl.Ir sutami Surakarta', 'Penandatanganan Dokumen', 'Penandatanganan perjanjian kunjungan Kampus ke KBRI Korea Selatan', 'luring', '2026-05-12 00:32:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-05-07 08:31:06', '2026-05-07 08:37:36', NULL, NULL, NULL, 'Perjanjian harus di tinjau ulang dikarenakan kondisi Geopolitik Internasional saat ini'),
(2, 1, 'institusi', NULL, 'richardo', 'ESDM', 'Jalan Medan Merdeka 3', 'Lainnya', 'Pemeriksaan Efisiensi Energi Kantor Kementerian Luar Negri', 'luring', '2026-05-25 14:31:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-05-07 08:31:58', '2026-06-30 22:14:00', NULL, NULL, NULL, 'ga mau'),
(3, 1, 'institusi', NULL, 'richardo', 'Kementerian Keuangan', 'Jalan Medan Merdeka 3', 'Lainnya', 'Rapat Anggaran Keuangan Kementerian Luar Negri', 'daring', '2026-06-19 10:32:00', 'approved', NULL, NULL, 'https://www.zoom.com/', NULL, '2026-05-20 12:35:00', '2026-05-07 08:32:43', '2026-05-07 08:36:54', 'mohon Lampirkan Surat Kuasa Pengikat ke email kemlu1@gmail.com', NULL, NULL, NULL),
(4, 4, 'institusi', NULL, 'manalu.fams', 'Universitas Sebelas', 'Jl.Ir sutami Surakarta', 'Penandatanganan Dokumen', 'Penandatanganan surat Magang dan pengauan Sertifikat atas Nama Richardo Gilbert Ganda Tua yang mengajukan magang pada 13 Mei 2025 dan akan berakhir di 13 Mei 2026 di Divisi Pustik Kemlu', 'luring', '2026-05-13 09:00:00', 'approved', NULL, NULL, NULL, 'Pejambon nomor 16 Gedung kementerian Luar Negeri', '2026-05-13 01:53:00', '2026-05-07 12:52:20', '2026-05-07 12:56:12', 'Bawa ID Card magang untuk dikembalikan', 'https://maps.app.goo.gl/agNAimMQMQjbxZFX9', 'Gedung A, Lantai 1, Ruang Tunggu', NULL),
(5, 4, 'institusi', NULL, 'richardo manalu', 'BPK', 'Audit Tutin Tahunan', 'Lainnya', 'Audit rutin tiap tahun untuk memeriksa seluruh aliran keuangan Kementerian Luar Negeri', 'luring', '2026-05-07 17:18:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:18:36', '2026-06-30 22:15:02', NULL, NULL, NULL, 'tudak bisa saya acc'),
(6, 9, 'institusi', NULL, 'susanto artagraha', 'Bahari Jaya', 'Jl. Gatot Subroto 15', 'Penandatanganan Dokumen', 'permohonan penandatanganan kerjasama nomo PD2113L7759', 'luring', '2026-06-08 20:40:00', 'approved', NULL, NULL, NULL, NULL, '2026-07-09 17:14:00', '2026-05-10 04:33:35', '2026-06-30 22:14:45', NULL, NULL, NULL, NULL),
(7, 4, 'institusi', NULL, 'richardo manalu', 'Sidoarjo Jaya', 'Jl. Sidobangun no 97', 'Konsultasi TIK', 'diskusi pembahasan program pengembangan digital indonesia jepang', 'daring', '2026-06-22 19:21:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-05-10 05:21:48', '2026-05-10 05:28:52', NULL, NULL, NULL, 'mengingat kondisi geopolitik global saat ini, maka permohonan anda perlu kami tinjau ulang'),
(8, 4, 'institusi', NULL, 'richardo manalu', 'Jaya Kusuma Bangsa', 'Pakuoan Town 77', 'Penandatanganan Dokumen', 'Penandatanganan kerjasama serikat pekerja keamanan untuk di salurkan ke Jepang', 'luring', '2026-05-20 19:23:00', 'approved', NULL, NULL, NULL, NULL, NULL, '2026-05-10 05:23:41', '2026-05-10 05:27:09', NULL, NULL, NULL, NULL),
(9, 4, 'institusi', NULL, 'richardo manalu', 'KEMENDAGRI', 'Jl. Intiraksi 55', 'Lainnya', 'Rapat pembahasan kerjasama pertukaran teknologi pertanian dengan jepang', 'luring', '2026-05-15 20:15:00', 'approved', NULL, NULL, NULL, NULL, NULL, '2026-05-10 06:15:57', '2026-05-10 06:17:53', NULL, NULL, NULL, NULL),
(10, 4, 'institusi', NULL, 'richardo manalu', 'PT.Haji Bahagia', 'Jl. indasari 73', 'Penandatanganan Dokumen', 'pembahasan kerjasama pemberangkatan jamaah haji', 'daring', '2026-05-31 20:21:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-05-10 06:21:05', '2026-05-10 06:21:54', NULL, NULL, NULL, 'melihat kondisi geopolitik global yang memanas, permohonan anda perlu kami tinjau ulang'),
(11, 4, 'institusi', NULL, 'richardo manalu', 'Ikatan Serikat Pekerja Luar Negeri', 'jl.  hartawijaya 84', 'Lainnya', 'membahas mengenai banyaknya anomali Pekerja Indonesia di Jepang yang menimbulkan keresahan bagi negara Jepang dan memperburuk citra Indonesia di kanca Internasional', 'luring', '2026-05-14 02:00:00', 'approved', NULL, NULL, NULL, NULL, NULL, '2026-05-10 12:01:17', '2026-05-10 12:02:13', NULL, NULL, NULL, NULL),
(12, 4, 'institusi', NULL, 'richardo manalu', 'ESDM', 'Jalan cabang solo 7', 'Penandatanganan Dokumen', 'pembahaan efisiensi energi di kementerian luar negeri', 'luring', '2026-05-19 02:05:00', 'approved', NULL, NULL, NULL, 'Pejambon nomor 16 Gedung kementerian Luar Negeri', '2026-05-20 02:47:00', '2026-05-10 12:05:05', '2026-05-10 12:47:25', NULL, NULL, NULL, NULL),
(13, 4, 'institusi', NULL, 'richardo manalu', 'Kemhan', 'Jalan Medan Merdeka 3', 'Penandatanganan Dokumen', 'kemhan kemhan', 'luring', '2026-05-12 02:52:00', 'approved', NULL, NULL, NULL, NULL, '2026-05-12 02:55:00', '2026-05-10 12:52:48', '2026-05-10 12:55:16', NULL, NULL, NULL, NULL),
(14, 4, 'institusi', NULL, 'richardo manalu', 'Sinar Jaya', 'Jl.Ir sutami Surakarta', 'Penandatanganan Dokumen', 'sinarjaya sinarjaya', 'luring', '2026-05-13 02:53:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-05-10 12:53:13', '2026-05-10 12:55:32', NULL, NULL, NULL, 'maaf'),
(15, 4, 'institusi', NULL, 'richardo manalu', 'PT. Berkah Jaya', 'jalan berkah 10', 'Penandatanganan Dokumen', 'pembahasan mengenai dokumen nomor 44 tahun 2019 XPPKS74I', 'daring', '2026-07-07 04:55:00', 'approved', NULL, NULL, 'https://www.zoom.com/', NULL, '2026-05-12 05:04:00', '2026-05-10 14:55:33', '2026-05-10 15:04:29', NULL, NULL, NULL, NULL),
(16, 4, 'institusi', NULL, 'richardo manalu', 'amora', 'jalan surya tenggela 2', 'Lainnya', 'pertemuan dan makan malam', 'daring', '2026-05-26 21:37:00', 'approved', NULL, NULL, 'https://www.zoom.com/', NULL, '2026-05-27 21:37:00', '2026-05-11 07:37:09', '2026-05-11 07:38:00', NULL, NULL, NULL, NULL),
(17, 4, 'institusi', NULL, 'richardo manalu', 'Pakuon01', 'Jl. Pakuon 51', 'Penandatanganan Dokumen', 'penandatanganan kerjasama pembangunan Pakuon Mall di Jepang', 'luring', '2026-05-18 21:12:00', 'approved', NULL, NULL, NULL, 'Pejambon nomor 16 Gedung kementerian Luar Negeri', '2026-05-18 21:13:00', '2026-05-12 07:12:29', '2026-05-12 07:13:27', NULL, NULL, NULL, NULL),
(18, 4, 'institusi', NULL, 'richardo manalu', 'Universitas Sebelas Maret', 'Jalan Medan Merdeka 3', 'Penandatanganan Dokumen', 'contoh aja zzzzzzzzzzzzzzz', 'luring', '2026-05-13 22:30:00', 'approved', NULL, NULL, NULL, NULL, '2026-05-13 22:32:00', '2026-05-12 08:31:00', '2026-05-12 08:32:04', NULL, NULL, NULL, NULL),
(19, 4, 'institusi', NULL, 'richardo manalu', 'ESDM', 'Jl.Ir sutami Surakarta', 'Penandatanganan Dokumen', 'zzzzzzzzzzz', 'luring', '2026-05-14 22:33:00', 'approved', NULL, NULL, NULL, 'Pejambon nomor 16 Gedung kementerian Luar Negeri', '2026-05-14 18:34:00', '2026-05-12 08:33:52', '2026-05-12 08:34:50', 'masuk', 'https://maps.app.goo.gl/agNAimMQMQjbxZFX9', NULL, NULL),
(22, 13, 'institusi', NULL, 'Jadi Tau', 'PT.UNS PERKASA', 'Sutami 17', 'Konsultasi TIK', 'Kerjasama magang', 'luring', '2026-06-15 01:46:00', 'approved', NULL, NULL, NULL, 'Jalan soedirman 7', '2026-06-25 00:47:00', '2026-06-10 21:42:37', '2026-06-10 21:49:34', 'Bertemu di lantai 1', NULL, NULL, NULL),
(23, 13, 'institusi', NULL, 'Jadi Tau', 'pt.contoh2', 'contoh saja2', 'Penandatanganan Dokumen', 'contoh contoh', 'luring', '2026-06-18 18:07:00', 'approved', NULL, NULL, NULL, NULL, '2026-07-09 12:06:00', '2026-06-11 04:07:48', '2026-06-30 22:06:42', NULL, NULL, NULL, NULL),
(24, 13, 'institusi', NULL, 'Jadi Tau', 'biasa', 'biasa no8', 'Penandatanganan Dokumen', 'bisa biasa', 'luring', '2026-06-18 18:15:00', 'approved', NULL, NULL, NULL, 'Jalan soedirman 7', '2026-06-18 18:16:00', '2026-06-11 04:15:53', '2026-06-11 04:17:16', 'cuman coba', NULL, NULL, NULL),
(25, 4, 'institusi', NULL, 'richardo manalu', 'pt pasti bisa', 'bisa jaya jaya', 'Penandatanganan Dokumen', 'ayo pasti berjaya', 'luring', '2026-07-10 15:15:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-06-30 22:16:02', '2026-06-30 22:17:34', NULL, NULL, NULL, 'maaf kamu jelek'),
(26, 4, 'institusi', NULL, 'richardo manalu', 'pt bisa bisa', 'bisa yok099', 'Penandatanganan Dokumen', 'kjansdjknkasnd', 'daring', '2026-07-16 17:16:00', 'approved', NULL, NULL, 'https://www.youtube.com/watch?v=MCNOH_ij-Yw&t=88s', NULL, '2026-07-01 14:16:00', '2026-06-30 22:16:31', '2026-06-30 22:17:21', 'baiklah kalo begitu saya ttd kan untuk kamu', NULL, NULL, NULL),
(27, 13, 'institusi', NULL, 'Jadi Tau', 'wokwok', 'wokwok', 'Penandatanganan Dokumen', 'wokwokwok', 'daring', '2026-07-07 21:02:00', 'submitted', NULL, NULL, NULL, NULL, NULL, '2026-07-02 04:02:23', '2026-07-02 04:02:23', NULL, NULL, NULL, NULL),
(28, 13, 'institusi', 16, 'Jadi Tau', 'tedted', 'tedted', 'Penandatanganan Dokumen', 'tedted', 'luring', '2026-07-21 23:02:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-07-02 04:02:52', '2026-07-02 05:31:24', NULL, NULL, NULL, 'ga ah'),
(29, 8, 'institusi', 16, 'Saurdot Lumban Gaol', 'coba janji temu', 'jalan manuk dadali 7', 'Penandatanganan Dokumen', 'tanda tangan urgent', 'luring', '2026-07-24 07:12:00', 'approved', NULL, NULL, NULL, 'Jalan soedirman 7', '2026-07-22 02:18:00', '2026-07-19 12:12:21', '2026-07-19 12:18:45', 'bawa ktp dan akte kelahiran', 'https://www.google.com/maps/place/UNS+Universitas+Sebelas+Maret,+Pucangsawit,+Kec.+Jebres,+Kota+Surakarta,+Jawa+Tengah+57125/@-7.5653271,110.8534737,17z/data=!3m1!4b1!4m6!3m5!1s0x2e7a1700177f63d7:0x746cf2bda7c5b6a1!8m2!3d-7.5653324!4d110.8560486!16s%2Fg%2F11p01t30k_?entry=ttu&g_ep=EgoyMDI2MDYwMy4xIKXMDSoASAFQAw%3D%3D', NULL, NULL),
(30, 8, 'institusi', 16, 'Saurdot Lumban Gaol', 'uji coba 2', 'magetan 87', 'Penandatanganan Dokumen', 'ttd pertemuan kunjungan mahasiswa', 'daring', '2026-07-29 02:21:00', 'rejected', NULL, NULL, NULL, NULL, NULL, '2026-07-19 12:21:10', '2026-07-19 12:23:48', NULL, NULL, NULL, 'maaf ya gak dulu'),
(31, 8, 'institusi', 16, 'Saurdot Lumban Gaol', 'uji coba 3', 'manhatan 27', 'Penandatanganan Dokumen', 'pertemuan janji megang 22 mahasiswa', 'luring', '2026-07-31 02:21:00', 'approved', NULL, NULL, NULL, 'Jalan soedirman 7', '2026-07-31 08:23:00', '2026-07-19 12:21:57', '2026-07-19 12:23:35', 'bawa surat pengantar', 'https://www.google.com/maps/place/UNS+Universitas+Sebelas+Maret,+Pucangsawit,+Kec.+Jebres,+Kota+Surakarta,+Jawa+Tengah+57125/@-7.5653271,110.8534737,17z/data=!3m1!4b1!4m6!3m5!1s0x2e7a1700177f63d7:0x746cf2bda7c5b6a1!8m2!3d-7.5653324!4d110.8560486!16s%2Fg%2F11p01t30k_?entry=ttu&g_ep=EgoyMDI2MDYwMy4xIKXMDSoASAFQAw%3D%3D', NULL, NULL),
(32, 8, 'institusi', 16, 'Saurdot Lumban Gaol', 'uji coba terakhir', 'penolakan 89', 'Penandatanganan Dokumen', 'tolak ya', 'daring', '2026-07-30 02:22:00', 'approved', NULL, NULL, 'https://www.youtube.com/watch?v=MCNOH_ij-Yw&t=88s', NULL, '2026-07-27 02:22:00', '2026-07-19 12:22:24', '2026-07-19 12:22:59', 'woke bawa kk', NULL, NULL, NULL),
(33, 4, 'institusi', 16, 'richardo manalu', 'dari TA', 'siapa saja 87', 'Penandatanganan Dokumen', 'uji coba, bawa KTP dan KARTU KELUARGA', 'daring', '2026-07-29 11:31:00', 'approved', NULL, NULL, 'https://www.youtube.com/watch?v=MCNOH_ij-Yw&t=88s', NULL, '2026-07-30 05:32:00', '2026-07-19 21:32:05', '2026-07-19 21:32:51', 'jangan lupa bawa KTP dan Kartu Keluarga', NULL, NULL, NULL),
(34, 4, 'institusi', 16, 'richardo manalu', 'pt TA', 'TA 78', 'Penandatanganan Dokumen', 'TA nih', 'luring', '2026-07-28 11:35:00', 'approved', NULL, NULL, NULL, 'Jalan soedirman 7', '2026-07-29 04:36:00', '2026-07-19 21:35:39', '2026-07-19 21:36:19', 'jangan terlambat dan bawa ktp', 'https://www.google.com/maps/place/UNS+Universitas+Sebelas+Maret,+Pucangsawit,+Kec.+Jebres,+Kota+Surakarta,+Jawa+Tengah+57125/@-7.5653271,110.8534737,17z/data=!3m1!4b1!4m6!3m5!1s0x2e7a1700177f63d7:0x746cf2bda7c5b6a1!8m2!3d-7.5653324!4d110.8560486!16s%2Fg%2F11p01t30k_?entry=ttu&g_ep=EgoyMDI2MDYwMy4xIKXMDSoASAFQAw%3D%3D', NULL, NULL),
(35, 4, 'institusi', NULL, 'richardo manalu', 'dari TA', 'siapa saja 878', 'Penandatanganan Dokumen', 'hanya contoh saja nih buat finalisaasi', 'luring', '2026-08-18 03:53:00', 'submitted', NULL, NULL, NULL, NULL, NULL, '2026-07-26 13:53:48', '2026-07-26 13:53:48', NULL, NULL, NULL, NULL),
(36, 4, 'institusi', NULL, 'richardo manalu', 'Presiden', 'Jl. Intiraksi 55', 'Konsultasi TIK', 'contoh ke 2 buat finalisasi', 'daring', '2026-08-31 03:54:00', 'submitted', NULL, NULL, NULL, NULL, NULL, '2026-07-26 13:54:19', '2026-07-26 13:54:19', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `beritas`
--

CREATE TABLE `beritas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `kategori` enum('Dalam Negeri','Mancanegara','Kerjasama') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `lead` text NOT NULL,
  `body` longtext NOT NULL,
  `closing` text DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `revisi_ke` int(11) NOT NULL DEFAULT 0,
  `riwayat_revisi` text DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `beritas`
--

INSERT INTO `beritas` (`id`, `admin_id`, `kategori`, `foto`, `judul`, `tanggal`, `lokasi`, `lead`, `body`, `closing`, `status`, `revisi_ke`, `riwayat_revisi`, `views`, `alasan_penolakan`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dalam Negeri', 'berita_foto/AteB1nmzqjCTEVmsovUgEfGcrEpLUQcTr5hc4a5e.png', 'Indonesia dan Jepang Teken Kerjasama Strategis Pengembangan Ekosistem Kendaraan Listrik', '2026-05-10', 'Gedung Kementerian Koordinator Bidang Kemaritiman dan Investasi, Jakarta Pusat', 'Pemerintah Indonesia dan Jepang resmi menandatangani Nota Kesepahaman (MoU) tentang kerjasama pengembangan ekosistem kendaraan listrik (EV) di Jakarta, Jumat (15/5). Kerjasama yang mencakup transfer teknologi, investasi pembangunan pabrik baterai, serta pengembangan sumber daya manusia ini ditargetkan dapat mempercepat transisi energi hijau di Indonesia sekaligus membuka lapangan kerja bagi 50.000 tenaga kerja lokal hingga tahun 2030.', 'Menteri Koordinator Bidang Kemaritiman dan Investasi, Luhut Binsar Pandjaitan, menjelaskan bahwa kerjasama ini merupakan tindak lanjut dari komitmen kedua negara dalam KTT G7 yang lalu. \"Jepang adalah mitra strategis Indonesia dalam pengembangan industri hijau. Dengan investasi senilai 2,5 miliar dolar AS dari Toyota, Mitsubishi, dan Panasonic, kita akan membangun pabrik baterai lithium terbesar di Asia Tenggara yang berlokasi di Morowali, Sulawesi Tengah,\" ujar Luhut dalam sambutannya.\r\n\r\nDuta Besar Jepang untuk Indonesia, Masaki Yasushi, menambahkan bahwa pihaknya sangat mengapresiasi komitmen pemerintah Indonesia dalam menciptakan iklim investasi yang kondusif. \"Kami tidak hanya membawa modal, tetapi juga teknologi terbaru dalam daur ulang baterai dan sistem manajemen energi. Ini adalah masa depan industri otomotif,\" ungkapnya dalam konferensi pers yang sama.\r\n\r\nDalam kesepakatan tersebut, terdapat tiga pilar utama kerjasama. Pertama, pembangunan pabrik baterai EV dengan kapasitas produksi 10 gigawatt-hour (GWh) per tahun yang ditargetkan beroperasi pada awal 2028. Kedua, program pendidikan vokasi bagi 5.000 insinyur muda Indonesia yang akan dikirim ke Jepang untuk magang selama dua tahun. Ketiga, pengembangan stasiun pengisian kendaraan listrik umum (SPKLU) di 100 titik di sepanjang jalur tol Trans-Jawa dan Sumatera.\r\n\r\nSementara itu, Menteri Perindustrian Agus Gumiwang Kartasasmita menyatakan bahwa pemerintah akan memberikan insentif fiskal berupa tax holiday selama 10 tahun bagi perusahaan Jepang yang berinvestasi di sektor ini. \"Insentif ini adalah bentuk keseriusan kita. Target kita bukan hanya pasar domestik, tetapi menjadikan Indonesia sebagai hub ekspor EV untuk kawasan Asia Pasifik,\" tegasnya.\r\n\r\nReaksi positif juga datang dari kalangan pengusaha. Ketua Umum Kamar Dagang dan Industri (Kadin) Indonesia, Arsjad Rasjid, menilai kerjasama ini akan mendorong pertumbuhan ekonomi nasional. \"Ini adalah momentum emas. Transfer teknologi dari Jepang akan melompatkan kapasitas industri dalam negeri, terutama di sektor hilirisasi nikel yang selama ini menjadi andalan kita,\" komentarnya.', 'Sebagai informasi tambahan, pemerintah Jepang melalui Japan International Cooperation Agency (JICA) juga berkomitmen untuk memberikan hibah senilai 50 juta dolar AS bagi pembangunan pusat penelitian dan pengembangan (R&D) energi terbarukan di kawasan PIK, Jakarta Utara. Kerjasama ini dijadwalkan akan ditindaklanjuti dengan pertemuan teknis bilateral di Tokyo pada bulan Juli mendatang untuk membahas detail implementasi di lapangan.', 'approved', 0, NULL, 0, NULL, '2026-05-11 07:41:50', '2026-05-11 07:42:27'),
(2, 2, 'Dalam Negeri', 'berita_foto/EYLasGoRpxBbgGibGpStkI779yycgCR7hwlrJD4V.png', 'Mencintai Mama', '2026-06-12', 'Jakarta, Indonesia', 'Ucapan manis tersebut tidak dapat dijadikan lead berita karena tidak terkait dengan peristiwa atau fakta yang layak diliput. Lead berita harus menyampaikan informasi penting dan akurat tentang suatu peristiwa atau kejadian.', 'i love u mom', 'assalamualaikum', 'approved', 0, NULL, 0, NULL, '2026-06-10 11:28:55', '2026-06-10 11:29:55'),
(3, 2, 'Dalam Negeri', 'berita_foto/BEXwGp5dc3DDMxw3RlsynVYXhJYECHJaQVIXXoAj.png', 'Roblox bagi gen A', '2026-06-19', 'Surakarta, Indonesia', 'Presiden AS Donald Trump dituduh sebagai narator yang tidak dapat dipercaya dalam konflik AS-Iran, karena dia terus membuat pernyataan yang kontradiktif tentang situasi konflik. Meskipun Trump mengklaim \"kemenangan lengkap\" atas Irak, serangan-serangan dari Iran terus berlanjut, termasuk penembakan helikopter Apache AS oleh drone Irak.', 'As the story of the US-Iran war is written direct to social media, Donald Trump may be the genre’s premier unreliable narrator.\r\n\r\nSince the war began, Trump has again and again threatened Iran with fearsome consequences if Tehran doesn’t come to the table and sign a peace deal that the US president said was imminent weeks ago. And he has also repeatedly claimed that an Iran deal is “close” – without any result. (A CNN tally put the number of times he’s claimed it at 38.)\r\n\r\nNever mind that the US has already claimed “complete victory” in the conflict and Trump has attacked reporters who have questioned the wisdom of the intervention, particularly as the strait of Hormuz remains closed to more than 20% of global oil traffic.\r\n\r\n\r\nEven so, he continues to seek to have it both ways: both declaring Iran vanquished and painting the country’s stubbornness as the reason why he can’t sign a peace deal and end the conflict.\r\n\r\n“The Bully of the Middle East is DEAD!!!” he wrote in a missive on Monday. “They’ve taken too long to negotiate a deal that would have been great for them, now they will have to pay the price!!!”\r\n\r\nThe US president was posting after a US Apache helicopter was downed off the coast of Oman by an Iranian drone, despite claims from both Trump and the Pentagon chief, Pete Hegseth, that Iran “[doesn’t] have anti-aircraft, they don’t have radar”.\r\n\r\nThat does not quite seem the case. Iran’s missile and drone attacks have continued against nearby US allies in Kuwait, Bahrain and Jordan. In retaliation for the downing of the Apache helicopter, the US managed to strike more than 20 targets in Iran including radar and anti-aircraft sites, according to US officials.', 'Assalamualaikum', 'approved', 0, NULL, 0, NULL, '2026-06-10 12:04:53', '2026-06-30 22:05:52'),
(4, 2, 'Dalam Negeri', 'berita_foto/a0aniizOrtspCU9he1Z0X71htrt6SYooczoIca1s.png', 'Trumpt has fallent', '2026-06-16', 'Surakarta, Indonesia', 'Ketegangan di Timur Tengah meningkat setelah serangan Amerika Serikat terhadap target di Iran, diikuti dengan serangan balasan Iran terhadap pangkalan udara di Kuwait dan Bahrain. Kuwait menutup ruang udaranya karena \"agresi Iran\" sementara Israel memperingatkan tentang peluncuran roket dari Lebanon ke komunitas di utara Israel.', 'Kuwait menutup ruang udaranya pada hari Kamis waktu setempat karena \"agresi Iran\" saat mereka mengintersep \"sasaran udara musuh\", setelah serangan Amerika Serikat terhadap Teheran, menandai meningkatnya ketegangan di Timur Tengah.\r\n\r\nKomando Pertahanan Dalam Negeri Israel juga memperingatkan tentang peluncuran dari Lebanon menuju beberapa komunitas di utara Israel.\r\n\r\nIran \"menyerang dan menghancurkan delapan belas target penting\" milik pasukan Amerika Serikat di pangkalan udara Ali Salem dan Ahmad al-Jaber di Kuwait, serta pangkalan udara Sheikh Issa di Bahrain, menurut kantor berita Tasnim yang dikelola negara. Kementerian Dalam Negeri Bahrain sebelumnya mengatakan bahwa sirene telah dibunyikan dan meminta warga sipil untuk menuju ke tempat yang aman.\r\n\r\nEscalasi ini mengikuti serangan Amerika Serikat terhadap beberapa target di Iran pada hari Rabu waktu setempat di bawah arahan Presiden Donald Trump, setelah \"agresi Iran yang tidak dapat dibenarkan dan berkelanjutan\".\r\n\r\nMarkas Besar Komando Sentral (Centcom) mengatakan serangan telah selesai pada pukul 21.04 ET hari Rabu, menambahkan bahwa mereka menyerang kemampuan pengawasan militer Iran, sistem komunikasi, dan situs pertahanan udara. Pasukan Amerika Serikat menembaki target Iran yang \"menimbulkan ancaman terhadap pasukan Amerika Serikat dan kapal komersial internasional yang melintas perairan regional\".\r\n\r\nMedia negara Iran sebelumnya melaporkan bahwa Iran telah menargetkan kapal Amerika Serikat di Selat Hormuz dengan serangan rudal dan drone. Kemudian, Reuters melaporkan bahwa komando militer atas Iran menutup sepenuhnya Selat Hormuz, memperingatkan bahwa setiap kapal yang mencoba melintas akan menjadi target.\r\n\r\nTrump kemudian mengatakan kepada Fox News bahwa dia berbicara langsung dengan pejabat Iran, yang dia katakan meminta dia untuk menghentikan serangan. Dia mengatakan bahwa pemboman akan segera berhenti dan bahwa Israel tidak terlibat dalam serangan, tetapi membuka kemungkinan tindakan militer lebih lanjut, menurut Fox.\r\n\r\nDalam menanggapi pertanyaan tentang apakah gencatan senjata telah berakhir, Trump dilaporkan mengatakan bahwa itu adalah gencatan senjata yang paling dilanggar dalam sejarah.\r\n\r\nSerangan ini terjadi setelah Trump sebelumnya mengatakan pada hari Rabu bahwa Amerika Serikat akan menyerang Iran \"sangat keras\" lagi, meningkatkan ancaman publiknya saat dia mendesak Teheran untuk menandatangani kesepakatan.\r\n\r\n\"Kami menyerang mereka keras kemarin, dan kami akan menyerang mereka keras lagi hari ini,\" kata Trump dalam acara penandatanganan Secure America Act di Gedung Putih. \"Kami akan menyerang mereka dan menyerang mereka sangat keras.\"\r\n\r\nTrump mengatakan Iran \"harus menandatangani kesepakatan\" dan mengatakan bahwa Amerika Serikat ingin mencapai kesepakatan \"yang bermakna dan efektif\".\r\n\r\n\"Kita lihat apa yang terjadi dengan kesepakatan,\" kata Trump.\r\n\r\nDalam menanggapi pada hari Rabu siang, kepala komisi keamanan nasional di parlemen Iran, Ebrahim Azizi, menulis bahwa \"kali ini, perang tidak akan terbatas pada wilayah\", dalam sebuah postingan di X.\r\n\r\nKomentar ini muncul setelah Trump memperingatkan di Truth Social bahwa Iran telah memakan waktu terlalu lama untuk bernegosiasi dan akan \"membayar harga\" di tengah meningkatnya ketegangan militer antara Washington dan Teheran.\r\n\r\n\"Militer Iran adalah kekacauan total dan lengkap,\" tulis Trump pada hari Rabu pagi. \"Sebagian besar dari mereka, seperti Angkatan Laut dan Angkatan Udara mereka, bahkan tidak ada lagi — Mereka telah dikalahkan sepenuhnya. Iran hanya bicara dan tidak ada tindakan.\"', 'Assalamualaikum', 'approved', 0, NULL, 0, NULL, '2026-06-10 22:00:13', '2026-06-10 22:01:55'),
(5, 2, 'Dalam Negeri', 'berita_foto/X5JWMkU1EymwmHNdY63BKUgaLTBk7WrHGZSdxYk7.png', 'hanya percobaan', '2026-06-17', 'Surakarta, Indonesia', 'Ketegangan di Timur Tengah meningkat setelah serangan Amerika Serikat terhadap beberapa target di Iran, menyebabkan Iran melakukan serangan balasan terhadap pangkalan udara milik Amerika Serikat di Kuwait dan Bahrain. Serangan ini memicu penutupan ruang udara Kuwait dan peringatan dari Komando Pertahanan Dalam Negeri Israel tentang peluncuran roket dari Lebanon menuju komunitas di utara Israel.', 'Kuwait menutup ruang udaranya pada hari Kamis waktu setempat karena \"agresi Iran\" ketika mereka menyergap \"sasaran udara musuh\", setelah serangan Amerika Serikat terhadap Tehran, menandai meningkatnya ketegangan di Timur Tengah.\r\n\r\nKomando Pertahanan Dalam Negeri Israel juga memperingatkan tentang peluncuran dari Lebanon menuju beberapa komunitas di utara Israel.\r\n\r\nIran \"menyerang dan menghancurkan delapan belas target penting\" milik pasukan Amerika Serikat di pangkalan udara Ali Salem dan Ahmad al-Jaber di Kuwait, serta pangkalan udara Sheikh Issa di Bahrain, menurut kantor berita Tasnim yang dikelola negara. Kementerian Dalam Negeri Bahrain sebelumnya mengatakan bahwa sirine telah dibunyikan dan meminta warga sipil untuk pergi ke tempat yang aman.\r\n\r\n Eskalasi ini terjadi setelah serangan Amerika Serikat terhadap beberapa target di Iran pada hari Rabu waktu setempat atas perintah Presiden Donald Trump, setelah \"agresi tidak provokatif dan terus-menerus Iran\".\r\n\r\nCentcom mengatakan serangan tersebut selesai pada pukul 21:04 ET hari Rabu, menambahkan bahwa mereka menyerang kemampuan pengawasan militer Iran, sistem komunikasi, dan situs pertahanan udara. Pasukan Amerika Serikat menyerang target Iran yang \"menimbulkan ancaman bagi pasukan Amerika Serikat dan kapal komersial internasional yang melintas perairan regional\".\r\n\r\nMedia negara Iran sebelumnya melaporkan bahwa Iran telah menyerang kapal Amerika Serikat di Selat Hormuz dengan serangan rudal dan drone. Kemudian, Reuters melaporkan bahwa komando militer teratas Iran menutup seluruhnya Selat Hormuz, memperingatkan bahwa setiap kapal yang mencoba melintas akan menjadi target.\r\n\r\nTrump kemudian mengatakan kepada Fox News bahwa dia berbicara langsung dengan pejabat Iran, yang dia katakan meminta dia untuk menghentikan serangan. Dia mengatakan pengeboman akan segera berhenti dan bahwa orang-orang Israel tidak terlibat dalam serangan, tetapi membuka kemungkinan tindakan militer lebih lanjut, menurut Fox.\r\n\r\nSebagai tanggapan atas pertanyaan tentang apakah gencatan senjata telah berakhir, Trump dilaporkan mengatakan bahwa itu adalah gencatan senjata yang paling dilanggar dalam sejarah.\r\n\r\nSerangan ini terjadi setelah Trump mengatakan sebelumnya pada hari Rabu bahwa Amerika Serikat akan menyerang Iran \"sangat keras\" lagi, meningkatkan ancaman publiknya ketika dia mendesak Tehran untuk menandatangani kesepakatan.\r\n\r\n\"Kami menyerang mereka keras kemarin, dan kami akan menyerang mereka keras lagi hari ini,\" Trump mengatakan dalam acara penandatanganan Secure America Act di Gedung Putih. \"Kami akan menyerang mereka dan menyerang mereka dengan sangat keras.\"\r\n\r\nTrump mengatakan bahwa Iran \"seharusnya menandatangani kesepakatan\" dan bahwa Amerika Serikat menginginkan kesepakatan \"yang bermakna dan efektif\".\r\n\r\n\"Kita lihat apa yang terjadi dengan kesepakatan,\" Trump mengatakan.\r\n\r\nSebagai tanggapan pada hari Rabu siang, kepala komisi keamanan nasional di parlemen Iran, Ebrahim Azizi, menulis bahwa \"kali ini, perang tidak akan terbatas pada wilayah\", dalam pos di X.\r\n\r\nKomentar ini datang setelah Trump memperingatkan di Truth Social bahwa Iran telah terlalu lama untuk bernegosiasi dan akan \"membayar harga\" di tengah meningkatnya ketegangan militer antara Washington dan Tehran.\r\n\r\n\"Militer Iran adalah kekacauan total dan lengkap,\" Trump menulis pada hari Rabu pagi. \"Sebagian besar dari mereka, seperti Angkatan Laut dan Angkatan Udara, bahkan tidak ada lagi - Mereka telah dikalahkan secara total. Iran hanya bicara dan tidak ada tindakan.\"', 'terimakasih sudah membaca', 'approved', 0, NULL, 0, NULL, '2026-06-11 04:20:34', '2026-06-11 04:22:21'),
(6, 2, 'Dalam Negeri', 'berita_foto/inK9kRjXWaNo2u5I1sk9kk9DCvHpKFhl58KtJMmQ.jpg', 'berita politik indo', '2026-07-01', 'Surakarta, Indonesia', 'Berikut adalah ringkasan padat atau lead berita tentang Politik Daerah:\r\nPolitik Daerah merupakan bentuk pemerintahan yang berfokus pada pengelolaan urusan internal di wilayah tertentu, seperti kota, kabupaten, atau provinsi, dengan tujuan meningkatkan kualitas hidup masyarakat. Dalam prakteknya, Politik Daerah melibatkan berbagai aktor dan lembaga untuk mencapai tujuan tersebut, sehingga berkontribusi pada pembangunan nasional dan kemajuan bangsa.', 'Politik Daerah adalah suatu bentuk pemerintahan yang memiliki yurisdiksi dan wewenang untuk mengatur dan mengelola urusan internal di dalam batas-batas wilayah tertentu, seperti kota, kabupaten, atau provinsi. Dalam konteks ini, Politik Daerah berfokus pada isu-isu dan kebijakan yang terkait dengan pemerintahan lokal, seperti penyediaan layanan publik, pengembangan infrastruktur, pengelolaan sumber daya alam, dan promosi ekonomi lokal.\r\n\r\nDalam prakteknya, Politik Daerah melibatkan berbagai aktor dan lembaga, termasuk pemerintah daerah, dewan perwakilan rakyat daerah, organisasi masyarakat sipil, dan warga masyarakat secara umum. Proses pengambilan keputusan dalam Politik Daerah biasanya melibatkan proses musyawarah, perundingan, dan penyusunan kebijakan yang mempertimbangkan kepentingan dan aspirasi masyarakat setempat.\r\n\r\nTujuan utama dari Politik Daerah adalah untuk meningkatkan kualitas hidup masyarakat, mempromosikan kesetaraan dan keadilan, serta memastikan bahwa kebijakan dan program pemerintah daerah berjalan efektif dan efisien. Dalam konteks yang lebih luas, Politik Daerah juga berkontribusi pada pembangunan nasional dan kemajuan bangsa.', 'alsdnkjandkj aksjndajkndaajkdn', 'approved', 0, NULL, 0, NULL, '2026-06-30 22:11:32', '2026-06-30 22:23:21'),
(7, 2, 'Dalam Negeri', 'berita_foto/pbzYNHWXX777toqQ3o5eznv96b7LC0P3poKhCeEW.jpg', 'contoh berita aja', '2026-07-02', 'Surakarta, Indonesia', 'Pemerintah Indonesia meluncurkan program baru untuk meningkatkan kemampuan bahasa Inggris di sekolah-sekolah di seluruh negeri sebagai upaya meningkatkan kualitas pendidikan dan mempersiapkan generasi muda untuk bersaing di era globalisasi. Program ini akan berfokus pada peningkatan kemampuan bahasa Inggris guru-guru dan siswa, serta pengembangan kurikulum yang lebih efektif dengan dukungan sumber daya dan fasilitas yang memadai.', 'Pemerintah Indonesia Meluncurkan Program Baru untuk Meningkatkan Kemampuan Bahasa Inggris di Sekolah \r\n\r\n Jakarta, Indonesia - Pemerintah Indonesia baru-baru ini meluncurkan program baru yang bertujuan untuk meningkatkan kemampuan bahasa Inggris di sekolah-sekolah di seluruh negeri. Program ini merupakan bagian dari upaya pemerintah untuk meningkatkan kualitas pendidikan dan mempersiapkan generasi muda Indonesia untuk bersaing di era globalisasi.\r\n\r\nProgram ini akan berfokus pada peningkatan kemampuan bahasa Inggris guru-guru dan siswa, serta pengembangan kurikulum yang lebih efektif. Pemerintah juga akan menyediakan sumber daya dan fasilitas yang memadai untuk mendukung program ini.\r\n\r\nMenurut Menteri Pendidikan dan Kebudayaan, program ini diharapkan dapat meningkatkan kemampuan bahasa Inggris siswa Indonesia dan mempersiapkan mereka untuk bersaing di tingkat internasional. \"Kemampuan bahasa Inggris yang baik sangat penting untuk kesuksesan di era globalisasi,\" kata Menteri.\r\n\r\nProgram ini juga akan berkolaborasi dengan organisasi internasional dan lembaga pendidikan untuk memperoleh pengalaman dan pengetahuan terbaru dalam pengajaran bahasa Inggris. Dengan demikian, diharapkan program ini dapat memberikan hasil yang signifikan dan mendukung kemajuan pendidikan di Indonesia.', 'dnjandkj djkfnk dskjan ajdsfn', 'rejected', 0, NULL, 0, 'jelek', '2026-06-30 22:12:11', '2026-06-30 22:23:15'),
(8, 2, 'Dalam Negeri', 'berita_foto/VoVx7CyBqVFPHcAJzYhdyJve1U5fP7lkNm41FPms.jpg', 'pasti bisa', '2026-07-23', 'jogja, jawa tengah', 'Dalam pertandingan bola yang tak terduga, seekor kelinci yang cerdas dan gesit tiba-tiba menjadi pemain bintang dan membawa timnya meraih kemenangan telak dengan skor yang mengagumkan. Kecepatan dan kelincahan kelinci tersebut membuat tim lawan kehilangan fokus dan tidak dapat menandingi serangan-serangan yang dilancarkannya.', 'Seekor Kelinci Menjadi Pemain Bola yang Handal dan Membuat Tim Lawan Kalah dengan Skor Telak.', 'ksldnkjna asdjknad', 'approved', 0, NULL, 2, NULL, '2026-06-30 22:13:23', '2026-07-02 04:47:23'),
(9, 16, 'Dalam Negeri', 'berita_foto/q7xxErthvyoEHc65W3CHZQ2lK9k4d32Dezrsgu7v.jpg', 'opatur', '2026-07-02', 'jogja, jawa tengah', 'Seekor kucing bernama \"Malam\" di sebuah kota kecil di Amerika menjadi viral di media sosial karena keahliannya mencuri makanan di rumah-rumah tetangga dengan kemampuan membuka pintu dan jendela. Kebiasaan kucing Malam ini telah membuat warga sekitar tertawa dan terhibur, namun pemiliknya juga mengingatkan bahwa kebiasaan ini tidak boleh diikuti oleh kucing lain.', 'Kucing Pencuri Makanan di Tengah Malam Menjadi Viral di Media Sosial\r\n\r\nJakarta - Seekor kucing yang memiliki kebiasaan mencuri makanan di rumah-rumah tetangga di sebuah kota kecil di Amerika telah menjadi sensasi di media sosial. Kucing yang diberi nama \"Malam\" ini memiliki keahlian yang luar biasa dalam mencuri makanan tanpa meninggalkan jejak.\r\n\r\nMenurut pemilik rumah yang menjadi korban pencurian makanan, kucing Malam memiliki kemampuan untuk membuka pintu dan jendela dengan mudah, sehingga dia dapat masuk ke rumah-rumah tanpa kesulitan. Setelah itu, dia akan mencari makanan yang lezat dan memakannya dengan lahap.\r\n\r\nKebiasaan kucing Malam ini telah membuat warga sekitar tertawa dan terhibur. Banyak dari mereka yang sengaja meninggalkan makanan di luar rumah untuk kucing Malam, hanya untuk melihatnya memakan makanan tersebut dengan gembira.\r\n\r\nSaat ini, kucing Malam telah menjadi bintang di media sosial, dengan banyak orang yang membagikan video dan foto tentang keahlian mencurinya. Namun, pemilik kucing Malam mengingatkan bahwa kebiasaan ini tidak boleh diikuti oleh kucing lain, karena dapat menyebabkan kerusakan pada properti dan makanan orang lain.', 'ajwknkjn adcsklndjkn', 'approved', 0, NULL, 2, NULL, '2026-07-02 03:33:26', '2026-07-02 04:47:18'),
(10, 16, 'Dalam Negeri', 'berita_foto/R5uHpY1wzcBL2RylzLChNT8L7XgHXkMUNGrtVCBn.png', 'berita nih', '2026-07-02', 'labuanbajo, papuaa', 'Perkembangan teknologi informasi terus berlanjut dengan pesat, meningkatkan efisiensi dan kemampuan melalui inovasi seperti Internet of Things (IoT) dan kecerdasan buatan (AI). Namun, perkembangan ini juga menimbulkan tantangan baru, seperti keamanan data dan privasi, yang memerlukan upaya kolaboratif dari para ahli untuk menciptakan solusi yang lebih aman dan efektif.o', 'Perkembangan Teknologi Informasi Terbaru: Meningkatkan Efisiensi dan Kemampuan Menghadapi Tantangan Global\r\n\r\nDalam beberapa tahun terakhir, teknologi informasi telah mengalami perkembangan yang sangat pesat. Dari pengembangan aplikasi pintar hingga penggunaan kecerdasan buatan, banyak inovasi yang telah dilakukan untuk meningkatkan efisiensi dan kemampuan dalam menghadapi tantangan global.\r\n\r\nTeknologi Internet of Things (IoT) merupakan salah satu contoh perkembangan teknologi informasi yang sangat signifikan. Dengan kemampuan untuk menghubungkan berbagai perangkat dan memungkinkan mereka untuk berkomunikasi satu sama lain, IoT telah membuka peluang baru untuk meningkatkan efisiensi dan produktivitas dalam berbagai sektor, seperti industri, kesehatan, dan transportasi.k\r\n\r\nSelain itu, kecerdasan buatan (AI) juga telah menjadi salah satu fokus utama dalam perkembangan teknologi informasi. Dengan kemampuan untuk menganalisis data besar dan membuat keputusan berdasarkan pola yang ditemukan, AI telah digunakan dalam berbagai aplikasi, seperti asisten virtual, sistem rekomendasi, dan diagnosa penyakit.\r\n\r\nNamun, perkembangan teknologi informasi juga menyajikan tantangan baru, seperti keamanan data dan privasi. Dengan meningkatnya penggunaan teknologi, risiko keamanan data juga meningkat. Oleh karena itu, perlu dilakukan upaya untuk meningkatkan keamanan data dan melindungi privasi pengguna.p\r\n\r\nDalam menghadapi tantangan ini, para ahli dan pengembang teknologi terus bekerja sama untuk menciptakan solusi yang lebih aman dan efektif. Dengan demikian, perkembangan teknologi informasi diharapkan dapat terus meningkatkan efisiensi dan kemampuan dalam menghadapi tantangan global, serta membuka peluang baru untuk meningkatkan kualitas hidup masyarakat.', 'sekian makasihhl', 'pending', 0, NULL, 0, NULL, '2026-07-03 03:26:53', '2026-07-03 07:58:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-balmond@test.com|127.0.0.1', 'i:1;', 1790156056),
('laravel-cache-balmond@test.com|127.0.0.1:timer', 'i:1790156056;', 1790156056),
('laravel-cache-opungmangatur@gmail.com|127.0.0.1', 'i:1;', 1790155893),
('laravel-cache-opungmangatur@gmail.com|127.0.0.1:timer', 'i:1790155893;', 1790155893),
('laravel-cache-richardogilbert@gmail.com|127.0.0.1', 'i:1;', 1785148277),
('laravel-cache-richardogilbert@gmail.com|127.0.0.1:timer', 'i:1785148277;', 1785148277);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_07_015454_create_user_profiles_table', 1),
(5, '2026_05_07_015519_create_appointments_table', 1),
(6, '2026_05_07_015528_create_mou_pks_table', 1),
(7, '2026_05_07_015536_create_tik_kemlu_table', 1),
(8, '2026_05_07_015546_create_tik_non_kemlu_table', 1),
(9, '2026_05_07_015556_create_activity_logs_table', 1),
(10, '2026_05_07_084858_add_detail_columns_to_appointments_table', 1),
(11, '2026_05_07_123533_add_feedback_to_kebijakan_tables', 1),
(12, '2026_05_07_151407_fix_all_missing_columns', 1),
(13, '2026_05_07_155753_add_google_id_to_users_table', 2),
(14, '2026_05_11_124819_create_beritas_table', 3),
(15, '2026_07_02_093543_add_tahap2_columns_to_tables', 4),
(16, '2026_07_03_103453_ubah_kolom_status_menjadi_string', 5),
(17, '2026_07_19_191726_perbesar_kolom_link_di_appointments', 6),
(18, '2026_07_26_172341_tambah_file_berita_acara_ke_kebijakan', 7),
(19, '2026_07_26_175254_perbarui_enum_role_di_users', 8),
(20, '2026_07_26_184811_tambah_berita_acara_ke_appointments', 9),
(21, '2026_07_26_195935_tambah_kolom_reviewer_ke_tabel_kebijakan', 10),
(22, '2026_07_26_210308_tambah_tipe_pemohon_ke_appointments', 11),
(23, '2026_07_26_220111_tambah_kolom_riwayat_revisi_ke_tabel_dokumen', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mou_pks`
--

CREATE TABLE `mou_pks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tim_hukum_id` bigint(20) UNSIGNED DEFAULT NULL,
  `super_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis` enum('MoU','PKS') NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `satker_kemlu` varchar(255) NOT NULL,
  `instansi_external` varchar(255) NOT NULL,
  `tanggal_disahkan` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `revisi_ke` int(11) NOT NULL DEFAULT 0,
  `riwayat_revisi` text DEFAULT NULL,
  `file_berita_acara` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alasan_penolakan` text DEFAULT NULL,
  `keterangan_tambahan` text DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mou_pks`
--

INSERT INTO `mou_pks` (`id`, `admin_id`, `tim_hukum_id`, `super_admin_id`, `jenis`, `perihal`, `satker_kemlu`, `instansi_external`, `tanggal_disahkan`, `tanggal_berakhir`, `status`, `revisi_ke`, `riwayat_revisi`, `file_berita_acara`, `keterangan`, `created_at`, `updated_at`, `alasan_penolakan`, `keterangan_tambahan`, `views`) VALUES
(1, NULL, NULL, NULL, 'MoU', 'PENGAMANAN BERSAMA SISTEM DAN KEBIJAKAN TEKNOLOGI INFORMASI DAN KOMUNIKASI (TIK) LINGKUP KEMENTERIAN LUAR NEGERI DENGAN SISTEM EKSTERNAL NON-KEMENTERIAN LUAR NEGERI', 'Sekretaris Jenderal Kementerian Luar Negeri Republik Indonesia', 'NOMOR: 01/MOU/KEMLU/IX/2024', '2026-05-28', '2026-07-16', 'aktif', 0, NULL, NULL, 'Arahan Sekertaris Kepresidenan', '2026-05-07 08:34:16', '2026-05-07 08:39:10', NULL, 'mohon utus orang untuk melakukan perpanjangan perjanjian', 0),
(2, NULL, NULL, NULL, 'MoU', 'Kerjasama 100 kapal Induk Prancis', 'Sekretaris Jenderal Kementerian Luar Negeri Republik Indonesia', 'BPK', '2026-05-08', '2026-05-15', 'aktif', 0, NULL, NULL, 'Pemeriksaan Keuangan Proyek Hibah Kapal Induk dari Prancis Sejumlah 100 unit kapal', '2026-05-08 01:29:58', '2026-05-08 01:33:50', NULL, 'kawal tiap proses audit keuangan tersebut', 0),
(3, NULL, NULL, NULL, 'MoU', 'Pengamanan Bersama Wilayah Udara Inonesia-Australia', 'Dirjen Kedaulatan Dalam Negeri Kementerian Luar Negri', 'Kementerian Pertahanan', '2026-05-12', '2026-06-24', 'aktif', 0, NULL, NULL, 'Mou sedang dalam Proses dengan progres yang menjanjikan', '2026-05-10 11:48:56', '2026-05-10 11:54:15', NULL, NULL, 0),
(4, NULL, NULL, NULL, 'PKS', 'aspek ketahanan pangan dalam negeri', 'Sekretaris Jenderal Kementerian Luar Negeri Republik Indonesia', 'kementerian perikanan', '2026-05-13', '2026-05-25', 'aktif', 0, NULL, NULL, 'tidak ada keterangan', '2026-05-10 11:55:42', '2026-05-10 11:55:42', NULL, NULL, 0),
(5, NULL, NULL, NULL, 'MoU', 'PENGAMANAN BERSAMA SISTEM DAN KEBIJAKAN TEKNOLOGI INFORMASI DAN KOMUNIKASI (TIK) LINGKUP KEMENTERIAN LUAR NEGERI DENGAN SISTEM EKSTERNAL NON-KEMENTERIAN LUAR NEGERI', 'Sekretaris Jenderal Kementerian Luar Negeri Republik Indonesia', 'BPK', '2026-05-12', '2026-07-30', 'aktif', 0, NULL, NULL, 'mengenai aliran keuangannya', '2026-05-10 12:48:35', '2026-05-10 12:50:46', NULL, NULL, 0),
(6, NULL, NULL, NULL, 'MoU', 'PENGAMANAN BERSAMA SISTEM DAN KEBIJAKAN TEKNOLOGI INFORMASI DAN KOMUNIKASI (TIK) LINGKUP KEMENTERIAN LUAR NEGERI DENGAN SISTEM EKSTERNAL NON-KEMENTERIAN LUAR NEGERI', 'Sekretaris Jenderal Kementerian Luar Negeri Republik Indonesia', 'BPK', '2026-05-20', '2026-05-25', 'aktif', 0, NULL, NULL, 'pengamanan digitalisasi di republik  indonesia dengan pengawalan ketat untuk menjamin keamanan data negara yang di pimpin langsung oleh sekertariatan negara republik indonesia', '2026-05-19 05:10:50', '2026-06-11 03:21:44', NULL, 'bagus', 0),
(7, NULL, NULL, NULL, 'MoU', 'perihal contoh', 'as', 'sa', '2026-07-07', '2026-07-14', 'aktif', 0, NULL, NULL, 'assa', '2026-06-30 22:07:21', '2026-06-30 22:22:30', NULL, 'woke acc', 0),
(8, 16, NULL, NULL, 'MoU', 'ttd opt ataur', 'opatur', 'opatur', '2026-07-01', '2026-07-28', 'tidak aktif', 0, NULL, NULL, 'jknwakjnkjn', '2026-07-02 03:34:17', '2026-07-02 04:52:55', 'ga boleh atur atur', NULL, 0),
(9, 16, NULL, NULL, 'PKS', 'opt atur pks', 'opaturpks', 'opaturpks', '2026-07-01', '2026-07-23', 'aktif', 0, NULL, NULL, 'sejnfkjnsfopopop', '2026-07-02 03:34:56', '2026-07-02 05:32:31', NULL, 'baiklah', 1),
(10, 17, NULL, NULL, 'MoU', 'bimbang', 'bimbang', 'bimbang', '2026-12-02', '2027-02-05', 'aktif', 0, NULL, NULL, 'bimbangbangettt', '2026-07-02 04:11:57', '2026-07-02 04:46:24', NULL, NULL, 1),
(11, 16, NULL, NULL, 'MoU', 'aturaatura', 'aturaatura', 'atura atura', '2026-07-17', '2026-07-21', 'aktif', 0, NULL, NULL, 'atsustausatu', '2026-07-03 03:24:02', '2026-07-03 03:24:02', NULL, NULL, 0),
(12, 16, NULL, NULL, 'PKS', 'saysaya', 'assaysay', 'saysasaya', '2026-07-09', '2026-07-22', 'revisi', 0, NULL, NULL, 'aduhaduh', '2026-07-03 03:24:27', '2026-07-03 03:39:20', 'buat lebih detail, tahunnya salah.', NULL, 0),
(13, 16, NULL, NULL, 'MoU', 'contoh untuk TA', 'TA 20 juli', 'TA12juli12', '2026-07-27', '2026-07-30', 'revisi', 0, NULL, NULL, 'izin TA', '2026-07-19 21:16:10', '2026-07-19 21:24:44', 'perbaiki bagian tanggal berakhir', NULL, 0),
(14, 16, NULL, NULL, 'MoU', 'contoh hukum tim 1', 'as', 'sa', '2026-07-14', '2026-07-31', 'revisi', 0, NULL, 'berita_acara_hukum/BA-HUKUM-MOU-14-1785093233.pdf', 'oke gas', '2026-07-26 10:59:33', '2026-07-26 12:16:54', 'cacat, buat dengan lebih jelas dasarnya', NULL, 0),
(15, 16, 18, NULL, 'PKS', 'tes 2 hukum', 'tes2 hukumm', 'tes2 hukum mou', '2026-07-21', '2026-08-28', 'pending_superadmin', 0, NULL, 'berita_acara_hukum/BA-HUKUM-MOU-15-1785101980.pdf', 'tes 2 hukum mou/pks', '2026-07-26 11:59:54', '2026-07-26 14:39:40', NULL, 'sudah sangat mantap', 0),
(16, 16, 18, 1, 'MoU', 'perihal contoh', 'as', 'TA12juli12', '2026-07-28', '2026-08-17', 'pending_hukum', 3, 'Revisi 1: Tim Hukum (tim hukum 1 (TIM Hotman)) - jelek | Revisi 2: Tim Hukum (tim hukum 1 (TIM Hotman)) - maaf ya belum bisa nih bos ku | Revisi 3: Super Admin (richardo manalu) - maaf belum bisa buat ulang hehe', 'berita_acara_hukum/BA-HUKUM-MOU-16-1785105722.pdf', 'baiklah paktolong lah pak jelek lu lu acc sekarang juga!!!', '2026-07-26 15:37:58', '2026-07-26 15:44:22', NULL, 'oke deh', 0),
(17, 16, NULL, NULL, 'MoU', 'contoh hari senin', 'senin distrik', '78iioa90LPPu', '2026-07-14', '2026-08-25', 'pending_hukum', 0, NULL, NULL, 'tanpa keterangan hukum', '2026-07-27 03:36:19', '2026-07-27 03:36:19', NULL, NULL, 0),
(18, 16, 18, NULL, 'MoU', 'contoh hari senin', 'senin distrik', '78iioa90LPPu', '2026-07-14', '2026-08-25', 'pending_superadmin', 0, 'Disetujui Legal: Tim Hukum (tim hukum 1 (TIM Hotman))', 'berita_acara_hukum/BA-HUKUM-MOU-18-1785148689.pdf', 'tanpa keterangan hukum', '2026-07-27 03:36:20', '2026-07-27 03:38:12', NULL, 'Catatan Legal: Sudah sesuai Tapoki Hukum', 0),
(19, 16, NULL, NULL, 'MoU', 'contoh hari senin', 'senin distrik', '78iioa90LPPu', '2026-07-14', '2026-08-25', 'pending_hukum', 0, NULL, NULL, 'tanpa keterangan hukum', '2026-07-27 03:36:20', '2026-07-27 03:36:20', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('balmond@test.com', '$2y$12$LArXEtbN/FjHhYeop.mdPeZHmBrXyiVAAiy40W4REcsea7A6dJ0hq', '2026-06-30 20:14:45'),
('manalu.fams@gmail.com', '$2y$12$6HDUde8Xr1Slm/TX3071ye6G1xCMvy58DnzqcxpBsEozstTIC7I5y', '2026-05-12 07:35:08'),
('tulangnyaekek@gmail.com', '$2y$12$z5nj83Dgr3w8dAoddOBI8.1wn.MJCv4LnnNeDgqjtP0ylQ5zrwWby', '2026-05-07 14:34:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hPRznhx5t8To91Sw3agey8r8t3624Cm57eN7aq2R', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.134.0 Chrome/148.0.7778.280 Electron/42.8.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWFPR090aVMzdDg2M0s1dGI3cnhaQW5OV3lVcTNEb29xU3V0b3c4ayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790155758),
('iCUkYwsJLAS6hTX0HiAgjEt1iUqf1BvsJW3RY6IU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGFnQUlWU1ZITnF0Y1ZjdmVLdTZrMjU2NjZDbHJVNmxrUHgyRnpSUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zdXBlci1hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MjE6InN1cGVyX2FkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1790156038),
('WhRe6Hq3uAX0Az96lJ5CLkDthkTucc89bO5Rip9Z', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibzdOUFo0ZUQ0cTFRb05MSmxKeGYycDNKQm1vNmpFaWc4bTdabnpQYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hdXRoL2dvb2dsZSI7czo1OiJyb3V0ZSI7czoxMjoiZ29vZ2xlLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1OiJzdGF0ZSI7czo0MDoicHFqSnlkU3pDN3FrRFFqdEhUNjcyeFNVWTBRdDZqZkJaa25rdks4UiI7fQ==', 1790155844);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tik_kemlu`
--

CREATE TABLE `tik_kemlu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tim_hukum_id` bigint(20) UNSIGNED DEFAULT NULL,
  `super_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_kebijakan` varchar(255) NOT NULL,
  `nomor_kebijakan` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `tautan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `revisi_ke` int(11) NOT NULL DEFAULT 0,
  `riwayat_revisi` text DEFAULT NULL,
  `file_berita_acara` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alasan_penolakan` text DEFAULT NULL,
  `keterangan_tambahan` text DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tik_kemlu`
--

INSERT INTO `tik_kemlu` (`id`, `admin_id`, `tim_hukum_id`, `super_admin_id`, `jenis_kebijakan`, `nomor_kebijakan`, `tahun`, `perihal`, `tautan`, `status`, `revisi_ke`, `riwayat_revisi`, `file_berita_acara`, `created_at`, `updated_at`, `alasan_penolakan`, `keterangan_tambahan`, `views`) VALUES
(1, NULL, NULL, NULL, 'Ruang Lingkup dan Definisi', 'Permenlu No. 4 Tahun 2016', '2016', 'aspek keamanan infrastruktur, manajemen risiko, dan tata kelola data', 'https://repository.unesa.ac.id/sysop/files/2023-05-04_Buku%205_Rr.%20NS.pdf', 'approved', 0, NULL, NULL, '2026-05-07 08:34:52', '2026-05-07 08:47:37', NULL, 'kirim utusan untuk perpanjang kontrak perjanjian', 0),
(2, NULL, NULL, NULL, 'Pengadaan Barang', 'Permenlu No 27 Tahun 2021', '2021', 'Mengatur tata cara pengadaan barang inventaris ataupun barang sekali pakai yang digunakan untuk seluruh kebutuhan Kementerian Luar Negeri dan meninjau segala baarang yang boleh dan tidak diperbolehkan untuk diadakan.', 'https://repository.unesa.ac.id/sysop/files/2023-05-04_Buku%205_Rr.%20NS.pdf', 'approved', 0, NULL, NULL, '2026-05-08 01:32:37', '2026-05-08 01:36:33', NULL, 'minta untuk semua satuan kerja kementerian Luar Negeri untuk mematuhi peraturan ini, segala barang yang diadakan baik untuk inventaris maupun sekali pakai haruslah melalu serangkaian proses yang telah di atur oleh permenlu nomor 27 tahun 2021 dan di laporkan ke sekertariat jendral serta di arsipkan dalam bentuk dokumen dan foto barang yang disimpan dalam bentuk digital serta fisik di gedung arsip.', 0),
(3, NULL, NULL, NULL, 'Pengadaan Kendaraan Dinas Kementerian Luar Negeri', 'perpres no 71 tahun 2023', '2023', 'Pengadaan Kendaraan Dinas Listrik di seluruh Kementerian guna meningkatkan perkembangan kendaraan listrik dalam negri dan menekan penggunaan BBM di dalam negeri', 'https://repository.unesa.ac.id/sysop/files/2023-05-04_Buku%205_Rr.%20NS.pdf', 'approved', 0, NULL, NULL, '2026-05-10 11:51:34', '2026-05-10 12:50:35', NULL, NULL, 0),
(4, NULL, NULL, NULL, 'Ruang Lingkup dan Definisi', 'Permenlu No. 4 Tahun 2016', '2016', 'aspek keamanan infrastruktur, manajemen risiko, dan tata kelola data', 'https://repository.unesa.ac.id/sysop/files/2023-05-04_Buku%205_Rr.%20NS.pdf', 'approved', 0, NULL, NULL, '2026-05-10 12:49:02', '2026-05-10 12:50:54', NULL, NULL, 0),
(5, NULL, NULL, NULL, 'jenis contoh', 'nomor contoh', '2026', 'perihal contoh', 'https://www.youtube.com/', 'rejected', 0, NULL, NULL, '2026-06-10 11:55:18', '2026-07-02 04:46:38', 'perbaiki', NULL, 1),
(6, NULL, NULL, NULL, 'jenis contoh', 'nomor contoh', '2001', 'qwwq', 'https://www.youtube.com/watch?v=MCNOH_ij-Yw&t=88s', 'rejected', 0, NULL, NULL, '2026-06-30 22:08:08', '2026-07-02 04:46:31', 'ga dulu', NULL, 1),
(7, 16, NULL, NULL, 'wowowk', 'KKKKKK', '2025', 'opeyk', 'https://www.youtube.com/watch?v=4UFiy6OkgN0k', 'approved', 0, NULL, NULL, '2026-07-03 03:25:02', '2026-07-03 08:27:05', NULL, 'oke', 0),
(8, 16, NULL, NULL, 'tim contoh hukum', '09eu93883j', '2026', 'buat hukum tes', 'https://www.youtube.com/watch?v=5TUUg9mU_V0&list=RDuFrrtA2fhF0&index=12', 'revisi_hukum', 0, NULL, NULL, '2026-07-26 11:01:13', '2026-07-26 12:14:18', 'buat dasar hukumnya lebih jelas', NULL, 0),
(9, 16, 18, NULL, 'tes2 tik kemlu hukum', 'tes2 tik kemlu hukum6778', '2026', 'tes2 tik kemlu hukum', 'https://www.youtube.com/watch?v=xTQvdE1oOaw&list=RDuFrrtA2fhF0&index=26', 'revisi_hukum', 0, NULL, NULL, '2026-07-26 12:00:22', '2026-07-26 14:39:53', 'masih kureng bos', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tik_non_kemlu`
--

CREATE TABLE `tik_non_kemlu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tim_hukum_id` bigint(20) UNSIGNED DEFAULT NULL,
  `super_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_kebijakan` varchar(255) NOT NULL,
  `nomor_kebijakan` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `tautan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `revisi_ke` int(11) NOT NULL DEFAULT 0,
  `riwayat_revisi` text DEFAULT NULL,
  `file_berita_acara` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alasan_penolakan` text DEFAULT NULL,
  `keterangan_tambahan` text DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tik_non_kemlu`
--

INSERT INTO `tik_non_kemlu` (`id`, `admin_id`, `tim_hukum_id`, `super_admin_id`, `jenis_kebijakan`, `nomor_kebijakan`, `tahun`, `perihal`, `instansi`, `tautan`, `status`, `revisi_ke`, `riwayat_revisi`, `file_berita_acara`, `created_at`, `updated_at`, `alasan_penolakan`, `keterangan_tambahan`, `views`) VALUES
(1, NULL, NULL, NULL, 'Tata Kelola Kebijakan Digital', 'perpres no 11 tahun 2013', '2013', 'Pengaturan dan pengelolaan kebijakan digital seluruh kementerian Republik Indonesia', 'Pusat Digitalisasi Nasional', 'https://repository.umj.ac.id/6800/1/DIKTAT%20PENGANTAR%20HI.pdf', 'rejected', 0, NULL, NULL, '2026-05-07 08:35:38', '2026-05-07 08:48:35', 'tinjau ulang dan minta pengunduran jadwal', NULL, 0),
(2, NULL, NULL, NULL, 'Pelaporan Terhadap Presiden', 'perpres no 32 tahun 2004', '2004', 'Tatacara pelaporan rutin kemajuan dan hambatan program kementerian ke presiden atau utusannya', 'kesekertariatan Kepresidenan', 'https://repository.unesa.ac.id/sysop/files/2023-05-04_Buku%205_Rr.%20NS.pdf', 'approved', 0, NULL, NULL, '2026-05-07 15:10:15', '2026-05-07 15:12:19', NULL, 'cetak fisik dan bawa ke brangkas lampiran fisik di ruang Melati', 0),
(3, NULL, NULL, NULL, 'Penjagaan Gabungan Wilayah Udara Indonesia-Australia', 'perpres no 112 tahun 2000', '2000', 'Penjagaan gabungan wilayah udara indonesia dan australia yang dilakukan demi menjaga keamanan kedua belah negara dan juga meningkatkan kerjasama baik', 'kementerian Pertahanan', 'https://repository.umj.ac.id/6800/1/DIKTAT%20PENGANTAR%20HI.pdf', 'approved', 0, NULL, NULL, '2026-05-10 11:53:28', '2026-05-10 12:50:42', NULL, NULL, 0),
(4, NULL, NULL, NULL, 'Ruang Lingkup dan Definisi', 'Permenlu No. 4 Tahun 2016', '2016', 'keikutsertaan mahasiswa', 'Universitas Sebelas Maret', 'https://repository.unesa.ac.id/sysop/files/2023-05-04_Buku%205_Rr.%20NS.pdf', 'approved', 0, NULL, NULL, '2026-05-10 12:49:37', '2026-07-02 04:46:47', NULL, NULL, 1),
(5, NULL, NULL, NULL, 'tik', 'kit', '2009', 'ayam', 'tikkit', 'https://www.youtube.com/watch?v=MCNOH_ij-Yw&t=88s', 'approved', 0, NULL, NULL, '2026-06-30 22:08:33', '2026-07-02 04:46:42', NULL, 'baiklah', 1),
(6, 16, NULL, NULL, 'atur', 'atur', '2022', 'aturan', 'atur', 'https://www.youtube.com/watch?v=MofaZRiwiOw&list=RDq7Fu7d1ppbI&index=27', 'rejected', 0, NULL, NULL, '2026-07-02 04:52:24', '2026-07-02 05:32:47', 'ga dulu', NULL, 0),
(7, 16, NULL, NULL, 'nonnon', '778non78963ono', '2019', 'kampoung', 'ono no no', 'https://www.youtube.com/watch?v=4UFiy6OkgN0', 'approved', 0, NULL, NULL, '2026-07-03 03:25:46', '2026-07-03 03:39:45', NULL, 'mantap', 0),
(8, 16, 18, NULL, 'kebijakan dalam hukum', '9937jjf73hg3', '2026', 'tes hukum non kemlu sorry bang kali ini paten pasti ga neko neko lagi', 'non kemlu hukum', 'https://www.youtube.com/watch?v=5TUUg9mU_V0&list=RDuFrrtA2fhF0&index=12', 'pending_superadmin', 0, NULL, 'berita_acara_hukum/BA-HUKUM-TIK_NON_KEMLU-8-1785104174.pdf', '2026-07-26 11:01:54', '2026-07-26 15:16:14', NULL, 'siap mantap', 0),
(9, 16, 18, NULL, 'tes 2 non kemlu hukum', 'tes 2 non kemlu hukum877', '2026', 'tes 2 non kemlu hukum dijamin kali ini paten bos ku ga kelng kaleng', 'tes 2 non kemlu hukum', 'https://www.youtube.com/watch?v=M5jnx3OgvIY&list=RDuFrrtA2fhF0&index=27', 'pending_superadmin', 0, NULL, 'berita_acara_hukum/BA-HUKUM-TIK_NON_KEMLU-9-1785105379.pdf', '2026-07-26 12:01:04', '2026-07-26 15:36:19', NULL, 'oke', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `role` enum('super_admin','admin','user','tim_hukum') NOT NULL DEFAULT 'user',
  `totp_secret` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `foto_profil`, `role`, `totp_secret`, `remember_token`, `created_at`, `updated_at`, `google_id`, `tanggal_lahir`, `no_telp`, `alamat`, `pekerjaan`, `nip`, `jabatan`) VALUES
(1, 'richardo manalu', 'richardo@test.com', '$2y$12$V8FvqJ/e6bx2rvRyXBm4j.cWTdzhXgWlJJY/Dlb9MrEGi6BXujSZC', 'foto_profil/OFSKqWtLTHBMxKvxTZzvL5wbSVIPF5ZbflUtqfc9.jpg', 'super_admin', NULL, 'tqXm9PGhnOAzZzKJGA064gBQIJzXGJ7f25eGCA3SttkZHTpGCTrrCSFvJXBw', '2026-05-07 08:30:06', '2026-07-26 14:37:12', NULL, '1992-06-10', '081398863037', 'gatau 78 rt 11 rw 12 jakarta utara', NULL, '78787889', 'Direktur Kebijakan'),
(2, 'balmond mobile legends', 'balmond@test.com', '$2y$12$NE0S76Y1PUQN.UTHwOrBt.L0w55jHtobLoH5iixK1fdYOeLFJbKDK', NULL, 'admin', NULL, 'ZBoyslhLWYKESYpDTozYhmwQ1rCGACQA4P08ovugI3LuDJKjY5hu6LpX7vUR', '2026-05-07 08:38:19', '2026-06-30 20:28:39', NULL, '2003-05-13', '081398863037', 'jalan kepahitan 1 nomor 77', NULL, '78787889', 'Admin IT'),
(3, 'Ricardo Gilbert', 'manalufamsss@gmail.com', '$2y$12$YAMZ2hfxzyt6WDTuyUMmg.DcSdMTcOxnzh2nJrc9S63xt.HaOnJB.', NULL, 'admin', NULL, NULL, '2026-05-07 12:46:40', '2026-05-07 12:46:40', '111828689009668543429', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'richardo manalu', 'manalu.fams@gmail.com', '$2y$12$rIkAFoILZg4qgBDFyY.NSO9xp5RBVIWtNpezbFl8V.7D1MnOg39sS', NULL, 'user', NULL, NULL, '2026-05-07 12:49:33', '2026-09-23 02:31:08', '118265197087415945472', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Nana Lancelot Jebres', 'Lancelot@test.com', '$2y$12$kGi3mqMw97lbCHpmLPJuou3uBLyyryiP.vwAleFvWHpJh1j2ziInS', NULL, 'admin', NULL, NULL, '2026-05-07 13:32:29', '2026-05-07 13:32:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Saurdot Lumban Gaol', 'tulangnyaekek@gmail.com', '$2y$12$Jc814eVWsrWmldI2wUmnfeF918Q3iYVPwzW5YrT26a/6bTsiJ3Vc2', NULL, 'user', NULL, NULL, '2026-05-08 03:48:42', '2026-07-19 12:11:41', '104257653785516515628', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'susanto artagraha', 'susanto01@gmail.com', '$2y$12$zNL.nFaaEuvQElsWM29rn.3QMWdk9axl0Ebn7bEOkogOp8Qw9E/Fm', NULL, 'user', NULL, NULL, '2026-05-10 04:26:23', '2026-05-10 04:26:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Jadi Tau', 'manalufamss@gmail.com', '$2y$12$bLohyidoIvyaG3Hb1iH4yuC0GbNeyYi1wKc9LGiAzRP5NngYH/cMq', NULL, 'user', NULL, NULL, '2026-06-10 21:37:11', '2026-07-27 03:32:38', '112621062094559107842', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Richardo Gilbert Ganda Tua', 'cumates@gmail.com', '$2y$12$PrcY20pTttPGow9/Sydul.txm2yAg5V3Ypkr/ZZTPwEgKo8NlFrHO', NULL, 'user', NULL, NULL, '2026-06-30 18:48:26', '2026-06-30 20:13:20', NULL, '2004-05-13', '089684401779', 'jl akar harum 7 no 11', 'mahasiswa', NULL, NULL),
(16, 'opung mangatur', 'opungmangatur@gmail.com', '$2y$12$frWaYANwXlcbHOq4YOHJvO7cayNoObCZ3KeuLV5bLFuY04uibTvU6', 'foto_profil/zuycLoY1w5w8oALA13WfkTuNGRT8KNjGgZOalb1a.jpg', 'admin', NULL, 'hLi9veUmdrMEYCjiwsZNmD1Zyip7i8BQp7ceSUKs8HHbSmELCLzyidoyGQM2', '2026-06-30 22:22:15', '2026-07-26 14:34:34', NULL, '1995-05-24', '089684401779', 'jalan marawara 17 rt 07 rw 08', NULL, '78787889', 'Admin IT'),
(17, 'bimbang', 'bimbangbanget@gmail.com', '$2y$12$9DlXXghePgGg9uTI3goC8.0cAvTUZmwfiAY8WaWjS6lxuHiRptnV6', NULL, 'admin', NULL, NULL, '2026-07-02 03:57:09', '2026-07-02 03:57:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'tim hukum 1 (TIM Hotman)', 'richardogilbertmanalu@gmail.com', '$2y$12$JgA07ZbwyFqBDuvn2pdsw.BwiVJWwzPpKriIQATY5gamZWWQPSQSq', NULL, 'tim_hukum', NULL, '9zIqPUIp8vWbWnUh5b0LFbrxE3k9bvfZFB6sdpNwU7Lh9Yg5F4ADdm8fw9Xy', '2026-07-26 10:58:18', '2026-07-26 10:58:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_user_id_foreign` (`user_id`),
  ADD KEY `appointments_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `beritas`
--
ALTER TABLE `beritas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beritas_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mou_pks`
--
ALTER TABLE `mou_pks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mou_pks_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tik_kemlu`
--
ALTER TABLE `tik_kemlu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tik_kemlu_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `tik_non_kemlu`
--
ALTER TABLE `tik_non_kemlu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tik_non_kemlu_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `beritas`
--
ALTER TABLE `beritas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `mou_pks`
--
ALTER TABLE `mou_pks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tik_kemlu`
--
ALTER TABLE `tik_kemlu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tik_non_kemlu`
--
ALTER TABLE `tik_non_kemlu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `beritas`
--
ALTER TABLE `beritas`
  ADD CONSTRAINT `beritas_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mou_pks`
--
ALTER TABLE `mou_pks`
  ADD CONSTRAINT `mou_pks_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tik_kemlu`
--
ALTER TABLE `tik_kemlu`
  ADD CONSTRAINT `tik_kemlu_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tik_non_kemlu`
--
ALTER TABLE `tik_non_kemlu`
  ADD CONSTRAINT `tik_non_kemlu_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
