-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 07:36 PM
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
-- Database: `clinic_management`
--
CREATE DATABASE IF NOT EXISTS `clinic_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `clinic_management`;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
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
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `import_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `type_id`, `quantity`, `price`, `import_date`) VALUES
(1, 'Amoxicillin 500mg', 1, 1000, 5000.00, '2024-03-15'),
(2, 'Paracetamol 500mg', 2, 2000, 2000.00, '2024-03-16'),
(3, 'Aspirin 81mg', 3, 1500, 3000.00, '2024-03-17'),
(4, 'Vitamin C 1000mg', 4, 3000, 1500.00, '2024-03-18'),
(5, 'Omeprazole 20mg', 5, 1000, 8000.00, '2024-03-19'),
(6, 'Ventolin 100mcg', 6, 500, 120000.00, '2024-03-20'),
(7, 'Betadine 10%', 7, 800, 25000.00, '2024-03-21'),
(8, 'Diazepam 5mg', 8, 600, 15000.00, '2024-03-22'),
(9, 'Metformin 850mg', 9, 1200, 4000.00, '2024-03-23'),
(10, 'Tobradex', 10, 400, 95000.00, '2024-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_types`
--

CREATE TABLE `medicine_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_types`
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
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
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
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `prescription_date` date NOT NULL,
  `diagnosis` text NOT NULL,
  `doctor_notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `patient_id`, `staff_id`, `medicine_id`, `quantity`, `price`, `prescription_date`, `diagnosis`, `doctor_notes`) VALUES
(1, 1, 1, 1, 20, 100000.00, '2024-03-15', 'Viêm họng cấp', 'Uống thuốc đều đặn, nghỉ ngơi nhiều'),
(2, 2, 2, 2, 30, 60000.00, '2024-03-16', 'Đau đầu mãn tính', 'Uống thuốc khi đau, tránh căng thẳng'),
(3, 3, 3, 3, 60, 180000.00, '2024-03-17', 'Cao huyết áp', 'Uống thuốc đều đặn mỗi sáng'),
(4, 4, 4, 4, 90, 135000.00, '2024-03-18', 'Suy nhược cơ thể', 'Uống vitamin sau bữa ăn'),
(5, 5, 5, 5, 30, 240000.00, '2024-03-19', 'Viêm dạ dày', 'Uống thuốc trước ăn 30 phút'),
(6, 1, 6, 6, 2, 240000.00, '2024-03-20', 'Hen suyễn cấp', 'Xịt thuốc khi khó thở'),
(7, 2, 7, 7, 2, 50000.00, '2024-03-21', 'Nhiễm trùng da', 'Bôi thuốc 2 lần/ngày'),
(8, 3, 8, 8, 30, 450000.00, '2024-03-22', 'Rối loạn lo âu', 'Uống thuốc trước khi ngủ'),
(9, 4, 9, 9, 60, 240000.00, '2024-03-23', 'Tiểu đường type 2', 'Uống thuốc sau bữa ăn'),
(10, 5, 10, 10, 1, 95000.00, '2024-03-24', 'Viêm kết mạc', 'Nhỏ mắt 4 lần/ngày');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `birth_year` int(11) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', '123', 'Administrator', 'admin', '2024-11-28 18:36:09'),
(2, 'staff', '123', 'Bác sĩ Ngô Lax', 'staff', '2024-11-28 18:36:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `medicine_types`
--
ALTER TABLE `medicine_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `medicine_types`
--
ALTER TABLE `medicine_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `medicine_types` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_3` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
