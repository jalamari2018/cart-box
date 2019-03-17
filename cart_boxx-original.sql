-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2018 at 09:37 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cart_boxx`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text,
  `category_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `config_key` varchar(24) NOT NULL,
  `config_desc` varchar(255) NOT NULL,
  `config_value` text NOT NULL,
  `config_group` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_key`, `config_desc`, `config_value`, `config_group`) VALUES
('ACTIVATE_EXPIRE', 'Activation email expiry in hours', '72', 0),
('CART_MAX', 'The max number you can add to cart.', '99', 0),
('EMAIL_USER_ACTIVATE', 'Email template - Activation required', '<p>Dear {user_name},</p>\n<p>Please copy-and-paste the following link in your browser to activate your account - {link}</p>\n<p>Take note that this link will expire in {expire} hours.</p>', 100),
('EMAIL_USER_FORGOT', 'Email template - Forgotten password', '<p>Dear {user_name},</p>\n<p>Please copy-and-paste the following link in your browser to reset your password - {link}</p>\n<p>Take note that this link will expire in {expire} hours.</p>', 100),
('EMAIL_USER_REG', 'Email template - Successfully registered', '<p>Dear {user_name},</p>\n<p>Thank you for registering, your account has been activated and you may sign in with the following:</p>\n<p>Email : {user_email}</p>\n<p>Password : {password}</p>', 100),
('EMAIL_USER_RESET', 'Email template - Password reset', '<p>Dear {user_name},</p>\n<p>We have reset your password at your request and you may sign in with the following:</p>\n<p>Email : {user_email}</p>\n<p>Password : {password}</p>\n<p>Please remember to change your password after you have signed in.</p>', 100),
('MAIL_FROM', 'Email sender identity', 'sys@yoursite.com', 0),
('PER_PAGE', 'Number of entries per page', '30', 0),
('SITE_NAME', 'Name of your website', 'Cart Boxx Demo', 0),
('SITE_THEME', 'Current theme.', 'd-boxx', 0),
('SLUG_ACTIVATE', 'Email activation URL', 'activate', 1),
('SLUG_ADMIN', 'Admin URL slug E.g. http://site.com/admin', 'admin', 1),
('SLUG_API', 'API URL slug E.g. http://site.com/api', 'api', 1),
('TITLE_USER_ACTIVATE', 'Email title - Activation required', 'Please activate your account', 101),
('TITLE_USER_FORGOT', 'Email title - Forgot password', 'Reset password', 101),
('TITLE_USER_REG', 'Email title - Successfully registered', 'Account activated', 101),
('TITLE_USER_RESET', 'Email title - Password reset', 'Here is your new password', 101);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `order_status` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_price` decimal(11,2) NOT NULL COMMENT 'Price of each',
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders_totals`
--

CREATE TABLE `orders_totals` (
  `order_id` int(11) NOT NULL,
  `total_text` varchar(255) NOT NULL,
  `total_value` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_slug` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text,
  `product_image` text,
  `product_price` decimal(11,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products_categories`
--

CREATE TABLE `products_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 suspended, 1 active, 2 pending activation',
  `user_password` varchar(255) NOT NULL,
  `user_level` varchar(5) NOT NULL,
  `user_hash` varchar(32) DEFAULT NULL,
  `hash_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_active`, `user_password`, `user_level`, `user_hash`, `hash_date`) VALUES
(1, 'Uvuvwevwevwe Onyetenyevwe Ugwemuhwem Osas', 'admin@cb.com', 1, 'mKKtuAryQFJ+zdY/jcSP1Q==', 'ADM', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_slug` (`category_slug`),
  ADD KEY `category_name` (`category_name`) USING BTREE;

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`config_key`),
  ADD KEY `config_group` (`config_group`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_date` (`order_date`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_status` (`order_status`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`order_id`,`product_id`);

--
-- Indexes for table `orders_totals`
--
ALTER TABLE `orders_totals`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD UNIQUE KEY `product_slug` (`product_slug`);

--
-- Indexes for table `products_categories`
--
ALTER TABLE `products_categories`
  ADD PRIMARY KEY (`product_id`,`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_active` (`user_active`),
  ADD KEY `user_level` (`user_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
