-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 28, 2023 at 10:36 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `momopetshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kb_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `kb_id`, `kategori`, `nama_barang`, `harga_barang`, `stok_barang`, `keterangan_barang`, `gambar_barang`, `created_at`, `updated_at`) VALUES
('923121f5-387f-4390-b537-ff53d130ffd7', '57325eee-6c69-437d-88a5-434c40932200', 'alat', 'Kandang', '500000', '2', 'kandang kucing', 'oem_oem_full01.webp', '2023-05-28 04:37:39', '2023-05-28 04:37:39'),
('9d2055c4-46c7-461c-9e47-c00c84c0ee86', 'b991d1ed-807e-4f35-86cf-5f04153fb326', 'pakan', 'Makanan kucing', '150000', '5', 'makanan kucing sehat', 'b50aeb494ac668645a670caa655f1d83.png', '2023-05-28 04:38:10', '2023-05-28 04:38:10'),
('db27c260-a285-46d6-b328-b5a172ded3ae', 'e7068eb9-755e-4cc5-aef6-52938be5c333', 'pakan', 'whiskas', '155000', '12', 'okeeee', 'Whiskas-Makanan-Kucing-Tuna-1.2-Kg_11zon.jpg', '2023-05-28 10:32:39', '2023-05-28 10:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksis`
--

CREATE TABLE `detail_transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trans_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksis`
--

INSERT INTO `detail_transaksis` (`id`, `trans_id`, `kategori`, `nama`, `jumlah`, `harga`, `folder`, `gambar`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, '202305281642081685266928', 'pakan', 'Makanan kucing', '1', '150000', 'barang', 'b50aeb494ac668645a670caa655f1d83.png', 'makanan kucing sehat', '0', '2023-05-28 09:42:08', '2023-05-28 09:42:08'),
(2, '202305281642081685266928', 'alat', 'Kandang', '1', '500000', 'barang', 'oem_oem_full01.webp', 'kandang kucing', '0', '2023-05-28 09:42:08', '2023-05-28 09:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hewans`
--

CREATE TABLE `hewans` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_hewan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jkel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat_hewan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tinggi_hewan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_hewan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_hewan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_hewan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_hewan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hewans`
--

INSERT INTO `hewans` (`id`, `nama_hewan`, `jkel`, `tgl_lahir`, `berat_hewan`, `tinggi_hewan`, `gambar_hewan`, `jumlah_hewan`, `harga_hewan`, `keterangan_hewan`, `created_at`, `updated_at`) VALUES
('1282d47b-53bf-4cf4-856d-cad91a7e01ab', 'Kucing lucu', 'Jantan', '2023-05-05', '23', '30', '052183700_1621230651-1500845.jpg', '3', '1000000', 'kucing lucu di momopetshop', '2023-05-28 04:37:10', '2023-05-28 04:37:10'),
('e53b8a0b-00c4-435a-af24-18de49bcf21b', 'Kucing luar', 'Betina', '2023-05-20', '123', '45', 'gambar-kucing.jpg', '4', '2500000', 'okeeee', '2023-05-28 09:58:57', '2023-05-28 09:58:57');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barangs`
--

CREATE TABLE `kategori_barangs` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_barangs`
--

INSERT INTO `kategori_barangs` (`id`, `kategori`, `nama_kategori`, `keterangan_kategori`, `created_at`, `updated_at`) VALUES
('23f40905-9aac-4e42-bccf-ca1e15efe4a7', 'alat', 'tempat makan', 'tempat makan', '2023-05-28 04:34:44', '2023-05-28 04:34:44'),
('375f42b8-4009-4736-85dd-c527253e17f7', 'pakan', 'Makanan basah', 'Makanan basah', '2023-05-28 04:34:44', '2023-05-28 04:34:44'),
('57325eee-6c69-437d-88a5-434c40932200', 'alat', 'Kandang hewan', 'Kandang hewan', '2023-05-28 04:34:44', '2023-05-28 04:34:44'),
('b991d1ed-807e-4f35-86cf-5f04153fb326', 'pakan', 'Makanan kering', 'Makanan kering', '2023-05-28 04:34:44', '2023-05-28 04:34:44'),
('e7068eb9-755e-4cc5-aef6-52938be5c333', 'pakan', 'Makanan ringan', 'Makanan ringan', '2023-05-28 04:34:44', '2023-05-28 04:34:44'),
('ee2557a7-8c49-4d67-bbf3-ee9d9947696f', 'alat', 'mainan', 'mainan', '2023-05-28 04:34:44', '2023-05-28 04:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `keranjangs`
--

CREATE TABLE `keranjangs` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjangs`
--

INSERT INTO `keranjangs` (`id`, `user_id`, `kategori`, `nama`, `jumlah`, `harga`, `folder`, `gambar`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
('16852669022425', '16852668458662', 'pakan', 'Makanan kucing', '1', '150000', 'barang', 'b50aeb494ac668645a670caa655f1d83.png', 'makanan kucing sehat', '0', '2023-05-28 09:41:42', '2023-05-28 09:41:42'),
('16852669066654', '16852668458662', 'alat', 'Kandang', '1', '500000', 'barang', 'oem_oem_full01.webp', 'kandang kucing', '0', '2023-05-28 09:41:46', '2023-05-28 09:41:46'),
('16852682883490', '16852668458662', 'hewan', 'Kucing luar', '1', '2500000', 'hewan', 'gambar-kucing.jpg', 'okeeee', '0', '2023-05-28 10:04:48', '2023-05-28 10:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_16_080000_create_treatments_table', 1),
(6, '2023_05_23_142652_create_kategori_barangs_table', 1),
(7, '2023_05_23_142849_create_barangs_table', 1),
(8, '2023_05_23_202826_create_hewans_table', 1),
(9, '2023_05_27_100436_create_keranjangs_table', 1),
(10, '2023_05_27_101423_create_transaksis_table', 1),
(11, '2023_05_27_101538_create_detail_transaksis_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bayar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `total_jumlah`, `total_harga`, `tgl_transaksi`, `total_bayar`, `created_at`, `updated_at`) VALUES
('202305281642081685266928', '16852668458662', '2', '650000', '2023-05-28', '650000', '2023-05-28 09:42:08', '2023-05-28 09:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_treatment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_treatment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_treatment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_treatment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_treatment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
('16852668457399', 'Administrator', 'admin', 'admin@gmail.com', NULL, '$2y$10$DGFgr6zidprxMLsERivV/e677ZjAdwKhONdCHjsR5cgr5KIFHXy5q', '1', '1', NULL, '2023-05-28 09:40:45', '2023-05-28 09:40:45'),
('16852668458058', 'Kasir', 'karyawan', 'karyawan@gmail.com', NULL, '$2y$10$sf/VjfxRhbocaZFOObKWzOBJUA/y8ftX5M6XN2CjKOOL0GTYNIKZ2', '2', '1', NULL, '2023-05-28 09:40:45', '2023-05-28 09:40:45'),
('16852668458662', 'Customer', 'customer', 'customer@gmail.com', NULL, '$2y$10$4vOiMbBxK79CxgA.D.ob3OkPc7E60dNt03.lzlYV4WGj245BHc.9a', '3', '1', NULL, '2023-05-28 09:40:45', '2023-05-28 09:40:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_kb_id_index` (`kb_id`);

--
-- Indexes for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksis_trans_id_index` (`trans_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hewans`
--
ALTER TABLE `hewans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_barangs`
--
ALTER TABLE `kategori_barangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjangs`
--
ALTER TABLE `keranjangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjangs_user_id_index` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_user_id_index` (`user_id`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_kb_id_foreign` FOREIGN KEY (`kb_id`) REFERENCES `kategori_barangs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD CONSTRAINT `detail_transaksis_trans_id_foreign` FOREIGN KEY (`trans_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
