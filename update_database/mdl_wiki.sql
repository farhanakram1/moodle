-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 06:25 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moodle`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdl_wiki`
--

CREATE TABLE `mdl_wiki` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT 'Wiki',
  `intro` longtext DEFAULT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  `firstpagetitle` varchar(255) NOT NULL DEFAULT 'First Page',
  `wikimode` varchar(20) NOT NULL DEFAULT 'collaborative',
  `defaultformat` varchar(20) NOT NULL DEFAULT 'creole',
  `forceformat` tinyint(1) NOT NULL DEFAULT 1,
  `editbegin` bigint(10) NOT NULL DEFAULT 0,
  `editend` bigint(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores Wiki activity configuration' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_wiki`
--

INSERT INTO `mdl_wiki` (`id`, `course`, `name`, `intro`, `introformat`, `timecreated`, `timemodified`, `firstpagetitle`, `wikimode`, `defaultformat`, `forceformat`, `editbegin`, `editend`) VALUES
(1, 1, 'Moodle', '', 1, 0, 1581595552, 'Home', 'collaborative', 'html', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_wiki`
--
ALTER TABLE `mdl_wiki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_wiki_cou_ix` (`course`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_wiki`
--
ALTER TABLE `mdl_wiki`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
