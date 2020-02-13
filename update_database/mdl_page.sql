-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 06:21 PM
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
-- Table structure for table `mdl_page`
--

CREATE TABLE `mdl_page` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `intro` longtext DEFAULT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT 0,
  `content` longtext DEFAULT NULL,
  `contentformat` smallint(4) NOT NULL DEFAULT 0,
  `legacyfiles` smallint(4) NOT NULL DEFAULT 0,
  `legacyfileslast` bigint(10) DEFAULT NULL,
  `display` smallint(4) NOT NULL DEFAULT 0,
  `displayoptions` longtext DEFAULT NULL,
  `revision` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Each record is one page and its config data' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_page`
--

INSERT INTO `mdl_page` (`id`, `course`, `name`, `intro`, `introformat`, `content`, `contentformat`, `legacyfiles`, `legacyfileslast`, `display`, `displayoptions`, `revision`, `timemodified`) VALUES
(1, 1, 'Home', '', 1, '<p>[[Home]]&nbsp; [[Contact]]&nbsp; [[About Us]] [[Login]]</p>\r\n<div style=\"background-image:url(&quot;@@PLUGINFILE@@/bg.png&quot;);background-repeat:no-repeat;padding:200px 0 200px 0;\">\r\n    <h2 style=\"text-align:center;color:#FFFFFF;\"><b>WELCOME</b></h2>\r\n    <p style=\"text-align:center;color:#FFFFFF;\">to the exam review platform for <b>Dr. Derek Mahony’s</b> EODO Miniresidency students</p>\r\n    <h5 style=\"text-align:center;\"><a href=\"#\" style=\"color:#FFFFFF;\"><b>LEARN MOR</b>E</a></h5>\r\n    <br></div>\r\n<br>\r\n<br>\r\n<h4><img src=\"@@PLUGINFILE@@/left_image.jpg\" alt=\"\" class=\"atto_image_button_left\" width=\"450\" height=\"300\">\r\n</h4>\r\n<br>\r\n\r\n<h4>How it works</h4>\r\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n    <p><b>Login, upload your work, see the results</b></p>\r\n</div>\r\n\r\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n    <div style=\"text-align:left;\">\r\n\r\n    </div>\r\n    <div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n        <div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n            <div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n                <div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n                    <div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n                        <div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n                            <div style=\"margin-left:30px;\" class=\"editor-indent\">\r\n                                <div style=\"text-align:left;\">Create a login<br>Choose the module you would like to submit<br>Upload your exam PDFs and pay for the corrections with PayPal<br>Review your results<br>Obtain the diploma at the end of the EODO Miniresidency Program</div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    <div style=\"text-align:left;\"><a href=\"#\">LOGIN</a></div>\r\n</div>\r\n<br>\r\n<br>\r\n<br>\r\n<br>\r\n<div style=\"text-align:center;\"><img src=\"@@PLUGINFILE@@/image3.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"><img src=\"@@PLUGINFILE@@/image4.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"> <img src=\"@@PLUGINFILE@@/image5.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">\r\n    <img src=\"@@PLUGINFILE@@/image1.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">&nbsp; <img src=\"@@PLUGINFILE@@/image2.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"></div>\r\n<div style=\"text-align:center;\">&nbsp;&nbsp;&nbsp; 24h access&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Review results&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manage exams&nbsp;&nbsp; Deadline overview&nbsp;&nbsp; Easy upload</div>\r\n<div><br></div>\r\n<div>A PLACE THAT<br>PROVIDES ALL TOOLS<br>FOR COMFORTABLE<br>WORK ENVIRONMENT</div>\r\n<div><br></div>\r\n<div style=\"text-align:left;\">This platform provides you with the tools to easily upload and manage<br>your EODO Miniresidency exams and assignments. You can<br>conveniently access your account 24/7 to check on your results and<br>ensure that you fulfil all requirements for your diploma\r\n    at the end of the<br>residency.</div>\r\n<div><br></div>\r\n<div style=\"text-align:center;\"><b>Copyright C 2019 MR Corrections<br>Impressum</b><br></div>', 1, 0, NULL, 5, 'a:3:{s:12:\"printheading\";s:1:\"1\";s:10:\"printintro\";s:1:\"0\";s:17:\"printlastmodified\";s:1:\"1\";}', 2, 1581612263);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_page`
--
ALTER TABLE `mdl_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_page_cou_ix` (`course`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_page`
--
ALTER TABLE `mdl_page`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
