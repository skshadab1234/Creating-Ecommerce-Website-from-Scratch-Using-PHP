-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2021 at 07:50 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_full_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_img` varchar(255) NOT NULL,
  `admin_added_on` datetime NOT NULL,
  `admin_status` int(11) NOT NULL,
  `adminLoginCode` int(11) NOT NULL,
  `admin_verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin_full_name`, `admin_email`, `admin_password`, `admin_img`, `admin_added_on`, `admin_status`, `adminLoginCode`, `admin_verified`) VALUES
(1, 'Shadab Admin', 'ks615044@gmail.com', '$2y$10$c/R9GmJhRmX6s5o.9AQVUuymF4Reyk32GisneinXTkZJJyL7IKbBu', 'original.jpg', '2021-10-24 11:14:00', 1, 123456, 1);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `bid` int(11) NOT NULL,
  `brand_img` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_status` int(11) NOT NULL,
  `brand_added_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`bid`, `brand_img`, `brand_name`, `brand_status`, `brand_added_on`) VALUES
(1, 'Burberry-Logo.jpg', 'BURBERRY', 1, '2021-10-11'),
(2, 'allen-1572954710.jpeg', 'Allen Solly', 1, '2021-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `size` varchar(11) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `cart_status` int(11) NOT NULL,
  `cart_added_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `qty`, `size`, `prod_price`, `cart_status`, `cart_added_on`) VALUES
(58, 8, 74, 1, 's', 280, 1, '2021-11-04');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `Order_Id` text NOT NULL,
  `payment_user_id` int(11) NOT NULL,
  `product_id` varchar(250) NOT NULL,
  `product_varient` varchar(255) NOT NULL,
  `product_qty` varchar(255) NOT NULL,
  `delivery_charge` varchar(255) NOT NULL,
  `delivery_address_id` int(11) NOT NULL,
  `card_brand` text NOT NULL,
  `payment_country` varchar(255) NOT NULL,
  `payment_id` text NOT NULL,
  `payment_status` varchar(250) NOT NULL,
  `receipt_url` text NOT NULL,
  `amount_captured` int(11) NOT NULL,
  `payment_method` text NOT NULL,
  `fingerprint` varchar(250) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `created` varchar(255) NOT NULL,
  `added_on` date NOT NULL,
  `card_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `Order_Id`, `payment_user_id`, `product_id`, `product_varient`, `product_qty`, `delivery_charge`, `delivery_address_id`, `card_brand`, `payment_country`, `payment_id`, `payment_status`, `receipt_url`, `amount_captured`, `payment_method`, `fingerprint`, `currency`, `created`, `added_on`, `card_id`) VALUES
(89, 'ORD-9698', 8, '3,2,2,2,3', '43,,S,M,44', '2,1,5,1,1', 'Free', 4, 'Visa', 'US', 'ch_3JnORQSFNgPd2Zme1xUEwSkf', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JnORQSFNgPd2Zme1xUEwSkf/rcpt_KSJ3Q3awrFyUViD5246JEGEMrw1HUPl', 16397, 'card_1JnORMSFNgPd2ZmesBcbLkT4', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-26 04:55:35', '2021-10-26', 'card_1JnORMSFNgPd2ZmesBcbLkT4'),
(90, 'ORD-2403', 8, '2,2', 'S,M', '1,1', '500', 4, 'Visa', 'US', 'ch_3JnOlxSFNgPd2Zme1pHf1w6A', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JnOlxSFNgPd2Zme1pHf1w6A/rcpt_KSJOUtku6CbrUZ2FvHhVtW4VjOPfKy1', 900, 'card_1JnOltSFNgPd2ZmeQTs58Os2', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-25 04:55:35', '2021-10-25', 'card_1JnOltSFNgPd2ZmeQTs58Os2'),
(91, 'ORD-2932', 8, '3,2,1,2,1', '42,S,M,XXL,S', '1,1,1,1,1', 'Free', 4, 'Visa', 'US', 'ch_3JomJWSFNgPd2Zme1yHNGTVL', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JomJWSFNgPd2Zme1yHNGTVL/rcpt_KTjnAAvw8uOfmD28YgI9TRd9BRh0N8m', 7397, 'card_1JomJRSFNgPd2ZmeERSo4qvm', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-25 04:55:35', '2021-10-25', 'card_1JomJRSFNgPd2ZmeERSo4qvm'),
(92, 'ORD-7886', 8, '3,2,1,2,1', '42,S,M,XXL,S', '1,1,1,1,1', 'Free', 4, 'Visa', 'US', 'ch_3JomLVSFNgPd2Zme1yuNNsKP', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JomLVSFNgPd2Zme1yuNNsKP/rcpt_KTjpPAN72r4OLafhqhnwJPJ2W80EDtP', 7397, 'card_1JomLRSFNgPd2ZmeBlVRhSqT', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-26 04:54:35', '2021-10-26', 'card_1JomLRSFNgPd2ZmeBlVRhSqT'),
(93, 'ORD-7145', 6, '1,2,3', 'S,S,42', '1,1,1', 'Free', 4, 'Visa', 'US', 'ch_3JomNlSFNgPd2Zme19pIu964', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JomNlSFNgPd2Zme19pIu964/rcpt_KTjrKp5HDBYhSfzG7e4WetZgYIo8f93', 5198, 'card_1JomNgSFNgPd2Zme2WUQ0Xq6', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-26 04:54:35', '2021-10-26', 'card_1JomNgSFNgPd2Zme2WUQ0Xq6'),
(94, 'ORD-2288', 6, '3', '42', '1', 'Free', 4, 'Visa', 'US', 'ch_3JonmdSFNgPd2Zme0wgLpyP2', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JonmdSFNgPd2Zme0wgLpyP2/rcpt_KTlJNTvead0DPMAP6iyyWDl9uNIVMHT', 2999, 'card_1JonmZSFNgPd2ZmeOmfYqCiK', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-26 04:55:35', '2021-10-26', 'card_1JonmZSFNgPd2ZmeOmfYqCiK'),
(95, 'ORD-1509', 6, '1', 'S', '1', 'Free', 4, 'Visa', 'US', 'ch_3JonuDSFNgPd2Zme0GUDurMD', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JonuDSFNgPd2Zme0GUDurMD/rcpt_KTlRa6s5RXPpH179kQwsvxk5gxuo0uA', 1999, 'card_1JonuASFNgPd2Zmes3tOuykx', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-26 05:03:25', '2021-10-26', 'card_1JonuASFNgPd2Zmes3tOuykx'),
(96, 'ORD-9693', 8, '2', 'M', '1', '500', 5, 'Visa', 'US', 'ch_3Jp2WzSFNgPd2Zme09Hf2E8V', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3Jp2WzSFNgPd2Zme09Hf2E8V/rcpt_KU0YAgrl1GCAz43fjzA6cruc3Ue9wIh', 700, 'card_1Jp2WvSFNgPd2ZmelIdJkHoh', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-27 08:40:25', '2021-10-27', 'card_1Jp2WvSFNgPd2ZmelIdJkHoh'),
(97, 'ORD-4838', 8, '3', '42', '10', 'Free', 5, 'Visa', 'US', 'ch_3Jp2bdSFNgPd2Zme1JHWI0Rf', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3Jp2bdSFNgPd2Zme1JHWI0Rf/rcpt_KU0cHcLKy6IlsfbDVeSgywQcwYtnGix', 29990, 'card_1Jp2bZSFNgPd2ZmeSPMOtFFZ', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-27 08:45:13', '2021-10-27', 'card_1Jp2bZSFNgPd2ZmeSPMOtFFZ'),
(98, 'ORD-7166', 8, '3', '42', '1', 'Free', 5, 'Visa', 'US', 'ch_3JpBc9SFNgPd2Zme10kbaPn6', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JpBc9SFNgPd2Zme10kbaPn6/rcpt_KU9w3NfoY8yghjETc9ysJDcRbBDB5Ou', 2999, 'card_1JpBc5SFNgPd2ZmeWOeE00IS', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-27 06:22:21', '2021-10-27', 'card_1JpBc5SFNgPd2ZmeWOeE00IS'),
(99, 'ORD-2623', 8, '3', '42', '15', 'Free', 5, 'Visa', 'US', 'ch_3JpBd1SFNgPd2Zme1vcdpEFH', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JpBd1SFNgPd2Zme1vcdpEFH/rcpt_KU9wIAjUJQ0DPCIOxGHB8jHR0icKi67', 44985, 'card_1JpBcwSFNgPd2ZmedLwBZlsf', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-27 06:23:15', '2021-10-27', 'card_1JpBcwSFNgPd2ZmedLwBZlsf'),
(100, 'ORD-2618', 8, '3,2,2', '42,M,S', '8,6,15', 'Free', 5, 'Visa', 'US', 'ch_3JpnDJSFNgPd2Zme1p3Sq6Ap', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JpnDJSFNgPd2Zme1p3Sq6Ap/rcpt_KUmmVCzGIqUCqogLrwaGtr6eEFLXGoO', 28192, 'card_1JpnDHSFNgPd2ZmeY4jY12Nb', 'uxDgiVpbv4g7aFsy', 'inr', '2021-10-29 10:31:13', '2021-10-29', 'card_1JpnDHSFNgPd2ZmeY4jY12Nb'),
(101, 'ORD-1760', 8, '73', '', '1', 'Free', 5, 'Visa', 'US', 'ch_3JroQESFNgPd2Zme1AQ5K5zj', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3JroQESFNgPd2Zme1AQ5K5zj/rcpt_KWsAHqOwWRo4beVzVIANmU8mf5plj0Z', 2499, 'card_1JroQ9SFNgPd2ZmeSVRlcaUX', 'uxDgiVpbv4g7aFsy', 'inr', '2021-11-04 12:12:54', '2021-11-04', 'card_1JroQ9SFNgPd2ZmeSVRlcaUX');

-- --------------------------------------------------------

--
-- Table structure for table `products_image`
--

CREATE TABLE `products_image` (
  `id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_image`
--

INSERT INTO `products_image` (`id`, `product_img`, `product_id`, `status`) VALUES
(4, 'black-white-mens-black-and-white-corporate-dress/men1.jpg', 1, 1),
(5, 'black-white-mens-black-and-white-corporate-dress/men2.jpg', 1, 1),
(6, 'black-white-mens-black-and-white-corporate-dress/men3.jpg', 1, 1),
(14, 'elegant-old-blazzer/men4.jpg', 2, 1),
(15, 'elegant-old-blazzer/men5.jpg', 2, 1),
(16, '3-pics-sherwani-set-black-colour/3_pcs_suit_sherani.jpg', 3, 1),
(17, '3-pics-sherwani-set-black-colour/3_pcs_suit_sherwani.jpg', 3, 1),
(18, '3-pics-sherwani-set-black-colour/3pc_s46whitesilkkp1_3_33e045a8.jpg', 3, 1),
(19, '3-pics-sherwani-set-black-colour/3pc_s46whitesilkkp1_4_99a5dec5.jpg', 3, 1),
(20, '3-pics-sherwani-set-black-colour/3pc_s46whitesilkkp1_5_a5134f49.jpg', 3, 1),
(21, '3-pics-sherwani-set-black-colour/3pc_s46whitesilkkp1_6_f7ae6120.jpg', 3, 1),
(22, '3-pics-sherwani-set-black-colour/3pc_s46whitesilkkp1_7_9fe1e327.jpg', 3, 1),
(23, '3-pcs-suit-sherani/3_pcs_suit_sherani.jpg', 73, 1),
(24, '3-pcs-suit-sherani/3_pcs_suit_sherwani.jpg', 73, 1),
(25, '3-pcs-suit-sherani/3pc_s46whitesilkkp1_3_33e045a8.jpg', 73, 1),
(26, '3-pcs-suit-sherani/3pc_s46whitesilkkp1_4_99a5dec5.jpg', 73, 1),
(27, '3-pcs-suit-sherani/3pc_s46whitesilkkp1_5_a5134f49.jpg', 73, 1),
(28, '3-pcs-suit-sherani/3pc_s46whitesilkkp1_6_f7ae6120.jpg', 73, 1),
(29, '3-pcs-suit-sherani/3pc_s46whitesilkkp1_7_9fe1e327.jpg', 73, 1),
(32, 'fsher-man-t-shrts/men3.jpg', 74, 1),
(33, 'fsher-man-t-shrts/men2.jpg', 74, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_data_sheet`
--

CREATE TABLE `product_data_sheet` (
  `id` int(11) NOT NULL,
  `data_sheet_name` varchar(255) NOT NULL,
  `data_sheet_desc` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_data_sheet`
--

INSERT INTO `product_data_sheet` (`id`, `data_sheet_name`, `data_sheet_desc`, `product_id`, `status`) VALUES
(1, 'Composition', 'Melt Paper', 2, 1),
(2, 'Cotton', 'Yes', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_oldPrice` int(11) NOT NULL,
  `product_brand` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL,
  `total_sold` int(11) NOT NULL,
  `product_desc_short` varchar(500) NOT NULL,
  `product_size` varchar(255) NOT NULL,
  `product_categories` varchar(255) NOT NULL,
  `product_tags` varchar(255) NOT NULL,
  `product_desc_long` text NOT NULL,
  `product_waist` varchar(255) NOT NULL,
  `product_hips` varchar(255) NOT NULL,
  `product_weight` varchar(255) NOT NULL,
  `product_status` int(11) NOT NULL,
  `product_added_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_name`, `product_price`, `product_oldPrice`, `product_brand`, `total_stock`, `total_sold`, `product_desc_short`, `product_size`, `product_categories`, `product_tags`, `product_desc_long`, `product_waist`, `product_hips`, `product_weight`, `product_status`, `product_added_on`) VALUES
(73, '3 pcs suit sherani', '2499', 3499, 1, 25, 1, '<p>Hey Guys Grav this deal</p>', '', 'Men / Shop', '', '<p>Hey Guys Grav this deal<span style=\"font-size: 1rem;\">Hey Guys Grav this deal</span><span style=\"font-size: 1rem;\">Hey Guys Grav this deal</span><span style=\"font-size: 1rem;\">Hey Guys Grav this deal</span><span style=\"font-size: 1rem;\">Hey Guys Grav this deal</span><span style=\"font-size: 1rem;\">Hey Guys Grav this deal Long</span><br></p>', '', '', '.5', 1, '2021-11-04');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_category` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop_category`
--

CREATE TABLE `shop_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `sub_category` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_category`
--

INSERT INTO `shop_category` (`id`, `category_name`, `sub_category`, `status`) VALUES
(1, 'Men', 'Shoes, Shirts, T-shirts', 1),
(2, 'Shop', 'Shoes, Shrts, Shoks, Dresses, Laravel, Denim', 1),
(3, 'Women', 'Panda, Skirts, Dresses, Awesome Paintinmg Dresses', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `social_title` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_img` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `newsletter` int(11) NOT NULL,
  `verify` int(11) NOT NULL,
  `userLoginCode` varchar(255) NOT NULL,
  `userAdded_On` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `social_title`, `firstname`, `lastname`, `password`, `user_img`, `email`, `newsletter`, `verify`, `userLoginCode`, `userAdded_On`) VALUES
(6, 'Mr', 'Khan', 'Shadab', '$2y$10$gdVOUaWjBqjbADzqrJpSMuLjm2VAuyZWprCRlKmfv19NTRCyg5Pi2', '', 'sa@gmail.com', 1, 1, '28381', '2021-10-26'),
(7, 'Mr', 'Khan', 'sHADAB', '$2y$10$7sOCBGdvUY.BoV9McHG2N.vJxJWnVxBMnOCkXEdg2Q6JYu4dxMgIi', '', 'skshadabkhojo@gmail.com', 0, 1, '39800', '2021-10-25'),
(8, 'Mr', 'Khan', 'Alam', '$2y$10$25owsFbrbzIcDYbJqPn88.JB3Ihe/KN6RDAe6JxzsgJ.EZ8Kn0WdW', 'shadab.jpg', 'ks615044@gmail.com', 1, 1, '25266', '2021-10-19'),
(9, 'Mr', 'Khan', 'Shadab', '$2y$10$ML/mE.V4J7reGJ.F.pDg3O6S7p6ToWUqafn5qnCHl51RyGGCiUULO', '', 'kssk@gmail.com', 0, 1, '87529', '2021-10-26'),
(10, 'Mr', 'Khan', 'Sk', '$2y$10$Tc47s5tXXA88RRLLFyt8G.yivqsFt2OZL3EnZGdKIoEWuq199g4Mi', '', 'nodiyat369@koldpak.com', 0, 1, '80116', '2021-10-26'),
(11, 'Mr', 'Khan', 'Shadab', '$2y$10$gdVOUaWjBqjbADzqrJpSMuLjm2VAuyZWprCRlKmfv19NTRCyg5Pi2', '', 'mehtab@gmail.com', 1, 1, '28381', '2021-10-26'),
(12, 'Mr', 'Khan', 'sHADAB', '$2y$10$7sOCBGdvUY.BoV9McHG2N.vJxJWnVxBMnOCkXEdg2Q6JYu4dxMgIi', '', 'skshadabkhojo1@gmail.com', 0, 1, '39800', '2021-10-26');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `add_firstname` varchar(255) NOT NULL,
  `add_lastname` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `addres_complement` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `default_address` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `add_firstname`, `add_lastname`, `company`, `address`, `addres_complement`, `city`, `state`, `postal_code`, `country`, `phone_number`, `status`, `default_address`) VALUES
(4, 6, 'Khan', 'Shadab', 'Shadab DMART PVT. LTD', 'Subhash Nagar', 'Room No 104', 'Kanpur', 'Maharashtra', '400612', 'India', '7845123696', 1, 1),
(5, 8, 'Khan ', 'Shadab', 'Infosys', 'Sayeed Makan, R 105, ', '', 'Dombivali', 'Maharashtra', '400125', 'India', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wishlist_name` varchar(255) NOT NULL,
  `wishlist_prod_id` varchar(255) NOT NULL,
  `wishlist_prod_size` varchar(255) NOT NULL,
  `default_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `wishlist_name`, `wishlist_prod_id`, `wishlist_prod_size`, `default_id`, `added_on`) VALUES
(29, 7, 'Favorate', '2', '', 0, '2021-10-23 10:45:28'),
(30, 8, 'My Wishlist', '3,1,2', '', 1, '2021-10-23 23:19:28'),
(31, 10, 'My Wishlist', '1', '', 1, '2021-10-24 10:31:53'),
(32, 10, 'Jack', '3,2', '', 0, '2021-10-24 10:32:08'),
(33, 6, 'My Wishlist', '1', '', 1, '2021-10-26 15:24:44'),
(34, 8, 'New Patterns', '1,3', '', 0, '2021-11-01 07:27:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_image`
--
ALTER TABLE `products_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_data_sheet`
--
ALTER TABLE `product_data_sheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_category`
--
ALTER TABLE `shop_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `products_image`
--
ALTER TABLE `products_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_data_sheet`
--
ALTER TABLE `product_data_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_category`
--
ALTER TABLE `shop_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
