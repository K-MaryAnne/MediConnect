CREATE DATABASE IF NOT EXISTS MediConnect;
CREATE TABLE `doctors` (
 `User_ID` int(10) NOT NULL,
 `Role_ID` varchar(20) NOT NULL,
 `First Name` varchar(50) NOT NULL,
 `Last Name` varchar(50) NOT NULL,
 `Specialisation` varchar(50) NOT NULL,
 `Years of Experience` int(10) NOT NULL,
 `Rating` int(15) NOT NULL,
 PRIMARY KEY (`User_ID`,`Role_ID`),
 UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`)
) ;
CREATE TABLE `nurses` (
 `User_ID` int(10) NOT NULL,
 `Role_ID` varchar(15) NOT NULL,
 `First Name` varchar(20) NOT NULL,
 `Last Name` varchar(20) NOT NULL,
 `Years of Experience` int(10) NOT NULL,
 `Rating` varchar(15) NOT NULL,
 PRIMARY KEY (`User_ID`,`Role_ID`),
 UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`)
) 
CREATE TABLE `patients` (
 `User_ID` int(10) NOT NULL,
 `Role_ID` varchar(15) NOT NULL,
 `First Name` varchar(20) NOT NULL,
 `Last Name` varchar(20) NOT NULL
)
CREATE TABLE `roles` (
 `Role_ID` int(11) NOT NULL AUTO_INCREMENT,
 `Role_Name` varchar(20) NOT NULL,
 `Description` text NOT NULL,
 `Created at` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`Role_ID`),
 UNIQUE KEY `Role_ID` (`Role_ID`)
)
CREATE TABLE `users` (
 `User_id` int(11) NOT NULL AUTO_INCREMENT,
 `First Name` varchar(20) NOT NULL,
 `Last Name` varchar(20) NOT NULL,
 `Other Names` varchar(20) NOT NULL,
 `E-mail` varchar(50) NOT NULL,
 `Phone Number` int(15) NOT NULL,
 `Password` varchar(20) NOT NULL,
 `Gender` varchar(10) NOT NULL,
 `Age` int(3) NOT NULL,
 PRIMARY KEY (`E-mail`),
 UNIQUE KEY `User_ID` (`User_id`,`E-mail`)
) 
CREATE TABLE `user_roles` (
 `E-Mail` varchar(50) NOT NULL,
 `User_ID` int(10) NOT NULL,
 `Role_ID` varchar(20) NOT NULL,
 `Assigned at` datetime NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`User_ID`,`Role_ID`),
 UNIQUE KEY `User_ID` (`User_ID`,`Role_ID`),
 UNIQUE KEY `User_ID_2` (`User_ID`)
)