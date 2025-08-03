-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2025 at 08:41 PM
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
-- Database: `qlda`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id_attendance` int(11) NOT NULL,
  `details_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id_attendance`, `details_id`, `date`, `check_in`, `check_out`, `note`) VALUES
(1, 1, '2025-07-30 00:00:00', '07:20:00', '17:00:00', 'On time'),
(2, 2, '2025-07-31 00:00:00', '07:28:00', '17:00:00', 'On time'),
(3, 1, '2025-08-01 00:00:00', '07:35:00', '17:00:00', 'Late'),
(4, 2, '2025-08-02 00:00:00', '07:15:00', '17:00:00', 'On time'),
(5, 1, '2025-08-03 00:00:00', '07:25:00', '17:00:00', 'On time'),
(6, 1, '2025-07-30 00:00:00', '07:25:00', '17:00:00', 'On time'),
(7, 2, '2025-07-30 00:00:00', '07:15:00', '17:00:00', 'On time'),
(8, 1, '2025-07-30 00:00:00', '07:45:00', '17:00:00', 'Late'),
(9, 2, '2025-07-30 00:00:00', '08:00:00', '17:00:00', 'Late'),
(10, 1, '2025-07-31 00:00:00', '07:10:00', '17:00:00', 'On time'),
(11, 2, '2025-07-31 00:00:00', '07:28:00', '17:00:00', 'On time'),
(12, 1, '2025-07-31 00:00:00', '07:35:00', '17:00:00', 'Late'),
(13, 2, '2025-07-31 00:00:00', '08:10:00', '17:00:00', 'Late'),
(14, 1, '2025-08-01 00:00:00', '07:05:00', '17:00:00', 'On time'),
(15, 2, '2025-08-01 00:00:00', '07:29:00', '17:00:00', 'On time'),
(16, 1, '2025-08-01 00:00:00', '07:50:00', '17:00:00', 'Late'),
(17, 2, '2025-08-01 00:00:00', '08:05:00', '17:00:00', 'Late'),
(18, 1, '2025-08-02 00:00:00', '07:25:00', '17:00:00', 'On time'),
(19, 2, '2025-08-02 00:00:00', '07:20:00', '17:00:00', 'On time'),
(20, 1, '2025-08-02 00:00:00', '07:40:00', '17:00:00', 'Late'),
(21, 2, '2025-08-02 00:00:00', '08:15:00', '17:00:00', 'Late'),
(22, 1, '2025-08-03 00:00:00', '07:10:00', '17:00:00', 'On time'),
(23, 2, '2025-08-03 00:00:00', '07:25:00', '17:00:00', 'On time'),
(24, 1, '2025-08-03 00:00:00', '07:45:00', '17:00:00', 'Late'),
(25, 2, '2025-08-03 00:00:00', '08:10:00', '17:00:00', 'Late');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `name`, `description`, `created_at`) VALUES
(1, 'Phòng Nhân sự', 'Quản lý nhân viên, tuyển dụng, chấm công', '2025-08-02 14:10:03'),
(2, 'Phòng Kế toán', 'Quản lý lương và chi phí', '2025-08-02 14:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `details_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Nam','Nữ') DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `status` enum('Đang làm','Nghỉ việc','Tạm nghỉ') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `avataa` varchar(255) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`details_id`, `full_name`, `dob`, `gender`, `phone`, `email`, `address`, `department_id`, `position_id`, `date_joined`, `status`, `created_at`, `avataa`, `otp`) VALUES
(1, 'Nguyễn Văn A', '1990-05-10', 'Nam', '0912345678', 'a.nguyen@example.com', 'Hà Nội1', 1, 1, '2020-01-15', 'Đang làm', '2025-08-02 14:10:03', NULL, NULL),
(2, 'Trần Thị B', '1988-08-22', 'Nữ', '0987654321', 'b.tran@example.com', 'Hồ Chí Minh', 2, 2, '2019-06-10', 'Đang làm', '2025-08-02 14:10:03', NULL, NULL),
(5, 'Nguyễn trọng đức', '2025-08-05', 'Nam', '1231241254', 'a1@gmail.com', 'thủ dức', 1, 1, '2025-08-18', NULL, NULL, NULL, NULL),
(6, 'fdf', '2025-08-07', 'Nam', '0866225534', 'nguyentrongduc447@gmail.com', 'thủ dức', 2, 2, '2025-08-15', NULL, NULL, NULL, NULL),
(7, 'sdfsdf', '2025-08-07', 'Nam', '0866225534', 'minhtld1451@ut.edu.vn', 'thủ dức1', 1, 1, '2025-08-15', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `id_evaluation` int(11) NOT NULL,
  `details_id` int(11) DEFAULT NULL,
  `month` datetime DEFAULT NULL,
  `kpi_score` float DEFAULT NULL,
  `evaluator_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id_leave` int(11) NOT NULL,
  `details_id` int(11) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','approved','refused') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id_overtime` int(11) NOT NULL,
  `details_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `base_salary` decimal(15,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `name`, `base_salary`, `description`, `created_at`) VALUES
(1, 'Nhân viên', 8000000.00, 'Cấp bậc cơ bản', '2025-08-02 14:10:03'),
(2, 'Trưởng phòng', 15000000.00, 'Quản lý bộ phận', '2025-08-02 14:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id_salary` int(11) NOT NULL,
  `details_id` int(11) DEFAULT NULL,
  `month` datetime DEFAULT NULL,
  `base_salary` decimal(15,2) DEFAULT NULL,
  `allowance` decimal(15,2) DEFAULT NULL,
  `overtime_pay` decimal(15,2) DEFAULT NULL,
  `deduction` decimal(15,2) DEFAULT NULL,
  `net_salary` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user','boss') DEFAULT NULL,
  `details_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `name`, `password`, `role`, `details_id`, `status`) VALUES
(1, 'admin', 'nguyễn văn a', '$2y$10$Lmwm81iXSCuJfYKIF3.jIumZV5RbDHAR.wszhGV5wbGF.4ypSbXmO', 'admin', 1, 'active'),
(2, 'user', 'nguyễn văn b', '$2y$10$Lmwm81iXSCuJfYKIF3.jIumZV5RbDHAR.wszhGV5wbGF.4ypSbXmO', 'user', 2, 'active'),
(8, 'nguyentrongduc_5', 'Nguyễn trọng đức', '$2y$10$ArTeSJLJhYhf49XbAUt2I.osmHSV/UYAMEBHQH9OLrIxmc52eQYsK', 'user', 5, 'active'),
(9, 'fdf_6', 'fdf', '$2y$10$UycQGewfxOxgAtcTnXXze.bLUelUv7gT1jeiQA70IqLrmQeojV5JO', 'user', 6, 'active'),
(10, 'sdfsdf_7', 'sdfsdf', '$2y$10$5JJ.7..FyFNKQSj53rBBI.IQhkYwOEQI5mXNheqbRTGnr4QbJ33N2', 'user', 7, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id_attendance`),
  ADD KEY `details_id` (`details_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id_evaluation`),
  ADD KEY `details_id` (`details_id`),
  ADD KEY `evaluator_id` (`evaluator_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id_leave`),
  ADD KEY `details_id` (`details_id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id_overtime`),
  ADD KEY `details_id` (`details_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id_salary`),
  ADD KEY `details_id` (`details_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `details_id` (`details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id_attendance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id_evaluation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id_leave` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id_overtime` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id_salary` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`);

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`),
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`evaluator_id`) REFERENCES `details` (`details_id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`);

--
-- Constraints for table `overtime`
--
ALTER TABLE `overtime`
  ADD CONSTRAINT `overtime_ibfk_1` FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`);

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_ibfk_1` FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
