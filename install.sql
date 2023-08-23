-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2021 at 04:43 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codecanyon_manyvendor`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_identifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  `image` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`id`, `name`, `unique_identifier`, `version`, `activated`, `image`, `created_at`, `updated_at`) VALUES
(5, 'paytm', NULL, '1', 1, 'paytm-banner.jpg', '2021-03-10 03:35:35', '2021-03-10 03:35:35'),
(6, 'product_export_import', NULL, '1', 1, 'productExportImport-banner.jpg', '2021-03-10 03:35:58', '2021-03-10 03:35:58'),
(7, 'ssl_commerz', NULL, '1', 1, 'ssl-commerz-banner.jpg', '2021-03-10 03:36:25', '2021-03-10 03:36:25'),
(8, 'affiliate_marketing', NULL, '1', 1, 'affiliate-system-banner.jpg', '2021-03-10 03:36:49', '2021-03-10 03:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `admin_commissions`
--

CREATE TABLE `admin_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `confirm_by` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `percentage` double(8,2) NOT NULL,
  `commission` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_accounts`
--

CREATE TABLE `affiliate_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `affiliation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `balance` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_paid_histories`
--

CREATE TABLE `affiliate_paid_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `is_cancelled` tinyint(1) NOT NULL DEFAULT 0,
  `payment_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_date` datetime DEFAULT NULL,
  `confirmed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_payments_accounts`
--

CREATE TABLE `affiliate_payments_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bank',
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routing_number` int(11) DEFAULT NULL,
  `paypal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Paypal',
  `paypal_acc_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_acc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Stripe',
  `stripe_acc_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_acc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_card_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payTm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'payTm',
  `payTm_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bKash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bKash',
  `bKash_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nagad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nagad',
  `nagad_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rocket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rocket',
  `rocket_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_sell_histories`
--

CREATE TABLE `affiliate_sell_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `affiliation_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordered_product_id` bigint(20) UNSIGNED NOT NULL,
  `order_amount` double NOT NULL,
  `amount` double NOT NULL,
  `is_pending` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `is_requested` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offer` bigint(20) UNSIGNED NOT NULL,
  `start_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_for_seller` tinyint(1) NOT NULL DEFAULT 1,
  `active_for_customer` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_requested` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_products`
--

CREATE TABLE `campaign_products` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_product_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `vpvs_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_product_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `top` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_requested` tinyint(1) NOT NULL DEFAULT 0,
  `parent_category_id` int(11) NOT NULL DEFAULT 0,
  `cat_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `meta_title` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_percentage` double DEFAULT NULL,
  `end_percentage` double DEFAULT NULL,
  `start_amount` double DEFAULT NULL,
  `end_amount` double DEFAULT NULL,
  `commission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `type` enum('percentage','flat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_amount` double DEFAULT NULL,
  `end_amount` double DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

CREATE TABLE `complains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` bigint(20) UNSIGNED NOT NULL,
  `complain_photos` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('solved','Not Solved','Untouched') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  `start_day` datetime NOT NULL,
  `end_day` datetime NOT NULL,
  `min_value` double DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` double NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `align` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `rate`, `is_published`, `align`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Dollar', 'USD', '$', 1, 1, 1, 'Flag_of_the_United_States.png', NULL, '2021-01-02 11:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/avatar.jpg',
  `phn_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliver_assigns`
--

CREATE TABLE `deliver_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deliver_user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `delivered` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pick` tinyint(1) NOT NULL DEFAULT 0,
  `pick_date` timestamp NULL DEFAULT NULL,
  `duration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliver_users`
--

CREATE TABLE `deliver_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT 0,
  `confirm_by` bigint(20) UNSIGNED DEFAULT NULL,
  `confirm_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveymen_tracks`
--

CREATE TABLE `deliveymen_tracks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deliverymen_id` bigint(20) UNSIGNED NOT NULL,
  `deliver_assign_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_campaign_products`
--

CREATE TABLE `ecom_campaign_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_carts`
--

CREATE TABLE `ecom_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_stock_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_deliver_assigns`
--

CREATE TABLE `ecom_deliver_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deliver_user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pick` tinyint(1) NOT NULL DEFAULT 0,
  `pick_date` datetime DEFAULT NULL,
  `duration` datetime DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirm',
  `delivered` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_deliver_tracks`
--

CREATE TABLE `ecom_deliver_tracks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deliverymen_id` bigint(20) UNSIGNED NOT NULL,
  `deliver_assign_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_deliveymen_tracks`
--

CREATE TABLE `ecom_deliveymen_tracks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deliverymen_id` bigint(20) UNSIGNED NOT NULL,
  `deliver_assign_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_orders`
--

CREATE TABLE `ecom_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_id` int(11) NOT NULL,
  `area_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logistic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `logistic_charge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applied_coupon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` enum('cod','stripe','paypal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_order_products`
--

CREATE TABLE `ecom_order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_code` bigint(20) UNSIGNED NOT NULL,
  `order_number` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `logistic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('cod','stripe','paypal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','delivered','canceled','follow_up','processing','quality_check','product_dispatched','confirmed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_star` int(11) DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecom_product_variant_stocks`
--

CREATE TABLE `ecom_product_variant_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variants_id` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_variants` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `extra_price` double NOT NULL DEFAULT 0,
  `alert_quantity` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `slug`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'super-admin', NULL, NULL, '2020-08-12 00:19:29', '2021-01-28 10:20:18'),
(2, 'customer', 'customer', NULL, NULL, '2020-08-12 04:06:36', '2020-08-12 04:06:36'),
(3, 'seller', 'seller', NULL, NULL, '2020-08-12 04:08:56', '2020-08-17 21:00:22'),
(5, 'Deliver section', 'deliver-section', NULL, NULL, '2020-12-27 00:44:34', '2020-12-27 00:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `group_has_permissions`
--

CREATE TABLE `group_has_permissions` (
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_has_permissions`
--

INSERT INTO `group_has_permissions` (`group_id`, `permission_id`) VALUES
(2, 111),
(3, 106),
(3, 110),
(3, 113),
(5, 118),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(1, 105),
(1, 107),
(1, 108),
(1, 109),
(1, 112),
(1, 115),
(1, 116),
(1, 117),
(1, 119),
(1, 106),
(1, 113);

-- --------------------------------------------------------

--
-- Table structure for table `infopages`
--

CREATE TABLE `infopages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section` enum('top','bottom') COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `infopages`
--

INSERT INTO `infopages` (`id`, `section`, `icon`, `header`, `desc`, `page_id`, `created_at`, `updated_at`) VALUES
(1, 'bottom', 'fa fa-support', 'Support 24/7', 'Call us : (+09)001101001', 6, '2020-08-28 23:17:59', '2020-08-31 02:37:20'),
(2, 'bottom', 'fa fa-refresh', 'Secured Payment', 'Your payments are secured', 3, '2020-08-28 23:19:26', '2020-08-28 23:19:26'),
(3, 'bottom', 'fa fa-star', 'Product Quality', 'We ensure best products for you', 5, '2020-08-28 23:20:51', '2020-08-28 23:21:59'),
(4, 'bottom', 'fa fa-bullhorn', 'Special Offer', 'Exciting Offers', 5, '2020-08-28 23:30:24', '2020-08-28 23:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'Flag_of_the_United_States.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logistics`
--

CREATE TABLE `logistics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistic_areas`
--

CREATE TABLE `logistic_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logistic_id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_03_16_005237_create_permissions_table', 1),
(9, '2019_03_16_005538_create_user_has_permissions_table', 1),
(10, '2019_03_16_005634_create_groups_table', 1),
(11, '2019_03_16_005759_create_group_has_permissions_table', 1),
(12, '2019_03_16_005834_create_user_has_groups_table', 1),
(13, '2019_08_19_000000_create_failed_jobs_table', 1),
(14, '2020_05_21_093740_create_settings_table', 1),
(15, '2020_05_21_093839_create_categories_table', 1),
(16, '2020_05_21_093908_create_currencies_table', 1),
(17, '2020_05_21_093935_create_languages_table', 1),
(18, '2020_05_21_203324_create_pages_table', 1),
(19, '2020_05_21_203341_create_page_contents_table', 1),
(20, '2020_06_12_164431_create_modules_table', 1),
(21, '2020_06_12_164655_create_module_has_permissions_table', 1),
(22, '2020_06_17_075327_create_brands_table', 1),
(23, '2020_06_18_152443_create_commissions_table', 1),
(24, '2020_06_18_205802_create_vendors_table', 1),
(25, '2020_06_19_061010_create_category_groups_table', 1),
(26, '2020_06_20_063516_create_section_settings_table', 1),
(27, '2020_06_23_080421_create_variants_table', 1),
(28, '2020_06_24_044443_create_products_table', 1),
(29, '2020_06_24_045956_create_product_images_table', 1),
(30, '2020_06_24_050102_create_product_variants_table', 1),
(31, '2020_06_27_094308_create_customers_table', 1),
(32, '2020_06_27_132906_create_vendor_products_table', 1),
(33, '2020_07_04_082306_create_carts_table', 1),
(34, '2020_07_06_052133_create_promotions_table', 1),
(35, '2020_07_06_130948_create_wishlists_table', 1),
(36, '2020_07_08_054549_create_districts_table', 1),
(37, '2020_07_08_054723_create_thanas_table', 1),
(38, '2020_07_08_071829_create_logistics_table', 1),
(39, '2020_07_08_091228_create_logistic_areas_table', 1),
(40, '2020_07_09_084030_create_vendor_product_variant_stocks_table', 1),
(41, '2020_07_09_100615_create_campaigns_table', 1),
(42, '2020_07_09_114210_create_coupons_table', 1),
(43, '2020_07_13_065921_create_campaign_products_table', 1),
(44, '2020_07_23_120041_create_orders_table', 1),
(45, '2020_07_23_121543_create_order_products_table', 1),
(46, '2020_07_29_094601_create_complains_table', 1),
(47, '2020_08_07_052102_create_page_groups_table', 1),
(48, '2020_08_10_104715_create_admin_commissions_table', 1),
(49, '2020_08_13_092807_create_infopages_table', 1),
(50, '2020_08_18_032558_create_seller_earnings_table', 1),
(51, '2020_08_18_071516_create_seller_accounts_table', 1),
(52, '2020_08_18_072008_create_payments_table', 1),
(53, '2020_08_20_083105_create_ecom_product_variant_stocks_table', 1),
(54, '2020_08_23_034334_create_ecom_campaign_products_table', 1),
(55, '2020_08_23_052929_create_ecom_carts_table', 1),
(56, '2020_08_24_032931_create_ecom_orders_table', 1),
(57, '2020_08_24_033032_create_ecom_order_products_table', 1),
(58, '2020_11_03_064315_create_verify_users_table', 1),
(64, '2020_12_27_061137_create_deliver_assigns_table', 2),
(65, '2020_12_28_042652_create_deliver_users_table', 2),
(67, '2020_12_29_052949_create_deliveymen_tracks_table', 3),
(68, '2020_12_30_113834_create_ecom_deliver_assigns_table', 4),
(69, '2020_12_30_113912_create_ecom_deliver_tracks_table', 4),
(70, '2020_12_30_114918_create_ecom_deliveymen_tracks_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `created_at`, `updated_at`) VALUES
(6, 'backend Module', '2020-08-12 03:18:02', '2020-08-17 20:59:19'),
(7, 'Seller Panel', '2020-08-12 03:36:16', '2020-08-12 03:36:16'),
(8, 'front End', '2020-08-12 03:36:27', '2020-08-12 03:36:27'),
(9, 'order managment', '2020-08-17 20:59:36', '2020-08-17 20:59:36'),
(10, 'Payment manage', '2020-08-18 03:19:46', '2020-08-18 03:19:46'),
(11, 'delivermen', '2020-12-27 00:44:04', '2020-12-27 00:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `module_has_permissions`
--

CREATE TABLE `module_has_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_has_permissions`
--

INSERT INTO `module_has_permissions` (`id`, `permission_id`, `module_id`, `created_at`, `updated_at`) VALUES
(164, 111, 8, '2020-08-12 03:36:27', '2020-08-12 03:36:27'),
(196, 110, 7, '2020-08-17 20:58:49', '2020-08-17 20:58:49'),
(225, 106, 9, '2020-08-17 20:59:36', '2020-08-17 20:59:36'),
(226, 113, 9, '2020-08-17 20:59:37', '2020-08-17 20:59:37'),
(227, 114, 10, '2020-08-18 03:19:46', '2020-08-18 03:19:46'),
(228, 82, 6, '2020-08-25 04:35:21', '2020-08-25 04:35:21'),
(229, 83, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(230, 84, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(231, 85, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(232, 86, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(233, 87, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(234, 88, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(235, 89, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(236, 90, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(237, 91, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(238, 92, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(239, 93, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(240, 94, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(241, 95, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(242, 96, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(243, 97, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(244, 98, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(245, 99, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(246, 100, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(247, 101, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(248, 102, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(249, 103, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(250, 104, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(251, 105, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(252, 107, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(253, 108, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(254, 109, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(255, 112, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(256, 115, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(257, 116, 6, '2020-08-25 04:35:22', '2020-08-25 04:35:22'),
(258, 117, 6, NULL, NULL),
(259, 118, 11, '2020-12-27 00:44:04', '2020-12-27 00:44:04'),
(260, 119, 6, '2020-12-27 00:44:04', '2020-12-27 00:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Manyvendor Personal Access Client', 'o6ZnLH0Y5WBSOiPP7ecaGvVVrBF3l8ZL3zS5LAmW', NULL, 'http://localhost', 1, 0, 0, '2020-11-04 05:15:45', '2020-11-04 05:15:45'),
(2, NULL, 'Manyvendor Password Grant Client', '9BhQhUljGSbKrKXRLqJFpZfxeqaUWQiK1zPnYIu7', 'users', 'http://localhost', 0, 1, 0, '2020-11-04 05:15:45', '2020-11-04 05:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-11-04 05:15:45', '2020-11-04 05:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_id` int(11) NOT NULL,
  `area_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logistic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `logistic_charge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applied_coupon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` enum('cod','stripe','paypal','paytm','ssl-commerz') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` bigint(20) UNSIGNED NOT NULL,
  `order_number` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `logistic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('cod','stripe','paypal','paytm','ssl-commerz') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','delivered','canceled','follow_up','processing','quality_check','product_dispatched','confirmed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_star` int(11) DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `page_group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `active`, `created_at`, `updated_at`, `page_group_id`) VALUES
(1, 'How It Works', 'how-it-works', 1, '2020-08-28 22:57:18', '2021-01-03 10:53:27', 6),
(2, 'Reviews', 'reviews', 1, '2020-08-28 23:00:03', '2021-01-03 10:54:24', 6),
(3, 'Privacy Policy', 'privacy-policy', 1, '2020-08-28 23:02:55', '2021-01-03 10:54:34', 5),
(4, 'Cookie Policy', 'cookie-policy', 1, '2020-08-28 23:04:00', '2021-01-03 10:54:41', 5),
(5, 'Purchasing Policy', 'purchasing-policy', 1, '2020-08-28 23:04:33', '2021-01-03 10:54:56', 5),
(6, 'About Us', 'about-us', 1, '2020-08-28 23:13:59', '2021-01-03 10:55:04', 6),
(7, 'Affiliate Marketing', 'affiliate-marketing', 1, '2020-08-28 23:15:41', '2021-01-03 10:55:10', 5),
(8, 'how', 'how', 0, '2021-01-02 10:38:19', '2021-01-03 10:53:16', 5),
(9, 'Site Map', 'site-map', 1, '2021-01-03 10:56:45', '2021-01-03 10:56:45', 7),
(10, 'Place Order', 'place-order', 1, '2021-01-03 10:57:27', '2021-01-03 10:57:27', 7),
(11, 'Location', 'location', 1, '2021-01-03 10:58:24', '2021-01-03 10:58:24', 8),
(12, 'Address', 'address', 1, '2021-01-03 10:58:37', '2021-01-03 10:58:37', 8),
(13, 'Location 2', 'location-2', 1, '2021-01-03 10:58:52', '2021-01-03 10:58:52', 8),
(14, 'Page 1', 'page-1', 1, '2021-01-03 11:07:55', '2021-01-03 11:07:55', 6),
(15, 'Page 2', 'page-2', 1, '2021-01-03 11:08:14', '2021-01-03 11:08:14', 7),
(16, 'Page 3', 'page-3', 1, '2021-01-03 11:08:24', '2021-01-03 11:08:24', 7),
(17, 'Page 4', 'page-4', 1, '2021-01-03 11:08:37', '2021-01-03 11:08:37', 8);

-- --------------------------------------------------------

--
-- Table structure for table `page_contents`
--

CREATE TABLE `page_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_data` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_groups`
--

CREATE TABLE `page_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_groups`
--

INSERT INTO `page_groups` (`id`, `name`, `is_published`, `created_at`, `updated_at`) VALUES
(5, 'Our Services', 1, '2021-01-02 10:37:55', '2021-01-03 10:50:48'),
(6, 'Information', 1, '2021-01-03 10:51:07', '2021-01-03 10:51:07'),
(7, 'About Site', 1, '2021-01-03 10:56:12', '2021-01-03 10:56:12'),
(8, 'Contact Us', 1, '2021-01-03 10:56:29', '2021-01-03 10:56:29');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `current_balance` double DEFAULT NULL,
  `process` enum('Bank','Paypal','Stripe') COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Request','Confirm') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_change_date` datetime DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(82, 'dashboard', 'dashboard', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">dashboard</pre>', NULL, '2020-08-12 03:10:28', '2020-08-12 03:10:28'),
(83, 'user management', 'user-management', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">user-management</pre>', NULL, '2020-08-12 03:10:35', '2020-08-12 03:10:35'),
(84, 'user setup', 'user-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">user-setup</pre>', NULL, '2020-08-12 03:10:40', '2020-08-12 03:10:40'),
(85, 'group setup', 'group-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">group-setup</pre>', NULL, '2020-08-12 03:10:45', '2020-08-12 03:10:45'),
(86, 'manage permissions', 'permissions-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">permissions-manage</pre>', NULL, '2020-08-12 03:10:51', '2020-08-12 03:10:51'),
(87, 'mail configuration', 'mail-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">mail-setup</pre>', NULL, '2020-08-12 03:10:56', '2020-08-12 03:10:56'),
(88, 'site settings', 'site-setting', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">site-setting</pre>', NULL, '2020-08-12 03:11:01', '2020-08-12 03:11:01'),
(89, 'language setup', 'language-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">language-setup</pre>', NULL, '2020-08-12 03:11:07', '2020-08-12 03:11:07'),
(90, 'currency setup', 'currency-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">currency-setup</pre>', NULL, '2020-08-12 03:11:12', '2020-08-12 03:11:12'),
(91, 'manage pages', 'pages-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">pages-manage</pre>', NULL, '2020-08-12 03:11:40', '2020-08-12 03:11:40'),
(92, 'category management', 'category-management', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">category-management</pre>', NULL, '2020-08-12 03:11:50', '2020-08-12 03:11:50'),
(93, 'commission management', 'commission-management', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">commission-management</pre>', NULL, '2020-08-12 03:11:55', '2020-08-12 03:11:55'),
(94, 'section settings', 'section-setting', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">section-setting</pre>', NULL, '2020-08-12 03:12:26', '2020-08-12 03:12:26'),
(95, 'additional setting', 'additional-setting', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">additional-setting</pre>', NULL, '2020-08-12 03:12:33', '2020-08-12 03:12:33'),
(96, 'manage product variant', 'product-variant-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">product-variant-manage</pre>', NULL, '2020-08-12 03:12:38', '2020-08-12 03:12:38'),
(97, 'manage product', 'product-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">product-manage</pre>', NULL, '2020-08-12 03:12:44', '2020-08-12 03:12:44'),
(98, 'ecommerce setting', 'ecommerce-setting', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">ecommerce-setting</pre>', NULL, '2020-08-12 03:12:49', '2020-08-12 03:12:49'),
(99, 'manage brand', 'brand-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">brand-manage</pre>', NULL, '2020-08-12 03:12:53', '2020-08-12 03:12:53'),
(100, 'manage campaign', 'campaign-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">campaign-manage</pre>', NULL, '2020-08-12 03:12:58', '2020-08-12 03:12:58'),
(101, 'payment method setup', 'payment-method-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">payment-method-setup</pre>', NULL, '2020-08-12 03:13:26', '2020-08-12 03:13:26'),
(102, 'promotions banner setup', 'promotions-banner-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">promotions-banner-setup</pre>', NULL, '2020-08-12 03:13:32', '2020-08-12 03:13:32'),
(103, 'main slider', 'main-slider-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">main-slider-setup</pre>', NULL, '2020-08-12 03:13:37', '2020-08-12 03:13:37'),
(104, 'shipping setup', 'shipping-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">shipping-setup</pre>', NULL, '2020-08-12 03:13:44', '2020-08-12 03:13:44'),
(105, 'coupon setup', 'coupon-setup', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">coupon-setup</pre>', NULL, '2020-08-12 03:13:50', '2020-08-12 03:13:50'),
(106, 'order manage', 'order-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">order-manage</pre>', NULL, '2020-08-12 03:13:56', '2020-08-12 03:13:56'),
(107, 'fullfillment', 'fullfill-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">fullfill-manage</pre>', NULL, '2020-08-12 03:14:01', '2020-08-12 03:14:01'),
(108, 'manage complain', 'complain-manage', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">complain-manage</pre>', NULL, '2020-08-12 03:14:07', '2020-08-12 03:14:07'),
(109, 'admin earning', 'admin-earning', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\">admin-earning</pre>', NULL, '2020-08-12 03:14:13', '2020-08-12 03:14:13'),
(110, 'seller', 'seller', NULL, NULL, '2020-08-12 03:35:48', '2020-08-12 03:35:48'),
(111, 'customer', 'customer', NULL, NULL, '2020-08-12 03:35:57', '2020-08-12 03:35:57'),
(112, 'seller management', 'seller-management', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\"><span style=\"color:#6a8759;background-color:#232525;\">seller.management</span></pre>', NULL, '2020-08-12 05:05:42', '2020-08-12 05:05:42'),
(113, 'order-modify', 'order-modify', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\"><span style=\"color:#6a8759;background-color:#232525;\">order-modify</span></pre>', NULL, '2020-08-17 20:57:54', '2020-08-17 20:57:54'),
(114, 'seller-payment', 'seller-payment', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\"><span style=\"color:#6a8759;background-color:#232525;\">seller-payment</span></pre>', NULL, '2020-08-18 03:18:53', '2020-08-18 03:18:53'),
(115, 'switch mode', 'app-active', '<pre style=\"background-color:#2b2b2b;color:#a9b7c6;font-family:\'JetBrains Mono\',monospace;font-size:9.8pt;\"><span style=\"color:#6a8759;background-color:#232525;\">app-active</span></pre>', NULL, '2020-08-25 04:35:05', '2020-08-25 04:35:05'),
(116, 'addons-manager', 'addons-manager', NULL, NULL, NULL, NULL),
(117, 'affiliate-management', 'affiliate-management', NULL, NULL, NULL, NULL),
(118, 'deliver', 'deliver', '<p>this deliver</p>', NULL, '2020-12-27 00:43:46', '2020-12-27 00:43:46'),
(119, 'deliver-management', 'deliver-management', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` bigint(20) DEFAULT NULL,
  `short_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `big_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` enum('youtube','vimeo') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_request` tinyint(1) NOT NULL DEFAULT 0,
  `have_variant` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `tax` double NOT NULL DEFAULT 0,
  `product_price` double DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `is_discount` tinyint(1) DEFAULT NULL,
  `discount_type` enum('flat','per') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_price` double DEFAULT NULL,
  `discount_percentage` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile_desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_stocks`
--

CREATE TABLE `product_variant_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variants_id` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_variants` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `extra_price` double NOT NULL DEFAULT 0,
  `alert_quantity` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL,
  `type` enum('header','category','section','mainSlider','popup') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_settings`
--

CREATE TABLE `section_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `active` double NOT NULL DEFAULT 1,
  `sort` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blade_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_settings`
--

INSERT INTO `section_settings` (`id`, `active`, `sort`, `name`, `blade_name`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Hero Section', 'main-banner', 'images/section/main-banner.png', NULL, NULL, '2020-08-08 03:38:49'),
(2, 1, 2, 'Trending Category', 'search-trending', 'images/section/search-trending.png', NULL, NULL, '2020-08-08 03:38:49'),
(3, 1, 3, 'Campaigns', 'deal-day', 'images/section/deal-day.png', NULL, NULL, NULL),
(4, 1, 4, 'Brands', 'shop-brand', 'images/section/shop-brand.png', NULL, NULL, NULL),
(5, 1, 6, 'Shops', 'shop-store', 'images/section/shop-store.png', NULL, NULL, '2020-11-16 04:06:41'),
(6, 0, 5, 'Promotions', 'promotional-banner', 'images/section/promotional-banner.png', NULL, NULL, '2021-01-03 11:16:15'),
(7, 0, 7, 'Categories', 'top-categories', 'images/section/top-categories.png', NULL, NULL, '2021-01-03 11:16:19'),
(8, 1, 8, 'Popular categories', 'category-promotional', 'images/section/category-promotional.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seller_accounts`
--

CREATE TABLE `seller_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bank',
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routing_number` int(11) DEFAULT NULL,
  `paypal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Paypal',
  `paypal_acc_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_acc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Stripe',
  `stripe_acc_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_acc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_card_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_earnings`
--

CREATE TABLE `seller_earnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_product_stock_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `commission_pay` double DEFAULT NULL,
  `get_amount` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'default_currencies', '1', NULL, NULL),
(2, 'type_logo', 'uploads/site/TxlH0sLrU22wiJ1ev0HELuOsts0CsIh592cRCuKN.png', NULL, '2020-09-22 06:05:56'),
(3, 'type_name', 'Jason Charles', NULL, '2021-03-10 03:33:56'),
(4, 'type_footer', 'Aut non nesciunt la', NULL, '2021-03-10 03:33:56'),
(5, 'type_mail', 'Eu dolores doloribus', NULL, '2021-03-10 03:33:56'),
(6, 'type_address', 'At voluptas ea a qui', NULL, '2021-03-10 03:33:56'),
(7, 'type_fb', 'Aspernatur quaerat n', NULL, '2021-03-10 03:33:56'),
(8, 'type_tw', 'Ad suscipit accusant', NULL, '2021-03-10 03:33:56'),
(9, 'type_number', '172', NULL, '2021-03-10 03:33:56'),
(10, 'type_google', 'Velit consequatur c', NULL, '2021-03-10 03:33:56'),
(11, 'footer_logo', NULL, NULL, '2020-08-06 00:07:09'),
(12, 'favicon_icon', 'uploads/site/WU01pUNSdsLDKpHitn3iNRutY1JbXgaY7Po6H1OS.png', NULL, '2020-09-22 06:05:56'),
(13, 'seller', 'enable', NULL, NULL),
(14, 'primary_color', NULL, NULL, '2020-08-06 00:44:26'),
(15, 'secondary_color', NULL, NULL, '2020-08-06 00:44:26'),
(16, 'seller_mode', 'request', NULL, '2020-12-29 05:07:50'),
(17, 'verification', 'on', NULL, '2020-12-29 05:07:50'),
(18, 'login_modal', 'on', NULL, '2020-08-06 00:44:27'),
(19, 'payment_logo', 'uploads/logo/8iN3FR7aoQlaKtTUpZG4txLVG3vF7q5OXtNqWQ6p.png', NULL, '2020-08-09 23:31:44'),
(20, 'type_ios', 'https://play.google.com/store/apps/details?id=com.softechit.many_vendor_ecommerce_app', NULL, '2020-10-22 09:47:51'),
(21, 'type_appstore', 'uploads/site/ItQJHlwNBesLo098tuYq5lFFKtz9XKoTT0SvYzW8.png', NULL, '2020-10-22 09:55:18'),
(22, 'type_playstore', 'uploads/site/HrxX6heoPShhSqt2DFyxYeu3We2BU2Fz7Fve40cY.png', NULL, '2020-10-22 09:55:18'),
(23, 'type_android', 'https://play.google.com/store/apps/details?id=com.multivendor.many_vendor_app', NULL, '2020-10-22 09:47:51'),
(45, 'affiliate_commission', NULL, '2020-11-03 03:34:22', '2020-11-03 03:34:22'),
(46, 'affiliate_min_withdrawal', NULL, '2020-11-03 03:34:22', '2020-11-03 03:34:22'),
(47, 'affiliate_cookie_limit', NULL, '2020-11-03 03:34:22', '2020-11-03 03:34:22'),
(48, 'affiliate_payment', NULL, '2020-11-03 03:34:22', '2020-11-03 03:34:22'),
(49, 'affiliate_commission', NULL, '2020-11-04 00:54:59', '2020-11-04 00:54:59'),
(50, 'affiliate_min_withdrawal', NULL, '2020-11-04 00:54:59', '2020-11-04 00:54:59'),
(51, 'affiliate_cookie_limit', NULL, '2020-11-04 00:54:59', '2020-11-04 00:54:59'),
(52, 'affiliate_payment', NULL, '2020-11-04 00:54:59', '2020-11-04 00:54:59'),
(53, 'affiliate_commission', NULL, '2021-03-10 03:36:49', '2021-03-10 03:36:49'),
(54, 'affiliate_min_withdrawal', NULL, '2021-03-10 03:36:49', '2021-03-10 03:36:49'),
(55, 'affiliate_cookie_limit', NULL, '2021-03-10 03:36:49', '2021-03-10 03:36:49'),
(56, 'affiliate_payment', NULL, '2021-03-10 03:36:49', '2021-03-10 03:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `thanas`
--

CREATE TABLE `thanas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thana_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genders` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/avatar.png',
  `login_time` timestamp NULL DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(240) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `balance`, `email`, `tel_number`, `genders`, `banned`, `avatar`, `login_time`, `provider_id`, `provider`, `email_verified_at`, `password`, `nationality`, `user_type`, `remember_token`, `created_at`, `updated_at`, `fcode`) VALUES
(39, 'Mohammad Prince', 'mohammad-prince', NULL, 'mprince2k16@gmail.com', NULL, NULL, 0, 'images/avatar.png', '2021-03-10 03:39:35', NULL, NULL, '2021-03-10 03:34:16', '$2y$10$sKHQ0JUQnSDfFSdHNbMcre0hWZ/mPsUWNbOlUWEsOoJjmyX6xbhSS', NULL, 'Admin', NULL, '2021-03-10 03:34:18', '2021-03-10 03:39:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_groups`
--

CREATE TABLE `user_has_groups` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_has_groups`
--

INSERT INTO `user_has_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 2),
(9, 2),
(13, 2),
(14, 5),
(15, 5),
(16, 5),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 5),
(23, 5),
(24, 5),
(25, 5),
(26, 5),
(27, 5),
(28, 5),
(29, 5),
(31, 5),
(32, 5),
(33, 5),
(34, 5),
(35, 5),
(30, 1),
(36, 2),
(37, 3),
(38, 1),
(39, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_permissions`
--

CREATE TABLE `user_has_permissions` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` float DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_name` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trade_licence` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_logo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approve_status` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_products`
--

CREATE TABLE `vendor_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_price` double NOT NULL,
  `purchase_price` double DEFAULT NULL,
  `is_discount` tinyint(1) DEFAULT NULL,
  `discount_type` enum('flat','per') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_price` double DEFAULT NULL,
  `discount_percentage` double DEFAULT NULL,
  `have_variant` tinyint(1) NOT NULL DEFAULT 0,
  `stock` int(11) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_product_variant_stocks`
--

CREATE TABLE `vendor_product_variant_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variants_id` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_variants` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `extra_price` double NOT NULL DEFAULT 0,
  `alert_quantity` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verify_users`
--

CREATE TABLE `verify_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_commissions`
--
ALTER TABLE `admin_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_accounts`
--
ALTER TABLE `affiliate_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affiliate_accounts_user_id_unique` (`user_id`);

--
-- Indexes for table `affiliate_paid_histories`
--
ALTER TABLE `affiliate_paid_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_payments_accounts`
--
ALTER TABLE `affiliate_payments_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affiliate_payments_accounts_user_id_unique` (`user_id`);

--
-- Indexes for table `affiliate_sell_histories`
--
ALTER TABLE `affiliate_sell_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_products`
--
ALTER TABLE `campaign_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complains`
--
ALTER TABLE `complains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliver_assigns`
--
ALTER TABLE `deliver_assigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliver_users`
--
ALTER TABLE `deliver_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveymen_tracks`
--
ALTER TABLE `deliveymen_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_campaign_products`
--
ALTER TABLE `ecom_campaign_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_carts`
--
ALTER TABLE `ecom_carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_deliver_assigns`
--
ALTER TABLE `ecom_deliver_assigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_deliver_tracks`
--
ALTER TABLE `ecom_deliver_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_deliveymen_tracks`
--
ALTER TABLE `ecom_deliveymen_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_orders`
--
ALTER TABLE `ecom_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_order_products`
--
ALTER TABLE `ecom_order_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecom_product_variant_stocks`
--
ALTER TABLE `ecom_product_variant_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infopages`
--
ALTER TABLE `infopages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistics`
--
ALTER TABLE `logistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistic_areas`
--
ALTER TABLE `logistic_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_has_permissions`
--
ALTER TABLE `module_has_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_contents`
--
ALTER TABLE `page_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_groups`
--
ALTER TABLE `page_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variant_stocks`
--
ALTER TABLE `product_variant_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_settings`
--
ALTER TABLE `section_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_accounts`
--
ALTER TABLE `seller_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_earnings`
--
ALTER TABLE `seller_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thanas`
--
ALTER TABLE `thanas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_products`
--
ALTER TABLE `vendor_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_product_variant_stocks`
--
ALTER TABLE `vendor_product_variant_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_users`
--
ALTER TABLE `verify_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin_commissions`
--
ALTER TABLE `admin_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `affiliate_accounts`
--
ALTER TABLE `affiliate_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `affiliate_paid_histories`
--
ALTER TABLE `affiliate_paid_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_payments_accounts`
--
ALTER TABLE `affiliate_payments_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `affiliate_sell_histories`
--
ALTER TABLE `affiliate_sell_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `campaign_products`
--
ALTER TABLE `campaign_products`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complains`
--
ALTER TABLE `complains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deliver_assigns`
--
ALTER TABLE `deliver_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `deliver_users`
--
ALTER TABLE `deliver_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `deliveymen_tracks`
--
ALTER TABLE `deliveymen_tracks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ecom_campaign_products`
--
ALTER TABLE `ecom_campaign_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecom_carts`
--
ALTER TABLE `ecom_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ecom_deliver_assigns`
--
ALTER TABLE `ecom_deliver_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ecom_deliver_tracks`
--
ALTER TABLE `ecom_deliver_tracks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecom_deliveymen_tracks`
--
ALTER TABLE `ecom_deliveymen_tracks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ecom_orders`
--
ALTER TABLE `ecom_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ecom_order_products`
--
ALTER TABLE `ecom_order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ecom_product_variant_stocks`
--
ALTER TABLE `ecom_product_variant_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `infopages`
--
ALTER TABLE `infopages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logistics`
--
ALTER TABLE `logistics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logistic_areas`
--
ALTER TABLE `logistic_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `module_has_permissions`
--
ALTER TABLE `module_has_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `page_contents`
--
ALTER TABLE `page_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `page_groups`
--
ALTER TABLE `page_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variant_stocks`
--
ALTER TABLE `product_variant_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `section_settings`
--
ALTER TABLE `section_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `seller_accounts`
--
ALTER TABLE `seller_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seller_earnings`
--
ALTER TABLE `seller_earnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `thanas`
--
ALTER TABLE `thanas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vendor_products`
--
ALTER TABLE `vendor_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_product_variant_stocks`
--
ALTER TABLE `vendor_product_variant_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verify_users`
--
ALTER TABLE `verify_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
