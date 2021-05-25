-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2021 at 11:48 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `compro20s1`
--
CREATE DATABASE IF NOT EXISTS `compro20s1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `compro20s1`;

-- --------------------------------------------------------

--
-- Table structure for table `class_lab_staff`
--

CREATE TABLE `class_lab_staff` (
  `class_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `group_id` int(11) NOT NULL,
  `group_no` int(3) DEFAULT NULL,
  `group_name` varchar(80) DEFAULT NULL,
  `department` int(11) NOT NULL DEFAULT 16,
  `lecturer` int(11) DEFAULT NULL,
  `day_of_week` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `semester` int(1) DEFAULT NULL,
  `allow_upload_pic` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_submit` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_login` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_exercise` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exam_room_info`
--

CREATE TABLE `exam_room_info` (
  `room_number` int(3) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `allow_access` enum('checked','unchecked') CHARACTER SET utf8 NOT NULL,
  `allow_check_in` enum('checked','unchecked') CHARACTER SET utf8 NOT NULL,
  `in_social_distancing` enum('checked','unchecked') CHARACTER SET utf16 NOT NULL DEFAULT 'unchecked',
  `is_active` enum('yes','no') CHARACTER SET utf8 NOT NULL,
  `chapter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_seat`
--

CREATE TABLE `exam_seat` (
  `room_number` int(3) NOT NULL,
  `seat_number` int(2) NOT NULL,
  `stu_id` int(8) DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `helper` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_student_swap`
--

CREATE TABLE `exam_student_swap` (
  `stu_id` int(8) NOT NULL,
  `room_number` int(3) NOT NULL,
  `stu_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exercise_constrain`
--

CREATE TABLE `exercise_constrain` (
  `constrain_id` int(11) NOT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `content` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exercise_submission`
--

CREATE TABLE `exercise_submission` (
  `submission_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `sourcecode_filename` varchar(40) NOT NULL,
  `marking` int(11) NOT NULL DEFAULT -1 COMMENT '-1 => unscored',
  `time_submit` datetime DEFAULT current_timestamp(),
  `inf_loop` enum('Yes','No') DEFAULT NULL,
  `output` varchar(8192) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exercise_testcase`
--

CREATE TABLE `exercise_testcase` (
  `testcase_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `testcase_content` varchar(1024) NOT NULL,
  `active` enum('yes','no') DEFAULT NULL,
  `show_to_student` enum('yes','no') DEFAULT NULL,
  `testcase_note` varchar(1024) DEFAULT NULL,
  `testcase_output` varchar(2048) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_assigned_chapter_item`
--

CREATE TABLE `group_assigned_chapter_item` (
  `group_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `exercise_id_list` varchar(1024) DEFAULT NULL,
  `full_mark` int(11) NOT NULL DEFAULT 2,
  `time_start` datetime DEFAULT NULL,
  `time_end` datetime DEFAULT NULL,
  `status` enum('ready','closed','stop','open') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='เก็บข้อมูล ของกลุ่ม';

-- --------------------------------------------------------

--
-- Table structure for table `group_assigned_exercise`
--

CREATE TABLE `group_assigned_exercise` (
  `group_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `selected` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_chapter_permission`
--

CREATE TABLE `group_chapter_permission` (
  `class_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `time_start` datetime DEFAULT NULL,
  `time_end` datetime DEFAULT NULL,
  `allow_submit` enum('yes','no') NOT NULL DEFAULT 'yes',
  `status` enum('na','ready','open','close','stop') NOT NULL DEFAULT 'na',
  `allow_access` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `infinite_loop`
--

CREATE TABLE `infinite_loop` (
  `stu_group` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `chapter` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `sequence` int(11) NOT NULL,
  `start` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lab_classinfo`
--

CREATE TABLE `lab_classinfo` (
  `chapter_id` int(11) NOT NULL,
  `chapter_name` varchar(256) NOT NULL,
  `chapter_fullmark` int(4) NOT NULL,
  `no_items` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='บทเรียนของวิชา';

-- --------------------------------------------------------

--
-- Table structure for table `lab_class_item`
--

CREATE TABLE `lab_class_item` (
  `item_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `exercise_id` int(11) DEFAULT NULL,
  `item_point` int(11) DEFAULT NULL,
  `selected` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='กำหนด exercise ให้นักศึกษา แต่ละแลป';

-- --------------------------------------------------------

--
-- Table structure for table `lab_exercise`
--

CREATE TABLE `lab_exercise` (
  `exercise_id` int(11) NOT NULL,
  `lab_chapter` int(3) DEFAULT NULL,
  `lab_level` enum('0','1','2','3','4','5','6') DEFAULT NULL,
  `lab_name` varchar(1024) DEFAULT NULL,
  `lab_content` varchar(10240) DEFAULT NULL,
  `testcase` enum('no_input','yes','undefined') NOT NULL DEFAULT 'no_input',
  `sourcecode` varchar(50) DEFAULT NULL,
  `full_mark` int(4) NOT NULL DEFAULT 10,
  `added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update` datetime NOT NULL DEFAULT current_timestamp(),
  `lab_constrain` varchar(1024) DEFAULT NULL,
  `added_by` varchar(40) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='to store exercise';

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` tinyint(4) NOT NULL,
  `level_name` varchar(255) COLLATE utf8_thai_520_w2 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

-- --------------------------------------------------------

--
-- Table structure for table `library_c`
--

CREATE TABLE `library_c` (
  `lib_id` int(11) NOT NULL,
  `lib_name` varchar(40) NOT NULL,
  `action` enum('allow','deny') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_assigned_chapter_item`
--

CREATE TABLE `student_assigned_chapter_item` (
  `stu_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `exercise_id` int(11) DEFAULT NULL,
  `full_mark` int(11) NOT NULL DEFAULT 0,
  `marking` int(11) NOT NULL DEFAULT 0,
  `added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `time_start` datetime DEFAULT NULL,
  `time_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='เก็บข้อมูลของนักศึกษาแต่ละคน ทีจะทำแลป';

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('admin','editor','author','student','supervisor','staff') DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `last_seen` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('online','offline') NOT NULL DEFAULT 'offline',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `added_by` varchar(40) DEFAULT NULL,
  `ci_session` int(11) DEFAULT NULL,
  `session_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_student`
--

CREATE TABLE `user_student` (
  `stu_id` int(11) NOT NULL,
  `stu_gender` enum('male','female','other') DEFAULT NULL,
  `stu_firstname` varchar(40) DEFAULT NULL,
  `stu_lastname` varchar(32) DEFAULT NULL,
  `stu_nickname` varchar(20) DEFAULT NULL,
  `stu_dob` date DEFAULT NULL,
  `stu_avatar` varchar(128) DEFAULT NULL,
  `stu_email` varchar(64) DEFAULT NULL,
  `stu_tel` varchar(12) DEFAULT NULL,
  `stu_group` int(11) DEFAULT NULL,
  `note` varchar(64) DEFAULT NULL,
  `stu_dept_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_supervisor`
--

CREATE TABLE `user_supervisor` (
  `supervisor_id` int(11) NOT NULL,
  `supervisor_firstname` varchar(50) DEFAULT NULL,
  `supervisor_lastname` varchar(50) DEFAULT NULL,
  `supervisor_nickname` varchar(50) DEFAULT NULL,
  `supervisor_gender` enum('male','female','other') DEFAULT NULL,
  `supervisor_dob` date DEFAULT NULL,
  `supervisor_avatar` varchar(64) DEFAULT NULL,
  `supervisor_email` varchar(64) DEFAULT NULL,
  `supervisor_tel` varchar(12) DEFAULT NULL,
  `supervisor_department` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_lab_staff`
--
ALTER TABLE `class_lab_staff`
  ADD PRIMARY KEY (`class_id`,`staff_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `lecturer` (`lecturer`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `exam_room_info`
--
ALTER TABLE `exam_room_info`
  ADD PRIMARY KEY (`room_number`);

--
-- Indexes for table `exam_seat`
--
ALTER TABLE `exam_seat`
  ADD PRIMARY KEY (`room_number`,`seat_number`);

--
-- Indexes for table `exam_student_swap`
--
ALTER TABLE `exam_student_swap`
  ADD PRIMARY KEY (`stu_id`);

--
-- Indexes for table `exercise_constrain`
--
ALTER TABLE `exercise_constrain`
  ADD PRIMARY KEY (`constrain_id`),
  ADD KEY `exercise_id_parent` (`lab_id`);

--
-- Indexes for table `exercise_submission`
--
ALTER TABLE `exercise_submission`
  ADD PRIMARY KEY (`submission_id`);

--
-- Indexes for table `exercise_testcase`
--
ALTER TABLE `exercise_testcase`
  ADD PRIMARY KEY (`testcase_id`),
  ADD KEY `exercise_testcase_parent` (`exercise_id`);

--
-- Indexes for table `group_assigned_chapter_item`
--
ALTER TABLE `group_assigned_chapter_item`
  ADD PRIMARY KEY (`group_id`,`chapter_id`,`item_id`);

--
-- Indexes for table `group_assigned_exercise`
--
ALTER TABLE `group_assigned_exercise`
  ADD PRIMARY KEY (`group_id`,`exercise_id`),
  ADD KEY `group` (`exercise_id`);

--
-- Indexes for table `group_chapter_permission`
--
ALTER TABLE `group_chapter_permission`
  ADD PRIMARY KEY (`class_id`,`chapter_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indexes for table `infinite_loop`
--
ALTER TABLE `infinite_loop`
  ADD PRIMARY KEY (`stu_group`,`stu_id`,`chapter`,`item`,`sequence`);

--
-- Indexes for table `lab_classinfo`
--
ALTER TABLE `lab_classinfo`
  ADD PRIMARY KEY (`chapter_id`);

--
-- Indexes for table `lab_exercise`
--
ALTER TABLE `lab_exercise`
  ADD PRIMARY KEY (`exercise_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `library_c`
--
ALTER TABLE `library_c`
  ADD PRIMARY KEY (`lib_id`),
  ADD UNIQUE KEY `lib_name` (`lib_name`);

--
-- Indexes for table `student_assigned_chapter_item`
--
ALTER TABLE `student_assigned_chapter_item`
  ADD PRIMARY KEY (`stu_id`,`chapter_id`,`item_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_student`
--
ALTER TABLE `user_student`
  ADD PRIMARY KEY (`stu_id`),
  ADD KEY `student_group` (`stu_group`),
  ADD KEY `stu_department` (`stu_dept_id`);

--
-- Indexes for table `user_supervisor`
--
ALTER TABLE `user_supervisor`
  ADD PRIMARY KEY (`supervisor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercise_constrain`
--
ALTER TABLE `exercise_constrain`
  MODIFY `constrain_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exercise_submission`
--
ALTER TABLE `exercise_submission`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exercise_testcase`
--
ALTER TABLE `exercise_testcase`
  MODIFY `testcase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_exercise`
--
ALTER TABLE `lab_exercise`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_lab_staff`
--
ALTER TABLE `class_lab_staff`
  ADD CONSTRAINT `staff_detail` FOREIGN KEY (`staff_id`) REFERENCES `user_supervisor` (`supervisor_id`),
  ADD CONSTRAINT `staff_for_class` FOREIGN KEY (`class_id`) REFERENCES `class_schedule` (`group_id`);

--
-- Constraints for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD CONSTRAINT `class_leader` FOREIGN KEY (`lecturer`) REFERENCES `user_supervisor` (`supervisor_id`),
  ADD CONSTRAINT `department_name` FOREIGN KEY (`department`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `group_assigned_exercise`
--
ALTER TABLE `group_assigned_exercise`
  ADD CONSTRAINT `for_group` FOREIGN KEY (`group_id`) REFERENCES `class_schedule` (`group_id`),
  ADD CONSTRAINT `group` FOREIGN KEY (`exercise_id`) REFERENCES `lab_exercise` (`exercise_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
