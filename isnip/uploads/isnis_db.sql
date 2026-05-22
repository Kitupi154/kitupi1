-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 09:32 PM
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
-- Database: `isnis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `cargo_id` int(11) NOT NULL,
  `shipment_id` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cargo_description` text DEFAULT NULL,
  `cargo_value` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_id`, `address`, `company_name`, `id_number`, `nationality`) VALUES
(1, 1, '    kariakoo,dar es salaam', 'Mr Amosi Technical Services', '20060219131120000227', 'Tanzania'),
(2, 2, '    kariakoo,dar es salaam', 'Mr Amosi Technical Services', '20060219131120000227', 'Tanzania');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` int(11) NOT NULL,
  `shipment_id` int(11) DEFAULT NULL,
  `receiver_name` varchar(100) DEFAULT NULL,
  `receiver_phone` varchar(20) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_status` enum('pending','delivered') DEFAULT 'pending',
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gps_tracking`
--

CREATE TABLE `gps_tracking` (
  `tracking_id` int(11) NOT NULL,
  `vessel_id` int(11) NOT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `speed` decimal(10,2) DEFAULT NULL,
  `heading` varchar(50) DEFAULT NULL,
  `tracking_status` varchar(100) DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_messages`
--

CREATE TABLE `internal_messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `notification_type` varchar(50) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

CREATE TABLE `ports` (
  `port_id` int(11) NOT NULL,
  `port_name` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `report_type` varchar(100) DEFAULT NULL,
  `report_description` text DEFAULT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `route_id` int(11) NOT NULL,
  `route_name` varchar(100) DEFAULT NULL,
  `departure_port_id` int(11) DEFAULT NULL,
  `destination_port_id` int(11) DEFAULT NULL,
  `estimated_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `shipment_id` int(11) NOT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `vessel_id` int(11) DEFAULT NULL,
  `departure_port_id` int(11) DEFAULT NULL,
  `destination_port_id` int(11) DEFAULT NULL,
  `cargo_type` varchar(100) DEFAULT NULL,
  `container_number` varchar(100) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `estimated_arrival` date DEFAULT NULL,
  `actual_arrival` date DEFAULT NULL,
  `shipment_status` enum('cargo_received','verified','loaded','in_transit','arrived_port','ready_pickup','delivered') DEFAULT 'cargo_received',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_status_history`
--

CREATE TABLE `shipment_status_history` (
  `history_id` int(11) NOT NULL,
  `shipment_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `company_phone` varchar(20) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','customer') NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `role`, `profile_photo`, `status`, `created_at`) VALUES
(1, 'kitupi jackson', 'kaemba155@gmai.com', '0754545454', '$2y$10$HRtf4GRAVephTUTozeHSW.SnkQOvK0nk0VxgLqpIlm5Uo91ltUuD2', 'customer', 'uploads/1779471182_1778783479_5941_cctv1.jpg', 'active', '2026-05-22 17:33:02'),
(2, 'kitupi jackson', 'kaemba0155@gmai.com', '0754545455', '$2y$10$brgKzRITtTh1SSQEU7mHn.Gnz0E7wVvv0oaJwQa6eZbiAmjQXQPL2', 'customer', 'uploads/1779472040_zuku1.jpg', 'active', '2026-05-22 17:47:20'),
(3, 'amani mpamda', 'mpanda155@gmai.com', '0754545454', '$2y$10$wc8NYCVtqUFsQLsdTr/KLu0bKFIrJuov2bdyX4I/obiPGzGBZN1pC', 'admin', NULL, 'active', '2026-05-22 18:53:37');

-- --------------------------------------------------------

--
-- Table structure for table `vessels`
--

CREATE TABLE `vessels` (
  `vessel_id` int(11) NOT NULL,
  `vessel_name` varchar(100) NOT NULL,
  `vessel_type` varchar(50) DEFAULT NULL,
  `registration_number` varchar(50) DEFAULT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `captain_name` varchar(100) DEFAULT NULL,
  `status` enum('active','maintenance','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vessel_routes`
--

CREATE TABLE `vessel_routes` (
  `vessel_route_id` int(11) NOT NULL,
  `vessel_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`cargo_id`),
  ADD KEY `shipment_id` (`shipment_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `shipment_id` (`shipment_id`);

--
-- Indexes for table `gps_tracking`
--
ALTER TABLE `gps_tracking`
  ADD PRIMARY KEY (`tracking_id`),
  ADD KEY `vessel_id` (`vessel_id`);

--
-- Indexes for table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ports`
--
ALTER TABLE `ports`
  ADD PRIMARY KEY (`port_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`route_id`),
  ADD KEY `departure_port_id` (`departure_port_id`),
  ADD KEY `destination_port_id` (`destination_port_id`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`shipment_id`),
  ADD UNIQUE KEY `tracking_number` (`tracking_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `vessel_id` (`vessel_id`),
  ADD KEY `departure_port_id` (`departure_port_id`),
  ADD KEY `destination_port_id` (`destination_port_id`);

--
-- Indexes for table `shipment_status_history`
--
ALTER TABLE `shipment_status_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `shipment_id` (`shipment_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vessels`
--
ALTER TABLE `vessels`
  ADD PRIMARY KEY (`vessel_id`);

--
-- Indexes for table `vessel_routes`
--
ALTER TABLE `vessel_routes`
  ADD PRIMARY KEY (`vessel_route_id`),
  ADD KEY `vessel_id` (`vessel_id`),
  ADD KEY `route_id` (`route_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `cargo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gps_tracking`
--
ALTER TABLE `gps_tracking`
  MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internal_messages`
--
ALTER TABLE `internal_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ports`
--
ALTER TABLE `ports`
  MODIFY `port_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `shipment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_status_history`
--
ALTER TABLE `shipment_status_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vessels`
--
ALTER TABLE `vessels`
  MODIFY `vessel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vessel_routes`
--
ALTER TABLE `vessel_routes`
  MODIFY `vessel_route_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `cargo_ibfk_1` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`shipment_id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`shipment_id`);

--
-- Constraints for table `gps_tracking`
--
ALTER TABLE `gps_tracking`
  ADD CONSTRAINT `gps_tracking_ibfk_1` FOREIGN KEY (`vessel_id`) REFERENCES `vessels` (`vessel_id`);

--
-- Constraints for table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD CONSTRAINT `internal_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `internal_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`departure_port_id`) REFERENCES `ports` (`port_id`),
  ADD CONSTRAINT `routes_ibfk_2` FOREIGN KEY (`destination_port_id`) REFERENCES `ports` (`port_id`);

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `shipments_ibfk_2` FOREIGN KEY (`vessel_id`) REFERENCES `vessels` (`vessel_id`),
  ADD CONSTRAINT `shipments_ibfk_3` FOREIGN KEY (`departure_port_id`) REFERENCES `ports` (`port_id`),
  ADD CONSTRAINT `shipments_ibfk_4` FOREIGN KEY (`destination_port_id`) REFERENCES `ports` (`port_id`);

--
-- Constraints for table `shipment_status_history`
--
ALTER TABLE `shipment_status_history`
  ADD CONSTRAINT `shipment_status_history_ibfk_1` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`shipment_id`),
  ADD CONSTRAINT `shipment_status_history_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `vessel_routes`
--
ALTER TABLE `vessel_routes`
  ADD CONSTRAINT `vessel_routes_ibfk_1` FOREIGN KEY (`vessel_id`) REFERENCES `vessels` (`vessel_id`),
  ADD CONSTRAINT `vessel_routes_ibfk_2` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
