-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2021 at 07:56 PM
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
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL,
  `banner_img` varchar(255) NOT NULL,
  `banner_link` varchar(255) NOT NULL,
  `banner_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`banner_id`, `banner_img`, `banner_link`, `banner_status`) VALUES
(1, '1.jpg', '', 1),
(2, '2.jpg', '', 1);

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
(5, 8, 97, 1, 'L', 299, 1, '2021-11-08'),
(6, 8, 98, 1, 'L', 399, 1, '2021-11-08');

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
  `delivery_address_id` varchar(255) NOT NULL,
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
  `card_id` text NOT NULL,
  `tracking_id` varchar(1000) NOT NULL,
  `invoice_file` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `Order_Id`, `payment_user_id`, `product_id`, `product_varient`, `product_qty`, `delivery_charge`, `delivery_address_id`, `card_brand`, `payment_country`, `payment_id`, `payment_status`, `receipt_url`, `amount_captured`, `payment_method`, `fingerprint`, `currency`, `created`, `added_on`, `card_id`, `tracking_id`, `invoice_file`) VALUES
(11, 'ORD-2648', 8, '95', 'M', '10', 'Free', '<strong>Khan  Shadab</strong><br>\r\n    Infosys<br>\r\n    Sayeed Manzil, R 104, <br>\r\n    Dombivali, Maharashtra-400125<br>\r\n    India <br>\r\n    ', 'Visa', 'US', 'ch_3Jt6NGSFNgPd2Zme0Jrrjbw6', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3Jt6NGSFNgPd2Zme0Jrrjbw6/rcpt_KYCmyw9unMgsV1EIqXisMa6NYus3CDX', 49990, 'card_1Jt6NBSFNgPd2ZmevoKDS7tN', 'uxDgiVpbv4g7aFsy', 'inr', '2021-11-07 01:35:10', '2021-11-07', 'card_1Jt6NBSFNgPd2ZmevoKDS7tN', '612486772', 'Invoice-11-2021_11_07-015252-PS.pdf'),
(12, 'ORD-3206', 8, '95', 'S', '1', 'Free', '<strong>Khan  Shadab</strong><br>\r\n    Sahil Pvt, ltd<br>\r\n    Sayeed Manzil, R 104, Kausa, Talao Pali<br>\r\n    Dombivali, Maharashtra-400612<br>\r\n    India <br>\r\n    9875484215', 'Visa', 'US', 'ch_3Jt6WMSFNgPd2Zme0ai8V0fC', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3Jt6WMSFNgPd2Zme0ai8V0fC/rcpt_KYCwa6AzrczLUlXgaOHPU3oK5gfvf5J', 4999, 'card_1Jt6WHSFNgPd2Zme9UWHoV1r', 'uxDgiVpbv4g7aFsy', 'inr', '2021-11-07 01:44:34', '2021-11-07', 'card_1Jt6WHSFNgPd2Zme9UWHoV1r', '333332118', 'Invoice-12-2021_11_07-014437-PS.pdf'),
(13, 'ORD-9594', 8, '96', 'S', '480', 'Free', '<strong>Khan  Shadab</strong><br>\r\n    Sahil Pvt, ltd<br>\r\n    Sayeed Manzil, R 104, Kausa, Talao Pali<br>\r\n    Dombivali, Maharashtra-400612<br>\r\n    India <br>\r\n    9875484215', 'Visa', 'US', 'ch_3Jt7GSSFNgPd2Zme0BtGzmcD', 'succeeded', 'https://pay.stripe.com/receipts/acct_1JlSQwSFNgPd2Zme/ch_3Jt7GSSFNgPd2Zme0BtGzmcD/rcpt_KYDhXhk2KgDjsEJp9puvIZ0fopUMH9J', 581760, 'card_1Jt7GOSFNgPd2ZmeX3bGvExH', 'uxDgiVpbv4g7aFsy', 'inr', '2021-11-07 02:32:12', '2021-11-07', 'card_1Jt7GOSFNgPd2ZmeX3bGvExH', '416009987', 'Invoice-13-2021_11_07-023215-PS.pdf');

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
(27, '3-pcs-suit-sherani/3pc_s46whitesilkkp1_5_a5134f49.jpg', 73, 1),
(29, '3-pcs-suit-sherani/3pc_s46whitesilkkp1_7_9fe1e327.jpg', 73, 1),
(34, 'asasaasasasa/men1.jpg', 74, 1),
(35, 'asasaasasasa/men2.jpg', 74, 1),
(36, 'asasaasasasa/men3.jpg', 74, 1),
(37, 'khan-shadabssass/men1.jpg', 81, 1),
(45, 'khan-shadab-alam/3pc_s46whitesilkkp1_3_33e045a8.jpg', 82, 1),
(46, 'khan-shadab-alam/3pc_s46whitesilkkp1_4_99a5dec5.jpg', 82, 1),
(47, 'khan-shadab-alam/3pc_s46whitesilkkp1_6_f7ae6120.jpg', 82, 1),
(48, 'khan-shadab-alam/3pc_s46whitesilkkp1_7_9fe1e327.jpg', 82, 1),
(49, 'asakjahdkasjd/3pc_s46whitesilkkp1_3_33e045a8.jpg', 85, 1),
(50, 'sadsasdasaas/3pc_s46whitesilkkp1_3_33e045a8.jpg', 92, 1),
(51, 'asdasdasddsadsa/3_pcs_suit_sherwani.jpg', 93, 1),
(52, 'asdasdasddsadsa/3_pcs_suit_sherwani.jpg', 93, 1),
(53, 'my-product/3_pcs_suit_sherwani.jpg', 94, 1),
(54, 'three-piece-shervani-for-wedding/3_pcs_suit_sherani.jpg', 95, 1),
(55, 'three-piece-shervani-for-wedding/3_pcs_suit_sherwani.jpg', 95, 1),
(57, 'three-piece-shervani-for-wedding/3pc_s46whitesilkkp1_4_99a5dec5.jpg', 95, 1),
(58, 'three-piece-shervani-for-wedding/3pc_s46whitesilkkp1_5_a5134f49.jpg', 95, 1),
(59, 'three-piece-shervani-for-wedding/3pc_s46whitesilkkp1_6_f7ae6120.jpg', 95, 1),
(64, 'asdasdasdsada/men5.jpg', 96, 1),
(65, 'black-and-white-cracker-for-men/men4.jpg', 96, 1),
(66, 'men-maroon-solid-round-neck-t-shirt/1636309329417.jpeg', 97, 1),
(67, 'men-maroon-solid-round-neck-t-shirt/1636309472996.jpeg', 97, 1),
(68, 'men-maroon-solid-round-neck-t-shirt/1636310301888.jpeg', 97, 1),
(70, 'men-navy-solid-round-neck-t-shirt/ezgif.com-gif-maker.jpg', 98, 1),
(71, 'men-navy-solid-round-neck-t-shirt/ezgif.com-gif-maker (1).jpg', 98, 1),
(72, 'men-navy-solid-round-neck-t-shirt/ezgif.com-gif-maker (2).jpg', 98, 1),
(73, 'men-navy-solid-round-neck-t-shirt/ezgif.com-gif-maker (3).jpg', 98, 1),
(74, 'men-navy-solid-round-neck-t-shirt/ezgif.com-gif-maker (4).jpg', 98, 1);

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
(20, 'Compisiton ', 'Melted', 81, 1),
(21, 'Hyper', 'Not', 81, 1),
(29, 'Data heet', 'hello', 89, 1),
(30, 'Sollid', 'yes', 94, 1),
(31, 'Slky', 'Yes', 95, 1),
(32, 'Cotton', 'Yes', 95, 1),
(33, 'Dragon Slk', 'Office', 95, 1),
(34, 'Material', 'Cotton', 95, 1),
(35, 'Soft', 'yes', 95, 1),
(36, 'Fabric', 'Cotton', 97, 1),
(37, 'Fit', 'Regular Fit', 97, 1),
(38, 'Length', 'Regular', 97, 1);

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
  `product_subCategories` varchar(255) NOT NULL,
  `product_subCat_Values` varchar(255) NOT NULL,
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

INSERT INTO `product_details` (`id`, `product_name`, `product_price`, `product_oldPrice`, `product_brand`, `total_stock`, `total_sold`, `product_desc_short`, `product_size`, `product_categories`, `product_subCategories`, `product_subCat_Values`, `product_tags`, `product_desc_long`, `product_waist`, `product_hips`, `product_weight`, `product_status`, `product_added_on`) VALUES
(97, 'Men Maroon Solid Round Neck T-shirt', '299', 399, 1, 1000, 0, '<div class=\"pdp-sizeFitDesc\" style=\"box-sizing: inherit; border: none; margin-top: 12px; font-family: Whitney, -apple-system, BlinkMacSystemFont, \" segoe=\"\" ui\",=\"\" roboto,=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" medium;\"=\"\"><h4 class=\"pdp-sizeFitDescTitle pdp-product-description-title\" style=\"box-sizing: inherit; font-size: 16px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; text-transform: capitalize; border: none; padding-bottom: 5px;\"><br></h4></div>', 'S,M,L,XL', '1', 'Topwear', 'T-Shirts', '', '<p>Its to good at this rate I bought it for 199rs Just a little loose fit but loose fitting is trending now so I have no regrates Go for it the product is totally same as shown if you go for photo review youll find ligh or very dark it is due to different camera quality and location the product is totally same as shown no need to worry go for it I orderd M size #LoveRoadister<br></p>', '', '', '1.2', 1, '2021-11-07'),
(98, 'Men Navy Solid Round Neck T-shirt', '399', 479, 2, 100, 0, '<p>Navy blue solid T-shirt, has a round neck, and short sleeves</p><p><span style=\"font-weight: bolder;\">Size &amp; Fit</span></p><p>The model (height 6\') is wearing a size M </p><p><b>Material &amp; Care</b></p><p> 100% cotton</p><p>Machine-wash</p>', 'S,M,L', '1', 'Topwear', 'T-Shirts', '', '<p><br></p>', '', '', '.5', 1, '2021-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `shop_category`
--

CREATE TABLE `shop_category` (
  `cat_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `sub_category` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_category`
--

INSERT INTO `shop_category` (`cat_id`, `category_name`, `sub_category`, `status`) VALUES
(1, 'Men', 'Topwear,Indian & Festive Wear,Bottomwear,Innerwear & Sleepwear,Plus Size,Footwear,Personal Care & Grooming,Sunglasses & Frames,Watches', 1),
(2, 'Women', 'Indian & Fusion Wear,Watches & Wearables,Western Wear,Plus Size,Sunglasses & Frames,Footwear,Sports & Active Wear,Lingerie & Sleepwear,Beauty & Personal Care,Gadgets,Jewellery,Backpacks,Handbags, Bags & Wallets,Luggages & Trolleys,Belts; Scarves & More', 1),
(3, 'Kids', 'Boys Clothing,Girls Clothing,Footwear,Toys,Personal Care', 1),
(4, 'Home Living', 'Bed Linen & Furnishing,Flooring,Bath,Lamps & Lighting,Home DÃ©cor,Cushions & Cushion Covers,Curtains,Home Gift Sets,Kitchen & Table,Storage', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `subcat_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_subcat_id` varchar(255) NOT NULL,
  `subcat_value` varchar(255) NOT NULL,
  `subcat_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`subcat_id`, `category_id`, `category_subcat_id`, `subcat_value`, `subcat_status`) VALUES
(4, 1, 'Topwear', 'T-Shirts,Casual Shirts,Formal Shirts,Sweatshirts,Sweaters,Jackets,Blazers & Coats,Suits,Rain Jackets', 1),
(5, 1, 'Indian & Festive Wear', 'Kurtas & Kurta Sets,Sherwanis,Nehru Jackets,Dhotis', 1),
(6, 1, 'Bottomwear', 'Jeans,Casual Trousers,Formal Trousers,Shorts,Track Pants & Joggers', 1),
(7, 1, 'Innerwear & Sleepwear', 'Briefs & Trunks,Boxers,Vests,Sleepwear & Loungewear,Thermals', 1),
(8, 1, 'Footwear', 'Casual Shoes,Sports Shoes,Formal Shoes,Sneakers,Sandals & Floaters,Flip Flops,Socks', 1),
(9, 2, 'Indian & Fusion Wear', 'Kurtas & Suits,Kurtis Tunics & Tops,Ethnic Wear,Leggings; Salwars & Churidars,Skirts & Palazzos,Sarees,Dress Materials,Lehenga Cholis,Dupattas & Shawls,Jackets', 1),
(10, 2, 'Western Wear', 'Dresses,Jumpsuits,Tops,Jeans,Trousers & Capris,Shorts & Skirts,Shrugs,Sweaters & Sweatshirts,Jackets & Coats,Blazers & Waistcoats', 1),
(11, 2, 'Footwear', 'Flats,Casual Shoes,Heels,Boots,Sports Shoes & Floaters', 1),
(12, 2, 'Sports & Active Wear', 'Clothing,Footwear,Sports Accessories,Sports Equipment', 1),
(13, 2, 'Lingerie & Sleepwear', 'Bra,Briefs,Shapewear,Sleepwear & Loungewear,Swimwear,Camisoles & Thermals', 1),
(14, 2, 'Beauty & Personal Care', 'Makeup,Skincare,Premium Beauty,Lipsticks,Fragrances', 1),
(15, 2, 'Gadgets', 'Smart Wearables,Fitness Gadgets,Headphones,Speakers', 1),
(16, 2, 'Jewellery', 'Fashion Jewellery,Fine Jewellery,Earrings', 1),
(17, 3, 'Boys Clothing', 'Earrings,Shirts,Shorts,Jeans,Trousers,Clothing Sets,Ethnic Wear,Track Pants & Pyjamas,Jacket, Sweater & Sweatshirts,Party Wear,Innerwear & Thermals,Nightwear & Loungewear,Value Packs', 1),
(18, 3, 'Girls Clothing', 'Dresses,Tops,Tshirts,Clothing Sets,Lehenga choli,Kurta Sets,Party wear,Dungarees & Jumpsuits,Skirts & shorts,Tights & Leggings,Jeans; Trousers & Capris,Jacket; Sweater & Sweatshirts,Innerwear & Thermals,Nightwear & Loungewear,Value Packs', 1),
(19, 3, 'Footwear', 'Casual Shoes,Flipflops,Sports Shoes,Flats,Sandals,Heels,School Shoes,Socks', 1),
(20, 3, 'Toys', 'Learning & Development,Activity Toys,Soft Toys,Action Figure / Play set', 1),
(21, 4, 'Bed Linen & Furnishing', 'Bodysuits,Bedding Sets,Blankets; Quilts & Dohars,Pillows & Pillow Covers,Bed Covers', 1),
(22, 4, 'Flooring', 'Carpets,Floor Mats & Dhurries,Door Mats', 1),
(23, 4, 'Bath', 'Door Mats,Hand & Face Towels,Beach Towels,Towels Set,Bath Rugs,Bath Robes,Bathroom Accessories', 1),
(24, 4, 'Lamps & Lighting', 'Floor Lamps,Ceiling Lamps,Table Lamps,Wall Lamps,Outdoor Lamps,String Lights', 1),
(25, 4, 'Home DÃ©cor', 'Plants & Planters,Aromas & Candles,Clocks,Mirrors,Wall DÃ©cor,Wall Shelves,Fountains,Showpieces & Vases', 1),
(26, 4, 'Kitchen & Table', 'Dinnerware & Serveware,Cups and Mugs,Bakeware & Cookware,Kitchen Storage & Tools,Bar & Drinkware,Table Covers & Furnishings', 1),
(27, 4, 'Storage', 'Organisers,Hooks & Holders', 1);

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
(5, 8, 'Khan ', 'Shadab', 'Sahil Pvt, ltd', 'Sayeed Manzil, R 104, Kausa', 'Talao Pali', 'Dombivali', 'Maharashtra', '400612', 'India', '9875484215', 1, 1);

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
(35, 8, 'My Wishlist', '96,95', '', 1, '2021-11-05 10:21:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

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
-- Indexes for table `shop_category`
--
ALTER TABLE `shop_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`subcat_id`);

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
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products_image`
--
ALTER TABLE `products_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `product_data_sheet`
--
ALTER TABLE `product_data_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `shop_category`
--
ALTER TABLE `shop_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `subcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
