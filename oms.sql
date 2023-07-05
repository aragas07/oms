-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2023 at 04:45 PM
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
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` int(11) NOT NULL,
  `about` longtext DEFAULT NULL,
  `municipality_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `abouts`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `receivecall` varchar(255) DEFAULT NULL,
  `location` longtext DEFAULT NULL,
  `dispatched` time DEFAULT NULL,
  `arrivalscene` longtext DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `municipality_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `alarmstatus` varchar(255) DEFAULT NULL,
  `fireout` time DEFAULT NULL,
  `occupancy` longtext DEFAULT NULL,
  `fatality` longtext DEFAULT NULL,
  `damage` longtext DEFAULT NULL,
  `returnedunit` varchar(255) DEFAULT NULL,
  `commander` varchar(100) DEFAULT NULL,
  `commandercontact` varchar(45) DEFAULT NULL,
  `sender` varchar(100) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `firetruck` varchar(105) DEFAULT NULL,
  `cause` varchar(255) DEFAULT NULL,
  `summary` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE `help` (
  `municipality_id` int(11) DEFAULT NULL,
  `activities` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `users_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `assignment` longtext DEFAULT NULL,
  `timein` time DEFAULT NULL,
  `timeout` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Mati', 'mati.png'),
(2, 'Lupon', 'lupon.png'),
(3, 'Cateel', 'cateel.png'),
(4, 'Baganga', 'baganga.png'),
(5, 'Tarragona', 'tarragona.png'),
(6, 'Gov. Gen', 'govgen.png'),
(7, 'Manay', 'manay.png'),
(8, 'Boston', 'boston.png'),
(9, 'BanayBanay', 'banaybanay.png'),
(10, 'Caraga', 'caraga.png'),
(11, 'San Isidro', 'sanisidro.png');

-- --------------------------------------------------------

--
-- Table structure for table `responded_personnel`
--

CREATE TABLE `responded_personnel` (
  `users_id` int(11) DEFAULT NULL,
  `activities_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responded_team`
--

CREATE TABLE `responded_team` (
  `activities_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responding_vehicle`
--

CREATE TABLE `responding_vehicle` (
  `activity_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responding_vehicle`
--

INSERT INTO `responding_vehicle` (`activity_id`, `vehicle_id`) VALUES
(1, 1),
(2, 1),
(1, 3),
(2, 2),
(1, 4),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `municipality_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `municipality_id`, `status`) VALUES
(1, 'Team payaman', 1, 1),
(2, 'team 1', 1, 1),
(3, 'team 2', 1, 0),
(4, 'new team', 1, 0),
(5, 'argie teams', 1, 0),
(6, 'ragas team', 1, 0),
(7, 'codog team', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `badge` int(13) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` longtext NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `usertype` varchar(10) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `municipality_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'vehicle', 'Medium Fire engine', 1, 1),
(2, 'vehicle #2', 'Heavy Fire engine', 0, 1),
(3, 'vehicle #3', 'Medium Fire engine', 0, 1),
(4, 'vehicle #4', 'Light Fire engine', 0, 1),
(5, 'vehicle #1', 'Medium Fire engine', 0, 2),
(6, 'vehicle #2', 'Heavy Fire engine', 0, 2),
(7, 'vehicle #3', 'Medium Fire engine', 0, 2),
(8, 'vehicle #4', 'Light Fire engine', 0, 2),
(9, 'vehicle #1', 'Medium Fire engine', 0, 3),
(10, 'vehicle #2', 'Heavy Fire engine', 0, 3),
(11, 'vehicle #3', 'Medium Fire engine', 0, 3),
(12, 'vehicle #4', 'Light Fire engine', 0, 3),
(13, 'vehicle #1', 'Medium Fire engine', 0, 4),
(14, 'vehicle #2', 'Heavy Fire engine', 0, 4),
(15, 'vehicle #3', 'Medium Fire engine', 0, 4),
(16, 'vehicle #4', 'Light Fire engine', 0, 4),
(17, 'vehicle #1', 'Medium Fire engine', 0, 5),
(18, 'vehicle #2', 'Heavy Fire engine', 0, 5),
(19, 'vehicle #3', 'Medium Fire engine', 0, 5),
(20, 'vehicle #4', 'Light Fire engine', 0, 5),
(21, 'vehicle #1', 'Medium Fire engine', 0, 6),
(22, 'vehicle #2', 'Heavy Fire engine', 0, 6),
(23, 'vehicle #3', 'Medium Fire engine', 0, 6),
(24, 'vehicle #4', 'Light Fire engine', 0, 6),
(26, 'asdfa', 'sdfasdfa', NULL, 1),
(27, 'asdfdasf', 'adfadsf', NULL, 1),
(28, 'asdfasd', 'asdfasf', NULL, 1),
(29, 'asdfasdasdfasfasdf', 'asdfasfasdfadsfasdfsdf', NULL, 1),
(30, 'asdfasdf', 'asdfasdfasdfasdfadf', NULL, 1),
(31, 'asdf', 'asdf', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_activities_municipality1_idx` (`municipality_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD KEY `fk_logs_users1_idx` (`users_id`);

--
-- Indexes for table `municipality`
--
ALTER TABLE `municipality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responded_personnel`
--
ALTER TABLE `responded_personnel`
  ADD KEY `fk_table1_users_idx` (`users_id`),
  ADD KEY `fk_table1_activities1_idx` (`activities_id`);

--
-- Indexes for table `responded_team`
--
ALTER TABLE `responded_team`
  ADD KEY `fk_activities_has_team_team1_idx` (`team_id`),
  ADD KEY `fk_activities_has_team_activities1_idx` (`activities_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_team1_idx` (`team_id`),
  ADD KEY `fk_users_municipality1_idx` (`municipality_id`);

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
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `municipality`
--
ALTER TABLE `municipality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `fk_activities_municipality1` FOREIGN KEY (`municipality_id`) REFERENCES `municipality` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_logs_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `responded_personnel`
--
ALTER TABLE `responded_personnel`
  ADD CONSTRAINT `fk_table1_activities1` FOREIGN KEY (`activities_id`) REFERENCES `activities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_table1_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_municipality1` FOREIGN KEY (`municipality_id`) REFERENCES `municipality` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_municipality1` FOREIGN KEY (`municipality_id`) REFERENCES `municipality` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_team1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `fk_vehicle_municipality1` FOREIGN KEY (`municipality_id`) REFERENCES `municipality` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
