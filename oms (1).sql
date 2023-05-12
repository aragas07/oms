-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 12:58 PM
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

INSERT INTO `abouts` (`id`, `about`, `municipality_id`) VALUES
(1, '<h4>Function and duties</h4> <p>  The BFP is responsible for ensuring public safety through the prevention or suppression of all destructive fires on buildings, houses, and other similar structure, forests, and land transportation vehicles and equipment, ships/vessels docked at piers, wharves or anchored at major seaports, petroleum industry installations. It is also responsible for the enforcement of the Fire Code of the Philippines (PD 1185) and other related laws, conduct investigations involving fire incidents and causes thereof including the filing of appropriate complaints/cases. According to its website, the primary functions of the BFP are </p><ul> <li>Prevention and suppression of all destructive fires;</li> <li>Enforcement of the Revised Implementing Rules and Regulations (RIRR) of the Repubic Act No. 9514 otherwise known as the Fire Code of the Philippines (PD 1185) other related laws; </li> <li>Investigate the causes of fires and if necessary, file a complaint to the city or provincial prosecutor relating to the case; </li> <li>In events of national emergency, will assist the military on the orders of the President of the Philippines;</li> <li>And establish at least one fire station with all personnel and equipment per municipality and provincial capital.</li> </ul> <p></p> <h4>History</h4> <p>  The BFP was formed from the units of the intergrated National Police\'s Office of Fire Protection Service on January 29, 1991 through Republic Act No. 6975, which created the present interior Department and placed the provision of fire services under its control. </p> <p>  Republic Act No. 6975, or the Department of interior and Local Government Act of 1990, took effect on January 1, 1991 and paved the way for the establishment of the Philippine National Police, BFP and Bureau of Jail Management and Penology as separate entities. Specifically, the Fire Bureau\'s charter was created under Chapter IV (Section 53 to 59) of the Implementing Rules and Regulations of the act. The organization was then placed under the direct supervision of the DILG undersecretary for peace as a distinct agency of the government, with the initial preparation of its operation plans and budget (OPB) by F/Brigadier General Ernesto Madriaga, INP (1990-1992), which took over from the long reign of F/Major Primo D. Cordeta (Ret.), the first chief fire marshal (1978-1989). Madriaga served as the BFP\'s first acting fire chief/director from 1991 to 1992. </p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `location` longtext DEFAULT NULL,
  `date` date DEFAULT NULL,
  `summary` longtext DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `municipality_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL
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

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`users_id`, `date`, `status`, `assignment`, `timein`, `timeout`) VALUES
(10, '2023-05-08', 1, '1', '07:09:18', '23:47:01'),
(11, '2023-05-08', 1, NULL, '23:48:11', '00:00:00');

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

--
-- Dumping data for table `responded_team`
--

INSERT INTO `responded_team` (`activities_id`, `team_id`) VALUES
(1, 1),
(2, 1);

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
(2, 1);

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
(1, 'team ', 1, 1),
(2, 'team 1', 1, 0);

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
(24, 'vehicle #4', 'Light Fire engine', 0, 6);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `responded_team`
--
ALTER TABLE `responded_team`
  ADD CONSTRAINT `fk_activities_has_team_activities1` FOREIGN KEY (`activities_id`) REFERENCES `activities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activities_has_team_team1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
