-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 17, 2019 at 05:48 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alamarit_cartbox`
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

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_slug`, `category_name`, `category_description`, `category_image`) VALUES
(1, 'smartphones', 'جوالات', 'جوالات', 'uploaded_e6ec88256f0c9e5e42c9ef62d597ecfc-1.jpg'),
(2, 'screens', 'شاشات', 'انواع مختلفة من الشاشات بأسعار مخفضة', 'screen.jpg'),
(3, 'smart_watches', 'ساعات ذكية', 'باقة متنوعة من الساعات الذكية بأسعار منافسة', 'smartwatch.jpg');

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
('EMAIL_USER_ACTIVATE', 'Email template - Activation required', '<p>عميلنا العزيز{user_name},</p>\r\n<p>الرجاء نسخ الرابط التالي ولصقة في المتصفح من أجب تنشيط الحساب - {link}</p>\r\n<p>ستنتهي صلاحية الرابط خلال  {expire} ساعة.</p>', 100),
('EMAIL_USER_FORGOT', 'Email template - Forgotten password', '<p>عميلنا العزيز{user_name},</p>\n<p>الرجاء نسخ الرابط التالي ولصقة في المتصفح من أجل تنشيط الحساب - {link}</p>\n<p>ستنتهي صلاحية الرابط خلال {expire} ساعة.</p>', 100),
('EMAIL_USER_REG', 'Email template - Successfully registered', '<p>عميلنا العزيز {user_name},</p>\n<p>لقد تم تنشيط حسابك بامكانك الان تسجيل الدخول:</p>\n<p>بالبريد التالي : {user_email}</p>\n<p>كلمة المرور : {password}</p>', 100),
('EMAIL_USER_RESET', 'Email template - Password reset', '<p>عميلنا العزيز {user_name},</p>\r\n<p>لقد تم تغيير كلمة المرور الخاصة بك بناء على طلبك. نرجو استخدام المعلومات التالية لتسجيل الدخول:</p>\r\n<p>البريد : {user_email}</p>\r\n<p>كلمة السر : {password}</p>\r\n<p>الرجاء تغيير كلمة المرور بعد تسجيل الدخول.</p>', 100),
('MAIL_FROM', 'Email sender identity', 'jalamari2018@gmail.com', 0),
('PER_PAGE', 'Number of entries per page', '30', 0),
('SITE_NAME', 'Name of your website', 'معرض اتجار', 0),
('SITE_THEME', 'Current theme.', 'd-boxx', 0),
('SLUG_ACTIVATE', 'Email activation URL', 'activate', 1),
('SLUG_ADMIN', 'Admin URL slug E.g. http://site.com/admin', 'jalamari', 1),
('SLUG_API', 'API URL slug E.g. http://site.com/api', 'api', 1),
('TITLE_USER_ACTIVATE', 'Email title - Activation required', 'الرجاء تنشيط حسابك', 101),
('TITLE_USER_FORGOT', 'Email title - Forgot password', 'استعادة كلمة المرور', 101),
('TITLE_USER_REG', 'Email title - Successfully registered', 'تم تنشيط الحساب', 101),
('TITLE_USER_RESET', 'Email title - Password reset', 'هذه هي كلمة المرور الجديدة', 101);

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `user_id`, `order_name`, `order_status`) VALUES
(1, '2019-03-15 01:54:36', 3, 'Jebreel Omar', 3),
(2, '2019-03-15 03:39:03', 1, 'Jebreel', 3),
(3, '2019-03-15 20:54:07', 3, 'Jebreel Omar', 1),
(4, '2019-03-15 20:56:44', 1, 'Jebreel', 1),
(5, '2019-03-15 21:00:13', 3, 'Jebreel Omar', 1),
(6, '2019-03-15 21:08:17', 3, 'Jebreel Omar', 1),
(7, '2019-03-15 21:54:14', 3, 'Jebreel Omar', 1),
(8, '2019-03-15 22:50:00', 3, 'Jebreel Omar', 1),
(9, '2019-03-16 20:16:05', 1, 'Jebreel', 1),
(10, '2019-03-16 20:36:09', 6, 'abumarym', 1),
(11, '2019-03-17 00:48:11', 6, 'abumarym', 1),
(12, '2019-03-17 03:44:09', 6, 'abumarym', 1),
(13, '2019-03-17 03:55:57', 6, 'abumarym', 1);

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

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`order_id`, `product_id`, `product_name`, `product_image`, `product_price`, `quantity`) VALUES
(1, 1, 'iphone xs max', 'uploaded_e6ec88256f0c9e5e42c9ef62d597ecfc-1.jpg', '4000.00', 1),
(2, 1, 'iphone xs max', 'uploaded_e6ec88256f0c9e5e42c9ef62d597ecfc-1.jpg', '4000.00', 1),
(2, 2, 'جلكسي 10', 's10.jpg', '5000.00', 1),
(3, 2, 'جلكسي 10', 's10.jpg', '5000.00', 1),
(4, 2, 'جلكسي 10', 's10.jpg', '5000.00', 1),
(5, 3, 'ايفون اكس', 'x.jpg', '3000.00', 1),
(6, 4, 'هواوي ميت', '71FqsV5b9VL._SX569_.jpg', '4500.00', 1),
(7, 3, 'ايفون اكس', 'x.jpg', '3000.00', 1),
(8, 4, 'هواوي ميت', '71FqsV5b9VL._SX569_.jpg', '4500.00', 1),
(9, 4, 'هواوي ميت', '71FqsV5b9VL._SX569_.jpg', '4500.00', 3),
(10, 7, 'ساعة ابل الجيل الأول ', 's1.jpg', '1000.00', 1),
(11, 1, 'iphone xs max', 'uploaded_e6ec88256f0c9e5e42c9ef62d597ecfc-1.jpg', '4000.00', 1),
(11, 4, 'هواوي ميت', '71FqsV5b9VL._SX569_.jpg', '4500.00', 1),
(12, 9, 'ساعة سامسونج سبورت اس 3', 'gear%20s3%20sport.jpg', '1400.00', 1),
(13, 4, 'هواوي ميت', '71FqsV5b9VL._SX569_.jpg', '4500.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_totals`
--

CREATE TABLE `orders_totals` (
  `order_id` int(11) NOT NULL,
  `total_text` varchar(255) NOT NULL,
  `total_value` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_totals`
--

INSERT INTO `orders_totals` (`order_id`, `total_text`, `total_value`) VALUES
(1, 'Grand Total', '4000.00'),
(2, 'Grand Total', '9000.00'),
(3, 'Grand Total', '5000.00'),
(4, 'Grand Total', '5000.00'),
(5, 'Grand Total', '3000.00'),
(6, 'Grand Total', '4500.00'),
(7, 'Grand Total', '3000.00'),
(8, 'Grand Total', '4500.00'),
(9, 'Grand Total', '13500.00'),
(10, 'Grand Total', '1000.00'),
(11, 'Grand Total', '8500.00'),
(12, 'Grand Total', '1400.00'),
(13, 'Grand Total', '4500.00');

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

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_slug`, `product_name`, `product_description`, `product_image`, `product_price`) VALUES
(1, 'xsmax', 'iphone xs max', 'اللون فضي المساحة ٦٤ جيجا', 'uploaded_e6ec88256f0c9e5e42c9ef62d597ecfc-1.jpg', '4000.00'),
(2, 'جلكسي 10', 'جلكسي 10', 'جهاز سامسونج كالكسي اس 10', 's10.jpg', '5000.00'),
(3, 'ايفون', 'ايفون اكس', 'ايفون اكس 64 جيجا', 'x.jpg', '3000.00'),
(4, 'هواوي', 'هواوي ميت', 'هواوي ميت 20 ', '71FqsV5b9VL._SX569_.jpg', '4500.00'),
(7, 'applewatchs1', 'ساعة ابل الجيل الأول ', 'ساعة ابل الإصدار الأول ', 's1.jpg', '1000.00'),
(8, 'applewatchs2', 'ساعة أبل الجيل الثاني', 'الاصدار الثاني من ساعة ابل - متوفرة بكل الالوان', 's2.jpg', '1500.00'),
(9, 'smsunggear', 'ساعة سامسونج سبورت اس 3', 'سامسونج قير اس 3', 'gear%20s3%20sport.jpg', '1400.00'),
(10, 'applewatchs3', 'ساعة ابل الجيل الثالث ', 'ساعة ابل الاصدار الثالث - متوفرة بكل الالوان', 's3.jpg', '2000.00'),
(11, 'huwatch', 'ساعة هواوي ', 'ساعة هواوي الذكية - عدة الوان متوفرة', 'huaeie%20.jpg', '1200.00'),
(12, 'applewatchs4', 'ساعة ابل الاصدار الرابع', 'ساعة ابل الاصدار الرابع - متوفرة بكل الالوان', 's4.jpg', '3000.00'),
(13, 'sharpscreen', 'شاسة شارب 66 انش', 'شاشة شارب ', 'sharp.jpg', '1200.00'),
(14, 'toshipa', 'شاشة توشيبا', 'شاشة توشيبا 55 انش', 'toshipa.jpg', '1500.00'),
(17, 'smasungscreen1', '  شاشة سامسونج بحجم كبير', 'شاشة سامسونج مقاس 66 انش', 'samsung.jpg', '1750.00');

-- --------------------------------------------------------

--
-- Table structure for table `products_categories`
--

CREATE TABLE `products_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_categories`
--

INSERT INTO `products_categories` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 2),
(14, 2),
(17, 2);

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
(1, 'Jebreel', 'jalamari@uccs.edu', 1, 'SoHufiszsYXs9MoyjTPXJg==', 'ADM', NULL, NULL),
(5, 'jebreel Alamari', 'jalamari2018@gmail.com', 1, 'SoHufiszsYXs9MoyjTPXJg==', 'USR', NULL, NULL),
(6, 'abumarym', 'jebreel1406@hotmail.com', 1, 'SoHufiszsYXs9MoyjTPXJg==', 'USR', NULL, NULL);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
