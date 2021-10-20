-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2021 at 12:33 PM
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
(87, 8, 2, 1, 'XXL', 200, 1, '2021-10-15'),
(88, 8, 2, 1, 'L', 200, 1, '2021-10-15');

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
(1, 'men1.jpg', 1, 1),
(2, 'men2.jpg', 1, 1),
(3, 'men3.jpg', 1, 1),
(4, 'men4.jpg', 2, 1),
(5, 'men5.jpg', 2, 1);

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

INSERT INTO `product_details` (`id`, `product_name`, `product_price`, `product_oldPrice`, `product_brand`, `total_stock`, `product_desc_short`, `product_size`, `product_categories`, `product_tags`, `product_desc_long`, `product_waist`, `product_hips`, `product_weight`, `product_status`, `product_added_on`) VALUES
(1, 'Shadba Khan Stock Product', '280', 303, 1, 200, 'Decription', 'S, M, L', 'Shop / Men /Clothing', 'Men, Men Clothing, Formal Dreses', 'Long Descripton', '60 - 66, 67 - 73, 74 - 81, 82 - 88, 89 - 95', '80 - 85, 86 - 90, 91 - 95, 96 - 100', '0.5', 1, '2021-10-14'),
(2, 'Elegant Old Blazzer', '200', 220, 2, 18000, 'Decription', 'S, M, L, XL, XXL', 'Shop / Men / Clothing', 'Men, Men Clothing', 'Long Descripton', '60 - 66, 67 - 73, 74 - 81, 82 - 88, 89 - 95', '80 - 85, 86 - 90, 91 - 95, 96 - 100', '0.5', 1, '2021-10-15');

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
  `sub_category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `userLoginCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `social_title`, `firstname`, `lastname`, `password`, `user_img`, `email`, `newsletter`, `verify`, `userLoginCode`) VALUES
(6, 'Mr', 'Khan', 'Shadab', '$2y$10$gdVOUaWjBqjbADzqrJpSMuLjm2VAuyZWprCRlKmfv19NTRCyg5Pi2', 'shadab.jpg', 'sa@gmail.com', 1, 1, '28381'),
(7, 'Mr', 'Khan', 'sHADAB', '$2y$10$7sOCBGdvUY.BoV9McHG2N.vJxJWnVxBMnOCkXEdg2Q6JYu4dxMgIi', '', 'skshadabkhojo@gmail.com', 0, 0, '39800'),
(8, 'Mr', 'Khan', 'Alam', '$2y$10$/WoU5y/F9oQJPDisdHuHo.YAeRafUQISX.IYWEo/zFfu0McCVqRsu', 'shadab.jpg', 'ks615044@gmail.com', 1, 1, '14456');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `products_image`
--
ALTER TABLE `products_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_data_sheet`
--
ALTER TABLE `product_data_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_category`
--
ALTER TABLE `shop_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
