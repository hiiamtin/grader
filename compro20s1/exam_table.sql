--
-- Table structure for table `exam_room`
--
CREATE TABLE `exam_room` (
                             `room_number` int(3) NOT NULL,
                             `class_id` int(11) DEFAULT NULL,
                             `allow_access` enum('checked','unchecked') CHARACTER SET utf8 NOT NULL,
                             `allow_check_in` enum('checked','unchecked') CHARACTER SET utf8 NOT NULL,
                             `in_social_distancing` enum('checked','unchecked') CHARACTER SET utf16 NOT NULL DEFAULT 'unchecked',
                             `is_active` enum('yes','no') CHARACTER SET utf8 NOT NULL,
                             `chapter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `exam_room` (`room_number`, `class_id`, `allow_access`, `allow_check_in`, `in_social_distancing`, `is_active`, `chapter_id`) VALUES
(704, 20020041, 'checked', 'checked', 'checked', 'no', 11),
(706, 0, 'unchecked', 'unchecked', 'unchecked', 'no', NULL);

ALTER TABLE `exam_room`
    ADD PRIMARY KEY (`room_number`);
COMMIT;


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

ALTER TABLE `exam_seat`
    ADD PRIMARY KEY (`room_number`,`seat_number`);
COMMIT;



--
-- Table structure for table `exam_student_swap`
--
CREATE TABLE `exam_student_swap` (
                                     `stu_id` int(8) NOT NULL,
                                     `room_number` int(3) NOT NULL,
                                     `stu_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `exam_student_swap`
    ADD PRIMARY KEY (`stu_id`);
COMMIT;