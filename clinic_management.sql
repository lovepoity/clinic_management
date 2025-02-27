-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 26, 2025 lúc 04:25 PM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `clinic_management`
--
CREATE DATABASE IF NOT EXISTS `clinic_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `clinic_management`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`) VALUES
(1, 'Khoa Nội', 'Chuyên khám và điều trị các bệnh lý nội khoa, tim mạch, hô hấp và tiêu hóa'),
(2, 'Khoa Ngoại', 'Thực hiện các ca phẫu thuật và điều trị các bệnh lý cần can thiệp ngoại khoa'),
(3, 'Khoa Sản', 'Chăm sóc sức khỏe phụ nữ mang thai và các vấn đề phụ khoa'),
(4, 'Khoa Nhi', 'Chuyên khám và điều trị các bệnh lý ở trẻ em từ 0-15 tuổi'),
(5, 'Khoa Cấp Cứu', 'Tiếp nhận và xử lý các trường hợp cấp cứu 24/7'),
(6, 'Khoa Tim Mạch', 'Chẩn đoán và điều trị các bệnh lý về tim mạch'),
(7, 'Khoa Thần Kinh', 'Chuyên về các bệnh lý thần kinh và não bộ'),
(8, 'Khoa Da Liễu', 'Điều trị các bệnh về da và thẩm mỹ da'),
(9, 'Khoa Mắt', 'Chẩn đoán và điều trị các bệnh về mắt'),
(10, 'Khoa Răng Hàm Mặt', 'Điều trị các vấn đề về răng miệng và phẫu thuật hàm mặt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `medicines`
--

CREATE TABLE `medicines` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type_id` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `type_id`, `price`) VALUES
(1, 'Amoxicillin 500mg', 1, 5000.00),
(2, 'Paracetamol 500mg', 2, 2000.00),
(3, 'Aspirin 81mg', 3, 3000.00),
(4, 'Vitamin C 1000mg', 4, 1500.00),
(5, 'Omeprazole 20mg', 5, 8000.00),
(6, 'Ventolin 100mcg', 6, 120000.00),
(7, 'Betadine 10%', 7, 25000.00),
(8, 'Diazepam 5mg', 8, 15000.00),
(9, 'Metformin 850mg', 9, 4000.00),
(10, 'Tobradex', 10, 95000.00),
(11, 'Augmentin 1g', 1, 15000.00),
(12, 'Panadol Extra', 2, 3000.00),
(13, 'Decolgen Forte', 6, 2500.00),
(14, 'Mobic 7.5mg', 2, 12000.00),
(15, 'Nexium 40mg', 5, 25000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `medicine_batches`
--

CREATE TABLE `medicine_batches` (
  `id` int NOT NULL,
  `medicine_id` int NOT NULL,
  `quantity` int NOT NULL,
  `import_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `batch_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `medicine_batches`
--

INSERT INTO `medicine_batches` (`id`, `medicine_id`, `quantity`, `import_date`, `expiry_date`, `batch_number`) VALUES
(1, 1, 500, '2024-03-15', '2025-03-15', 'AMX001'),
(2, 1, 500, '2024-03-20', '2025-03-20', 'AMX002'),
(3, 1, 800, '2024-04-01', '2025-04-01', 'AMX003'),
(4, 1, 1000, '2024-04-15', '2025-04-15', 'AMX004'),
(5, 2, 1000, '2024-03-16', '2025-03-16', 'PCM001'),
(6, 2, 1000, '2024-03-21', '2025-03-21', 'PCM002'),
(7, 2, 1500, '2024-04-05', '2025-04-05', 'PCM003'),
(8, 2, 2000, '2024-04-20', '2025-04-20', 'PCM004'),
(9, 3, 750, '2024-03-25', '2025-03-25', 'ASP001'),
(10, 3, 750, '2024-03-25', '2025-03-25', 'ASP002'),
(11, 3, 1000, '2024-04-10', '2025-04-10', 'ASP003'),
(12, 4, 1000, '2024-03-18', '2025-09-18', 'VTC001'),
(13, 4, 1500, '2024-04-02', '2025-10-02', 'VTC002'),
(14, 4, 2000, '2024-04-18', '2025-10-18', 'VTC003'),
(15, 5, 500, '2024-03-19', '2025-03-19', 'OMP001'),
(16, 5, 500, '2024-04-03', '2025-04-03', 'OMP002'),
(17, 5, 800, '2024-04-19', '2025-04-19', 'OMP003'),
(18, 6, 200, '2024-03-20', '2025-06-20', 'VNT001'),
(19, 6, 300, '2024-04-04', '2025-07-04', 'VNT002'),
(20, 6, 400, '2024-04-20', '2025-07-20', 'VNT003'),
(21, 7, 300, '2024-03-21', '2025-09-21', 'BTD001'),
(22, 7, 500, '2024-04-05', '2025-10-05', 'BTD002'),
(23, 7, 600, '2024-04-21', '2025-10-21', 'BTD003'),
(24, 8, 200, '2024-03-22', '2025-03-22', 'DZP001'),
(25, 8, 400, '2024-04-06', '2025-04-06', 'DZP002'),
(26, 8, 500, '2024-04-22', '2025-04-22', 'DZP003'),
(27, 9, 400, '2024-03-23', '2025-03-23', 'MTF001'),
(28, 9, 800, '2024-04-07', '2025-04-07', 'MTF002'),
(29, 9, 1000, '2024-04-23', '2025-04-23', 'MTF003'),
(30, 10, 150, '2024-03-24', '2025-06-24', 'TBD001'),
(31, 10, 250, '2024-04-08', '2025-07-08', 'TBD002'),
(32, 10, 300, '2024-04-24', '2025-07-24', 'TBD003'),
(33, 11, 400, '2024-03-25', '2025-09-25', 'AUG001'),
(34, 11, 400, '2024-04-09', '2025-10-09', 'AUG002'),
(35, 11, 600, '2024-04-25', '2025-10-25', 'AUG003'),
(36, 12, 750, '2024-03-25', '2025-06-25', 'PAN001'),
(37, 12, 750, '2024-04-10', '2025-07-10', 'PAN002'),
(38, 12, 1000, '2024-04-26', '2025-07-26', 'PAN003'),
(39, 13, 500, '2024-03-25', '2025-03-25', 'DCL001'),
(40, 13, 500, '2024-04-11', '2025-04-11', 'DCL002'),
(41, 13, 800, '2024-04-27', '2025-04-27', 'DCL003'),
(42, 14, 300, '2024-03-25', '2025-03-25', 'MBC001'),
(43, 14, 300, '2024-04-12', '2025-04-12', 'MBC002'),
(44, 14, 400, '2024-04-28', '2025-04-28', 'MBC003'),
(45, 15, 200, '2024-03-25', '2025-09-25', 'NXM001'),
(46, 15, 200, '2024-04-13', '2025-10-13', 'NXM002'),
(47, 15, 300, '2024-04-29', '2025-10-29', 'NXM003');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `medicine_types`
--

CREATE TABLE `medicine_types` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `medicine_types`
--

INSERT INTO `medicine_types` (`id`, `name`, `description`) VALUES
(1, 'Thuốc kháng sinh', 'Điều trị các bệnh nhiễm khuẩn, virus và nấm'),
(2, 'Thuốc giảm đau', 'Giảm đau và hạ sốt cho các trường hợp đau nhức'),
(3, 'Thuốc tim mạch', 'Điều trị các bệnh về tim và huyết áp'),
(4, 'Vitamin và khoáng chất', 'Bổ sung dinh dưỡng và tăng cường sức đề kháng'),
(5, 'Thuốc tiêu hóa', 'Điều trị các vấn đề về dạ dày và đường ruột'),
(6, 'Thuốc hô hấp', 'Điều trị các bệnh về đường hô hấp'),
(7, 'Thuốc da liễu', 'Điều trị các bệnh ngoài da và dị ứng'),
(8, 'Thuốc thần kinh', 'Điều trị các rối loạn tâm thần và thần kinh'),
(9, 'Thuốc nội tiết', 'Điều trị các rối loạn nội tiết và chuyển hóa'),
(10, 'Thuốc mắt', 'Điều trị các bệnh về mắt và thị giác');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `patients`
--

CREATE TABLE `patients` (
  `id` int NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `patients`
--

INSERT INTO `patients` (`id`, `full_name`, `gender`, `phone`, `birth_date`, `address`) VALUES
(1, 'Nguyễn Văn An', 'Male', '0901234567', '1990-05-15', '123 Nguyễn Văn Linh, Quận 7, TP.HCM'),
(2, 'Trần Thị Bình', 'Female', '0912345678', '1985-08-20', '456 Lê Lợi, Quận 1, TP.HCM'),
(3, 'Lê Văn Cường', 'Male', '0923456789', '1978-03-10', '789 Điện Biên Phủ, Quận 3, TP.HCM'),
(4, 'Phạm Thị Dung', 'Female', '0934567890', '1995-12-25', '321 Nguyễn Thị Minh Khai, Quận 1, TP.HCM'),
(5, 'Hoàng Văn Em', 'Male', '0945678901', '1982-06-30', '654 Cách Mạng Tháng 8, Quận 3, TP.HCM'),
(6, 'Ngô Thị Phương', 'Female', '0956789012', '1992-09-05', '987 Võ Văn Kiệt, Quận 5, TP.HCM'),
(7, 'Đặng Văn Giàu', 'Male', '0967890123', '1975-11-18', '147 Nguyễn Đình Chiểu, Quận 3, TP.HCM'),
(8, 'Mai Thị Hoa', 'Female', '0978901234', '1988-04-22', '258 Hai Bà Trưng, Quận 1, TP.HCM'),
(9, 'Vũ Văn Inh', 'Male', '0989012345', '1980-07-14', '369 Nam Kỳ Khởi Nghĩa, Quận 3, TP.HCM'),
(10, 'Đỗ Thị Kim', 'Female', '0990123456', '1993-01-28', '741 Lý Tự Trọng, Quận 1, TP.HCM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `staff_id` int DEFAULT NULL,
  `diagnosis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `doctor_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `prescription_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prescription_details`
--

CREATE TABLE `prescription_details` (
  `id` int NOT NULL,
  `prescription_id` int NOT NULL,
  `medicine_id` int NOT NULL,
  `batch_id` int NOT NULL,
  `quantity` int NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `id` int NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birth_year` int NOT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`id`, `full_name`, `gender`, `birth_year`, `position`, `department_id`) VALUES
(1, 'Dr. Nguyễn Văn Anh', 'Male', 1975, 'Trưởng khoa', 1),
(2, 'Dr. Trần Thị Bích', 'Female', 1980, 'Bác sĩ chuyên khoa', 2),
(3, 'Dr. Lê Văn Cường', 'Male', 1978, 'Bác sĩ nội trú', 3),
(4, 'Dr. Phạm Thị Dung', 'Female', 1982, 'Bác sĩ chuyên khoa', 4),
(5, 'Dr. Hoàng Văn Em', 'Male', 1985, 'Trưởng khoa', 5),
(6, 'Dr. Ngô Thị Phương', 'Female', 1979, 'Bác sĩ điều trị', 6),
(7, 'Dr. Đặng Văn Giàu', 'Male', 1976, 'Bác sĩ chuyên khoa', 7),
(8, 'Dr. Mai Thị Hoa', 'Female', 1983, 'Bác sĩ nội trú', 8),
(9, 'Dr. Vũ Văn Inh', 'Male', 1977, 'Trưởng khoa', 9),
(10, 'Dr. Đỗ Thị Kim', 'Female', 1981, 'Bác sĩ điều trị', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', '123', 'Administrator', 'admin', '2024-11-28 18:36:09'),
(2, 'staff', '123', 'Bác sĩ Ngô Lax', 'staff', '2024-11-28 18:36:09');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `medicine_batches`
--
ALTER TABLE `medicine_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Chỉ mục cho bảng `medicine_types`
--
ALTER TABLE `medicine_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `fk_prescriptions_staff` (`staff_id`);

--
-- Chỉ mục cho bảng `prescription_details`
--
ALTER TABLE `prescription_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_id` (`prescription_id`),
  ADD KEY `medicine_id` (`medicine_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `medicine_batches`
--
ALTER TABLE `medicine_batches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `medicine_types`
--
ALTER TABLE `medicine_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `prescription_details`
--
ALTER TABLE `prescription_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `medicine_batches`
--
ALTER TABLE `medicine_batches`
  ADD CONSTRAINT `fk_medicine_batches_medicines` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);

--
-- Các ràng buộc cho bảng `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `fk_prescriptions_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Các ràng buộc cho bảng `prescription_details`
--
ALTER TABLE `prescription_details`
  ADD CONSTRAINT `prescription_details_ibfk_1` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`),
  ADD CONSTRAINT `prescription_details_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`),
  ADD CONSTRAINT `prescription_details_ibfk_3` FOREIGN KEY (`batch_id`) REFERENCES `medicine_batches` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
