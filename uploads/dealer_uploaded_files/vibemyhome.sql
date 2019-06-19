-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2018 at 08:35 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vibemyhome`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartdetails`
--

CREATE TABLE `cartdetails` (
  `cart_id` bigint(20) NOT NULL,
  `uid` int(10) NOT NULL,
  `support_id` varchar(5000) NOT NULL,
  `designer_id` varchar(255) NOT NULL,
  `current_process` varchar(255) NOT NULL,
  `orderdate` varchar(255) NOT NULL,
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `restocks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `address_shipping_first_name` varchar(255) NOT NULL,
  `address_shipping_last_name` varchar(255) NOT NULL,
  `address_phone` varchar(255) NOT NULL,
  `address_shipping_suite` varchar(255) NOT NULL,
  `address_shipping_company` varchar(255) NOT NULL,
  `address_shipping_zip` varchar(255) NOT NULL,
  `address_shipping_country` varchar(255) NOT NULL,
  `address_shipping_city` varchar(255) NOT NULL,
  `address_shipping_street` varchar(255) NOT NULL,
  `address_shipping_state` varchar(255) NOT NULL,
  `shipping_price` double NOT NULL,
  `shipping_description` varchar(5000) NOT NULL,
  `updated_at` varchar(255) NOT NULL,
  `refund_possible` varchar(255) NOT NULL,
  `payment_last4` varchar(255) NOT NULL,
  `risk_level_zip_fail` varchar(255) NOT NULL,
  `risk_level_ip_fail` varchar(255) NOT NULL,
  `conversion_referrer` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `refunded` varchar(255) NOT NULL,
  `conversion_landing_page` varchar(255) NOT NULL,
  `risk_level_cvc_fail` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `risk_level_address_fail` varchar(255) NOT NULL,
  `display_number` varchar(255) NOT NULL,
  `discount_type` varchar(255) NOT NULL,
  `discount_value` varchar(255) NOT NULL,
  `discount_title` varchar(255) NOT NULL,
  `shipments_tracking_number` varchar(5000) NOT NULL,
  `shipments_fulfilment_id` int(11) NOT NULL,
  `shipments_shipping_carrier` int(11) NOT NULL,
  `shipments_items` varchar(5000) NOT NULL,
  `fulfilment_warehouse` varchar(255) NOT NULL,
  `fulfilments_id` int(11) NOT NULL,
  `fulfilments_item` varchar(5000) NOT NULL,
  `order_status` int(11) NOT NULL COMMENT '0-Awaiting Images',
  `items` varchar(5000) NOT NULL,
  `fulfilments` varchar(5000) NOT NULL,
  `shipments` varchar(5000) NOT NULL,
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cartdetails`
--

INSERT INTO `cartdetails` (`cart_id`, `uid`, `support_id`, `designer_id`, `current_process`, `orderdate`, `isDelete`, `customer_id`, `payment_type`, `restocks`, `status`, `address_shipping_first_name`, `address_shipping_last_name`, `address_phone`, `address_shipping_suite`, `address_shipping_company`, `address_shipping_zip`, `address_shipping_country`, `address_shipping_city`, `address_shipping_street`, `address_shipping_state`, `shipping_price`, `shipping_description`, `updated_at`, `refund_possible`, `payment_last4`, `risk_level_zip_fail`, `risk_level_ip_fail`, `conversion_referrer`, `notes`, `refunded`, `conversion_landing_page`, `risk_level_cvc_fail`, `paid`, `risk_level_address_fail`, `display_number`, `discount_type`, `discount_value`, `discount_title`, `shipments_tracking_number`, `shipments_fulfilment_id`, `shipments_shipping_carrier`, `shipments_items`, `fulfilment_warehouse`, `fulfilments_id`, `fulfilments_item`, `order_status`, `items`, `fulfilments`, `shipments`, `adate`) VALUES
(20, 19, '', '', '', '1522232047', 0, 11, '', '[]', 0, 'Deep', 'Ghia', '', 'Test', '', '360005', 'IN', 'Rajkot', 'University Road', 'GJ', 0, 'FREE SHIPPING', '', '', '', '', '', '', '', '', 'https://vibemyhome.com/', '', '1', '', '1015', 'coupon', '129.99', 'FREE', '', 0, 0, '', '', 0, '', 0, '', '', '', '2018-04-24 02:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `id` bigint(20) NOT NULL,
  `cart_id` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(5000) NOT NULL,
  `compare_price` double NOT NULL,
  `type` varchar(5000) NOT NULL,
  `auto_fulfilment` varchar(255) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `shipping_weight` varchar(255) NOT NULL,
  `is_giftcard` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `image_max_size` varchar(5000) NOT NULL,
  `is_multi` varchar(255) NOT NULL,
  `track_inventory` varchar(255) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `variants_value` varchar(5000) NOT NULL,
  `fulfilled` varchar(255) NOT NULL,
  `restocked` varchar(255) NOT NULL,
  `shipped` varchar(255) NOT NULL,
  `not_fulfilled` varchar(255) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`id`, `cart_id`, `uid`, `product_id`, `item_id`, `title`, `price`, `quantity`, `image`, `compare_price`, `type`, `auto_fulfilment`, `vendor`, `shipping_weight`, `is_giftcard`, `sku`, `image_max_size`, `is_multi`, `track_inventory`, `variant_id`, `variants_value`, `fulfilled`, `restocked`, `shipped`, `not_fulfilled`, `isDelete`, `adate`) VALUES
(29, 20, 19, 8, 1015, '"Paws" Personalized Luxury & Comfort For Your Dog', 129.99, 1, 'https://s3-us-west-2.amazonaws.com/commercehq-userfiles-master/commercehq-store-d945fb40cf4ee342ea94282ec39ad3da_7f8ee84f4cf599be71dc87a7eecacf740c7f12b7/uploads/1521480358_b05f4a57c633a06eb61ee0a05c467eef892da9c6.jpg', 159.99, 'Custom Pet Bed', '', 'MWW', '5', '', 'PRT-GEN-SDBGO50/paws/blue', '8', '1', '', 84, '["Blue","Large (50\\"x40\\")","Indoor\\/Outdoor (All Weather Polyester)"]', '', '', '', '', 0, '2018-04-24 02:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `customer_image`
--

CREATE TABLE `customer_image` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cart_item_id` int(11) NOT NULL,
  `files` varchar(500) NOT NULL,
  `customization_text` varchar(500) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `order_status` int(11) NOT NULL,
  `rejection_reason` varchar(5000) NOT NULL,
  `final_artwork_url` varchar(50000) NOT NULL,
  `mockup_file` varchar(255) NOT NULL,
  `customer_status` int(11) NOT NULL,
  `artwork_approve` int(11) NOT NULL,
  `request_revision` varchar(5000) NOT NULL,
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_audit`
--

CREATE TABLE `event_audit` (
  `event_Id` int(11) NOT NULL,
  `event_time` datetime DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `event_type` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `atime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_audit`
--

INSERT INTO `event_audit` (`event_Id`, `event_time`, `order_id`, `event_type`, `staff_id`, `customer_id`, `atime`) VALUES
(1, '2018-04-23 19:12:11', 6, 3, NULL, 20, '2018-04-23 19:12:11'),
(2, '2018-04-24 11:34:55', 5, 3, NULL, 20, '2018-04-24 11:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `id` int(11) NOT NULL,
  `ip` varchar(14) NOT NULL,
  `ltime` datetime NOT NULL,
  `attempts` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`id`, `ip`, `ltime`, `attempts`, `status`, `adate`) VALUES
(30, 'fe80::15a2:385', '2018-04-21 09:26:04', 1, 0, '2018-04-21 03:56:19'),
(31, 'fe80::15a2:385', '2018-04-21 09:37:04', 1, 0, '2018-04-21 04:07:03'),
(32, 'fe80::15a2:385', '2018-04-21 09:37:04', 1, 0, '2018-04-21 04:07:26'),
(33, 'fe80::15a2:385', '2018-04-21 09:37:04', 1, 0, '2018-04-21 04:07:57'),
(34, 'fe80::15a2:385', '2018-04-21 09:39:04', 1, 0, '2018-04-21 04:09:15'),
(35, 'fe80::15a2:385', '2018-04-21 09:40:04', 1, 0, '2018-04-21 04:10:16'),
(36, 'fe80::15a2:385', '2018-04-21 09:42:04', 1, 0, '2018-04-21 04:12:24'),
(37, 'fe80::15a2:385', '2018-04-21 09:43:04', 1, 0, '2018-04-21 04:13:03'),
(38, 'fe80::15a2:385', '2018-04-21 09:43:04', 1, 0, '2018-04-21 04:13:11'),
(39, 'fe80::15a2:385', '2018-04-21 09:43:04', 1, 0, '2018-04-21 04:13:48'),
(40, 'fe80::15a2:385', '2018-04-21 09:44:04', 1, 0, '2018-04-21 04:14:02'),
(41, 'fe80::15a2:385', '2018-04-21 09:45:04', 1, 0, '2018-04-21 04:15:17'),
(42, 'fe80::15a2:385', '2018-04-21 09:46:04', 1, 0, '2018-04-21 04:16:41'),
(43, 'fe80::15a2:385', '2018-04-21 09:47:04', 1, 0, '2018-04-21 04:17:26'),
(47, 'fe80::15a2:385', '2018-04-23 10:29:04', 1, 0, '2018-04-23 04:59:41'),
(48, 'fe80::15a2:385', '2018-04-23 10:30:04', 1, 0, '2018-04-23 05:00:32'),
(49, 'fe80::15a2:385', '2018-04-23 10:31:04', 1, 0, '2018-04-23 05:01:17'),
(50, 'fe80::15a2:385', '2018-04-23 10:32:04', 1, 0, '2018-04-23 05:02:01'),
(51, 'fe80::15a2:385', '2018-04-23 17:04:04', 1, 0, '2018-04-23 11:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `test` varchar(5000) NOT NULL,
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `test`, `adate`) VALUES
(2, '0', '2018-03-23 01:50:56'),
(3, '0', '2018-03-23 01:54:24'),
(4, '{"id":1013,"display_number":"1013","email":"crazycompiler002@gmail.com","status":0,"paid":1,"discounts":[{"type":"coupon","value":309.97,"title":"FREE"}],"shipping":{"description":"FREE SHIPPING","price":"0.00"},"tax":0,"total":0,"ip":"43.241.145.217","items":[{"data":{"id":65,"product_id":8,"title":"\\"Paws\\" Personalized Luxury & Comfort For Your Dog","is_multi":true,"type":"Custom Pet Bed","is_giftcard":false,"shipping_weight":5,"vendor":"MWW","auto_fulfilment":false,"track_inventory":false,"sku":"PRT-GEN-SDBGEN/paws/green","price":89.99,"compare_price":119.99,"image":"https://s3-us-west-2.amazonaws.com/commercehq-userfiles-master/commercehq-store-d945fb40cf4ee342ea94282ec39ad3da_7f8ee84f4cf599be71dc87a7eecacf740c7f12b7/uploads/1521480361_cd5c9ece39aac35789a8132435da804f30ee28d8.jpg","image_max_size":8,"variant":{"id":93,"variant":["Green","Medium (40\\"x30\\")","Indoor (Coral Fleece Polyester)"]}},"status":{"quantity":1,"not_fulfilled":1,"fulfilled":0,"shipped":0,"restocked":0}},{"data":{"id":66,"product_id":8,"title":"\\"Paws\\" Personalized Luxury & Comfort For Your Dog","is_multi":true,"type":"Custom Pet Bed","is_giftcard":false,"shipping_weight":5,"vendor":"MWW","auto_fulfilment":false,"track_inventory":false,"sku":"PRT-GEN-SDBOUT/paws/green","price":99.99,"compare_price":129.99,"image":"https://s3-us-west-2.amazonaws.com/commercehq-userfiles-master/commercehq-store-d945fb40cf4ee342ea94282ec39ad3da_7f8ee84f4cf599be71dc87a7eecacf740c7f12b7/uploads/1521480361_cd5c9ece39aac35789a8132435da804f30ee28d8.jpg","image_max_size":8,"variant":{"id":94,"variant":["Green","Medium (40\\"x30\\")","Indoor/Outdoor (All Weather Polyester)"]}},"status":{"quantity":1,"not_fulfilled":1,"fulfilled":0,"shipped":0,"restocked":0}},{"data":{"id":67,"product_id":8,"title":"\\"Paws\\" Personalized Luxury & Comfort For Your Dog","is_multi":true,"type":"Custom Pet Bed","is_giftcard":false,"shipping_weight":5,"vendor":"MWW","auto_fulfilment":false,"track_inventory":false,"sku":"PRT-GEN-SDBGN50/paws/green","price":119.99,"compare_price":149.99,"image":"https://s3-us-west-2.amazonaws.com/commercehq-userfiles-master/commercehq-store-d945fb40cf4ee342ea94282ec39ad3da_7f8ee84f4cf599be71dc87a7eecacf740c7f12b7/uploads/1521480361_cd5c9ece39aac35789a8132435da804f30ee28d8.jpg","image_max_size":8,"variant":{"id":95,"variant":["Green","Large (50\\"x40\\")","Indoor (Coral Fleece Polyester)"]}},"status":{"quantity":1,"not_fulfilled":1,"fulfilled":0,"shipped":0,"restocked":0}}],"fulfilments":[],"shipments":[],"restocks":[],"customer":{"id":10,"email":"crazycompiler002@gmail.com","first_name":"Deep","last_name":"Ghia"},"address":{"shipping":{"first_name":"Deep","last_name":"Ghia","company":null,"street":"345 Toast Street","suite":null,"city":"London","country":"GB","state":"Greater London","zip":"N3 9RL"},"billing":{"first_name":"Deep","last_name":"Ghia","street":"345 Toast Street","suite":null,"city":"London","country":"GB","state":"Greater London","zip":"N3 9RL"},"phone":null},"payment":{"type":null,"last4":null},"conversion":{"landing_page":"https://vibemyhome.com/","referrer":null},"risk_level":{"ip_fail":false,"address_fail":false,"zip_fail":false,"cvc_fail":false},"refunded":0,"refund_possible":false,"order_date":1521641458,"updated_at":null,"notes":null}', '2018-03-23 01:58:28'),
(5, '{"id":1013,"display_number":"1013","email":"crazycompiler002@gmail.com","status":0,"paid":1,"discounts":[{"type":"coupon","value":309.97,"title":"FREE"}],"shipping":{"description":"FREE SHIPPING","price":"0.00"},"tax":0,"total":0,"ip":"43.241.145.217","items":[{"data":{"id":65,"product_id":8,"title":"\\"Paws\\" Personalized Luxury & Comfort For Your Dog","is_multi":true,"type":"Custom Pet Bed","is_giftcard":false,"shipping_weight":5,"vendor":"MWW","auto_fulfilment":false,"track_inventory":false,"sku":"PRT-GEN-SDBGEN/paws/green","price":89.99,"compare_price":119.99,"image":"https://s3-us-west-2.amazonaws.com/commercehq-userfiles-master/commercehq-store-d945fb40cf4ee342ea94282ec39ad3da_7f8ee84f4cf599be71dc87a7eecacf740c7f12b7/uploads/1521480361_cd5c9ece39aac35789a8132435da804f30ee28d8.jpg","image_max_size":8,"variant":{"id":93,"variant":["Green","Medium (40\\"x30\\")","Indoor (Coral Fleece Polyester)"]}},"status":{"quantity":1,"not_fulfilled":1,"fulfilled":0,"shipped":0,"restocked":0}},{"data":{"id":66,"product_id":8,"title":"\\"Paws\\" Personalized Luxury & Comfort For Your Dog","is_multi":true,"type":"Custom Pet Bed","is_giftcard":false,"shipping_weight":5,"vendor":"MWW","auto_fulfilment":false,"track_inventory":false,"sku":"PRT-GEN-SDBOUT/paws/green","price":99.99,"compare_price":129.99,"image":"https://s3-us-west-2.amazonaws.com/commercehq-userfiles-master/commercehq-store-d945fb40cf4ee342ea94282ec39ad3da_7f8ee84f4cf599be71dc87a7eecacf740c7f12b7/uploads/1521480361_cd5c9ece39aac35789a8132435da804f30ee28d8.jpg","image_max_size":8,"variant":{"id":94,"variant":["Green","Medium (40\\"x30\\")","Indoor/Outdoor (All Weather Polyester)"]}},"status":{"quantity":1,"not_fulfilled":1,"fulfilled":0,"shipped":0,"restocked":0}},{"data":{"id":67,"product_id":8,"title":"\\"Paws\\" Personalized Luxury & Comfort For Your Dog","is_multi":true,"type":"Custom Pet Bed","is_giftcard":false,"shipping_weight":5,"vendor":"MWW","auto_fulfilment":false,"track_inventory":false,"sku":"PRT-GEN-SDBGN50/paws/green","price":119.99,"compare_price":149.99,"image":"https://s3-us-west-2.amazonaws.com/commercehq-userfiles-master/commercehq-store-d945fb40cf4ee342ea94282ec39ad3da_7f8ee84f4cf599be71dc87a7eecacf740c7f12b7/uploads/1521480361_cd5c9ece39aac35789a8132435da804f30ee28d8.jpg","image_max_size":8,"variant":{"id":95,"variant":["Green","Large (50\\"x40\\")","Indoor (Coral Fleece Polyester)"]}},"status":{"quantity":1,"not_fulfilled":1,"fulfilled":0,"shipped":0,"restocked":0}}],"fulfilments":[],"shipments":[],"restocks":[],"customer":{"id":10,"email":"crazycompiler002@gmail.com","first_name":"Deep","last_name":"Ghia"},"address":{"shipping":{"first_name":"Deep","last_name":"Ghia","company":null,"street":"345 Toast Street","suite":null,"city":"London","country":"GB","state":"Greater London","zip":"N3 9RL"},"billing":{"first_name":"Deep","last_name":"Ghia","street":"345 Toast Street","suite":null,"city":"London","country":"GB","state":"Greater London","zip":"N3 9RL"},"phone":null},"payment":{"type":null,"last4":null},"conversion":{"landing_page":"https://vibemyhome.com/","referrer":null},"risk_level":{"ip_fail":false,"address_fail":false,"zip_fail":false,"cvc_fail":false},"refunded":0,"refund_possible":false,"order_date":1521641458,"updated_at":null,"notes":null}', '2018-03-23 01:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `customer_first_name` varchar(250) NOT NULL,
  `customer_last_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `address_billing_street` varchar(255) NOT NULL,
  `address_billing_city` varchar(255) NOT NULL,
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `forgotpass_string` varchar(255) NOT NULL DEFAULT '0',
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address_billing_zip` varchar(250) NOT NULL,
  `ip` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `customer_first_name`, `customer_last_name`, `email`, `password`, `address_billing_street`, `address_billing_city`, `isDelete`, `forgotpass_string`, `adate`, `address_billing_zip`, `ip`) VALUES
(2, 'Nick', 'Fielding', 'nick.j.fielding@gmail.com', '9cd013fe250ebffc853b386569ab18c0', '345 Toast Street', 'London', 0, '0', '2018-03-16 19:59:49', 'N3 9RL', '31.48.62.17'),
(13, 'Nick', 'Fielding', 'crazycoder09@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '345 Toast Street', 'London', 0, '093d9031102c6b9019c5', '2018-03-19 12:25:07', 'N3 9RL', '31.48.62.17'),
(17, 'Deep', 'Ghia', 'crazycompiler002@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '345 Toast Street', 'London', 0, '0', '2018-03-23 05:55:38', 'N3 9RL', '43.241.145.217'),
(18, 'Deep', 'Ghia', 'crazycompiler002@gmail.com1', 'd1ad167c04df2b1eab47379ca7b57329', '345 Toast Street', 'London', 0, '0', '2018-03-28 06:18:09', 'N3 9RL', '43.241.145.217'),
(19, 'Deep', 'Test', 'aspiringcoder89@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'kalawad road', 'rajkot', 0, '0', '2018-03-28 06:30:26', '360001', '43.241.145.173'),
(20, 'Deep', 'Ghia', 'ghiadeep@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'qwerty', 'qewret', 0, '0', '2018-04-07 02:10:30', '360001', '43.241.145.26');

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `other_address` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `city` varchar(150) NOT NULL,
  `state` varchar(150) NOT NULL,
  `country` int(11) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `agree_term` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vibemyhome`
--

CREATE TABLE `vibemyhome` (
  `id` int(11) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `forgot_pass_string` text NOT NULL,
  `last_login` datetime NOT NULL,
  `last_ip` varchar(222) DEFAULT NULL,
  `isSuperAdmin` tinyint(1) NOT NULL,
  `access_area` varchar(255) NOT NULL,
  `role` int(11) NOT NULL COMMENT '0 = super admin,1 = support manager,2 = support,3 = design manager, 4 = designer.',
  `isDelete` tinyint(1) NOT NULL,
  `adate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vibemyhome`
--

INSERT INTO `vibemyhome` (`id`, `fname`, `lname`, `username`, `password`, `email`, `forgot_pass_string`, `last_login`, `last_ip`, `isSuperAdmin`, `access_area`, `role`, `isDelete`, `adate`) VALUES
(1, 'admin', 'test', 'admin', '70301d302b53113ad65561e1fa36e3f', 'test@test.com', '000', '2018-04-24 10:41:04', '192.168.1.9', 1, '0#,#1#,#2#,#3#,#4', 0, 0, '2018-03-20 19:51:12'),
(5, 'test', 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', 'test1@test.com', '', '2018-04-21 13:08:04', '192.168.1.5', 0, '0#,#1#,#4', 1, 0, '2018-03-20 19:51:12'),
(6, 'Deep', 'Ghia', 'Deep', '098f6bcd4621d373cade4e832627b4f6', 'aspiringcoder89@gmail.com', '000', '0000-00-00 00:00:00', NULL, 0, '1#,#4', 3, 0, '2018-03-28 06:57:01'),
(7, 'DeepTest', 'Designer', 'DeepTest', '098f6bcd4621d373cade4e832627b4f6', 'test@test.com', '', '0000-00-00 00:00:00', NULL, 0, '2#,#4', 4, 0, '2018-03-28 08:50:12'),
(8, 'Deep', 'Ghia', 'Deep', 'e10adc3949ba59abbe56e057f20f883e', 'ghiadeep@gmail.com', '', '2018-04-24 10:40:04', 'fe80::15a2:3858:b714:a26d', 0, '0#,#1#,#2#,#3#,#4', 1, 0, '2018-04-07 02:58:09'),
(9, 'test designer', 'designer', 'test designer', '409751c1fb09306214de10f5241cccb0', 'testdesigner@test.com', '', '0000-00-00 00:00:00', NULL, 0, '0#,#1#,#3', 4, 0, '2018-04-21 13:34:45'),
(10, 'fname', 'lname designer', 'fname', '2c725873caa77096f047dfef0eb29648', 'testerdesigner@mail.com', '', '0000-00-00 00:00:00', NULL, 0, '0#,#3#,#4', 4, 0, '2018-04-21 13:40:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartdetails`
--
ALTER TABLE `cartdetails`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_image`
--
ALTER TABLE `customer_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_audit`
--
ALTER TABLE `event_audit`
  ADD PRIMARY KEY (`event_Id`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `attemps` (`attempts`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fname` (`customer_first_name`),
  ADD KEY `lname` (`customer_last_name`),
  ADD KEY `email` (`email`),
  ADD KEY `password` (`password`),
  ADD KEY `adate` (`adate`),
  ADD KEY `isDelete` (`isDelete`),
  ADD KEY `forgotpassword_string` (`forgotpass_string`),
  ADD KEY `reg_ip` (`ip`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state` (`state`),
  ADD KEY `city` (`city`),
  ADD KEY `phone` (`phone`),
  ADD KEY `uid` (`uid`),
  ADD KEY `uid_2` (`uid`,`phone`,`city`,`state`),
  ADD KEY `country` (`country`),
  ADD KEY `profile_image` (`profile_image`);

--
-- Indexes for table `vibemyhome`
--
ALTER TABLE `vibemyhome`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartdetails`
--
ALTER TABLE `cartdetails`
  MODIFY `cart_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `customer_image`
--
ALTER TABLE `customer_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `event_audit`
--
ALTER TABLE `event_audit`
  MODIFY `event_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `user_detail`
--
ALTER TABLE `user_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vibemyhome`
--
ALTER TABLE `vibemyhome`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
