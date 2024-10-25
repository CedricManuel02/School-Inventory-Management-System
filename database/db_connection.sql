-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 04:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_connection`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`, `category_date_created`) VALUES
(1, 'Equipment', '2024-03-26 12:36:47'),
(2, 'Furniture and Fixture', '2024-03-26 12:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `employee_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL,
  `employee_first_name` varchar(255) NOT NULL,
  `employee_last_name` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `employee_date_created` datetime NOT NULL,
  `employee_date_updated` datetime DEFAULT NULL,
  `employee_date_deleted` datetime DEFAULT NULL,
  `roles_id` int(11) NOT NULL,
  `password_salt` varchar(255) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`employee_id`, `position_id`, `office_id`, `employee_first_name`, `employee_last_name`, `employee_email`, `employee_password`, `is_deleted`, `employee_date_created`, `employee_date_updated`, `employee_date_deleted`, `roles_id`, `password_salt`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(15, 1, 1, 'Gale', 'Dexter', 'fannymikasa1994@gmail.com', '$2y$10$IzQAbmWg.w2/HwkH/N6LU.cx56aKm1s0ytQLAab2dfIKQaHzHmY0u', 0, '2024-05-25 00:57:23', '2024-06-15 10:33:53', NULL, 1, '666cfd919f041', NULL, NULL),
(16, 2, 2, 'Cedric Gio', 'Manuel', 'cedricmanuel02@gmail.com', '$2y$10$yCF8786ZcbloUmh7CelwlOaifTbnELxa2v3aDHMjo/amekDAJURJ6', 0, '2024-05-25 00:58:25', '2024-06-15 10:56:17', NULL, 2, '666d040832323', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item`
--

CREATE TABLE `tbl_item` (
  `item_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_brand` varchar(255) DEFAULT NULL,
  `item_serial_no` varchar(255) DEFAULT NULL,
  `item_model_no` varchar(255) DEFAULT NULL,
  `item_amount` double NOT NULL,
  `item_condition` varchar(255) NOT NULL,
  `item_date_purchased` date NOT NULL,
  `item_date_created` datetime NOT NULL,
  `item_date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_item`
--

INSERT INTO `tbl_item` (`item_id`, `employee_id`, `category_id`, `item_name`, `item_brand`, `item_serial_no`, `item_model_no`, `item_amount`, `item_condition`, `item_date_purchased`, `item_date_created`, `item_date_updated`) VALUES
(23, 16, 1, 'Laptop', 'DELL', 'JS923GDK3X', 'Latitude E5570', 49000, 'Condemed', '2024-05-15', '2024-05-25 14:18:45', NULL),
(34, 16, 2, 'Sofa Bed', '', '', '', 3000, 'Condemed', '2024-06-13', '2024-06-15 10:47:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office`
--

CREATE TABLE `tbl_office` (
  `office_id` int(11) NOT NULL,
  `office_name` varchar(255) NOT NULL,
  `office_date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_office`
--

INSERT INTO `tbl_office` (`office_id`, `office_name`, `office_date_created`) VALUES
(1, 'Management Information System Office', '2024-03-26 10:34:14'),
(2, 'Personnel', '2024-03-26 10:34:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position`
--

CREATE TABLE `tbl_position` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `position_date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_position`
--

INSERT INTO `tbl_position` (`position_id`, `position_name`, `position_date_created`) VALUES
(1, 'Information Technology Officer', '2024-03-26 10:31:29'),
(2, 'MIS Head', '2024-03-26 10:32:00'),
(3, 'Book Keeper', '2024-03-26 10:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

CREATE TABLE `tbl_request` (
  `request_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `request_status` varchar(50) DEFAULT NULL,
  `is_done` tinyint(1) NOT NULL,
  `request_date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_request`
--

INSERT INTO `tbl_request` (`request_id`, `item_id`, `request_status`, `is_done`, `request_date_created`) VALUES
(17, 23, '', 1, '2024-05-25 17:40:07'),
(23, 34, '', 1, '2024-06-15 10:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `roles_id` int(11) NOT NULL,
  `roles` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`roles_id`, `roles`) VALUES
(1, 'Admin'),
(2, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `office_id` (`office_id`),
  ADD KEY `fk_employee_roles` (`roles_id`);

--
-- Indexes for table `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_office`
--
ALTER TABLE `tbl_office`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `tbl_position`
--
ALTER TABLE `tbl_position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `tbl_request`
--
ALTER TABLE `tbl_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`roles_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_item`
--
ALTER TABLE `tbl_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_office`
--
ALTER TABLE `tbl_office`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_position`
--
ALTER TABLE `tbl_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_request`
--
ALTER TABLE `tbl_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `roles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD CONSTRAINT `fk_employee_roles` FOREIGN KEY (`roles_id`) REFERENCES `tbl_roles` (`roles_id`),
  ADD CONSTRAINT `tbl_employee_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `tbl_position` (`position_id`),
  ADD CONSTRAINT `tbl_employee_ibfk_2` FOREIGN KEY (`office_id`) REFERENCES `tbl_office` (`office_id`);

--
-- Constraints for table `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD CONSTRAINT `tbl_item_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `tbl_employee` (`employee_id`),
  ADD CONSTRAINT `tbl_item_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`);

--
-- Constraints for table `tbl_request`
--
ALTER TABLE `tbl_request`
  ADD CONSTRAINT `tbl_request_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
