-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2026 at 07:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alb`
--

-- --------------------------------------------------------

--
-- Table structure for table `crypto_payments`
--

CREATE TABLE `crypto_payments` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `wallet_address` varchar(100) DEFAULT NULL,
  `total_rupees` int(11) NOT NULL,
  `usd_amount` decimal(18,6) DEFAULT NULL,
  `sol_amount` decimal(18,9) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crypto_payments`
--

INSERT INTO `crypto_payments` (`id`, `users_id`, `items_id`, `signature`, `wallet_address`, `total_rupees`, `usd_amount`, `sol_amount`, `created_at`) VALUES
(1, 19, 1, 'PpFYFXixV7GnQRDF79vJhDRCcdFfjURumwi52jgM3XFNGfDVBF6VS7hMBW2UJ9RqD5HGXUqLpXmFUP9dnPdtmtM', 'E8ZyXyhaBfd1V48fJ7uc28LPgsuBQCFmRMJk2AuiWLGe', 500, 5.555556, 0.027197119, '2025-10-15 16:46:34'),
(2, 19, 1, '5UY3LJWYuL5MALmXueWPcFgUL2gvKEaUAi7GWWjJ3efp8kZuMtvRNrcZxnJE79nc7QvLwDs8UMFu6RoBURwC3HVn', 'E8ZyXyhaBfd1V48fJ7uc28LPgsuBQCFmRMJk2AuiWLGe', 500, 5.555556, 0.027487782, '2025-10-15 18:43:26'),
(3, 19, 1, '3pq5mdneLAbogEQxmC9pSxJqEr618m8CCSWJEdME2vdQRSH5ZnigroqBUrVDXpwvCFEPFgkR8AA3MSc69Chat6j2', 'E8ZyXyhaBfd1V48fJ7uc28LPgsuBQCFmRMJk2AuiWLGe', 500, 5.555556, 0.027470113, '2025-10-15 19:00:09'),
(4, 19, 1, '4X2coXfcbHs6Bd337mNpTRDmBJgYX1X2nHyJzhBv9cs96KwHBxHDBDrkUU9x627min8TC9QeVWQ1EGZ9uAMU9EoH', 'E8ZyXyhaBfd1V48fJ7uc28LPgsuBQCFmRMJk2AuiWLGe', 500, 5.555556, 0.027610733, '2025-10-28 10:05:49'),
(5, 19, 2, 'Ypavum4AvP9gyrVmy2jjMBxUEbe7RL135DvD713DtKSmgoTXqLS2dpV7MNgEE4orrpsAtA3Eifbpq6iCYtuSBdn', 'E8ZyXyhaBfd1V48fJ7uc28LPgsuBQCFmRMJk2AuiWLGe', 10379, 115.322222, 0.572972734, '2025-10-28 10:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `items_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `types` varchar(255) NOT NULL,
  `price` varchar(225) NOT NULL,
  `stock` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`items_id`, `name`, `brand`, `description`, `types`, `price`, `stock`, `rol`, `img`) VALUES
(1, 'DAP', 'go', 'All', 'FERTILIZER', '500', 5, 3, '1.PNG'),
(2, 'Eraser AP', 'MARTINS', 'Martins Eraser AP Herbicide 2.5gal', 'HERBICIDE', '10379', 2, 5, '3.PNG'),
(3, 'vermi compost', 'TrustBasket', 'Fertilizer Manure for Plants 5KG', 'FERTILIZER', '349', 123, 20, '2.PNG'),
(7, 'CROP Sprayer', 'PAD CORP by PADGILWAR CORPORATION', 'PAD CORP by PADGILWAR CORPORATION Double Bull Battery Operated Sprayer 12VX14 Strong Tank 18 Liter', 'SPRAYER', '5299', 67, 15, '7.PNG'),
(18, 'Acemain', 'Adama', 'Acephate 75 SP', 'INSECTICIDES', '735', 28, 5, '14.PNG'),
(19, 'Admire', 'Bayer', 'ADMIRE INSECTICIDE', 'INSECTICIDES', '748', 77, 15, '15.PNG'),
(20, 'Total plant care', 'plantic', 'Plantic Total Plant Care 3 in 1', 'INSECTICIDES', '99', 66, 22, '16.PNG'),
(21, 'Komugi', 'Komugi', 'PYRIPROXYFEN 10 EC', 'PESTICIDES', '60', 59, 10, '17.PNG'),
(40, 'phoskill', 'dip', 'use 36', 'FERTILIZER', '900', 90, 0, 'WhatsApp Image 2025-10-06 at 22.38.56_affffa22.jpg'),
(41, 'BHARTIYA JAN URAVARAK', 'MAHADHAN', '2424', 'FERTILIZER', '350', 40, 0, 'IMG-20251006-WA0038.jpg'),
(42, 'AMONIUM SULPHATE', 'MAHADHAN', '20.5', 'FERTILIZER', '600', 79, 0, 'IMG-20251006-WA0037.jpg'),
(43, 'BHARAT DAP', 'MAHADHAN', '18 46 0', 'FERTILIZER', '950', 65, 0, 'IMG-20251006-WA0036.jpg'),
(44, 'FANTAC', 'DELAB', '15', 'HERBICIDE', '150', 15, 0, 'IMG-20251006-WA0023.jpg'),
(45, 'GOLDI', 'BOLLGARD', 'CORN', 'HERBICIDE', '460', 36, 0, 'IMG-20251006-WA0024.jpg'),
(46, 'RIDOMIL', 'SYNGENTA', '100 GM', 'HERBICIDE', '490', 45, 0, 'IMG-20251006-WA0019.jpg'),
(47, 'MALLIKA', 'SEED', '46GM', 'HERBICIDE', '340', 50, 0, 'IMG-20251006-WA0025.jpg'),
(48, 'GENERAL LIQUID', 'MULTIPLEX', '2 LTR', 'PESTICIDES', '320', 20, 0, 'IMG-20251006-WA0016.jpg'),
(49, 'ISABION', 'SYNGETA', '1 LTR', 'PESTICIDES', '160', 24, 0, 'IMG-20251006-WA0018.jpg'),
(50, 'PROCLAIM', 'CRYSTAL', '250 G', 'PESTICIDES', '130', 13, 0, 'WhatsApp Image 2025-10-06 at 22.38.53_bb122e1b.jpg'),
(51, 'SIMODIS', 'SYGENTA', '250 MG', 'PESTICIDES', '120', 13, 0, 'WhatsApp Image 2025-10-06 at 22.38.54_954a088a.jpg'),
(52, 'ECOMAX', 'JU', '250 GM', 'INSECTICIDES', '500', 16, 0, 'WhatsApp Image 2025-10-06 at 22.38.49_cc611cb5.jpg'),
(53, 'MASAAL', 'JU', '12', 'INSECTICIDES', '350', 46, 0, 'WhatsApp Image 2025-10-06 at 22.38.49_42c19aa1.jpg'),
(54, 'RAINOLEX', 'INDIAN', '15 L', 'SPRAYER', '3200', 8, 0, 'WhatsApp Image 2025-10-06 at 22.46.49_77537dfc.jpg'),
(55, 'ELECTRONIC SPICES', 'ELECTRO', '20 L', 'SPRAYER', '3500', 4, 0, 'WhatsApp Image 2025-10-06 at 22.46.50_15c03c31.jpg'),
(56, 'OEM', 'OEM BRANDED', 'LIMITED EDITION', 'SPRAYER', '4000', 0, 0, 'WhatsApp Image 2025-10-06 at 22.46.51_8a50041a.jpg'),
(57, 'BATTERY', 'AYUDH', '12V 12MAH', 'OTHER', '2000', 5, 0, 'WhatsApp Image 2025-10-06 at 22.46.48_09dc0675.jpg'),
(58, 'AGRI POWER BATTERY', 'MADE IN INDIA', '12V 28MAH 1 YEAR WARRENTY', 'OTHER', '2100', 2, 0, 'WhatsApp Image 2025-10-06 at 22.46.46_6b6e1d50.jpg'),
(59, 'SHENGDELI', 'SDL', '12V 12AH', 'OTHER', '800', 3, 0, 'WhatsApp Image 2025-10-06 at 22.46.47_80db613d.jpg'),
(60, 'MOP', 'MHADAHN', 'BEST RESULT', 'FERTILIZER', '1350', 150, 0, 'IMG-20251006-WA0032.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `sales_id`, `users_id`, `review`, `created_at`) VALUES
(1, 34, 19, 'good', '2025-10-06 11:08:02'),
(2, 35, 20, 'expensivve', '2025-10-06 11:14:01'),
(3, 38, 19, 'good', '2025-10-06 19:38:42'),
(4, 41, 22, 'good', '2025-10-07 08:41:56'),
(5, 42, 22, 'good', '2025-10-07 09:58:27'),
(6, 43, 22, 'very very good pump', '2025-10-08 04:23:37'),
(7, 43, 22, 'good', '2025-10-08 08:56:16'),
(8, 49, 19, 'good', '2025-10-15 13:23:55'),
(9, 49, 19, 'good', '2025-10-15 13:24:05');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `review` longtext DEFAULT NULL,
  `supplier` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `req_date` datetime NOT NULL,
  `supplier_date` datetime NOT NULL,
  `proc_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  `rating` int(11) DEFAULT 0,
  `payment_type` varchar(10) DEFAULT 'cod',
  `order_status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `users_id`, `items_id`, `qty`, `total`, `date`, `review`, `supplier`, `status`, `req_date`, `supplier_date`, `proc_date`, `delivery_date`, `rating`, `payment_type`, `order_status`) VALUES
(1, 1, 1, 10, 3990, '2022-01-15 10:18:10', 'good', 1, 5, '2022-04-25 19:26:19', '2022-06-22 07:18:37', '2022-06-22 07:18:48', '2022-06-22 07:19:03', 0, 'cod', 'Pending'),
(4, 2, 2, 5, 51895, '2022-01-15 10:24:11', 'nice', 10, 2, '2022-04-24 15:40:53', '2022-04-24 15:53:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(5, 2, 5, 1, 17799, '2022-01-15 10:25:10', 'well suits', 1, 2, '2022-04-25 19:30:06', '2022-07-20 20:17:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(6, 6, 6, 7, 350000, '2022-01-15 13:48:30', 'super', 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(9, 1, 2, 3, 31137, '2022-01-17 18:53:36', '', 1, 5, '2022-04-25 19:23:17', '2022-04-25 19:23:48', '2022-07-19 12:51:34', '2022-07-19 12:55:08', 0, 'cod', 'Pending'),
(10, 1, 10, 1, 5299, '2022-01-17 21:37:57', NULL, 10, 2, '2022-04-24 15:42:29', '2022-04-24 15:44:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(12, 6, 16, 1, 350000, '2022-02-01 05:40:10', 'amazing', 0, 0, '0000-00-00 00:00:00', '2022-04-24 14:55:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(13, 1, 7, 10, 52990, '2022-03-08 08:55:11', '', 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2022-06-20 09:20:49', '2022-06-20 13:01:37', 0, 'cod', 'Pending'),
(14, 1, 16, 2, 700000, '2022-03-10 15:34:33', 'goog', 1, 5, '0000-00-00 00:00:00', '2022-04-24 15:43:54', '2022-07-19 12:52:00', '2022-07-19 12:58:08', 0, 'cod', 'Pending'),
(15, 2, 19, 40, 29920, '2022-03-10 19:04:07', NULL, 1, 4, '2022-04-27 08:41:16', '2022-04-27 08:41:25', '2022-04-27 09:03:26', '2022-06-20 13:03:01', 0, 'cod', 'Pending'),
(16, 12, 12, 10, 76490, '2022-03-11 00:42:22', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(17, 14, 1, 2, 798, '2022-03-11 09:32:00', 'good', 12, 2, '0000-00-00 00:00:00', '2022-04-22 17:05:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(18, 15, 16, 3, 1050000, '2022-03-25 11:22:05', 'excellent', 11, 2, '0000-00-00 00:00:00', '2022-04-24 15:05:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(19, 1, 2, 1, 10379, '2022-04-05 23:00:20', NULL, 1, 5, '2022-04-25 19:32:20', '2022-06-20 08:52:57', '2022-06-20 08:54:47', '2022-07-19 13:00:11', 0, 'cod', 'Pending'),
(20, 16, 3, 2, 698, '2022-04-22 14:57:36', NULL, 14, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(21, 16, 13, 1, 240000, '2022-04-22 16:59:48', NULL, 14, 5, '0000-00-00 00:00:00', '2022-06-20 13:11:33', '2022-06-20 13:12:12', '2022-06-20 13:20:08', 0, 'cod', 'Pending'),
(22, 17, 6, 1, 50000, '2022-06-21 22:08:03', NULL, 1, 3, '2022-06-27 15:05:52', '2022-06-28 11:44:55', '2022-07-19 12:52:46', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(23, 1, 16, 5, 1750000, '2022-06-28 11:47:17', NULL, 10, 5, '0000-00-00 00:00:00', '2022-06-28 11:48:29', '2022-06-28 11:52:11', '2022-06-28 11:53:09', 0, 'cod', 'Pending'),
(24, 1, 18, 1, 735, '2022-07-19 12:24:29', NULL, 1, 3, '2022-07-19 12:30:22', '2022-07-20 18:53:20', '2022-07-20 20:53:21', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(25, 1, 4, 1, 5950, '2022-07-19 12:26:12', 'amazing', 1, 2, '2022-07-19 12:45:18', '2022-07-20 18:52:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(26, 1, 18, 1, 735, '2022-07-20 20:47:15', NULL, 1, 1, '2022-07-20 21:00:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(27, 1, 12, 1, 7649, '2022-07-20 21:00:41', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(28, 1, 15, 2, 500000, '2022-07-23 09:55:38', NULL, 1, 5, '2022-07-23 09:57:06', '2022-07-23 09:57:25', '2022-07-23 09:57:41', '2022-07-23 09:57:56', 0, 'cod', 'Pending'),
(29, 1, 20, 1, 99, '2022-07-25 03:22:37', NULL, 10, 2, '0000-00-00 00:00:00', '2022-07-25 08:37:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(30, 1, 1, 2, 798, '2022-07-25 12:53:45', 'amazing', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(31, 18, 1, 2, 998, '2022-08-02 09:19:42', 'I AM ARTIN. SUPER', 1, 5, '2022-08-02 09:22:31', '2022-08-02 09:23:08', '2022-08-02 09:23:30', '2022-08-02 09:24:36', 0, 'cod', 'Pending'),
(32, 1, 14, 2, 5000000, '2022-11-11 11:35:29', 'good', 1, 5, '0000-00-00 00:00:00', '2022-11-11 11:36:31', '2022-11-11 11:37:55', '2022-11-11 11:38:52', 0, 'cod', 'Pending'),
(33, 1, 1, 1, 500, '2024-02-28 19:04:07', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(34, 19, 1, 2, 1000, '2025-10-06 16:37:07', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(35, 20, 2, 1, 10379, '2025-10-06 16:43:22', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'card', 'Pending'),
(36, 21, 2, 1, 10379, '2025-10-06 17:06:49', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(37, 19, 1, 1, 500, '2025-10-06 20:46:38', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(38, 19, 18, 5, 3675, '2025-10-07 01:08:37', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(39, 19, 1, 1, 500, '2025-10-07 07:40:39', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(40, 19, 42, 1, 600, '2025-10-07 09:13:09', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(41, 22, 1, 1, 500, '2025-10-07 14:11:49', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(42, 22, 1, 1, 500, '2025-10-07 15:28:15', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(43, 22, 56, 1, 4000, '2025-10-08 09:53:15', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'card', 'Pending'),
(44, 22, 1, 1, 500, '2025-10-08 14:26:05', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(45, 19, 3, 1, 349, '2025-10-15 16:30:37', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'sol', 'Completed'),
(46, 19, 3, 1, 349, '2025-10-15 16:32:11', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending'),
(47, 19, 1, 1, 500, '2025-10-15 16:46:34', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'sol', 'Completed'),
(48, 19, 1, 1, 500, '2025-10-15 18:43:26', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'sol', 'Completed'),
(49, 19, 1, 1, 500, '2025-10-15 18:53:31', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'card', 'Pending'),
(50, 19, 1, 1, 500, '2025-10-15 19:00:09', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'sol', 'Completed'),
(51, 19, 1, 1, 500, '2025-10-28 10:05:49', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'sol', 'Completed'),
(52, 19, 2, 1, 10379, '2025-10-28 10:08:05', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'sol', 'Completed'),
(53, 22, 1, 1, 500, '2025-11-14 09:42:03', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'card', 'Pending'),
(54, 19, 1, 1, 500, '2026-04-10 09:19:39', NULL, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'cod', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `aadhar` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `email`, `aadhar`, `address`, `mobile`, `password`, `status`, `location`, `city`, `district`, `state`, `country`) VALUES
(1, 'Albert Sebastian', 'albertsebastian75@gmail.com', '820370903255', 'House No 195', '8590956627', 'zxcvbnm', 1, 'KERALA', 'Thopramkudy', 'Idukki', 'KERALA', 'India'),
(2, 'Nikhil Sebastain', 'nikhil@gmail.com', '789678967896', 'MC road', '8989878564', '123456', 1, 'TAMIL NADU', 'town arch', 'Panaji', 'GOA', 'India'),
(4, 'Abhishek', 'abhishek@gamil.com', '852585258525', 'Palayam', '8569859658', '123456', 1, 'DELHI', 'shiva lenka', 'Ahmedabad', 'GUJARAT', 'India'),
(5, 'qw', 'qq@w', '111111111111', 'Choodaserry', '1111111111', '111111111111', 2, 'GOA', 'gandhi nagar', 'Gangtok', 'SIKKIM', 'India'),
(8, 'Ram Shankar', 'ram@gmail.com', '789654125874', 'qwerty', '8745962134', '123456', 0, 'MADHYA PRADESH', 'xyz city', 'Bhopal', 'MADHYA PRADESH', 'India'),
(9, 'Sam S', 'sam@gmail.com', '734629569348', '9 House left street\r\n', '5497084376', '12334455', 1, 'GUJARAT', 'kudalur', 'Amaravathi', 'ANDHRA PRADESH', 'India'),
(10, 'Alb Seb', 'alb@gmail.com', '945678545522', 'qwerty', '9495602791', '987654321', 1, 'KERALA', 'AC Town', 'Ahmedabad', 'GUJARAT', 'India'),
(12, 'krish ram', 'krish@gmail.com', '111111111111', '1', '8888888888', '456456', 0, 'ANDHRA PRADESH', 'kk', 'd', 'ASSAM', 'India'),
(13, 'd', 'd@d', '222222222222', '111111111\r\n', '2222222222', 'dddddd', 1, 'BIHAR', 'q', 'q', 'BIHAR', 'India'),
(14, 'f', 'f@f', '222222222222', '111\r\n', '2222222222', 'ffffff', 3, 'BIHAR', 'f', 'f', 'BIHAR', 'India'),
(15, 'q', 'qq@q', '111111111111', 'qq\r\n', '1111111111', 'qqqqqqq', 1, 'ANDHRA PRADESH', 'q', 'q', 'HIMACHAL PRADESH', 'India'),
(16, 'khushal', 'khushal@', '985674589655', 'Thopramkudy', '5909566277', 'ogougiouvuii', 0, 'ANDHRA PRADESH', 'Idukki', 'q', 'KERALA', 'India');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adr` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `district` varchar(250) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `firstname`, `lastname`, `email`, `mobile`, `password`, `adr`, `country`, `state`, `district`, `city`) VALUES
(19, 'harsh', 'sorathiya', 'harshsorathiya05@gmail.com', '8160032803', 'harsh007', 'junagadh', '', '', '', ''),
(20, 'prince', 'sangani', 'princesangani58@gmail.com', '9327243853', 'prince007', 'jetpur', '', '', '', ''),
(21, 'khushal', 'solanki', 'khushalsolanki2022@gmail.com', '7862898764', 'khusha', 'jaipur 364120', '', '', '', ''),
(22, 'MANAN', 'SAVALIYA', 'MANAN@GAMIL.COM', '9106920265', 'MANAN007', 'RAJKOT', '', '', '', ''),
(23, 'pammy', 'rakholiya', 'p@gamil.com', '6353850653', '9106920265', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendorid` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `companyname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendorid`, `fullname`, `companyname`, `email`, `address`, `mobile`, `password`, `status`) VALUES
(1, 'Akhil Joseph', 'ABC Comapny', 'akhil@gmail.com', 'MCT Road palayam', '9856985698', 'qwertyuiop', 1),
(2, 'Albin', ' Reji Intrenational', 'albin@gmail.com', 'qwerty road', '8236541236', '123456', 1),
(3, 'Anto Antony', 'Max Infotech', 'anto@gmail.com', 'plarivattam', '7568954756', '456987', 1),
(6, 'Abhi Alex', 'Abhi Exports', 'abhi@gmail.com', 'qwerty', '6589745896', '125896357', 3),
(7, 'Alex Joseph', 'XYZ Manufactures', 'alex@gmail.com', 'rani', '8569741236', 'qazxswedc', 2),
(8, 'Raj S', 'qwerty Exports and Imports', 'raj@gmail.com', 'zxcvbnmkl', '7854123000', '789987', 2),
(10, 'Albert Sebastian', 'ABC', 'albertsebastian75@gmail.com', 'Kuttikattu House', '8590956627', 'zxcvbnm', 1),
(12, 'q', 'q', 'q@w', 'w', '5909566277', 'wwwwwwwwwwwww', 1),
(13, 'irin', 'IRIN Golden Sail', 'irin@gmail.com', 'Kuttikattu House', '8590956627', '1111111', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_product`
--

CREATE TABLE `vendor_product` (
  `vendor_prod_id` int(11) NOT NULL,
  `vendorid` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `prize` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `qty_need` int(11) NOT NULL,
  `req_date` datetime NOT NULL,
  `proc_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_product`
--

INSERT INTO `vendor_product` (`vendor_prod_id`, `vendorid`, `items_id`, `prize`, `qty`, `qty_need`, `req_date`, `proc_date`, `delivery_date`, `status`) VALUES
(1, 10, 2, 1500, 123, 23, '2022-06-22 19:23:30', '2022-07-21 13:07:42', '2022-07-21 18:08:17', 3),
(4, 10, 13, 1000000, 0, 0, '2022-06-22 19:24:13', '2022-07-20 08:34:28', '0000-00-00 00:00:00', 2),
(5, 10, 2, 1255, 5, 2, '2022-06-24 09:48:00', '2022-07-21 13:09:31', '0000-00-00 00:00:00', 1),
(6, 10, 2, 5000, 5, 2, '2022-06-28 11:59:45', '2022-07-21 16:03:13', '2022-07-21 18:08:37', 3),
(7, 10, 2, 1520, 25, 5, '2022-07-20 09:07:29', '2022-07-20 11:05:18', '0000-00-00 00:00:00', 1),
(12, 10, 14, 150000, 1, 0, '2022-07-21 11:53:56', '2022-07-21 23:59:00', '0000-00-00 00:00:00', 2),
(13, 10, 15, 150000, 3, 0, '2022-07-21 18:17:01', '2022-07-21 18:19:32', '0000-00-00 00:00:00', 2),
(14, 10, 34, 1225, 2, 1, '2022-07-21 19:04:05', '2022-07-21 22:54:43', '0000-00-00 00:00:00', 1),
(17, 0, 21, 0, 0, 0, '2022-07-21 22:53:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10),
(18, 0, 2, 0, 0, 0, '2022-07-21 22:58:02', '2022-07-22 13:58:16', '0000-00-00 00:00:00', 9),
(19, 10, 2, 1000, 17, 15, '2022-07-21 23:03:57', '2022-07-21 23:49:14', '0000-00-00 00:00:00', 1),
(20, 10, 21, 1222, 1222, 10, '2022-07-21 23:18:56', '2022-07-25 12:59:35', '0000-00-00 00:00:00', 1),
(21, 1, 21, 159, 25, 1, '2022-07-21 23:22:18', '2022-07-21 23:48:56', '0000-00-00 00:00:00', 1),
(27, 0, 14, 0, 0, 0, '2022-07-21 23:35:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10),
(28, 1, 14, 150000, 23, 1, '2022-07-21 23:36:04', '2022-07-21 23:50:57', '2022-07-21 23:52:59', 3),
(29, 1, 13, 150000, 4, 1, '2022-07-21 23:43:53', '2022-07-21 23:47:48', '0000-00-00 00:00:00', 1),
(30, 10, 39, 1200, 25, 20, '2022-08-02 09:29:52', '2022-08-02 09:30:40', '2022-08-02 09:34:04', 3),
(31, 0, 1, 0, 0, 0, '2022-08-02 09:30:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10),
(32, 10, 2, 1111111, 11, 0, '2022-08-02 09:35:38', '2022-08-02 09:35:48', '0000-00-00 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `items_id`, `users_id`) VALUES
(5, 2, 6),
(8, 4, 12),
(9, 11, 12),
(11, 12, 12),
(12, 1, 14),
(13, 1, 15),
(15, 0, 0),
(16, 1, 1),
(19, 1, 18),
(20, 14, 1),
(21, 3, 21),
(22, 2, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crypto_payments`
--
ALTER TABLE `crypto_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_signature` (`signature`),
  ADD KEY `idx_users` (`users_id`),
  ADD KEY `idx_items` (`items_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`items_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendorid`);

--
-- Indexes for table `vendor_product`
--
ALTER TABLE `vendor_product`
  ADD PRIMARY KEY (`vendor_prod_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crypto_payments`
--
ALTER TABLE `crypto_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendorid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vendor_product`
--
ALTER TABLE `vendor_product`
  MODIFY `vendor_prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
