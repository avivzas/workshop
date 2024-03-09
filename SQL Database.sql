-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: מרץ 09, 2024 בזמן 10:49 PM
-- גרסת שרת: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sadna`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `registrations`
--

CREATE TABLE `registrations` (
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `registrations`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `reservations`
--

CREATE TABLE `reservations` (
  `spaceID` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `reservations`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `workspaces`
--

CREATE TABLE `workspaces` (
  `userName` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `region` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `placeType` varchar(255) NOT NULL,
  `dailyPrice` int(11) NOT NULL,
  `ownerName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pictures` blob DEFAULT NULL,
  `aboutWorkspace` text DEFAULT NULL,
  `reserved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `workspaces`
--
--
-- Indexes for dumped tables
--

--
-- אינדקסים לטבלה `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`userName`);

--
-- אינדקסים לטבלה `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spaceID` (`spaceID`),
  ADD KEY `userName` (`userName`);

--
-- אינדקסים לטבלה `workspaces`
--
ALTER TABLE `workspaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspaces_ibfk_1` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `workspaces`
--
ALTER TABLE `workspaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- הגבלות לטבלאות שהוצאו
--

--
-- הגבלות לטבלה `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`spaceID`) REFERENCES `workspaces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`userName`) REFERENCES `registrations` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- הגבלות לטבלה `workspaces`
--
ALTER TABLE `workspaces`
  ADD CONSTRAINT `workspaces_ibfk_1` FOREIGN KEY (`userName`) REFERENCES `registrations` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
