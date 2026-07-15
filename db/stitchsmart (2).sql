-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 09:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stitchsmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_type` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `access_type`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'stitchsmartofficial@gmail.com', '$2y$10$9MnukaJZ/SKQMYlueeYSq.A6Tj/nzn1R54d9Gg7mcG6iLTvxR4fYe', 'full', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `alt` text NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `text` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `alt`, `image_url`, `text`) VALUES
(28, 'MAIN', 'pictures/banners/MAIN.png', 'MAIN'),
(30, 'CHILD', 'pictures/banners/CHILD.png', 'CH'),
(33, '3', 'pictures/banners/3.png', '3');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `size` varchar(100) DEFAULT '',
  `fabric` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `qty`, `size`, `fabric`, `created_at`) VALUES
(61, 4047, 146, 2, 'L', '', '2026-06-20 11:16:13');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(150) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `c_description` varchar(2000) NOT NULL,
  `c_image` varchar(500) DEFAULT NULL,
  `c_img2` varchar(500) NOT NULL,
  `meta_title` varchar(150) DEFAULT NULL,
  `meta_description` varchar(160) DEFAULT NULL,
  `meta_keywords` varchar(250) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`, `slug`, `c_description`, `c_image`, `c_img2`, `meta_title`, `meta_description`, `meta_keywords`, `parent_id`) VALUES
(37, 'Men', '', 'Men', 'pictures/category/1781469665_cat_WhatsApp Image 2026-06-14 at 1.21.48 PM.jpeg', '', 'Men', 'Men', 'Men', 0),
(39, 'Kids', '', 'Kids ', 'pictures/category/1781469806_cat_WhatsApp Image 2026-06-14 at 1.21.49 PM (1).jpeg', '', 'Kids ', 'Kids ', 'Kids ', 0),
(57, 'Women', 'women', 'Main Category for Women', 'pictures/category/1781779321_cat_WhatsApp Image 2026-06-14 at 1.21.51 PM (2).jpeg', '', '', '', '', 0),
(58, 'Shirts', 'men-shirts', 'Shirts for Men', NULL, '', NULL, NULL, NULL, 37),
(59, 'Pants', 'men-pants', 'Pants for Men', NULL, '', NULL, NULL, NULL, 37),
(60, 'Jackets', 'men-jackets', 'Jackets for Men', NULL, '', NULL, NULL, NULL, 37),
(61, 'Dresses', 'women-dresses', 'Dresses for Women', NULL, '', NULL, NULL, NULL, 57),
(62, 'Tops', 'women-tops', 'Tops for Women', NULL, '', NULL, NULL, NULL, 57),
(63, 'Skirts', 'women-skirts', 'Skirts for Women', NULL, '', NULL, NULL, NULL, 57),
(64, 'Boys', 'boys', 'Girls for Kids', 'pictures/category/1781784257_cat_kid image 8.jpg', '', 'Boys', 'Boys', 'Boys', 39),
(65, 'Girls', 'girls', 'Girls for Kids', 'pictures/category/1781784322_cat_Kids_Model_10.webp', '', 'Girls', 'Girls', 'Girls', 39),
(66, 'Infants', 'infants', 'Infants for Kids', 'pictures/category/1781784372_cat_i2.webp', '', 'Infants', 'Infants', 'Infants', 39);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `color_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`, `color_code`) VALUES
(1, 'Cyan Blue ', '#009ce5'),
(2, 'Lemon Yellow', '#c1a600'),
(3, 'Pearl Blue', '#001593'),
(4, 'Red Yam', ' #900d09'),
(5, 'Flame Blue', '#1e52a1'),
(6, 'Stove Green', '#309b87');

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `status` enum('queued','sent','failed') NOT NULL DEFAULT 'queued',
  `error_message` text DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'cod',
  `status` varchar(50) DEFAULT 'Pending',
  `tracking_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `email`, `phone`, `address`, `total`, `payment_method`, `status`, `tracking_id`, `created_at`, `invoice_no`) VALUES
(6, NULL, 'abc', 'stitchsmartofficial@gmail.com', '1234678', 'nowhere', 6000.00, 'cod', 'Pending', NULL, '2026-05-06 09:44:17', ''),
(7, NULL, 'abc', 'stitchsmartofficial@gmail.com', '1234000000', 'abc', 0.00, 'cod', 'Pending', NULL, '2026-05-07 04:34:42', ''),
(8, NULL, 'abc', 'stitchsmartofficial@gmail.com', 'abc', 'abc', 6000.00, 'cod', 'Dispatched', '9998', '2026-05-07 04:42:56', ''),
(9, NULL, 'abc', 'stitchsmartofficial@gmail.com', 'abc', 'st 123', 56.00, 'cod', 'Delivered', NULL, '2026-05-07 04:46:17', ''),
(10, NULL, 'abc', 'stitchsmartofficial@gmail.com', '123', 'st 1234', 1500.00, 'cod', 'Pending', NULL, '2026-05-07 04:47:31', ''),
(11, NULL, 'abcd', 'stitchsmartofficial@gmail.com', '12346', '1234', 3000.00, 'cod', 'Pending', NULL, '2026-05-07 04:49:31', ''),
(12, NULL, 'abc', 'stitchsmartofficial@gmail.com', '1234', 'abc', 12000.00, 'cod', 'Dispatched', '999', '2026-05-07 05:16:24', ''),
(13, NULL, 'adil', 'stitchsmartofficial@gmail.com', '24343423', 'lahore dha phase 4\r\n', 1500.00, 'cod', 'Delivered', NULL, '2026-05-07 06:19:47', ''),
(14, NULL, 'vgjhgkjgh', 'stitchsmartofficial@gmail.com', '6868767868787', 'hgdhgfdgfdghdgdhgdgfdgf', 0.00, 'cod', 'Delivered', NULL, '2026-05-07 07:03:19', ''),
(15, NULL, 'ABC', 'stitchsmartofficial@gmail.com', '+92 0006778', 'ABC', 156000.00, 'cod', 'Delivered', NULL, '2026-05-10 10:16:26', ''),
(16, NULL, 'abc', 'stitchsmartofficial@gmail.com', '+92 000000', 'abc xyz', 12000.00, 'cod', 'Delivered', NULL, '2026-05-10 10:19:01', ''),
(17, NULL, 'adil', 'stitchsmartofficial@gmail.com', '03340446466', 'adsdasdas', 0.00, 'cod', 'Delivered', NULL, '2026-05-11 07:17:30', ''),
(18, NULL, 'moiz', 'moizmalikofficiall@gmail.com', '03249670130', 'nasir road', 10000.00, 'cod', 'Pending', NULL, '2026-05-17 21:25:02', ''),
(19, 4038, 'moiz', 'moizmalikofficiall@gmail.com', '03249670130', 'ddexedx', 7699.00, 'cod', 'Pending', NULL, '2026-05-18 00:11:10', ''),
(20, 4039, 'moiz', 'moiz@gmail.com', '1234567', 'ertyui', 7499.00, 'cod', 'Delivered', NULL, '2026-05-18 09:49:20', ''),
(21, NULL, 'moiz', 'moizmalikofficiall@gmail.com', '03249670130', 'Sialkot', 7499.00, 'cod', 'Delivered', NULL, '2026-05-19 04:11:55', ''),
(22, 4040, 'Bissma Ijaz', 'bissmaijaz62@gmail.com', '1234567890', 'Sialkot', 7499.00, 'cod', 'Delivered', NULL, '2026-05-19 06:46:30', ''),
(23, 4042, 'moiz', 'stitchsmart@gmail.com', '0334523434', 'sialkot', 4000.00, 'cod', 'Dispatched', '788', '2026-05-21 09:10:26', ''),
(24, 4042, 'moiz', 'stitchsmart@gmail.com', '0334523434', 'lklk;k\'kl;llk;lk;k;', 4000.00, 'cod', 'Delivered', NULL, '2026-05-21 20:39:19', ''),
(25, 4042, 'moiz', 'stitchsmart@gmail.com', '0334523434', 'kjll', 4000.00, 'cod', 'Delivered', '68768876876', '2026-05-22 22:58:20', ''),
(26, 4042, 'moiz', 'stitchsmart@gmail.com', '0334523434', 'alkjhdkjhakjdhkahdklahdkj', 4000.00, 'cod', 'Delivered', '12333424234234', '2026-05-26 14:21:40', ''),
(27, 4042, 'moiz', 'stitchsmart@gmail.com', '0334523434', 'Nasir Rd', 11249.10, 'cod', 'Delivered', NULL, '2026-06-01 05:31:47', ''),
(28, NULL, 'StitchSmart', 'stitchsmartofficial@gmail.com', '03249670130', 'Sialkot', 14849.10, 'cod', 'Pending', NULL, '2026-06-05 05:40:30', ''),
(29, NULL, 'StitchSmart', 'stitchsmartofficial@gmail.com', '03249670130', ',nljlkjlk', 4000.00, 'cod', 'Pending', NULL, '2026-06-14 23:32:58', ''),
(30, 4044, 'Test User', 'testuser@stitchsmart.com', '+92-300-1111111', 'cas', 5500.00, 'cod', 'Delivered', '9998', '2026-06-15 00:18:33', ''),
(31, 4044, 'Test User', 'testuser@stitchsmart.com', '+92-300-1111111', ',klkl', 3000.00, 'cod', 'Dispatched', '897965432', '2026-06-15 00:44:41', ''),
(32, 4044, 'Test User', 'testuser@stitchsmart.com', '+92-300-1111111', 'bfb', 1350.00, 'cod', 'Pending', NULL, '2026-06-15 05:43:26', ''),
(33, 4044, 'Test User', 'testuser@stitchsmart.com', '+92-300-1111111', 'hjk', 4500.00, 'cod', 'Pending', NULL, '2026-06-16 04:49:06', ''),
(34, 4044, 'Test User', 'testuser@stitchsmart.com', '+92-300-1111111', 'cfvgbhb', 5000.00, 'cod', 'Delivered', NULL, '2026-06-16 07:23:20', ''),
(35, 4044, 'Test User', 'testuser@stitchsmart.com', '+92-300-1111111', 'dre', 5000.00, 'cod', 'Delivered', '123456', '2026-06-16 07:25:58', ''),
(36, 4045, 'user', 'user@gmail.com', '03034752367', 'Sialkot', 5000.00, 'cod', 'Delivered', '12478', '2026-06-16 14:46:10', ''),
(37, 4047, 'Bissma', 'bissmaijaz62@gmail.com', '03257926255', 'sialkot', 11000.00, 'cod', 'Dispatched', '76777', '2026-06-17 06:53:27', ''),
(38, 4047, 'Bissma', 'bissmaijaz62@gmail.com', '03257926255', 'sialkot', 5000.00, 'cod', 'Processing', NULL, '2026-06-17 13:09:06', ''),
(39, 4045, 'user', 'user@gmail.com', '03034752367', 'Siakkot', 4000.00, 'cod', 'Delivered', '857686', '2026-06-18 13:23:51', ''),
(40, 4045, 'user', 'user@gmail.com', '03034752367', 'sialkot', 3000.00, 'cod', 'Delivered', '1234', '2026-06-18 13:40:53', ''),
(41, 4045, 'user', 'user@gmail.com', '03034752367', 'sialkot', 3000.00, 'cod', 'Delivered', '1231434242345', '2026-06-18 13:43:40', ''),
(42, 4045, 'user', 'user@gmail.com', '03034752367', 'sialkot', 5000.00, 'bank', 'Pending', NULL, '2026-06-18 14:07:03', ''),
(43, 4047, 'Bissma', 'bissmaijaz62@gmail.com', '03257926255', 'sialkot', 8000.00, 'cod', 'Pending', NULL, '2026-06-19 08:08:58', ''),
(44, 4047, 'Bissma', 'bissmaijaz62@gmail.com', '03257926255', 'Sialkot', 2500.00, 'card', 'Delivered', '111111111', '2026-06-19 08:12:02', ''),
(45, NULL, 'StitchSmart', 'stitchsmartofficial@gmail.com', '03034752367', 'sialkot', 5000.00, 'cod', 'Processing', NULL, '2026-06-19 08:13:45', ''),
(46, 4047, 'Bissma', 'bissmaijaz62@gmail.com', '03257926255', 'sialkot', 17999.10, 'cod', 'Pending - Voucher: STITCH10', NULL, '2026-06-20 10:19:44', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(8, 6, 41, 6000.00, 1),
(9, 7, 21, 0.00, 2),
(10, 8, 41, 6000.00, 1),
(11, 9, 13, 56.00, 1),
(12, 10, 45, 1500.00, 1),
(13, 11, 24, 3000.00, 1),
(14, 12, 32, 6000.00, 2),
(15, 13, 45, 1500.00, 1),
(16, 14, 21, 0.00, 1),
(17, 15, 41, 6000.00, 26),
(18, 16, 41, 6000.00, 2),
(19, 17, 21, 0.00, 1),
(20, 18, 53, 10000.00, 1),
(21, 19, 48, 200.00, 1),
(22, 19, 59, 7499.00, 1),
(23, 20, 59, 7499.00, 1),
(24, 21, 59, 7499.00, 1),
(25, 22, 59, 7499.00, 1),
(26, 23, 62, 4000.00, 1),
(27, 24, 62, 4000.00, 1),
(28, 25, 62, 4000.00, 1),
(29, 26, 62, 4000.00, 1),
(30, 27, 63, 12499.00, 1),
(31, 28, 63, 12499.00, 1),
(32, 28, 62, 4000.00, 1),
(33, 29, 64, 4000.00, 1),
(34, 30, 65, 1500.00, 1),
(35, 30, 64, 4000.00, 1),
(36, 31, 65, 1500.00, 2),
(37, 32, 65, 1500.00, 1),
(38, 33, 98, 5000.00, 1),
(39, 34, 101, 5000.00, 1),
(40, 35, 99, 5000.00, 1),
(41, 36, 98, 5000.00, 1),
(42, 37, 82, 2000.00, 1),
(43, 37, 100, 4000.00, 1),
(44, 37, 101, 5000.00, 1),
(45, 38, 101, 5000.00, 1),
(46, 39, 66, 4000.00, 1),
(47, 40, 141, 3000.00, 1),
(48, 41, 141, 3000.00, 1),
(49, 42, 146, 5000.00, 1),
(50, 43, 146, 5000.00, 1),
(51, 43, 141, 3000.00, 1),
(52, 44, 145, 2500.00, 1),
(53, 45, 146, 5000.00, 1),
(54, 46, 142, 2000.00, 1),
(55, 46, 89, 2000.00, 1),
(56, 46, 100, 4000.00, 1),
(57, 46, 146, 5000.00, 1),
(58, 46, 126, 6999.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `publish_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `parent_id`, `is_published`, `publish_date`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', '<style>\r\n/* Scoped Variables & Typography for About Us to prevent conflicts */\r\n/* Base/Default Theme Variables for About Us */\r\n:root .about-us-wrapper,\r\n:root.theme-default .about-us-wrapper {\r\n    --au-gold-primary: #c89a5a;\r\n    --au-gold-light: #f5efe6;\r\n    --au-gold-dark: #8B6D3B;\r\n    --au-bg-main: #fcf9f2;\r\n    --au-bg-card: #ffffff;\r\n    --au-bg-hero: #f5efe6;\r\n    --au-text-main: #24150F;\r\n    --au-text-muted: #5A3D2B;\r\n    --au-border-color: rgba(90,61,43,0.12);\r\n    \r\n    --au-font-heading: \'Playfair Display\', serif;\r\n    --au-font-body: \'Plus Jakarta Sans\', sans-serif;\r\n\r\n    background-color: var(--au-bg-main);\r\n    color: var(--au-text-main);\r\n    font-family: var(--au-font-body);\r\n    overflow-x: hidden;\r\n    position: relative;\r\n}\r\n\r\n/* Luxury Theme Variables for About Us */\r\n:root.theme-luxury .about-us-wrapper {\r\n    --au-gold-primary: #C19A4E;\r\n    --au-gold-light: rgba(193, 154, 78, 0.1);\r\n    --au-gold-dark: #C19A4E;\r\n    --au-bg-main: #0a0a0a;\r\n    --au-bg-card: #141414;\r\n    --au-bg-hero: #0f0f0f;\r\n    --au-text-main: #ffffff;\r\n    --au-text-muted: #a0a0a0;\r\n    --au-border-color: rgba(193, 154, 78, 0.25);\r\n}\r\n\r\n/* Animations */\r\n@keyframes fadeInUp {\r\n    from { opacity: 0; transform: translateY(40px); }\r\n    to { opacity: 1; transform: translateY(0); }\r\n}\r\n\r\n@keyframes fadeInLeft {\r\n    from { opacity: 0; transform: translateX(-40px); }\r\n    to { opacity: 1; transform: translateX(0); }\r\n}\r\n\r\n@keyframes fadeInRight {\r\n    from { opacity: 0; transform: translateX(40px); }\r\n    to { opacity: 1; transform: translateX(0); }\r\n}\r\n\r\n@keyframes float {\r\n    0% { transform: translateY(0px); }\r\n    50% { transform: translateY(-15px); }\r\n    100% { transform: translateY(0px); }\r\n}\r\n\r\n.about-us-wrapper h1, \r\n.about-us-wrapper h2, \r\n.about-us-wrapper h3, \r\n.about-us-wrapper h4 {\r\n    font-family: var(--au-font-heading);\r\n    font-weight: 600;\r\n    color: var(--au-text-main);\r\n}\r\n\r\n/* Hero Section */\r\n.about-hero {\r\n    position: relative;\r\n    padding: 160px 0 100px;\r\n    text-align: center;\r\n    background: radial-gradient(circle at 50% 0%, var(--au-bg-hero) 0%, var(--au-bg-main) 100%);\r\n    border-bottom: 1px solid var(--au-border-color);\r\n    z-index: 1;\r\n}\r\n\r\n.about-hero .gold-accent {\r\n    color: var(--au-gold-dark);\r\n    font-size: 1.1rem;\r\n    letter-spacing: 4px;\r\n    text-transform: uppercase;\r\n    display: block;\r\n    margin-bottom: 20px;\r\n    opacity: 0;\r\n    font-weight: 600;\r\n    animation: fadeInUp 1s ease forwards;\r\n}\r\n\r\n.about-hero h1 {\r\n    font-size: 4.5rem;\r\n    color: var(--au-text-main);\r\n    margin-bottom: 30px;\r\n    opacity: 0;\r\n    animation: fadeInUp 1s ease 0.2s forwards;\r\n    line-height: 1.2;\r\n}\r\n\r\n.about-hero h1 span {\r\n    color: var(--au-gold-primary);\r\n    font-style: italic;\r\n}\r\n\r\n.about-hero p {\r\n    font-size: 1.25rem;\r\n    color: var(--au-text-muted);\r\n    max-width: 700px;\r\n    margin: 0 auto;\r\n    opacity: 0;\r\n    animation: fadeInUp 1s ease 0.4s forwards;\r\n    line-height: 1.8;\r\n}\r\n\r\n/* Story Section */\r\n.story-section {\r\n    padding: 120px 0;\r\n    position: relative;\r\n    z-index: 1;\r\n}\r\n\r\n.story-content {\r\n    opacity: 0;\r\n    animation: fadeInLeft 1s ease 0.6s forwards;\r\n    padding-right: 40px;\r\n}\r\n\r\n.story-content h2 {\r\n    font-size: 3.5rem;\r\n    color: var(--au-text-main);\r\n    margin-bottom: 30px;\r\n    position: relative;\r\n}\r\n\r\n.story-content h2 span {\r\n    color: var(--au-gold-primary);\r\n}\r\n\r\n.story-content p {\r\n    font-size: 1.15rem;\r\n    line-height: 1.9;\r\n    color: var(--au-text-muted);\r\n    margin-bottom: 25px;\r\n}\r\n\r\n.story-image-container {\r\n    position: relative;\r\n    opacity: 0;\r\n    animation: fadeInRight 1s ease 0.6s forwards;\r\n}\r\n\r\n.story-image-wrapper {\r\n    position: relative;\r\n    border-radius: 20px;\r\n    overflow: hidden;\r\n    z-index: 2;\r\n    box-shadow: 0 20px 50px rgba(0,0,0,0.1);\r\n}\r\n\r\n.story-image-wrapper img {\r\n    width: 100%;\r\n    height: 600px;\r\n    object-fit: cover;\r\n    display: block;\r\n    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);\r\n}\r\n\r\n.story-image-container:hover img {\r\n    transform: scale(1.05);\r\n}\r\n\r\n/* image accent removed */\r\n\r\n/* Team Section */\r\n.team-section {\r\n    padding: 100px 0;\r\n    background: var(--au-bg-hero);\r\n    border-top: 1px solid var(--au-border-color);\r\n    border-bottom: 1px solid var(--au-border-color);\r\n    position: relative;\r\n    z-index: 1;\r\n}\r\n\r\n.team-header {\r\n    text-align: center;\r\n    margin-bottom: 60px;\r\n}\r\n\r\n.team-header h2 {\r\n    font-size: 3.5rem;\r\n    color: var(--au-text-main);\r\n    margin-bottom: 20px;\r\n}\r\n\r\n.team-member {\r\n    text-align: center;\r\n    padding: 40px 20px;\r\n    background: var(--au-bg-card);\r\n    border: 1px solid var(--au-border-color);\r\n    border-radius: 20px;\r\n    transition: transform 0.4s ease, box-shadow 0.4s ease;\r\n    box-shadow: 0 10px 30px rgba(0,0,0,0.03);\r\n}\r\n\r\n.team-member:hover {\r\n    transform: translateY(-15px);\r\n    box-shadow: 0 25px 50px rgba(193, 154, 78, 0.15);\r\n    border-color: var(--au-gold-primary);\r\n}\r\n\r\n.team-avatar {\r\n    width: 120px;\r\n    height: 120px;\r\n    margin: 0 auto 25px;\r\n    border-radius: 50%;\r\n    background-color: var(--au-gold-light);\r\n    border: 3px solid var(--au-gold-primary);\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    font-size: 3rem;\r\n    color: var(--au-gold-dark);\r\n    overflow: hidden;\r\n}\r\n\r\n.team-name {\r\n    font-family: var(--au-font-heading);\r\n    font-size: 1.6rem;\r\n    font-weight: 600;\r\n    color: var(--au-text-main);\r\n    margin-bottom: 5px;\r\n}\r\n\r\n.team-role {\r\n    font-size: 1rem;\r\n    color: var(--au-gold-dark);\r\n    text-transform: uppercase;\r\n    letter-spacing: 2px;\r\n    font-weight: 600;\r\n}\r\n\r\n/* Core Values Section */\r\n.values-section {\r\n    padding: 120px 0;\r\n    position: relative;\r\n    z-index: 1;\r\n}\r\n\r\n.section-header {\r\n    text-align: center;\r\n    margin-bottom: 80px;\r\n}\r\n\r\n.section-header h2 {\r\n    font-size: 3.5rem;\r\n    color: var(--au-text-main);\r\n    margin-bottom: 20px;\r\n}\r\n\r\n.section-header p {\r\n    color: var(--au-text-muted);\r\n    font-size: 1.2rem;\r\n    max-width: 600px;\r\n    margin: 0 auto;\r\n}\r\n\r\n.value-card {\r\n    background: var(--au-bg-card);\r\n    border: 1px solid var(--au-border-color);\r\n    border-radius: 24px;\r\n    padding: 50px 40px;\r\n    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);\r\n    height: 100%;\r\n    position: relative;\r\n    overflow: hidden;\r\n    box-shadow: 0 10px 30px rgba(0,0,0,0.03);\r\n}\r\n\r\n.value-card:hover {\r\n    transform: translateY(-15px);\r\n    box-shadow: 0 25px 50px rgba(193, 154, 78, 0.15);\r\n    border-color: var(--au-gold-primary);\r\n}\r\n\r\n.value-card .icon-wrapper {\r\n    width: 90px;\r\n    height: 90px;\r\n    margin-bottom: 35px;\r\n    background: var(--au-bg-hero);\r\n    border-radius: 20px;\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    font-size: 2.5rem;\r\n    color: var(--au-gold-dark);\r\n    border: 1px solid var(--au-border-color);\r\n    transition: all 0.5s ease;\r\n}\r\n\r\n.value-card:hover .icon-wrapper {\r\n    transform: scale(1.1) rotate(5deg);\r\n    background: var(--au-gold-light);\r\n    color: var(--au-gold-dark);\r\n}\r\n\r\n.value-card h3 {\r\n    font-size: 1.8rem;\r\n    color: var(--au-text-main);\r\n    margin-bottom: 20px;\r\n}\r\n\r\n.value-card p {\r\n    color: var(--au-text-muted);\r\n    line-height: 1.8;\r\n    font-size: 1.05rem;\r\n    margin: 0;\r\n}\r\n\r\n/* Responsive */\r\n@media (max-width: 991px) {\r\n    .about-hero h1 { font-size: 3.5rem; }\r\n    .story-content { padding-right: 0; margin-bottom: 60px; }\r\n    .story-image-wrapper img { height: 400px; }\r\n    .image-accent-box { display: none; }\r\n}\r\n\r\n@media (max-width: 768px) {\r\n    .about-hero { padding: 120px 0 80px; }\r\n    .about-hero h1 { font-size: 2.8rem; }\r\n    .story-content h2 { font-size: 2.8rem; }\r\n    .section-header h2 { font-size: 2.8rem; }\r\n    .stat-number { font-size: 3rem; }\r\n    .value-card { padding: 40px 30px; }\r\n}\r\n</style>\r\n\r\n<div class=\"about-us-wrapper\">\r\n    <!-- Hero Section -->\r\n    <section class=\"about-hero\">\r\n        <div class=\"container\">\r\n            <span class=\"gold-accent\">The Stitch Smart Standard</span>\r\n            <h1>Crafting <span>Premium</span> Apparel</h1>\r\n            <p>Elevating the art of custom clothing with passion, precision, and an unwavering dedication to excellence.</p>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Story Section -->\r\n    <section class=\"story-section\">\r\n        <div class=\"container\">\r\n            <div class=\"row align-items-center\">\r\n                <div class=\"col-lg-6\">\r\n                    <div class=\"story-content\">\r\n                        <h2>Our <span>Legacy</span></h2>\r\n                        <p>At <strong>Stitch Smart</strong>, we believe that clothing is more than just fabric—it\'s an expression of identity, ambition, and style. Founded on the principles of superior craftsmanship, we set out to redefine custom apparel manufacturing.</p>\r\n                        <p>We source only the finest materials, employing expert artisans who pour their soul into every stitch. From luxurious hoodies and crewnecks to impeccably tailored sweatpants, we bridge the gap between your visionary designs and wearable reality.</p>\r\n                        <p>Our journey began with a simple idea: to empower brands and individuals with premium, customizable clothing that doesn\'t compromise on quality or aesthetics. Today, we stand proud as a trusted partner to creators worldwide.</p>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-lg-6\">\r\n                    <div class=\"story-image-container\">\r\n                        <div class=\"story-image-wrapper\">\r\n                            <!-- Beautiful Tailoring/Clothing Manufacturing Image -->\r\n                            <img src=\"https://images.unsplash.com/photo-1551232864-3f0890e580d9?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1200&amp;q=80\" alt=\"Premium Custom Apparel Craftsmanship\">\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Team Section -->\r\n    <section class=\"team-section\">\r\n        <div class=\"container\">\r\n            <div class=\"team-header\">\r\n                <h2>Meet the Team</h2>\r\n            </div>\r\n            <div class=\"row g-4\">\r\n                <div class=\"col-md-4\">\r\n                    <div class=\"team-member\">\r\n                        <div class=\"team-avatar\">\r\n                            <i class=\"fa-solid fa-user\"></i>\r\n                        </div>\r\n                        <div class=\"team-name\">Moiz Ahmed</div>\r\n                        <div class=\"team-role\">Founder</div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-md-4\">\r\n                    <div class=\"team-member\">\r\n                        <div class=\"team-avatar\">\r\n                            <i class=\"fa-solid fa-user\"></i>\r\n                        </div>\r\n                        <div class=\"team-name\">Bissma Ijaz</div>\r\n                        <div class=\"team-role\">Co-Founder</div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-md-4\">\r\n                    <div class=\"team-member\">\r\n                        <div class=\"team-avatar\">\r\n                            <i class=\"fa-solid fa-user\"></i>\r\n                        </div>\r\n                        <div class=\"team-name\">Ali Haider</div>\r\n                        <div class=\"team-role\">Director</div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Core Values Section -->\r\n    <section class=\"values-section\">\r\n        <div class=\"container\">\r\n            <div class=\"section-header\">\r\n                <h2>The Core Pillars</h2>\r\n                <p>The fundamental values that drive our passion and precision in every garment we create.</p>\r\n            </div>\r\n            <div class=\"row g-5\">\r\n                <!-- Value 1 -->\r\n                <div class=\"col-md-4\">\r\n                    <div class=\"value-card\">\r\n                        <div class=\"icon-wrapper\">\r\n                            <i class=\"fa-solid fa-gem\"></i>\r\n                        </div>\r\n                        <h3>Uncompromised Quality</h3>\r\n                        <p>Every garment undergoes rigorous quality control. We select premium fabrics that offer unparalleled comfort, durability, and a luxurious feel.</p>\r\n                    </div>\r\n                </div>\r\n                <!-- Value 2 -->\r\n                <div class=\"col-md-4\">\r\n                    <div class=\"value-card\">\r\n                        <div class=\"icon-wrapper\">\r\n                            <i class=\"fa-solid fa-wand-magic-sparkles\"></i>\r\n                        </div>\r\n                        <h3>Creative Freedom</h3>\r\n                        <p>Your vision, our expertise. We provide extensive customization options—from dyes to distressing—giving you the ultimate creative control.</p>\r\n                    </div>\r\n                </div>\r\n                <!-- Value 3 -->\r\n                <div class=\"col-md-4\">\r\n                    <div class=\"value-card\">\r\n                        <div class=\"icon-wrapper\">\r\n                            <i class=\"fa-solid fa-handshake-angle\"></i>\r\n                        </div>\r\n                        <h3>Trusted Partnership</h3>\r\n                        <p>We are more than manufacturers; we are your partners. We pride ourselves on transparent communication and reliable, timely delivery.</p>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </section>\r\n</div>\r\n', 'About Stitch-Smart | Premium Personalized Streetwear', 'Discover our mission to merge advanced technology with artisanal clothing craft, empowering you to design unique premium streetwear.', 'custom hoodies, design crewneck, customized clothing, streetwear brand', NULL, 1, NULL, '2025-08-01 05:11:54', '2026-06-18 12:48:16'),
(2, 'Terms and Condition', 'terms-and-condition', '<style>\n/* ── TERMS HERO ── */\n.terms-hero {\n    position: relative;\n    min-height: 380px;\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    text-align: center;\n    padding: 60px 20px;\n    border-bottom: 1px solid rgba(193, 154, 78, 0.25);\n}\n.terms-hero-content {\n    max-width: 650px;\n}\n.terms-hero h1 {\n    font-family: \'Playfair Display\', serif;\n    font-size: clamp(2.5rem, 5vw, 3.8rem);\n    font-weight: 900;\n    color: #1a0f0a;\n    margin-bottom: 20px;\n    line-height: 1.1;\n}\n.terms-hero h1 span {\n    color: #c19a4e;\n}\n.terms-hero p {\n    color: #4a4a4a;\n    font-size: 1.1rem;\n    line-height: 1.7;\n    margin-bottom: 0;\n}\n.terms-divider {\n    width: 80px;\n    height: 3px;\n    background: #c19a4e;\n    margin: 25px auto;\n    border-radius: 2px;\n}\n\n/* ── TERMS CONTENT ── */\n.terms-section {\n    padding: 40px 0 80px;\n    background-color: var(--page-bg, #000);\n}\n.terms-container {\n    background: var(--bg-card, #0a0a0a);\n    border: 1px solid rgba(193, 154, 78, 0.15);\n    border-radius: 16px;\n    padding: 50px 60px;\n    box-shadow: 0 10px 30px rgba(0,0,0,0.2);\n}\n\n.terms-content h2 {\n    font-family: \'Playfair Display\', serif;\n    color: #c19a4e;\n    font-size: 1.8rem;\n    margin-top: 40px;\n    margin-bottom: 20px;\n    font-weight: 700;\n    border-bottom: 1px solid rgba(193, 154, 78, 0.15);\n    padding-bottom: 10px;\n}\n.terms-content h2:first-child {\n    margin-top: 0;\n}\n.terms-content p {\n    color: var(--page-text, #f4e9d3);\n    opacity: 0.85;\n    font-size: 1.05rem;\n    line-height: 1.8;\n    margin-bottom: 20px;\n}\n.terms-content ul {\n    color: var(--page-text, #f4e9d3);\n    opacity: 0.85;\n    font-size: 1.05rem;\n    line-height: 1.8;\n    margin-bottom: 25px;\n    padding-left: 20px;\n}\n.terms-content li {\n    margin-bottom: 10px;\n}\n\n@media (max-width: 768px) {\n    .terms-container {\n        padding: 30px 20px;\n    }\n}\n</style>\n\n<div class=\"terms-page-wrap\">\n    <!-- Hero Section -->\n    <section class=\"terms-hero\">\n        <div class=\"terms-hero-content\">\n            <h1 class=\"animate-fade-up\">Terms & <span>Conditions</span></h1>\n            <div class=\"terms-divider animate-fade-up\"></div>\n            <p class=\"animate-fade-up\">Please read these terms carefully. By using our platform, you agree to the conditions outlining our services, custom tailoring policies, and your rights as a consumer.</p>\n        </div>\n    </section>\n\n    <!-- Terms Content -->\n    <section class=\"terms-section\">\n        <div class=\"container\">\n            <div class=\"row justify-content-center\">\n                <div class=\"col-lg-10\">\n                    <div class=\"terms-container animate-fade-up\">\n                        <div class=\"terms-content\">\n                            \n                            <h2>1. Introduction</h2>\n                            <p>Welcome to StitchSmart. These Terms and Conditions govern your use of our website and services. By accessing our platform, placing an order, or utilizing our custom tailoring services, you agree to be bound by these terms in full.</p>\n\n                            <h2>2. Custom Tailoring & Measurements</h2>\n                            <p>At Stitch Smart, every custom-tailored garment is meticulously crafted to your unique specifications to ensure a flawless, premium fit.</p>\n                            \n\n                            <h2>3. Order Processing & Deposits</h2>\n                            <p>For custom orders, a 50% non-refundable deposit is required to initiate the crafting process. The remaining balance must be cleared prior to dispatch. Standard retail items require full payment at checkout.</p>\n                            <p>Orders cannot be canceled once the fabric has been cut or the crafting process has commenced.</p>\n\n                            <h2>4. Pricing & Payments</h2>\n                            <p>All prices are subject to change without notice. We reserve the right to modify or discontinue any product or service without prior notice. Secure checkout is provided, and we do not store your payment information on our servers.</p>\n\n                            <h2>5. Returns & Alterations</h2>\n                            <p>Due to the personalized nature of custom garments, we do not offer full refunds on bespoke items. However, we are committed to your satisfaction and offer complementary alterations within 14 days of delivery if the garment does not meet the agreed specifications.</p>\n                            <p>Standard retail items (non-custom) can be returned within 14 days in their original, unworn condition.</p>\n\n                            <h2>6. Intellectual Property</h2>\n                            <p>All content, designs, logos, and materials present on the StitchSmart platform are the exclusive property of StitchSmart. Unauthorized use, reproduction, or distribution is strictly prohibited.</p>\n\n                            <h2>7. Limitation of Liability</h2>\n                            <p>StitchSmart shall not be liable for any indirect, incidental, or consequential damages arising from the use of our products or services. Our maximum liability shall not exceed the total amount paid by you for the product in question.</p>\n\n                            <h2>8. Contact & Notices</h2>\n                            <p>If you have any questions regarding these Terms and Conditions or need to serve notice, please reach out to us exclusively through our <strong>Contact Support</strong> portal or via the phone numbers provided on our platform. We do not process legal or formal disputes via email.</p>\n                            \n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </section>\n</div>\n\n<script>\n    document.addEventListener(\"DOMContentLoaded\", function() {\n        const elements = document.querySelectorAll(\'.animate-fade-up\');\n        elements.forEach((el, index) => {\n            el.style.opacity = \'0\';\n            el.style.transform = \'translateY(20px)\';\n            el.style.transition = `opacity 0.8s ease, transform 0.8s ease`;\n            \n            setTimeout(() => {\n                el.style.opacity = \'1\';\n                el.style.transform = \'translateY(0)\';\n            }, 50 + (index * 150)); \n        });\n    });\n</script>\n', 'Terms & Conditions | Stich Smart Clothing', 'Review the Terms & Conditions of Stich Smart Clothing to understand our policies on product usage, orders, payments, returns, and customer responsibilities when using our ecommerce store.', 'terms and conditions clothing store, Stich Smart policies, ecommerce terms, online shopping rules, return policy, payment terms, user agreement clothing', NULL, 1, NULL, '2025-08-07 10:59:39', '2026-05-11 07:11:52'),
(3, 'Return and Refunds', 'return-and-refunds', '<style>\r\n\r\n\r\n    .sidebar {\r\n      background: rgba(255, 255, 255, 0.85);\r\n      backdrop-filter: blur(8px);\r\n      border: 1px solid #d5deed;\r\n      border-radius: 16px;\r\n      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);\r\n      padding: 20px;\r\n    }\r\n\r\n    .sidebar .nav-link2 {\r\n      color: #333;\r\n      font-size: 0.95rem;\r\n     padding:10px 15px;\r\n      border-radius: 8px;\r\n      transition: 0.3s ease;\r\n    }\r\n\r\n    .sidebar .nav-link2:hover,\r\n    .sidebar .nav-link2.active {\r\n      background-color: #e0f7fa;\r\n      color: ##3bafc0;\r\n      font-weight: 500;\r\n    }\r\n\r\n    .content-box {\r\n      background: #ffffff;\r\n      padding: 2.5rem;\r\n      border-radius: 18px;\r\n      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.03);\r\n      border: 1px solid #d5deed;\r\n    }\r\n\r\n    h2 {\r\n      font-weight: 600;\r\n      font-size: 2rem;\r\n      margin-bottom: 1rem;\r\n    }\r\n\r\n    h4 {\r\n      font-size: 1.25rem;\r\n      color: #0d6efd;\r\n      margin-top: 2rem;\r\n      margin-bottom: 0.5rem;\r\n    }\r\n\r\n    .breadcrumb {\r\n      font-size: 0.85rem;\r\n    }\r\n\r\n    ul li {\r\n      margin-bottom: 6px;\r\n    }\r\n\r\n    a {\r\n      text-decoration: none;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n      .sidebar {\r\n        margin-bottom: 1.5rem;\r\n      }\r\n    }\r\n  </style>\r\n\r\n<div class=\"container\">\r\n  <!-- Breadcrumb -->\r\n\r\n  <div class=\"row\">\r\n    <!-- Sidebar -->\r\n    <div class=\"col-md-4 col-lg-3\">\r\n      <div class=\"sidebar\">\r\n        <h6 class=\"text-center fw-bold mb-3\" style=\"text-align: center; \">Information Pages</h6>\r\n        <nav class=\"nav flex-column\" style=\"border-top:1px solid #5b5758;\">\r\n          <a class=\"nav-link2\" href=\"terms-and-condition\"><i class=\"bi bi-info-circle me-2\"></i>Terms & Conditions</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"shipping-and-delivery\"><i class=\"bi bi-truck me-2\"></i>Shpping & Delivery</a>\r\n          <a class=\"nav-link2 active\" href=\"return-and-refunds\"><i class=\"bi bi-arrow-counterclockwise me-2\"></i>Returns & Refunds</a>\r\n          <a class=\"nav-link2\" href=\"payment-and-financing\"><i class=\"bi bi-credit-card me-2\"></i>Payment & Financing</a>\r\n          \r\n          <a class=\"nav-link2\" href=\"my-account\"><i class=\"bi bi-person-circle me-2\"></i>My Account</a>\r\n          <a class=\"nav-link2\" href=\"newsletter\"><i class=\"bi bi-envelope-open me-2\"></i>Newsletter</a>\r\n\r\n          <a class=\"nav-link2\" href=\"how-to-order\"><i class=\"bi bi-cart-plus me-2\"></i>How to Order</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"product-advice\"><i class=\"bi bi-patch-check me-2\"></i>Product Advice</a>\r\n          <a class=\"nav-link2\" href=\"preferred-delivery\"><i class=\"bi bi-box2-heart me-2\"></i>Preferred Delivery</a>\r\n        </nav>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- Content -->\r\n    <div class=\"col-md-8 col-lg-9\">\r\n      <div class=\"content-box\">\r\n        <h2>Returns & Refunds</h2>\r\n        <p class=\"text-muted\">We make returns simple and worry-free. Learn how to return items, request refunds, and get support if needed.</p>\r\n        <hr>\r\n\r\n        <h4><font color=\"#25a0b1\">How do I return an item?</font></h4>\r\n        <p>You may return any eligible item within 14 days of delivery. Items must be unused and in their original packaging. Certain products such as customized or intimate goods are not returnable.</p>\r\n\r\n        <h4><font color=\"#25a0b1\">How do I pack an item for return?</font></h4>\r\n        <p>Use the original packaging where possible. Ensure the product is secure to avoid damage during transit.</p>\r\n\r\n        <h4><font color=\"#25a0b1\">Returning as a registered customer:</font></h4>\r\n        <ul>\r\n          <li>Login to your account and go to <strong>My Orders</strong>.</li>\r\n          <li>Select the product and click <strong>“Return Item”</strong>.</li>\r\n          <li>We will email you a prepaid return label.</li>\r\n          <li>Print and attach the label to your package, and drop it at a return point.</li>\r\n        </ul>\r\n\r\n        <h4><font color=\"#25a0b1\">Returning as a guest:</font></h4>\r\n        <ul>\r\n          <li>Email us at <font color=\"#311873\"><b>info</b></font><a href=\"mailto:support@example.com\"><font color=\"#311873\"><b>@meditip.</b></font></a><font color=\"#311873\"><b>store</b></font> with your order details.</li>\r\n          <li>We will send you a return label with further instructions.</li>\r\n        </ul>\r\n\r\n        <h4><font color=\"#25a0b1\">Refund timeline</font></h4>\r\n        <p>Refunds are processed within 5–7 business days after inspection of returned items. You will be notified via email once the refund is issued.</p>\r\n\r\n        <h4><font color=\"#42adc2\">Need assistance?</font></h4>\r\n        <p>Call us at <strong>+92 321 6101111</strong> or chat with our team online during business hours.</p>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>', 'Return & Refund Policy | Stich Smart Clothing', 'Learn about Stich Smart Clothing’s return and refund policy, including eligibility, timeframes, and procedures for returning items and requesting refunds through our ecommerce store.', 'return and refund policy, clothing returns, refund process, exchange policy, online store returns, Stich Smart refunds, product return terms', NULL, 1, NULL, '2025-08-08 04:54:34', '2026-05-06 07:09:33'),
(4, 'Shipping and Delivery', 'shipping-and-delivery', '<style>\n/* ── SHIPPING HERO ── */\n.shipping-hero {\n    position: relative;\n    min-height: 380px;\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    text-align: center;\n    padding: 60px 20px;\n    border-bottom: 1px solid rgba(193, 154, 78, 0.25);\n}\n.shipping-hero-content {\n    max-width: 650px;\n}\n.shipping-hero h1 {\n    font-family: \'Playfair Display\', serif;\n    font-size: clamp(2.5rem, 5vw, 3.8rem);\n    font-weight: 900;\n    color: #1a0f0a;\n    margin-bottom: 20px;\n    line-height: 1.1;\n}\n.shipping-hero h1 span {\n    color: #c19a4e;\n}\n.shipping-hero p {\n    color: #4a4a4a;\n    font-size: 1.1rem;\n    line-height: 1.7;\n    margin-bottom: 0;\n}\n.shipping-hero-divider {\n    width: 80px;\n    height: 3px;\n    background: #c19a4e;\n    margin: 25px auto;\n    border-radius: 2px;\n}\n\n/* ── SHIPPING INFO SECTION ── */\n.shipping-section {\n    padding: 40px 0 80px;\n    background-color: var(--page-bg, #000);\n}\n.shipping-card {\n    background: var(--bg-card, #0a0a0a);\n    border: 1px solid rgba(193, 154, 78, 0.15);\n    border-radius: 16px;\n    padding: 40px 30px;\n    height: 100%;\n    transition: all 0.4s ease;\n    text-align: left;\n}\n.shipping-card:hover {\n    transform: translateY(-5px);\n    border-color: #c19a4e;\n    box-shadow: 0 15px 35px rgba(0,0,0,0.3);\n}\n.shipping-icon-wrapper {\n    width: 60px;\n    height: 60px;\n    border-radius: 12px;\n    background: rgba(193, 154, 78, 0.1);\n    color: #c19a4e;\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    font-size: 1.8rem;\n    margin-bottom: 25px;\n    border: 1px solid rgba(193, 154, 78, 0.25);\n}\n.shipping-card h3 {\n    font-family: \'Playfair Display\', serif;\n    font-size: 1.4rem;\n    color: #c19a4e;\n    margin-bottom: 15px;\n    font-weight: 700;\n}\n.shipping-card p {\n    color: var(--page-text, #f4e9d3);\n    opacity: 0.85;\n    font-size: 0.95rem;\n    line-height: 1.6;\n    margin-bottom: 15px;\n}\n.shipping-badge {\n    display: inline-block;\n    padding: 6px 12px;\n    background: rgba(193, 154, 78, 0.1);\n    color: #c19a4e;\n    border-radius: 30px;\n    font-size: 0.85rem;\n    font-weight: 600;\n    margin-bottom: 15px;\n    border: 1px solid rgba(193, 154, 78, 0.2);\n}\n\n/* ── TRACKING CTA ── */\n.shipping-cta {\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    padding: 70px 0;\n    text-align: center;\n    border-top: 1px solid rgba(193, 154, 78, 0.25);\n}\n.shipping-cta h2 {\n    font-family: \'Playfair Display\', serif;\n    color: #1a0f0a;\n    font-size: 2.2rem;\n    margin-bottom: 20px;\n}\n.shipping-cta p {\n    color: #4a4a4a;\n    max-width: 600px;\n    margin: 0 auto 30px;\n    font-size: 1.05rem;\n}\n.btn-gold {\n    background: #c19a4e;\n    color: #fff;\n    padding: 14px 35px;\n    border-radius: 50px;\n    font-weight: 600;\n    text-decoration: none;\n    text-transform: uppercase;\n    letter-spacing: 1px;\n    font-size: 0.9rem;\n    transition: all 0.3s ease;\n    border: none;\n    display: inline-block;\n}\n.btn-gold:hover {\n    background: #e8c97a;\n    color: #1a0f0a;\n    transform: translateY(-2px);\n    box-shadow: 0 5px 15px rgba(193, 154, 78, 0.3);\n}\n</style>\n\n<div class=\"shipping-page-wrap\">\n    <!-- Hero Section -->\n    <section class=\"shipping-hero\">\n        <div class=\"shipping-hero-content\">\n            <h1 class=\"animate-fade-up\">Shipping & <span>Delivery</span></h1>\n            <div class=\"shipping-hero-divider animate-fade-up\"></div>\n            <p class=\"animate-fade-up\">Fast, reliable, and premium delivery services to ensure your tailored garments arrive in perfect condition, exactly when you expect them.</p>\n        </div>\n    </section>\n\n    <!-- Shipping Cards Section -->\n    <section class=\"shipping-section\">\n        <div class=\"container\">\n            <div class=\"row g-4 justify-content-center\">\n                \n                <!-- Standard Shipping -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"shipping-card animate-fade-up\">\n                        <div class=\"shipping-icon-wrapper\">\n                            <i class=\"bi bi-box-seam\"></i>\n                        </div>\n                        <div class=\"shipping-badge\">Free Over $50</div>\n                        <h3>Standard Delivery</h3>\n                        <p>Enjoy our reliable standard shipping for everyday orders. Deliveries typically arrive within 3-5 business days once your garments are dispatched from our tailoring house.</p>\n                        <p><strong>Cost:</strong> Free for orders over $50, otherwise standard flat rates apply.</p>\n                    </div>\n                </div>\n\n                <!-- Express Delivery -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"shipping-card animate-fade-up\" style=\"transition-delay: 0.1s;\">\n                        <div class=\"shipping-icon-wrapper\">\n                            <i class=\"bi bi-lightning-charge\"></i>\n                        </div>\n                        <div class=\"shipping-badge\">Next Day Options</div>\n                        <h3>Express Shipping</h3>\n                        <p>Need it sooner? Select our Express Shipping option at checkout for priority processing and expedited delivery within 1-2 business days.</p>\n                        <p>Perfect for last-minute events and urgent tailoring requests.</p>\n                    </div>\n                </div>\n\n                <!-- Custom Orders Processing -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"shipping-card animate-fade-up\" style=\"transition-delay: 0.2s;\">\n                        <div class=\"shipping-icon-wrapper\">\n                            <i class=\"bi bi-scissors\"></i>\n                        </div>\n                        <div class=\"shipping-badge\">Bespoke Timeline</div>\n                        <h3>Custom Orders Processing</h3>\n                        <p>Due to the meticulous nature of custom tailoring, bespoke orders require a crafting period of 10-14 days before they are shipped.</p>\n                        <p>You will receive status updates as your garment moves from cutting to final stitching.</p>\n                    </div>\n                </div>\n\n                <!-- International Shipping -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"shipping-card animate-fade-up\">\n                        <div class=\"shipping-icon-wrapper\">\n                            <i class=\"bi bi-globe\"></i>\n                        </div>\n                        <h3>International Shipping</h3>\n                        <p>We proudly ship our premium garments worldwide. International delivery times vary depending on the destination and local customs processing (typically 7-14 days).</p>\n                        <p><strong>Note:</strong> Customers are responsible for any import duties or taxes.</p>\n                    </div>\n                </div>\n\n                <!-- Package Tracking -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"shipping-card animate-fade-up\" style=\"transition-delay: 0.1s;\">\n                        <div class=\"shipping-icon-wrapper\">\n                            <i class=\"bi bi-pin-map\"></i>\n                        </div>\n                        <h3>Order Tracking</h3>\n                        <p>Once your order is dispatched, you will receive a tracking link via SMS. You can monitor your package\'s journey from our workshop directly to your doorstep.</p>\n                        <p>All premium shipments are fully insured for your peace of mind.</p>\n                    </div>\n                </div>\n                \n                <!-- Returns & Issues -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"shipping-card animate-fade-up\" style=\"transition-delay: 0.2s;\">\n                        <div class=\"shipping-icon-wrapper\">\n                            <i class=\"bi bi-arrow-counterclockwise\"></i>\n                        </div>\n                        <h3>Delivery Issues</h3>\n                        <p>In the rare event that your package is delayed, damaged, or lost in transit, our support team will resolve the issue immediately.</p>\n                        <p>Simply reach out via our contact page, and we will initiate a replacement or investigation.</p>\n                    </div>\n                </div>\n\n            </div>\n        </div>\n    </section>\n\n    <!-- CTA Section -->\n    <section class=\"shipping-cta\">\n        <div class=\"container\">\n            <h2>Track Your Order or Need Help?</h2>\n            <p>If you have any questions regarding an existing shipment, please contact our dispatch team through the support portal.</p>\n            <a href=\"<?= BASE_URL ?>/index.php?page=contact\" class=\"btn-gold\">Contact Support</a>\n        </div>\n    </section>\n</div>\n\n<script>\n    document.addEventListener(\"DOMContentLoaded\", function() {\n        const elements = document.querySelectorAll(\'.animate-fade-up\');\n        elements.forEach((el, index) => {\n            el.style.opacity = \'0\';\n            el.style.transform = \'translateY(20px)\';\n            el.style.transition = `opacity 0.8s ease, transform 0.8s ease`;\n            \n            setTimeout(() => {\n                el.style.opacity = \'1\';\n                el.style.transform = \'translateY(0)\';\n            }, 50 + (index * 50)); \n        });\n    });\n</script>\n', 'Shipping & Delivery Policy | Stich Smart Clothing', 'Explore Stich Smart Clothing’s shipping and delivery policy, including order processing times, shipping methods, delivery timelines, and tracking details for a smooth shopping experience.', 'shipping policy, delivery information, order shipping, ecommerce delivery, shipping time, Stich Smart delivery, online clothing shipping', NULL, 1, NULL, '2025-08-08 08:17:12', '2026-05-11 07:10:20'),
(5, 'Payment & Financing', 'payment-and-financing', '<style>\n/* ── PAYMENT & FINANCING HERO ── */\n.finance-hero {\n    position: relative;\n    min-height: 380px;\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    text-align: center;\n    padding: 60px 20px;\n    border-bottom: 1px solid rgba(193, 154, 78, 0.25);\n}\n.finance-hero-content {\n    max-width: 650px;\n}\n.finance-hero h1 {\n    font-family: \'Playfair Display\', serif;\n    font-size: clamp(2.5rem, 5vw, 3.8rem);\n    font-weight: 900;\n    color: #1a0f0a;\n    margin-bottom: 20px;\n    line-height: 1.1;\n}\n.finance-hero h1 span {\n    color: #c19a4e;\n}\n.finance-hero p {\n    color: #4a4a4a;\n    font-size: 1.1rem;\n    line-height: 1.7;\n    margin-bottom: 0;\n}\n.finance-hero-divider {\n    width: 80px;\n    height: 3px;\n    background: #c19a4e;\n    margin: 25px auto;\n    border-radius: 2px;\n}\n\n/* ── SECURE PAYMENT SECTION ── */\n.payment-section {\n    padding: 40px 0 80px;\n    background-color: var(--page-bg, #000);\n}\n.payment-card {\n    background: var(--bg-card, #0a0a0a);\n    border: 1px solid rgba(193, 154, 78, 0.15);\n    border-radius: 16px;\n    padding: 40px 30px;\n    height: 100%;\n    transition: all 0.4s ease;\n    text-align: left;\n}\n.payment-card:hover {\n    transform: translateY(-5px);\n    border-color: #c19a4e;\n    box-shadow: 0 15px 35px rgba(0,0,0,0.3);\n}\n.payment-icon-wrapper {\n    width: 60px;\n    height: 60px;\n    border-radius: 12px;\n    background: rgba(193, 154, 78, 0.1);\n    color: #c19a4e;\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    font-size: 1.8rem;\n    margin-bottom: 25px;\n    border: 1px solid rgba(193, 154, 78, 0.25);\n}\n.payment-card h3 {\n    font-family: \'Playfair Display\', serif;\n    font-size: 1.4rem;\n    color: #c19a4e;\n    margin-bottom: 15px;\n    font-weight: 700;\n}\n.payment-card p {\n    color: var(--page-text, #f4e9d3);\n    opacity: 0.85;\n    font-size: 0.95rem;\n    line-height: 1.6;\n    margin-bottom: 10px;\n}\n.payment-logos {\n    display: flex;\n    gap: 15px;\n    margin-top: 20px;\n    font-size: 1.5rem;\n    color: #a0a0a0;\n}\n\n/* ── FINANCING CTA ── */\n.finance-cta {\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    padding: 70px 0;\n    text-align: center;\n    border-top: 1px solid rgba(193, 154, 78, 0.25);\n}\n.finance-cta h2 {\n    font-family: \'Playfair Display\', serif;\n    color: #1a0f0a;\n    font-size: 2.2rem;\n    margin-bottom: 20px;\n}\n.finance-cta p {\n    color: #4a4a4a;\n    max-width: 600px;\n    margin: 0 auto 30px;\n    font-size: 1.05rem;\n}\n.btn-gold {\n    background: #c19a4e;\n    color: #fff;\n    padding: 14px 35px;\n    border-radius: 50px;\n    font-weight: 600;\n    text-decoration: none;\n    text-transform: uppercase;\n    letter-spacing: 1px;\n    font-size: 0.9rem;\n    transition: all 0.3s ease;\n    border: none;\n    display: inline-block;\n}\n.btn-gold:hover {\n    background: #e8c97a;\n    color: #1a0f0a;\n    transform: translateY(-2px);\n    box-shadow: 0 5px 15px rgba(193, 154, 78, 0.3);\n}\n</style>\n\n<div class=\"finance-page-wrap\">\n    <!-- Hero Section -->\n    <section class=\"finance-hero\">\n        <div class=\"finance-hero-content\">\n            <h1 class=\"animate-fade-up\">Payment & <span>Financing</span></h1>\n            <div class=\"finance-hero-divider animate-fade-up\"></div>\n            <p class=\"animate-fade-up\">Experience seamless, secure, and flexible payment options tailored for your convenience. Shop our premium collections with complete peace of mind.</p>\n        </div>\n    </section>\n\n    <!-- Payment Cards Section -->\n    <section class=\"payment-section\">\n        <div class=\"container\">\n            <div class=\"row g-4 justify-content-center\">\n                \n                <!-- Secure Checkout -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"payment-card\">\n                        <div class=\"payment-icon-wrapper\">\n                            <i class=\"bi bi-shield-lock\"></i>\n                        </div>\n                        <h3>100% Secure Checkout</h3>\n                        <p>Your security is our top priority. All transactions are encrypted using state-of-the-art SSL technology to protect your personal and payment information.</p>\n                        <p>We do not store your credit card details on our servers, ensuring an industry-leading standard of data protection.</p>\n                    </div>\n                </div>\n\n                <!-- Payment Methods -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"payment-card\">\n                        <div class=\"payment-icon-wrapper\">\n                            <i class=\"bi bi-credit-card-2-front\"></i>\n                        </div>\n                        <h3>Accepted Payment Methods</h3>\n                        <p>We accept all major global credit and debit cards for instant, hassle-free checkout.</p>\n                        \n                    </div>\n                </div>\n\n                <!-- Financing / Buy Now Pay Later -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"payment-card\">\n                        <div class=\"payment-icon-wrapper\">\n                            <i class=\"bi bi-wallet2\"></i>\n                        </div>\n                        <h3>Flexible Financing</h3>\n                        <p>Luxury should be accessible. Take advantage of our \"Buy Now, Pay Later\" options to split your purchase into manageable installments.</p>\n                        <p><strong>Pay in 4:</strong> Split your total into 4 interest-free payments billed every two weeks.</p>\n                    </div>\n                </div>\n\n                <!-- Custom Orders -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"payment-card\">\n                        <div class=\"payment-icon-wrapper\">\n                            <i class=\"bi bi-scissors\"></i>\n                        </div>\n                        <h3>Custom Tailoring Deposits</h3>\n                        <p>For bespoke and custom tailoring orders, we require a 50% upfront deposit to begin crafting your garment.</p>\n                        <p>The remaining 50% balance is charged only when your garment is ready to be shipped. We will notify you via email with a final invoice link.</p>\n                    </div>\n                </div>\n                \n                <!-- Refunds -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"payment-card\">\n                        <div class=\"payment-icon-wrapper\">\n                            <i class=\"bi bi-arrow-counterclockwise\"></i>\n                        </div>\n                        <h3>Refunds & Processing</h3>\n                        <p>If a refund is issued according to our return policy, the funds will be automatically credited back to your original payment method.</p>\n                        <p>Please allow 3-5 business days for the amount to reflect in your account, depending on your bank\'s processing times.</p>\n                    </div>\n                </div>\n\n            </div>\n        </div>\n    </section>\n\n    <!-- CTA Section -->\n    <section class=\"finance-cta\">\n        <div class=\"container\">\n            <h2>Have Payment Questions?</h2>\n            <p>If you\'re having trouble with checkout or want to discuss financing for a bulk custom order, our billing team is here to assist you.</p>\n            <a href=\"<?= BASE_URL ?>/index.php?page=contact\" class=\"btn-gold\">Contact Support</a>\n        </div>\n    </section>\n</div>\n\n<script>\n    document.addEventListener(\"DOMContentLoaded\", function() {\n        const heroElements = document.querySelectorAll(\'.animate-fade-up\');\n        heroElements.forEach((el, index) => {\n            el.style.opacity = \'0\';\n            el.style.transform = \'translateY(20px)\';\n            el.style.transition = `opacity 0.8s ease ${index * 0.15}s, transform 0.8s ease ${index * 0.15}s`;\n            \n            setTimeout(() => {\n                el.style.opacity = \'1\';\n                el.style.transform = \'translateY(0)\';\n            }, 50);\n        });\n    });\n</script>\n', 'Payment & Financing | Stitch-Smart Secure Payments', 'Explore safe payment options including Credit/Debit card checkout, mobile wallet transfers, and flexible interest-free monthly installment plans.', 'easypaisa payment, secure clothing check, interest free installments', NULL, 1, NULL, '2025-08-08 11:24:12', '2026-05-18 22:24:16');
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `parent_id`, `is_published`, `publish_date`, `created_at`, `updated_at`) VALUES
(6, 'How to Order', 'how-to-order', '<style>\n/* ── HOW TO ORDER HERO ── */\n.order-hero {\n    position: relative;\n    min-height: 380px;\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    text-align: center;\n    padding: 60px 20px;\n    border-bottom: 1px solid rgba(193, 154, 78, 0.25);\n}\n.order-hero-content {\n    max-width: 650px;\n}\n.order-hero h1 {\n    font-family: \'Playfair Display\', serif;\n    font-size: clamp(2.5rem, 5vw, 3.8rem);\n    font-weight: 900;\n    color: #1a0f0a;\n    margin-bottom: 20px;\n    line-height: 1.1;\n}\n.order-hero h1 span {\n    color: #c19a4e;\n}\n.order-hero p {\n    color: #4a4a4a;\n    font-size: 1.1rem;\n    line-height: 1.7;\n    margin-bottom: 0;\n}\n.order-divider {\n    width: 80px;\n    height: 3px;\n    background: #c19a4e;\n    margin: 25px auto;\n    border-radius: 2px;\n}\n\n/* ── STEPS SECTION ── */\n.steps-section {\n    padding: 40px 0 80px;\n    background-color: var(--page-bg, #000);\n}\n.step-container {\n    max-width: 900px;\n    margin: 0 auto;\n}\n.step-card {\n    background: var(--bg-card, #0a0a0a);\n    border: 1px solid rgba(193, 154, 78, 0.15);\n    border-radius: 16px;\n    padding: 40px 50px;\n    margin-bottom: 30px;\n    display: flex;\n    align-items: center;\n    gap: 40px;\n    transition: all 0.4s ease;\n    box-shadow: 0 10px 30px rgba(0,0,0,0.2);\n}\n.step-card:hover {\n    transform: translateX(10px);\n    border-color: #c19a4e;\n}\n.step-number {\n    flex-shrink: 0;\n    width: 100px;\n    height: 100px;\n    border-radius: 50%;\n    background: linear-gradient(135deg, #c19a4e, #e8c97a);\n    color: #1a0f0a;\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    font-size: 2.5rem;\n    font-weight: 900;\n    font-family: \'Playfair Display\', serif;\n    border: 4px solid var(--bg-card, #0a0a0a);\n    outline: 2px solid #c19a4e;\n}\n.step-content {\n    flex-grow: 1;\n}\n.step-content h3 {\n    font-family: \'Playfair Display\', serif;\n    font-size: 1.8rem;\n    color: #c19a4e;\n    margin-bottom: 15px;\n    font-weight: 700;\n}\n.step-content p {\n    color: var(--page-text, #f4e9d3);\n    opacity: 0.85;\n    font-size: 1.05rem;\n    line-height: 1.7;\n    margin-bottom: 0;\n}\n\n@media (max-width: 768px) {\n    .step-card {\n        flex-direction: column;\n        text-align: center;\n        padding: 40px 30px;\n        gap: 20px;\n    }\n    .step-card:hover {\n        transform: translateY(-10px);\n    }\n}\n\n/* ── CTA SECTION ── */\n.order-cta {\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    padding: 70px 0;\n    text-align: center;\n    border-top: 1px solid rgba(193, 154, 78, 0.25);\n}\n.order-cta h2 {\n    font-family: \'Playfair Display\', serif;\n    color: #1a0f0a;\n    font-size: 2.2rem;\n    margin-bottom: 20px;\n}\n.order-cta p {\n    color: #4a4a4a;\n    max-width: 600px;\n    margin: 0 auto 30px;\n    font-size: 1.05rem;\n}\n.btn-gold {\n    background: #c19a4e;\n    color: #fff;\n    padding: 14px 35px;\n    border-radius: 50px;\n    font-weight: 600;\n    text-decoration: none;\n    text-transform: uppercase;\n    letter-spacing: 1px;\n    font-size: 0.9rem;\n    transition: all 0.3s ease;\n    border: none;\n    display: inline-block;\n}\n.btn-gold:hover {\n    background: #e8c97a;\n    color: #1a0f0a;\n    transform: translateY(-2px);\n    box-shadow: 0 5px 15px rgba(193, 154, 78, 0.3);\n}\n</style>\n\n<div class=\"order-page-wrap\">\n    <!-- Hero Section -->\n    <section class=\"order-hero\">\n        <div class=\"order-hero-content\">\n            <h1 class=\"animate-fade-up\">How to <span>Order</span></h1>\n            <div class=\"order-divider animate-fade-up\"></div>\n            <p class=\"animate-fade-up\">Experiencing premium tailoring has never been easier. Follow our simple four-step process to get your bespoke garments crafted to perfection.</p>\n        </div>\n    </section>\n\n    <!-- Steps Section -->\n    <section class=\"steps-section\">\n        <div class=\"container\">\n            <div class=\"step-container\">\n                \n                <!-- Step 1 -->\n                <div class=\"step-card animate-fade-up\">\n                    <div class=\"step-number\">1</div>\n                    <div class=\"step-content\">\n                        <h3>Select Your Style</h3>\n                        <p>Browse through our exclusive collections. Whether you\'re looking for a sharp business suit, an elegant evening dress, or custom casual wear, choose the design that speaks to you.</p>\n                    </div>\n                </div>\n\n                <!-- Step 2 -->\n                <div class=\"step-card animate-fade-up\" style=\"transition-delay: 0.1s;\">\n                    <div class=\"step-number\">2</div>\n                    <div class=\"step-content\">\n                        <h3>Provide Measurements</h3>\n                        <p>For custom items, simply follow our easy-to-use measurement guide online. Enter your exact specifications, or choose standard sizing if you prefer an off-the-rack fit.</p>\n                    </div>\n                </div>\n\n                <!-- Step 3 -->\n                <div class=\"step-card animate-fade-up\" style=\"transition-delay: 0.2s;\">\n                    <div class=\"step-number\">3</div>\n                    <div class=\"step-content\">\n                        <h3>Secure Checkout</h3>\n                        <p>Review your order details and proceed to our encrypted checkout. We offer a 50% upfront deposit option for large custom orders and accept all major secure payment methods.</p>\n                    </div>\n                </div>\n\n                <!-- Step 4 -->\n                <div class=\"step-card animate-fade-up\" style=\"transition-delay: 0.3s;\">\n                    <div class=\"step-number\">4</div>\n                    <div class=\"step-content\">\n                        <h3>Crafting & Delivery</h3>\n                        <p>Our master tailors immediately begin crafting your piece. You will receive updates along the way. Once perfected, your garment is securely shipped straight to your door.</p>\n                    </div>\n                </div>\n\n            </div>\n        </div>\n    </section>\n\n    <!-- CTA Section -->\n    <section class=\"order-cta\">\n        <div class=\"container\">\n            <h2>Ready to Elevate Your Wardrobe?</h2>\n            <p>Start browsing our latest premium collections and experience the true art of bespoke tailoring today.</p>\n            <a href=\"<?= BASE_URL ?>/index.php?page=allproducts\" class=\"btn-gold\">Shop Now</a>\n        </div>\n    </section>\n</div>\n\n<script>\n    document.addEventListener(\"DOMContentLoaded\", function() {\n        const elements = document.querySelectorAll(\'.animate-fade-up\');\n        elements.forEach((el, index) => {\n            el.style.opacity = \'0\';\n            el.style.transform = \'translateY(20px)\';\n            el.style.transition = `opacity 0.8s ease, transform 0.8s ease`;\n            \n            setTimeout(() => {\n                el.style.opacity = \'1\';\n                el.style.transform = \'translateY(0)\';\n            }, 50 + (index * 100)); \n        });\n    });\n</script>\n', 'How to Order | Stich Smart Clothing', 'Learn how to easily place an order at Stich Smart Clothing, from browsing products to secure checkout, payment, and order confirmation for a smooth shopping experience.', 'how to order online, shopping guide, place order clothing, ecommerce order steps, Stich Smart ordering, online purchase guide, checkout process', NULL, 1, NULL, '2025-08-09 05:04:08', '2026-05-07 06:07:56'),
(7, 'Product Advice', 'product-advice', '<style>\n/* ── PRODUCT ADVICE HERO ── */\n.advice-hero {\n    position: relative;\n    min-height: 380px;\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    text-align: center;\n    padding: 60px 20px;\n    border-bottom: 1px solid rgba(193, 154, 78, 0.2);\n}\n.advice-hero-content {\n    max-width: 650px;\n}\n.advice-hero h1 {\n    font-family: \'Playfair Display\', serif;\n    font-size: clamp(2.5rem, 5vw, 3.8rem);\n    font-weight: 900;\n    color: #1a0f0a;\n    margin-bottom: 20px;\n    line-height: 1.1;\n}\n.advice-hero h1 span {\n    color: #c19a4e;\n}\n.advice-hero p {\n    color: #4a4a4a;\n    font-size: 1.1rem;\n    line-height: 1.7;\n    margin-bottom: 0;\n}\n.advice-hero-divider {\n    width: 80px;\n    height: 3px;\n    background: #c19a4e;\n    margin: 25px auto;\n    border-radius: 2px;\n}\n\n/* ── ADVICE CARDS ── */\n.advice-section {\n    padding: 40px 0 80px;\n    background-color: var(--page-bg, #000);\n}\n.advice-card {\n    background: var(--bg-card, #0a0a0a);\n    border: 1px solid rgba(193, 154, 78, 0.15);\n    border-radius: 16px;\n    padding: 40px 30px;\n    height: 100%;\n    transition: all 0.4s ease;\n    text-align: center;\n}\n.advice-card:hover {\n    transform: translateY(-10px);\n    border-color: #c19a4e;\n    box-shadow: 0 15px 35px rgba(0,0,0,0.3);\n}\n.advice-icon-wrapper {\n    width: 70px;\n    height: 70px;\n    border-radius: 50%;\n    background: rgba(193, 154, 78, 0.1);\n    color: #c19a4e;\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    font-size: 2rem;\n    margin: 0 auto 25px;\n    border: 1px solid rgba(193, 154, 78, 0.25);\n    transition: all 0.3s ease;\n}\n.advice-card:hover .advice-icon-wrapper {\n    background: #c19a4e;\n    color: #fff;\n}\n.advice-card h3 {\n    font-family: \'Playfair Display\', serif;\n    font-size: 1.5rem;\n    color: #c19a4e;\n    margin-bottom: 15px;\n    font-weight: 700;\n}\n.advice-card p {\n    color: var(--page-text, #f4e9d3);\n    opacity: 0.8;\n    font-size: 0.95rem;\n    line-height: 1.6;\n    margin-bottom: 20px;\n}\n.advice-link {\n    display: inline-block;\n    color: #c19a4e;\n    font-weight: 600;\n    text-decoration: none;\n    text-transform: uppercase;\n    font-size: 0.85rem;\n    letter-spacing: 1px;\n    transition: color 0.3s ease;\n}\n.advice-link i {\n    margin-left: 5px;\n    transition: transform 0.3s ease;\n}\n.advice-card:hover .advice-link {\n    color: #e8c97a;\n}\n.advice-card:hover .advice-link i {\n    transform: translateX(5px);\n}\n\n/* ── CTA SECTION ── */\n.advice-cta {\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    padding: 70px 0;\n    text-align: center;\n    border-top: 1px solid rgba(193, 154, 78, 0.25);\n}\n.advice-cta h2 {\n    font-family: \'Playfair Display\', serif;\n    color: #1a0f0a;\n    font-size: 2.2rem;\n    margin-bottom: 20px;\n}\n.advice-cta p {\n    color: #4a4a4a;\n    max-width: 600px;\n    margin: 0 auto 30px;\n    font-size: 1.05rem;\n}\n.btn-gold {\n    background: #c19a4e;\n    color: #fff;\n    padding: 14px 35px;\n    border-radius: 50px;\n    font-weight: 600;\n    text-decoration: none;\n    text-transform: uppercase;\n    letter-spacing: 1px;\n    font-size: 0.9rem;\n    transition: all 0.3s ease;\n    border: none;\n    display: inline-block;\n}\n.btn-gold:hover {\n    background: #e8c97a;\n    color: #1a0f0a;\n    transform: translateY(-2px);\n    box-shadow: 0 5px 15px rgba(193, 154, 78, 0.3);\n}\n</style>\n\n<div class=\"advice-page-wrap\">\n    <!-- Hero Section -->\n    <section class=\"advice-hero\">\n        <div class=\"advice-hero-content\">\n            <h1 class=\"animate-fade-up\">Expert <span>Product Advice</span></h1>\n            <div class=\"advice-hero-divider animate-fade-up\"></div>\n            <p class=\"animate-fade-up\">Make informed choices with our comprehensive guides. From finding the perfect fit to caring for premium fabrics, we\'re here to help you elevate your wardrobe.</p>\n        </div>\n    </section>\n\n    <!-- Advice Cards Section -->\n    <section class=\"advice-section\">\n        <div class=\"container\">\n            <div class=\"row g-4\">\n                <!-- Card 1 -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"advice-card\">\n                        <div class=\"advice-icon-wrapper\">\n                            <i class=\"bi bi-rulers\"></i>\n                        </div>\n                        <h3>Sizing & Fit Guide</h3>\n                        <div style=\"text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;\">\n                            <p class=\"mb-2\"><strong>Shirts:</strong> Measure around the fullest part of your chest and base of your neck. For sleeves, measure from the center back of your neck to your wrist.</p>\n                            <p class=\"mb-2\"><strong>Trousers:</strong> Measure around your natural waistline and from your inner thigh down to the ankle for the perfect inseam.</p>\n                            <p class=\"mb-0\"><em>Tip:</em> Always keep the measuring tape comfortably loose, never too tight.</p>\n                        </div>\n                    </div>\n                </div>\n                \n                <!-- Card 2 -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"advice-card\">\n                        <div class=\"advice-icon-wrapper\">\n                            <i class=\"bi bi-droplet\"></i>\n                        </div>\n                        <h3>Fabric Care</h3>\n                        <div style=\"text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;\">\n                            <p class=\"mb-2\"><strong>Cotton:</strong> Machine wash cold with similar colors. Tumble dry low or hang to prevent shrinking.</p>\n                            <p class=\"mb-2\"><strong>Silk & Wool:</strong> Dry clean only to maintain the delicate fibers and shape of the garment.</p>\n                            <p class=\"mb-0\"><strong>Linen:</strong> Wash in lukewarm water. Iron while the fabric is slightly damp for best results.</p>\n                        </div>\n                    </div>\n                </div>\n\n                <!-- Card 3 -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"advice-card\">\n                        <div class=\"advice-icon-wrapper\">\n                            <i class=\"bi bi-star\"></i>\n                        </div>\n                        <h3>Styling Tips</h3>\n                        <div style=\"text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;\">\n                            <p class=\"mb-2\"><strong>Smart Casual:</strong> Pair a tailored blazer with dark denim and a crisp white shirt for an effortlessly sharp look.</p>\n                            <p class=\"mb-2\"><strong>Color Blocking:</strong> Stick to the rule of three — never mix more than three dominant colors in a single outfit.</p>\n                            <p class=\"mb-0\"><strong>Accessories:</strong> Match your belt with your shoes (especially leathers) for a cohesive and polished appearance.</p>\n                        </div>\n                    </div>\n                </div>\n\n                <!-- Card 4 -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"advice-card\">\n                        <div class=\"advice-icon-wrapper\">\n                            <i class=\"bi bi-shield-check\"></i>\n                        </div>\n                        <h3>Material Guide</h3>\n                        <div style=\"text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;\">\n                            <p class=\"mb-2\"><strong>Egyptian Cotton:</strong> Highly breathable and soft, perfect for everyday luxury dress shirts.</p>\n                            <p class=\"mb-2\"><strong>Merino Wool:</strong> Temperature-regulating and wrinkle-resistant, ideal for suits and fine knitwear.</p>\n                            <p class=\"mb-0\"><strong>Linen:</strong> Lightweight and highly absorbent, the ultimate choice for summer elegance.</p>\n                        </div>\n                    </div>\n                </div>\n\n                <!-- Card 5 -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"advice-card\">\n                        <div class=\"advice-icon-wrapper\">\n                            <i class=\"bi bi-palette\"></i>\n                        </div>\n                        <h3>Color Matching</h3>\n                        <div style=\"text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;\">\n                            <p class=\"mb-2\"><strong>Monochromatic:</strong> Wearing different shades of the same color creates a slimming, sophisticated profile.</p>\n                            <p class=\"mb-2\"><strong>Neutrals:</strong> Navy, grey, black, and white are foundational. Pair them with one accent color to stand out.</p>\n                            <p class=\"mb-0\"><strong>Skin Tones:</strong> Warmer skin tones look great in earthy colors, while cooler tones shine in blues and greys.</p>\n                        </div>\n                    </div>\n                </div>\n\n                <!-- Card 6 -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"advice-card\">\n                        <div class=\"advice-icon-wrapper\">\n                            <i class=\"bi bi-scissors\"></i>\n                        </div>\n                        <h3>Custom Tailoring</h3>\n                        <div style=\"text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;\">\n                            <p class=\"mb-2\"><strong>Alterations:</strong> Even off-the-rack garments look custom-made when tailored. Prioritize adjusting sleeve length and waist.</p>\n                            <p class=\"mb-0\"><strong>Custom Orders:</strong> When ordering bespoke, communicate your typical fit issues (e.g., broad shoulders) so our master tailors can adjust the pattern accordingly.</p>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </section>\n\n    <!-- CTA Section -->\n    <section class=\"advice-cta\">\n        <div class=\"container\">\n            <h2>Need Personalized Assistance?</h2>\n            <p>Our style experts and tailors are always available to help you make the right choice.</p>\n            <a href=\"<?= BASE_URL ?>/index.php?page=contact\" class=\"btn-gold\">Contact Support</a>\n        </div>\n    </section>\n</div>\n\n<script>\n    // Simple fade-up animation for hero\n    document.addEventListener(\"DOMContentLoaded\", function() {\n        const heroElements = document.querySelectorAll(\'.animate-fade-up\');\n        heroElements.forEach((el, index) => {\n            el.style.opacity = \'0\';\n            el.style.transform = \'translateY(20px)\';\n            el.style.transition = `opacity 0.8s ease ${index * 0.15}s, transform 0.8s ease ${index * 0.15}s`;\n            \n            setTimeout(() => {\n                el.style.opacity = \'1\';\n                el.style.transform = \'translateY(0)\';\n            }, 50);\n        });\n    });\n</script>\n', 'Product Advice & Sizing Guide | Stitch-Smart Clothing care', 'Expert advice on custom fits (oversized, relaxed, slim), fabric qualities, and maintenance tips to keep print/embroidery looking new.', 'clothing size guide, oversize hoodie wash, cotton fabric care', NULL, 1, NULL, '2025-08-09 07:53:53', '2026-05-18 22:24:16'),
(15, 'Our Story', 'our-story', '<style>\n/* ── OUR STORY HERO ── */\n.story-hero {\n    position: relative;\n    min-height: 380px;\n    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    text-align: center;\n    padding: 60px 20px;\n    border-bottom: 1px solid rgba(193, 154, 78, 0.25);\n}\n.story-hero-content {\n    max-width: 700px;\n}\n.story-hero h1 {\n    font-family: \'Playfair Display\', serif;\n    font-size: clamp(2.5rem, 5vw, 3.8rem);\n    font-weight: 900;\n    color: #1a0f0a;\n    margin-bottom: 20px;\n    line-height: 1.1;\n}\n.story-hero h1 span {\n    color: #c19a4e;\n}\n.story-hero p {\n    color: #4a4a4a;\n    font-size: 1.1rem;\n    line-height: 1.7;\n    margin-bottom: 0;\n}\n.story-divider {\n    width: 80px;\n    height: 3px;\n    background: #c19a4e;\n    margin: 25px auto;\n    border-radius: 2px;\n}\n\n/* ── STORY CONTENT ── */\n.story-content-section {\n    padding: 40px 0 80px;\n    background-color: var(--page-bg, #000);\n    color: var(--page-text, #f4e9d3);\n}\n.story-content-box {\n    background: var(--bg-card, #0a0a0a);\n    border: 1px solid rgba(193, 154, 78, 0.15);\n    border-radius: 16px;\n    padding: 50px;\n    box-shadow: 0 10px 30px rgba(0,0,0,0.2);\n}\n.story-content-box h2 {\n    font-family: \'Playfair Display\', serif;\n    color: #c19a4e;\n    font-size: 2rem;\n    margin-bottom: 25px;\n    font-weight: 700;\n}\n.story-content-box p {\n    font-size: 1.05rem;\n    line-height: 1.8;\n    opacity: 0.85;\n    margin-bottom: 20px;\n}\n\n/* ── TEAM SECTION ── */\n.team-section {\n    padding: 80px 0;\n    background-color: var(--page-bg, #000);\n}\n.team-title {\n    text-align: center;\n    font-family: \'Playfair Display\', serif;\n    color: var(--page-heading, #f4e9d3);\n    font-size: 2.5rem;\n    margin-bottom: 50px;\n    font-weight: 700;\n}\n.team-card {\n    background: var(--bg-card, #0a0a0a);\n    border: 1px solid rgba(193, 154, 78, 0.15);\n    border-radius: 16px;\n    padding: 40px 30px;\n    text-align: center;\n    transition: all 0.4s ease;\n    height: 100%;\n}\n.team-card:hover {\n    transform: translateY(-10px);\n    border-color: #c19a4e;\n    box-shadow: 0 15px 35px rgba(0,0,0,0.3);\n}\n.team-avatar {\n    width: 120px;\n    height: 120px;\n    border-radius: 50%;\n    background: linear-gradient(135deg, #c19a4e, #e8c97a);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    font-size: 3rem;\n    color: #1a0f0a;\n    margin: 0 auto 25px;\n    border: 4px solid var(--bg-card, #0a0a0a);\n    outline: 2px solid #c19a4e;\n}\n.team-card h3 {\n    font-family: \'Playfair Display\', serif;\n    font-size: 1.6rem;\n    color: #c19a4e;\n    margin-bottom: 10px;\n    font-weight: 700;\n}\n.team-card h6 {\n    color: var(--page-text, #f4e9d3);\n    text-transform: uppercase;\n    letter-spacing: 2px;\n    font-size: 0.85rem;\n    opacity: 0.8;\n    margin-bottom: 20px;\n}\n.team-card p {\n    color: var(--page-text, #f4e9d3);\n    opacity: 0.7;\n    font-size: 0.95rem;\n    line-height: 1.6;\n}\n</style>\n\n<div class=\"story-page-wrap\">\n    <!-- Hero Section -->\n    <section class=\"story-hero\">\n        <div class=\"story-hero-content\">\n            <h1 class=\"animate-fade-up\">Our <span>Story</span></h1>\n            <div class=\"story-divider animate-fade-up\"></div>\n            <p class=\"animate-fade-up\">From a passionate vision to a premium tailoring destination. Discover the craftsmanship and dedication that drives StitchSmart.</p>\n        </div>\n    </section>\n\n    <!-- The Journey -->\n    <section class=\"story-content-section\">\n        <div class=\"container\">\n            <div class=\"row justify-content-center\">\n                <div class=\"col-lg-10\">\n                    <div class=\"story-content-box animate-fade-up\">\n                        <h2>Crafting Elegance</h2>\n                        <p>StitchSmart was born out of a simple desire: to bridge the gap between premium bespoke tailoring and modern accessibility. We noticed that true craftsmanship was becoming harder to find, so we set out to build a platform that brings master tailors directly to you.</p>\n                        <p>Our journey started with a commitment to uncompromised quality. We source the finest materials and employ generational techniques to ensure every garment we create is not just worn, but cherished. Today, StitchSmart stands as a symbol of elegance, personalized service, and timeless style.</p>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </section>\n\n    <!-- Team Section -->\n    <section class=\"team-section\">\n        <div class=\"container\">\n            <h2 class=\"team-title animate-fade-up\">Meet the Leadership</h2>\n            <div class=\"row g-4 justify-content-center\">\n                \n                <!-- Moiz Ahmed -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"team-card animate-fade-up\">\n                        <div class=\"team-avatar\">\n                            <i class=\"bi bi-person-fill\"></i>\n                        </div>\n                        <h3>Moiz Ahmed</h3>\n                        <h6>Founder</h6>\n                        <p>The visionary behind StitchSmart. Moiz built the foundation of our brand with an unwavering focus on quality, customer experience, and redefining modern tailoring.</p>\n                    </div>\n                </div>\n\n                <!-- Bissma Ijaz -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"team-card animate-fade-up\" style=\"transition-delay: 0.1s;\">\n                        <div class=\"team-avatar\">\n                            <i class=\"bi bi-person-fill\"></i>\n                        </div>\n                        <h3>Bissma Ijaz</h3>\n                        <h6>Co Founder</h6>\n                        <p>With an exceptional eye for design and operational excellence, Bissma ensures that every collection and custom piece meets the highest standards of luxury.</p>\n                    </div>\n                </div>\n\n                <!-- Ali Haider -->\n                <div class=\"col-md-6 col-lg-4\">\n                    <div class=\"team-card animate-fade-up\" style=\"transition-delay: 0.2s;\">\n                        <div class=\"team-avatar\">\n                            <i class=\"bi bi-person-fill\"></i>\n                        </div>\n                        <h3>Ali Haider</h3>\n                        <h6>Director</h6>\n                        <p>Driving the strategic growth of StitchSmart, Ali connects our master tailors with clients worldwide, ensuring our legacy of craftsmanship reaches new horizons.</p>\n                    </div>\n                </div>\n\n            </div>\n        </div>\n    </section>\n</div>\n\n<script>\n    document.addEventListener(\"DOMContentLoaded\", function() {\n        const elements = document.querySelectorAll(\'.animate-fade-up\');\n        elements.forEach((el, index) => {\n            el.style.opacity = \'0\';\n            el.style.transform = \'translateY(20px)\';\n            el.style.transition = `opacity 0.8s ease, transform 0.8s ease`;\n            \n            setTimeout(() => {\n                el.style.opacity = \'1\';\n                el.style.transform = \'translateY(0)\';\n            }, 50 + (index * 100)); // Staggered animation\n        });\n    });\n</script>\n', 'Our Story | Three Student Founders Behind Stitch-Smart', 'Meet Moiz Ahmed (CEO), Bissma Ijaz (Inventory), and Ali Haider (Finance)—the three student founders who revolutionized custom clothing.', 'stitch smart founders, moiz ahmed, bissma ijaz, ali haider, custom streetwear startup', NULL, 1, NULL, '2026-05-18 22:24:16', '2026-05-18 22:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `article_number` varchar(100) NOT NULL,
  `Fabric_Type` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `details` varchar(10000) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `img2` varchar(500) NOT NULL,
  `img3` varchar(3) NOT NULL,
  `size` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `document` varchar(300) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `parent_cat` int(11) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL,
  `sale_discount_percent` int(11) NOT NULL DEFAULT 20,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `color_id` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `Designing` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `article_number`, `Fabric_Type`, `name`, `description`, `details`, `image_url`, `img2`, `img3`, `size`, `price`, `document`, `c_id`, `parent_cat`, `featured`, `sale_discount_percent`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`, `color_id`, `slug`, `Designing`, `quantity`, `is_featured`) VALUES
(66, '1001', '', 'Trendy Design', 'Durable and stylish design', 'Durable and long-lasting', 'pictures/products/1781533495_6a300b372905e_kids.jpg', '', '', 'XS:0, S:0, L:0, XL:0',  4000.00, '', ' NULL',  39,  1,  0, 'Trendy Design | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'trendy, design, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:24:55', '2026-06-20 06:39:37', ' NULL', 'trendy-design', 'Yes',  39,  0),
(67, '1002', '', 'Premium Product', 'High-quality product with excellent finish', 'Modern design and finish', 'pictures/products/1781534194_6a300df2bf209_kid image 2.webp', '', '', 'XS:20, S:0, L:21, XL:0',  3000.00, '', ' NULL',  39,  0,  2, 'Premium Product | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'premium, product, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:36:34', '2026-06-18 14:46:17', ' NULL', 'premium-product', 'Yes',  41,  0),
(68, '1003', '', 'White Shirt For Kids', 'Carefully selected for premium quality', 'Premium quality material', 'pictures/products/1781534360_6a300e9819892_kid image3.webp', '', '', 'XS:0, S:50, L:0, XL:0',  3000.00, '', ' NULL',  39,  0,  2, 'White Shirt For Kids | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'white, shirt, kids, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:39:20', '2026-06-18 14:46:35', ' NULL', 'white-shirt-for-kids', 'Yes',  50,  0),
(69, '1004', '', 'Premium Collection Shirt', 'Carefully selected for premium quality', 'Premium quality material', 'pictures/products/1781534476_6a300f0c1235d_kid image4.webp', '', '', 'XS:0, S:0, L:0, XL:0',  1500.00, '', ' NULL',  39,  1,  0, 'Premium Collection Shirt | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'premium, collection, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:41:16', '2026-06-18 15:14:04', ' NULL', 'premium-collection-shirt', 'Yes',  35,  0),
(71, '1005', '', 'Trendy Design shirt', 'Durable and stylish design', 'Comfortable and practical', 'pictures/products/1781534773_6a30103517583_kid image5.webp', '', '', 'XS:0, S:0, L:0, XL:50',  2000.00, '', ' NULL',  39,  0,  0, 'Trendy Design shirt | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'trendy, design, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:46:13', '2026-06-18 11:59:59', ' NULL', 'trendy-design-shirt', 'Yes',  50,  0),
(73, '1006', '', 'Trendy Design Black Shirt', 'High-quality product with excellent finish', 'Comfortable and practical', 'pictures/products/1781534969_6a3010f92c533_kid image7.jpg', '', '', 'XS:50, S:0, L:0, XL:0',  2000.00, '', ' NULL',  39,  0,  20, 'Trendy Design Black Shirt | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'trendy, design, black, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:49:29', '2026-06-15 14:49:29', ' NULL', 'trendy-design-black-shirt', 'Yes',  50,  0),
(74, '1007', '', 'Classic Style', 'Durable and stylish design', 'Durable and long-lasting', 'pictures/products/1781535055_6a30114f282f9_kid image 8.jpg', '', '', 'XS:0, S:50, L:0, XL:0',  1500.00, '', ' NULL',  39,  1,  0, 'Classic Style | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'classic, style, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:50:55', '2026-06-16 06:09:07', ' NULL', 'classic-style', 'Yes',  50,  0),
(75, '1008', '', 'Quality Light Green Shirt', 'Carefully selected for premium quality', 'Comfortable and practical', 'pictures/products/1781535138_6a3011a2472f8_kid image 9.jpg', '', '', 'XS:0, S:50, L:50, XL:0',  1000.00, '', ' NULL',  39,  0,  0, 'Quality Light Green Shirt | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'quality, light, green, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:52:18', '2026-06-18 14:46:45', ' NULL', 'quality-light-green-shirt', 'Yes',  100,  0),
(76, '1009', '', 'Premium Collection', 'Durable and stylish design', 'Comfortable and practical', 'pictures/products/1781535234_6a301202cf87b_kid image 10.webp', '', '', 'XS:1, S:0, L:0, XL:50',  1000.00, '', ' NULL',  39,  0,  2, 'Premium Collection | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'premium, collection, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:53:54', '2026-06-20 06:40:25', ' NULL', 'premium-collection', 'Yes',  51,  0),
(77, '1010', '', 'Trendy Design Pink Shirt', 'Durable and stylish design', 'Modern design and finish', 'pictures/products/1781535305_6a301249244da_image 11.webp', '', '', 'XS:0, S:50, L:20, XL:0',  2000.00, '', ' NULL',  39,  0,  0, 'Trendy Design Pink Shirt | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'trendy, design, pink, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-15 14:55:05', '2026-06-16 14:15:47', ' NULL', 'trendy-design-pink-shirt', 'Yes',  70,  0),
(80, '1011', '', 'Premium Collection Shirt For Girls', 'Durable and stylish design', 'Professional quality', 'pictures/products/1781535912_6a3014a836c6d_w10.jpg', '', '', 'XS:0, S:0, L:0, XL:50',  1500.00, '', ' NULL', ' NULL',  1,  0, 'Premium Collection Shirt For Girls | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'premium, collection, shirt, girls, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:05:12', '2026-06-16 06:09:02', ' NULL', 'premium-collection-shirt-for-girls', 'Yes',  50,  0),
(81, '1012', '', 'Premium Blue Item', 'Perfect for everyday use', 'Premium quality material', 'pictures/products/1781536061_6a30153de3238_w9.jpg', '', '', 'XS:0, S:50, L:50, XL:0',  4000.00, '', ' NULL', ' NULL',  0,  20, 'Premium Blue Item | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'premium, blue, item, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:07:41', '2026-06-15 15:07:41', ' NULL', 'premium-blue-item', 'Yes',  100,  0),
(82, '1013', '', 'Classic Style Brown Dress', 'Perfect for everyday use', 'Premium quality material', 'pictures/products/1781536153_6a3015990910e_w8.webp', '', '', 'XS:50, S:0, L:50, XL:0',  2000.00, '', ' NULL', ' NULL',  0,  20, 'Classic Style Brown Dress | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'classic, style, brown, dress, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:09:13', '2026-06-17 06:53:27', ' NULL', 'classic-style-brown-dress', 'Yes',  99,  0),
(83, '1014', '', 'Classic Style Pent Shirt', 'Durable and stylish design', 'Comfortable and practical', 'pictures/products/1781536239_6a3015efb92cd_w4.jpg', '', '', 'XS:0, S:50, L:9, XL:0',  5000.00, '', ' NULL', ' NULL',  1,  0, 'Classic Style Pent Shirt | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'classic, style, pent, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:10:39', '2026-06-20 06:37:33', ' NULL', 'classic-style-pent-shirt', 'Yes',  59,  0),
(85, '1015', '', 'Quality Item In Dark Red', 'Excellent value for money', 'Durable and long-lasting', 'pictures/products/1781536367_6a30166f24868_w3.jpg', '', '', 'XS:0, S:0, L:0, XL:50',  5000.00, '', ' NULL', ' NULL',  0,  0, 'Quality Item In Dark Red | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'quality, item, dark, red, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:12:47', '2026-06-18 10:09:54', ' NULL', 'quality-item-in-dark-red', 'Yes',  50,  0),
(86, '1016', '', 'Classic Style Light Purple Shirt', 'Excellent value for money', 'Premium quality material', 'pictures/products/1781536476_6a3016dc8bd0a_w2.webp', '', '', 'XS:0, S:60, L:0, XL:0',  4000.00, '', ' NULL', ' NULL',  0,  2, 'Classic Style Light Purple Shirt | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'classic, style, light, purple, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:14:36', '2026-06-20 06:40:17', ' NULL', 'classic-style-light-purple-shirt', 'Yes',  60,  0),
(87, '1017', '', 'Quality Item T-Shirt with jeans', 'Durable and stylish design', 'Modern design and finish', 'pictures/products/1781536696_6a3017b8da4b2_w1.webp', '', '', 'XS:0, S:0, L:0, XL:10',  3000.00, '', ' NULL', ' NULL',  0,  20, 'Quality Item T-Shirt with jeans | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'quality, item, tshirt, jeans, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:18:16', '2026-06-15 15:18:16', ' NULL', 'quality-item-t-shirt-with-jeans', 'Yes',  10,  0),
(88, '1018', '', 'Premium Collection Complete Set', 'High-quality product with excellent finish', 'Modern design and finish', 'pictures/products/1781536830_6a30183e345bc_DSC_5266-min_1000x.jpg', '', '', 'XS:0, S:0, L:20, XL:0',  2500.00, '', ' NULL', ' NULL',  0,  0, 'Premium Collection Complete Set | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'premium, collection, complete, set, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:20:30', '2026-06-18 12:00:51', ' NULL', 'premium-collection-complete-set', 'Yes',  20,  0),
(89, '1019', '', 'Quality Item Red Dress', 'Durable and stylish design', 'Premium quality material', 'pictures/products/1781536944_6a3018b080d8a_171A2102copy_94b2151a-25fc-40bf-bbe0-0a1921e8cec4_1000x.webp', '', '', 'XS:0, S:0, L:10, XL:0',  2000.00, '', ' NULL', ' NULL',  1,  0, 'Quality Item Red Dress | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'quality, item, red, dress, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:22:24', '2026-06-20 10:19:44', ' NULL', 'quality-item-red-dress', 'Yes',  24,  0),
(92, '1020', '', 'Trendy Design Dress', 'Durable and stylish design', 'Modern design and finish', 'pictures/products/1781537167_6a30198fa313a_WS4649-1_1000x.webp', '', '', 'XS:0, S:0, L:0, XL:50',  3000.00, '', ' NULL', ' NULL',  0,  20, 'Trendy Design Dress | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'trendy, design, dress, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:26:07', '2026-06-15 15:26:07', ' NULL', 'trendy-design-dress', 'Yes',  50,  0),
(93, '1021', '', 'Sleeveless Black Quality Item', 'Carefully selected for premium quality', 'Comfortable and practical', 'pictures/products/1781538171_6a301d7b40784_m1.webp', '', '', 'XS:0, S:0, L:0, XL:50',  4000.00, '', ' NULL',  37,  0,  2, 'Sleeveless Black Quality Item | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'sleeveless, black, quality, item, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:42:51', '2026-06-20 06:40:29', ' NULL', 'sleeveless-black-quality-item', 'Yes',  50,  0),
(94, '1022', '', 'Basic Tea White Quality Item', 'Durable and stylish design', 'Comfortable and practical', 'pictures/products/1781538303_6a301dffa9ca6_m2.jpg', '', '', 'XS:50, S:0, L:5, XL:0',  5000.00, '', ' NULL',  37,  0,  0, 'Basic Tea White Quality Item | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'basic, tea, white, quality, item, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:45:03', '2026-06-18 12:01:12', ' NULL', 'basic-tea-white-quality-item', 'Yes',  55,  0),
(95, '1023', '', 'Spider Black Premium Collection', 'Durable and stylish design', 'Durable and long-lasting', 'pictures/products/1781538368_6a301e4049818_m3.webp', '', '', 'XS:0, S:0, L:10, XL:0',  3000.00, '', ' NULL',  37,  0,  20, 'Spider Black Premium Collection | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'spider, black, premium, collection, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:46:08', '2026-06-15 15:46:08', ' NULL', 'spider-black-premium-collection', 'Yes',  10,  0),
(96, '1024', '', 'Gym Shirt with Quality', 'High-quality product with excellent finish', 'Durable and long-lasting', 'pictures/products/1781538442_6a301e8a5e1bb_m4.webp', '', '', 'XS:0, S:0, L:50, XL:0',  3000.00, '', ' NULL',  37,  0,  20, 'Gym Shirt with Quality | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'gym, shirt, quality, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:47:22', '2026-06-15 15:47:22', ' NULL', 'gym-shirt-with-quality', 'Yes',  50,  0),
(97, '1025', '', 'Black Premium Collection', 'Perfect for everyday use', 'Durable and long-lasting', 'pictures/products/1781538500_6a301ec40dfdb_m5.webp', '', '', 'XS:0, S:0, L:0, XL:0',  1500.00, '', ' NULL',  37,  0,  0, 'Black Premium Collection | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'black, premium, collection, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:48:20', '2026-06-20 06:28:38', ' NULL', 'black-premium-collection', 'Yes',  100,  0),
(98, '1026', '', 'ActiveWear Premium Collection', 'Carefully selected for premium quality', 'Comfortable and practical', 'pictures/products/1781538605_6a301f2db9781_m6.jpg', '', '', 'XS:0, S:0, L:0, XL:0',  5000.00, '', ' NULL',  37,  0,  0, 'ActiveWear Premium Collection | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'activewear, premium, collection, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:50:05', '2026-06-18 13:22:01', ' NULL', 'activewear-premium-collection', 'Yes',  10,  0),
(99, '1027', '', 'Core Mesh T-Shirt Classic Style', 'Durable and stylish design', 'Durable and long-lasting', 'pictures/products/1781538676_6a301f745ac04_m7.jpg', '', '', 'XS:0, S:0, L:0, XL:30',  5000.00, '', ' NULL',  37,  0,  20, 'Core Mesh T-Shirt Classic Style | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'core, mesh, tshirt, classic, style, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:51:16', '2026-06-16 07:25:58', ' NULL', 'core-mesh-t-shirt-classic-style', 'Yes',  29,  0),
(100, '1028', '', 'Premium T-Shirt with Trendy Design', 'Excellent value for money', 'Comfortable and practical', 'pictures/products/1781538764_6a301fcca6b25_m8.jpg', '', '', 'XS:0, S:0, L:45, XL:0',  4000.00, '', ' NULL',  37,  0,  20, 'Premium T-Shirt with Trendy Design | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'premium, tshirt, trendy, design, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:52:44', '2026-06-20 10:19:44', ' NULL', 'premium-t-shirt-with-trendy-design', 'Yes',  43,  0),
(101, '1029', '', 'Men\\'s Active Wear Premium Collection', 'Perfect for everyday use', 'Modern design and finish', 'pictures/products/1781538980_6a3020a41d059_m9.jpg', '', '', 'XS:2, S:2, L:2, XL:2',  5000.00, '', ' NULL',  37,  0,  0, 'Men\\'s Active Wear Premium Collection | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'mens, active, wear, premium, collection, stitch smart, online shopping, pakistan fashion', '2026-06-15 15:56:20', '2026-06-20 06:34:01', ' NULL', 'men-s-active-wear-premium-collection', 'Yes',  7,  0),
(102, '1030', '', 'Women\\'s Blue Textured Co-ord Set', 'A stylish and comfortable co-ord set featuring a textured t-shirt and matching relaxed-fit pants. Perfect for casual outings or lounging.', 'The set is made from a soft, breathable fabric with a subtle diagonal texture. The t-shirt has a classic crew neck and short sleeves. The pants feature a comfortable elastic waistband and a relaxed, tapered leg with a small slit at the hem. Side pockets are included on the pants.', 'pictures/products/1781777577_6a33c4a9e0f3d_w9.jpg', '', '', 'XS:0, S:0, L:0, XL:50',  1299.00, '', ' NULL',  57,  0,  20, 'Women\\'s Blue Textured Co-ord Set | Stitch Smart', 'A stylish and comfortable co-ord set featuring a textured t-shirt and matching relaxed-fit pants. Perfect for casual outings or lounging. Buy premium quality at', 'womens, blue, textured, coord, set, stitch smart, online shopping, pakistan fashion', '2026-06-18 10:12:57', '2026-06-18 10:12:57', ' NULL', 'women-s-blue-textured-co-ord-set', 'Yes',  50,  0),
(103, '1031', '', 'Women\\'s Classic Fit White Cotton Full Sleeve Shirt', 'A timeless and versatile white cotton shirt for women, perfect for both formal and casual wear. Featuring a classic fit and full sleeves, this shirt offers comfort and style.', 'Crafted from 100% premium cotton, this shirt ensures breathability and a soft feel against the skin. It features a pointed collar, a button-down front closure, and buttoned cuffs for adjustable fit. The tailored seams provide a flattering silhouette.', 'pictures/products/1781777910_6a33c5f69d632_w10.jpg', '', '', 'XS:50, S:0, L:0, XL:0',  1500.00, '', ' NULL',  57,  0,  20, 'Women\\'s Classic Fit White Cotton Full Sleeve Sh | Stitch Smart', 'A timeless and versatile white cotton shirt for women, perfect for both formal and casual wear. Featuring a classic fit and full sleeves, th. Buy premium qualit', 'womens, classic, fit, white, cotton, full, sleeve, shirt', '2026-06-18 10:18:30', '2026-06-18 10:18:30', ' NULL', 'women-s-classic-fit-white-cotton-full-sleeve-shirt', 'Yes',  50,  0),
(104, '1032', '', 'Women\\'s Brown Oversized Cotton Shirt', 'A chic and comfortable oversized shirt in a warm brown hue. Perfect for a casual yet stylish look.', 'Made from breathable cotton fabric. Features a classic collar, button-down front, and a single chest pocket. The oversized fit provides a relaxed and contemporary silhouette.', 'pictures/products/1781778077_6a33c69d5c9c3_w8.webp', '', '', 'XS:0, S:0, L:50, XL:0',  1599.00, '', ' NULL',  57,  0,  0, 'Women\\'s Brown Oversized Cotton Shirt | Stitch Smart', 'A chic and comfortable oversized shirt in a warm brown hue. Perfect for a casual yet stylish look. Buy premium quality at best price.', 'womens, brown, oversized, cotton, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-18 10:21:17', '2026-06-18 12:01:22', ' NULL', 'women-s-brown-oversized-cotton-shirt', 'Yes',  50,  0),
(105, '1033', '', 'Women\\'s Striped Short Sleeve Shirt', 'A stylish and comfortable short-sleeved shirt featuring subtle vertical stripes. Perfect for casual outings or a relaxed day at home.', 'Crafted from a breathable cotton blend fabric, this shirt offers a relaxed fit with a classic collar and button-down front. The short sleeves are finished with a neat cuff detail.', 'pictures/products/1781778173_6a33c6fd3d488_w4.jpg', '', '', 'XS:0, S:0, L:50, XL:0',  1399.00, '', ' NULL',  57,  0,  20, 'Women\\'s Striped Short Sleeve Shirt | Stitch Smart', 'A stylish and comfortable short-sleeved shirt featuring subtle vertical stripes. Perfect for casual outings or a relaxed day at home. Buy premium quality at bes', 'womens, striped, short, sleeve, shirt, stitch smart, online shopping, pakistan fashion', '2026-06-18 10:22:53', '2026-06-18 10:22:53', ' NULL', 'women-s-striped-short-sleeve-shirt', 'Yes',  50,  0),
(106, '1034', '', 'Women\\'s Burgundy Collared Puff Sleeve Button-Up Shirt', 'A stylish and elegant burgundy shirt for women, featuring a classic collared neckline, puff sleeves for a touch of volume, and a flattering button-up front. This versatile shirt can be dressed up or down for various occasions.', 'Made from a blend of cotton and polyester, this shirt offers comfort and durability. The fabric is breathable and easy to care for. It features a pointed collar, short puff sleeves, and a concealed button placket with decorative buttons visible on the outside. The design includes subtle pleating at the waist for a tailored fit.', 'pictures/products/1781778302_6a33c77ec720f_w3.jpg', '', '', 'XS:0, S:0, L:50, XL:0',  1350.00, '', ' NULL',  57,  0,  20, 'Women\\'s Burgundy Collared Puff Sleeve Button-Up | Stitch Smart', 'A stylish and elegant burgundy shirt for women, featuring a classic collared neckline, puff sleeves for a touch of volume, and a flattering. Buy premium quality', 'womens, burgundy, collared, puff, sleeve, buttonup, shirt, stitch smart', '2026-06-18 10:25:02', '2026-06-18 10:25:02', ' NULL', 'women-s-burgundy-collared-puff-sleeve-button-up-shirt', 'Yes',  50,  0),
(107, '1035', '', 'Lavender Puff Sleeve Peplum Top', 'A stylish lavender top with elegant puff sleeves and a flattering peplum silhouette. Features a classic collar and button-down front.', 'Fabric: Cotton blend. Style: Peplum, collared, button-down, short puff sleeves.', 'pictures/products/1781778386_6a33c7d2ccf06_w2.webp', '', '', 'XS:0, S:0, L:50, XL:0',  1099.00, '', ' NULL',  57,  0,  20, 'Lavender Puff Sleeve Peplum Top | Stitch Smart', 'A stylish lavender top with elegant puff sleeves and a flattering peplum silhouette. Features a classic collar and button-down front. Buy premium quality at bes', 'lavender, puff, sleeve, peplum, top, stitch smart, online shopping, pakistan fashion', '2026-06-18 10:26:26', '2026-06-18 10:26:26', ' NULL', 'lavender-puff-sleeve-peplum-top', 'Yes',  50,  0),
(108, '1036', '', 'Women\\'s White Puff Sleeve Collared Shirt', 'A chic and versatile white shirt with subtle puff sleeves and a classic collar, perfect for both casual and formal occasions.', 'Crafted from a comfortable cotton blend, this shirt features a tailored fit, a V-neckline with a notch collar, button-down front with golden buttons, and elegant puff sleeves with a cuffed hem. The fabric offers a soft feel and good breathability.', 'pictures/products/1781778532_6a33c8640da55_w1.webp', '', '', 'XS:0, S:0, L:50, XL:0',  1399.00, '', ' NULL',  57,  0,  20, 'Women\\'s White Puff Sleeve Collared Shirt | Stitch Smart', 'A chic and versatile white shirt with subtle puff sleeves and a classic collar, perfect for both casual and formal occasions. Buy premium quality at best price.', 'womens, white, puff, sleeve, collared, shirt, stitch smart, online shopping', '2026-06-18 10:28:52', '2026-06-18 10:28:52', ' NULL', 'women-s-white-puff-sleeve-collared-shirt', 'Yes',  50,  0),
(109, '1037', '', 'Black Hoodie and Jogger Set with Red Accents', 'A comfortable and stylish black hoodie and jogger set for women, featuring subtle red brand logo detailing and contrasting red stripes on the cuffs and hood lining.', 'Crafted from a soft and breathable cotton blend fabric for all-day comfort. The hoodie has a classic pullover design with an adjustable drawstring hood and a kangaroo pocket. The joggers feature a comfortable elastic waistband with a drawstring, side pockets, and ribbed cuffs. The brand\\'s signature red logo is embroidered on the chest of the hoodie and the thigh of the joggers. Red stripe details accent the cuffs of the hoodie sleeves and the waistband of the joggers.', 'pictures/products/1781779425_6a33cbe11d5f6_DSC_5266-min_1000x.jpg', '', '', 'XS:0, S:0, L:0, XL:50',  1999.00, '', ' NULL',  57,  0,  20, 'Black Hoodie and Jogger Set with Red Accents | Stitch Smart', 'A comfortable and stylish black hoodie and jogger set for women, featuring subtle red brand logo detailing and contrasting red stripes on th. Buy premium qualit', 'black, hoodie, jogger, set, red, accents, stitch smart, online shopping', '2026-06-18 10:43:45', '2026-06-18 10:43:45', ' NULL', 'black-hoodie-and-jogger-set-with-red-accents', 'Yes',  50,  0),
(110, '1038', '', 'Women\\'s Red Crew Neck T-Shirt', 'A vibrant red crew neck t-shirt designed for everyday comfort and style. This t-shirt features a subtle embroidered logo on the chest, adding a touch of brand identity.', 'Crafted from a soft and breathable cotton blend fabric, this t-shirt offers a relaxed fit. It has short sleeves and a classic crew neckline, making it a versatile piece for casual wear.', 'pictures/products/1781779575_6a33cc7777f58_171A2102copy_94b2151a-25fc-40bf-bbe0-0a1921e8cec4_1000x.webp', '', '', 'XS:0, S:0, L:0, XL:50',  599.00, '', ' NULL',  57,  0,  20, 'Women\\'s Red Crew Neck T-Shirt | Stitch Smart', 'A vibrant red crew neck t-shirt designed for everyday comfort and style. This t-shirt features a subtle embroidered logo on the chest, addin. Buy premium qualit', 'womens, red, crew, neck, tshirt, stitch smart, online shopping, pakistan fashion', '2026-06-18 10:46:15', '2026-06-18 10:46:15', ' NULL', 'women-s-red-crew-neck-t-shirt', 'Yes',  50,  0),
(111, '1039', '', 'Women\\'s Peach Crew Neck Long Sleeve Sweatshirt', 'A comfortable and stylish crew neck sweatshirt in a soft peach hue. Perfect for casual wear, this long-sleeved top offers a relaxed fit and versatile styling options.', 'Made from a soft cotton blend, this sweatshirt features a classic crew neckline and long sleeves. The relaxed fit ensures comfort, making it ideal for layering or wearing on its own. The peach color is a subtle and flattering shade.', 'pictures/products/1781779660_6a33cccc402c1_WS4649-1_1000x.webp', '', '', 'XS:0, S:50, L:0, XL:0',  899.00, '', ' NULL',  57,  0,  2, 'Women\\'s Peach Crew Neck Long Sleeve Sweatshirt | Stitch Smart', 'A comfortable and stylish crew neck sweatshirt in a soft peach hue. Perfect for casual wear, this long-sleeved top offers a relaxed fit and. Buy premium quality', 'womens, peach, crew, neck, long, sleeve, sweatshirt, stitch smart', '2026-06-18 10:47:40', '2026-06-18 12:00:32', ' NULL', 'women-s-peach-crew-neck-long-sleeve-sweatshirt', 'Yes',  50,  0),
(112, '1040', '', 'Kids\\' Blue Rainbow Print T-shirt and Pants Set', 'Adorable and comfortable blue t-shirt and pants set for kids featuring a charming rainbow print. Perfect for everyday wear or playtime.', 'This set includes a short-sleeved t-shirt and matching pants. Both garments are made from a soft, breathable fabric (likely cotton blend) suitable for children\\'s sensitive skin. The bright blue base is adorned with a playful pattern of colorful rainbows and small white dots.', 'pictures/products/1781779890_6a33cdb29a810_kw1.webp', '', '', 'XS:0, S:0, L:50, XL:0',  850.00, '', ' NULL',  65,  0,  20, 'Kids\\' Blue Rainbow Print T-shirt and Pants Set | Stitch Smart', 'Adorable and comfortable blue t-shirt and pants set for kids featuring a charming rainbow print. Perfect for everyday wear or playtime. Buy premium quality at b', 'kids, blue, rainbow, print, tshirt, pants, set, stitch smart', '2026-06-18 10:51:30', '2026-06-18 10:51:30', ' NULL', 'kids-blue-rainbow-print-t-shirt-and-pants-set', 'Yes',  50,  0),
(113, '1041', '', 'Girls\\' Pink \"Awesome Girl\" Graphic Long Sleeve T-Shirt', 'Dress your little one in this vibrant pink long-sleeve t-shirt featuring a playful \"Awesome Girl\" graphic. Designed for comfort and style, this tee is perfect for everyday wear.', 'Made from soft and breathable cotton fabric. Features ruffled detailing on the sleeves and a printed \"Awesome Girl\" graphic with colorful striped accents. Crew neck, long sleeves. Suitable for girls.', 'pictures/products/1781779979_6a33ce0b1e651_Kids_Model_10.webp', '', '', 'XS:0, S:50, L:0, XL:0',  499.00, '', ' NULL',  65,  0,  20, 'Girls\\' Pink \"Awesome Girl\" Graphic Long Sleev | Stitch Smart', 'Dress your little one in this vibrant pink long-sleeve t-shirt featuring a playful \"Awesome Girl\" graphic. Designed for comfort and style. Buy premium quality', 'girls, pink, awesome, girl, graphic, long, sleeve, tshirt', '2026-06-18 10:52:59', '2026-06-18 10:52:59', ' NULL', 'girls-pink-awesome-girl-graphic-long-sleeve-t-shirt', 'Yes',  50,  0),
(114, '1042', '', 'Girls Navy \\'Sweet Little Sparkly Girl\\' Butterfly Print T-shirt and Denim Shorts Set', 'Adorable navy blue t-shirt featuring a \\'Sweet Little Sparkly Girl\\' slogan with cute butterfly graphics, paired with comfortable light-wash denim shorts. Perfect for everyday wear and casual outings.', 'T-shirt: 100% Cotton. Shorts: Denim (Cotton Blend). Short sleeves, crew neck t-shirt. Rolled hem shorts with an elasticated waistband for comfort.', 'pictures/products/1781780166_6a33cec61c602_kw3.webp', '', '', 'XS:0, S:50, L:0, XL:0',  750.00, '', ' NULL',  65,  0,  20, 'Girls Navy \\'Sweet Little Sparkly Girl\\' Butterf | Stitch Smart', 'Adorable navy blue t-shirt featuring a \\'Sweet Little Sparkly Girl\\' slogan with cute butterfly graphics, paired with comfortable light-wash. Buy premium qualit', 'girls, navy, sweet, little, sparkly, girl, butterfly, print', '2026-06-18 10:56:06', '2026-06-18 10:56:06', ' NULL', 'girls-navy-sweet-little-sparkly-girl-butterfly-print-t-shirt-and-denim-shorts-set', 'Yes',  50,  0),
(115, '1043', '', 'Cream Ruffle Neck Blouse', 'A charming cream-colored blouse for girls featuring a delicate ruffle neckline and subtle floral embroidery. This top offers a comfortable and stylish addition to any casual outfit.', 'Crafted from a lightweight, breathable fabric, likely a cotton blend, with a textured floral embroidered pattern throughout. The blouse has short, puffed sleeves and a gathered elastic hem for a flattering fit. The prominent ruffle around the neckline adds a touch of sweetness and detail.', 'pictures/products/1781780322_6a33cf62cc5fb_kw4.webp', '', '', 'XS:0, S:0, L:50, XL:0',  850.00, '', ' NULL',  65,  0,  20, 'Cream Ruffle Neck Blouse | Stitch Smart', 'A charming cream-colored blouse for girls featuring a delicate ruffle neckline and subtle floral embroidery. This top offers a comfortable a. Buy premium qualit', 'cream, ruffle, neck, blouse, stitch smart, online shopping, pakistan fashion', '2026-06-18 10:58:42', '2026-06-18 10:58:42', ' NULL', 'cream-ruffle-neck-blouse', 'Yes',  50,  0),
(116, '1044', '', 'Girls\\' White \"Hello Summer Adventure\" T-Shirt and Polka Dot Shorts Set', 'A cute and comfortable t-shirt and shorts set for girls, perfect for summer adventures. The white t-shirt features a fun \"Hello Summer Adventure\" graphic, and the purple shorts are adorned with white polka dots.', 'T-shirt: 100% Cotton. Shorts: 100% Cotton with elastic waistband.', 'pictures/products/1781780451_6a33cfe316bc1_kw5.webp', '', '', 'XS:0, S:50, L:0, XL:0',  499.00, '', ' NULL',  65,  0,  20, 'Girls\\' White \"Hello Summer Adventure\" T-Shirt | Stitch Smart', 'A cute and comfortable t-shirt and shorts set for girls, perfect for summer adventures. The white t-shirt features a fun \"Hello Summer Adve. Buy premium qualit', 'girls, white, hello, summer, adventure, tshirt, polka, dot', '2026-06-18 11:00:51', '2026-06-18 11:00:51', ' NULL', 'girls-white-hello-summer-adventure-t-shirt-and-polka-dot-shorts-set', 'Yes',  50,  0),
(117, '1045', '', 'Cute Dinosaur Applique Knee-High Socks for Kids', 'Adorable knee-high socks for children featuring a charming green dinosaur applique with a pink bow. Perfect for adding a fun and playful touch to any outfit.', 'Made from a soft and comfortable ribbed knit fabric blend, likely cotton and polyester for durability and stretch. The socks are knee-high length, with contrasting yellow and white heel and toe accents. The dinosaur applique is made of felt and soft fabric, with embroidered eyes and a delicate net bow.', 'pictures/products/1781781009_6a33d211acd5b_i1.webp', '', '', 'XS:50, S:50, L:50, XL:0',  199.00, '', ' NULL',  66,  0,  20, 'Cute Dinosaur Applique Knee-High Socks for Kids | Stitch Smart', 'Adorable knee-high socks for children featuring a charming green dinosaur applique with a pink bow. Perfect for adding a fun and playful tou. Buy premium qualit', 'cute, dinosaur, applique, kneehigh, socks, kids, stitch smart, online shopping', '2026-06-18 11:10:09', '2026-06-18 11:10:09', ' NULL', 'cute-dinosaur-applique-knee-high-socks-for-kids', 'Yes',  150,  0),
(118, '1046', '', 'Stylish Baby kids socks', 'Perfect for everyday use', 'Durable and long-lasting', 'pictures/products/1781781154_6a33d2a2b7fb3_i2.webp', '', '', 'XS:0, S:20, L:0, XL:0',  2500.00, '', ' NULL',  66,  0,  20, 'Stylish Baby kids socks | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'stylish, baby, kids, socks, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:12:34', '2026-06-18 11:12:34', ' NULL', 'stylish-baby-kids-socks', 'Yes',  20,  0),
(119, '1047', '', 'Baby Dress Set', 'Excellent value for money', 'Durable and long-lasting', 'pictures/products/1781781253_6a33d3057e333_i3.webp', '', '', 'XS:0, S:30, L:0, XL:0',  5000.00, '', ' NULL',  66,  0,  20, 'Baby Dress Set | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'baby, dress, set, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:14:13', '2026-06-18 11:14:13', ' NULL', 'baby-dress-set', 'Yes',  30,  0),
(120, '1048', '', 'Classic Style Baby Dress Set', 'Carefully selected for premium quality', 'Premium quality material', 'pictures/products/1781781548_6a33d42ca9bc3_i4.jpg', '', '', 'XS:40, S:50, L:0, XL:0',  5000.00, '', ' NULL',  66,  0,  20, 'Classic Style Baby Dress Set | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'classic, style, baby, dress, set, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:19:08', '2026-06-18 11:19:08', ' NULL', 'classic-style-baby-dress-set', 'Yes',  90,  0),
(121, '1049', '', 'Trendy Baby Silicon Socks', 'Excellent value for money', 'Durable and long-lasting', 'pictures/products/1781781679_6a33d4af1bc7a_i5.jpg', '', '', 'XS:45, S:40, L:0, XL:0',  4000.00, '', ' NULL',  66,  0,  20, 'Trendy Baby Silicon Socks | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'trendy, baby, silicon, socks, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:21:19', '2026-06-18 11:21:19', ' NULL', 'trendy-baby-silicon-socks', 'Yes',  85,  0),
(122, '1050', '', 'Men\\'s Brown Vintage Style Jacket', 'Durable and stylish design', 'Premium quality material', 'pictures/products/1781781851_6a33d55bd11f6_j1.jpg', '', '', 'XS:0, S:0, L:60, XL:0',  2500.00, '', ' NULL',  60,  0,  20, 'Men\\'s Brown Vintage Style Jacket | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'mens, brown, vintage, style, jacket, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:24:11', '2026-06-18 11:24:11', ' NULL', 'men-s-brown-vintage-style-jacket', 'Yes',  60,  0),
(123, '1051', '', 'Men\\'s Black Softshell Jacket', 'Excellent value for money', 'Professional quality', 'pictures/products/1781781921_6a33d5a1567c0_j2.jpg', '', '', 'XS:0, S:0, L:45, XL:12',  4000.00, '', ' NULL',  60,  0,  20, 'Men\\'s Black Softshell Jacket | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'mens, black, softshell, jacket, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:25:21', '2026-06-18 11:25:21', ' NULL', 'men-s-black-softshell-jacket', 'Yes',  57,  0),
(124, '1052', '', 'Quality Men\\'s Red Jacket', 'Carefully selected for premium quality', 'Durable and long-lasting', 'pictures/products/1781781997_6a33d5ed7ade6_j3.webp', '', '', 'XS:0, S:0, L:22, XL:35',  45000.00, '', ' NULL',  60,  0,  20, 'Quality Men\\'s Red Jacket | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'quality, mens, red, jacket, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:26:37', '2026-06-18 11:26:37', ' NULL', 'quality-men-s-red-jacket', 'Yes',  57,  0),
(125, '1053', '', 'Men\\'s Black Cargo Style Winter Jacket', 'A stylish and practical black jacket with a cargo-inspired design, featuring multiple pockets and a stand-up collar. Perfect for casual wear and layering.', 'Made from durable cotton blend fabric. Features a full zip front closure, multiple chest and side pockets with button and zip closures, epaulette details on the shoulders, and ribbed cuffs and hem for a comfortable fit. The stand-up collar adds a touch of modern style.', 'pictures/products/1781782074_6a33d63a741a7_j4.webp', '', '', 'XS:0, S:0, L:0, XL:50',  1899.00, '', ' NULL',  60,  0,  20, 'Men\\'s Black Cargo Style Winter Jacket | Stitch Smart', 'A stylish and practical black jacket with a cargo-inspired design, featuring multiple pockets and a stand-up collar. Perfect for casual wear. Buy premium qualit', 'mens, black, cargo, style, winter, jacket, stitch smart, online shopping', '2026-06-18 11:27:54', '2026-06-18 11:27:54', ' NULL', 'men-s-black-cargo-style-winter-jacket', 'Yes',  50,  0),
(126, '1054', '', 'Men\\'s Tan Brown Genuine Leather Bomber Jacket', 'A stylish and durable men\\'s bomber jacket crafted from premium tan brown genuine leather. Perfect for adding a touch of rugged sophistication to any casual or semi-formal outfit.', 'Made from 100% genuine lambskin leather. Features a ribbed collar, zippered front closure, two side zippered pockets, and a comfortable polyester lining. The classic bomber silhouette offers a timeless appeal.', 'pictures/products/1781782117_6a33d665c902d_j5.jpg', '', '', 'XS:0, S:0, L:50, XL:0',  6999.00, '', ' NULL',  60,  0,  20, 'Men\\'s Tan Brown Genuine Leather Bomber Jacket | Stitch Smart', 'A stylish and durable men\\'s bomber jacket crafted from premium tan brown genuine leather. Perfect for adding a touch of rugged sophisticati. Buy premium qualit', 'mens, tan, brown, genuine, leather, bomber, jacket, stitch smart', '2026-06-18 11:28:37', '2026-06-20 10:19:44', ' NULL', 'men-s-tan-brown-genuine-leather-bomber-jacket', 'Yes',  49,  0),
(127, '1055', '', 'Quality Item', 'Excellent value for money', 'Professional quality', 'pictures/products/1781782180_6a33d6a4313bc_p1.webp', '', '', 'XS:0, S:0, L:50, XL:0',  3000.00, '', ' NULL',  59,  0,  20, 'Quality Item | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'quality, item, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:29:40', '2026-06-18 11:29:40', ' NULL', 'quality-item', 'Yes',  50,  0),
(128, '1056', '', 'Trendy Cotton Jeans', 'Perfect for everyday use', 'Comfortable and practical', 'pictures/products/1781782255_6a33d6efb7285_p2.jpg', '', '', 'XS:0, S:0, L:50, XL:0',  3000.00, '', ' NULL',  59,  0,  20, 'Trendy Cotton Jeans | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'trendy, cotton, jeans, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:30:55', '2026-06-18 11:30:55', ' NULL', 'trendy-cotton-jeans', 'Yes',  50,  0),
(129, '1057', '', 'Premium gray cotton pent', 'Durable and stylish design', 'Comfortable and practical', 'pictures/products/1781782332_6a33d73c1dd3b_p3.webp', '', '', 'XS:0, S:0, L:50, XL:0',  2500.00, '', ' NULL',  59,  0,  20, 'Premium gray cotton pent | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'premium, gray, cotton, pent, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:32:12', '2026-06-18 11:32:12', ' NULL', 'premium-gray-cotton-pent', 'Yes',  50,  0),
(130, '1058', '', 'Men\\'s Brown Casual Trousers with Drawstring Waist', 'Comfortable and stylish brown casual trousers for men, featuring a drawstring waist for adjustable fit and a modern, relaxed silhouette. Perfect for everyday wear.', 'Crafted from a soft, breathable fabric blend (likely cotton or a cotton-polyester mix), these trousers offer excellent comfort and durability. They feature a classic straight-leg cut with subtle front pleating for a touch of sophistication. The elasticated waistband with an adjustable drawstring ensures a personalized fit. Side pockets provide practicality, and the overall design makes them versatile for various casual occasions.', 'pictures/products/1781782406_6a33d786c0971_p4.webp', '', '', 'XS:0, S:0, L:50, XL:0',  1499.00, '', ' NULL',  59,  0,  20, 'Men\\'s Brown Casual Trousers with Drawstring Wai | Stitch Smart', 'Comfortable and stylish brown casual trousers for men, featuring a drawstring waist for adjustable fit and a modern, relaxed silhouette. Per. Buy premium qualit', 'mens, brown, casual, trousers, drawstring, waist, stitch smart, online shopping', '2026-06-18 11:33:26', '2026-06-18 11:33:26', ' NULL', 'men-s-brown-casual-trousers-with-drawstring-waist', 'Yes',  50,  0),
(131, '1059', '', 'Quality Pent for Boys', 'Perfect for everyday use', 'Professional quality', 'pictures/products/1781782482_6a33d7d2c8e2c_p5.jpg', '', '', 'XS:0, S:0, L:39, XL:19',  2500.00, '', ' NULL',  59,  0,  2, 'Quality Pent for Boys | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'quality, pent, boys, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:34:42', '2026-06-18 12:00:44', ' NULL', 'quality-pent-for-boys', 'Yes',  58,  0),
(132, '1060', '', 'Trendy Women Western Wear', 'Durable and stylish design', 'Modern design and finish', 'pictures/products/1781782665_6a33d889cd70d_d1.jpg', '', '', 'XS:0, S:0, L:0, XL:100',  4000.00, '', ' NULL',  61,  0,  20, 'Trendy Women Western Wear | Stitch Smart', 'Durable and stylish design. Buy premium quality at best price.', 'trendy, women, western, wear, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:37:45', '2026-06-18 11:37:45', ' NULL', 'trendy-women-western-wear', 'Yes',  100,  0),
(133, '1061', '', 'Quality Women Western Wear', 'Excellent value for money', 'Professional quality', 'pictures/products/1781782789_6a33d90511ee0_d2.jpg', '', '', 'XS:0, S:0, L:0, XL:50',  5000.00, '', ' NULL',  61,  0,  20, 'Quality Women Western Wear | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'quality, women, western, wear, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:39:49', '2026-06-18 11:39:49', ' NULL', 'quality-women-western-wear', 'Yes',  50,  0),
(134, '1062', '', 'Classic Style Formal Western Dress', 'Carefully selected for premium quality', 'Premium quality material', 'pictures/products/1781782910_6a33d97e739f8_d3.jpg', '', '', 'XS:0, S:0, L:100, XL:0',  2500.00, '', ' NULL',  61,  0,  20, 'Classic Style Formal Western Dress | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'classic, style, formal, western, dress, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:41:50', '2026-06-18 11:41:50', ' NULL', 'classic-style-formal-western-dress', 'Yes',  100,  0),
(135, '1063', '', 'Premium Collection West Wear For Women', 'Excellent value for money', 'Premium quality material', 'pictures/products/1781782993_6a33d9d14f58d_d4.jpg', '', '', 'XS:0, S:0, L:0, XL:100',  2000.00, '', ' NULL',  61,  0,  20, 'Premium Collection West Wear For Women | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'premium, collection, west, wear, women, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:43:13', '2026-06-18 11:43:13', ' NULL', 'premium-collection-west-wear-for-women', 'Yes',  100,  0),
(136, '1064', '', 'Premium Western Wear', 'High-quality product with excellent finish', 'Modern design and finish', 'pictures/products/1781783057_6a33da11ad152_d5.jpg', '', '', 'XS:0, S:0, L:60, XL:0',  4000.00, '', ' NULL',  61,  0,  20, 'Premium Western Wear | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'premium, western, wear, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:44:17', '2026-06-18 11:44:17', ' NULL', 'premium-western-wear', 'Yes',  60,  0),
(137, '1065', '', 'Bow Tie Skirt For Women', 'Perfect for everyday use', 'Durable and long-lasting', 'pictures/products/1781783155_6a33da7305363_s1.jpg', '', '', 'XS:0, S:0, L:50, XL:0',  3000.00, '', ' NULL',  63,  0,  20, 'Bow Tie Skirt For Women | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'bow, tie, skirt, women, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:45:55', '2026-06-18 11:45:55', ' NULL', 'bow-tie-skirt-for-women', 'Yes',  50,  0),
(138, '1066', '', 'Premium Women Skirt', 'Excellent value for money', 'Durable and long-lasting', 'pictures/products/1781783250_6a33dad2b7925_s2.jpg', '', '', 'XS:0, S:0, L:50, XL:0',  4000.00, '', ' NULL',  63,  0,  20, 'Premium Women Skirt | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'premium, women, skirt, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:47:30', '2026-06-18 11:47:30', ' NULL', 'premium-women-skirt', 'Yes',  50,  0),
(139, '1067', '', 'Classic Style Skirt', 'High-quality product with excellent finish', 'Durable and long-lasting', 'pictures/products/1781783314_6a33db12e3b2b_s3.webp', '', '', 'XS:0, S:0, L:0, XL:50',  3000.00, '', ' NULL',  63,  0,  20, 'Classic Style Skirt | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'classic, style, skirt, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:48:34', '2026-06-18 11:48:34', ' NULL', 'classic-style-skirt', 'Yes',  50,  0),
(140, '1068', '', 'Branded Blue Skirt', 'Perfect for everyday use', 'Comfortable and practical', 'pictures/products/1781783395_6a33db6368a0d_s4.webp', '', '', 'XS:0, S:0, L:60, XL:0',  5000.00, '', ' NULL',  63,  0,  20, 'Branded Blue Skirt | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'branded, blue, skirt, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:49:55', '2026-06-18 11:49:55', ' NULL', 'branded-blue-skirt', 'Yes',  60,  0),
(141, '1069', '', 'Classic style bow skirt for women', 'High-quality product with excellent finish', 'Comfortable and practical', 'pictures/products/1781783482_6a33dbba0ae5d_s5.webp', '', '', 'XS:0, S:0, L:0, XL:50',  3000.00, '', ' NULL',  63,  0,  20, 'Classic style bow skirt for women | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'classic, style, bow, skirt, women, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:51:22', '2026-06-19 08:08:58', ' NULL', 'classic-style-bow-skirt-for-women', 'Yes',  47,  0),
(142, '1070', '', 'Quality Women Top', 'Excellent value for money', 'Premium quality material', 'pictures/products/1781783554_6a33dc025dc1a_t1.jpg', '', '', 'XS:0, S:0, L:0, XL:50',  2000.00, '', ' NULL',  62,  0,  20, 'Quality Women Top | Stitch Smart', 'Excellent value for money. Buy premium quality at best price.', 'quality, women, top, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:52:34', '2026-06-20 10:19:44', ' NULL', 'quality-women-top', 'Yes',  49,  0),
(143, '1071', '', 'Beautiful trendy top', 'High-quality product with excellent finish', 'Professional quality', 'pictures/products/1781783650_6a33dc627bb5f_t2.webp', '', '', 'XS:0, S:0, L:50, XL:0',  5000.00, '', ' NULL',  62,  0,  20, 'Beautiful trendy top | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'beautiful, trendy, top, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:54:10', '2026-06-18 11:54:10', ' NULL', 'beautiful-trendy-top', 'Yes',  50,  0),
(144, '1072', '', 'Premium Top for girls', 'Perfect for everyday use', 'Modern design and finish', 'pictures/products/1781783716_6a33dca4612c2_t3.jpg', '', '', 'XS:0, S:0, L:50, XL:0',  5000.00, '', ' NULL',  62,  0,  20, 'Premium Top for girls | Stitch Smart', 'Perfect for everyday use. Buy premium quality at best price.', 'premium, top, girls, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:55:16', '2026-06-18 11:55:16', ' NULL', 'premium-top-for-girls', 'Yes',  50,  0),
(145, '1073', '', 'Ladies Casual Top', 'Carefully selected for premium quality', 'Professional quality', 'pictures/products/1781783844_6a33dd24d8caa_t4.webp', '', '', 'XS:0, S:0, L:45, XL:45',  2500.00, '', ' NULL',  62,  0,  20, 'Ladies Casual Top | Stitch Smart', 'Carefully selected for premium quality. Buy premium quality at best price.', 'ladies, casual, top, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:57:24', '2026-06-19 08:12:02', ' NULL', 'ladies-casual-top', 'Yes',  89,  0),
(146, '1074', '', 'Blue Formal Top For Women', 'High-quality product with excellent finish', 'Durable and long-lasting', 'pictures/products/1781783962_6a33dd9a19a3b_t5.webp', '', '', 'XS:0, S:0, L:30, XL:30',  5000.00, '', ' NULL',  62,  0,  20, 'Blue Formal Top For Women | Stitch Smart', 'High-quality product with excellent finish. Buy premium quality at best price.', 'blue, formal, top, women, stitch smart, online shopping, pakistan fashion', '2026-06-18 11:59:22', '2026-06-20 10:19:44', ' NULL', 'blue-formal-top-for-women', 'Yes',  56,  0);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 4042, 62, 4, 'farag ha', '2026-05-25 21:32:26'),
(2, 4042, 63, 2, 'flana tamkann', '2026-05-26 15:15:50'),
(3, 4044, 101, 1, 'Quick Rating', '2026-06-15 17:24:20'),
(4, 4044, 100, 5, 'Quick Rating', '2026-06-15 17:25:54'),
(5, 4044, 101, 3, 'Quick Rating', '2026-06-15 17:29:28'),
(6, 4044, 101, 3, 'Quick Rating', '2026-06-15 17:42:14'),
(7, 4044, 101, 2, 'Quick Rating', '2026-06-15 17:56:17'),
(8, 0, 82, 5, 'Quick Rating', '2026-06-16 04:31:23'),
(9, 4044, 101, 2, 'Quick Rating', '2026-06-16 06:57:34'),
(10, 4044, 99, 4, 'very good i recommennd you not to buy this.', '2026-06-16 07:27:42'),
(11, 4045, 98, 3, 'Best Product', '2026-06-16 14:48:20'),
(12, 4045, 66, 5, 'Nice quality', '2026-06-18 13:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `return_requests`
--

CREATE TABLE `return_requests` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `damage_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_requests`
--

INSERT INTO `return_requests` (`id`, `order_id`, `order_item_id`, `product_id`, `quantity`, `status`, `damage_note`, `created_at`) VALUES
(7, 36, 41, 98, 1, 'restocked', 'Type: Damaged / Defective | Issue: Color is Different | Note: juuj', '2026-06-18 13:18:49'),
(8, 39, 46, 66, 1, 'trashed', 'Type: Damaged / Defective | Issue: Wrong Size / Fit', '2026-06-18 13:27:08'),
(9, 41, 48, 141, 1, 'rejected', 'Type: Standard Return | Issue: Wrong Size / Fit | Note: overall ok', '2026-06-18 13:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `is_verified`, `created_at`, `updated_at`, `last_login`) VALUES
(4038, 'moiz', 'moizmalikofficiall@gmail.com', '$2y$10$yjTgkH6xa1p2WaKMJ.bns.IBqSG49rG7XXgHmw0hzSnzZHGQJP2Iu', '03249670130', 1, '2026-05-17 17:10:50', NULL, '2026-05-18 08:14:03'),
(4039, 'moiz', 'moiz@gmail.com', '$2y$10$E9Od9o8mUJoUO.r1DqynSOiNYQ.b4FzVIzsWn59RRHzp6Q2hovlmS', '1234567', 1, '2026-05-18 02:49:11', NULL, NULL),
(4041, 'SohnaPak', 'sohnapakwears@gmail.com', '$2y$10$FCopsntD2wF333OhQtYpaeRDwCOmIM2/mZK0MUHen9Tutwp/gEmlq', '0339070130', 1, '2026-05-18 22:41:53', NULL, NULL),
(4042, 'moiz', 'stitchsmart@gmail.com', '$2y$10$DZE9547XSApavIifGR7aCulXKOogyUBXtb6mZ2E1aJS697RRR8n9.', '0334523434', 1, '2026-05-21 02:10:10', NULL, '2026-06-04 22:48:39'),
(4043, 'Test Customer', 'test@stitchsmart.com', '$2y$10$SUryCuGMQKknPaglNzd7GOTQHMZNygCXrUq84ZoQ2MqBv45o6rFPK', '+92-300-1234567', 1, '2026-06-14 16:58:28', NULL, '2026-06-14 17:02:30'),
(4044, 'Test User', 'testuser@stitchsmart.com', '$2y$10$iaNdSom0ZIcE5aHyirVNseYjcs0R4NjQ7NU31CK8FI4GjvFWK62Im', '+92-300-1111111', 1, '2026-06-14 17:11:20', NULL, '2026-06-16 09:31:02'),
(4045, 'user', 'user@gmail.com', '$2y$10$FFrl6sJUDTrOd/NST4spiutl2ZvfVhjpUmAeUvC9DLF0cDn/cKLgy', '03034752367', 1, '2026-06-16 07:45:13', NULL, '2026-06-17 23:09:18'),
(4047, 'Bissma', 'bissmaijaz62@gmail.com', '$2y$10$Oz.nXwNlcSIZFKbsPkh/j.yQFG0h4uv.ifOIlVey0FSINHU0r2S3O', '03257926255', 1, '2026-06-16 08:30:57', NULL, '2026-06-20 04:16:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_chats`
--

CREATE TABLE `user_chats` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(10) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_chats`
--

INSERT INTO `user_chats` (`id`, `user_id`, `role`, `message`, `created_at`) VALUES
(3, 4042, 'user', 'hy', '2026-05-26 09:55:29'),
(4, 4042, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-05-26 09:55:45'),
(5, 4042, 'user', 'hy', '2026-05-26 09:57:19'),
(6, 4042, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-05-26 09:57:21'),
(7, 4042, 'user', 'hy', '2026-05-26 09:57:29'),
(8, 4042, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-05-26 09:57:31'),
(9, 4042, 'user', 'hy', '2026-05-26 09:57:43'),
(10, 4042, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-05-26 09:57:45'),
(11, 4042, 'user', 'hy', '2026-05-26 10:02:33'),
(12, 4042, 'bot', '👋 Hi there! Welcome to Stitch Smart. I\'m your virtual shopping assistant.\n\nHow can I help you find the perfect baseball wear, T-shirt, or sportswear today? I can assist with product information, pricing, sizes, and more!', '2026-05-26 10:02:36'),
(13, 4042, 'user', 'can u refer me any black shit and shose', '2026-05-26 10:02:54'),
(14, 4042, 'bot', '👋 I can certainly help you find some black apparel!\n\nRegarding \"shose,\" we don\'t currently carry shoes in our catalog.\n\nHowever, we do have several black shirts, sweatshirts, and', '2026-05-26 10:03:02'),
(15, 4042, 'user', 'any  bomber jacket  do  u  have  any', '2026-05-26 10:03:28'),
(16, 4042, 'bot', 'We don\'t currently have any bomber jackets in our catalog.\n\nHowever, we do have a stylish **Men\'s Denim Jacket** that you might be interested in:\n\n**Men\'s Denim Jacket** — $6000.00\nSize: | Fabric: | Design: Denim Jacket\nA classic denim jacket for a timeless look.\n[🛍️ View Product Details](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=MJ4626-002-BLA)', '2026-05-26 10:03:35'),
(17, 4042, 'user', 'hy', '2026-05-26 14:01:39'),
(18, 4042, 'bot', '👋 Hi there! Welcome to Stitch Smart. I\'m your virtual shopping assistant.\n\nHow can I help you find the perfect baseball wear, T-shirt, or sportswear today? I can assist with product information, pricing, sizes, and more!', '2026-05-26 14:01:43'),
(19, 4042, 'user', 'refer some bomber jacket', '2026-05-26 14:32:04'),
(20, 4042, 'bot', 'We don\'t currently have any bomber jackets in our catalog.\n\nHowever, we do have a stylish leather jacket that might interest you:\n\n**Men\'s Distressed Dark Brown Premium Leather Jacket** — $7499.00\nSize: XS:6, S:2, L:0, XL:0 | Fabric: 100% Genuine Sheepskin Leather | Design: Distressed finish, full-zip, shirt-style collar\nA classic and rugged dark brown leather jacket with a unique distressed finish for a timeless masculine aesthetic.\n[🛍️ View Product Details](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=JAC12)', '2026-05-26 14:32:08'),
(21, 4042, 'user', 'hi', '2026-05-26 20:14:15'),
(22, 4042, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-05-26 20:14:17'),
(23, 4042, 'user', 'HI', '2026-05-29 10:08:14'),
(24, 4042, 'bot', '👋 Hi there! I\'m your virtual shopping assistant from Stitch Smart.\n\nI can help you find baseball wear, T-shirts, and sportswear like hoodies, jackets, leggings, and training tops. I can also answer questions about pricing, sizes, fabric types, and designs, and provide information on shipping and returns.\n\nHow can I assist you today? 🛍️', '2026-05-29 10:08:16'),
(25, 4042, 'user', 'hi', '2026-05-31 08:16:41'),
(26, 4042, 'bot', '👋 Hi there! Welcome to Stitch Smart. I\'m your virtual shopping assistant.\n\nHow can I help you find the perfect baseball wear, T-shirt, or sportswear today? Feel free to ask about products, sizes, prices, or anything else you need!', '2026-05-31 08:16:43'),
(27, 4042, 'user', 'shoes', '2026-05-31 08:16:58'),
(28, 4042, 'bot', 'I\'m sorry, but we don\'t currently have shoes in our catalog at Stitch Smart. Our specialty is baseball wear, T-shirts, and sportswear.\n\nWould you like to explore our range of jackets, shirts, or compression tanks instead? We have many great options for your sportswear needs!', '2026-05-31 08:17:02'),
(29, 4042, 'user', 'baseball', '2026-05-31 08:17:11'),
(30, 4042, 'bot', 'I\'m sorry, but we don\'t currently have specific baseball wear items like jerseys or caps in our catalog at Stitch Smart. Our current selection focuses on general sportswear, T-shirts, and jackets.\n\nWould you like to explore our range of shirts, sweatshirts, or hoodies instead? We have many great options that might suit your needs for casual wear or general sportswear!', '2026-05-31 08:17:13'),
(31, 4044, 'user', 'hy', '2026-06-15 00:36:34'),
(32, 4044, 'bot', '👋 Hi there! Welcome to Stitch Smart. I\'m your virtual shopping assistant.\n\nHow can I help you find the perfect outfit or answer any questions about our products today? 🛍️', '2026-06-15 00:36:37'),
(33, 4044, 'user', 'can u refer me some men products', '2026-06-15 00:49:04'),
(34, 4044, 'bot', 'Certainly! We have a couple of great options that might interest you from our men\'s collection. 🛍️\n\nHere are some in-stock products for men:\n\n• **[sweat shirt mens](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=64)** — Rs. 4,000\n• Category: shirt | Size: XS:5, S:4, L:6, XL:10 | Fabric: Not specified\n• Stock: 25 units\n• Description: sweat shirt mens\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=65)** — Rs. 1,500\n• Category: shirt | Size: XS:4, S:4, L:5, XL:5 | Fabric: Not specified\n• Stock: 18 units\n• Description: Durable and stylish design shirt\n\nLet me know if you\'d like more details on any of these, or if you\'re looking for something specific!', '2026-06-15 00:49:10'),
(35, 4044, 'user', 'sugest some men shirt', '2026-06-15 05:23:26'),
(36, 4044, 'bot', 'Certainly! Here are some in-stock men\'s shirts that might interest you: 🛍️\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=65)** — Rs. 1,500\n• Category: shirt | Size: XS:4, S:4, L:5, XL:5 | Fabric: Not specified\n• Stock: 18 units\n• Description: Durable and stylish design shirt\n\n• **[sweat shirt mens](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=64)** — Rs. 4,000\n• Category: shirt | Size: XS:5, S:4, L:6, XL:10 | Fabric: Not specified\n• Stock: 25 units\n• Description: sweat shirt mens\n\nLet me know if you\'d like to explore other categories or have any specific preferences!', '2026-06-15 05:23:31'),
(37, 4044, 'user', 'hey', '2026-06-15 05:28:38'),
(38, 4044, 'bot', '👋 Hi there! Welcome back to Stitch Smart. I\'m your virtual shopping assistant.\n\nHow can I help you find something special or answer any questions about our products today? 🛍️', '2026-06-15 05:28:42'),
(39, 4044, 'user', 'why r u soo expensive', '2026-06-15 05:29:01'),
(40, 4044, 'bot', 'I understand your concern about pricing. At Stitch Smart, we strive to offer high-quality clothing with unique designs, and our prices reflect the craftsmanship and materials used in our products.\n\nWe also have a range of items at different price points. If you\'re looking for something specific within a certain budget, I\'d be happy to help you find it! 💰\n\nFor example, among our men\'s shirts, the **Trendy Design shirt** is a more budget-friendly option:\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=65)** — Rs. 1,500\n• Category: shirt | Size: XS:4, S:4, L:5, XL:5 | Fabric: Not specified\n• Stock: 18 units\n• Description: Durable and stylish design shirt\n\nPlease let me know your preferences, and I\'ll do my best to find something that suits your needs!', '2026-06-15 05:29:06'),
(41, 4044, 'user', 'which unique design u dnt hve any sense of busniess', '2026-06-15 05:29:40'),
(42, 4044, 'bot', 'I understand your perspective and appreciate your feedback. At Stitch Smart, when we refer to \"design,\" we focus on creating stylish and distinctive pieces that stand out in terms of aesthetics and quality.\n\nWe aim to offer products that combine current trends with durability. For example, the **Trendy Design shirt** is one of our items crafted with a focus on its look and feel:\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=65)** — Rs. 1,500\n• Category: shirt | Size: XS:4, S:4, L:5, XL:5 | Fabric: Not specified\n• Stock: 18 units\n• Description: Durable and stylish design shirt\n\nI\'m here to help you find products that match your specific style and preferences. Please let me know what you\'re looking for, and I\'ll do my best to assist you! 🛍️', '2026-06-15 05:29:40'),
(43, 4044, 'user', 'u idiot', '2026-06-15 05:29:51'),
(44, 4044, 'bot', 'I\'m sorry, but I cannot respond to that kind of language. My purpose is to help you with shopping at Stitch Smart, answer questions about our products, and assist with store policies.\n\nPlease let me know if you have any questions about our clothing, pricing, or anything else related to your shopping experience. I\'m here to help you find what you\'re looking for.', '2026-06-15 05:29:51'),
(45, 4044, 'user', 'shutp', '2026-06-15 05:29:56'),
(46, 4044, 'bot', 'I\'m sorry, but I cannot respond to that kind of language. My purpose is to help you with shopping at Stitch Smart, answer questions about our products, and assist with store policies.\n\nPlease let me know if you have any questions about our clothing, pricing, or anything else related to your shopping experience. I\'m here to help you find what you\'re looking for.', '2026-06-15 05:29:57'),
(47, 4044, 'user', 'hi suggestme some mesn weaar', '2026-06-15 08:38:24'),
(48, 4044, 'bot', '👋 Hello there! I\'d be happy to help you find some men\'s wear from Stitch Smart.\n\nHere are a couple of great options currently in stock: 🛍️\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=65)** — Rs. 1,500\n• Category: shirt | Size: XS:4, S:4, L:5, XL:5 | Fabric: Not specified\n• Stock: 18 units\n• Description: Durable and stylish design shirt\n\n• **[sweat shirt mens](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=64)** — Rs. 4,000\n• Category: shirt | Size: XS:5, S:4, L:6, XL:10 | Fabric: Not specified\n• Stock: 25 units\n• Description: sweat shirt mens\n\nLet me know if you\'re looking for something specific, like a particular style, size, or occasion!', '2026-06-15 08:38:31'),
(49, 4044, 'user', 'hey', '2026-06-15 18:01:04'),
(50, 4044, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-06-15 18:01:06'),
(51, 4047, 'user', 'Show me your Kids collection', '2026-06-17 04:53:57'),
(52, 4047, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-06-17 04:53:59'),
(53, 4045, 'user', 'What sizes do you have available?', '2026-06-18 06:32:45'),
(54, 4045, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-06-18 06:32:47'),
(55, 4047, 'user', 'hey', '2026-06-19 09:25:49'),
(56, 4047, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-06-19 09:25:52'),
(57, 4047, 'user', 'hey', '2026-06-19 09:28:24'),
(58, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️', '2026-06-19 09:28:29'),
(59, 4047, 'user', 'can you shoew me products', '2026-06-19 09:28:43'),
(60, 4047, 'bot', '👋 Hello there! Absolutely, I can show you some products. Here are a few items currently in stock:\n\n• **[sweat shirt mens](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=64)** — Rs. 4000\n• Category: shirt | Size: XS, S, L, XL | Fabric: \n• Stock: 25 units\n• Description: sweat shirt mens\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=65)** — Rs. 1500\n• Category: shirt | Size: XS, S, L, XL | Fabric: \n• Stock: 18 units\n• Description: Durable and stylish design shirt\n\nLet me know if you\'re looking for anything specific! 🛍️', '2026-06-19 09:28:43'),
(61, 4047, 'user', 'hey', '2026-06-19 09:35:46'),
(62, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️', '2026-06-19 09:35:48'),
(63, 4047, 'user', 'I need a help', '2026-06-19 09:37:16'),
(64, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️\n\nIf you\'re looking for some general recommendations, here are a few items currently in stock:\n\n• **[Trendy Cotton Jeans](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=128)** — Rs. 3000\n• Category: Pants | Size: L | Fabric: \n• Stock: 50 units\n• Description: Perfect for everyday use\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=71)** — Rs. 2000\n• Category: Kids | Size: XL | Fabric: \n• Stock: 50 units\n• Description: Durable and stylish design\n\n• **[Premium Collection](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=76)** — Rs. 1000\n• Category: Kids | Size: XS, XL | Fabric: \n• Stock: 51 units\n• Description: Durable and stylish design\n\n• **[Women\'s Classic Fit White Cotton Full Sleeve Shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=103)** — Rs. 1500\n• Category: Women | Size: XS | Fab', '2026-06-19 09:37:16'),
(65, 4047, 'user', 'i want some budget friendly outfit', '2026-06-19 09:37:52'),
(66, 4047, 'bot', '👋 Hello there! I can certainly help you find some budget-friendly outfits. Here are a few options from our current collection that are in stock:\n\n• **[Women\'s Red Crew Neck T-Shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=110)** — Rs. 599\n• Category: Women | Size: XL | Fabric: \n• Stock: 50 units\n• Description: A vibrant red crew neck t-shirt designed for everyday comfort and style.\n\n• **[Cute Dinosaur Applique Knee-High Socks for Kids](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=117)** — Rs. 199\n• Category: Infants | Size: XS, S, L | Fabric: \n• Stock: 150 units\n• Description: Adorable knee-high socks for children featuring a charming green dinosaur applique with a pink bow. Perfect for adding a fun and playful touch to any outfit.\n\n• **[Cream Ruffle Neck Blouse](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=115)** — Rs. 850\n• Category: Girls | Size: L | Fabric: \n• Stock: 50 units\n• Description: A charming cream-c', '2026-06-19 09:37:52'),
(67, 4047, 'user', 'hey', '2026-06-19 09:38:25'),
(68, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️', '2026-06-19 09:38:30'),
(69, 4047, 'user', 'hey', '2026-06-19 09:39:30'),
(70, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️', '2026-06-19 09:39:33'),
(71, 4047, 'user', 'can you help me understand how to order', '2026-06-19 09:40:37'),
(72, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. I can certainly help you understand how to place an order.\n\nTo order, simply browse our catalog, add the items you like to your cart, and proceed to checkout. You\'ll be guided through entering your shipping and payment information.\n\nIf you\'d like to see some of our available products, here are a few popular items:\n\n• **[Quality Men\'s Red Jacket](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=124)** — Rs. 45000\n• Category: Jackets | Size: L, XL | Fabric: \n• Stock: 57 units\n• Description: Carefully selected for premium quality\n\n• **[Classic Style Baby Dress Set](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=120)** — Rs. 5000\n• Category: Infants | Size: XS, S | Fabric: \n• Stock: 90 units\n• Description: Carefully selected for premium quality\n\n• **[Quality Pent for Boys](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=131)** — Rs. 2500\n• Category: Pants | Size: L, XL | Fabric: \n• Stock: 58', '2026-06-19 09:40:40'),
(73, 4047, 'user', 'i dont want so see products dont show me that just payment method', '2026-06-19 09:41:22'),
(74, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. I can certainly help you with information about our payment methods.\n\nWe accept the following payment methods:\n*   Cash on Delivery\n*   Bank Transfer\n\nIf you\'d like to know more about our products or need assistance with anything else, please feel free to ask! 🛍️', '2026-06-19 09:41:27'),
(75, 4047, 'user', 'can you accept debit card', '2026-06-19 09:41:53'),
(76, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart.\n\nRegarding payment methods, we currently accept:\n*   Cash on Delivery\n*   Bank Transfer\n\nWe do not currently accept debit cards directly.\n\nIf you have any other questions about our products or policies, feel free to ask! 🛍️', '2026-06-19 09:41:53'),
(77, 4047, 'user', 'as a demo', '2026-06-19 09:42:08'),
(78, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️\n\nHere are a few of our products that are currently in stock:\n\n• **[Branded Blue Skirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=140)** — Rs. 5000\n• Category: Skirts | Size: L | Fabric: \n• Stock: 60 units\n• Description: Perfect for everyday use\n\n• **[Premium T-Shirt with Trendy Design](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=100)** — Rs. 4000\n• Category: Men | Size: L | Fabric: \n• Stock: 44 units\n• Description: Excellent value for money\n\n• **[Baby Dress Set](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=119)** — Rs. 5000\n• Category: Infants | Size: S | Fabric: \n• Stock: 30 units\n• Description: Excellent value for money\n\n• **[Beautiful trendy top](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=143)** — Rs. 5000\n• Category: Tops | Size: L | Fabric: \n• Stock: 50 units\n• Description: High-quality produc', '2026-06-19 09:42:08'),
(79, 4047, 'user', 'hey', '2026-06-19 09:43:11'),
(80, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️\n\nHere are a few of our products that are currently in stock:\n\n• **[Branded Blue Skirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=140)** — Rs. 5000\n• Category: Skirts | Size: L | Fabric: \n• Stock: 60 units\n• Description: Perfect for everyday use\n\n• **[Premium T-Shirt with Trendy Design](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=100)** — Rs. 4000\n• Category: Men | Size: L | Fabric: \n• Stock: 44 units\n• Description: Excellent value for money\n\n• **[Baby Dress Set](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=119)** — Rs. 5000\n• Category: Infants | Size: S | Fabric: \n• Stock: 30 units\n• Description: Excellent value for money\n\n• **[Beautiful trendy top](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=143)** — Rs. 5000\n• Category: Tops | Size: L | Fabric: \n• Stock: 50 units\n• Description: High-quality produc', '2026-06-19 09:43:16'),
(81, 4047, 'user', 'hey', '2026-06-19 09:44:59'),
(82, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️\n\nHere are a few of our products that are currently in stock:\n\n• **[Trendy Design Black Shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=73)** — Rs. 2000\n• Category: Kids | Size: XS | Fabric: \n• Stock: 50 units\n• Description: High-quality product with excellent finish\n\n• **[Quality Women Top](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=142)** — Rs. 2000\n• Category: Tops | Size: XL | Fabric: \n• Stock: 50 units\n• Description: Excellent value for money\n\n• **[Stylish Baby kids socks](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=118)** — Rs. 2500\n• Category: Infants | Size: S | Fabric: \n• Stock: 20 units\n• Description: Perfect for everyday use\n\n• **[Classic style bow skirt for women](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=141)** — Rs. 3000\n• Category: Skirts | Size: XL | Fabric: \n• Stock: 47 units\n• ', '2026-06-19 09:45:05'),
(83, 4047, 'user', 'can you suggest me something budget friendly in kids category', '2026-06-19 09:46:27'),
(84, 4047, 'bot', '👋 Hello there! I can certainly help you find some budget-friendly options in the kids\' category. Here are a few items that are currently in stock:\n\n• **[Cute Dinosaur Applique Knee-High Socks for Kids](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=117)** — Rs. 199\n• Category: Infants | Size: XS, S, L | Fabric: \n• Stock: 150 units\n• Description: Adorable knee-high socks for children featuring a charming green dinosaur applique with a pink bow. Perfect for adding a fun and playful touch to any outfit.\n\n• **[Kids\' Blue Rainbow Print T-shirt and Pants Set](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=112)** — Rs. 850\n• Category: Girls | Size: L | Fabric: \n• Stock: 50 units\n• Description: Adorable and comfortable blue t-shirt and pants set for kids featuring a charming rainbow print. Perfect for everyday wear or playtime.\n\n• **[Trendy Design Black Shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=73)** — Rs. 2000\n• Catego', '2026-06-19 09:46:30'),
(85, 4047, 'user', 'hey', '2026-06-19 09:48:10'),
(86, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️\n\nHere are a few of our products that are currently in stock:\n\n• **[Trendy Cotton Jeans](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=128)** — Rs. 3000\n• Category: Pants | Size: L | Fabric: \n• Stock: 50 units\n• Description: Perfect for everyday use\n\n• **[Trendy Women Western Wear](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=132)** — Rs. 4000\n• Category: Dresses | Size: XL | Fabric: \n• Stock: 100 units\n• Description: Durable and stylish design\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=71)** — Rs. 2000\n• Category: Kids | Size: XL | Fabric: \n• Stock: 50 units\n• Description: Durable and stylish design\n\n• **[Premium gray cotton pent](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=129)** — Rs. 2500\n• Category: Pants | Size: L | Fabric: \n• Stock: 50 units\n• Description: Durable and s', '2026-06-19 09:48:14'),
(87, 4047, 'user', 'can i customize our product in your website', '2026-06-19 09:49:29'),
(88, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart.\n\nWe currently do not offer product customization on our website. However, we have a wide variety of ready-to-wear items that are designed with quality and style in mind.\n\nHere are a few of our popular products:\n\n• **[Trendy Women Western Wear](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=132)** — Rs. 4000\n• Category: Dresses | Size: XL | Fabric: \n• Stock: 100 units\n• Description: Durable and stylish design\n\n• **[Classic Style Formal Western Dress](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=134)** — Rs. 2500\n• Category: Dresses | Size: L | Fabric: \n• Stock: 100 units\n• Description: Carefully selected for premium quality\n\n• **[Trendy Design Black Shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=73)** — Rs. 2000\n• Category: Kids | Size: XS | Fabric: \n• Stock: 50 units\n• Description: High-quality product with excellent finish\n\n• **[Trendy Cotton Jeans](http://localhost/Stitch-S', '2026-06-19 09:49:29'),
(89, 4047, 'user', 'hey', '2026-06-19 09:51:45'),
(90, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart. How can I help you find the perfect outfit today? 🛍️\n\nHere are a few of our products that are currently in stock:\n\n• **[Trendy Cotton Jeans](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=128)** — Rs. 3000\n• Category: Pants | Size: L | Fabric: \n• Stock: 50 units\n• Description: Perfect for everyday use\n\n• **[Trendy Women Western Wear](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=132)** — Rs. 4000\n• Category: Dresses | Size: XL | Fabric: \n• Stock: 100 units\n• Description: Durable and stylish design\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=71)** — Rs. 2000\n• Category: Kids | Size: XL | Fabric: \n• Stock: 50 units\n• Description: Durable and stylish design\n\n• **[Premium gray cotton pent](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=129)** — Rs. 2500\n• Category: Pants | Size: L | Fabric: \n• Stock: 50 units\n• Description: Durable and s', '2026-06-19 09:51:50'),
(91, 4047, 'user', 'can you provide customization in website', '2026-06-19 09:52:16'),
(92, 4047, 'bot', '👋 Hello there! Welcome to Stitch Smart.\n\nWe currently do not offer product customization on our website. However, we have a wide variety of ready-to-wear items that are designed with quality and style in mind.\n\nHere are a few of our popular products that are currently in stock:\n\n• **[Trendy Cotton Jeans](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=128)** — Rs. 3000\n• Category: Pants | Size: L | Fabric: \n• Stock: 50 units\n• Description: Perfect for everyday use\n\n• **[Premium gray cotton pent](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=129)** — Rs. 2500\n• Category: Pants | Size: L | Fabric: \n• Stock: 50 units\n• Description: Durable and stylish design\n\n• **[Trendy Design Black Shirt](http://localhost/Stitch-Smart/public/index.php?page=product_show&id=73)** — Rs. 2000\n• Category: Kids | Size: XS | Fabric: \n• Stock: 50 units\n• Description: High-quality product with excellent finish\n\n• **[Trendy Design shirt](http://localhost/Stitch-Smart/publ', '2026-06-19 09:52:16'),
(93, 4047, 'user', 'hey', '2026-06-19 09:56:42'),
(94, 4047, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-06-19 09:56:52'),
(95, 4047, 'user', 'hey', '2026-06-19 09:58:21'),
(96, 4047, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-06-19 09:58:31'),
(97, 4047, 'user', 'hey', '2026-06-19 09:59:47'),
(98, 4047, 'bot', 'Sorry, the assistant is currently unavailable. Please try again later.', '2026-06-19 09:59:57'),
(99, 4047, 'user', 'hey', '2026-06-20 07:11:34'),
(100, 4047, 'bot', 'Hello! Welcome to Stitch Smart. How can I help you today?', '2026-06-20 07:11:35'),
(101, 4047, 'user', 'how are you', '2026-06-20 07:11:40'),
(102, 4047, 'bot', 'I am a virtual assistant and do not have feelings. How can I help you today?', '2026-06-20 07:11:42'),
(103, 4047, 'user', 'in your website can i customize my hoodie', '2026-06-20 07:12:03'),
(104, 4047, 'bot', 'Yes, you can customize products using the \"Design Yourself\" feature. You can also place \"Art Orders\" for custom designs.', '2026-06-20 07:12:05'),
(105, 4047, 'user', 'ok that great', '2026-06-20 07:12:17'),
(106, 4047, 'bot', 'Great! How else can I assist you today?', '2026-06-20 07:12:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_searches`
--

CREATE TABLE `user_searches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_searches`
--

INSERT INTO `user_searches` (`id`, `user_id`, `query`, `created_at`) VALUES
(1, 4045, 'sw', '2026-06-18 14:47:19'),
(2, 4045, 'swe', '2026-06-18 14:47:20'),
(3, 4045, 'swea', '2026-06-18 14:47:20'),
(4, 4045, 'sweat', '2026-06-18 14:47:20'),
(5, 4045, 'bo', '2026-06-18 14:50:30'),
(6, 4045, 'boy', '2026-06-18 14:50:31'),
(7, 4045, 'boys', '2026-06-18 14:50:31'),
(8, 4045, 'boys', '2026-06-18 14:50:31'),
(9, 4045, 'boys c', '2026-06-18 14:50:31'),
(10, 4045, 'boys co', '2026-06-18 14:50:31'),
(11, 4045, 'boys col', '2026-06-18 14:50:32'),
(12, 4045, 'boys colt', '2026-06-18 14:50:32'),
(13, 4045, 'boys colth', '2026-06-18 14:50:32'),
(14, 4045, 'boys colthe', '2026-06-18 14:50:32'),
(15, 4045, 'boys colthes', '2026-06-18 14:50:33'),
(16, 4047, 'bl', '2026-06-19 08:20:40'),
(17, 4047, 'bla', '2026-06-19 08:20:41'),
(18, 4047, 'bo', '2026-06-19 08:21:13'),
(19, 4047, 'boy', '2026-06-19 08:21:14'),
(20, 4047, 'boysx', '2026-06-19 08:21:14'),
(21, 4047, 'boysx', '2026-06-19 08:21:14'),
(22, 4047, 'boysx', '2026-06-19 08:21:15'),
(23, 4047, 'bl', '2026-06-20 11:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `code` varchar(60) NOT NULL,
  `discount_percent` int(11) NOT NULL,
  `redeemed` tinyint(1) NOT NULL DEFAULT 0,
  `order_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `redeemed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `email`, `customer_name`, `code`, `discount_percent`, `redeemed`, `order_id`, `created_at`, `redeemed_at`) VALUES
(1, 'bissmaijaz62@gmail.com', 'Bissma Ijaz', 'BIS18WD', 10, 0, NULL, '2026-05-27 22:51:09', NULL),
(2, 'moizmalikofficiall@gmail.com', 'moiz', 'MOI89HW', 10, 0, NULL, '2026-05-27 22:51:16', NULL),
(4, 'moizmalikofficiall@gmail.com', 'moiz', 'MOI77NP', 25, 0, NULL, '2026-05-27 23:00:35', NULL),
(5, 'stitchsmartofficial@gmail.com', 'Aleesha Ali', 'ALE72ZS', 30, 0, NULL, '2026-05-27 23:01:57', NULL),
(6, 'bissmaijaz62@gmail.com', 'Bissma Ijaz', 'BIS54BL', 10, 0, NULL, '2026-05-31 15:36:24', NULL),
(7, 'moizmalikofficiall@gmail.com', 'moiz', 'MOI31YZ', 30, 0, NULL, '2026-05-31 15:36:27', NULL),
(8, 'stitchsmartofficial@gmail.com', 'Aleesha Ali', 'ALE65RF', 30, 0, NULL, '2026-05-31 15:36:31', NULL),
(9, 'stitchsmart@gmail.com', 'moiz', 'MOI67RW', 15, 0, NULL, '2026-05-31 16:18:20', NULL),
(10, 'stitchsmart@gmail.com', 'moiz', 'MOI92WA', 14, 0, NULL, '2026-05-31 16:18:31', NULL),
(11, 'bissmaijaz62@gmail.com', 'Bissma Ijaz', 'BIS79DZ', 13, 0, NULL, '2026-06-01 05:25:00', NULL),
(12, 'testuser@stitchsmart.com', 'Test User', 'TES58IV', 14, 0, NULL, '2026-06-16 06:37:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` int(1) NOT NULL,
  `web_name` varchar(250) NOT NULL,
  `web_mail` varchar(150) NOT NULL,
  `web_contact` varchar(100) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `instagram` varchar(200) NOT NULL,
  `pinterest` varchar(200) NOT NULL,
  `linkdin` varchar(200) NOT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `theme` varchar(50) DEFAULT 'theme-luxury'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `web_name`, `web_mail`, `web_contact`, `facebook`, `instagram`, `pinterest`, `linkdin`, `meta_title`, `meta_description`, `meta_keywords`, `theme`) VALUES
(1, 'www.StitchSmart.com', 'stitchsmartofficial@gmail.com', '+92 3249670130', 'https://www.facebook.com/stitch-smart', 'https://www.instagram.com/stitch-smart/', 'https://pinterest.com/stitch-smart', 'www.linkedin.com', 'Stitch Smart | Premium Sustainable Fashion', 'Discover Stitch Smart: Elevate your style with ethically crafted, premium sustainable fashion. Experience luxury, comfort, and timeless designs for the discerning individual.', 'Stitch Smart, premium fashion, sustainable fashion, luxury clothing, ethical fashion, designer apparel, eco-friendly fashion, high-end fashion, conscious fashion, quality clothing, timeless style', 'theme-default'),
(1, 'www.StitchSmart.com', 'stitchsmartofficial@gmail.com', '+92 3249670130', 'https://www.facebook.com/stitch-smart', 'https://www.instagram.com/stitch-smart/', 'https://pinterest.com/stitch-smart', 'www.linkedin.com', 'Stitch Smart | Premium Sustainable Fashion', 'Discover Stitch Smart: Elevate your style with ethically crafted, premium sustainable fashion. Experience luxury, comfort, and timeless designs for the discerning individual.', 'Stitch Smart, premium fashion, sustainable fashion, luxury clothing, ethical fashion, designer apparel, eco-friendly fashion, high-end fashion, conscious fashion, quality clothing, timeless style', 'theme-default'),
(1, 'Stitch Smart', 'stitchsmartofficiall@gmail.com', '+92 12345565', 'https://www.facebook.com/stitch-smart', 'https://www.instagram.com/stitch-smart/', 'https://pinterest.com/stitch-smart', 'www.linkedin.com', '', '', '', 'theme-default');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(7, 4042, 32, '2026-05-29 20:54:02'),
(8, 4042, 21, '2026-05-31 07:35:11'),
(9, 4042, 24, '2026-05-31 19:50:26'),
(17, 4044, 74, '2026-06-15 18:05:19'),
(18, 4044, 80, '2026-06-16 06:47:26'),
(20, 4047, 97, '2026-06-16 16:36:10'),
(22, 4045, 66, '2026-06-18 06:09:43'),
(23, 4045, 146, '2026-06-18 14:01:25'),
(24, 4047, 146, '2026-06-20 09:31:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_name` (`c_name`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status_created` (`status`,`created_at`),
  ADD KEY `idx_recipient_email` (`recipient_email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_number` (`article_number`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `parent_cat` (`parent_cat`),
  ADD KEY `fk_color` (`color_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_product` (`user_id`,`product_id`);

--
-- Indexes for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_chats`
--
ALTER TABLE `user_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_idx` (`user_id`);

--
-- Indexes for table `user_searches`
--
ALTER TABLE `user_searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_idx` (`user_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_product` (`user_id`,`product_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4048;

--
-- AUTO_INCREMENT for table `user_chats`
--
ALTER TABLE `user_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `user_searches`
--
ALTER TABLE `user_searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_color` FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `category` (`c_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`parent_cat`) REFERENCES `category` (`c_id`) ON DELETE SET NULL;

--
-- Constraints for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD CONSTRAINT `return_requests_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_requests_ibfk_2` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_requests_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
