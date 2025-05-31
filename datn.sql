-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th5 25, 2025 lúc 03:22 PM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `datn`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nike', 'nike', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(2, 'Adidas', 'adidas', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(3, 'Zara', 'zara', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(4, 'H&M', 'hm', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(5, 'Uniqlo', 'uniqlo', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(6, 'Puma', 'puma', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(7, 'Levi\'s', 'levis', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(8, 'The North Face', 'the-north-face', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(9, 'Gucci', 'gucci', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(10, 'Calvin Klein', 'calvin-klein', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(11, 'Gottlieb, Rice and Gislason', 'gottlieb-rice-and-gislason', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(12, 'Zemlak-Bayer', 'zemlak-bayer', 'inactive', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(13, 'Osinski, Rath and Reynolds', 'osinski-rath-and-reynolds', 'inactive', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(14, 'Zemlak, Nader and Runolfsson', 'zemlak-nader-and-runolfsson', 'inactive', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(15, 'Kub-Tremblay', 'kub-tremblay', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_variant_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `product_variant_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 54, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(2, 1, NULL, 63, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(3, 1, NULL, 17, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(4, 1, NULL, 62, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(5, 1, NULL, 13, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(6, 2, NULL, 16, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(7, 2, NULL, 29, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(8, 2, NULL, 15, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(9, 2, NULL, 2, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(10, 3, NULL, 4, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(11, 4, NULL, 10, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(12, 4, NULL, 33, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(13, 4, NULL, 56, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(14, 4, NULL, 27, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(15, 4, NULL, 65, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(16, 5, NULL, 41, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(17, 5, NULL, 6, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(18, 5, NULL, 27, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(19, 5, NULL, 61, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(20, 5, NULL, 64, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(21, 6, NULL, 34, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(22, 6, NULL, 38, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(23, 6, NULL, 9, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(24, 7, NULL, 9, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(25, 7, NULL, 8, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(26, 7, NULL, 14, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(27, 7, NULL, 51, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(28, 8, NULL, 40, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(29, 9, NULL, 46, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(30, 9, NULL, 37, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(31, 9, NULL, 58, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(32, 9, NULL, 59, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(33, 10, NULL, 10, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(34, 11, NULL, 40, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(35, 11, NULL, 32, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(36, 11, NULL, 34, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(37, NULL, 'a69c3614-3e7e-3243-b58c-dd41a51f5996', 58, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(38, NULL, 'a69c3614-3e7e-3243-b58c-dd41a51f5996', 33, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(39, NULL, 'a69c3614-3e7e-3243-b58c-dd41a51f5996', 29, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(40, NULL, 'a69c3614-3e7e-3243-b58c-dd41a51f5996', 24, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(41, NULL, 'efa972b9-8723-3651-bf99-e5d3600e80f4', 9, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(42, NULL, 'efa972b9-8723-3651-bf99-e5d3600e80f4', 65, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(43, NULL, '0ec562e4-681b-35a2-a012-93810017bb4f', 3, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(44, NULL, '0ec562e4-681b-35a2-a012-93810017bb4f', 16, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(45, NULL, '9d03a817-105d-3fd8-81a4-31d4126d9eda', 24, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(46, NULL, '9d03a817-105d-3fd8-81a4-31d4126d9eda', 7, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(47, NULL, '9d03a817-105d-3fd8-81a4-31d4126d9eda', 46, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(48, NULL, '9d03a817-105d-3fd8-81a4-31d4126d9eda', 28, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(49, NULL, '6d90f433-648a-35ca-b51a-af455c19c714', 60, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(50, NULL, '6d90f433-648a-35ca-b51a-af455c19c714', 9, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(51, NULL, '6d90f433-648a-35ca-b51a-af455c19c714', 34, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(52, NULL, '246ebdc2-df5b-3beb-b885-ac4a3f2fa349', 61, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(53, NULL, '246ebdc2-df5b-3beb-b885-ac4a3f2fa349', 31, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(54, NULL, '246ebdc2-df5b-3beb-b885-ac4a3f2fa349', 51, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(55, NULL, '246ebdc2-df5b-3beb-b885-ac4a3f2fa349', 64, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(56, NULL, '9a5f62ea-cbaf-37c2-9a84-7c29abe7c770', 42, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(57, NULL, '9a5f62ea-cbaf-37c2-9a84-7c29abe7c770', 9, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(58, NULL, '9a5f62ea-cbaf-37c2-9a84-7c29abe7c770', 61, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(59, NULL, '9a5f62ea-cbaf-37c2-9a84-7c29abe7c770', 14, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(60, NULL, '81be7531-3552-35f6-8210-fbfac013593c', 32, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(61, NULL, '81be7531-3552-35f6-8210-fbfac013593c', 21, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(62, NULL, '81be7531-3552-35f6-8210-fbfac013593c', 7, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(63, NULL, 'b67a0c33-31fe-3ec1-847c-17e843469fb7', 54, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(64, NULL, 'b67a0c33-31fe-3ec1-847c-17e843469fb7', 51, 3, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(65, NULL, 'b67a0c33-31fe-3ec1-847c-17e843469fb7', 26, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(66, NULL, 'b67a0c33-31fe-3ec1-847c-17e843469fb7', 11, 1, '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(67, NULL, 'e4056fd1-2c94-3051-9b45-83be7d4e5d72', 51, 2, '2025-05-25 08:04:43', '2025-05-25 08:04:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Áo thun', 'ao-thun', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(2, 'Quần jean', 'quan-jean', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(3, 'Đầm váy', 'dam-vay', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(4, 'Áo khoác', 'ao-khoac', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(5, 'Giày dép', 'giay-dep', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(6, 'Phụ kiện', 'phu-kien', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(7, 'Quần short', 'quan-short', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(8, 'Áo sơ mi', 'ao-so-mi', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(9, 'Đồ thể thao', 'do-the-thao', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(10, 'Túi xách', 'tui-xach', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(11, 'Ad', 'ad', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(12, 'Neque', 'neque', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(13, 'Consequuntur', 'consequuntur', 'inactive', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(14, 'Odio', 'odio', 'active', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(15, 'Et', 'et', 'inactive', '2025-05-25 08:04:38', '2025-05-25 08:04:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` enum('percent','fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_value` decimal(10,2) DEFAULT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `usage_limit` int DEFAULT NULL,
  `user_usage_limit` int DEFAULT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `applicable_categories` json DEFAULT NULL,
  `applicable_products` json DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_value`, `max_discount`, `start_date`, `end_date`, `usage_limit`, `user_usage_limit`, `used_count`, `applicable_categories`, `applicable_products`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GZAWBEAZ', 'fixed', 39.08, 96.42, NULL, '2025-05-18 08:04:42', '2025-06-04 08:04:42', 50, 5, 0, NULL, NULL, 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(2, '4O51EGXX', 'fixed', 11.72, 76.98, NULL, '2025-05-21 08:04:42', '2025-06-10 08:04:42', 83, 1, 0, NULL, NULL, 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(3, '5BBVIUXQ', 'percent', 45.00, 148.33, 52.45, '2025-05-23 08:04:42', '2025-06-15 08:04:42', 27, 1, 0, NULL, NULL, 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(4, 'KFXQF2XN', 'percent', 19.00, 91.12, 22.31, '2025-05-18 08:04:42', '2025-06-07 08:04:42', 78, 5, 0, NULL, NULL, 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(5, 'C2E0RA7N', 'percent', 25.00, 160.97, 41.90, '2025-05-20 08:04:42', '2025-06-03 08:04:42', 43, 3, 0, NULL, NULL, 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(6, 'UZ1FZVKJ', 'percent', 37.00, 148.89, 75.50, '2025-05-17 08:04:42', '2025-06-06 08:04:42', 67, 4, 0, NULL, NULL, 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(7, 'HZKRXWTE', 'percent', 47.00, 101.99, 54.97, '2025-05-21 08:04:42', '2025-06-08 08:04:42', 64, 2, 0, NULL, NULL, 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(8, 'VKQTCGHY', 'fixed', 70.28, 149.63, NULL, '2025-05-15 08:04:42', '2025-06-07 08:04:42', 10, 2, 0, NULL, NULL, 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(9, 'UA7PCVJV', 'fixed', 20.78, 143.91, NULL, '2025-05-18 08:04:42', '2025-06-12 08:04:42', 69, 5, 0, NULL, NULL, 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(10, 'ZKHWB8DQ', 'fixed', 58.72, 52.52, NULL, '2025-05-17 08:04:42', '2025-05-30 08:04:42', 75, 1, 0, NULL, NULL, 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_05_21_150605_create_roles_table', 1),
(4, '2025_05_21_150648_create_users_table', 1),
(5, '2025_05_21_150729_create_categories_table', 1),
(6, '2025_05_21_150746_create_brands_table', 1),
(7, '2025_05_21_150818_create_products_table', 1),
(8, '2025_05_21_150838_create_product_variants_table', 1),
(9, '2025_05_21_150906_create_shipping_addresses_table', 1),
(10, '2025_05_21_150935_create_coupons_table', 1),
(11, '2025_05_21_151020_create_orders_table', 1),
(12, '2025_05_21_151044_create_order_details_table', 1),
(13, '2025_05_21_151109_create_payments_table', 1),
(14, '2025_05_21_151200_create_wishlists_table', 1),
(15, '2025_05_21_151226_create_carts_table', 1),
(16, '2025_05_21_151350_create_reviews_table', 1),
(17, '2025_05_21_151525_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('email','push','system') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `order_id`, `created_at`) VALUES
(1, 1, 'Occaecati quia non reiciendis.', 'Consequatur et enim sint harum veniam animi est. Molestiae aliquid tenetur suscipit qui perspiciatis debitis.', 'email', 1, 4, '2025-05-25 08:04:43'),
(2, 1, 'Sunt facere.', 'Aut voluptas odit sint debitis. Quam cupiditate harum illo quia. Aliquam ex velit delectus voluptatem amet non dolorem eveniet. Molestias quo quos occaecati aut dicta magni quia.', 'system', 1, 23, '2025-05-25 08:04:43'),
(3, 1, 'Modi magni amet.', 'Accusamus dolorum aliquid voluptatem ut fugit perspiciatis voluptatum dolorem. Autem dolor maxime ea velit molestiae enim nam. Soluta est natus et illo.', 'system', 1, 27, '2025-05-25 08:04:43'),
(4, 1, 'Consequuntur quisquam vel labore.', 'Est quia molestiae eum quos et repellendus voluptatem. Debitis quis maxime rerum dolorem sint. Beatae deleniti vero blanditiis magni reiciendis similique iste.', 'push', 0, NULL, '2025-05-25 08:04:43'),
(5, 1, 'Quae ut architecto.', 'Ut vel velit velit tenetur illum cum voluptas. Quia qui tempora excepturi cum molestiae eos. Libero facere voluptate similique ut doloribus eaque. Numquam optio quos suscipit harum doloremque.', 'system', 0, 11, '2025-05-25 08:04:43'),
(6, 2, 'Ipsa corporis libero molestiae.', 'Est pariatur enim amet rerum. Assumenda sit ipsam et ut soluta ut. Ipsum et molestiae autem molestiae dolores. Autem aut animi tempora minus quibusdam.', 'push', 0, NULL, '2025-05-25 08:04:43'),
(7, 3, 'Temporibus quos dolores.', 'Minima id animi et et nostrum voluptatem beatae. Iste aperiam sed qui aut. Consectetur aut repellat nulla architecto similique.', 'email', 1, NULL, '2025-05-25 08:04:43'),
(8, 3, 'Ullam animi officia.', 'Qui minus animi harum esse aut rerum facere. Voluptatem repellat quia sit omnis. Autem et rem nihil non asperiores molestiae illum a. Vitae veniam ad consectetur. Sapiente non veritatis sit rerum quis voluptas.', 'email', 1, 11, '2025-05-25 08:04:43'),
(9, 3, 'Rem sequi ducimus ullam.', 'Rerum et neque veritatis magni molestiae assumenda earum qui. Tenetur facere sequi eaque et in sequi. Asperiores ratione magni sequi consequatur rerum.', 'push', 0, 34, '2025-05-25 08:04:43'),
(10, 4, 'Sed nobis quisquam et.', 'Consequatur nobis dolor voluptatem omnis qui illum. Ab ut consequatur et. Nihil illo rem ut. Qui ut vel magnam facilis error ut dicta.', 'push', 0, 14, '2025-05-25 08:04:43'),
(11, 5, 'Unde placeat nihil.', 'Modi quod ipsam ex hic. Omnis voluptas quo impedit labore quasi vel pariatur. Qui omnis eum ad et dolorem. Voluptatem et sint quo quibusdam repudiandae aperiam numquam. Iste voluptas ducimus assumenda neque in aut numquam.', 'email', 1, NULL, '2025-05-25 08:04:43'),
(12, 5, 'Voluptate aut illo.', 'Sit aut et illum. Voluptatem aliquam omnis aspernatur hic. Voluptas autem aut ipsum et asperiores id.', 'email', 1, 6, '2025-05-25 08:04:43'),
(13, 5, 'Aliquam asperiores consequuntur recusandae.', 'Placeat vitae blanditiis quae repudiandae. Distinctio eum repellendus labore. Quis architecto aut libero corrupti sequi. Quis nostrum laborum est voluptatem itaque eveniet enim. Quaerat cupiditate vitae et aut ratione.', 'push', 0, 30, '2025-05-25 08:04:43'),
(14, 5, 'Hic vel qui.', 'Aut at est amet ipsum tenetur id amet. Animi aut voluptatem velit sint corrupti quibusdam doloribus quia. Commodi itaque autem voluptas maiores nisi. Autem nisi aliquam non et.', 'push', 1, NULL, '2025-05-25 08:04:43'),
(15, 6, 'Repellendus sint aliquam.', 'Est quaerat ratione modi ducimus mollitia. Repellendus deserunt quo explicabo corrupti et. Nemo rerum quia dolore quo ratione quasi. Rem dolores quod expedita tenetur pariatur nam.', 'system', 1, NULL, '2025-05-25 08:04:43'),
(16, 7, 'Sint illo error officia.', 'Debitis quam ex ut non id dolor numquam nihil. Eveniet quo ipsa dolores eum ipsum. Sint architecto ut qui fugiat doloremque et.', 'email', 1, 33, '2025-05-25 08:04:43'),
(17, 7, 'Similique quia maiores consequatur.', 'Pariatur dolorum sunt quo ullam maxime sunt quae iure. Incidunt pariatur accusantium voluptas fugit id sit. Voluptatem asperiores doloremque enim repudiandae.', 'system', 1, NULL, '2025-05-25 08:04:43'),
(18, 7, 'Ea excepturi eum in.', 'Qui voluptas tempore magnam quia voluptatum. Consequatur rem ullam enim porro dicta. Qui dicta aliquam dolorum eius labore iste at. Voluptatibus minima possimus aliquam ut.', 'push', 0, NULL, '2025-05-25 08:04:43'),
(19, 7, 'Dolorem numquam officiis et.', 'Maxime provident aspernatur amet quasi quo. Facere dolor quos est id ducimus illo facere. Temporibus quia cupiditate sed ipsa iusto. Rerum esse voluptatibus alias perspiciatis maiores et autem. Consequuntur at est voluptatem illum est iure repellat.', 'system', 0, 10, '2025-05-25 08:04:43'),
(20, 8, 'Necessitatibus deleniti hic illum.', 'Qui provident a enim quaerat dignissimos sit. Quia vel non quod reprehenderit enim quod.', 'email', 1, 31, '2025-05-25 08:04:43'),
(21, 9, 'Repellendus amet aliquam.', 'Nesciunt soluta exercitationem voluptatem harum aut. Minima facere fuga soluta similique. Earum vitae odio amet aut illum unde odit. Blanditiis fuga quia eos commodi.', 'push', 0, NULL, '2025-05-25 08:04:43'),
(22, 9, 'Quam deleniti veniam.', 'Iste atque perferendis qui quia non. Magnam eos dolorum vitae soluta. Qui quaerat perferendis repellat sit culpa sunt aut.', 'push', 0, 8, '2025-05-25 08:04:43'),
(23, 9, 'Omnis sint omnis adipisci.', 'Rerum ut libero et. Nemo et non deserunt mollitia dolorum eaque blanditiis sint. Aut cumque nisi nihil dolor in sed optio. Et tempore autem velit perferendis error mollitia.', 'system', 0, 25, '2025-05-25 08:04:43'),
(24, 9, 'Qui consequatur odit.', 'Hic molestiae dignissimos voluptatum occaecati hic. Sed ut et eveniet culpa. Eos quo laudantium quia ratione eaque. Laborum dolores recusandae id sunt quibusdam quo temporibus.', 'system', 1, 26, '2025-05-25 08:04:43'),
(25, 10, 'Voluptatem iusto occaecati similique.', 'Dolor odio repellat libero eius minus veritatis. Distinctio ullam voluptate omnis eum tenetur. Asperiores id aspernatur sint sequi voluptatem ut. Quisquam doloremque magnam vel.', 'system', 0, NULL, '2025-05-25 08:04:43'),
(26, 11, 'Velit dolorem est.', 'Inventore velit autem beatae rerum. Enim saepe sit omnis possimus maxime doloribus. Cumque dolorem maxime qui incidunt est quia.', 'email', 0, 11, '2025-05-25 08:04:43'),
(27, 11, 'Optio expedita sunt.', 'Quae et ea et neque modi. Voluptatem praesentium quaerat aut aperiam perspiciatis. Dignissimos qui in doloribus est. Asperiores animi et rerum.', 'push', 0, NULL, '2025-05-25 08:04:43'),
(28, 11, 'Maxime ut quibusdam.', 'Aut autem debitis et reiciendis quidem. Inventore aliquam accusantium aut voluptatem. Praesentium consequatur ex alias. Natus voluptatem beatae aut sint.', 'system', 0, 13, '2025-05-25 08:04:43'),
(29, 11, 'Corporis consectetur facilis.', 'Qui ut eos autem fugit. Consequatur aspernatur voluptatibus id voluptas quia neque eum illo. Expedita dolorem voluptatem neque enim voluptate.', 'system', 1, NULL, '2025-05-25 08:04:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` enum('cod','bank_transfer','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `shipping_address_id` bigint UNSIGNED NOT NULL,
  `coupon_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `payment_status`, `note`, `shipping_address_id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3724.00, 'cancelled', 'online', 'completed', 'Et voluptas veniam nulla voluptates quis cupiditate debitis.', 1, 10, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(2, 1, 2431.22, 'pending', 'cod', 'pending', NULL, 2, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(3, 1, 2926.87, 'cancelled', 'cod', 'completed', NULL, 1, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(4, 1, 2384.30, 'delivered', 'cod', 'failed', 'Nam soluta facere rerum consectetur.', 2, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(5, 2, 3877.13, 'pending', 'online', 'completed', 'Laborum architecto eveniet veritatis.', 5, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(6, 2, 2603.68, 'delivered', 'online', 'completed', NULL, 4, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(7, 2, 855.08, 'pending', 'online', 'failed', NULL, 4, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(8, 2, 465.44, 'processing', 'online', 'failed', NULL, 4, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(9, 3, 2926.97, 'delivered', 'bank_transfer', 'pending', 'Voluptatem quibusdam quidem unde provident numquam quia.', 6, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(10, 3, 1426.58, 'delivered', 'cod', 'failed', NULL, 6, 9, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(11, 3, 2521.90, 'pending', 'cod', 'pending', NULL, 6, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(12, 3, 3629.78, 'shipped', 'bank_transfer', 'completed', 'Voluptatibus nulla ex temporibus quis dolorem tenetur.', 6, 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(13, 4, 1144.42, 'delivered', 'online', 'failed', 'Itaque ea cumque omnis cumque numquam eos.', 7, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(14, 4, 4832.08, 'processing', 'cod', 'completed', NULL, 7, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(15, 5, 3747.41, 'delivered', 'cod', 'failed', 'Natus accusamus atque accusantium consectetur.', 8, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(16, 5, 4106.42, 'shipped', 'cod', 'failed', NULL, 8, 6, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(17, 5, 2612.48, 'shipped', 'bank_transfer', 'failed', NULL, 8, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(18, 6, 647.50, 'delivered', 'bank_transfer', 'failed', 'Accusantium ut consequatur expedita.', 9, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(19, 6, 1898.79, 'pending', 'cod', 'pending', NULL, 9, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(20, 6, 1797.29, 'cancelled', 'online', 'completed', NULL, 9, 5, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(21, 6, 4128.85, 'delivered', 'online', 'completed', NULL, 10, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(22, 6, 1886.60, 'cancelled', 'online', 'failed', NULL, 10, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(23, 7, 1848.39, 'shipped', 'cod', 'pending', NULL, 11, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(24, 7, 3998.29, 'delivered', 'cod', 'pending', NULL, 11, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(25, 8, 4102.26, 'processing', 'bank_transfer', 'completed', 'Porro temporibus iusto et assumenda amet deserunt eum iste.', 13, 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(26, 8, 4115.74, 'shipped', 'bank_transfer', 'pending', 'Asperiores nostrum distinctio officia qui voluptates ipsa dolorum.', 13, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(27, 8, 3234.24, 'pending', 'cod', 'pending', 'Non voluptatem quia asperiores quis consectetur voluptates.', 13, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(28, 8, 4262.10, 'pending', 'bank_transfer', 'pending', 'Fuga iusto corporis est fugit magnam sed.', 13, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(29, 9, 1696.16, 'shipped', 'bank_transfer', 'pending', NULL, 15, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(30, 9, 2944.89, 'processing', 'online', 'pending', NULL, 14, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(31, 9, 1530.91, 'shipped', 'cod', 'pending', NULL, 15, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(32, 9, 865.32, 'cancelled', 'bank_transfer', 'failed', 'Sint architecto sequi non optio mollitia id id.', 14, 10, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(33, 9, 4191.03, 'shipped', 'cod', 'completed', 'Exercitationem rerum eligendi quasi quisquam.', 15, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(34, 10, 2596.22, 'delivered', 'online', 'pending', 'Reprehenderit similique et ex animi quam unde illum.', 18, 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(35, 10, 3940.02, 'processing', 'cod', 'failed', 'Nihil amet illo cupiditate.', 16, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(36, 10, 624.92, 'processing', 'bank_transfer', 'failed', NULL, 16, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(37, 10, 2824.34, 'cancelled', 'online', 'completed', NULL, 16, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(38, 10, 3679.73, 'shipped', 'bank_transfer', 'completed', NULL, 16, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(39, 11, 3597.94, 'shipped', 'bank_transfer', 'failed', NULL, 19, NULL, '2025-05-25 08:04:42', '2025-05-25 08:04:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_variant_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_variant_id`, `quantity`, `price`, `discount`, `subtotal`) VALUES
(1, 1, 57, 5, 378.83, 79.11, 1498.60),
(2, 1, 45, 4, 387.21, 109.13, 1112.32),
(3, 1, 40, 1, 425.66, 42.99, 382.67),
(4, 1, 34, 4, 77.19, 10.74, 265.80),
(5, 1, 27, 2, 134.76, 2.43, 264.66),
(6, 2, 25, 3, 438.01, 31.41, 1219.80),
(7, 3, 58, 3, 145.52, 11.80, 401.16),
(8, 3, 53, 1, 469.09, 69.88, 399.21),
(9, 3, 51, 5, 94.58, 15.90, 393.40),
(10, 3, 43, 3, 456.09, 88.78, 1101.93),
(11, 3, 26, 2, 238.54, 0.43, 476.22),
(12, 4, 3, 1, 332.03, 87.73, 244.30),
(13, 4, 60, 1, 136.65, 3.21, 133.44),
(14, 5, 19, 5, 316.27, 46.62, 1348.25),
(15, 6, 54, 1, 466.88, 65.76, 401.12),
(16, 6, 38, 5, 147.09, 34.04, 565.25),
(17, 7, 30, 2, 406.38, 65.73, 681.30),
(18, 8, 14, 5, 54.26, 3.78, 252.40),
(19, 9, 63, 2, 471.69, 18.87, 905.64),
(20, 10, 45, 4, 387.21, 78.82, 1233.56),
(21, 11, 24, 3, 430.03, 54.84, 1125.57),
(22, 11, 36, 3, 314.15, 80.91, 699.72),
(23, 11, 14, 5, 54.26, 7.26, 235.00),
(24, 11, 38, 2, 147.09, 36.62, 220.94),
(25, 12, 45, 5, 387.21, 91.80, 1477.05),
(26, 12, 11, 5, 158.22, 43.75, 572.35),
(27, 12, 23, 2, 240.25, 1.28, 477.94),
(28, 12, 61, 5, 469.94, 39.06, 2154.40),
(29, 12, 28, 1, 141.97, 37.23, 104.74),
(30, 13, 11, 1, 158.22, 38.48, 119.74),
(31, 13, 19, 2, 316.27, 52.37, 527.80),
(32, 13, 35, 5, 398.96, 105.89, 1465.35),
(33, 13, 9, 5, 254.35, 69.21, 925.70),
(34, 13, 33, 2, 312.40, 86.32, 452.16),
(35, 14, 43, 5, 456.09, 68.30, 1938.95),
(36, 14, 38, 4, 147.09, 38.08, 436.04),
(37, 14, 55, 5, 84.26, 18.40, 329.30),
(38, 14, 55, 1, 84.26, 6.05, 78.21),
(39, 15, 13, 2, 358.51, 35.73, 645.56),
(40, 15, 53, 4, 469.09, 38.92, 1720.68),
(41, 15, 61, 2, 469.94, 48.00, 843.88),
(42, 16, 53, 4, 469.09, 103.35, 1462.96),
(43, 16, 8, 5, 87.30, 19.17, 340.65),
(44, 16, 65, 5, 495.04, 61.57, 2167.35),
(45, 16, 27, 3, 134.76, 7.14, 382.86),
(46, 17, 37, 4, 485.05, 52.62, 1729.72),
(47, 17, 21, 3, 73.86, 3.93, 209.79),
(48, 17, 9, 4, 254.35, 50.74, 814.44),
(49, 17, 41, 5, 360.19, 91.75, 1342.20),
(50, 17, 64, 1, 478.98, 40.94, 438.04),
(51, 18, 14, 1, 54.26, 7.09, 47.17),
(52, 18, 64, 5, 478.98, 23.83, 2275.75),
(53, 18, 38, 5, 147.09, 42.10, 524.95),
(54, 18, 61, 2, 469.94, 105.04, 729.80),
(55, 19, 59, 2, 208.10, 42.45, 331.30),
(56, 19, 54, 2, 466.88, 96.82, 740.12),
(57, 19, 30, 1, 406.38, 120.43, 285.95),
(58, 20, 16, 4, 155.94, 35.83, 480.44),
(59, 20, 44, 5, 247.50, 8.90, 1193.00),
(60, 20, 52, 4, 158.70, 3.44, 621.04),
(61, 20, 34, 5, 77.19, 18.76, 292.15),
(62, 21, 11, 1, 158.22, 21.39, 136.83),
(63, 21, 22, 5, 100.19, 10.46, 448.65),
(64, 22, 33, 1, 312.40, 51.97, 260.43),
(65, 23, 28, 3, 141.97, 11.18, 392.37),
(66, 23, 21, 2, 73.86, 7.01, 133.70),
(67, 23, 37, 5, 485.05, 36.56, 2242.45),
(68, 23, 32, 2, 167.01, 41.27, 251.48),
(69, 23, 54, 2, 466.88, 76.82, 780.12),
(70, 24, 47, 1, 230.56, 50.15, 180.41),
(71, 25, 26, 4, 238.54, 42.31, 784.92),
(72, 26, 7, 1, 63.24, 0.85, 62.39),
(73, 26, 57, 3, 378.83, 62.91, 947.76),
(74, 26, 1, 3, 89.17, 23.20, 197.91),
(75, 26, 56, 4, 106.55, 19.83, 346.88),
(76, 26, 6, 3, 488.56, 139.04, 1048.56),
(77, 27, 7, 1, 63.24, 10.67, 52.57),
(78, 27, 14, 4, 54.26, 5.98, 193.12),
(79, 27, 23, 1, 240.25, 63.40, 176.85),
(80, 28, 20, 3, 292.76, 27.96, 794.40),
(81, 28, 62, 4, 239.40, 47.20, 768.80),
(82, 28, 9, 2, 254.35, 69.83, 369.04),
(83, 28, 35, 4, 398.96, 31.19, 1471.08),
(84, 28, 61, 2, 469.94, 89.09, 761.70),
(85, 29, 1, 4, 89.17, 10.49, 314.72),
(86, 29, 24, 3, 430.03, 38.18, 1175.55),
(87, 29, 1, 1, 89.17, 9.73, 79.44),
(88, 29, 38, 1, 147.09, 13.79, 133.30),
(89, 30, 65, 1, 495.04, 4.48, 490.56),
(90, 30, 60, 4, 136.65, 18.63, 472.08),
(91, 31, 34, 4, 77.19, 3.30, 295.56),
(92, 31, 2, 2, 476.06, 117.11, 717.90),
(93, 31, 33, 4, 312.40, 19.53, 1171.48),
(94, 31, 37, 4, 485.05, 66.83, 1672.88),
(95, 31, 29, 4, 336.27, 64.63, 1086.56),
(96, 32, 61, 2, 469.94, 101.48, 736.92),
(97, 32, 38, 3, 147.09, 22.79, 372.90),
(98, 32, 9, 1, 254.35, 58.81, 195.54),
(99, 33, 17, 1, 77.39, 19.52, 57.87),
(100, 33, 36, 2, 314.15, 82.94, 462.42),
(101, 33, 61, 3, 469.94, 41.94, 1284.00),
(102, 33, 11, 5, 158.22, 25.58, 663.20),
(103, 34, 38, 2, 147.09, 17.93, 258.32),
(104, 34, 30, 4, 406.38, 106.46, 1199.68),
(105, 34, 47, 1, 230.56, 27.88, 202.68),
(106, 34, 56, 3, 106.55, 15.67, 272.64),
(107, 34, 23, 5, 240.25, 39.32, 1004.65),
(108, 35, 21, 1, 73.86, 7.46, 66.40),
(109, 35, 41, 4, 360.19, 64.76, 1181.72),
(110, 35, 50, 2, 484.99, 114.83, 740.32),
(111, 36, 56, 4, 106.55, 28.77, 311.12),
(112, 36, 6, 3, 488.56, 130.64, 1073.76),
(113, 36, 64, 1, 478.98, 76.89, 402.09),
(114, 36, 34, 5, 77.19, 9.74, 337.25),
(115, 36, 12, 1, 115.72, 28.66, 87.06),
(116, 37, 32, 2, 167.01, 12.50, 309.02),
(117, 37, 14, 2, 54.26, 8.39, 91.74),
(118, 37, 8, 2, 87.30, 25.23, 124.14),
(119, 37, 6, 3, 488.56, 20.36, 1404.60),
(120, 38, 57, 2, 378.83, 68.36, 620.94),
(121, 38, 54, 5, 466.88, 42.10, 2123.90),
(122, 38, 48, 2, 483.49, 138.10, 690.78),
(123, 38, 49, 3, 314.22, 93.90, 660.96),
(124, 38, 4, 2, 347.82, 47.93, 599.78),
(125, 39, 29, 3, 336.27, 4.85, 994.26),
(126, 39, 63, 3, 471.69, 124.08, 1042.83),
(127, 39, 32, 4, 167.01, 11.96, 620.20),
(128, 39, 55, 5, 84.26, 12.08, 360.90),
(129, 39, 24, 4, 430.03, 36.72, 1573.24);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `method` enum('cod','bank_transfer','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `payment_gateway` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `method`, `amount`, `status`, `transaction_id`, `paid_at`, `payment_gateway`) VALUES
(1, 3, 'cod', 2926.87, 'completed', '56351b33-e620-3a74-ba0c-1df5dcdd526c', NULL, NULL),
(2, 5, 'online', 3877.13, 'completed', NULL, '2025-05-21 23:48:52', 'PayPal'),
(3, 6, 'online', 2603.68, 'completed', NULL, '2025-05-12 17:15:37', 'PayPal'),
(4, 9, 'bank_transfer', 2926.97, 'completed', '0d906d15-79e4-384c-b213-f3fc76238774', '2025-05-05 18:12:29', NULL),
(5, 11, 'cod', 2521.90, 'completed', NULL, '2025-05-24 08:20:44', NULL),
(6, 13, 'online', 1144.42, 'completed', NULL, NULL, 'Stripe'),
(7, 17, 'bank_transfer', 2612.48, 'failed', NULL, '2025-05-17 05:25:35', NULL),
(8, 20, 'online', 1797.29, 'completed', 'dac52c11-0a2c-34bd-a86d-f2f85d12274f', NULL, 'PayPal'),
(9, 21, 'online', 4128.85, 'pending', NULL, NULL, 'VNPay'),
(10, 23, 'cod', 1848.39, 'completed', 'c5345dfa-aef9-3cb4-ba5b-57d38aba4248', NULL, NULL),
(11, 24, 'cod', 3998.29, 'completed', NULL, NULL, NULL),
(12, 25, 'bank_transfer', 4102.26, 'completed', NULL, NULL, NULL),
(13, 26, 'bank_transfer', 4115.74, 'failed', '7a8521dc-865e-3cfe-8987-7b0aa82f5140', NULL, NULL),
(14, 28, 'bank_transfer', 4262.10, 'completed', '1c1d2fec-b4e5-3e89-b105-4d02fc308675', '2025-05-18 05:28:17', NULL),
(15, 29, 'bank_transfer', 1696.16, 'completed', '781bba1e-3790-33bd-a42a-31bfa6d19110', NULL, NULL),
(16, 30, 'online', 2944.89, 'pending', NULL, '2025-05-09 12:32:44', 'Stripe'),
(17, 32, 'bank_transfer', 865.32, 'pending', NULL, NULL, NULL),
(18, 34, 'online', 2596.22, 'completed', NULL, '2025-05-14 15:30:20', 'Stripe'),
(19, 35, 'cod', 3940.02, 'completed', '4588dc59-d4e4-3136-a987-791991b59839', NULL, NULL),
(20, 36, 'bank_transfer', 624.92, 'completed', NULL, '2025-05-02 10:10:28', NULL),
(21, 37, 'online', 2824.34, 'pending', NULL, NULL, 'VNPay');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','out_of_stock') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `brand_id`, `sku`, `thumbnail`, `description`, `short_description`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Eligendi quam architecto', 13, 14, '9G5YEVPX', 'products/thumbnails/', 'Nesciunt dicta animi laborum dicta voluptas iste minus. Omnis commodi officiis nostrum suscipit. Commodi perspiciatis enim hic ea cum. Consequatur qui id magnam vitae doloremque eligendi illum.', 'Sit labore ipsam dolor consequatur eveniet.', 'eligendi-quam-architecto-boed', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(2, 'Dignissimos quibusdam voluptatem', 10, 3, 'GJB1PBUG', 'products/thumbnails/', 'In totam minus nostrum sed necessitatibus sequi odit. Rerum enim temporibus autem et fugit quidem id velit.', 'Aut dolorem non quam totam numquam.', 'dignissimos-quibusdam-voluptatem-35vh', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(3, 'Natus suscipit adipisci', 15, 15, 'HN6LGZMS', 'products/thumbnails/', 'Rerum expedita at ut blanditiis. Et eum dolor cum neque et ad ullam occaecati. Exercitationem dolorem est neque rerum tenetur. Necessitatibus voluptas quae dolorem consequatur officiis et dicta.', 'Natus odio sit voluptas est tempore.', 'natus-suscipit-adipisci-x3rr', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(4, 'Quos praesentium nostrum', 4, 11, 'FN1L8JO7', 'products/thumbnails/', 'Ipsa ut et voluptate aut qui quos. Enim aspernatur qui rerum neque. Doloremque velit perferendis nam quam quis nemo. Commodi ea sit ipsa sunt.', 'Maiores deleniti voluptatibus quas totam soluta et et.', 'quos-praesentium-nostrum-jiqd', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(5, 'Perspiciatis magnam est', 6, 2, 'G0ZMZYUA', 'products/thumbnails/', 'Similique velit sed molestiae laudantium et ratione. Voluptatem magnam et voluptate maxime fuga. Laudantium distinctio necessitatibus ut sit.', 'Assumenda ipsa fugiat sit ex.', 'perspiciatis-magnam-est-7ww0', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(6, 'Omnis error eaque', 14, 15, 'WVSWHCVE', 'products/thumbnails/', 'Ab dignissimos animi tempora exercitationem consequatur deserunt. Fugiat quod nobis voluptas quis. Qui sapiente velit occaecati aut at vitae et magnam.', 'Ea dolorem iste reiciendis ut culpa dolore.', 'omnis-error-eaque-7ob0', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(7, 'Labore itaque architecto', 4, 8, '6O37RWS3', 'products/thumbnails/', 'Distinctio accusantium omnis accusantium recusandae. Qui atque mollitia optio quidem ratione. Aliquam qui rerum perspiciatis pariatur voluptatum consectetur et.', 'Neque exercitationem corporis tenetur in.', 'labore-itaque-architecto-p8z5', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(8, 'Consequatur enim id', 12, 6, '6FHYZ1GK', 'products/thumbnails/', 'Quas nihil dolores vel praesentium molestiae. Eum et voluptates doloribus. Ut quisquam maiores voluptas quod est sapiente. Harum velit rerum sapiente impedit assumenda consectetur.', 'Consequuntur tempore molestiae in minus sapiente.', 'consequatur-enim-id-jmmc', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(9, 'Aspernatur rem qui', 15, 9, 'PYKSGD2N', 'products/thumbnails/', 'Consequatur praesentium officia animi. Architecto tenetur possimus autem excepturi soluta. Sed temporibus ea dicta minima aut quod consequatur.', 'Rerum ut et vero hic et aut.', 'aspernatur-rem-qui-rqdh', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(10, 'Cum recusandae impedit', 11, 4, 'ASROBC2Y', 'products/thumbnails/', 'Voluptatem veniam eius odit optio ipsam quia praesentium. Ea eaque inventore velit officiis ex qui itaque.', 'Laboriosam dolor omnis saepe.', 'cum-recusandae-impedit-9etc', 'out_of_stock', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(11, 'Voluptatem corrupti ipsa', 11, 6, 'OLCBAKBG', 'products/thumbnails/', 'Totam eos eius sint quia debitis. Fugit debitis laudantium eius reiciendis voluptas non. Ab iure reiciendis dolores. Ullam quam non sint placeat non.', 'Harum accusamus quo consequuntur ut modi nihil quam.', 'voluptatem-corrupti-ipsa-rhsk', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(12, 'Rerum ea officia', 9, 2, 'GTZAVX8A', 'products/thumbnails/', 'Consequatur adipisci illum reiciendis nam magni nihil. Rerum autem et placeat laborum ratione. Cupiditate sunt laudantium blanditiis et. Nulla quisquam ut omnis autem nam quo aut consectetur.', 'Qui unde vero suscipit possimus ut rerum.', 'rerum-ea-officia-axjk', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(13, 'Et voluptates culpa', 2, 7, 'NUZ30RJM', 'products/thumbnails/', 'Iusto aut id iste doloribus quo. Quia qui omnis qui. Aperiam neque veniam sint in quo. Dolores qui itaque magni.', 'Molestiae quae est cum cumque.', 'et-voluptates-culpa-ucnc', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(14, 'Delectus quis nemo', 7, 5, 'MAIXJY3B', 'products/thumbnails/', 'Quo magni minus rerum quia rerum sit consectetur. Sint corrupti laudantium a amet. Voluptatem libero quia reiciendis aut sit in. Neque alias saepe qui officia dicta.', 'Perferendis quam veniam porro eum vel saepe sapiente.', 'delectus-quis-nemo-b2cd', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(15, 'Voluptatem quis quibusdam', 14, 7, '2NNH66BV', 'products/thumbnails/', 'Saepe qui tempora provident. Nostrum voluptatem incidunt qui magni omnis est qui. Vitae aliquam eius sit non optio minima est voluptatem. Mollitia cumque architecto neque voluptatem ad officiis.', 'Molestias molestias dolores veritatis provident.', 'voluptatem-quis-quibusdam-4hod', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(16, 'Quis et impedit', 6, 5, '8D6APDA8', 'products/thumbnails/', 'Consequuntur provident ut voluptas eligendi et adipisci. Quasi voluptatem iusto molestias doloremque quam. Iusto consequatur qui beatae ut. Ut assumenda tempore quidem est assumenda recusandae nobis.', 'Et magnam facere temporibus reprehenderit est totam et.', 'quis-et-impedit-ud8d', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(17, 'Molestias praesentium officia', 8, 2, 'LR5LUKMQ', 'products/thumbnails/', 'Cumque quo repellendus qui ut quae in. Et laboriosam minima dicta. Nobis quis odit eius voluptas quia minima ipsa et.', 'Ut nobis quia libero ratione illum ut.', 'molestias-praesentium-officia-yop2', 'out_of_stock', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(18, 'Qui dolorem corrupti', 12, 7, 'YOSUPRND', 'products/thumbnails/', 'Ea ea magni et harum perferendis. Rerum aut ducimus qui. Eligendi nobis harum qui laudantium recusandae sunt. Delectus doloremque enim cupiditate ipsa labore.', 'Impedit ea reprehenderit pariatur magni enim aliquid quae.', 'qui-dolorem-corrupti-ygvv', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(19, 'Quis ut et', 10, 14, 'ZBIHLV2W', 'products/thumbnails/', 'Vitae dolores quia tempore adipisci. Et sunt praesentium voluptatem. Ipsa sapiente eius dolores repellendus.', 'Consequatur expedita vel rem voluptatem repudiandae deleniti vero.', 'quis-ut-et-yrt3', 'out_of_stock', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(20, 'Expedita et sed', 5, 12, 'GBEGJSL4', 'products/thumbnails/', 'Qui blanditiis eos libero consectetur ut deserunt aut. Neque officia sunt sit. Asperiores dolorum voluptas quia enim voluptates.', 'Quae officiis necessitatibus et adipisci.', 'expedita-et-sed-odwz', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color`, `size`, `sku`, `price`, `stock_quantity`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 'Đỏ', 'S', 'Y5HCZGLZ', 89.17, 88, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(2, 13, 'Xám', 'M', '89HTUV1V', 476.06, 12, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(3, 13, 'Đỏ', 'L', 'MJCN5DX8', 332.03, 42, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(4, 4, 'Xanh', 'S', 'IPHMEGNN', 347.82, 23, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(5, 4, 'Hồng', 'L', '6NHEWVTL', 309.36, 56, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(6, 7, 'Trắng', 'S', 'PFQLRHCN', 488.56, 26, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(7, 20, 'Đen', 'XS', 'DMOGIQNN', 63.24, 39, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(8, 20, 'Đỏ', 'L', '0QZLCYOB', 87.30, 94, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(9, 20, 'Xanh', 'XXL', 'FYJ98J6H', 254.35, 89, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(10, 20, 'Hồng', 'XS', 'SV5DZVFO', 202.16, 50, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(11, 5, 'Hồng', 'M', 'N9B1HMYS', 158.22, 28, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(12, 5, 'Xám', 'XXL', 'CUFHVDS6', 115.72, 62, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(13, 16, 'Trắng', 'M', 'Q1H7DTMF', 358.51, 2, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(14, 16, 'Đen', 'L', 'AL9455KK', 54.26, 60, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(15, 16, 'Hồng', 'L', 'DPHLB0HA', 455.64, 39, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(16, 16, 'Trắng', 'S', 'F6KDTWPH', 155.94, 48, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(17, 14, 'Xanh', 'XXL', 'Z0ESMXCZ', 77.39, 43, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(18, 14, 'Đen', 'L', '4MYE7SKM', 52.03, 29, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(19, 14, 'Trắng', 'M', 'B1GPC8HJ', 316.27, 89, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(20, 14, 'Xám', 'XL', 'EO0SOZMG', 292.76, 93, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(21, 17, 'Xanh', 'XXL', 'I4KXHAWT', 73.86, 92, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(22, 17, 'Đỏ', 'XS', 'VRHG4TUW', 100.19, 90, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(23, 17, 'Đen', 'L', '4N76DTFK', 240.25, 42, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(24, 17, 'Đen', 'M', 'VMWJXJ0K', 430.03, 47, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(25, 12, 'Đỏ', 'XXL', 'FX78EMOA', 438.01, 34, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(26, 12, 'Xám', 'XL', 'HINMTBUI', 238.54, 18, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(27, 12, 'Hồng', 'L', '35WTFJQR', 134.76, 0, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(28, 12, 'Hồng', 'S', 'ARZWJ7Z6', 141.97, 38, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(29, 2, 'Hồng', 'M', 'C10JIRVN', 336.27, 80, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(30, 2, 'Đen', 'XXL', 'AT7MXWHJ', 406.38, 94, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(31, 2, 'Đỏ', 'M', 'XLJTI96H', 76.21, 11, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(32, 19, 'Hồng', 'M', 'PLAPHZB3', 167.01, 99, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(33, 19, 'Trắng', 'XL', 'MEENGRM3', 312.40, 99, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(34, 19, 'Đen', 'S', 'TUPTGADI', 77.19, 65, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(35, 19, 'Trắng', 'XXL', 'EWTAYJST', 398.96, 49, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(36, 10, 'Đỏ', 'L', 'JFBUOAOE', 314.15, 93, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(37, 10, 'Hồng', 'XXL', '7OZEGXEO', 485.05, 90, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(38, 10, 'Hồng', 'M', 'PD07Z6KR', 147.09, 29, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(39, 10, 'Đen', 'XXL', 'XMMJAJ3B', 191.95, 41, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(40, 11, 'Đen', 'XS', 'KSAS5KED', 425.66, 21, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(41, 11, 'Đen', 'S', 'EYAHDRFY', 360.19, 60, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(42, 11, 'Trắng', 'XXL', 'UCO4I23N', 246.37, 9, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(43, 11, 'Trắng', 'XS', 'T5PQAQS0', 456.09, 48, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(44, 8, 'Đỏ', 'S', 'HIYBXY14', 247.50, 82, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(45, 8, 'Xám', 'M', 'PZD6NJR2', 387.21, 52, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(46, 8, 'Xám', 'S', 'Z7XDAXAI', 488.54, 3, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(47, 8, 'Đen', 'XXL', 'UBVAZ7HT', 230.56, 67, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(48, 18, 'Đỏ', 'S', 'E6P4P4HL', 483.49, 22, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(49, 18, 'Vàng', 'XXL', 'G9UUZT5M', 314.22, 80, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(50, 18, 'Xanh', 'S', 'WVG4OTKS', 484.99, 97, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(51, 18, 'Xám', 'S', 'YIR68XDY', 94.58, 61, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(52, 1, 'Đen', 'XL', 'RPFBTQX9', 158.70, 93, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(53, 1, 'Trắng', 'XL', 'B6GO6K6X', 469.09, 68, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(54, 1, 'Đen', 'XXL', 'HGPSRSWS', 466.88, 54, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(55, 1, 'Xanh', 'M', 'PTLID1KP', 84.26, 99, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(56, 6, 'Trắng', 'XS', 'LU6BA2TP', 106.55, 10, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(57, 15, 'Hồng', 'S', 'RB6R6ALW', 378.83, 34, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(58, 15, 'Đen', 'M', 'WIXNWPAS', 145.52, 81, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(59, 15, 'Xanh', 'XS', 'WCCH5ZNI', 208.10, 44, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(60, 3, 'Vàng', 'M', '6PEAF9VY', 136.65, 7, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(61, 3, 'Đỏ', 'M', 'WEWDLOZD', 469.94, 97, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(62, 3, 'Đỏ', 'XL', 'OYX9HDUU', 239.40, 79, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(63, 9, 'Xanh', 'XL', '3CYUPIPN', 471.69, 62, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(64, 9, 'Xám', 'L', 'C5HQR58U', 478.98, 1, 'products/variants/', 'inactive', '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(65, 9, 'Đen', 'XS', 'MRTSMYG2', 495.04, 24, 'products/variants/', 'active', '2025-05-25 08:04:42', '2025-05-25 08:04:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 17, 2, 'Porro voluptatem laudantium cum impedit minus consequuntur aspernatur.', 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(2, 2, 8, 1, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(3, 2, 6, 1, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(4, 2, 19, 5, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(5, 3, 8, 3, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(6, 3, 4, 3, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(7, 3, 9, 3, NULL, 'approved', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(8, 4, 17, 4, 'Vero saepe sit ut odio fugiat enim.', 'approved', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(9, 4, 13, 3, NULL, 'approved', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(10, 5, 12, 1, NULL, 'approved', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(11, 5, 6, 2, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(12, 6, 15, 3, 'Assumenda quae aliquid veritatis maxime maiores.', 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(13, 7, 5, 2, 'Veniam nihil corporis eum voluptas voluptate ipsa.', 'approved', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(14, 7, 4, 2, 'Consectetur itaque eaque praesentium veniam.', 'pending', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(15, 7, 9, 3, NULL, 'approved', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(16, 8, 20, 4, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(17, 8, 18, 3, 'Et impedit autem consequuntur cum accusamus.', 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(18, 8, 17, 3, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(19, 9, 13, 4, NULL, 'approved', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(20, 9, 4, 4, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(21, 10, 4, 5, NULL, 'rejected', '2025-05-25 08:04:43', '2025-05-25 08:04:43'),
(22, 11, 17, 1, NULL, 'pending', '2025-05-25 08:04:43', '2025-05-25 08:04:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', '[\"manage_users\", \"manage_products\", \"view_reports\"]', '2025-05-25 08:04:38', '2025-05-25 08:04:38'),
(2, 'customer', '[\"view_products\", \"place_orders\"]', '2025-05-25 08:04:38', '2025-05-25 08:04:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ward` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `user_id`, `name`, `phone_number`, `address`, `ward`, `district`, `city`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Porter Upton DDS', '(503) 597-6069', '3748 Rachael Ports Suite 672', 'bury', 'North Chelsey', 'Missouri', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(2, 1, 'Kaelyn Kihn', '479.687.8788', '95403 Johnson Path Suite 884', 'stad', 'North Veronica', 'Connecticut', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(3, 2, 'Ricardo Nitzsche', '1-551-357-3733', '8693 Maia Valley', 'bury', 'Dennismouth', 'Illinois', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(4, 2, 'Prof. Sibyl Ondricka III', '+1 (240) 630-9463', '4619 Schneider Rue Apt. 371', 'land', 'Port Martyville', 'Nevada', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(5, 2, 'Mrs. Angelita Dickinson', '+1-859-670-5806', '242 Jones Parks Apt. 264', 'chester', 'Friesentown', 'South Dakota', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(6, 3, 'Royal Huel Sr.', '1-215-426-8310', '14227 Lionel Cliff Suite 609', 'side', 'West Cassandraside', 'South Dakota', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(7, 4, 'Ms. Deborah Morar', '+1 (386) 566-8283', '121 Raymond Curve Apt. 679', 'ton', 'Volkmanmouth', 'Oklahoma', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(8, 5, 'Vada Hettinger DVM', '458-506-5987', '936 Leatha Route', 'berg', 'Runolfsdottirchester', 'Vermont', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(9, 6, 'Deborah O\'Reilly', '+1 (206) 532-2357', '147 Susan Corners', 'haven', 'East Alishamouth', 'Michigan', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(10, 6, 'Anibal Labadie', '1-272-371-7954', '2031 Fisher Path', 'berg', 'Duncanberg', 'Texas', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(11, 7, 'Cindy Ullrich', '817-273-2487', '6549 Kihn Causeway', 'mouth', 'West Elmoview', 'Florida', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(12, 7, 'Keagan Turcotte', '947.632.4643', '37175 Francesca Pine Apt. 845', 'berg', 'Patiencestad', 'West Virginia', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(13, 8, 'Charity Batz DVM', '+1-620-965-2049', '46683 Adams Crest Suite 368', 'stad', 'Greenfort', 'Utah', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(14, 9, 'Miss Katlynn Kemmer', '+1 (860) 997-5349', '2494 Runolfsdottir Ford Apt. 417', 'borough', 'Soledadborough', 'Iowa', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(15, 9, 'Prof. Erwin Daniel Sr.', '+1-504-973-1896', '3244 Pedro Mills Suite 974', 'mouth', 'New Orenfurt', 'Hawaii', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(16, 10, 'Jules Gerlach', '+1 (475) 824-7087', '78329 Duncan Glens', 'bury', 'New Berylbury', 'Washington', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(17, 10, 'Abel Muller', '(520) 624-6844', '32938 Krajcik Land', 'bury', 'Jonathanville', 'Pennsylvania', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(18, 10, 'Orin Harris DVM', '828-785-0808', '6203 Goyette Cliff Suite 098', 'ton', 'New Colt', 'Utah', 0, '2025-05-25 08:04:42', '2025-05-25 08:04:42'),
(19, 11, 'Vern Greenholt', '754.513.5837', '54715 Emanuel Viaduct', 'mouth', 'Coleview', 'New Mexico', 1, '2025-05-25 08:04:42', '2025-05-25 08:04:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','banned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `reset_password_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_expires_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `password`, `status`, `email_verified_at`, `reset_password_token`, `reset_password_expires_at`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin User', 'admin@example.com', '0900000000', '$2y$12$AJ.rzmRcsw41QgM5iov.wuWObMD8xhXoypnZt1EBd.2z0wbR6/U2e', 'active', '2025-05-25 08:04:39', NULL, NULL, 1, '2025-05-25 08:04:39', '2025-05-25 08:04:39', NULL),
(2, 'Tremayne Shanahan', 'amiya.hackett@example.org', '1-980-235-8029', '$2y$12$vSzaT9tVmW/vmCgfiCpqFungKa7GeouDds2t/euw05eXkCpTZtY4O', 'inactive', '2025-05-25 08:04:39', NULL, NULL, 2, '2025-05-25 08:04:39', '2025-05-25 08:04:39', NULL),
(3, 'Abel Rau IV', 'edward96@example.org', '+1-323-223-0707', '$2y$12$R1Ds/QBfeWB8.Be6E5NDY.o9s2v.t/FPTUfGl4w5noCDE75uB8jo2', 'active', '2025-05-25 08:04:39', NULL, NULL, 2, '2025-05-25 08:04:39', '2025-05-25 08:04:39', NULL),
(4, 'Torrance Schneider', 'bergnaum.stephanie@example.com', '747-705-7470', '$2y$12$/45ro8IolW2RmM64f1Vbteb.yGwOUP1ArOFKMAczLZT.4G3Ku1nNK', 'active', NULL, NULL, NULL, 2, '2025-05-25 08:04:39', '2025-05-25 08:04:39', NULL),
(5, 'Laverne Wolff', 'boconner@example.org', '928-703-6749', '$2y$12$aKnbCr7D299.kziide7bDO4eRSPmZgIkxens716uQ60drGfP3MTGm', 'active', NULL, NULL, NULL, 2, '2025-05-25 08:04:40', '2025-05-25 08:04:40', NULL),
(6, 'Mr. Gunnar Koelpin V', 'kaycee.reinger@example.com', '+1-605-254-1011', '$2y$12$ScPsvjN2OnpdYVT3NF.pbOjaSghM9EQQbJ7QHb3MxMo3tVMf0J.CC', 'banned', '2025-05-25 08:04:40', NULL, NULL, 2, '2025-05-25 08:04:40', '2025-05-25 08:04:40', NULL),
(7, 'Kristian Hudson', 'misty82@example.net', '830.992.1652', '$2y$12$oBt5CTy.N/myE.OkZYE93ucx7RBfw6ohFQD2721XjMiyZdXfta9QC', 'banned', '2025-05-25 08:04:40', NULL, NULL, 2, '2025-05-25 08:04:40', '2025-05-25 08:04:40', NULL),
(8, 'Ms. Augusta Beahan', 'markus.pfannerstill@example.net', '(630) 944-5455', '$2y$12$JzEFbwLJaDy.0LVVAA.O9u/YU/PCjZE/OeUoXOEV7DJuasvZcfwTi', 'banned', NULL, NULL, NULL, 2, '2025-05-25 08:04:41', '2025-05-25 08:04:41', NULL),
(9, 'Mia Langosh', 'kenyon73@example.com', '480-899-6805', '$2y$12$4D5L3KXoaU0kxMV7DhZn3OXXwfppzUPWXvNwMqV3bveQrJLWOej4e', 'active', NULL, NULL, NULL, 2, '2025-05-25 08:04:41', '2025-05-25 08:04:41', NULL),
(10, 'Dr. Hal Kertzmann', 'ullrich.bradford@example.net', '(417) 391-4414', '$2y$12$vToStH/kkKxyOeSi4PpDCO1ksrLE9t/ka0boRDQMWDlmJ0wZVOPwq', 'inactive', '2025-05-25 08:04:41', NULL, NULL, 2, '2025-05-25 08:04:41', '2025-05-25 08:04:41', NULL),
(11, 'Mandy Littel', 'juliana78@example.net', '541.603.7454', '$2y$12$tBvWAeECXnL5ujYztJCOuu3rmoHRT8JRme4s7Kfm6Th3HIrD9VLsG', 'active', '2025-05-25 08:04:42', NULL, NULL, 2, '2025-05-25 08:04:42', '2025-05-25 08:04:42', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 17, '2025-05-25 08:04:43'),
(2, 1, 4, '2025-05-25 08:04:43'),
(3, 2, 13, '2025-05-25 08:04:43'),
(4, 2, 9, '2025-05-25 08:04:43'),
(5, 2, 7, '2025-05-25 08:04:43'),
(6, 2, 16, '2025-05-25 08:04:43'),
(7, 2, 14, '2025-05-25 08:04:43'),
(8, 3, 2, '2025-05-25 08:04:43'),
(9, 3, 3, '2025-05-25 08:04:43'),
(10, 3, 7, '2025-05-25 08:04:43'),
(11, 3, 8, '2025-05-25 08:04:43'),
(12, 4, 20, '2025-05-25 08:04:43'),
(13, 5, 19, '2025-05-25 08:04:43'),
(14, 6, 8, '2025-05-25 08:04:43'),
(15, 6, 6, '2025-05-25 08:04:43'),
(16, 6, 18, '2025-05-25 08:04:43'),
(17, 6, 17, '2025-05-25 08:04:43'),
(18, 6, 5, '2025-05-25 08:04:43'),
(19, 7, 6, '2025-05-25 08:04:43'),
(20, 8, 1, '2025-05-25 08:04:43'),
(21, 8, 4, '2025-05-25 08:04:43'),
(22, 8, 19, '2025-05-25 08:04:43'),
(23, 8, 9, '2025-05-25 08:04:43'),
(24, 9, 11, '2025-05-25 08:04:43'),
(25, 9, 10, '2025-05-25 08:04:43'),
(26, 10, 5, '2025-05-25 08:04:43'),
(27, 10, 16, '2025-05-25 08:04:43'),
(28, 10, 3, '2025-05-25 08:04:43'),
(29, 11, 13, '2025-05-25 08:04:43'),
(30, 11, 6, '2025-05-25 08:04:43'),
(31, 11, 17, '2025-05-25 08:04:43'),
(32, 11, 8, '2025-05-25 08:04:43');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_variant_id_foreign` (`product_variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  ADD KEY `orders_coupon_id_foreign` (`coupon_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_variant_id_foreign` (`product_variant_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
