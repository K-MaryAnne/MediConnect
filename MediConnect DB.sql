-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 02:33 PM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`User_ID`, `Role_ID`, `First_Name`, `Last_Name`, `Email`, `status`, `phone_number`, `address`, `town`, `date_of_birth`, `profile_photo`) VALUES
(95, 1, 'Tony', 'Stark', 'maryanne.kariuki.k@gmail.com', 'active', '+254 711 138 45', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `Rating` double NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `denied_applications`
--

CREATE TABLE `denied_applications` (
  `User_ID` int(11) NOT NULL,
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
-- Triggers `doctors`
--
DELIMITER $$
CREATE TRIGGER `suspend_doctor` BEFORE UPDATE ON `doctors` FOR EACH ROW BEGIN
    IF NEW.status = 'suspended' THEN
        INSERT INTO suspended_healthcare_providers (User_ID, Role_ID, First_Name, Last_Name, Email, Specialisation, Years_of_Experience, Rating, status, Suspended_At)
        VALUES (OLD.User_ID, 5, OLD.First_Name, OLD.Last_Name, OLD.Email, OLD.Specialisation, OLD.Years_of_Experience, OLD.Rating, 'suspended', CURRENT_TIMESTAMP);
        
        DELETE FROM doctors WHERE User_ID = OLD.User_ID;
        UPDATE users SET Role_ID = 5, is_suspended = 1 WHERE User_id = OLD.User_ID;
    END IF;
END
$$
DELIMITER ;

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

--
-- Dumping data for table `nurses`
--

INSERT INTO `nurses` (`User_ID`, `Role_ID`, `First_Name`, `Last_Name`, `Email`, `Specialisation`, `Years_of_Experience`, `Rating`, `status`) VALUES
(90, 3, 'Maria', 'Atieno', '', '', 5, 4, 'active'),
(91, 3, 'Moses', 'Waweru', '', '', 7, 5, 'active'),
(92, 3, 'Immaculate', 'Kubai', '', '', 3, 3, 'active'),
(93, 3, 'Tony', 'Hawk', '', '', 10, 4, 'active'),
(94, 3, 'Papa', 'Shirandula', '', '', 4, 3, 'active'),
(96, 3, 'Martin', 'Luther', 'kariuki.mary@strathmore.edu', 'Pedtriatic care', 14, 0, 'active');

--
-- Triggers `nurses`
--
DELIMITER $$
CREATE TRIGGER `suspend_nurse` BEFORE UPDATE ON `nurses` FOR EACH ROW BEGIN
    IF NEW.status = 'suspended' THEN
        INSERT INTO suspended_healthcare_providers (User_ID, Role_ID, First_Name, Last_Name, Email, Specialisation, Years_of_Experience, Rating, status, Suspended_At)
        VALUES (OLD.User_ID, 5, OLD.First_Name, OLD.Last_Name, OLD.Email, OLD.Specialisation, OLD.Years_of_Experience, OLD.Rating, 'suspended', CURRENT_TIMESTAMP);
        
        DELETE FROM nurses WHERE User_ID = OLD.User_ID;
        UPDATE users SET Role_ID = 5, is_suspended = 1 WHERE User_id = OLD.User_ID;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `address` text DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rate_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `rating` double NOT NULL,
  `review` varchar(255) NOT NULL,
  `created at` timestamp NOT NULL DEFAULT current_timestamp()
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
-- Table structure for table `suspended_healthcare_providers`
--

CREATE TABLE `suspended_healthcare_providers` (
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Specialisation` varchar(50) NOT NULL,
  `Years_of_Experience` int(10) NOT NULL,
  `Rating` int(2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'suspended',
  `Suspended_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `Status` int(1) NOT NULL DEFAULT 0,
  `Role_ID` int(11) NOT NULL DEFAULT 4,
  `is_suspended` tinyint(1) NOT NULL DEFAULT 0,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `First_Name`, `Last_Name`, `Other_Names`, `Email`, `Phone_Number`, `Password`, `Gender`, `Age`, `Verification_Token`, `Reset_Token`, `Status`, `Role_ID`, `is_suspended`, `profile_photo`) VALUES
(17, 'Mary ', 'Kariuki', '', 'mnjeri901@gmail.com', '+254 711 138 45', '$2y$10$SLj5X2oQIzgtxReEIP2bB.crBVById0p2DoR2sSR/1UFihJE0NRVi', 'female', 0, NULL, NULL, 1, 2, 0, NULL),
(80, 'Charlene', 'Ruto', '', 'patient1@example.com', '+1234567895', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'female', 50, NULL, NULL, 1, 4, 0, NULL),
(81, 'William', 'Ruto', '', 'patient2@example.com', '+1234567896', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'male', 45, NULL, NULL, 1, 4, 0, NULL),
(82, 'Rigathi', 'Gachagua', '', 'patient3@example.com', '+1234567897', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'female', 38, NULL, NULL, 1, 4, 0, NULL),
(90, 'Maria', 'Atieno', '', 'nurse1@example.com', '+1234567890', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'female', 30, NULL, NULL, 1, 4, 0, NULL),
(91, 'Moses', 'Waweru', '', 'nurse2@example.com', '+1234567891', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'male', 35, NULL, NULL, 1, 4, 0, NULL),
(92, 'Immaculate', 'Kubai', '', 'nurse3@example.com', '+1234567892', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'female', 28, NULL, NULL, 1, 4, 0, NULL),
(93, 'Tony', 'Hawk', '', 'nurse4@example.com', '+1234567893', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'male', 40, NULL, NULL, 1, 4, 0, NULL),
(94, 'Papa', 'Shirandula', '', 'nurse5@example.com', '+1234567894', '$2y$10$eW5qai9aQJ5sWjN1ZVJkSeU/Wn1FJ4yPpOKbN6FZW7BHpG8RL7ULm', 'female', 32, NULL, NULL, 1, 4, 0, NULL),
(95, 'Tony', 'Stark', '', 'maryanne.kariuki.k@gmail.com', '+254 711 138 45', '$2y$10$OdrvBe4zBda7GATdQySNce5ES1G0vGACsxPfpzfxaAfJKAU4j4kK6', 'male', 0, NULL, NULL, 1, 1, 0, NULL),
(96, 'Martin', 'Luther', '', 'kariuki.mary@strathmore.edu', '+254 711 137 45', '$2y$10$shTvH1t8vhLyKV2ZlQ70f.SxWpbxDQDsD3xtH5MUUc9IPdjhgCqyK', 'male', 0, '0b36eece809eeabc4e845691239164b0', NULL, 0, 3, 0, NULL);

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
(16, 17, 'Mary ', 'Kariuki', 'mnjeri901@gmail.com', 'Doctor', 4, 'Oncology', 0, 'accepted'),
(17, 96, 'Martin', 'Luther', 'kariuki.mary@strathmore.edu', 'Nurse', 4, 'Pedtriatic care', 0, 'accepted'),
(18, 17, 'Mary ', 'Kariuki', 'mnjeri901@gmail.com', 'Doctor', 4, 'Oncology', 0, 'accepted'),
(19, 17, 'Mary ', 'Kariuki', 'mnjeri901@gmail.com', 'Doctor', 4, 'Oncology', 0, 'denied'),
(20, 17, 'Mary ', 'Kariuki', 'mnjeri901@gmail.com', 'Doctor', 4, 'Oncology', 0, 'denied');

--
-- Triggers `user_applications`
--
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
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`User_ID`,`Role_ID`),
  ADD UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctor_id` (`Role_ID`),
  ADD UNIQUE KEY `User_id_2` (`User_id`,`Role_ID`),
  ADD KEY `user_id` (`User_id`),
  ADD KEY `doctor_user_id` (`Role_ID`);

--
-- Indexes for table `denied_applications`
--
ALTER TABLE `denied_applications`
  ADD PRIMARY KEY (`User_ID`);

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
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rate_id`),
  ADD UNIQUE KEY `rate_id` (`rate_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Role_ID`),
  ADD UNIQUE KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `suspended_healthcare_providers`
--
ALTER TABLE `suspended_healthcare_providers`
  ADD PRIMARY KEY (`User_ID`,`Role_ID`),
  ADD UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `admins_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `users` (`User_id`);

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
-- Constraints for table `suspended_healthcare_providers`
--
ALTER TABLE `suspended_healthcare_providers`
  ADD CONSTRAINT `suspended_healthcare_providers_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `suspended_healthcare_providers_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);

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
