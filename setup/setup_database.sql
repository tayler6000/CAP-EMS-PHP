SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

CREATE TABLE `audit` (
  `id` int NOT NULL,
  `sortie_type` enum('ground','air','sUAS') NOT NULL,
  `sortie_id` int NOT NULL,
  `entry` text NOT NULL,
  `timestamp` int NOT NULL,
  `WMIRS` enum('true', 'false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `audit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `deployed_air` (
  `id` int NOT NULL,
  `mission` varchar(255) NOT NULL,
  `sortie` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `callsign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Assigned',
  `mp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Assigned',
  `mo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Assigned',
  `ms_ap` varchar(255) NOT NULL DEFAULT 'Not Assigned',
  `status` enum('Initiating','Tasked','Briefing','In Progress','RTB','Debriefing','Completed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `location` varchar(1000) NOT NULL,
  `checkin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `deployed_air`
  ADD PRIMARY KEY (`mission`,`sortie`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `deployed_air`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


CREATE TABLE `deployed_ground` (
  `id` int NOT NULL,
  `mission` varchar(255) NOT NULL,
  `sortie` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `cov` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Assigned',
  `driver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Assigned',
  `leader` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Assigned',
  `passengers` int NOT NULL DEFAULT '0',
  `status` enum('Initiating','Tasked','Briefing','In Progress','RTB','Debriefing','Completed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `location` varchar(1000) NOT NULL,
  `checkin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `deployed_ground`
  ADD PRIMARY KEY (`mission`,`sortie`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `deployed_ground`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `deployed_suas` (
  `id` int NOT NULL,
  `mission` varchar(255) NOT NULL,
  `sortie` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `ground_id` int DEFAULT NULL,
  `mp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Assigned',
  `status` enum('Initiating','Tasked','Briefing','In Progress','RTB','Debriefing','Completed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `location` varchar(1000) NOT NULL,
  `checkin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `deployed_suas`
  ADD PRIMARY KEY (`mission`,`sortie`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `deployed_suas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `settings` (
  `setting` varchar(255) NOT NULL,
  `value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `settings` (`setting`, `value`) VALUES
('air_late', 35),
('air_warning', 30),
('ground_late', 35),
('ground_warning', 30),
('suas_late', 35),
('suas_warning', 30);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
