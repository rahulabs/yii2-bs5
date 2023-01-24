-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2023 at 07:23 AM
-- Server version: 10.9.2-MariaDB
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `countyconvention`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_301_redirect`
--

DROP TABLE IF EXISTS `tbl_301_redirect`;
CREATE TABLE IF NOT EXISTS `tbl_301_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL,
  `to` longtext NOT NULL,
  `redirect_type` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_page`
--

DROP TABLE IF EXISTS `tbl_admin_page`;
CREATE TABLE IF NOT EXISTS `tbl_admin_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `config_name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `config_value` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT 1,
  `status` tinyint(1) DEFAULT 1,
  `on_top` tinyint(1) NOT NULL DEFAULT 1,
  `main_module` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `tbl_admin_page`
--

INSERT INTO `tbl_admin_page` (`id`, `parent_id`, `config_name`, `icon`, `config_value`, `sort_order`, `status`, `on_top`, `main_module`) VALUES
(2, NULL, 'Settings', '<i class=\"fas fa-cog\"></i>', 'settings', 100, 1, 1, 1),
(4, 14, 'User Role', NULL, 'user-role', 2, 1, 1, 1),
(13, NULL, 'Pages', NULL, 'page', 1, 1, 1, 1),
(14, NULL, 'Users', '<i class=\"fas fa-users\"></i>', '#', 99, 1, 1, 1),
(15, 14, 'Users', NULL, 'users', 1, 1, 1, 1),
(16, NULL, 'Clear cache', '<i class=\"fa-solid fa-broom\"></i>', 'clear', 101, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

DROP TABLE IF EXISTS `tbl_language`;
CREATE TABLE IF NOT EXISTS `tbl_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) DEFAULT NULL,
  `image` varchar(64) DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`language_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`language_id`, `name`, `code`, `locale`, `image`, `sort_order`, `status`) VALUES
(1, 'EN', 'en-US', 'en-US', 'gb.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1627280565),
('m130524_201442_init', 1627280567),
('m190124_110200_add_verification_token_column_to_user_table', 1627280567),
('m210819_044425_create_301_redirect_table', 1629348511),
('m211230_072715_alter_page_table', 1640849401);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page`
--

DROP TABLE IF EXISTS `tbl_page`;
CREATE TABLE IF NOT EXISTS `tbl_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `page_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `page_type` int(11) NOT NULL DEFAULT 0,
  `show_on_footer` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_header` int(11) NOT NULL DEFAULT 0,
  `external_url` longtext DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`page_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_page`
--

INSERT INTO `tbl_page` (`page_id`, `parent_id`, `slug`, `page_order`, `status`, `page_type`, `show_on_footer`, `show_on_header`, `external_url`, `is_delete`, `created_at`, `updated_at`) VALUES
(3, NULL, 'account', 1, 1, 1, 0, 1, '', 1, 1640848399, 1640849690);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_description`
--

DROP TABLE IF EXISTS `tbl_page_description`;
CREATE TABLE IF NOT EXISTS `tbl_page_description` (
  `description_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`description_id`),
  KEY `language_id` (`language_id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_page_description`
--

INSERT INTO `tbl_page_description` (`description_id`, `language_id`, `page_id`, `title`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(7, 1, 3, 'Account', '<p>Account</p>\r\n', 'Account', 'Account', 'Account');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

DROP TABLE IF EXISTS `tbl_settings`;
CREATE TABLE IF NOT EXISTS `tbl_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settings_key` varchar(255) NOT NULL,
  `settings_value` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=250 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `settings_key`, `settings_value`) VALUES
(242, 'config_website_url', 'http://localhost/yii2'),
(243, 'config_name', 'yii2'),
(244, 'config_logo', ''),
(245, 'config_emails', ''),
(246, 'config_analytic', ''),
(247, 'config_title', 'yii2'),
(248, 'config_meta_description', 'yii2'),
(249, 'config_meta_keywords', 'yii2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `other_roles` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `role_id`, `other_roles`, `is_delete`, `verification_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'xlMZXqW4EOkAVH_iVanBOtEA6qMts5gh', '$2y$13$9a0o0Nbcxm8ksnCw1BED4OQaobNrbQRsR9osnfT2V5HTB.sT.jOKi', NULL, 'netradiant@gmail.com', 10, 2, '', 0, 'w_ieWKsdU5g4j1uVPWTIchpwuYLbXqEC_1627280860', 1627280860, 1674544562);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

DROP TABLE IF EXISTS `tbl_user_role`;
CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `permission` text COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`role_id`, `name`, `permission`, `is_delete`) VALUES
(1, 'Normal Users', '', 0),
(2, 'Admin Users', 'a:5:{i:0;s:1:\"4\";i:1;s:2:\"13\";i:2;s:2:\"12\";i:3;s:1:\"2\";i:4;s:1:\"3\";}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_to_pages`
--

DROP TABLE IF EXISTS `tbl_user_to_pages`;
CREATE TABLE IF NOT EXISTS `tbl_user_to_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=884 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_to_pages`
--

INSERT INTO `tbl_user_to_pages` (`id`, `role_id`, `menu_id`, `parent_id`) VALUES
(878, 2, 13, 0),
(879, 2, 14, 0),
(880, 2, 15, 14),
(881, 2, 4, 14),
(882, 2, 2, 0),
(883, 2, 16, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin_page`
--
ALTER TABLE `tbl_admin_page`
  ADD CONSTRAINT `fk-admin_page-parent_id` FOREIGN KEY (`parent_id`) REFERENCES `tbl_admin_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_page_description`
--
ALTER TABLE `tbl_page_description`
  ADD CONSTRAINT `tbl_page_description_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `tbl_page` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_page_description_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `tbl_language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_user_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
