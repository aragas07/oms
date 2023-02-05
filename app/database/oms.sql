-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2023 at 02:28 PM
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
-- Database: `oms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `location` longtext DEFAULT NULL,
  `date` date DEFAULT NULL,
  `team_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `team_id`, `activity`, `location`, `date`, `team_status`) VALUES
(1, 16, 'building fire', 'Gov. gen', '2022-03-10', 1),
(2, 17, 'building fire', 'Gov. gen', '2022-03-10', 1),
(3, 1, 'Grass fire', 'Lupon City', '2022-07-10', 1),
(4, 1, 'building fire', 'Lupon City', '2022-10-10', 1),
(5, 17, 'building fire', 'Lupon City', '2022-10-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `municipality`
--

CREATE TABLE `municipality` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `img` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `municipality`
--

INSERT INTO `municipality` (`id`, `name`, `img`) VALUES
(7, 'Mati', 'mati.png'),
(8, 'Lupon', 'lupon.png'),
(9, 'Cateel', 'cateel.png'),
(10, 'Baganga', 'baganga.png'),
(11, 'Tarragona', 'tarragona.png'),
(12, 'Gov. Gen', 'govgen.png');

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `assignment` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`id`, `team_id`, `firstname`, `middlename`, `lastname`, `status`, `assignment`) VALUES
(1, 1, 'Jhon', 'Craig', 'Doe', 1, 'none'),
(2, 1, 'Tom', '', 'Cruise', 1, 'none'),
(3, 1, 'Johnny', NULL, 'Deep', 1, 'none'),
(4, 16, 'Will', NULL, 'Smith', 1, 'none'),
(5, 16, 'Robert', '', 'De Niro', 1, 'none'),
(6, 16, 'Adam ', NULL, 'Sandler', 1, 'none'),
(7, 17, 'Leonardo', NULL, 'DiCaprio', 1, 'none'),
(8, 17, 'Robert', NULL, 'Downey Jr.', 1, 'none'),
(9, 17, 'Vin', NULL, 'Diesel', 1, 'none');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `municipality_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `municipality_id`) VALUES
(1, 'team 1', 7),
(2, 'team 2', 7),
(3, 'team 3', 7),
(4, 'team 1', 8),
(5, 'team 2', 8),
(6, 'team 3', 8),
(7, 'team 1', 9),
(8, 'team 2', 9),
(9, 'team 3', 9),
(10, 'team 1', 10),
(11, 'team 2', 10),
(12, 'team 3', 10),
(13, 'team 1', 11),
(14, 'team 2', 11),
(15, 'team 3', 11),
(16, 'team 1', 12),
(17, 'team 2', 12),
(18, 'team 3', 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` longtext NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `middlename`, `lastname`) VALUES
(2, 'greg', 'ea26b0075d29530c636d6791bb5d73f4', 'gregorio', 'justol', 0),
(3, 'argie', '6cf51b9070c74b2b7b90a24428e9a99b', 'argie', 'codog', 0),
(4, 'grego', '4bb76b889a9e86b5d54fb11d1e4134d5', 'grego', 'justol', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `vehicle` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `municipality_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicle`, `type`, `status`, `municipality_id`) VALUES
(1, 'vehicle #1', 'Medium Fire engine', 1, 7),
(2, 'vehicle #2', 'Heavy Fire engine', 1, 7),
(3, 'vehicle #3', 'Medium Fire engine', 1, 7),
(4, 'vehicle #4', 'Light Fire engine', 1, 7),
(5, 'vehicle #1', 'Medium Fire engine', 1, 8),
(6, 'vehicle #2', 'Heavy Fire engine', 1, 8),
(7, 'vehicle #3', 'Medium Fire engine', 1, 8),
(8, 'vehicle #4', 'Light Fire engine', 1, 8),
(9, 'vehicle #1', 'Medium Fire engine', 1, 9),
(10, 'vehicle #2', 'Heavy Fire engine', 1, 9),
(11, 'vehicle #3', 'Medium Fire engine', 1, 9),
(12, 'vehicle #4', 'Light Fire engine', 1, 9),
(13, 'vehicle #1', 'Medium Fire engine', 1, 10),
(14, 'vehicle #2', 'Heavy Fire engine', 1, 10),
(15, 'vehicle #3', 'Medium Fire engine', 1, 10),
(16, 'vehicle #4', 'Light Fire engine', 1, 10),
(17, 'vehicle #1', 'Medium Fire engine', 1, 11),
(18, 'vehicle #2', 'Heavy Fire engine', 1, 11),
(19, 'vehicle #3', 'Medium Fire engine', 1, 11),
(20, 'vehicle #4', 'Light Fire engine', 1, 11),
(21, 'vehicle #1', 'Medium Fire engine', 1, 12),
(22, 'vehicle #2', 'Heavy Fire engine', 1, 12),
(23, 'vehicle #3', 'Medium Fire engine', 1, 12),
(24, 'vehicle #4', 'Light Fire engine', 1, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_activities_team1_idx` (`team_id`);

--
-- Indexes for table `municipality`
--
ALTER TABLE `municipality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personnel_team1_idx` (`team_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_team_municipality1_idx` (`municipality_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vehicle_municipality1_idx` (`municipality_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `municipality`
--
ALTER TABLE `municipality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `fk_activities_team1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `fk_personnel_team1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_municipality1` FOREIGN KEY (`municipality_id`) REFERENCES `municipality` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `fk_vehicle_municipality1` FOREIGN KEY (`municipality_id`) REFERENCES `municipality` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
