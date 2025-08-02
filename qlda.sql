

-- Tạo bảng `details` thay cho bảng `employees`
CREATE TABLE `details` (
  `details_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `otp` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `attendance`
CREATE TABLE `attendance` (
  `id_attendance` int(11) NOT NULL AUTO_INCREMENT,
  `details_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `note` text DEFAULT NULL,
  PRIMARY KEY (`id_attendance`),
  FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `departments`
CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `evaluation`
CREATE TABLE `evaluation` (
  `id_evaluation` int(11) NOT NULL AUTO_INCREMENT,
  `details_id` int(11) DEFAULT NULL,
  `month` datetime DEFAULT NULL,
  `kpi_score` float DEFAULT NULL,
  `evaluator_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  PRIMARY KEY (`id_evaluation`),
  FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`),
  FOREIGN KEY (`evaluator_id`) REFERENCES `details` (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `leave_requests`
CREATE TABLE `leave_requests` (
  `id_leave` int(11) NOT NULL AUTO_INCREMENT,
  `details_id` int(11) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('Chờ duyệt','Đã duyệt','Từ chối') DEFAULT NULL,
  PRIMARY KEY (`id_leave`),
  FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `overtime`
CREATE TABLE `overtime` (
  `id_overtime` int(11) NOT NULL AUTO_INCREMENT,
  `details_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `note` text DEFAULT NULL,
  PRIMARY KEY (`id_overtime`),
  FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `positions`
CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `base_salary` decimal(15,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `salaries`
CREATE TABLE `salaries` (
  `id_salary` int(11) NOT NULL AUTO_INCREMENT,
  `details_id` int(11) DEFAULT NULL,
  `month` datetime DEFAULT NULL,
  `base_salary` decimal(15,2) DEFAULT NULL,
  `allowance` decimal(15,2) DEFAULT NULL,
  `overtime_pay` decimal(15,2) DEFAULT NULL,
  `deduction` decimal(15,2) DEFAULT NULL,
  `net_salary` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_salary`),
  FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tạo bảng `user`
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user','boss') DEFAULT NULL,
  `details_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`details_id`) REFERENCES `details` (`details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Chèn dữ liệu mẫu vào bảng `details`
INSERT INTO `details` (`full_name`, `dob`, `gender`, `phone`, `email`, `address`, `department_id`, `position_id`, `date_joined`, `status`, `created_at`, `avataa`, `otp`)
VALUES 
('Nguyễn Văn A', '1990-05-10', 'Nam', '0912345678', 'a.nguyen@example.com', 'Hà Nội', 1, 1, '2020-01-15', 'Đang làm', NOW(), NULL, NULL),
('Trần Thị B', '1988-08-22', 'Nữ', '0987654321', 'b.tran@example.com', 'Hồ Chí Minh', 2, 2, '2019-06-10', 'Đang làm', NOW(), NULL, NULL);

-- Chèn dữ liệu vào bảng `departments`
INSERT INTO `departments` (`name`, `description`, `created_at`) VALUES
('Phòng Nhân sự', 'Quản lý nhân viên, tuyển dụng, chấm công', NOW()),
('Phòng Kế toán', 'Quản lý lương và chi phí', NOW());

-- Chèn dữ liệu vào bảng `positions`
INSERT INTO `positions` (`name`, `base_salary`, `description`, `created_at`) VALUES
('Nhân viên', 8000000.00, 'Cấp bậc cơ bản', NOW()),
('Trưởng phòng', 15000000.00, 'Quản lý bộ phận', NOW());

-- Chèn dữ liệu mẫu vào bảng `user`
INSERT INTO `user` (`username`, `name`, `password`, `role`, `details_id`, `status`)
VALUES
('admin', 'nguyễn văn a', '$2y$10$Lmwm81iXSCuJfYKIF3.jIumZV5RbDHAR.wszhGV5wbGF.4ypSbXmO', 'admin', 1, 'active'),
('user', 'nguyễn văn b', '$2y$10$Lmwm81iXSCuJfYKIF3.jIumZV5RbDHAR.wszhGV5wbGF.4ypSbXmO', 'user', 2, 'active');
