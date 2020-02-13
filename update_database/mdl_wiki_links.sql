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
-- Table structure for table `mdl_wiki_links`
--

CREATE TABLE `mdl_wiki_links` (
  `id` bigint(10) NOT NULL,
  `subwikiid` bigint(10) NOT NULL DEFAULT 0,
  `frompageid` bigint(10) NOT NULL DEFAULT 0,
  `topageid` bigint(10) NOT NULL DEFAULT 0,
  `tomissingpage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Page wiki links' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_wiki_links`
--

INSERT INTO `mdl_wiki_links` (`id`, `subwikiid`, `frompageid`, `topageid`, `tomissingpage`) VALUES
(69, 1, 4, 1, NULL),
(70, 1, 4, 2, NULL),
(71, 1, 4, 3, NULL),
(72, 1, 4, 4, NULL),
(77, 1, 3, 1, NULL),
(78, 1, 3, 2, NULL),
(79, 1, 3, 3, NULL),
(80, 1, 3, 4, NULL),
(81, 1, 1, 1, NULL),
(82, 1, 1, 2, NULL),
(83, 1, 1, 3, NULL),
(84, 1, 1, 4, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_wiki_links`
--
ALTER TABLE `mdl_wiki_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_wikilink_fro_ix` (`frompageid`),
  ADD KEY `mdl_wikilink_sub_ix` (`subwikiid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_wiki_links`
--
ALTER TABLE `mdl_wiki_links`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
