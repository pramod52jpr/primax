-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2023 at 07:59 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primax`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(1, 'Admin'),
(2, 'Supplier');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `doc_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `doc_spec` varchar(50) NOT NULL DEFAULT '',
  `doc_desc` varchar(500) NOT NULL DEFAULT '',
  `doc_po_code` varchar(100) NOT NULL DEFAULT '',
  `doc_po_file` varchar(500) NOT NULL DEFAULT '',
  `doc_supplier` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`doc_id`, `project_id`, `doc_spec`, `doc_desc`, `doc_po_code`, `doc_po_file`, `doc_supplier`) VALUES
(1, 5, '35234', 'ok', 'awesome', 'BIOROLES  MASTER USER.pdf', 3),
(3, 8, 'its my spec', '5gbe', 'gerg', 'Smart lock.pdf', 3),
(4, 6, 'weguk', 'glh', 'ugih', 'enterence.pdf', 10),
(5, 5, 'fye', 'fghik', 'jhfuf', 'Smart lock.pdf', 3);

-- --------------------------------------------------------

--
-- Table structure for table `drawings`
--

CREATE TABLE `drawings` (
  `draw_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL DEFAULT 0,
  `draw_number` varchar(100) NOT NULL DEFAULT '',
  `draw_title` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drawings`
--

INSERT INTO `drawings` (`draw_id`, `document_id`, `draw_number`, `draw_title`) VALUES
(1, 1, '67688786', 'this is the title one'),
(4, 1, 'i amnaaya', 'tirlw'),
(5, 1, 'gjhcj', 'jfkhkjl'),
(6, 1, 'yufui', 'leug98');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(200) NOT NULL DEFAULT '',
  `pro_desc` varchar(5000) NOT NULL DEFAULT '',
  `pro_po_no` varchar(100) NOT NULL DEFAULT '',
  `pro_po_date` varchar(30) NOT NULL DEFAULT '',
  `pro_file` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`pro_id`, `pro_name`, `pro_desc`, `pro_po_no`, `pro_po_date`, `pro_file`) VALUES
(4, 'first', 'this is first project desc', 'ebtegr', '7287-03-31', 'Pramod CV.pdf'),
(5, 'second', 'second desc', '2763767', '2656-04-06', 'debtors@.xls'),
(6, 'third', 'third desc this is', '432e', '4111-03-31', 'VIC Graphic Controller.pdf'),
(8, 'new project', 'new project desc', 'T8789737493', '2023-09-05', 'Copy of CONTACT MY ir.xlsx'),
(9, 'its new', 'bt', '465543456', '2023-09-27', 'Copy of CONTACT MY ir.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `revision_drawings`
--

CREATE TABLE `revision_drawings` (
  `revision_id` int(11) NOT NULL,
  `drawing_id` int(11) NOT NULL DEFAULT 0,
  `drawing_file` varchar(500) NOT NULL DEFAULT '',
  `date` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revision_drawings`
--

INSERT INTO `revision_drawings` (`revision_id`, `drawing_id`, `drawing_file`, `date`) VALUES
(1, 1, 'BIOROLES  MASTER USER.pdf', '2023-09-26'),
(2, 2, 'about VMS.xlsx', '2023-09-26'),
(3, 3, 'VIC Graphic Controller.pdf', '2023-09-26'),
(4, 4, '[Lesson 2] Video Wall Solutions.pdf', '2023-09-26'),
(5, 5, 'Copy of CONTACT MY ir.xlsx', '2023-09-26'),
(7, 4, 'VIC Graphic Controller.pdf', '2023-09-26'),
(8, 1, 'debtors@.xls', '2023-09-26'),
(9, 6, 'VIC Graphic Controller.pdf', '2023-09-27'),
(10, 4, 'Copy of CONTACT MY ir.xlsx', '2023-09-27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `name` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(300) NOT NULL DEFAULT '',
  `category` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `active`, `name`, `username`, `password`, `category`) VALUES
(1, 1, 'Admin', 'admin', '61646d696e', 1),
(3, 1, 'Pramod Pandit', 'pramod', '7072616d6f64', 2),
(10, 1, 'Naveen Pandit', 'naveen', '6e617665656e', 2),
(11, 1, 'new', 'new', '6e6577', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `drawings`
--
ALTER TABLE `drawings`
  ADD PRIMARY KEY (`draw_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `revision_drawings`
--
ALTER TABLE `revision_drawings`
  ADD PRIMARY KEY (`revision_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `drawings`
--
ALTER TABLE `drawings`
  MODIFY `draw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `revision_drawings`
--
ALTER TABLE `revision_drawings`
  MODIFY `revision_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
