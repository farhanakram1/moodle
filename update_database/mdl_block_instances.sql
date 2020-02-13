-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 06:10 PM
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
-- Table structure for table `mdl_block_instances`
--

CREATE TABLE `mdl_block_instances` (
  `id` bigint(10) NOT NULL,
  `blockname` varchar(40) NOT NULL DEFAULT '',
  `parentcontextid` bigint(10) NOT NULL,
  `showinsubcontexts` smallint(4) NOT NULL,
  `requiredbytheme` smallint(4) NOT NULL DEFAULT 0,
  `pagetypepattern` varchar(64) NOT NULL DEFAULT '',
  `subpagepattern` varchar(16) DEFAULT NULL,
  `defaultregion` varchar(16) NOT NULL DEFAULT '',
  `defaultweight` bigint(10) NOT NULL,
  `configdata` longtext DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='This table stores block instances. The type of block this is' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_block_instances`
--

INSERT INTO `mdl_block_instances` (`id`, `blockname`, `parentcontextid`, `showinsubcontexts`, `requiredbytheme`, `pagetypepattern`, `subpagepattern`, `defaultregion`, `defaultweight`, `configdata`, `timecreated`, `timemodified`) VALUES
(1, 'admin_bookmarks', 1, 0, 0, 'admin-*', NULL, 'side-pre', 2, '', 1581427940, 1581427940),
(2, 'timeline', 1, 0, 0, 'my-index', '2', 'side-post', 0, '', 1581427940, 1581427940),
(3, 'private_files', 1, 0, 0, 'my-index', '2', 'side-post', 1, '', 1581427941, 1581427941),
(4, 'online_users', 1, 0, 0, 'my-index', '2', 'side-post', 2, '', 1581427941, 1581427941),
(5, 'badges', 1, 0, 0, 'my-index', '2', 'side-post', 3, '', 1581427941, 1581427941),
(6, 'calendar_month', 1, 0, 0, 'my-index', '2', 'side-post', 4, '', 1581427942, 1581427942),
(7, 'calendar_upcoming', 1, 0, 0, 'my-index', '2', 'side-post', 5, '', 1581427942, 1581427942),
(8, 'lp', 1, 0, 0, 'my-index', '2', 'content', 0, '', 1581427942, 1581427942),
(9, 'recentlyaccessedcourses', 1, 0, 0, 'my-index', '2', 'content', 1, '', 1581427943, 1581427943),
(10, 'myoverview', 1, 0, 0, 'my-index', '2', 'content', 2, '', 1581427943, 1581427943),
(11, 'timeline', 5, 0, 0, 'my-index', '3', 'side-post', 0, '', 1581429223, 1581429223),
(12, 'private_files', 5, 0, 0, 'my-index', '3', 'side-post', 1, '', 1581429224, 1581429224),
(13, 'online_users', 5, 0, 0, 'my-index', '3', 'side-post', 2, '', 1581429224, 1581429224),
(14, 'badges', 5, 0, 0, 'my-index', '3', 'side-post', 3, '', 1581429224, 1581429224),
(15, 'calendar_month', 5, 0, 0, 'my-index', '3', 'side-post', 4, '', 1581429224, 1581429224),
(16, 'calendar_upcoming', 5, 0, 0, 'my-index', '3', 'side-post', 5, '', 1581429225, 1581429225),
(17, 'lp', 5, 0, 0, 'my-index', '3', 'side-pre', 7, '', 1581429225, 1581608784),
(18, 'recentlyaccessedcourses', 5, 0, 0, 'my-index', '3', 'content', 1, '', 1581429225, 1581429225),
(19, 'myoverview', 5, 0, 0, 'my-index', '3', 'content', 2, '', 1581429225, 1581608796),
(20, 'settings', 1, 0, 0, 'admin-search', NULL, 'side-pre', 4, '', 1581433802, 1581433862),
(22, 'slider', 28, 0, 0, 'course-view-*', NULL, 'side-pre', 0, '', 1581608415, 1581608415),
(25, 'html', 26, 0, 0, 'mod-wiki-*', NULL, 'side-pre', 0, 'Tzo4OiJzdGRDbGFzcyI6Mzp7czo1OiJ0aXRsZSI7czowOiIiO3M6NjoiZm9ybWF0IjtzOjE6IjEiO3M6NDoidGV4dCI7czozMDE6Ijxmb3JtIGFjdGlvbj0iIiBtZXRob2Q9InBvc3QiIF9scGNoZWNrZWQ9IjEiPg0KICAgIDxsYWJlbCBmb3I9ImZuYW1lIj5GaXJzdCBuYW1lOjwvbGFiZWw+PGJyPg0KICAgIDxpbnB1dCB0eXBlPSJ0ZXh0IiBpZD0iZm5hbWUiIG5hbWU9ImZuYW1lIj48YnI+DQogICAgPGxhYmVsIGZvcj0ibG5hbWUiPkxhc3QgbmFtZTo8L2xhYmVsPjxicj4NCiAgICA8aW5wdXQgdHlwZT0idGV4dCIgaWQ9ImxuYW1lIiBuYW1lPSJsbmFtZSI+PGJyPjxicj4NCiAgICA8aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0iU3VibWl0Ij4NCjwvZm9ybT4iO30=', 1581609390, 1581611046);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_block_instances`
--
ALTER TABLE `mdl_block_instances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_blocinst_parshopagsub_ix` (`parentcontextid`,`showinsubcontexts`,`pagetypepattern`,`subpagepattern`),
  ADD KEY `mdl_blocinst_tim_ix` (`timemodified`),
  ADD KEY `mdl_blocinst_par_ix` (`parentcontextid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_block_instances`
--
ALTER TABLE `mdl_block_instances`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
