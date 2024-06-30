-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2024 at 04:43 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `denied_applications`
--

CREATE TABLE `denied_applications` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_applied_for` varchar(50) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `Specialisation` varchar(50) NOT NULL,
  `Years_of_Experience` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Specialisation` varchar(50) NOT NULL,
  `Years_of_Experience` int(10) NOT NULL,
  `Rating` int(2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`User_ID`, `Role_ID`, `First_Name`, `Last_Name`, `Email`, `Specialisation`, `Years_of_Experience`, `Rating`, `status`) VALUES
(17, 2, 'Mary ', 'Kariuki', '', '', 0, 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Specialisation` varchar(50) NOT NULL,
  `Years_of_Experience` int(10) NOT NULL,
  `Rating` int(2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Role_ID` int(11) NOT NULL,
  `Role_Name` varchar(20) NOT NULL,
  `Description` text NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Role_ID`, `Role_Name`, `Description`, `Created_at`) VALUES
(1, 'admin', 'Administrator Role', '2024-06-30 10:22:12'),
(2, 'doctor', 'Doctor Role', '2024-06-30 10:22:12'),
(3, 'nurse', 'Nurse Role', '2024-06-30 10:22:12'),
(4, 'patient', 'Patient Role', '2024-06-30 10:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Other_Names` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone_Number` varchar(15) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Age` int(3) NOT NULL,
  `Verification_Token` varchar(32) DEFAULT NULL,
  `Reset_Token` varchar(32) DEFAULT NULL,
  `Status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `First_Name`, `Last_Name`, `Other_Names`, `Email`, `Phone_Number`, `Password`, `Gender`, `Age`, `Verification_Token`, `Reset_Token`, `Status`) VALUES
(17, 'Mary ', 'Kariuki', '', 'maryanne.kariuki.k@gmail.com', '+254 711 138 45', '$2y$10$SLj5X2oQIzgtxReEIP2bB.crBVById0p2DoR2sSR/1UFihJE0NRVi', 'female', 0, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_applications`
--

CREATE TABLE `user_applications` (
  `id` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_applied_for` varchar(50) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `Specialisation` varchar(50) NOT NULL,
  `Years_of_Experience` int(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_applications`
--

INSERT INTO `user_applications` (`id`, `User_ID`, `first_name`, `last_name`, `email`, `role_applied_for`, `Role_ID`, `Specialisation`, `Years_of_Experience`, `status`) VALUES
(2, 17, 'Mary ', 'Kariuki', 'maryanne.kariuki.k@gmail.com', 'Doctor', 2, '', 0, 'accepted');

--
-- Triggers `user_applications`
--
DELIMITER $$
CREATE TRIGGER `accept_application_trigger` AFTER UPDATE ON `user_applications` FOR EACH ROW BEGIN
    DECLARE v_count INT;

    -- Check if the user already exists in doctors/nurses table
    SELECT COUNT(*) INTO v_count
    FROM doctors
    WHERE User_ID = NEW.User_ID AND Role_ID = NEW.Role_ID;

    IF v_count = 0 THEN
        -- Insert into doctors table if not already exists
        IF NEW.role_applied_for = 'Doctor' THEN
            INSERT INTO `doctors` (`User_ID`, `Role_ID`, `First_Name`, `Last_Name`, `Email`, `Specialisation`, `Years_of_Experience`, `Rating`, `status`)
            SELECT `User_ID`, NEW.`Role_ID`, `first_name`, `last_name`, `email`, `Specialisation`, `Years_of_Experience`, 0, 'active'
            FROM `user_applications`
            WHERE `id` = NEW.id;

            DELETE FROM `user_applications` WHERE `id` = NEW.id;

        -- Insert into nurses table if not already exists
        ELSEIF NEW.role_applied_for = 'Nurse' THEN
            INSERT INTO `nurses` (`User_ID`, `Role_ID`, `First_Name`, `Last_Name`, `Years_of_Experience`, `Rating`)
            SELECT `User_ID`, NEW.`Role_ID`, `first_name`, `last_name`, `Years_of_Experience`, 0
            FROM `user_applications`
            WHERE `id` = NEW.id;

            DELETE FROM `user_applications` WHERE `id` = NEW.id;
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deny_application_trigger` AFTER UPDATE ON `user_applications` FOR EACH ROW BEGIN
    IF NEW.status = 'Denied' THEN
        INSERT INTO `denied_applications` (`id`, `first_name`, `last_name`, `email`, `role_applied_for`, `Role_ID`, `Specialisation`, `Years_of_Experience`)
        SELECT `id`, `first_name`, `last_name`, `email`, `role_applied_for`, `Role_ID`, `Specialisation`, `Years_of_Experience`
        FROM `user_applications`
        WHERE `id` = NEW.id;

        DELETE FROM `user_applications` WHERE `id` = NEW.id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `populate_user_data_before_insert` BEFORE INSERT ON `user_applications` FOR EACH ROW BEGIN
    DECLARE v_user_id INT;
    
    -- Fetch User_ID from users table based on the email
    SELECT `User_id` INTO v_user_id
    FROM `users`
    WHERE `Email` = NEW.email;
    
    -- Set the fetched User_ID and email into the new row
    SET NEW.`User_ID` = v_user_id;
    SET NEW.`email` = NEW.email;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `Email` varchar(50) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `Assigned_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `denied_applications`
--
ALTER TABLE `denied_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`User_ID`,`Role_ID`),
  ADD UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`User_ID`,`Role_ID`),
  ADD UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`User_ID`,`Role_ID`),
  ADD UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Role_ID`),
  ADD UNIQUE KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `user_applications`
--
ALTER TABLE `user_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`User_ID`,`Role_ID`),
  ADD UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `denied_applications`
--
ALTER TABLE `denied_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `doctors_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);

--
-- Constraints for table `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `nurses_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `patients_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
