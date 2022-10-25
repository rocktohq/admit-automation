-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2022 at 09:24 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfmu.admits`
--

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.admin`
--

CREATE TABLE `sfmu.admin` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 0,
  `password` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.cse_syllabus_`
--

CREATE TABLE `sfmu.cse_syllabus_` (
  `id` int(11) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `year` int(1) NOT NULL,
  `semester` int(1) NOT NULL,
  `credit` double NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.cse_syllabus_old`
--

CREATE TABLE `sfmu.cse_syllabus_old` (
  `id` int(11) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `year` int(1) NOT NULL,
  `semester` int(1) NOT NULL,
  `credit` double NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.cse_syllabus_running`
--

CREATE TABLE `sfmu.cse_syllabus_running` (
  `id` int(11) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `year` int(1) NOT NULL,
  `semester` int(1) NOT NULL,
  `credit` double NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.departments`
--

CREATE TABLE `sfmu.departments` (
  `id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `program` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.logs`
--

CREATE TABLE `sfmu.logs` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `login_time` datetime NOT NULL DEFAULT current_timestamp(),
  `logout_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.print_details`
--

CREATE TABLE `sfmu.print_details` (
  `id` int(10) NOT NULL,
  `department` varchar(200) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `program` varchar(100) NOT NULL,
  `color` varchar(10) NOT NULL,
  `examtype` varchar(20) NOT NULL,
  `esemester` varchar(10) NOT NULL,
  `semester` varchar(15) NOT NULL,
  `year` int(1) NOT NULL,
  `syllabus` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.students`
--

CREATE TABLE `sfmu.students` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `uid` varchar(16) NOT NULL,
  `department` varchar(100) NOT NULL,
  `batch` int(10) DEFAULT NULL,
  `year` int(1) DEFAULT NULL,
  `semester` int(1) DEFAULT NULL,
  `session` varchar(15) NOT NULL,
  `admission_year` int(10) NOT NULL,
  `admission_semester` varchar(10) NOT NULL,
  `retake` varchar(30) DEFAULT NULL,
  `improvement` varchar(100) DEFAULT NULL,
  `recourse` varchar(100) DEFAULT NULL,
  `incomplete` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmu.tmp_students`
--

CREATE TABLE `sfmu.tmp_students` (
  `id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(200) NOT NULL,
  `uid` varchar(16) NOT NULL,
  `department` varchar(100) NOT NULL,
  `batch` int(10) DEFAULT NULL,
  `year` int(1) DEFAULT NULL,
  `semester` int(1) DEFAULT NULL,
  `session` varchar(15) NOT NULL,
  `admission_year` int(10) NOT NULL,
  `admission_semester` varchar(10) NOT NULL,
  `retake` varchar(30) DEFAULT NULL,
  `improvement` varchar(100) DEFAULT NULL,
  `recourse` varchar(100) DEFAULT NULL,
  `incomplete` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sfmu.admin`
--
ALTER TABLE `sfmu.admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sfmu.cse_syllabus_`
--
ALTER TABLE `sfmu.cse_syllabus_`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfmu.cse_syllabus_old`
--
ALTER TABLE `sfmu.cse_syllabus_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfmu.cse_syllabus_running`
--
ALTER TABLE `sfmu.cse_syllabus_running`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfmu.departments`
--
ALTER TABLE `sfmu.departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sfmu.logs`
--
ALTER TABLE `sfmu.logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfmu.print_details`
--
ALTER TABLE `sfmu.print_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfmu.students`
--
ALTER TABLE `sfmu.students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sfmu.admin`
--
ALTER TABLE `sfmu.admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmu.cse_syllabus_`
--
ALTER TABLE `sfmu.cse_syllabus_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmu.cse_syllabus_old`
--
ALTER TABLE `sfmu.cse_syllabus_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmu.cse_syllabus_running`
--
ALTER TABLE `sfmu.cse_syllabus_running`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmu.departments`
--
ALTER TABLE `sfmu.departments`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmu.logs`
--
ALTER TABLE `sfmu.logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmu.students`
--
ALTER TABLE `sfmu.students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
