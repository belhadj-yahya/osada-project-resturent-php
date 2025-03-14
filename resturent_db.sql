-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 12:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resturent_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `street` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(30) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `street`, `city`, `postal_code`, `user_id`) VALUES
(1, '123 Main St', 'New York', '10001', 1),
(2, '456 Elm St', 'Los Angeles', '90001', 2),
(3, '789 Oak St', 'Chicago', '60601', 3),
(4, '321 Pine St', 'Houston', '77001', 4),
(5, 'kasba', 'tanger', '90000', 5),
(6, 'bokhalf', 'mrakch', '70000', 6),
(7, 'malabata', 'xawn', '400000', 7),
(8, 'fada123', 'mirikh', '90000', 8);

-- --------------------------------------------------------

--
-- Table structure for table `admen_gmail`
--

CREATE TABLE `admen_gmail` (
  `admen_id` int(11) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admen_gmail` varchar(200) NOT NULL,
  `admen_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admen_gmail`
--

INSERT INTO `admen_gmail` (`admen_id`, `admin_name`, `admen_gmail`, `admen_password`) VALUES
(1, 'mohamed_abdol', 'abdol@gmail.com', '$2y$10$4N39rXqj5CohRkTv4rkLbu0ul32bI6OOfvs.vNSujfvPvDUu9AVj.');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(5, 'pasta'),
(9, 'Pizza'),
(11, 'Beverages'),
(12, 'chainis');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL,
  `dish_price` decimal(10,2) NOT NULL,
  `dish_name` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`dish_id`, `dish_price`, `dish_name`, `category_id`) VALUES
(34, 50.20, 'makarona', 5),
(42, 20.50, 'cocktil', 11),
(56, 10.40, 'sushi', 12),
(57, 100.50, 'pasta', 5),
(60, 13.99, 'pizza hot', 9),
(61, 19.40, 'domino pizza', 9),
(69, 40.20, 'liazanya', 5),
(70, 10.50, 'cacke', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `status`, `user_id`, `address_id`) VALUES
(1, '2023-10-01', 'Shipped', 1, 1),
(2, '2023-10-02', 'Pending', 2, 2),
(3, '2023-10-03', 'Shipped', 3, 3),
(4, '2023-10-04', 'Canceled', 4, 4),
(8, '2023-10-03', 'pending', 5, 5),
(9, '2023-11-05', 'Completed', 6, 6),
(10, '2024-01-05', 'pending', 7, 7),
(11, '2024-01-20', 'Shipped', 2, 2),
(12, '2025-03-01', 'canceled', 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_item_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `dish_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_item_id`, `quantity`, `dish_id`, `order_id`) VALUES
(7, 2, 34, 1),
(8, 1, 42, 1),
(9, 3, 56, 1),
(10, 4, 57, 2),
(11, 2, 60, 2),
(12, 1, 61, 2),
(13, 5, 69, 3),
(14, 3, 34, 3),
(15, 2, 42, 3),
(16, 6, 60, 4),
(17, 4, 42, 4),
(24, 3, 57, 8),
(25, 3, 69, 9),
(26, 3, 61, 10),
(27, 2, 61, 11),
(28, 2, 42, 12),
(29, 1, 34, 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '$2y$10$aYeQxZ9QKQLesNXEpg.AeOQfWz7J1G4hfHraGfe3rnOR2Ez/.ihA2', '123-456-7890'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '$2y$10$lMSrV1Pni.II4akFtfm.PeRHwODVpYM4uE3OHi2bJYvTp0JGSCFvu', '987-654-3210'),
(3, 'Alice', 'Johnson', 'alice.johnson@example.com', '$2y$10$qC/clTgLWfRWAZU0uiOPb.rjCnWoUm8KGcnMoUaWzdsuQvocMcGLS', '555-555-5555'),
(4, 'Bob', 'Brown', 'bob.brown@example.com', '$2y$10$g/9RBcUF9tu4qPjUZTQ3/OqvabegJYa.zUqcpM3z//0xiFlUAuVfe', '444-444-4444'),
(5, 'yahya', 'belhadj', 'yahya@gmail.com', '$2y$10$9LKY1HfJGFYGsk8//LTlIur0bndkETcnmxfB1.JJYWRvQFXq.0ghy', '068-132-1347'),
(6, 'sami', '3arbiy', 'sami@yahoo.com', '$2y$10$TqV9.h1/b8l4Squf3zg9guHTyJ0pxzR2sjOwExa4CGBHeCMHIVgbi', '584-648-7597'),
(7, 'wahiba', 'basri', 'brahim@gmail.com', '$2y$10$uhwmPuYjvuqshKASuu7XROxNMI6PAdbbqtkoeOyDY4WtcFnUZ9Xvy', '555-777-8888'),
(8, 'yahya', 'belhadj', 'yahya.belhadj.pro@gmail.com', '$2y$10$0VU5Db9QAYU52eMcwLb3/uNFpL/KLaPc3U5UwGGvBFu6bz6RpOLMm', '123-456-7891');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admen_gmail`
--
ALTER TABLE `admen_gmail`
  ADD PRIMARY KEY (`admen_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admen_gmail`
--
ALTER TABLE `admen_gmail`
  MODIFY `admen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
