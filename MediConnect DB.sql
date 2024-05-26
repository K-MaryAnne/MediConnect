CREATE DATABASE IF NOT EXISTS MediConnect;
CREATE TABLE `nurses` (
    `User_ID` int(10) NOT NULL,
    `Role_ID` varchar(15) NOT NULL,
    `First_Name` varchar(20) NOT NULL,
    `Last_Name` varchar(20) NOT NULL,
    `Years_of_Experience` int(10) NOT NULL,
    `Rating` varchar(15) NOT NULL,
    PRIMARY KEY (`User_ID`, `Role_ID`),
    UNIQUE KEY `User_ID` (`User_ID`, `Role_ID`)
);

CREATE TABLE `patients` (
    `User_ID` int(10) NOT NULL,
    `Role_ID` varchar(15) NOT NULL,
    `First_Name` varchar(20) NOT NULL,
    `Last_Name` varchar(20) NOT NULL
);

CREATE TABLE `roles` (
    `Role_ID` int(11) NOT NULL AUTO_INCREMENT,
    `Role_Name` varchar(20) NOT NULL,
    `Description` text NOT NULL,
    `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`Role_ID`),
    UNIQUE KEY `Role_ID` (`Role_ID`)
);

CREATE TABLE `users` (
    `User_id` int(11) NOT NULL AUTO_INCREMENT,
    `First_Name` varchar(20) NOT NULL,
    `Last_Name` varchar(20) NOT NULL,
    `Other_Names` varchar(20) NOT NULL,
    `E_mail` varchar(50) NOT NULL,
    `Phone_Number` varchar(15) NOT NULL,
    `Password` varchar(20) NOT NULL,
    `Gender` varchar(10) NOT NULL,
    `Age` int(3) NOT NULL,
    PRIMARY KEY (`User_id`),
    UNIQUE KEY `User_ID` (`User_id`, `E_mail`)
);

CREATE TABLE `user_roles` (
    `E_mail` varchar(50) NOT NULL,
    `User_ID` int(10) NOT NULL,
    `Role_ID` varchar(20) NOT NULL,
    `Assigned_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`User_ID`, `Role_ID`),
    UNIQUE KEY `User_ID` (`User_ID`, `Role_ID`),
    UNIQUE KEY `User_ID_2` (`User_ID`)
);

-- Alter the `users` table to add new columns
ALTER TABLE users
ADD COLUMN verification_token VARCHAR(255) NULL AFTER Password,
ADD COLUMN status TINYINT(1) NOT NULL DEFAULT 0 AFTER verification_token;
