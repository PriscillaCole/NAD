-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 08:00 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leave_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Dashboard', 'fa-bar-chart', '/dashboard', NULL, NULL, '2024-04-05 02:14:31'),
(2, 0, 5, 'Admin', 'fa-tasks', NULL, NULL, NULL, '2024-02-13 08:08:24'),
(3, 2, 6, 'Users', 'fa-users', 'auth/users', NULL, NULL, '2024-02-13 07:35:31'),
(4, 2, 7, 'Roles', 'fa-user', 'auth/roles', NULL, NULL, '2024-02-13 07:35:31'),
(5, 2, 8, 'Permission', 'fa-ban', 'auth/permissions', NULL, NULL, '2024-02-13 07:35:31'),
(6, 2, 9, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL, '2024-02-13 07:35:31'),
(7, 2, 10, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL, '2024-02-13 07:35:31'),
(8, 0, 2, 'Staff Management', 'fa-users', 'staff', NULL, '2024-02-13 07:32:27', '2024-02-13 07:37:45'),
(9, 0, 3, 'Leave Request', 'fa-question-circle', 'leave-datas', NULL, '2024-02-13 07:34:25', '2024-02-13 07:35:31'),
(10, 0, 4, 'Leave Types', 'fa-sticky-note', 'leave-types', NULL, '2024-02-13 07:35:06', '2024-02-13 08:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `admin_operation_log`
--

CREATE TABLE `admin_operation_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_operation_log`
--

INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(1, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:22:56', '2024-02-13 07:22:56'),
(2, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:23:00', '2024-02-13 07:23:00'),
(3, 1, 'auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Staff\",\"icon\":\"fa-users\",\"uri\":\"staff\",\"roles\":[null],\"permission\":null,\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\"}', '2024-02-13 07:32:27', '2024-02-13 07:32:27'),
(4, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:32:27', '2024-02-13 07:32:27'),
(5, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:32:47', '2024-02-13 07:32:47'),
(6, 1, 'auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Leave Request\",\"icon\":\"fa-question-circle\",\"uri\":\"leave-datas\",\"roles\":[null],\"permission\":null,\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\"}', '2024-02-13 07:34:25', '2024-02-13 07:34:25'),
(7, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:34:25', '2024-02-13 07:34:25'),
(8, 1, 'auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Leave Types\",\"icon\":\"fa-sticky-note\",\"uri\":\"leave-types\",\"roles\":[null],\"permission\":null,\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\"}', '2024-02-13 07:35:06', '2024-02-13 07:35:06'),
(9, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:35:06', '2024-02-13 07:35:06'),
(10, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:35:10', '2024-02-13 07:35:10'),
(11, 1, 'auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"_order\":\"[{\\\"id\\\":1},{\\\"id\\\":8},{\\\"id\\\":9},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":10},{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2024-02-13 07:35:31', '2024-02-13 07:35:31'),
(12, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:35:31', '2024-02-13 07:35:31'),
(13, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:36:35', '2024-02-13 07:36:35'),
(14, 1, 'auth/roles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:36:39', '2024-02-13 07:36:39'),
(15, 1, 'auth/roles', 'POST', '127.0.0.1', '{\"slug\":\"supervisor\",\"name\":\"Supervisor\",\"permissions\":[\"1\",null],\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:37:10', '2024-02-13 07:37:10'),
(16, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:37:10', '2024-02-13 07:37:10'),
(17, 1, 'auth/roles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:37:12', '2024-02-13 07:37:12'),
(18, 1, 'auth/roles', 'POST', '127.0.0.1', '{\"slug\":\"staff\",\"name\":\"Staff\",\"permissions\":[\"1\",null],\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:37:28', '2024-02-13 07:37:28'),
(19, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:37:29', '2024-02-13 07:37:29'),
(20, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:37:32', '2024-02-13 07:37:32'),
(21, 1, 'auth/menu/8/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:37:36', '2024-02-13 07:37:36'),
(22, 1, 'auth/menu/8', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Staff Management\",\"icon\":\"fa-users\",\"uri\":\"staff\",\"roles\":[null],\"permission\":null,\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:37:45', '2024-02-13 07:37:45'),
(23, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:37:45', '2024-02-13 07:37:45'),
(24, 1, 'auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"_order\":\"[{\\\"id\\\":1},{\\\"id\\\":8},{\\\"id\\\":9},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":10},{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2024-02-13 07:38:01', '2024-02-13 07:38:01'),
(25, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:38:01', '2024-02-13 07:38:01'),
(26, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:38:04', '2024-02-13 07:38:04'),
(27, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:38:18', '2024-02-13 07:38:18'),
(28, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:38:26', '2024-02-13 07:38:26'),
(29, 1, 'auth/roles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:38:32', '2024-02-13 07:38:32'),
(30, 1, 'auth/roles', 'POST', '127.0.0.1', '{\"slug\":\"dev\",\"name\":\"Dev\",\"permissions\":[\"1\",null],\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:38:50', '2024-02-13 07:38:50'),
(31, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:38:50', '2024-02-13 07:38:50'),
(32, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:38:54', '2024-02-13 07:38:54'),
(33, 1, 'auth/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:38:56', '2024-02-13 07:38:56'),
(34, 1, 'auth/users', 'POST', '127.0.0.1', '{\"username\":\"dev1\",\"name\":\"Priscilla\",\"password\":\"dev1\",\"password_confirmation\":\"dev1\",\"roles\":[\"4\",null],\"permissions\":[\"1\",null],\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-02-13 07:39:44', '2024-02-13 07:39:44'),
(35, 1, 'auth/users/2', 'GET', '127.0.0.1', '[]', '2024-02-13 07:39:45', '2024-02-13 07:39:45'),
(36, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:39:52', '2024-02-13 07:39:52'),
(37, 1, 'auth/roles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:39:55', '2024-02-13 07:39:55'),
(38, 1, 'auth/roles/1', 'PUT', '127.0.0.1', '{\"slug\":\"administrator\",\"name\":\"Administrator\",\"permissions\":[\"2\",\"3\",\"4\",null],\"_token\":\"hZXXnWWxoYuO3ffBxRMmmRxYPasC53QGFHjeenss\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:40:29', '2024-02-13 07:40:29'),
(39, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:40:29', '2024-02-13 07:40:29'),
(40, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:40:33', '2024-02-13 07:40:33'),
(41, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:40:37', '2024-02-13 07:40:37'),
(42, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:40:39', '2024-02-13 07:40:39'),
(43, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:40:44', '2024-02-13 07:40:44'),
(44, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:40:46', '2024-02-13 07:40:46'),
(45, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:40:48', '2024-02-13 07:40:48'),
(46, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:40:49', '2024-02-13 07:40:49'),
(47, 2, '/', 'GET', '127.0.0.1', '[]', '2024-02-13 07:42:28', '2024-02-13 07:42:28'),
(48, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:42:49', '2024-02-13 07:42:49'),
(49, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:43:05', '2024-02-13 07:43:05'),
(50, 2, 'auth/menu/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:43:09', '2024-02-13 07:43:09'),
(51, 2, 'auth/menu/2', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Admin\",\"icon\":\"fa-tasks\",\"uri\":null,\"roles\":[\"1\",\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:43:20', '2024-02-13 07:43:20'),
(52, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:43:20', '2024-02-13 07:43:20'),
(53, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:43:23', '2024-02-13 07:43:23'),
(54, 2, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:43:28', '2024-02-13 07:43:28'),
(55, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:43:33', '2024-02-13 07:43:33'),
(56, 2, 'auth/menu/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:43:37', '2024-02-13 07:43:37'),
(57, 2, 'auth/menu/3', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Users\",\"icon\":\"fa-users\",\"uri\":\"auth\\/users\",\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:43:43', '2024-02-13 07:43:43'),
(58, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:43:43', '2024-02-13 07:43:43'),
(59, 2, 'auth/menu/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:43:52', '2024-02-13 07:43:52'),
(60, 2, 'auth/menu/4', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Roles\",\"icon\":\"fa-user\",\"uri\":\"auth\\/roles\",\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:43:57', '2024-02-13 07:43:57'),
(61, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:43:57', '2024-02-13 07:43:57'),
(62, 2, 'auth/menu/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:44:03', '2024-02-13 07:44:03'),
(63, 2, 'auth/menu/5', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Permission\",\"icon\":\"fa-ban\",\"uri\":\"auth\\/permissions\",\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:44:08', '2024-02-13 07:44:08'),
(64, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:44:08', '2024-02-13 07:44:08'),
(65, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:44:15', '2024-02-13 07:44:15'),
(66, 2, 'auth/menu/10/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:44:30', '2024-02-13 07:44:30'),
(67, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:44:35', '2024-02-13 07:44:35'),
(68, 2, 'auth/menu/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:44:39', '2024-02-13 07:44:39'),
(69, 2, 'auth/menu/4', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Roles\",\"icon\":\"fa-user\",\"uri\":\"auth\\/roles\",\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:44:42', '2024-02-13 07:44:42'),
(70, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:44:43', '2024-02-13 07:44:43'),
(71, 2, 'auth/menu/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:44:45', '2024-02-13 07:44:45'),
(72, 2, 'auth/menu/5', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Permission\",\"icon\":\"fa-ban\",\"uri\":\"auth\\/permissions\",\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:44:48', '2024-02-13 07:44:48'),
(73, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:44:48', '2024-02-13 07:44:48'),
(74, 2, 'auth/menu/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:44:50', '2024-02-13 07:44:50'),
(75, 2, 'auth/menu/6', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Menu\",\"icon\":\"fa-bars\",\"uri\":\"auth\\/menu\",\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:44:59', '2024-02-13 07:44:59'),
(76, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:44:59', '2024-02-13 07:44:59'),
(77, 2, 'auth/menu/7/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:45:02', '2024-02-13 07:45:02'),
(78, 2, 'auth/menu/7', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Operation log\",\"icon\":\"fa-history\",\"uri\":\"auth\\/logs\",\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:45:07', '2024-02-13 07:45:07'),
(79, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:45:07', '2024-02-13 07:45:07'),
(80, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:45:11', '2024-02-13 07:45:11'),
(81, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:45:16', '2024-02-13 07:45:16'),
(82, 1, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:45:23', '2024-02-13 07:45:23'),
(83, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-13 07:45:33', '2024-02-13 07:45:33'),
(84, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:45:44', '2024-02-13 07:45:44'),
(85, 2, 'auth/menu/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:46:52', '2024-02-13 07:46:52'),
(86, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:47:15', '2024-02-13 07:47:15'),
(87, 2, 'auth/menu/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:47:19', '2024-02-13 07:47:19'),
(88, 2, 'auth/menu/2', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Admin\",\"icon\":\"fa-tasks\",\"uri\":null,\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:47:26', '2024-02-13 07:47:26'),
(89, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:47:26', '2024-02-13 07:47:26'),
(90, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:47:30', '2024-02-13 07:47:30'),
(91, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:47:34', '2024-02-13 07:47:34'),
(92, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:47:43', '2024-02-13 07:47:43'),
(93, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:47:54', '2024-02-13 07:47:54'),
(94, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:47:58', '2024-02-13 07:47:58'),
(95, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:48:00', '2024-02-13 07:48:00'),
(96, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:48:01', '2024-02-13 07:48:01'),
(97, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:48:02', '2024-02-13 07:48:02'),
(98, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:48:03', '2024-02-13 07:48:03'),
(99, 2, 'auth/menu/10/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:48:14', '2024-02-13 07:48:14'),
(100, 2, 'auth/menu/10', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Leave Types\",\"icon\":\"fa-sticky-note\",\"uri\":\"leave-types\",\"roles\":[\"1\",\"4\",null],\"permission\":null,\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:48:30', '2024-02-13 07:48:30'),
(101, 2, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:48:31', '2024-02-13 07:48:31'),
(102, 2, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:48:36', '2024-02-13 07:48:36'),
(103, 2, 'auth/roles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:48:49', '2024-02-13 07:48:49'),
(104, 2, 'auth/roles/1', 'PUT', '127.0.0.1', '{\"slug\":\"administrator\",\"name\":\"Administrator\",\"permissions\":[\"1\",null],\"_token\":\"Fv0dH0hnF8nCjOaQsMGj1hAQrjb52tLEBBvOEfDl\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:49:22', '2024-02-13 07:49:22'),
(105, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:49:22', '2024-02-13 07:49:22'),
(106, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-02-13 07:49:26', '2024-02-13 07:49:26'),
(107, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:49:29', '2024-02-13 07:49:29'),
(108, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:49:30', '2024-02-13 07:49:30'),
(109, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:49:32', '2024-02-13 07:49:32'),
(110, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:49:34', '2024-02-13 07:49:34'),
(111, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:50:17', '2024-02-13 07:50:17'),
(112, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:50:21', '2024-02-13 07:50:21'),
(113, 1, 'auth/menu/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:50:23', '2024-02-13 07:50:23'),
(114, 1, 'auth/menu/3', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Users\",\"icon\":\"fa-users\",\"uri\":\"auth\\/users\",\"roles\":[\"1\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 07:50:31', '2024-02-13 07:50:31'),
(115, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 07:50:31', '2024-02-13 07:50:31'),
(116, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:50:43', '2024-02-13 07:50:43'),
(117, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:51:37', '2024-02-13 07:51:37'),
(118, 1, 'auth/roles/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:51:43', '2024-02-13 07:51:43'),
(119, 1, 'auth/roles/4', 'PUT', '127.0.0.1', '{\"slug\":\"caumm\",\"name\":\"CAUMM\",\"permissions\":[\"2\",\"3\",\"4\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:52:45', '2024-02-13 07:52:45'),
(120, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:52:45', '2024-02-13 07:52:45'),
(121, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:52:54', '2024-02-13 07:52:54'),
(122, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:52:58', '2024-02-13 07:52:58'),
(123, 2, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:00', '2024-02-13 07:53:00'),
(124, 2, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:07', '2024-02-13 07:53:07'),
(125, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:38', '2024-02-13 07:53:38'),
(126, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:39', '2024-02-13 07:53:39'),
(127, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:40', '2024-02-13 07:53:40'),
(128, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:42', '2024-02-13 07:53:42'),
(129, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:43', '2024-02-13 07:53:43'),
(130, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:53:46', '2024-02-13 07:53:46'),
(131, 2, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:49', '2024-02-13 07:53:49'),
(132, 2, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:50', '2024-02-13 07:53:50'),
(133, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:53:52', '2024-02-13 07:53:52'),
(134, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:54:03', '2024-02-13 07:54:03'),
(135, 1, 'auth/users/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:54:08', '2024-02-13 07:54:08'),
(136, 1, 'auth/users/2', 'PUT', '127.0.0.1', '{\"username\":\"dev1\",\"name\":\"Priscilla\",\"password\":\"$2y$12$tcDaCZH\\/8f3G8y4dI77eS.TMmQQv4j3M2wjXGVeJNOeE.gpkWxL1W\",\"password_confirmation\":\"$2y$12$tcDaCZH\\/8f3G8y4dI77eS.TMmQQv4j3M2wjXGVeJNOeE.gpkWxL1W\",\"roles\":[\"4\",null],\"permissions\":[\"1\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-02-13 07:54:23', '2024-02-13 07:54:23'),
(137, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-02-13 07:54:24', '2024-02-13 07:54:24'),
(138, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:55:28', '2024-02-13 07:55:28'),
(139, 1, 'auth/menu/10/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:55:31', '2024-02-13 07:55:31'),
(140, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:55:37', '2024-02-13 07:55:37'),
(141, 1, 'auth/menu/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:55:43', '2024-02-13 07:55:43'),
(142, 2, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:55:55', '2024-02-13 07:55:55'),
(143, 2, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:55:57', '2024-02-13 07:55:57'),
(144, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:55:58', '2024-02-13 07:55:58'),
(145, 2, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:56:05', '2024-02-13 07:56:05'),
(146, 2, '/', 'GET', '127.0.0.1', '[]', '2024-02-13 07:56:18', '2024-02-13 07:56:18'),
(147, 2, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:56:30', '2024-02-13 07:56:30'),
(148, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:56:32', '2024-02-13 07:56:32'),
(149, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:56:39', '2024-02-13 07:56:39'),
(150, 1, 'auth/roles/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:56:54', '2024-02-13 07:56:54'),
(151, 1, 'auth/roles/4', 'PUT', '127.0.0.1', '{\"slug\":\"caumm\",\"name\":\"CAUMM\",\"permissions\":[\"2\",\"3\",\"3\",\"4\",\"5\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:57:20', '2024-02-13 07:57:20'),
(152, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:57:21', '2024-02-13 07:57:21'),
(153, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:57:27', '2024-02-13 07:57:27'),
(154, 1, 'auth/roles/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:57:50', '2024-02-13 07:57:50'),
(155, 1, 'auth/roles/4', 'PUT', '127.0.0.1', '{\"slug\":\"caumm\",\"name\":\"CAUMM\",\"permissions\":[\"3\",\"4\",\"5\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:58:33', '2024-02-13 07:58:33'),
(156, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:58:33', '2024-02-13 07:58:33'),
(157, 2, '/', 'GET', '127.0.0.1', '[]', '2024-02-13 07:58:39', '2024-02-13 07:58:39'),
(158, 2, '/', 'GET', '127.0.0.1', '[]', '2024-02-13 07:58:42', '2024-02-13 07:58:42'),
(159, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:58:44', '2024-02-13 07:58:44'),
(160, 2, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:58:46', '2024-02-13 07:58:46'),
(161, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:58:47', '2024-02-13 07:58:47'),
(162, 1, 'auth/roles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 07:59:22', '2024-02-13 07:59:22'),
(163, 1, 'auth/roles/1', 'PUT', '127.0.0.1', '{\"slug\":\"administrator\",\"name\":\"Administrator\",\"permissions\":[\"4\",\"2\",\"3\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 07:59:44', '2024-02-13 07:59:44'),
(164, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 07:59:44', '2024-02-13 07:59:44'),
(165, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:00:17', '2024-02-13 08:00:17'),
(166, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:00:18', '2024-02-13 08:00:18'),
(167, 2, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:00:29', '2024-02-13 08:00:29'),
(168, 2, 'auth/roles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:00:37', '2024-02-13 08:00:37'),
(169, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:01:27', '2024-02-13 08:01:27'),
(170, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:01:28', '2024-02-13 08:01:28'),
(171, 2, 'auth/roles/1', 'PUT', '127.0.0.1', '{\"slug\":\"administrator\",\"name\":\"Administrator\",\"permissions\":[\"1\",\"2\",\"3\",\"4\",\"5\",null],\"_token\":\"th7vWQWj7i3z3Ib45DPqt8sRBtxZ4AEZJ4iP7zKx\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 08:01:36', '2024-02-13 08:01:36'),
(172, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:01:37', '2024-02-13 08:01:37'),
(173, 2, 'auth/roles/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:01:52', '2024-02-13 08:01:52'),
(174, 2, 'auth/roles/4', 'PUT', '127.0.0.1', '{\"slug\":\"caumm\",\"name\":\"CAUMM\",\"permissions\":[\"2\",\"3\",\"4\",null],\"_token\":\"th7vWQWj7i3z3Ib45DPqt8sRBtxZ4AEZJ4iP7zKx\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 08:02:03', '2024-02-13 08:02:03'),
(175, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:02:04', '2024-02-13 08:02:04'),
(176, 2, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:02:29', '2024-02-13 08:02:29'),
(177, 2, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-02-13 08:02:39', '2024-02-13 08:02:39'),
(178, 2, 'auth/users/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:02:46', '2024-02-13 08:02:46'),
(179, 2, 'auth/users/2', 'PUT', '127.0.0.1', '{\"username\":\"dev1\",\"name\":\"Priscilla\",\"password\":\"$2y$12$tcDaCZH\\/8f3G8y4dI77eS.TMmQQv4j3M2wjXGVeJNOeE.gpkWxL1W\",\"password_confirmation\":\"$2y$12$tcDaCZH\\/8f3G8y4dI77eS.TMmQQv4j3M2wjXGVeJNOeE.gpkWxL1W\",\"roles\":[\"4\",null],\"permissions\":[null],\"_token\":\"th7vWQWj7i3z3Ib45DPqt8sRBtxZ4AEZJ4iP7zKx\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-02-13 08:02:59', '2024-02-13 08:02:59'),
(180, 2, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-02-13 08:02:59', '2024-02-13 08:02:59'),
(181, 2, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:03:07', '2024-02-13 08:03:07'),
(182, 2, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:03:09', '2024-02-13 08:03:09'),
(183, 2, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:03:10', '2024-02-13 08:03:10'),
(184, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:03:24', '2024-02-13 08:03:24'),
(185, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:04:21', '2024-02-13 08:04:21'),
(186, 1, 'auth/menu/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:04:23', '2024-02-13 08:04:23'),
(187, 1, 'auth/menu/4', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Roles\",\"icon\":\"fa-user\",\"uri\":\"auth\\/roles\",\"roles\":[\"1\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:04:31', '2024-02-13 08:04:31'),
(188, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:04:31', '2024-02-13 08:04:31'),
(189, 1, 'auth/menu/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:04:50', '2024-02-13 08:04:50'),
(190, 1, 'auth/menu/6', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Menu\",\"icon\":\"fa-bars\",\"uri\":\"auth\\/menu\",\"roles\":[\"1\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:04:56', '2024-02-13 08:04:56'),
(191, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:04:56', '2024-02-13 08:04:56'),
(192, 1, 'auth/menu/7/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:05:03', '2024-02-13 08:05:03'),
(193, 1, 'auth/menu/7', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Operation log\",\"icon\":\"fa-history\",\"uri\":\"auth\\/logs\",\"roles\":[\"1\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:05:12', '2024-02-13 08:05:12'),
(194, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:05:12', '2024-02-13 08:05:12'),
(195, 1, 'auth/menu/7/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:05:26', '2024-02-13 08:05:26'),
(196, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:05:36', '2024-02-13 08:05:36'),
(197, 1, 'auth/menu/7/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:05:39', '2024-02-13 08:05:39'),
(198, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:05:52', '2024-02-13 08:05:52'),
(199, 1, 'auth/menu/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:05:55', '2024-02-13 08:05:55'),
(200, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:06:27', '2024-02-13 08:06:27'),
(201, 1, 'auth/menu/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:06:30', '2024-02-13 08:06:30'),
(202, 1, 'auth/menu/5', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"Permission\",\"icon\":\"fa-ban\",\"uri\":\"auth\\/permissions\",\"roles\":[\"1\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:06:38', '2024-02-13 08:06:38'),
(203, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:06:38', '2024-02-13 08:06:38'),
(204, 1, 'auth/menu/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:06:40', '2024-02-13 08:06:40'),
(205, 1, 'auth/menu/2', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"System settings\",\"icon\":\"fa-tasks\",\"uri\":null,\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:06:54', '2024-02-13 08:06:54'),
(206, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:06:54', '2024-02-13 08:06:54'),
(207, 2, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:07:06', '2024-02-13 08:07:06'),
(208, 1, 'auth/menu/10/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:07:21', '2024-02-13 08:07:21'),
(209, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:07:36', '2024-02-13 08:07:36'),
(210, 1, 'auth/menu/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:07:46', '2024-02-13 08:07:46'),
(211, 1, 'auth/menu/2/edit', 'GET', '127.0.0.1', '[]', '2024-02-13 08:07:55', '2024-02-13 08:07:55'),
(212, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:08:03', '2024-02-13 08:08:03'),
(213, 1, 'auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_order\":\"[{\\\"id\\\":1},{\\\"id\\\":8},{\\\"id\\\":9},{\\\"id\\\":10},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2024-02-13 08:08:11', '2024-02-13 08:08:11'),
(214, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:08:11', '2024-02-13 08:08:11'),
(215, 1, 'auth/menu/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:08:15', '2024-02-13 08:08:15'),
(216, 1, 'auth/menu/2', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Admin\",\"icon\":\"fa-tasks\",\"uri\":null,\"roles\":[\"4\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:08:24', '2024-02-13 08:08:24'),
(217, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:08:25', '2024-02-13 08:08:25'),
(218, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:08:37', '2024-02-13 08:08:37'),
(219, 2, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-02-13 08:08:42', '2024-02-13 08:08:42'),
(220, 1, 'auth/menu/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:08:49', '2024-02-13 08:08:49'),
(221, 1, 'auth/menu/2', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Admin\",\"icon\":\"fa-tasks\",\"uri\":null,\"roles\":[\"1\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:08:59', '2024-02-13 08:08:59'),
(222, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:08:59', '2024-02-13 08:08:59'),
(223, 2, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-02-13 08:09:05', '2024-02-13 08:09:05'),
(224, 2, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:09:13', '2024-02-13 08:09:13'),
(225, 1, 'auth/menu/10/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:09:17', '2024-02-13 08:09:17'),
(226, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:07', '2024-02-13 08:10:07'),
(227, 1, 'auth/menu/9/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:15', '2024-02-13 08:10:15'),
(228, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:21', '2024-02-13 08:10:21'),
(229, 1, 'auth/menu/10/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:25', '2024-02-13 08:10:25'),
(230, 1, 'auth/menu/10', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Leave Types\",\"icon\":\"fa-sticky-note\",\"uri\":\"leave-types\",\"roles\":[\"1\",\"4\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 08:10:33', '2024-02-13 08:10:33'),
(231, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 08:10:33', '2024-02-13 08:10:33'),
(232, 2, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-02-13 08:10:39', '2024-02-13 08:10:39'),
(233, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:43', '2024-02-13 08:10:43'),
(234, 2, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:45', '2024-02-13 08:10:45'),
(235, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:47', '2024-02-13 08:10:47'),
(236, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:50', '2024-02-13 08:10:50'),
(237, 2, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:51', '2024-02-13 08:10:51'),
(238, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:56', '2024-02-13 08:10:56'),
(239, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:10:58', '2024-02-13 08:10:58'),
(240, 1, 'auth/roles/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:11:06', '2024-02-13 08:11:06'),
(241, 1, 'auth/roles/4', 'PUT', '127.0.0.1', '{\"slug\":\"caumm\",\"name\":\"CAUMM\",\"permissions\":[\"1\",\"2\",\"3\",\"4\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 08:11:16', '2024-02-13 08:11:16'),
(242, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:11:16', '2024-02-13 08:11:16'),
(243, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:11:22', '2024-02-13 08:11:22'),
(244, 2, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-02-13 08:11:33', '2024-02-13 08:11:33'),
(245, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:11:44', '2024-02-13 08:11:44'),
(246, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:12:07', '2024-02-13 08:12:07'),
(247, 1, 'auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:12:26', '2024-02-13 08:12:26'),
(248, 1, 'auth/permissions', 'POST', '127.0.0.1', '{\"slug\":\"staff\",\"name\":\"Staff management\",\"http_method\":[null],\"http_path\":\"http:\\/\\/127.0.0.1:8000\\/staff\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/permissions\"}', '2024-02-13 08:13:22', '2024-02-13 08:13:22'),
(249, 1, 'auth/permissions', 'GET', '127.0.0.1', '[]', '2024-02-13 08:13:22', '2024-02-13 08:13:22'),
(250, 1, 'auth/permissions/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:13:32', '2024-02-13 08:13:32'),
(251, 1, 'auth/permissions/6', 'PUT', '127.0.0.1', '{\"slug\":\"staff\",\"name\":\"Staff management\",\"http_method\":[null],\"http_path\":\"\\/staff\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/permissions\"}', '2024-02-13 08:13:40', '2024-02-13 08:13:40'),
(252, 1, 'auth/permissions', 'GET', '127.0.0.1', '[]', '2024-02-13 08:13:40', '2024-02-13 08:13:40'),
(253, 1, 'auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:13:46', '2024-02-13 08:13:46'),
(254, 1, 'auth/permissions', 'POST', '127.0.0.1', '{\"slug\":\"leave\",\"name\":\"Leave Requests\",\"http_method\":[null],\"http_path\":\"\\/leave-datas\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/permissions\"}', '2024-02-13 08:14:12', '2024-02-13 08:14:12'),
(255, 1, 'auth/permissions', 'GET', '127.0.0.1', '[]', '2024-02-13 08:14:12', '2024-02-13 08:14:12'),
(256, 1, 'auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:14:19', '2024-02-13 08:14:19'),
(257, 1, 'auth/permissions', 'POST', '127.0.0.1', '{\"slug\":\"leave_types\",\"name\":\"Leave Types\",\"http_method\":[null],\"http_path\":\"\\/leave-types\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/permissions\"}', '2024-02-13 08:14:44', '2024-02-13 08:14:44'),
(258, 1, 'auth/permissions', 'GET', '127.0.0.1', '[]', '2024-02-13 08:14:44', '2024-02-13 08:14:44'),
(259, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:14:51', '2024-02-13 08:14:51'),
(260, 1, 'auth/roles/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:14:57', '2024-02-13 08:14:57'),
(261, 1, 'auth/roles/4', 'PUT', '127.0.0.1', '{\"slug\":\"caumm\",\"name\":\"CAUMM\",\"permissions\":[\"2\",\"3\",\"4\",\"6\",\"7\",\"8\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 08:17:15', '2024-02-13 08:17:15'),
(262, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:17:15', '2024-02-13 08:17:15'),
(263, 2, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:17:22', '2024-02-13 08:17:22'),
(264, 2, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:17:24', '2024-02-13 08:17:24'),
(265, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:17:25', '2024-02-13 08:17:25'),
(266, 2, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:17:27', '2024-02-13 08:17:27'),
(267, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:17:28', '2024-02-13 08:17:28'),
(268, 1, 'auth/roles/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:17:35', '2024-02-13 08:17:35'),
(269, 1, 'auth/roles/3', 'PUT', '127.0.0.1', '{\"slug\":\"staff\",\"name\":\"Staff\",\"permissions\":[\"2\",\"3\",\"4\",\"7\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 08:18:10', '2024-02-13 08:18:10'),
(270, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:18:11', '2024-02-13 08:18:11'),
(271, 1, 'auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:18:15', '2024-02-13 08:18:15'),
(272, 1, 'auth/roles/2', 'PUT', '127.0.0.1', '{\"slug\":\"supervisor\",\"name\":\"Supervisor\",\"permissions\":[\"2\",\"3\",\"4\",\"7\",null],\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-02-13 08:18:48', '2024-02-13 08:18:48'),
(273, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:18:48', '2024-02-13 08:18:48'),
(274, 2, '/', 'GET', '127.0.0.1', '[]', '2024-02-13 08:18:55', '2024-02-13 08:18:55'),
(275, 2, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:19:28', '2024-02-13 08:19:28'),
(276, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-13 08:41:02', '2024-02-13 08:41:02'),
(277, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:05', '2024-02-13 08:41:05'),
(278, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:07', '2024-02-13 08:41:07'),
(279, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Perspiciatis ut vel\",\"firstname\":\"Sebastian\",\"lastname\":\"Hubbard\",\"dob\":\"Qui ut qui est quide\",\"email\":\"sixycybaj@mailinator.com\",\"phone_number\":\"+1 (742) 815-6702\",\"contract_start_date\":\"06-Oct-1991\",\"contract_end_date\":\"16-Aug-1993\",\"appraisal_date\":\"28-Apr-1990\",\"next_of_kin_name\":\"Celeste Howell\",\"next_of_kin_relationship\":\"Obcaecati temporibus\",\"next_of_kin_contact\":\"Quia qui delectus o\",\"home_district\":\"Eu quas ut labore an\",\"nssf_number\":\"353\",\"tin_number\":\"359\",\"job_title\":\"Velit molestiae volu\",\"duty_station\":\"Minima rerum repudia\",\"employee_status\":\"Nostrum ad do non cu\",\"profile_picture\":\"Sint consequat Ist\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-02-13 08:41:14', '2024-02-13 08:41:14'),
(280, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 08:41:14', '2024-02-13 08:41:14'),
(281, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:36', '2024-02-13 08:41:36'),
(282, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:39', '2024-02-13 08:41:39'),
(283, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Sed id eos quia ill\",\"firstname\":\"Amena\",\"lastname\":\"Bailey\",\"dob\":\"Magni dolorem eum ut\",\"email\":\"buvytozym@mailinator.com\",\"phone_number\":\"+1 (833) 341-9649\",\"contract_start_date\":\"27-Sep-1972\",\"contract_end_date\":\"15-Mar-1980\",\"appraisal_date\":\"04-May-2011\",\"next_of_kin_name\":\"Wallace Hahn\",\"next_of_kin_relationship\":\"Vero necessitatibus\",\"next_of_kin_contact\":\"Eveniet qui incidun\",\"home_district\":\"Aut sapiente enim se\",\"nssf_number\":\"914\",\"tin_number\":\"960\",\"job_title\":\"Sint deleniti tempo\",\"duty_station\":\"Est sint esse nostru\",\"employee_status\":\"Pariatur Ipsa ut c\",\"profile_picture\":\"Quisquam officia cor\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-02-13 08:41:43', '2024-02-13 08:41:43'),
(284, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 08:41:43', '2024-02-13 08:41:43'),
(285, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:46', '2024-02-13 08:41:46'),
(286, 1, 'staff/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:49', '2024-02-13 08:41:49'),
(287, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:53', '2024-02-13 08:41:53'),
(288, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:41:57', '2024-02-13 08:41:57'),
(289, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 08:43:08', '2024-02-13 08:43:08'),
(290, 1, 'staff/employee_picture.jpg', 'GET', '127.0.0.1', '[]', '2024-02-13 08:43:08', '2024-02-13 08:43:08'),
(291, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 08:43:50', '2024-02-13 08:43:50'),
(292, 1, 'staff/employee_picture.jpg', 'GET', '127.0.0.1', '[]', '2024-02-13 08:43:50', '2024-02-13 08:43:50'),
(293, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 08:44:27', '2024-02-13 08:44:27'),
(294, 1, 'staff/employee_picture.jpg', 'GET', '127.0.0.1', '[]', '2024-02-13 08:44:28', '2024-02-13 08:44:28'),
(295, 1, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:44:40', '2024-02-13 08:44:40'),
(296, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:44:41', '2024-02-13 08:44:41'),
(297, 1, 'staff/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:44:45', '2024-02-13 08:44:45'),
(298, 1, 'staff/employee_picture.jpg', 'GET', '127.0.0.1', '[]', '2024-02-13 08:44:46', '2024-02-13 08:44:46'),
(299, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 08:45:00', '2024-02-13 08:45:00'),
(300, 1, 'staff/employee_picture.jpg', 'GET', '127.0.0.1', '[]', '2024-02-13 08:45:01', '2024-02-13 08:45:01'),
(301, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 08:46:19', '2024-02-13 08:46:19'),
(302, 1, 'staff/employee_picture.jpg', 'GET', '127.0.0.1', '[]', '2024-02-13 08:46:20', '2024-02-13 08:46:20'),
(303, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 08:53:48', '2024-02-13 08:53:48'),
(304, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 08:54:12', '2024-02-13 08:54:12'),
(305, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 08:55:11', '2024-02-13 08:55:11'),
(306, 1, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:56:02', '2024-02-13 08:56:02'),
(307, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:56:04', '2024-02-13 08:56:04'),
(308, 1, 'staff/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:56:10', '2024-02-13 08:56:10'),
(309, 1, 'staff/2', 'PUT', '127.0.0.1', '{\"staff_id\":\"Sed id eos quia ill\",\"firstname\":\"Amena\",\"lastname\":\"Bailey\",\"dob\":\"Magni dolorem eum ut\",\"email\":\"buvytozym@mailinator.com\",\"phone_number\":\"+1 (833) 341-9649\",\"contract_start_date\":\"27-Sep-1972\",\"contract_end_date\":\"15-Mar-1980\",\"appraisal_date\":\"04-May-2011\",\"next_of_kin_name\":\"Wallace Hahn\",\"next_of_kin_relationship\":\"Vero necessitatibus\",\"next_of_kin_contact\":\"Eveniet qui incidun\",\"home_district\":\"Aut sapiente enim se\",\"nssf_number\":\"914\",\"tin_number\":\"960\",\"job_title\":\"Sint deleniti tempo\",\"duty_station\":\"Est sint esse nostru\",\"employee_status\":\"Pariatur Ipsa ut c\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-02-13 08:56:30', '2024-02-13 08:56:30'),
(310, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 08:56:30', '2024-02-13 08:56:30'),
(311, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 08:56:36', '2024-02-13 08:56:36'),
(312, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 08:57:01', '2024-02-13 08:57:01'),
(313, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 08:57:33', '2024-02-13 08:57:33'),
(314, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 08:59:44', '2024-02-13 08:59:44'),
(315, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:00:02', '2024-02-13 09:00:02'),
(316, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:00:19', '2024-02-13 09:00:19'),
(317, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:00:34', '2024-02-13 09:00:34'),
(318, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:03:36', '2024-02-13 09:03:36'),
(319, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:05:46', '2024-02-13 09:05:46'),
(320, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:06:33', '2024-02-13 09:06:33'),
(321, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:07:33', '2024-02-13 09:07:33'),
(322, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:07:58', '2024-02-13 09:07:58'),
(323, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:08:23', '2024-02-13 09:08:23'),
(324, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:08:29', '2024-02-13 09:08:29');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(325, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:08:38', '2024-02-13 09:08:38'),
(326, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:08:45', '2024-02-13 09:08:45'),
(327, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:08:51', '2024-02-13 09:08:51'),
(328, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:09:07', '2024-02-13 09:09:07'),
(329, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:09:21', '2024-02-13 09:09:21'),
(330, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:09:31', '2024-02-13 09:09:31'),
(331, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:09:58', '2024-02-13 09:09:58'),
(332, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:10:27', '2024-02-13 09:10:27'),
(333, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:11:21', '2024-02-13 09:11:21'),
(334, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:13:06', '2024-02-13 09:13:06'),
(335, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:13:42', '2024-02-13 09:13:42'),
(336, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:13:46', '2024-02-13 09:13:46'),
(337, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:14:29', '2024-02-13 09:14:29'),
(338, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:14:48', '2024-02-13 09:14:48'),
(339, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:15:15', '2024-02-13 09:15:15'),
(340, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:15:17', '2024-02-13 09:15:17'),
(341, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:15:36', '2024-02-13 09:15:36'),
(342, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:16:00', '2024-02-13 09:16:00'),
(343, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:17:01', '2024-02-13 09:17:01'),
(344, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:17:40', '2024-02-13 09:17:40'),
(345, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:18:34', '2024-02-13 09:18:34'),
(346, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:19:09', '2024-02-13 09:19:09'),
(347, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:20:13', '2024-02-13 09:20:13'),
(348, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:20:22', '2024-02-13 09:20:22'),
(349, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:22:50', '2024-02-13 09:22:50'),
(350, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:22:59', '2024-02-13 09:22:59'),
(351, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:23:10', '2024-02-13 09:23:10'),
(352, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:24:23', '2024-02-13 09:24:23'),
(353, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:24:40', '2024-02-13 09:24:40'),
(354, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:26:36', '2024-02-13 09:26:36'),
(355, 1, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:27:14', '2024-02-13 09:27:14'),
(356, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:27:16', '2024-02-13 09:27:16'),
(357, 1, 'staff/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:27:22', '2024-02-13 09:27:22'),
(358, 1, 'staff/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:27:25', '2024-02-13 09:27:25'),
(359, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 09:28:27', '2024-02-13 09:28:27'),
(360, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 09:28:45', '2024-02-13 09:28:45'),
(361, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 09:28:58', '2024-02-13 09:28:58'),
(362, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 09:32:20', '2024-02-13 09:32:20'),
(363, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:32:37', '2024-02-13 09:32:37'),
(364, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:32:41', '2024-02-13 09:32:41'),
(365, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:34:52', '2024-02-13 09:34:52'),
(366, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:34:58', '2024-02-13 09:34:58'),
(367, 1, 'staff/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:35:02', '2024-02-13 09:35:02'),
(368, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:35:07', '2024-02-13 09:35:07'),
(369, 1, 'staff/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:35:11', '2024-02-13 09:35:11'),
(370, 1, 'staff/1', 'GET', '127.0.0.1', '[]', '2024-02-13 09:35:58', '2024-02-13 09:35:58'),
(371, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:36:23', '2024-02-13 09:36:23'),
(372, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:36:29', '2024-02-13 09:36:29'),
(373, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Omnis autem magnam m\",\"firstname\":\"Demetria\",\"lastname\":\"Berger\",\"dob\":\"Quisquam repellendus\",\"email\":\"wyvatopaz@mailinator.com\",\"phone_number\":\"+1 (609) 651-9501\",\"contract_start_date\":\"18-May-2014\",\"contract_end_date\":\"24-Oct-1997\",\"appraisal_date\":\"06-Nov-2004\",\"next_of_kin_name\":\"Brody Vasquez\",\"next_of_kin_relationship\":\"Ipsum est sint sed\",\"next_of_kin_contact\":\"Minus eos velit dese\",\"home_district\":\"Architecto et ipsam\",\"nssf_number\":\"163\",\"tin_number\":\"413\",\"job_title\":\"Quidem illum nulla\",\"duty_station\":\"Facilis veniam ut l\",\"employee_status\":\"Tempore culpa odio\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-02-13 09:36:38', '2024-02-13 09:36:38'),
(374, 1, 'staff/3', 'GET', '127.0.0.1', '[]', '2024-02-13 09:36:38', '2024-02-13 09:36:38'),
(375, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:37:20', '2024-02-13 09:37:20'),
(376, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 09:39:43', '2024-02-13 09:39:43'),
(377, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:39:49', '2024-02-13 09:39:49'),
(378, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:39:57', '2024-02-13 09:39:57'),
(379, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 09:40:22', '2024-02-13 09:40:22'),
(380, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:40:25', '2024-02-13 09:40:25'),
(381, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:40:57', '2024-02-13 09:40:57'),
(382, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:42:28', '2024-02-13 09:42:28'),
(383, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:42:32', '2024-02-13 09:42:32'),
(384, 1, 'staff/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:42:35', '2024-02-13 09:42:35'),
(385, 1, 'staff/3', 'GET', '127.0.0.1', '[]', '2024-02-13 09:42:54', '2024-02-13 09:42:54'),
(386, 1, 'staff/3', 'GET', '127.0.0.1', '[]', '2024-02-13 09:43:48', '2024-02-13 09:43:48'),
(387, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:43:52', '2024-02-13 09:43:52'),
(388, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:44:03', '2024-02-13 09:44:03'),
(389, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:44:06', '2024-02-13 09:44:06'),
(390, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:44:09', '2024-02-13 09:44:09'),
(391, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:45:12', '2024-02-13 09:45:12'),
(392, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-02-13 09:45:38', '2024-02-13 09:45:38'),
(393, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:45:55', '2024-02-13 09:45:55'),
(394, 1, 'staff/1', 'DELETE', '127.0.0.1', '{\"_method\":\"delete\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\"}', '2024-02-13 09:46:44', '2024-02-13 09:46:44'),
(395, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:46:44', '2024-02-13 09:46:44'),
(396, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 09:47:50', '2024-02-13 09:47:50'),
(397, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 09:48:15', '2024-02-13 09:48:15'),
(398, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"page:1\"}', '2024-02-13 09:48:59', '2024-02-13 09:48:59'),
(399, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 09:49:47', '2024-02-13 09:49:47'),
(400, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 09:51:29', '2024-02-13 09:51:29'),
(401, 1, 'staff/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 09:51:39', '2024-02-13 09:51:39'),
(402, 1, 'staff/2/edit', 'GET', '127.0.0.1', '[]', '2024-02-13 10:03:01', '2024-02-13 10:03:01'),
(403, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:03:05', '2024-02-13 10:03:05'),
(404, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:03:07', '2024-02-13 10:03:07'),
(405, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Neque in ad velit at\",\"firstname\":\"Kylee\",\"lastname\":\"Barnett\",\"dob\":\"Minus deserunt qui e\",\"email\":\"hopegyhule@mailinator.com\",\"phone_number\":\"+1 (195) 272-2063\",\"contract_start_date\":\"01-Aug-2012\",\"contract_end_date\":\"01-Oct-1973\",\"appraisal_date\":\"23-Feb-2011\",\"next_of_kin_name\":\"Jael Booker\",\"next_of_kin_relationship\":\"Laudantium soluta m\",\"next_of_kin_contact\":\"Est aliquip et in s\",\"home_district\":\"Sint rerum ex deleni\",\"nssf_number\":\"240\",\"tin_number\":\"654\",\"job_title\":\"Facere ullam sed nat\",\"duty_station\":\"Aliquid eos nulla el\",\"employee_status\":\"Veritatis porro dolo\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"after-save\":\"2\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-02-13 10:03:14', '2024-02-13 10:03:14'),
(406, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-02-13 10:03:15', '2024-02-13 10:03:15'),
(407, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Neque in ad velit at\",\"firstname\":\"Kylee\",\"lastname\":\"Barnett\",\"dob\":\"Minus deserunt qui e\",\"email\":\"hopegyhule@mailinator.com\",\"phone_number\":\"+1 (195) 272-2063\",\"contract_start_date\":\"01-Aug-2012\",\"contract_end_date\":\"01-Oct-1973\",\"appraisal_date\":\"23-Feb-2011\",\"next_of_kin_name\":\"Jael Booker\",\"next_of_kin_relationship\":\"Laudantium soluta m\",\"next_of_kin_contact\":\"Est aliquip et in s\",\"home_district\":\"Sint rerum ex deleni\",\"nssf_number\":\"240\",\"tin_number\":\"654\",\"job_title\":\"Facere ullam sed nat\",\"duty_station\":\"Aliquid eos nulla el\",\"employee_status\":\"Veritatis porro dolo\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\"}', '2024-02-13 10:04:36', '2024-02-13 10:04:36'),
(408, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-02-13 10:04:37', '2024-02-13 10:04:37'),
(409, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-02-13 10:07:19', '2024-02-13 10:07:19'),
(410, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"firstname\":\"Astra\",\"lastname\":\"Calhoun\",\"dob\":\"Omnis voluptas corru\",\"email\":\"pisase@mailinator.com\",\"phone_number\":\"+1 (918) 775-7655\",\"contract_start_date\":\"04-Nov-1997\",\"contract_end_date\":\"18-Apr-1984\",\"appraisal_date\":\"23-May-1980\",\"next_of_kin_name\":\"Xyla Hess\",\"next_of_kin_relationship\":\"Reprehenderit qui fu\",\"next_of_kin_contact\":\"Commodi sit quas fug\",\"home_district\":\"Dolor aut veniam qu\",\"nssf_number\":\"829\",\"tin_number\":\"871\",\"job_title\":\"Quia libero autem qu\",\"duty_station\":\"Ea irure proident c\",\"employee_status\":\"Porro velit ipsum qu\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"after-save\":\"3\"}', '2024-02-13 10:07:26', '2024-02-13 10:07:26'),
(411, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-02-13 10:07:27', '2024-02-13 10:07:27'),
(412, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"firstname\":\"Astra\",\"lastname\":\"Calhoun\",\"dob\":\"Omnis voluptas corru\",\"email\":\"pisase@mailinator.com\",\"phone_number\":\"+1 (918) 775-7655\",\"contract_start_date\":\"04-Nov-1997\",\"contract_end_date\":\"18-Apr-1984\",\"appraisal_date\":\"23-May-1980\",\"next_of_kin_name\":\"Xyla Hess\",\"next_of_kin_relationship\":\"Reprehenderit qui fu\",\"next_of_kin_contact\":\"Commodi sit quas fug\",\"home_district\":\"Dolor aut veniam qu\",\"nssf_number\":\"829\",\"tin_number\":\"871\",\"job_title\":\"Quia libero autem qu\",\"duty_station\":\"Ea irure proident c\",\"employee_status\":\"Porro velit ipsum qu\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\"}', '2024-02-13 10:08:30', '2024-02-13 10:08:30'),
(413, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-02-13 10:08:30', '2024-02-13 10:08:30'),
(414, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"firstname\":\"Astra\",\"lastname\":\"Calhoun\",\"dob\":\"Omnis voluptas corru\",\"email\":\"pisase@mailinator.com\",\"phone_number\":\"+1 (918) 775-7655\",\"contract_start_date\":\"04-Nov-1997\",\"contract_end_date\":\"18-Apr-1984\",\"appraisal_date\":\"23-May-1980\",\"next_of_kin_name\":\"Xyla Hess\",\"next_of_kin_relationship\":\"Reprehenderit qui fu\",\"next_of_kin_contact\":\"Commodi sit quas fug\",\"home_district\":\"Dolor aut veniam qu\",\"nssf_number\":\"829\",\"tin_number\":\"871\",\"job_title\":\"Quia libero autem qu\",\"duty_station\":\"Ea irure proident c\",\"employee_status\":\"Porro velit ipsum qu\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\"}', '2024-02-13 10:12:14', '2024-02-13 10:12:14'),
(415, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 10:12:14', '2024-02-13 10:12:14'),
(416, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:12:33', '2024-02-13 10:12:33'),
(417, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:12:37', '2024-02-13 10:12:37'),
(418, 1, 'staff/6', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:12:41', '2024-02-13 10:12:41'),
(419, 1, 'staff/6', 'GET', '127.0.0.1', '[]', '2024-02-13 10:13:22', '2024-02-13 10:13:22'),
(420, 5, '/', 'GET', '127.0.0.1', '[]', '2024-02-13 10:13:43', '2024-02-13 10:13:43'),
(421, 5, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:14:15', '2024-02-13 10:14:15'),
(422, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:14:20', '2024-02-13 10:14:20'),
(423, 1, 'auth/menu/8/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:14:24', '2024-02-13 10:14:24'),
(424, 1, 'auth/menu/8', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Staff Management\",\"icon\":\"fa-users\",\"uri\":\"staff\",\"roles\":[\"1\",\"4\",null],\"permission\":null,\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-02-13 10:14:37', '2024-02-13 10:14:37'),
(425, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-02-13 10:14:37', '2024-02-13 10:14:37'),
(426, 5, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 10:14:41', '2024-02-13 10:14:41'),
(427, 5, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:14:44', '2024-02-13 10:14:44'),
(428, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:14:46', '2024-02-13 10:14:46'),
(429, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:14:48', '2024-02-13 10:14:48'),
(430, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:40:34', '2024-02-13 10:40:34'),
(431, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:44:00', '2024-02-13 10:44:00'),
(432, 1, 'auth/permissions/7/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:44:11', '2024-02-13 10:44:11'),
(433, 1, 'auth/permissions/7', 'PUT', '127.0.0.1', '{\"slug\":\"leave\",\"name\":\"Leave Requests\",\"http_method\":[null],\"http_path\":\"\\/leave-datas*\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/permissions\"}', '2024-02-13 10:44:20', '2024-02-13 10:44:20'),
(434, 1, 'auth/permissions', 'GET', '127.0.0.1', '[]', '2024-02-13 10:44:21', '2024-02-13 10:44:21'),
(435, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-13 10:44:28', '2024-02-13 10:44:28'),
(436, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:44:30', '2024-02-13 10:44:30'),
(437, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:44:32', '2024-02-13 10:44:32'),
(438, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:45:00', '2024-02-13 10:45:00'),
(439, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 10:45:41', '2024-02-13 10:45:41'),
(440, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 10:46:49', '2024-02-13 10:46:49'),
(441, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-13 10:49:13', '2024-02-13 10:49:13'),
(442, 1, 'staff', 'GET', '127.0.0.1', '{\"id\":null,\"staff_id\":\"Sed id eos quia ill\",\"firstname\":null,\"job_title\":null,\"duty_station\":null,\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:49:21', '2024-02-13 10:49:21'),
(443, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"id\":null,\"staff_id\":\"Sed id eos quia ill\",\"firstname\":\"Demetria\",\"job_title\":\"Quia libero autem qu\",\"duty_station\":null}', '2024-02-13 10:49:28', '2024-02-13 10:49:28'),
(444, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:49:44', '2024-02-13 10:49:44'),
(445, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:51:56', '2024-02-13 10:51:56'),
(446, 1, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:51:58', '2024-02-13 10:51:58'),
(447, 1, 'leave-types', 'POST', '127.0.0.1', '{\"leave_type_name\":\"Pregnancy\",\"description\":\"Atque non esse possi\",\"no_of_leave_days\":\"60\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-02-13 10:52:16', '2024-02-13 10:52:16'),
(448, 1, 'leave-types/1', 'GET', '127.0.0.1', '[]', '2024-02-13 10:52:16', '2024-02-13 10:52:16'),
(449, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:52:19', '2024-02-13 10:52:19'),
(450, 1, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:52:21', '2024-02-13 10:52:21'),
(451, 1, 'leave-types', 'POST', '127.0.0.1', '{\"leave_type_name\":\"General\",\"description\":\"Doloremque aliquam t\",\"no_of_leave_days\":\"30\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-02-13 10:52:35', '2024-02-13 10:52:35'),
(452, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-02-13 10:52:35', '2024-02-13 10:52:35'),
(453, 1, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 10:52:38', '2024-02-13 10:52:38'),
(454, 1, 'leave-types', 'POST', '127.0.0.1', '{\"leave_type_name\":\"Vibes\",\"description\":\"In eos minus odio as\",\"no_of_leave_days\":\"20\",\"_token\":\"JnSgNHZI9PgQ2B8tDcGxCNRohbhsCCLdAolOckqR\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-02-13 10:52:52', '2024-02-13 10:52:52'),
(455, 1, 'leave-types/3', 'GET', '127.0.0.1', '[]', '2024-02-13 10:52:53', '2024-02-13 10:52:53'),
(456, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:09:06', '2024-02-13 11:09:06'),
(457, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:09:34', '2024-02-13 11:09:34'),
(458, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:15:46', '2024-02-13 11:15:46'),
(459, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:15:49', '2024-02-13 11:15:49'),
(460, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:16:23', '2024-02-13 11:16:23'),
(461, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:16:40', '2024-02-13 11:16:40'),
(462, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:19:03', '2024-02-13 11:19:03'),
(463, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:24:54', '2024-02-13 11:24:54'),
(464, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:26:10', '2024-02-13 11:26:10'),
(465, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:26:47', '2024-02-13 11:26:47'),
(466, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Cupiditate error cum\",\"no_of_leave_days_requested\":\"50\",\"date_of_absence_from\":\"2024-02-13\",\"i_delegated_my_duties_to\":\"1\",\"signature_of_delegated\":\"Voluptatibus et et h\",\"employee_signature\":\"Quisquam adipisicing\",\"date_of_leave\":\"2024-02-13\",\"date_of_request\":\"2024-02-13 14:26:47\",\"approval_status\":\"Omnis id minim anim\",\"approved_by\":\"1\",\"_token\":\"A7VBJIqVduWH8x84804xmdXeUanKuHuh8KjyJE2Q\",\"after-save\":\"2\"}', '2024-02-13 11:45:52', '2024-02-13 11:45:52'),
(467, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:45:52', '2024-02-13 11:45:52'),
(468, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Cupiditate error cum\",\"no_of_leave_days_requested\":\"50\",\"date_of_absence_from\":\"2024-02-13\",\"i_delegated_my_duties_to\":\"1\",\"signature_of_delegated\":\"Voluptatibus et et h\",\"employee_signature\":\"Quisquam adipisicing\",\"date_of_leave\":\"2024-02-13\",\"date_of_request\":\"2024-02-13 14:26:47\",\"approval_status\":\"Omnis id minim anim\",\"approved_by\":\"1\",\"_token\":\"A7VBJIqVduWH8x84804xmdXeUanKuHuh8KjyJE2Q\"}', '2024-02-13 11:45:59', '2024-02-13 11:45:59'),
(469, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-13 11:45:59', '2024-02-13 11:45:59'),
(470, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 11:46:05', '2024-02-13 11:46:05'),
(471, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-13 11:48:48', '2024-02-13 11:48:48'),
(472, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 04:56:54', '2024-02-14 04:56:54'),
(473, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 06:51:55', '2024-02-14 06:51:55'),
(474, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 06:55:50', '2024-02-14 06:55:50'),
(475, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 06:56:41', '2024-02-14 06:56:41'),
(476, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Rerum exercitation t\",\"no_of_leave_days_requested\":\"21\",\"date_of_absence_from\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"1\",\"signature_of_delegated\":\"Ex in reprehenderit\",\"employee_signature\":\"Aut ut odio et nihil\",\"date_of_leave\":\"2024-02-14\",\"date_of_request\":\"2024-02-14 09:56:41\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\",\"after-save\":\"1\"}', '2024-02-14 06:56:51', '2024-02-14 06:56:51'),
(477, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 06:56:56', '2024-02-14 06:56:56'),
(478, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Rerum exercitation t\",\"no_of_leave_days_requested\":\"50\",\"date_of_absence_from\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"1\",\"signature_of_delegated\":\"Ex in reprehenderit\",\"employee_signature\":\"Aut ut odio et nihil\",\"date_of_leave\":\"2024-02-14\",\"date_of_request\":\"2024-02-14 09:56:41\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\"}', '2024-02-14 07:05:26', '2024-02-14 07:05:26'),
(479, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 07:05:26', '2024-02-14 07:05:26'),
(480, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Rerum exercitation t\",\"no_of_leave_days_requested\":\"21\",\"date_of_absence_from\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"1\",\"signature_of_delegated\":\"Ex in reprehenderit\",\"employee_signature\":\"Aut ut odio et nihil\",\"date_of_leave\":\"2024-02-14\",\"date_of_request\":\"2024-02-14 09:56:41\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\"}', '2024-02-14 07:05:39', '2024-02-14 07:05:39'),
(481, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 07:05:39', '2024-02-14 07:05:39'),
(482, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 07:13:56', '2024-02-14 07:13:56'),
(483, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"2\",\"description\":\"Debitis quos ut sunt\",\"no_of_leave_days_requested\":\"50\",\"date_of_absence_from\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"1\",\"signature_of_delegated\":\"Suscipit ut deleniti\",\"employee_signature\":\"Voluptatem vel et es\",\"date_of_leave\":\"2024-02-14\",\"date_of_request\":\"2024-02-14 10:13:56\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\",\"after-save\":\"1\"}', '2024-02-14 07:14:08', '2024-02-14 07:14:08'),
(484, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 07:14:08', '2024-02-14 07:14:08'),
(485, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 07:56:40', '2024-02-14 07:56:40'),
(486, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"2\",\"description\":\"Nobis voluptatem deb\",\"no_of_leave_days_requested\":\"60\",\"date_of_absence_from\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Aut occaecat reprehe\",\"employee_signature\":\"Vero aliqua Id ulla\",\"date_of_leave\":\"2024-02-14\",\"date_of_request\":\"2024-02-14 10:56:40\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\",\"after-save\":\"3\"}', '2024-02-14 07:57:43', '2024-02-14 07:57:43'),
(487, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 07:57:44', '2024-02-14 07:57:44'),
(488, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"At obcaecati laborum\",\"no_of_leave_days_requested\":\"28\",\"date_of_absence_from\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Nulla reiciendis ut\",\"employee_signature\":\"Amet error voluptat\",\"date_of_leave\":\"2024-02-14\",\"date_of_request\":\"2024-02-14 10:56:40\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\",\"after-save\":\"2\"}', '2024-02-14 07:57:57', '2024-02-14 07:57:57'),
(489, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 07:57:57', '2024-02-14 07:57:57'),
(490, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"At obcaecati laborum\",\"no_of_leave_days_requested\":\"28\",\"date_of_absence_from\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Nulla reiciendis ut\",\"employee_signature\":\"Amet error voluptat\",\"date_of_leave\":\"2024-02-14\",\"date_of_request\":\"2024-02-14 10:56:40\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\"}', '2024-02-14 08:05:39', '2024-02-14 08:05:39'),
(491, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:05:39', '2024-02-14 08:05:39'),
(492, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:06:20', '2024-02-14 08:06:20'),
(493, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:06:41', '2024-02-14 08:06:41'),
(494, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:06:44', '2024-02-14 08:06:44'),
(495, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:12:23', '2024-02-14 08:12:23'),
(496, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:13:02', '2024-02-14 08:13:02'),
(497, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:14:07', '2024-02-14 08:14:07'),
(498, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:15:46', '2024-02-14 08:15:46'),
(499, 1, 'leave-types/3', 'GET', '127.0.0.1', '[]', '2024-02-14 08:22:01', '2024-02-14 08:22:01'),
(500, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 08:22:10', '2024-02-14 08:22:10'),
(501, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 08:24:25', '2024-02-14 08:24:25'),
(502, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 08:24:49', '2024-02-14 08:24:49'),
(503, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 08:24:54', '2024-02-14 08:24:54'),
(504, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 08:25:20', '2024-02-14 08:25:20'),
(505, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-02-14 09:11:10', '2024-02-14 09:11:10'),
(506, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 09:11:14', '2024-02-14 09:11:14'),
(507, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:12:00', '2024-02-14 09:12:00'),
(508, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:17:59', '2024-02-14 09:17:59'),
(509, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:18:08', '2024-02-14 09:18:08'),
(510, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:19:49', '2024-02-14 09:19:49'),
(511, 1, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"At obcaecati laborum\",\"no_of_leave_days_requested\":\"28\",\"date_of_absence_from\":\"2024-02-14\",\"date_of_leave\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Nulla reiciendis ut\",\"employee_signature\":\"Amet error voluptat\",\"date_of_request\":\"2024-02-14 10:56:40\",\"approval_status\":\"approved\",\"reason\":\"reason\",\"approved_by\":\"1\",\"user_id\":\"5\",\"_token\":\"wbuiqtsRY28fW4K4DhfySmSaQnQbqNvSKrf4tYEy\",\"_method\":\"PUT\"}', '2024-02-14 09:26:31', '2024-02-14 09:26:31'),
(512, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:26:31', '2024-02-14 09:26:31'),
(513, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:29:01', '2024-02-14 09:29:01'),
(514, 1, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"At obcaecati laborum\",\"no_of_leave_days_requested\":\"28\",\"date_of_absence_from\":\"2024-02-14\",\"date_of_leave\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Nulla reiciendis ut\",\"employee_signature\":\"Amet error voluptat\",\"date_of_request\":\"2024-02-14 10:56:40\",\"approval_status\":\"approved\",\"reason\":\"reas\",\"approved_by\":\"1\",\"user_id\":\"5\",\"_token\":\"wbuiqtsRY28fW4K4DhfySmSaQnQbqNvSKrf4tYEy\",\"_method\":\"PUT\"}', '2024-02-14 09:29:11', '2024-02-14 09:29:11'),
(515, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:29:12', '2024-02-14 09:29:12'),
(516, 1, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"At obcaecati laborum\",\"no_of_leave_days_requested\":\"28\",\"date_of_absence_from\":\"2024-02-14\",\"date_of_leave\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Nulla reiciendis ut\",\"employee_signature\":\"Amet error voluptat\",\"date_of_request\":\"2024-02-14 10:56:40\",\"approval_status\":\"approved\",\"reason\":\"reas\",\"approved_by\":\"1\",\"user_id\":\"5\",\"_token\":\"wbuiqtsRY28fW4K4DhfySmSaQnQbqNvSKrf4tYEy\",\"_method\":\"PUT\"}', '2024-02-14 09:31:30', '2024-02-14 09:31:30'),
(517, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:31:31', '2024-02-14 09:31:31'),
(518, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-02-14 09:31:51', '2024-02-14 09:31:51'),
(519, 1, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"At obcaecati laborum\",\"no_of_leave_days_requested\":\"28\",\"date_of_absence_from\":\"2024-02-14\",\"date_of_leave\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Nulla reiciendis ut\",\"employee_signature\":\"Amet error voluptat\",\"date_of_request\":\"2024-02-14 10:56:40\",\"approval_status\":\"approved\",\"reason\":\"approveddd\",\"approved_by\":\"1\",\"user_id\":\"5\",\"_token\":\"wbuiqtsRY28fW4K4DhfySmSaQnQbqNvSKrf4tYEy\",\"_method\":\"PUT\"}', '2024-02-14 09:40:45', '2024-02-14 09:40:45'),
(520, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:40:45', '2024-02-14 09:40:45'),
(521, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:41:23', '2024-02-14 09:41:23'),
(522, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:41:31', '2024-02-14 09:41:31'),
(523, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:41:34', '2024-02-14 09:41:34'),
(524, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 09:51:51', '2024-02-14 09:51:51'),
(525, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"Non eveniet sit qui\",\"no_of_leave_days_requested\":\"60\",\"date_of_absence_from\":\"2024-02-14\",\"date_of_leave\":\"2024-02-14\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Ad ut dolorem ut nes\",\"employee_signature\":\"Sapiente voluptate e\",\"date_of_request\":\"2024-02-14 12:51:51\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-02-14 09:52:51', '2024-02-14 09:52:51'),
(526, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 09:52:51', '2024-02-14 09:52:51'),
(527, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"Non eveniet sit qui\",\"no_of_leave_days_requested\":\"60\",\"date_of_absence_from\":\"2024-03-08\",\"date_of_leave\":\"2024-03-09\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Ad ut dolorem ut nes\",\"employee_signature\":\"Sapiente voluptate e\",\"date_of_request\":\"2024-02-14 12:51:51\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\"}', '2024-02-14 09:53:01', '2024-02-14 09:53:01'),
(528, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 09:53:01', '2024-02-14 09:53:01'),
(529, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"Non eveniet sit qui\",\"no_of_leave_days_requested\":\"60\",\"date_of_absence_from\":\"2024-03-08\",\"date_of_leave\":\"2024-03-09\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Ad ut dolorem ut nes\",\"employee_signature\":\"Sapiente voluptate e\",\"date_of_request\":\"2024-02-14 12:51:51\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\"}', '2024-02-14 09:54:07', '2024-02-14 09:54:07'),
(530, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-02-14 09:54:07', '2024-02-14 09:54:07'),
(531, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"Non eveniet sit qui\",\"no_of_leave_days_requested\":\"23\",\"date_of_absence_from\":\"2024-03-08\",\"date_of_leave\":\"2024-03-09\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Ad ut dolorem ut nes\",\"employee_signature\":\"Sapiente voluptate e\",\"date_of_request\":\"2024-02-14 12:51:51\",\"user_id\":\"5\",\"_token\":\"qYdpPuF7ITKckTQN127rl6d25rQqTMbTayvSDTFi\"}', '2024-02-14 09:54:28', '2024-02-14 09:54:28'),
(532, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:54:28', '2024-02-14 09:54:28'),
(533, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:54:43', '2024-02-14 09:54:43'),
(534, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 09:54:50', '2024-02-14 09:54:50'),
(535, 1, 'auth/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 09:54:54', '2024-02-14 09:54:54'),
(536, 1, 'auth/users', 'POST', '127.0.0.1', '{\"username\":\"sup\",\"name\":\"Debra Bean\",\"password\":\"admin\",\"password_confirmation\":\"admin\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"wbuiqtsRY28fW4K4DhfySmSaQnQbqNvSKrf4tYEy\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-02-14 09:55:24', '2024-02-14 09:55:24'),
(537, 1, 'auth/users/6', 'GET', '127.0.0.1', '[]', '2024-02-14 09:55:25', '2024-02-14 09:55:25'),
(538, 6, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 09:55:44', '2024-02-14 09:55:44'),
(539, 6, 'leave-datas/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 09:55:51', '2024-02-14 09:55:51'),
(540, 6, 'leave-datas/2', 'PUT', '127.0.0.1', '{\"staff_id\":\"Consequatur et autem\",\"type_of_leave_id\":\"1\",\"description\":\"Non eveniet sit qui\",\"no_of_leave_days_requested\":\"23\",\"date_of_absence_from\":\"2024-03-08\",\"date_of_leave\":\"2024-03-09\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":\"Ad ut dolorem ut nes\",\"employee_signature\":\"Sapiente voluptate e\",\"date_of_request\":\"2024-02-14 12:51:51\",\"approval_status\":\"approved\",\"reason\":\"dan\",\"approved_by\":\"6\",\"_token\":\"JwoErmVmOpqZvsPBgUILF6h0whNeIoPQVUc0IJLk\",\"_method\":\"PUT\"}', '2024-02-14 09:56:04', '2024-02-14 09:56:04'),
(541, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:56:04', '2024-02-14 09:56:04'),
(542, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:56:07', '2024-02-14 09:56:07'),
(543, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:56:12', '2024-02-14 09:56:12'),
(544, 1, 'auth/users/6', 'GET', '127.0.0.1', '[]', '2024-02-14 09:56:20', '2024-02-14 09:56:20'),
(545, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:58:09', '2024-02-14 09:58:09'),
(546, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-02-14 09:58:52', '2024-02-14 09:58:52'),
(547, 5, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 10:30:56', '2024-02-14 10:30:56'),
(548, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"iXi4hwehFvrMMFjZGzXyHnUZTkguPk7PAhFxXTAp\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-02-14 10:35:08', '2024-02-14 10:35:08'),
(549, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"5yHGAG3WSnyEAY2796mOzz1ocC7uR3f0CRzFmf6c\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-02-14 10:37:18', '2024-02-14 10:37:18'),
(550, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"LhFxQxCUcQVDtkYLc0gEEBWb18HV4uIclqvGqYIL\",\"username\":\"Cole\",\"password\":\"password\"}', '2024-02-14 10:42:59', '2024-02-14 10:42:59'),
(551, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"LhFxQxCUcQVDtkYLc0gEEBWb18HV4uIclqvGqYIL\",\"username\":\"Cole\",\"password\":null}', '2024-02-14 10:43:08', '2024-02-14 10:43:08'),
(552, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"LhFxQxCUcQVDtkYLc0gEEBWb18HV4uIclqvGqYIL\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-02-14 10:43:30', '2024-02-14 10:43:30'),
(553, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"vutn0sVlDQiwQcNPw15F3cIUwS6POWGMyzGtWUgr\",\"username\":\"Cephas\",\"password\":\"RfV4uiEoQi6=\"}', '2024-02-14 10:44:58', '2024-02-14 10:44:58'),
(554, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"vutn0sVlDQiwQcNPw15F3cIUwS6POWGMyzGtWUgr\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-02-14 10:45:17', '2024-02-14 10:45:17'),
(555, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"PUCC8MrbntVkxmLIesQbNBuOzLjEBzYyLD3ScGfC\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-02-14 10:50:05', '2024-02-14 10:50:05'),
(556, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"QgUN7tJ09YVKVmjCF0kgvlRHDjQVnF89SfUlCZXZ\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-02-14 10:51:20', '2024-02-14 10:51:20'),
(557, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 10:51:21', '2024-02-14 10:51:21'),
(558, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:10:47', '2024-02-14 11:10:47'),
(559, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:11:54', '2024-02-14 11:11:54'),
(560, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:12:20', '2024-02-14 11:12:20'),
(561, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:12:50', '2024-02-14 11:12:50'),
(562, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:13:38', '2024-02-14 11:13:38'),
(563, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:13:40', '2024-02-14 11:13:40'),
(564, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:14:11', '2024-02-14 11:14:11'),
(565, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:14:47', '2024-02-14 11:14:47'),
(566, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:16:50', '2024-02-14 11:16:50'),
(567, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:17:56', '2024-02-14 11:17:56'),
(568, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:18:07', '2024-02-14 11:18:07'),
(569, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:18:30', '2024-02-14 11:18:30'),
(570, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:19:03', '2024-02-14 11:19:03'),
(571, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:19:32', '2024-02-14 11:19:32'),
(572, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:19:59', '2024-02-14 11:19:59'),
(573, 1, 'auth/users/6', 'GET', '127.0.0.1', '[]', '2024-02-14 11:27:20', '2024-02-14 11:27:20'),
(574, 1, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:27:23', '2024-02-14 11:27:23'),
(575, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:28:14', '2024-02-14 11:28:14'),
(576, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:28:42', '2024-02-14 11:28:42'),
(577, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:31:25', '2024-02-14 11:31:25'),
(578, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:34:40', '2024-02-14 11:34:40'),
(579, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:42:27', '2024-02-14 11:42:27'),
(580, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:43:44', '2024-02-14 11:43:44'),
(581, 1, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:44:24', '2024-02-14 11:44:24'),
(582, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:53:25', '2024-02-14 11:53:25'),
(583, 1, 'auth/users/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:53:37', '2024-02-14 11:53:37'),
(584, 1, 'auth/users/2', 'PUT', '127.0.0.1', '{\"username\":\"caumm\",\"name\":\"Priscilla\",\"password\":\"$2y$12$tcDaCZH\\/8f3G8y4dI77eS.TMmQQv4j3M2wjXGVeJNOeE.gpkWxL1W\",\"password_confirmation\":\"$2y$12$tcDaCZH\\/8f3G8y4dI77eS.TMmQQv4j3M2wjXGVeJNOeE.gpkWxL1W\",\"roles\":[\"4\",null],\"permissions\":[null],\"_token\":\"wbuiqtsRY28fW4K4DhfySmSaQnQbqNvSKrf4tYEy\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-02-14 11:53:47', '2024-02-14 11:53:47'),
(585, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-02-14 11:53:48', '2024-02-14 11:53:48'),
(586, 1, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:53:56', '2024-02-14 11:53:56'),
(587, 1, 'auth/users/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:54:54', '2024-02-14 11:54:54'),
(588, 1, 'auth/users/2', 'PUT', '127.0.0.1', '{\"username\":\"caumm\",\"name\":\"Priscilla\",\"password\":\"admin\",\"password_confirmation\":\"admin\",\"roles\":[\"4\",null],\"permissions\":[null],\"_token\":\"wbuiqtsRY28fW4K4DhfySmSaQnQbqNvSKrf4tYEy\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-02-14 11:55:13', '2024-02-14 11:55:13'),
(589, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-02-14 11:55:13', '2024-02-14 11:55:13'),
(590, 2, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:55:28', '2024-02-14 11:55:28'),
(591, 6, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:55:42', '2024-02-14 11:55:42'),
(592, 6, '/', 'GET', '127.0.0.1', '[]', '2024-02-14 11:56:05', '2024-02-14 11:56:05'),
(593, 2, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:57:05', '2024-02-14 11:57:05'),
(594, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 11:57:13', '2024-02-14 11:57:13'),
(595, 2, 'staff', 'GET', '127.0.0.1', '[]', '2024-02-14 13:33:28', '2024-02-14 13:33:28'),
(596, 2, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 13:36:17', '2024-02-14 13:36:17'),
(597, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 13:37:04', '2024-02-14 13:37:04'),
(598, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 13:37:07', '2024-02-14 13:37:07'),
(599, 2, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 13:37:13', '2024-02-14 13:37:13'),
(600, 2, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 13:37:17', '2024-02-14 13:37:17'),
(601, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-02-14 13:37:22', '2024-02-14 13:37:22'),
(602, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 03:42:57', '2024-03-01 03:42:57'),
(603, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 03:43:17', '2024-03-01 03:43:17'),
(604, 2, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 03:44:34', '2024-03-01 03:44:34'),
(605, 6, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 03:45:07', '2024-03-01 03:45:07'),
(606, 1, 'auth/users/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 03:45:19', '2024-03-01 03:45:19'),
(607, 1, 'auth/users/5', 'PUT', '127.0.0.1', '{\"username\":\"Consequatur et autem\",\"name\":\"Astra Calhoun\",\"password\":\"admin\",\"password_confirmation\":\"admin\",\"roles\":[\"3\",null],\"permissions\":[null],\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-03-01 03:45:36', '2024-03-01 03:45:36'),
(608, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-03-01 03:45:37', '2024-03-01 03:45:37'),
(609, 1, 'auth/users/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 03:45:43', '2024-03-01 03:45:43'),
(610, 1, 'auth/users/5', 'PUT', '127.0.0.1', '{\"username\":\"pangus\",\"name\":\"Astra Calhoun\",\"password\":\"$2y$12$BoZDhOMbjsa2Ue25oxKC8eHH5PPZgKTliHmDvFiUfyqCu8A7IHpza\",\"password_confirmation\":\"$2y$12$BoZDhOMbjsa2Ue25oxKC8eHH5PPZgKTliHmDvFiUfyqCu8A7IHpza\",\"roles\":[\"3\",null],\"permissions\":[null],\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-03-01 03:45:52', '2024-03-01 03:45:52'),
(611, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-03-01 03:45:52', '2024-03-01 03:45:52'),
(612, 5, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 03:46:15', '2024-03-01 03:46:15'),
(613, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 03:46:21', '2024-03-01 03:46:21'),
(614, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:44:00', '2024-03-01 04:44:00'),
(615, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:44:07', '2024-03-01 04:44:07'),
(616, 2, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:44:13', '2024-03-01 04:44:13'),
(617, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:44:16', '2024-03-01 04:44:16'),
(618, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:44:49', '2024-03-01 04:44:49'),
(619, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:44:53', '2024-03-01 04:44:53'),
(620, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:44:59', '2024-03-01 04:44:59'),
(621, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:45:04', '2024-03-01 04:45:04'),
(622, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:45:08', '2024-03-01 04:45:08'),
(623, 2, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:45:15', '2024-03-01 04:45:15'),
(624, 2, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:45:37', '2024-03-01 04:45:37'),
(625, 2, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:45:53', '2024-03-01 04:45:53'),
(626, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:46:38', '2024-03-01 04:46:38'),
(627, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:47:15', '2024-03-01 04:47:15'),
(628, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:47:21', '2024-03-01 04:47:21'),
(629, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":null,\"firstname\":\"Dorcus\",\"lastname\":\"Ayikoru\",\"dob\":\"2000-02-01\",\"email\":\"dorcus@cuamm.org\",\"phone_number\":\"0700000000\",\"contract_start_date\":\"2010-03-01\",\"contract_end_date\":\"2023-05-01\",\"appraisal_date\":\"2023-03-04\",\"next_of_kin_name\":\"Racheal\",\"next_of_kin_relationship\":\"Sister\",\"next_of_kin_contact\":\"0701111111\",\"home_district\":\"Kampala\",\"nssf_number\":\"089911\",\"tin_number\":\"19210324\",\"job_title\":\"Head of HR CUAMM\",\"duty_station\":\"Kansanga\",\"employee_status\":\"Active\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-03-01 04:50:31', '2024-03-01 04:50:31'),
(630, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-01 04:50:35', '2024-03-01 04:50:35');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(631, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"HR123\",\"firstname\":\"Dorcus\",\"lastname\":\"Ayikoru\",\"dob\":\"2000-02-01\",\"email\":\"dorcus@cuamm.org\",\"phone_number\":\"0700000000\",\"contract_start_date\":\"2010-03-01\",\"contract_end_date\":\"2023-05-01\",\"appraisal_date\":\"2023-03-04\",\"next_of_kin_name\":\"Racheal\",\"next_of_kin_relationship\":\"Sister\",\"next_of_kin_contact\":\"0701111111\",\"home_district\":\"Kampala\",\"nssf_number\":\"089911\",\"tin_number\":\"19210324\",\"job_title\":\"Head of HR CUAMM\",\"duty_station\":\"Kansanga\",\"employee_status\":\"Active\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\"}', '2024-03-01 04:51:43', '2024-03-01 04:51:43'),
(632, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-01 04:51:45', '2024-03-01 04:51:45'),
(633, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:52:43', '2024-03-01 04:52:43'),
(634, 1, 'auth/users/7/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:52:54', '2024-03-01 04:52:54'),
(635, 1, 'auth/users/7', 'PUT', '127.0.0.1', '{\"username\":\"HR123\",\"name\":\"Dorcus Ayikoru\",\"password\":\"$2y$12$1wEhx9V\\/7U9ZL9r3PcpmXuODumMtsYqGnMSkxZInzaP\\/4NuD4MKRy\",\"password_confirmation\":\"$2y$12$1wEhx9V\\/7U9ZL9r3PcpmXuODumMtsYqGnMSkxZInzaP\\/4NuD4MKRy\",\"roles\":[\"4\",null],\"permissions\":[null],\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-03-01 04:53:17', '2024-03-01 04:53:17'),
(636, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-03-01 04:53:18', '2024-03-01 04:53:18'),
(637, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:53:29', '2024-03-01 04:53:29'),
(638, 1, 'auth/roles/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:53:34', '2024-03-01 04:53:34'),
(639, 1, 'auth/roles/4', 'PUT', '127.0.0.1', '{\"slug\":\"caumm\",\"name\":\"HR\",\"permissions\":[\"2\",\"3\",\"4\",\"6\",\"7\",\"8\",null],\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/roles\"}', '2024-03-01 04:53:45', '2024-03-01 04:53:45'),
(640, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-03-01 04:53:46', '2024-03-01 04:53:46'),
(641, 2, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:54:06', '2024-03-01 04:54:06'),
(642, 2, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:54:22', '2024-03-01 04:54:22'),
(643, 7, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 04:55:18', '2024-03-01 04:55:18'),
(644, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:55:33', '2024-03-01 04:55:33'),
(645, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:56:32', '2024-03-01 04:56:32'),
(646, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:56:58', '2024-03-01 04:56:58'),
(647, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"2\",\"description\":\"Est harum enim recus\",\"no_of_leave_days_requested\":\"26\",\"date_of_absence_from\":\"2024-03-01\",\"date_of_leave\":\"2024-03-01\",\"i_delegated_my_duties_to\":\"2\",\"signature_of_delegated\":\"Voluptatem quis offi\",\"employee_signature\":\"At saepe elit non r\",\"date_of_request\":\"2024-03-01 07:56:58\",\"user_id\":\"5\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-01 04:57:45', '2024-03-01 04:57:45'),
(648, 5, 'leave-datas/3', 'GET', '127.0.0.1', '[]', '2024-03-01 04:57:47', '2024-03-01 04:57:47'),
(649, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:57:54', '2024-03-01 04:57:54'),
(650, 7, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 04:58:08', '2024-03-01 04:58:08'),
(651, 7, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 04:58:13', '2024-03-01 04:58:13'),
(652, 6, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 04:58:33', '2024-03-01 04:58:33'),
(653, 6, 'leave-datas/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 04:59:04', '2024-03-01 04:59:04'),
(654, 6, 'leave-datas/3', 'PUT', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"2\",\"description\":\"Est harum enim recus\",\"no_of_leave_days_requested\":\"26\",\"date_of_absence_from\":\"2024-03-01\",\"date_of_leave\":\"2024-03-01\",\"i_delegated_my_duties_to\":\"2\",\"signature_of_delegated\":\"Voluptatem quis offi\",\"employee_signature\":\"At saepe elit non r\",\"date_of_request\":\"2024-03-01 07:56:58\",\"approval_status\":\"approved\",\"reason\":null,\"approved_by\":\"6\",\"_token\":\"wXowHPEq5FVRjKVkedOX9aipkVBGo01balyuwUQ1\",\"_method\":\"PUT\"}', '2024-03-01 04:59:24', '2024-03-01 04:59:24'),
(655, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 04:59:25', '2024-03-01 04:59:25'),
(656, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 04:59:38', '2024-03-01 04:59:38'),
(657, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 04:59:47', '2024-03-01 04:59:47'),
(658, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 05:00:05', '2024-03-01 05:00:05'),
(659, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 05:00:10', '2024-03-01 05:00:10'),
(660, 5, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:00:24', '2024-03-01 05:00:24'),
(661, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:01:21', '2024-03-01 05:01:21'),
(662, 7, 'leave-types/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:01:36', '2024-03-01 05:01:36'),
(663, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:01:40', '2024-03-01 05:01:40'),
(664, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:01:55', '2024-03-01 05:01:55'),
(665, 1, 'leave-types/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:02:00', '2024-03-01 05:02:00'),
(666, 1, 'leave-types/1', 'PUT', '127.0.0.1', '{\"leave_type_name\":\"Pregnancy\",\"description\":\"Maternal leave - Default are 60 days\",\"no_of_leave_days\":\"60\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-03-01 05:02:46', '2024-03-01 05:02:46'),
(667, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:02:47', '2024-03-01 05:02:47'),
(668, 1, 'leave-types/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:03:04', '2024-03-01 05:03:04'),
(669, 1, 'leave-types/2', 'PUT', '127.0.0.1', '{\"leave_type_name\":\"Annual\",\"description\":\"Annual Leave granted for general reasons\",\"no_of_leave_days\":\"30\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-03-01 05:03:38', '2024-03-01 05:03:38'),
(670, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:03:38', '2024-03-01 05:03:38'),
(671, 1, 'leave-types/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:03:43', '2024-03-01 05:03:43'),
(672, 1, 'leave-types/3', 'PUT', '127.0.0.1', '{\"leave_type_name\":\"Sick\",\"description\":\"Sick Leave\",\"no_of_leave_days\":\"5\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-03-01 05:04:44', '2024-03-01 05:04:44'),
(673, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:04:45', '2024-03-01 05:04:45'),
(674, 1, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:04:48', '2024-03-01 05:04:48'),
(675, 1, 'leave-types', 'POST', '127.0.0.1', '{\"leave_type_name\":\"Paternity\",\"description\":\"Paternity Leave\",\"no_of_leave_days\":\"4\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-03-01 05:05:28', '2024-03-01 05:05:28'),
(676, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:05:29', '2024-03-01 05:05:29'),
(677, 1, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:05:34', '2024-03-01 05:05:34'),
(678, 1, 'leave-types', 'POST', '127.0.0.1', '{\"leave_type_name\":\"Study\",\"description\":\"Study Leave\",\"no_of_leave_days\":\"10\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-03-01 05:05:54', '2024-03-01 05:05:54'),
(679, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:05:54', '2024-03-01 05:05:54'),
(680, 1, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:05:58', '2024-03-01 05:05:58'),
(681, 1, 'leave-types', 'POST', '127.0.0.1', '{\"leave_type_name\":\"Compasssion\",\"description\":\"Compassion Leave\",\"no_of_leave_days\":\"7\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-types\"}', '2024-03-01 05:06:24', '2024-03-01 05:06:24'),
(682, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:06:24', '2024-03-01 05:06:24'),
(683, 7, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:11:42', '2024-03-01 05:11:42'),
(684, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:11:53', '2024-03-01 05:11:53'),
(685, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:12:03', '2024-03-01 05:12:03'),
(686, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:12:06', '2024-03-01 05:12:06'),
(687, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:12:29', '2024-03-01 05:12:29'),
(688, 5, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:12:54', '2024-03-01 05:12:54'),
(689, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:12:55', '2024-03-01 05:12:55'),
(690, 7, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:15:57', '2024-03-01 05:15:57'),
(691, 7, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 05:16:11', '2024-03-01 05:16:11'),
(692, 7, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:16:18', '2024-03-01 05:16:18'),
(693, 7, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 05:16:55', '2024-03-01 05:16:55'),
(694, 7, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:17:17', '2024-03-01 05:17:17'),
(695, 5, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:17:37', '2024-03-01 05:17:37'),
(696, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:18:44', '2024-03-01 05:18:44'),
(697, 7, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 05:23:43', '2024-03-01 05:23:43'),
(698, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:24:21', '2024-03-01 05:24:21'),
(699, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:25:01', '2024-03-01 05:25:01'),
(700, 7, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:25:41', '2024-03-01 05:25:41'),
(701, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:25:45', '2024-03-01 05:25:45'),
(702, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:26:18', '2024-03-01 05:26:18'),
(703, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:27:21', '2024-03-01 05:27:21'),
(704, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:27:26', '2024-03-01 05:27:26'),
(705, 5, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:27:40', '2024-03-01 05:27:40'),
(706, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:27:55', '2024-03-01 05:27:55'),
(707, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:27:57', '2024-03-01 05:27:57'),
(708, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"5\",\"description\":\"Going abroad for studies\",\"no_of_leave_days_requested\":\"15\",\"date_of_absence_from\":\"2024-03-01\",\"date_of_leave\":\"2024-03-01\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":null,\"employee_signature\":null,\"date_of_request\":\"2024-03-01 08:27:57\",\"user_id\":\"5\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-01 05:29:17', '2024-03-01 05:29:17'),
(709, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-01 05:29:17', '2024-03-01 05:29:17'),
(710, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"5\",\"description\":\"Going abroad for studies\",\"no_of_leave_days_requested\":\"5\",\"date_of_absence_from\":\"2024-03-01\",\"date_of_leave\":\"2024-03-01\",\"i_delegated_my_duties_to\":\"0\",\"signature_of_delegated\":null,\"employee_signature\":null,\"date_of_request\":\"2024-03-01 08:27:57\",\"user_id\":\"5\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\"}', '2024-03-01 05:30:04', '2024-03-01 05:30:04'),
(711, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-01 05:30:04', '2024-03-01 05:30:04'),
(712, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"5\",\"description\":\"Going abroad for studies\",\"no_of_leave_days_requested\":\"5\",\"date_of_absence_from\":\"2024-03-13\",\"date_of_leave\":\"2024-03-15\",\"i_delegated_my_duties_to\":\"3\",\"signature_of_delegated\":null,\"employee_signature\":null,\"date_of_request\":\"2024-03-01 08:27:57\",\"user_id\":\"5\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\"}', '2024-03-01 05:33:59', '2024-03-01 05:33:59'),
(713, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 05:34:00', '2024-03-01 05:34:00'),
(714, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-01 05:35:00', '2024-03-01 05:35:00'),
(715, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-01 05:35:00', '2024-03-01 05:35:00'),
(716, 1, 'auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:35:53', '2024-03-01 05:35:53'),
(717, 1, 'auth/permissions/8/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:01', '2024-03-01 05:36:01'),
(718, 1, 'auth/permissions/8', 'PUT', '127.0.0.1', '{\"slug\":\"leave_types\",\"name\":\"Leave Types\",\"http_method\":[null],\"http_path\":\"\\/leave-types*\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/permissions\"}', '2024-03-01 05:36:12', '2024-03-01 05:36:12'),
(719, 1, 'auth/permissions', 'GET', '127.0.0.1', '[]', '2024-03-01 05:36:12', '2024-03-01 05:36:12'),
(720, 7, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-01 05:36:19', '2024-03-01 05:36:19'),
(721, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:21', '2024-03-01 05:36:21'),
(722, 7, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:27', '2024-03-01 05:36:27'),
(723, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:32', '2024-03-01 05:36:32'),
(724, 7, 'leave-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:38', '2024-03-01 05:36:38'),
(725, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:40', '2024-03-01 05:36:40'),
(726, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:49', '2024-03-01 05:36:49'),
(727, 7, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:36:51', '2024-03-01 05:36:51'),
(728, 1, 'auth/permissions/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:37:04', '2024-03-01 05:37:04'),
(729, 1, 'auth/permissions/6', 'PUT', '127.0.0.1', '{\"slug\":\"staff\",\"name\":\"Staff management\",\"http_method\":[null],\"http_path\":\"\\/staff*\",\"_token\":\"vJa64Svzp9M5glOmyE6WCVaUQozfozBRotxxTqfk\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/permissions\"}', '2024-03-01 05:37:11', '2024-03-01 05:37:11'),
(730, 1, 'auth/permissions', 'GET', '127.0.0.1', '[]', '2024-03-01 05:37:12', '2024-03-01 05:37:12'),
(731, 7, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-01 05:37:17', '2024-03-01 05:37:17'),
(732, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:37:20', '2024-03-01 05:37:20'),
(733, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:44:22', '2024-03-01 05:44:22'),
(734, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:44:29', '2024-03-01 05:44:29'),
(735, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:44:36', '2024-03-01 05:44:36'),
(736, 7, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:44:45', '2024-03-01 05:44:45'),
(737, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:45:05', '2024-03-01 05:45:05'),
(738, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:45:06', '2024-03-01 05:45:06'),
(739, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:45:08', '2024-03-01 05:45:08'),
(740, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:45:12', '2024-03-01 05:45:12'),
(741, 7, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:45:13', '2024-03-01 05:45:13'),
(742, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:49:03', '2024-03-01 05:49:03'),
(743, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:49:53', '2024-03-01 05:49:53'),
(744, 7, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:49:57', '2024-03-01 05:49:57'),
(745, 7, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-01 05:51:04', '2024-03-01 05:51:04'),
(746, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 05:53:45', '2024-03-01 05:53:45'),
(747, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 05:55:33', '2024-03-01 05:55:33'),
(748, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:57:19', '2024-03-01 05:57:19'),
(749, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:57:30', '2024-03-01 05:57:30'),
(750, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-01 05:57:46', '2024-03-01 05:57:46'),
(751, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 05:57:55', '2024-03-01 05:57:55'),
(752, 5, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:01:43', '2024-03-01 06:01:43'),
(753, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:06:28', '2024-03-01 06:06:28'),
(754, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:06:44', '2024-03-01 06:06:44'),
(755, 5, '_handle_action_', 'POST', '127.0.0.1', '{\"_key\":\"4\",\"_model\":\"App_Models_LeaveData\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\",\"_action\":\"Encore_Admin_Grid_Actions_Delete\",\"_input\":\"true\"}', '2024-03-01 06:06:57', '2024-03-01 06:06:57'),
(756, 5, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:06:57', '2024-03-01 06:06:57'),
(757, 5, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:07:34', '2024-03-01 06:07:34'),
(758, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"2\",\"description\":\"personal business\",\"no_of_leave_days_requested\":\"12\",\"date_of_absence_from\":\"2024-03-04\",\"date_of_leave\":\"2024-03-16\",\"i_delegated_my_duties_to\":\"3\",\"signature_of_delegated\":\"Claire\",\"employee_signature\":null,\"date_of_request\":\"2024-03-01 09:07:34\",\"user_id\":\"5\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-01 06:10:49', '2024-03-01 06:10:49'),
(759, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-01 06:10:50', '2024-03-01 06:10:50'),
(760, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"4\",\"description\":\"personal business\",\"no_of_leave_days_requested\":\"12\",\"date_of_absence_from\":\"2024-03-04\",\"date_of_leave\":\"2024-03-16\",\"i_delegated_my_duties_to\":\"3\",\"signature_of_delegated\":\"Claire\",\"employee_signature\":null,\"date_of_request\":\"2024-03-01 09:07:34\",\"user_id\":\"5\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\"}', '2024-03-01 06:11:49', '2024-03-01 06:11:49'),
(761, 5, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-01 06:11:49', '2024-03-01 06:11:49'),
(762, 5, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"4\",\"description\":\"personal business\",\"no_of_leave_days_requested\":\"4\",\"date_of_absence_from\":\"2024-03-04\",\"date_of_leave\":\"2024-03-16\",\"i_delegated_my_duties_to\":\"3\",\"signature_of_delegated\":\"Claire\",\"employee_signature\":null,\"date_of_request\":\"2024-03-01 09:07:34\",\"user_id\":\"5\",\"_token\":\"zgSQoTpfr4eoRQUR1f6P4wUkOYd1CLVUpUly8eiY\"}', '2024-03-01 06:12:13', '2024-03-01 06:12:13'),
(763, 5, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 06:12:14', '2024-03-01 06:12:14'),
(764, 7, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 06:12:36', '2024-03-01 06:12:36'),
(765, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:12:48', '2024-03-01 06:12:48'),
(766, 7, 'leave-datas/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:12:54', '2024-03-01 06:12:54'),
(767, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:12:59', '2024-03-01 06:12:59'),
(768, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 06:13:31', '2024-03-01 06:13:31'),
(769, 6, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:13:42', '2024-03-01 06:13:42'),
(770, 6, 'leave-datas/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:13:47', '2024-03-01 06:13:47'),
(771, 6, 'leave-datas/5', 'PUT', '127.0.0.1', '{\"staff_id\":\"pangus\",\"type_of_leave_id\":\"4\",\"description\":\"personal business\",\"no_of_leave_days_requested\":\"4\",\"date_of_absence_from\":\"2024-03-04\",\"date_of_leave\":\"2024-03-16\",\"i_delegated_my_duties_to\":\"3\",\"signature_of_delegated\":\"Claire\",\"employee_signature\":null,\"date_of_request\":\"2024-03-01 09:07:34\",\"approval_status\":\"approved\",\"reason\":\"sfdf\",\"approved_by\":\"6\",\"_token\":\"wXowHPEq5FVRjKVkedOX9aipkVBGo01balyuwUQ1\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-01 06:14:36', '2024-03-01 06:14:36'),
(772, 6, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 06:14:37', '2024-03-01 06:14:37'),
(773, 7, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-01 06:14:47', '2024-03-01 06:14:47'),
(774, 7, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:14:52', '2024-03-01 06:14:52'),
(775, 7, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:14:54', '2024-03-01 06:14:54'),
(776, 7, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:15:07', '2024-03-01 06:15:07'),
(777, 7, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-01 06:15:11', '2024-03-01 06:15:11'),
(778, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-06 03:48:09', '2024-03-06 03:48:09'),
(779, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:48:21', '2024-03-06 03:48:21'),
(780, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:48:25', '2024-03-06 03:48:25'),
(781, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Mollit quam beatae f\",\"firstname\":\"Ciaran\",\"lastname\":\"Ware\",\"dob\":\"2024-03-06\",\"email\":\"bazemofo@mailinator.com\",\"phone_number\":\"kkkkkkkkkkk\",\"contract_start_date\":\"2024-03-28\",\"contract_end_date\":\"2024-03-20\",\"appraisal_date\":\"2024-03-29\",\"next_of_kin_name\":\"Maris Conrad\",\"next_of_kin_relationship\":\"Commodo vero incidid\",\"home_district\":\"Necessitatibus quis\",\"nssf_number\":\"278\",\"tin_number\":\"497\",\"job_title\":\"Sit minima ducimus\",\"duty_station\":\"Voluptas ad deserunt\",\"employee_status\":\"Magni autem cupidita\",\"_token\":\"HMCAL0LzMYrcYUXTZsxm4Qba7vSMaf4tZm8nwy8E\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-03-06 03:49:01', '2024-03-06 03:49:01'),
(782, 1, 'staff/8', 'GET', '127.0.0.1', '[]', '2024-03-06 03:49:02', '2024-03-06 03:49:02'),
(783, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:49:41', '2024-03-06 03:49:41'),
(784, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:49:44', '2024-03-06 03:49:44'),
(785, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-06 03:50:41', '2024-03-06 03:50:41'),
(786, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"Doloremque repellend\",\"firstname\":\"Tasha\",\"lastname\":\"Santana\",\"dob\":\"2024-03-14\",\"email\":\"jewupodi@mailinator.com\",\"phone_number\":\"+1 (709) 451-4922\",\"contract_start_date\":\"2024-04-05\",\"contract_end_date\":\"2024-03-28\",\"appraisal_date\":\"2024-03-28\",\"next_of_kin_name\":\"Beverly Finley\",\"next_of_kin_relationship\":\"Duis et dolore volup\",\"next_of_kin_contact\":\"Illum dolores conse\",\"home_district\":\"Eveniet in quia exc\",\"nssf_number\":\"50\",\"tin_number\":\"474\",\"job_title\":\"Sit asperiores deser\",\"duty_station\":\"Culpa labore dolori\",\"employee_status\":\"Qui eos eveniet mai\",\"_token\":\"HMCAL0LzMYrcYUXTZsxm4Qba7vSMaf4tZm8nwy8E\",\"after-save\":\"1\"}', '2024-03-06 03:51:05', '2024-03-06 03:51:05'),
(787, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-06 03:51:05', '2024-03-06 03:51:05'),
(788, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:51:29', '2024-03-06 03:51:29'),
(789, 1, 'staff/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:51:33', '2024-03-06 03:51:33'),
(790, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:51:50', '2024-03-06 03:51:50'),
(791, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 03:53:07', '2024-03-06 03:53:07'),
(792, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 03:53:09', '2024-03-06 03:53:09'),
(793, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-06 03:54:03', '2024-03-06 03:54:03'),
(794, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-06 03:54:22', '2024-03-06 03:54:22'),
(795, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-06 03:55:50', '2024-03-06 03:55:50'),
(796, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-06 03:56:10', '2024-03-06 03:56:10'),
(797, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-06 04:26:39', '2024-03-06 04:26:39'),
(798, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 04:26:44', '2024-03-06 04:26:44'),
(799, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:26:50', '2024-03-06 04:26:50'),
(800, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:27:59', '2024-03-06 04:27:59'),
(801, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:29:14', '2024-03-06 04:29:14'),
(802, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:29:54', '2024-03-06 04:29:54'),
(803, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:30:45', '2024-03-06 04:30:45'),
(804, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:30:49', '2024-03-06 04:30:49'),
(805, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:31:22', '2024-03-06 04:31:22'),
(806, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:33:40', '2024-03-06 04:33:40'),
(807, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:34:57', '2024-03-06 04:34:57'),
(808, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:36:16', '2024-03-06 04:36:16'),
(809, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:38:52', '2024-03-06 04:38:52'),
(810, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:40:08', '2024-03-06 04:40:08'),
(811, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:40:35', '2024-03-06 04:40:35'),
(812, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:40:37', '2024-03-06 04:40:37'),
(813, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:41:06', '2024-03-06 04:41:06'),
(814, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:41:10', '2024-03-06 04:41:10'),
(815, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:41:53', '2024-03-06 04:41:53'),
(816, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:43:59', '2024-03-06 04:43:59'),
(817, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:46:48', '2024-03-06 04:46:48'),
(818, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:47:39', '2024-03-06 04:47:39'),
(819, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:49:09', '2024-03-06 04:49:09'),
(820, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 04:52:16', '2024-03-06 04:52:16'),
(821, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:08:26', '2024-03-06 05:08:26'),
(822, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:08:32', '2024-03-06 05:08:32'),
(823, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:09:09', '2024-03-06 05:09:09'),
(824, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:12:52', '2024-03-06 05:12:52'),
(825, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 05:13:02', '2024-03-06 05:13:02'),
(826, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 05:13:06', '2024-03-06 05:13:06'),
(827, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:13:56', '2024-03-06 05:13:56'),
(828, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:14:57', '2024-03-06 05:14:57'),
(829, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:24:41', '2024-03-06 05:24:41'),
(830, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:25:03', '2024-03-06 05:25:03'),
(831, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:25:19', '2024-03-06 05:25:19'),
(832, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:25:38', '2024-03-06 05:25:38'),
(833, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:26:40', '2024-03-06 05:26:40'),
(834, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:29:42', '2024-03-06 05:29:42'),
(835, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:48:29', '2024-03-06 05:48:29'),
(836, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:50:29', '2024-03-06 05:50:29'),
(837, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:50:55', '2024-03-06 05:50:55'),
(838, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:51:06', '2024-03-06 05:51:06'),
(839, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:52:39', '2024-03-06 05:52:39'),
(840, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:55:00', '2024-03-06 05:55:00'),
(841, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:55:51', '2024-03-06 05:55:51'),
(842, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:58:09', '2024-03-06 05:58:09'),
(843, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 05:59:16', '2024-03-06 05:59:16'),
(844, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 05:59:19', '2024-03-06 05:59:19'),
(845, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 06:00:26', '2024-03-06 06:00:26'),
(846, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:02:23', '2024-03-06 06:02:23'),
(847, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:03:42', '2024-03-06 06:03:42'),
(848, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:06:52', '2024-03-06 06:06:52'),
(849, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:08:41', '2024-03-06 06:08:41'),
(850, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:10:08', '2024-03-06 06:10:08'),
(851, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:13:16', '2024-03-06 06:13:16'),
(852, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:35:21', '2024-03-06 06:35:21'),
(853, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:36:01', '2024-03-06 06:36:01'),
(854, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:41:52', '2024-03-06 06:41:52'),
(855, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 06:42:46', '2024-03-06 06:42:46'),
(856, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 06:43:45', '2024-03-06 06:43:45'),
(857, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:46:20', '2024-03-06 06:46:20'),
(858, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 06:46:26', '2024-03-06 06:46:26'),
(859, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:27:30', '2024-03-06 07:27:30'),
(860, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:28:37', '2024-03-06 07:28:37'),
(861, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:30:42', '2024-03-06 07:30:42'),
(862, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:30:45', '2024-03-06 07:30:45'),
(863, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:32:31', '2024-03-06 07:32:31'),
(864, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:33:56', '2024-03-06 07:33:56'),
(865, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:34:38', '2024-03-06 07:34:38'),
(866, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:36:16', '2024-03-06 07:36:16'),
(867, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:36:45', '2024-03-06 07:36:45'),
(868, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:36:56', '2024-03-06 07:36:56'),
(869, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:37:01', '2024-03-06 07:37:01'),
(870, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:37:05', '2024-03-06 07:37:05'),
(871, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:37:09', '2024-03-06 07:37:09'),
(872, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:37:12', '2024-03-06 07:37:12'),
(873, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:37:15', '2024-03-06 07:37:15'),
(874, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:38:45', '2024-03-06 07:38:45'),
(875, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:38:47', '2024-03-06 07:38:47'),
(876, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:38:49', '2024-03-06 07:38:49'),
(877, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:38:51', '2024-03-06 07:38:51'),
(878, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:38:52', '2024-03-06 07:38:52'),
(879, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:38:54', '2024-03-06 07:38:54'),
(880, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-06 07:38:55', '2024-03-06 07:38:55'),
(881, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:39:11', '2024-03-06 07:39:11'),
(882, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-06 07:39:22', '2024-03-06 07:39:22'),
(883, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-07 07:27:21', '2024-03-07 07:27:21'),
(884, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-07 07:47:23', '2024-03-07 07:47:23'),
(885, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:47:26', '2024-03-07 07:47:26'),
(886, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-07 07:47:40', '2024-03-07 07:47:40'),
(887, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-07 07:47:54', '2024-03-07 07:47:54'),
(888, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:47:58', '2024-03-07 07:47:58'),
(889, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:48:01', '2024-03-07 07:48:01'),
(890, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:48:13', '2024-03-07 07:48:13'),
(891, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:48:15', '2024-03-07 07:48:15'),
(892, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:48:18', '2024-03-07 07:48:18'),
(893, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-07 07:48:44', '2024-03-07 07:48:44'),
(894, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:48:51', '2024-03-07 07:48:51'),
(895, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 07:55:35', '2024-03-07 07:55:35'),
(896, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-07 08:02:04', '2024-03-07 08:02:04'),
(897, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-07 08:04:29', '2024-03-07 08:04:29'),
(898, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 08:05:24', '2024-03-07 08:05:24'),
(899, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 08:06:09', '2024-03-07 08:06:09'),
(900, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-07 08:06:12', '2024-03-07 08:06:12'),
(901, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-07 08:06:14', '2024-03-07 08:06:14'),
(902, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-12 05:26:49', '2024-03-12 05:26:49'),
(903, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 05:27:03', '2024-03-12 05:27:03'),
(904, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 05:27:08', '2024-03-12 05:27:08'),
(905, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 05:27:10', '2024-03-12 05:27:10'),
(906, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 05:27:55', '2024-03-12 05:27:55'),
(907, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 05:27:58', '2024-03-12 05:27:58'),
(908, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 05:27:58', '2024-03-12 05:27:58'),
(909, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 05:28:26', '2024-03-12 05:28:26'),
(910, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 05:28:33', '2024-03-12 05:28:33'),
(911, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:29:53', '2024-03-12 05:29:53'),
(912, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 05:30:05', '2024-03-12 05:30:05'),
(913, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 05:30:08', '2024-03-12 05:30:08'),
(914, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:30:25', '2024-03-12 05:30:25'),
(915, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:35:02', '2024-03-12 05:35:02'),
(916, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:36:43', '2024-03-12 05:36:43'),
(917, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:37:07', '2024-03-12 05:37:07'),
(918, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:41:31', '2024-03-12 05:41:31'),
(919, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:42:07', '2024-03-12 05:42:07'),
(920, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:42:33', '2024-03-12 05:42:33'),
(921, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:43:07', '2024-03-12 05:43:07'),
(922, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 05:46:35', '2024-03-12 05:46:35'),
(923, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:14:27', '2024-03-12 06:14:27'),
(924, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:14:31', '2024-03-12 06:14:31'),
(925, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:14:59', '2024-03-12 06:14:59'),
(926, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1447\",\"firstname\":\"Rowan\",\"lastname\":\"Bolton\",\"dob\":\"2024-03-13\",\"email\":\"curigapar@mailinator.com\",\"phone_number\":\"+1 (583) 345-8447\",\"contract_start_date\":\"2024-03-14\",\"contract_end_date\":\"2024-04-06\",\"appraisal_date\":\"2024-03-28\",\"next_of_kin_name\":\"Lisandra Harper\",\"next_of_kin_relationship\":\"Quod nesciunt maior\",\"next_of_kin_contact\":\"Consectetur optio\",\"home_district\":\"Non fugiat Nam est\",\"nssf_number\":\"503\",\"tin_number\":\"592\",\"job_title\":\"Expedita cupiditate\",\"duty_station\":\"Quia est officia qui\",\"employee_status\":\"Eaque ut excepturi p\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"after-save\":\"3\"}', '2024-03-12 06:15:25', '2024-03-12 06:15:25'),
(927, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:15:26', '2024-03-12 06:15:26'),
(928, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1447\",\"firstname\":\"Rowan\",\"lastname\":\"Bolton\",\"dob\":\"2024-03-13\",\"email\":\"curigapar@mailinator.com\",\"phone_number\":\"+1 (583) 345-8447\",\"contract_start_date\":\"2024-03-14\",\"contract_end_date\":\"2024-04-06\",\"appraisal_date\":\"2024-03-28\",\"next_of_kin_name\":\"Lisandra Harper\",\"next_of_kin_relationship\":\"Quod nesciunt maior\",\"next_of_kin_contact\":\"+1 (583) 345-8447\",\"home_district\":\"Non fugiat Nam est\",\"nssf_number\":\"503\",\"tin_number\":\"592\",\"job_title\":\"Expedita cupiditate\",\"duty_station\":\"Quia est officia qui\",\"employee_status\":\"Eaque ut excepturi p\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\"}', '2024-03-12 06:15:46', '2024-03-12 06:15:46'),
(929, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:15:47', '2024-03-12 06:15:47'),
(930, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1447\",\"firstname\":\"Rowan\",\"lastname\":\"Bolton\",\"dob\":\"2024-03-13\",\"email\":\"curigapar@mailinator.com\",\"phone_number\":\"+1 (583) 345-8447\",\"contract_start_date\":\"2024-03-14\",\"contract_end_date\":\"2024-04-06\",\"appraisal_date\":\"2024-03-28\",\"next_of_kin_name\":\"Lisandra Harper\",\"next_of_kin_relationship\":\"Quod nesciunt maior\",\"next_of_kin_contact\":\"+1 (583) 345-8447\",\"home_district\":\"Non fugiat Nam est\",\"nssf_number\":\"503\",\"tin_number\":\"592\",\"job_title\":\"Expedita cupiditate\",\"duty_station\":\"Quia est officia qui\",\"employee_status\":\"Eaque ut excepturi p\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\"}', '2024-03-12 06:16:36', '2024-03-12 06:16:36'),
(931, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:16:37', '2024-03-12 06:16:37'),
(932, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:16:57', '2024-03-12 06:16:57'),
(933, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/4411\",\"firstname\":\"Colorado\",\"lastname\":\"Chambers\",\"dob\":\"2024-03-20\",\"email\":\"fejabeg@mailinator.com\",\"phone_number\":\"+1 (227) 435-7644\",\"contract_start_date\":\"2024-03-20\",\"contract_end_date\":\"2024-03-28\",\"appraisal_date\":\"2024-04-05\",\"next_of_kin_name\":\"Eagan Mayer\",\"next_of_kin_relationship\":\"Vel est omnis sit m\",\"next_of_kin_contact\":\"+1 (227) 435-7644\",\"home_district\":\"Delectus voluptas n\",\"nssf_number\":\"85\",\"tin_number\":\"118\",\"job_title\":\"Voluptate nisi magna\",\"duty_station\":\"Voluptatum reprehend\",\"employee_status\":\"Officia est dolore r\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"after-save\":\"3\"}', '2024-03-12 06:18:32', '2024-03-12 06:18:32'),
(934, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:18:33', '2024-03-12 06:18:33'),
(935, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/4411\",\"firstname\":\"Colorado\",\"lastname\":\"Chambers\",\"dob\":\"2024-03-20\",\"email\":\"fejabeg@mailinator.com\",\"phone_number\":\"+1 (227) 435-7644\",\"contract_start_date\":\"2024-03-20\",\"contract_end_date\":\"2024-03-28\",\"appraisal_date\":\"2024-04-05\",\"next_of_kin_name\":\"Eagan Mayer\",\"next_of_kin_relationship\":\"Vel est omnis sit m\",\"next_of_kin_contact\":\"+1 (227) 435-7644\",\"home_district\":\"Delectus voluptas n\",\"nssf_number\":\"85\",\"tin_number\":\"118\",\"job_title\":\"Voluptate nisi magna\",\"duty_station\":\"Voluptatum reprehend\",\"employee_status\":\"Officia est dolore r\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\"}', '2024-03-12 06:20:22', '2024-03-12 06:20:22'),
(936, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:20:23', '2024-03-12 06:20:23'),
(937, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:36:40', '2024-03-12 06:36:40'),
(938, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"firstname\":\"Kirestin\",\"lastname\":\"Kramer\",\"dob\":\"2024-03-13\",\"email\":\"pevik@mailinator.com\",\"phone_number\":\"+1 (191) 267-8839\",\"contract_start_date\":\"2024-03-26\",\"contract_end_date\":\"2024-04-06\",\"appraisal_date\":\"2024-03-22\",\"next_of_kin_name\":\"Tatum Carey\",\"next_of_kin_relationship\":\"Eveniet est excepte\",\"next_of_kin_contact\":\"+1 (191) 267-8839\",\"home_district\":\"Voluptatem Ut hic v\",\"nssf_number\":\"501\",\"tin_number\":\"280\",\"job_title\":\"Sunt tempor sed et\",\"duty_station\":\"Unde qui veniam est\",\"employee_status\":\"Repellendus Incidid\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"after-save\":\"2\"}', '2024-03-12 06:37:16', '2024-03-12 06:37:16'),
(939, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:37:17', '2024-03-12 06:37:17'),
(940, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:37:28', '2024-03-12 06:37:28'),
(941, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:37:37', '2024-03-12 06:37:37'),
(942, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:40:38', '2024-03-12 06:40:38'),
(943, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:40:47', '2024-03-12 06:40:47'),
(944, 1, 'staff', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"firstname\":\"Henry\",\"lastname\":\"Morrow\",\"dob\":\"2024-03-21\",\"email\":\"fitugase@mailinator.com\",\"phone_number\":\"+1 (457) 353-5853\",\"contract_start_date\":\"2024-04-06\",\"contract_end_date\":\"2024-03-30\",\"appraisal_date\":\"2024-04-06\",\"next_of_kin_name\":\"Deborah Maddox\",\"next_of_kin_relationship\":\"Sit ducimus alias\",\"next_of_kin_contact\":\"+1 (457) 353-5853\",\"home_district\":\"Qui possimus quae c\",\"nssf_number\":\"664\",\"tin_number\":\"638\",\"job_title\":\"Est velit corporis\",\"duty_station\":\"Omnis distinctio Se\",\"employee_status\":\"Ipsum velit suscipi\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"after-save\":\"3\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/staff\"}', '2024-03-12 06:41:23', '2024-03-12 06:41:23'),
(945, 1, 'staff/2', 'GET', '127.0.0.1', '[]', '2024-03-12 06:41:24', '2024-03-12 06:41:24'),
(946, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:41:34', '2024-03-12 06:41:34'),
(947, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:41:37', '2024-03-12 06:41:37'),
(948, 1, '_handle_action_', 'POST', '127.0.0.1', '{\"_key\":\"2\",\"_model\":\"App_Models_Staff\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"_action\":\"Encore_Admin_Grid_Actions_Delete\",\"_input\":\"true\"}', '2024-03-12 06:44:34', '2024-03-12 06:44:34'),
(949, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:44:34', '2024-03-12 06:44:34'),
(950, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 06:45:54', '2024-03-12 06:45:54'),
(951, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 06:47:22', '2024-03-12 06:47:22'),
(952, 1, 'staff/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:47:33', '2024-03-12 06:47:33'),
(953, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:47:44', '2024-03-12 06:47:44'),
(954, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 06:47:46', '2024-03-12 06:47:46'),
(955, 1, 'staff/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:47:49', '2024-03-12 06:47:49'),
(956, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:48:32', '2024-03-12 06:48:32'),
(957, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:48:34', '2024-03-12 06:48:34'),
(958, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:49:23', '2024-03-12 06:49:23'),
(959, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:49:42', '2024-03-12 06:49:42'),
(960, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:51:53', '2024-03-12 06:51:53'),
(961, 1, 'staff/create', 'GET', '127.0.0.1', '[]', '2024-03-12 06:52:07', '2024-03-12 06:52:07'),
(962, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 06:53:02', '2024-03-12 06:53:02'),
(963, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_export_\":\"all\"}', '2024-03-12 06:53:06', '2024-03-12 06:53:06'),
(964, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 06:55:49', '2024-03-12 06:55:49'),
(965, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 06:55:52', '2024-03-12 06:55:52'),
(966, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:03:26', '2024-03-12 07:03:26');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(967, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:03:30', '2024-03-12 07:03:30'),
(968, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:04:11', '2024-03-12 07:04:11'),
(969, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:04:13', '2024-03-12 07:04:13'),
(970, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:09:00', '2024-03-12 07:09:00'),
(971, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:09:02', '2024-03-12 07:09:02'),
(972, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:09:16', '2024-03-12 07:09:16'),
(973, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:14:12', '2024-03-12 07:14:12'),
(974, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:14:15', '2024-03-12 07:14:15'),
(975, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:14:17', '2024-03-12 07:14:17'),
(976, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:14:23', '2024-03-12 07:14:23'),
(977, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:14:25', '2024-03-12 07:14:25'),
(978, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:14:27', '2024-03-12 07:14:27'),
(979, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:14:32', '2024-03-12 07:14:32'),
(980, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"page:1\"}', '2024-03-12 07:14:49', '2024-03-12 07:14:49'),
(981, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"page:1\"}', '2024-03-12 07:14:51', '2024-03-12 07:14:51'),
(982, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:14:54', '2024-03-12 07:14:54'),
(983, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:15:12', '2024-03-12 07:15:12'),
(984, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:15:14', '2024-03-12 07:15:14'),
(985, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:16:10', '2024-03-12 07:16:10'),
(986, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:16:12', '2024-03-12 07:16:12'),
(987, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:16:15', '2024-03-12 07:16:15'),
(988, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_export_\":\"all\"}', '2024-03-12 07:16:16', '2024-03-12 07:16:16'),
(989, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:19:03', '2024-03-12 07:19:03'),
(990, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:19:07', '2024-03-12 07:19:07'),
(991, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:19:08', '2024-03-12 07:19:08'),
(992, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_export_\":\"all\"}', '2024-03-12 07:19:10', '2024-03-12 07:19:10'),
(993, 1, 'staff', 'GET', '127.0.0.1', '[]', '2024-03-12 07:19:54', '2024-03-12 07:19:54'),
(994, 1, 'staff', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-12 07:19:56', '2024-03-12 07:19:56'),
(995, 9, '/', 'GET', '127.0.0.1', '[]', '2024-03-12 07:24:19', '2024-03-12 07:24:19'),
(996, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:24:22', '2024-03-12 07:24:22'),
(997, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:24:26', '2024-03-12 07:24:26'),
(998, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:24:33', '2024-03-12 07:24:33'),
(999, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:24:51', '2024-03-12 07:24:51'),
(1000, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"6\",\"description\":\"Et eligendi providen\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-12\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-12 10:24:51\",\"date_of_leave\":\"pending\",\"_token\":\"H9sYTTrvSUbPXazptHU26QFWDdsfysAVn6RUc8ty\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-12 07:25:02', '2024-03-12 07:25:02'),
(1001, 9, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 07:25:02', '2024-03-12 07:25:02'),
(1002, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"1\",\"description\":\"Et eligendi providen\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-12\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-12 10:24:51\",\"date_of_leave\":\"pending\",\"_token\":\"H9sYTTrvSUbPXazptHU26QFWDdsfysAVn6RUc8ty\"}', '2024-03-12 07:25:14', '2024-03-12 07:25:14'),
(1003, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 07:25:14', '2024-03-12 07:25:14'),
(1004, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:25:32', '2024-03-12 07:25:32'),
(1005, 1, 'auth/users/10/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:25:38', '2024-03-12 07:25:38'),
(1006, 1, 'auth/users/10', 'PUT', '127.0.0.1', '{\"username\":\"STF\\/CUAMM\\/184323\",\"name\":\"Henry Morrow\",\"password\":\"$2y$12$\\/i8uLf0nyIkrq6IiAycg9OxumFMwvoTiLdlamcDobgFQ50d6iAEuy\",\"password_confirmation\":\"$2y$12$\\/i8uLf0nyIkrq6IiAycg9OxumFMwvoTiLdlamcDobgFQ50d6iAEuy\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/users\"}', '2024-03-12 07:25:45', '2024-03-12 07:25:45'),
(1007, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-03-12 07:25:46', '2024-03-12 07:25:46'),
(1008, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-03-12 07:25:57', '2024-03-12 07:25:57'),
(1009, 1, 'leave-datas/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:26:02', '2024-03-12 07:26:02'),
(1010, 1, 'leave-datas/6/edit', 'GET', '127.0.0.1', '[]', '2024-03-12 07:30:53', '2024-03-12 07:30:53'),
(1011, 1, 'leave-datas/6/edit', 'GET', '127.0.0.1', '[]', '2024-03-12 07:40:07', '2024-03-12 07:40:07'),
(1012, 1, 'leave-datas/6/edit', 'GET', '127.0.0.1', '[]', '2024-03-12 07:41:14', '2024-03-12 07:41:14'),
(1013, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:45:04', '2024-03-12 07:45:04'),
(1014, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 07:45:12', '2024-03-12 07:45:12'),
(1015, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"2\",\"employee_name\":\"Henry Morrow\",\"user_id\":\"10\",\"type_of_leave_id\":\"4\",\"description\":\"Voluptatem minim qu\",\"no_of_leave_days_requested\":\"16\",\"date_of_absence_from\":\"2024-03-12\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-12 10:45:12\",\"date_of_leave\":\"pending\",\"approval_status\":\"approved\",\"reason\":null,\"approved_by\":\"1\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-12 07:45:42', '2024-03-12 07:45:42'),
(1016, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 07:45:42', '2024-03-12 07:45:42'),
(1017, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 07:47:23', '2024-03-12 07:47:23'),
(1018, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"2\",\"user_id\":\"10\",\"type_of_leave_id\":\"3\",\"description\":\"Atque maxime consequ\",\"no_of_leave_days_requested\":\"26\",\"date_of_absence_from\":\"2024-03-12\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-12 10:47:24\",\"date_of_leave\":\"pending\",\"approved_by\":\"1\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\\/6\\/edit\"}', '2024-03-12 07:47:36', '2024-03-12 07:47:36'),
(1019, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 07:47:37', '2024-03-12 07:47:37'),
(1020, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 08:02:46', '2024-03-12 08:02:46'),
(1021, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"2\",\"user_id\":\"10\",\"type_of_leave_id\":\"1\",\"description\":\"Culpa odit labore do\",\"no_of_leave_days_requested\":\"28\",\"date_of_absence_from\":\"2024-03-12\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-12 11:02:46\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\"}', '2024-03-12 08:02:58', '2024-03-12 08:02:58'),
(1022, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 08:02:59', '2024-03-12 08:02:59'),
(1023, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 08:05:28', '2024-03-12 08:05:28'),
(1024, 1, '_handle_action_', 'POST', '127.0.0.1', '{\"_key\":\"7\",\"_model\":\"App_Models_LeaveData\",\"_token\":\"sgWvYOgY5C0vnhdusI9cNaNrxcKZD7ODT5Cbdjg6\",\"_action\":\"Encore_Admin_Grid_Actions_Delete\",\"_input\":\"true\"}', '2024-03-12 08:05:42', '2024-03-12 08:05:42'),
(1025, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 08:05:42', '2024-03-12 08:05:42'),
(1026, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-12 08:05:46', '2024-03-12 08:05:46'),
(1027, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-12 08:05:48', '2024-03-12 08:05:48'),
(1028, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-12 08:09:33', '2024-03-12 08:09:33'),
(1029, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-13 03:29:08', '2024-03-13 03:29:08'),
(1030, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:30:08', '2024-03-13 03:30:08'),
(1031, 1, 'auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:30:14', '2024-03-13 03:30:14'),
(1032, 10, '/', 'GET', '127.0.0.1', '[]', '2024-03-13 03:33:59', '2024-03-13 03:33:59'),
(1033, 9, '/', 'GET', '127.0.0.1', '[]', '2024-03-13 03:35:00', '2024-03-13 03:35:00'),
(1034, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:35:16', '2024-03-13 03:35:16'),
(1035, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:35:19', '2024-03-13 03:35:19'),
(1036, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:35:21', '2024-03-13 03:35:21'),
(1037, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:35:38', '2024-03-13 03:35:38'),
(1038, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"4\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 03:35:48', '2024-03-13 03:35:48'),
(1039, 9, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 03:35:48', '2024-03-13 03:35:48'),
(1040, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\"}', '2024-03-13 03:35:54', '2024-03-13 03:35:54'),
(1041, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 03:35:55', '2024-03-13 03:35:55'),
(1042, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-03-13 03:36:00', '2024-03-13 03:36:00'),
(1043, 10, '/', 'GET', '127.0.0.1', '[]', '2024-03-13 03:36:19', '2024-03-13 03:36:19'),
(1044, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:36:23', '2024-03-13 03:36:23'),
(1045, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:36:39', '2024-03-13 03:36:39'),
(1046, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:36:41', '2024-03-13 03:36:41'),
(1047, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:40:08', '2024-03-13 03:40:08'),
(1048, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:40:13', '2024-03-13 03:40:13'),
(1049, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:40:14', '2024-03-13 03:40:14'),
(1050, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:42:15', '2024-03-13 03:42:15'),
(1051, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:42:19', '2024-03-13 03:42:19'),
(1052, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:42:22', '2024-03-13 03:42:22'),
(1053, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:42:23', '2024-03-13 03:42:23'),
(1054, 10, 'leave-datas/1', 'GET', '127.0.0.1', '[]', '2024-03-13 03:43:17', '2024-03-13 03:43:17'),
(1055, 10, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:43:22', '2024-03-13 03:43:22'),
(1056, 10, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:43:26', '2024-03-13 03:43:26'),
(1057, 10, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:43:30', '2024-03-13 03:43:30'),
(1058, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 03:43:44', '2024-03-13 03:43:44'),
(1059, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 03:43:50', '2024-03-13 03:43:50'),
(1060, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:43:51', '2024-03-13 03:43:51'),
(1061, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:47:11', '2024-03-13 03:47:11'),
(1062, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\\/1\"}', '2024-03-13 03:47:16', '2024-03-13 03:47:16'),
(1063, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:47:16', '2024-03-13 03:47:16'),
(1064, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:48:01', '2024-03-13 03:48:01'),
(1065, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:48:05', '2024-03-13 03:48:05'),
(1066, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:48:06', '2024-03-13 03:48:06'),
(1067, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:51:26', '2024-03-13 03:51:26'),
(1068, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"1\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:51:30', '2024-03-13 03:51:30'),
(1069, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:51:30', '2024-03-13 03:51:30'),
(1070, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:53:52', '2024-03-13 03:53:52'),
(1071, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:53:59', '2024-03-13 03:53:59'),
(1072, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:54:04', '2024-03-13 03:54:04'),
(1073, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:54:04', '2024-03-13 03:54:04'),
(1074, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:58:28', '2024-03-13 03:58:28'),
(1075, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"user_id\":\"9\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 03:58:32', '2024-03-13 03:58:32'),
(1076, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 03:58:33', '2024-03-13 03:58:33'),
(1077, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:07:25', '2024-03-13 04:07:25'),
(1078, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 04:08:09', '2024-03-13 04:08:09'),
(1079, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:08:09', '2024-03-13 04:08:09'),
(1080, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:12:10', '2024-03-13 04:12:10'),
(1081, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:13:06', '2024-03-13 04:13:06'),
(1082, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:14:01', '2024-03-13 04:14:01'),
(1083, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:14:03', '2024-03-13 04:14:03'),
(1084, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 04:14:11', '2024-03-13 04:14:11'),
(1085, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:14:11', '2024-03-13 04:14:11'),
(1086, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:14:44', '2024-03-13 04:14:44'),
(1087, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:14:45', '2024-03-13 04:14:45'),
(1088, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:14:48', '2024-03-13 04:14:48'),
(1089, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"rejected\",\"reason\":null,\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 04:20:03', '2024-03-13 04:20:03'),
(1090, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:20:03', '2024-03-13 04:20:03'),
(1091, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"rejected\",\"reason\":null,\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 04:20:38', '2024-03-13 04:20:38'),
(1092, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:20:38', '2024-03-13 04:20:38'),
(1093, 9, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:22:33', '2024-03-13 04:22:33'),
(1094, 9, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 04:22:42', '2024-03-13 04:22:42'),
(1095, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:22:42', '2024-03-13 04:22:42'),
(1096, 1, 'auth/users', 'GET', '127.0.0.1', '[]', '2024-03-13 04:23:19', '2024-03-13 04:23:19'),
(1097, 1, 'leave-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:23:31', '2024-03-13 04:23:31'),
(1098, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:23:33', '2024-03-13 04:23:33'),
(1099, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:23:36', '2024-03-13 04:23:36'),
(1100, 1, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 04:23:41', '2024-03-13 04:23:41'),
(1101, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:23:41', '2024-03-13 04:23:41'),
(1102, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:23:48', '2024-03-13 04:23:48'),
(1103, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:23:52', '2024-03-13 04:23:52'),
(1104, 1, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"rejected\",\"reason\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 04:23:56', '2024-03-13 04:23:56'),
(1105, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:23:56', '2024-03-13 04:23:56'),
(1106, 1, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:24:04', '2024-03-13 04:24:04'),
(1107, 1, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"2\",\"description\":\"Nostrum possimus qu\",\"no_of_leave_days_requested\":\"14\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"approved\",\"reason\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 04:24:08', '2024-03-13 04:24:08'),
(1108, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:24:08', '2024-03-13 04:24:08'),
(1109, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:26:29', '2024-03-13 04:26:29'),
(1110, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"proceed\",\"approved_by\":\"1\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 04:26:36', '2024-03-13 04:26:36'),
(1111, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:26:37', '2024-03-13 04:26:37'),
(1112, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:28:16', '2024-03-13 04:28:16'),
(1113, 10, 'leave-datas/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:28:19', '2024-03-13 04:28:19'),
(1114, 10, 'leave-datas/1', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":\"2024-03-27\",\"approval_status\":\"rejected\",\"reason\":null,\"approved_by\":\"1\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 04:28:22', '2024-03-13 04:28:22'),
(1115, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:28:22', '2024-03-13 04:28:22'),
(1116, 10, '_handle_action_', 'POST', '127.0.0.1', '{\"_key\":\"1\",\"_model\":\"App_Models_LeaveData\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_action\":\"Encore_Admin_Grid_Actions_Delete\",\"_input\":\"true\"}', '2024-03-13 04:38:19', '2024-03-13 04:38:19'),
(1117, 10, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:38:19', '2024-03-13 04:38:19'),
(1118, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:50:59', '2024-03-13 04:50:59'),
(1119, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:53:12', '2024-03-13 04:53:12'),
(1120, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:53:14', '2024-03-13 04:53:14'),
(1121, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:53:22', '2024-03-13 04:53:22'),
(1122, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:53:24', '2024-03-13 04:53:24'),
(1123, 1, 'staff/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:53:26', '2024-03-13 04:53:26'),
(1124, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:55:55', '2024-03-13 04:55:55'),
(1125, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:57:32', '2024-03-13 04:57:32'),
(1126, 9, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 04:57:57', '2024-03-13 04:57:57'),
(1127, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"6\",\"description\":\"Ipsum laudantium at\",\"no_of_leave_days_requested\":\"8\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 07:57:57\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\"}', '2024-03-13 04:58:08', '2024-03-13 04:58:08'),
(1128, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:58:27', '2024-03-13 04:58:27'),
(1129, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_export_\":\"all\"}', '2024-03-13 04:58:40', '2024-03-13 04:58:40'),
(1130, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:59:33', '2024-03-13 04:59:33'),
(1131, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 04:59:44', '2024-03-13 04:59:44'),
(1132, 10, 'leave-datas/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 04:59:50', '2024-03-13 04:59:50'),
(1133, 10, 'leave-datas/2', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"6\",\"description\":\"Ipsum laudantium at\",\"no_of_leave_days_requested\":\"8\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 07:57:57\",\"date_of_leave\":null,\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 04:59:55', '2024-03-13 04:59:55'),
(1134, 10, 'leave-datas/2/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 04:59:56', '2024-03-13 04:59:56'),
(1135, 10, 'leave-datas/2', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"6\",\"description\":\"Ipsum laudantium at\",\"no_of_leave_days_requested\":\"8\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 07:57:57\",\"date_of_leave\":null,\"approval_status\":\"rejected\",\"reason\":null,\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 05:00:11', '2024-03-13 05:00:11'),
(1136, 10, 'leave-datas/2/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 05:00:12', '2024-03-13 05:00:12'),
(1137, 10, 'leave-datas/2/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 05:03:53', '2024-03-13 05:03:53'),
(1138, 10, 'leave-datas/2', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"5\",\"description\":\"Hic error facilis om\",\"no_of_leave_days_requested\":\"7\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 06:35:38\",\"date_of_leave\":null,\"approval_status\":\"proceed\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:03:58', '2024-03-13 05:03:58'),
(1139, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:03:58', '2024-03-13 05:03:58'),
(1140, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:04:06', '2024-03-13 05:04:06'),
(1141, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:04:19', '2024-03-13 05:04:19'),
(1142, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:04:22', '2024-03-13 05:04:22'),
(1143, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:04:28', '2024-03-13 05:04:28'),
(1144, 10, 'leave-datas/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:04:35', '2024-03-13 05:04:35'),
(1145, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:09:50', '2024-03-13 05:09:50'),
(1146, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:09:54', '2024-03-13 05:09:54'),
(1147, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"2\",\"description\":\"Neque alias repellen\",\"no_of_leave_days_requested\":\"1\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-13 08:09:54\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:10:02', '2024-03-13 05:10:02'),
(1148, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:10:08', '2024-03-13 05:10:08'),
(1149, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:10:18', '2024-03-13 05:10:18'),
(1150, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:10:21', '2024-03-13 05:10:21'),
(1151, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:10:22', '2024-03-13 05:10:22'),
(1152, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:10:30', '2024-03-13 05:10:30'),
(1153, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:10:33', '2024-03-13 05:10:33'),
(1154, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:12:22', '2024-03-13 05:12:22'),
(1155, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:13:11', '2024-03-13 05:13:11'),
(1156, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:13:33', '2024-03-13 05:13:33'),
(1157, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:15:47', '2024-03-13 05:15:47'),
(1158, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:21:24', '2024-03-13 05:21:24'),
(1159, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:25:05', '2024-03-13 05:25:05'),
(1160, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:27:17', '2024-03-13 05:27:17'),
(1161, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:29:52', '2024-03-13 05:29:52'),
(1162, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:35:02', '2024-03-13 05:35:02'),
(1163, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:35:09', '2024-03-13 05:35:09'),
(1164, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:35:41', '2024-03-13 05:35:41'),
(1165, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:35:46', '2024-03-13 05:35:46'),
(1166, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:37:05', '2024-03-13 05:37:05'),
(1167, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:37:59', '2024-03-13 05:37:59'),
(1168, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:38:06', '2024-03-13 05:38:06'),
(1169, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:38:08', '2024-03-13 05:38:08'),
(1170, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id_display\":\"2\",\"user_id\":\"10\",\"staff_id\":\"STF\\/CUAMM\\/184323\",\"type_of_leave_id\":\"2\",\"description\":\"Incidunt eos venia\",\"no_of_leave_days_requested\":\"9\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 08:38:08\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:38:19', '2024-03-13 05:38:19'),
(1171, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:38:19', '2024-03-13 05:38:19'),
(1172, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:38:27', '2024-03-13 05:38:27'),
(1173, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:38:48', '2024-03-13 05:38:48'),
(1174, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:40:19', '2024-03-13 05:40:19'),
(1175, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"employee_signature\":\"2\",\"user_id\":\"10\",\"staff_id\":\"STF\\/CUAMM\\/184323\",\"type_of_leave_id\":\"3\",\"description\":\"Voluptatibus eum at\",\"no_of_leave_days_requested\":\"12\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-13 08:40:19\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\"}', '2024-03-13 05:40:30', '2024-03-13 05:40:30'),
(1176, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:40:36', '2024-03-13 05:40:36'),
(1177, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:40:39', '2024-03-13 05:40:39'),
(1178, 10, 'leave-datas/2/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 05:40:58', '2024-03-13 05:40:58'),
(1179, 10, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:41:03', '2024-03-13 05:41:03'),
(1180, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:41:21', '2024-03-13 05:41:21'),
(1181, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:41:46', '2024-03-13 05:41:46'),
(1182, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"1\",\"description\":\"Consequuntur deserun\",\"no_of_leave_days_requested\":\"144\",\"date_of_absence_from\":\"2024-04-06\",\"i_delegated_my_duties_to\":\"3\",\"date_of_request\":\"2024-03-13 08:41:46\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:42:10', '2024-03-13 05:42:10'),
(1183, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:42:16', '2024-03-13 05:42:16'),
(1184, 9, '_handle_action_', 'POST', '127.0.0.1', '{\"_key\":\"3\",\"_model\":\"App_Models_LeaveData\",\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_action\":\"Encore_Admin_Grid_Actions_Delete\",\"_input\":\"true\"}', '2024-03-13 05:42:25', '2024-03-13 05:42:25'),
(1185, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:42:25', '2024-03-13 05:42:25'),
(1186, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:43:28', '2024-03-13 05:43:28'),
(1187, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"employee_signature\":\"1\",\"user_id\":\"9\",\"staff_id\":\"STF\\/CUAMM\\/1843\",\"type_of_leave_id\":\"3\",\"description\":\"Possimus corporis e\",\"no_of_leave_days_requested\":\"279\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-13 08:43:28\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:43:42', '2024-03-13 05:43:42'),
(1188, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:43:42', '2024-03-13 05:43:42'),
(1189, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:47:30', '2024-03-13 05:47:30'),
(1190, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:47:36', '2024-03-13 05:47:36'),
(1191, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:47:43', '2024-03-13 05:47:43'),
(1192, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"employee_signature\":\"2\",\"user_id\":\"10\",\"staff_id\":\"STF\\/CUAMM\\/184323\",\"type_of_leave_id\":\"2\",\"description\":\"Repellendus Vero ut\",\"no_of_leave_days_requested\":\"200\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-13 08:47:43\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\"}', '2024-03-13 05:48:29', '2024-03-13 05:48:29'),
(1193, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:48:30', '2024-03-13 05:48:30'),
(1194, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:48:35', '2024-03-13 05:48:35'),
(1195, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:48:43', '2024-03-13 05:48:43'),
(1196, 10, 'leave-datas/1,2', 'DELETE', '127.0.0.1', '{\"_method\":\"delete\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\"}', '2024-03-13 05:49:14', '2024-03-13 05:49:14'),
(1197, 10, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:49:15', '2024-03-13 05:49:15'),
(1198, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:52:53', '2024-03-13 05:52:53'),
(1199, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:52:56', '2024-03-13 05:52:56'),
(1200, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"5\",\"description\":\"Delectus ipsum per\",\"no_of_leave_days_requested\":\"16\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-13 08:52:56\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:53:01', '2024-03-13 05:53:01'),
(1201, 9, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:53:01', '2024-03-13 05:53:01'),
(1202, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"5\",\"description\":\"Delectus ipsum per\",\"no_of_leave_days_requested\":\"4\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"1\",\"date_of_request\":\"2024-03-13 08:52:56\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\"}', '2024-03-13 05:53:10', '2024-03-13 05:53:10'),
(1203, 9, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:53:11', '2024-03-13 05:53:11'),
(1204, 9, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:54:39', '2024-03-13 05:54:39'),
(1205, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"6\",\"description\":\"Autem qui voluptatem\",\"no_of_leave_days_requested\":\"6\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:54:39\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\"}', '2024-03-13 05:54:44', '2024-03-13 05:54:44'),
(1206, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:54:50', '2024-03-13 05:54:50'),
(1207, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:54:54', '2024-03-13 05:54:54'),
(1208, 1, 'leave-datas/4', 'DELETE', '127.0.0.1', '{\"_method\":\"delete\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\"}', '2024-03-13 05:55:03', '2024-03-13 05:55:03'),
(1209, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:55:03', '2024-03-13 05:55:03'),
(1210, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:55:06', '2024-03-13 05:55:06'),
(1211, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:55:10', '2024-03-13 05:55:10'),
(1212, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:55:12', '2024-03-13 05:55:12'),
(1213, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"3\",\"description\":\"Voluptas reprehender\",\"no_of_leave_days_requested\":\"1\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:12\",\"date_of_leave\":null,\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:55:16', '2024-03-13 05:55:16'),
(1214, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:55:22', '2024-03-13 05:55:22'),
(1215, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:55:31', '2024-03-13 05:55:31'),
(1216, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:55:33', '2024-03-13 05:55:33'),
(1217, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"employee_signature\":\"2\",\"user_id\":\"10\",\"staff_id\":\"STF\\/CUAMM\\/184323\",\"type_of_leave_id\":\"4\",\"description\":\"Animi aut quia even\",\"no_of_leave_days_requested\":\"27\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:33\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:55:42', '2024-03-13 05:55:42'),
(1218, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:55:42', '2024-03-13 05:55:42'),
(1219, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"employee_signature\":\"2\",\"user_id\":null,\"staff_id\":null,\"type_of_leave_id\":\"4\",\"description\":\"Animi aut quia even\",\"no_of_leave_days_requested\":\"2\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:33\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\"}', '2024-03-13 05:55:48', '2024-03-13 05:55:48'),
(1220, 1, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 05:55:49', '2024-03-13 05:55:49'),
(1221, 1, 'leave-datas', 'POST', '127.0.0.1', '{\"employee_signature\":\"2\",\"user_id\":\"10\",\"staff_id\":\"STF\\/CUAMM\\/184323\",\"type_of_leave_id\":\"4\",\"description\":\"Animi aut quia even\",\"no_of_leave_days_requested\":\"2\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:33\",\"date_of_leave\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\"}', '2024-03-13 05:56:11', '2024-03-13 05:56:11'),
(1222, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:56:16', '2024-03-13 05:56:16'),
(1223, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:56:54', '2024-03-13 05:56:54'),
(1224, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:56:59', '2024-03-13 05:56:59'),
(1225, 10, 'leave-datas/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:57:03', '2024-03-13 05:57:03'),
(1226, 10, 'leave-datas/5', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"3\",\"description\":\"Voluptas reprehender\",\"no_of_leave_days_requested\":\"1\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:12\",\"date_of_leave\":null,\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 05:57:06', '2024-03-13 05:57:06'),
(1227, 10, 'leave-datas/5/edit', 'GET', '127.0.0.1', '[]', '2024-03-13 05:57:06', '2024-03-13 05:57:06'),
(1228, 10, 'leave-datas/5', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"3\",\"description\":\"Voluptas reprehender\",\"no_of_leave_days_requested\":\"1\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:12\",\"date_of_leave\":null,\"approval_status\":\"proceed\",\"approved_by\":\"10\",\"_token\":\"tUAsp1LqvcNus1VT6eXecTCJR6EC46QenOdFPH9a\",\"_method\":\"PUT\"}', '2024-03-13 05:58:13', '2024-03-13 05:58:13'),
(1229, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:58:18', '2024-03-13 05:58:18'),
(1230, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:58:23', '2024-03-13 05:58:23'),
(1231, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 05:58:29', '2024-03-13 05:58:29'),
(1232, 9, 'leave-datas/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 05:58:34', '2024-03-13 05:58:34'),
(1233, 9, 'leave-datas/5', 'GET', '127.0.0.1', '[]', '2024-03-13 05:59:24', '2024-03-13 05:59:24'),
(1234, 9, 'leave-datas/5', 'GET', '127.0.0.1', '[]', '2024-03-13 05:59:42', '2024-03-13 05:59:42'),
(1235, 9, 'leave-datas/5', 'GET', '127.0.0.1', '[]', '2024-03-13 06:00:24', '2024-03-13 06:00:24'),
(1236, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:00:31', '2024-03-13 06:00:31'),
(1237, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:00:36', '2024-03-13 06:00:36'),
(1238, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:08:34', '2024-03-13 06:08:34'),
(1239, 9, 'leave-datas/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:08:37', '2024-03-13 06:08:37'),
(1240, 9, 'leave-datas/5', 'GET', '127.0.0.1', '[]', '2024-03-13 06:08:40', '2024-03-13 06:08:40'),
(1241, 9, 'leave-datas/5', 'GET', '127.0.0.1', '[]', '2024-03-13 06:08:43', '2024-03-13 06:08:43'),
(1242, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:08:45', '2024-03-13 06:08:45'),
(1243, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:08:48', '2024-03-13 06:08:48'),
(1244, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:10:03', '2024-03-13 06:10:03'),
(1245, 9, 'leave-datas/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:10:06', '2024-03-13 06:10:06'),
(1246, 9, 'leave-datas/5', 'GET', '127.0.0.1', '[]', '2024-03-13 06:10:08', '2024-03-13 06:10:08');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(1247, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:10:10', '2024-03-13 06:10:10'),
(1248, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:10:16', '2024-03-13 06:10:16'),
(1249, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:10:38', '2024-03-13 06:10:38'),
(1250, 1, 'leave-datas/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:11:31', '2024-03-13 06:11:31'),
(1251, 1, 'leave-datas/5', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"3\",\"description\":\"Voluptas reprehender\",\"no_of_leave_days_requested\":\"1\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:12\",\"date_of_leave\":null,\"approval_status\":\"approved\",\"reason\":null,\"approved_by\":\"10\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 06:11:37', '2024-03-13 06:11:37'),
(1252, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:11:45', '2024-03-13 06:11:45'),
(1253, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:11:49', '2024-03-13 06:11:49'),
(1254, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:11:54', '2024-03-13 06:11:54'),
(1255, 9, 'leave-datas/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:11:59', '2024-03-13 06:11:59'),
(1256, 9, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:12:02', '2024-03-13 06:12:02'),
(1257, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:12:04', '2024-03-13 06:12:04'),
(1258, 10, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:12:11', '2024-03-13 06:12:11'),
(1259, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:12:27', '2024-03-13 06:12:27'),
(1260, 1, 'leave-datas/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:12:31', '2024-03-13 06:12:31'),
(1261, 1, 'leave-datas/6', 'PUT', '127.0.0.1', '{\"type_of_leave_id\":\"4\",\"description\":\"Animi aut quia even\",\"no_of_leave_days_requested\":\"2\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 08:55:33\",\"date_of_leave\":null,\"approval_status\":\"approved\",\"reason\":null,\"approved_by\":\"1\",\"_token\":\"XFYSmjbYeFtIUIY7H87s2LUHTcbegNsezitMCnvt\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 06:12:45', '2024-03-13 06:12:45'),
(1262, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:12:51', '2024-03-13 06:12:51'),
(1263, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:13:03', '2024-03-13 06:13:03'),
(1264, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:13:44', '2024-03-13 06:13:44'),
(1265, 1, 'auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:23:29', '2024-03-13 06:23:29'),
(1266, 1, 'auth/roles', 'GET', '127.0.0.1', '[]', '2024-03-13 06:50:36', '2024-03-13 06:50:36'),
(1267, 1, 'leave-types', 'GET', '127.0.0.1', '[]', '2024-03-13 06:50:41', '2024-03-13 06:50:41'),
(1268, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:50:43', '2024-03-13 06:50:43'),
(1269, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:50:46', '2024-03-13 06:50:46'),
(1270, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:50:48', '2024-03-13 06:50:48'),
(1271, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:51:45', '2024-03-13 06:51:45'),
(1272, 1, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:51:47', '2024-03-13 06:51:47'),
(1273, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:52:37', '2024-03-13 06:52:37'),
(1274, 9, 'leave-datas/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-13 06:52:39', '2024-03-13 06:52:39'),
(1275, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"5\",\"description\":\"Consequatur Itaque\",\"no_of_leave_days_requested\":\"17\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 09:52:39\",\"date_of_leave\":null,\"supervisor_id\":\"10\",\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/leave-datas\"}', '2024-03-13 06:52:46', '2024-03-13 06:52:46'),
(1276, 9, 'leave-datas/create', 'GET', '127.0.0.1', '[]', '2024-03-13 06:52:46', '2024-03-13 06:52:46'),
(1277, 9, 'leave-datas', 'POST', '127.0.0.1', '{\"staff_id\":\"STF\\/CUAMM\\/1843\",\"user_id\":\"9\",\"type_of_leave_id\":\"5\",\"description\":\"Consequatur Itaque\",\"no_of_leave_days_requested\":\"1\",\"date_of_absence_from\":\"2024-03-13\",\"i_delegated_my_duties_to\":\"2\",\"date_of_request\":\"2024-03-13 09:52:39\",\"date_of_leave\":null,\"supervisor_id\":\"10\",\"_token\":\"aeLU0VrA65VHSH6udLA5CkM93fE7q4v6KikQT3d7\"}', '2024-03-13 06:52:52', '2024-03-13 06:52:52'),
(1278, 9, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-13 06:53:02', '2024-03-13 06:53:02'),
(1279, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"S0pXUyZhIMqpgxUi6emAI1aSAnI9XAg8LbMVpI12\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 06:40:47', '2024-03-18 06:40:47'),
(1280, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"pEk4Z7wQAT6TXboixD5ImtNeD1iH2IER8y7E7WoO\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 06:40:50', '2024-03-18 06:40:50'),
(1281, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"q1RXOmbMOc7mWVF8CjG984bYt0uAukGOCIsG46y4\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 06:40:55', '2024-03-18 06:40:55'),
(1282, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"aRi21aWskMm94cA8z95gRJVujvOBadfsTP9b947T\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 06:40:57', '2024-03-18 06:40:57'),
(1283, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"A5xEkVYfcHZyeIzNv0w3DT35Vvs1T7QvVpHY5Jzt\",\"username\":\"admin\",\"password\":\"adminooo\"}', '2024-03-18 06:41:07', '2024-03-18 06:41:07'),
(1284, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"A5xEkVYfcHZyeIzNv0w3DT35Vvs1T7QvVpHY5Jzt\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 06:41:15', '2024-03-18 06:41:15'),
(1285, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"SH5N5EdBiV68WdVD1GxpT3hDvWOyR8WUHO4FydQL\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 07:00:40', '2024-03-18 07:00:40'),
(1286, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"O6rVWcMuYMAFRZcHF1tyJ1REiDYsNrSo6E67JBnD\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 07:01:23', '2024-03-18 07:01:23'),
(1287, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:23', '2024-03-18 07:01:23'),
(1288, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:24', '2024-03-18 07:01:24'),
(1289, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:24', '2024-03-18 07:01:24'),
(1290, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:24', '2024-03-18 07:01:24'),
(1291, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:24', '2024-03-18 07:01:24'),
(1292, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:24', '2024-03-18 07:01:24'),
(1293, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:25', '2024-03-18 07:01:25'),
(1294, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:25', '2024-03-18 07:01:25'),
(1295, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:25', '2024-03-18 07:01:25'),
(1296, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:25', '2024-03-18 07:01:25'),
(1297, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:26', '2024-03-18 07:01:26'),
(1298, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:26', '2024-03-18 07:01:26'),
(1299, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:26', '2024-03-18 07:01:26'),
(1300, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:26', '2024-03-18 07:01:26'),
(1301, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:26', '2024-03-18 07:01:26'),
(1302, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:27', '2024-03-18 07:01:27'),
(1303, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:27', '2024-03-18 07:01:27'),
(1304, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:27', '2024-03-18 07:01:27'),
(1305, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:27', '2024-03-18 07:01:27'),
(1306, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:29', '2024-03-18 07:01:29'),
(1307, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:29', '2024-03-18 07:01:29'),
(1308, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:29', '2024-03-18 07:01:29'),
(1309, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:29', '2024-03-18 07:01:29'),
(1310, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:30', '2024-03-18 07:01:30'),
(1311, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:30', '2024-03-18 07:01:30'),
(1312, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:30', '2024-03-18 07:01:30'),
(1313, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:30', '2024-03-18 07:01:30'),
(1314, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:30', '2024-03-18 07:01:30'),
(1315, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:31', '2024-03-18 07:01:31'),
(1316, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:31', '2024-03-18 07:01:31'),
(1317, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:31', '2024-03-18 07:01:31'),
(1318, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:31', '2024-03-18 07:01:31'),
(1319, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:31', '2024-03-18 07:01:31'),
(1320, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:32', '2024-03-18 07:01:32'),
(1321, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:32', '2024-03-18 07:01:32'),
(1322, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:32', '2024-03-18 07:01:32'),
(1323, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:32', '2024-03-18 07:01:32'),
(1324, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:32', '2024-03-18 07:01:32'),
(1325, 1, 'auth/login', 'GET', '127.0.0.1', '[]', '2024-03-18 07:01:33', '2024-03-18 07:01:33'),
(1326, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"b80A6ta0L9ebN19KIBqYeiJUKUMhkKraLJqh3TqG\",\"username\":\"admin\",\"password\":\"admin\"}', '2024-03-18 07:02:53', '2024-03-18 07:02:53'),
(1327, 1, '/', 'GET', '127.0.0.1', '[]', '2024-03-18 07:10:56', '2024-03-18 07:10:56'),
(1328, 1, '/', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-18 07:11:46', '2024-03-18 07:11:46'),
(1329, 1, 'staff', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-18 07:11:48', '2024-03-18 07:11:48'),
(1330, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-18 07:11:56', '2024-03-18 07:11:56'),
(1331, 1, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-18 07:13:01', '2024-03-18 07:13:01'),
(1332, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-18 07:13:04', '2024-03-18 07:13:04'),
(1333, 1, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-03-18 07:13:16', '2024-03-18 07:13:16'),
(1334, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-03-19 04:56:46', '2024-03-19 04:56:46'),
(1335, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-04-05 01:52:03', '2024-04-05 01:52:03'),
(1336, 1, 'auth/login', 'POST', '127.0.0.1', '{\"_token\":\"K3se3KlJpOOuc7Rc9PQKv9vw5ABdPxaYhJgNiUau\",\"email\":\"admin@gmail.com\",\"password\":\"admin\"}', '2024-04-05 01:53:20', '2024-04-05 01:53:20'),
(1337, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-04-05 01:53:21', '2024-04-05 01:53:21'),
(1338, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 01:53:31', '2024-04-05 01:53:31'),
(1339, 1, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 01:54:23', '2024-04-05 01:54:23'),
(1340, 1, 'leave-datas', 'GET', '127.0.0.1', '[]', '2024-04-05 02:13:50', '2024-04-05 02:13:50'),
(1341, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 02:14:06', '2024-04-05 02:14:06'),
(1342, 1, 'auth/menu/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 02:14:22', '2024-04-05 02:14:22'),
(1343, 1, 'auth/menu/1', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Dashboard\",\"icon\":\"fa-bar-chart\",\"uri\":\"\\/dashboard\",\"roles\":[null],\"permission\":null,\"_token\":\"1nC1LTL8lMeqxAhjJUPcYdHtjWB0hwJr2uSxLTwJ\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/127.0.0.1:8000\\/auth\\/menu\"}', '2024-04-05 02:14:31', '2024-04-05 02:14:31'),
(1344, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-04-05 02:14:32', '2024-04-05 02:14:32'),
(1345, 1, 'auth/menu', 'GET', '127.0.0.1', '[]', '2024-04-05 02:14:36', '2024-04-05 02:14:36'),
(1346, 1, 'dashboard', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 02:14:41', '2024-04-05 02:14:41'),
(1347, 1, 'auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 02:17:10', '2024-04-05 02:17:10'),
(1348, 1, 'auth/menu/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 02:17:42', '2024-04-05 02:17:42'),
(1349, 1, 'leave-datas', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 02:18:28', '2024-04-05 02:18:28'),
(1350, 1, 'auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2024-04-05 02:18:32', '2024-04-05 02:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`) VALUES
(1, 'All permission', '*', '', '*', NULL, NULL),
(2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL),
(3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL),
(4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL),
(5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL),
(6, 'Staff management', 'staff', '', '/staff*', '2024-02-13 08:13:22', '2024-03-01 05:37:11'),
(7, 'Leave Requests', 'leave', '', '/leave-datas*', '2024-02-13 08:14:12', '2024-02-13 10:44:20'),
(8, 'Leave Types', 'leave_types', '', '/leave-types*', '2024-02-13 08:14:44', '2024-03-01 05:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', '2024-02-13 07:22:17', '2024-02-13 07:22:17'),
(2, 'Supervisor', 'supervisor', '2024-02-13 07:37:10', '2024-02-13 07:37:10'),
(3, 'Staff', 'staff', '2024-02-13 07:37:28', '2024-02-13 07:37:28'),
(4, 'HR', 'caumm', '2024-02-13 07:38:50', '2024-03-01 04:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_menu`
--

CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_role_menu`
--

INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 10, NULL, NULL),
(4, 10, NULL, NULL),
(1, 3, NULL, NULL),
(1, 4, NULL, NULL),
(1, 6, NULL, NULL),
(1, 7, NULL, NULL),
(1, 5, NULL, NULL),
(1, 2, NULL, NULL),
(1, 8, NULL, NULL),
(4, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_permissions`
--

CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(4, 3, NULL, NULL),
(4, 4, NULL, NULL),
(1, 4, NULL, NULL),
(1, 2, NULL, NULL),
(1, 3, NULL, NULL),
(1, 1, NULL, NULL),
(1, 5, NULL, NULL),
(4, 2, NULL, NULL),
(4, 6, NULL, NULL),
(4, 7, NULL, NULL),
(4, 8, NULL, NULL),
(3, 2, NULL, NULL),
(3, 3, NULL, NULL),
(3, 4, NULL, NULL),
(3, 7, NULL, NULL),
(2, 2, NULL, NULL),
(2, 3, NULL, NULL),
(2, 4, NULL, NULL),
(2, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_users`
--

CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_role_users`
--

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(4, 2, NULL, NULL),
(3, 5, '2024-02-13 10:12:14', '2024-02-13 10:12:14'),
(2, 6, NULL, NULL),
(4, 7, NULL, NULL),
(3, 8, '2024-03-06 03:49:02', '2024-03-06 03:49:02'),
(3, 9, '2024-03-12 06:37:17', '2024-03-12 06:37:17'),
(2, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `staff_id`, `email`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$xOJXYG31NJdswkrWHTXZGeNyWO2OOT4ubQ5ltjJ4/XZ4l/s2Dtd/O', 'Administrator', NULL, NULL, 'admin@gmail.com', 'SVxNEbSRkIn1x8hFQeL2IUedPebT1vjKAjW1RFVtk7vTqdRmvKHXD8qW5v2v', '2024-02-13 07:22:17', '2024-02-13 07:22:17'),
(2, 'caumm', '$2y$12$wtCP7wzjx8ZAAtl7sgvFDOpoTJBOn4qAZ.p2fAbQNQoeleayLUmOq', 'Priscilla', 'images/Amokol Priscilla.jpeg', NULL, 'amokkkolpriscilla@gmail.com', 'UBCFd6I0RD2Bv4FEKOKCcow3gH41AXSmspZXYpf94Np9qpI1PwLQoinCMS9Q', '2024-02-13 07:39:45', '2024-02-14 11:55:13'),
(9, 'STF/CUAMM/1843', '$2y$12$c/N1nNiNBBSiT9kO8hUYVOtiduvDBdpy.8KO3ETbqnzksPbWV8y4O', 'Kirestin Kramer', 'images/default_image.png', 1, 'amokolpriscilla@gmail.com', '6U5GWtsraJm3NCCwYdKIn4rOgWWBwELqVAKs5IokN8XmxjHyAKDGLJRSOmO0', '2024-03-12 06:37:17', '2024-03-18 08:05:50'),
(10, 'STF/CUAMM/184323', '$2y$12$/i8uLf0nyIkrq6IiAycg9OxumFMwvoTiLdlamcDobgFQ50d6iAEuy', 'Henry Morrow', 'images/default_image.png', 2, 'amgokolpriscilla@gmail.com', 'S3Ln38R6UGR4vWg9w2hMJvk0RAFbwGCXn1s9N7EhLs5qEdtHuVwAGCvzEpky', '2024-03-12 06:41:23', '2024-03-12 06:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_permissions`
--

CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave_credits`
--

CREATE TABLE `employee_leave_credits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `leave_days_used` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_days_remaining` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
-- Error reading structure for table leave_management.failed_jobs: #1932 - Table &#039;leave_management.failed_jobs&#039; doesn&#039;t exist in engine
-- Error reading data for table leave_management.failed_jobs: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `leave_management`.`failed_jobs`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `leave_data`
--

CREATE TABLE `leave_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type_of_leave_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_leave_days_requested` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_absence_from` date DEFAULT NULL,
  `i_delegated_my_duties_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature_of_delegated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_leave` date DEFAULT NULL,
  `date_of_request` datetime DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `supervisor_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_data`
--

INSERT INTO `leave_data` (`id`, `staff_id`, `user_id`, `type_of_leave_id`, `description`, `no_of_leave_days_requested`, `date_of_absence_from`, `i_delegated_my_duties_to`, `signature_of_delegated`, `employee_signature`, `date_of_leave`, `date_of_request`, `approval_status`, `reason`, `approved_by`, `supervisor_id`, `created_at`, `updated_at`) VALUES
(1, 'STF/CUAMM/1843', 9, 5, 'Consequatur Itaque', '1', '2024-03-13', '2', NULL, NULL, NULL, '2024-03-13 09:52:39', 'pending', NULL, NULL, 10, '2024-03-13 06:52:52', '2024-03-13 06:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_leave_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `leave_type_name`, `description`, `no_of_leave_days`, `created_at`, `updated_at`) VALUES
(1, 'Pregnancy', 'Maternal leave - Default are 60 days', '60', '2024-02-13 10:52:16', '2024-03-01 05:02:46'),
(2, 'Annual', 'Annual Leave granted for general reasons', '30', '2024-02-13 10:52:35', '2024-03-01 05:03:38'),
(3, 'Sick', 'Sick Leave', '5', '2024-02-13 10:52:52', '2024-03-01 05:04:44'),
(4, 'Paternity', 'Paternity Leave', '4', '2024-03-01 05:05:28', '2024-03-01 05:05:28'),
(5, 'Study', 'Study Leave', '10', '2024-03-01 05:05:54', '2024-03-01 05:05:54'),
(6, 'Compasssion', 'Compassion Leave', '7', '2024-03-01 05:06:24', '2024-03-01 05:06:24');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2016_01_03_100251_create_staff_table', 1),
(4, '2016_01_04_173148_create_admin_tables', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_02_13_100307_create_leave_types_table', 1),
(15, '2024_02_14_080405_create_notifications_table', 6),
(16, '2024_02_13_100330_create_employee_leave_credits_table', 7),
(17, '2024_02_13_100357_create_leave_data_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `receiver_id` int(10) UNSIGNED DEFAULT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `created_at`, `updated_at`, `receiver_id`, `role_id`, `message`, `form_link`, `link`, `model`, `model_id`) VALUES
(9, '2024-03-13 06:12:45', '2024-03-13 06:12:45', 10, NULL, 'Dear Henry Morrow, your leave request has been accepted.', 'http://127.0.0.1:8000/leave-datas/6', 'http://127.0.0.1:8000/auth/login', 'LeaveData', 6),
(10, '2024-03-13 06:52:52', '2024-03-13 06:52:52', NULL, 1, 'New leave request has been submitted byKirestin Kramer ', 'http://127.0.0.1:8000/leave-datas/1/edit', 'http://127.0.0.1:8000/auth/login', 'LeaveData', 1),
(11, '2024-03-13 06:52:53', '2024-03-13 06:52:53', NULL, 2, 'New leave request has been submitted byKirestin Kramer ', 'http://127.0.0.1:8000/leave-datas/1/edit', 'http://127.0.0.1:8000/auth/login', 'LeaveData', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appraisal_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_of_kin_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_of_kin_relationship` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_of_kin_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nssf_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duty_station` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `firstname`, `lastname`, `dob`, `email`, `phone_number`, `contract_start_date`, `contract_end_date`, `appraisal_date`, `next_of_kin_name`, `next_of_kin_relationship`, `next_of_kin_contact`, `home_district`, `nssf_number`, `tin_number`, `job_title`, `duty_station`, `employee_status`, `profile_picture`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'STF/CUAMM/1843', 'Kirestin', 'Kramer', '2024-03-13', 'pevik@mailinator.com', '+1 (191) 267-8839', '2024-03-26', '2024-04-06', '2024-03-22', 'Tatum Carey', 'Eveniet est excepte', '+1 (191) 267-8839', 'Voluptatem Ut hic v', '501', '280', 'Sunt tempor sed et', 'Unde qui veniam est', 'Repellendus Incidid', NULL, NULL, '2024-03-12 06:37:16', '2024-03-12 06:37:16'),
(2, 'STF/CUAMM/184323', 'Henry', 'Morrow', '2024-03-21', 'fitugase@mailinator.com', '+1 (457) 353-5853', '2024-04-06', '2024-03-30', '2024-04-06', 'Deborah Maddox', 'Sit ducimus alias', '+1 (457) 353-5853', 'Qui possimus quae c', '664', '638', 'Est velit corporis', 'Omnis distinctio Se', 'Ipsum velit suscipi', NULL, NULL, '2024-03-12 06:41:23', '2024-03-12 06:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_operation_log`
--
ALTER TABLE `admin_operation_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_operation_log_user_id_index` (`user_id`);

--
-- Indexes for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_permissions_name_unique` (`name`),
  ADD UNIQUE KEY `admin_permissions_slug_unique` (`slug`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_roles_name_unique` (`name`),
  ADD UNIQUE KEY `admin_roles_slug_unique` (`slug`);

--
-- Indexes for table `admin_role_menu`
--
ALTER TABLE `admin_role_menu`
  ADD KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`);

--
-- Indexes for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`);

--
-- Indexes for table `admin_role_users`
--
ALTER TABLE `admin_role_users`
  ADD KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_username_unique` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `admin_users_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `admin_user_permissions`
--
ALTER TABLE `admin_user_permissions`
  ADD KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`);

--
-- Indexes for table `employee_leave_credits`
--
ALTER TABLE `employee_leave_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_leave_credits_user_id_foreign` (`user_id`),
  ADD KEY `employee_leave_credits_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `leave_data`
--
ALTER TABLE `leave_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_data_user_id_foreign` (`user_id`),
  ADD KEY `leave_data_type_of_leave_id_foreign` (`type_of_leave_id`),
  ADD KEY `leave_data_approved_by_foreign` (`approved_by`),
  ADD KEY `leave_data_supervisor_id_foreign` (`supervisor_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_receiver_id_foreign` (`receiver_id`),
  ADD KEY `notifications_role_id_foreign` (`role_id`),
  ADD KEY `notifications_model_id_foreign` (`model_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `admin_operation_log`
--
ALTER TABLE `admin_operation_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1351;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee_leave_credits`
--
ALTER TABLE `employee_leave_credits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_data`
--
ALTER TABLE `leave_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD CONSTRAINT `admin_users_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_leave_credits`
--
ALTER TABLE `employee_leave_credits`
  ADD CONSTRAINT `employee_leave_credits_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `employee_leave_credits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `leave_data`
--
ALTER TABLE `leave_data`
  ADD CONSTRAINT `leave_data_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `leave_data_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `leave_data_type_of_leave_id_foreign` FOREIGN KEY (`type_of_leave_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `leave_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_model_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `leave_data` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
