-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 06:26 PM
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
-- Table structure for table `mdl_wiki_pages`
--

CREATE TABLE `mdl_wiki_pages` (
  `id` bigint(10) NOT NULL,
  `subwikiid` bigint(10) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL DEFAULT 'title',
  `cachedcontent` longtext NOT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  `timerendered` bigint(10) NOT NULL DEFAULT 0,
  `userid` bigint(10) NOT NULL DEFAULT 0,
  `pageviews` bigint(10) NOT NULL DEFAULT 0,
  `readonly` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores wiki pages' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_wiki_pages`
--

INSERT INTO `mdl_wiki_pages` (`id`, `subwikiid`, `title`, `cachedcontent`, `timecreated`, `timemodified`, `timerendered`, `userid`, `pageviews`, `readonly`) VALUES
(1, 1, 'Home', '<div class=\"wiki-toc\"><p class=\"wiki-toc-title\">Table of contents</p><p class=\"wiki-toc-section-1 wiki-toc-section\">1. <a href=\"#toc-1\"><img src=\"@@PLUGINFILE@@/left_image.jpg\" alt=\"\" class=\"atto_image_button_left\" width=\"450\" height=\"300\"> <a href=\"edit.php?pageid=1&amp;section=%3Cimg+src%3D%22%40%40PLUGINFILE%40%40%2Fleft_image.jpg%22+alt%3D%22%22+class%3D%22atto_image_button_left%22+width%3D%22450%22+height%3D%22300%22%3E\" class=\"wiki_edit_section\">[edit]</a></a></p><p class=\"wiki-toc-section-1 wiki-toc-section\">2. <a href=\"#toc-2\">How it works <a href=\"edit.php?pageid=1&amp;section=How+it+works\" class=\"wiki_edit_section\">[edit]</a></a></p></div><p><a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=1\">Home</a>&nbsp; <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=2\">Contact</a>&nbsp; <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=3\">About Us</a> <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=4\">Login</a></p>\n<div style=\"background-image:url(&quot;@@PLUGINFILE@@/bg.png&quot;);background-repeat:no-repeat;padding:200px 0 200px 0;\">\n   <h2 style=\"text-align:center;color:#FFFFFF;\"><b>WELCOME</b></h2>\n   <p style=\"text-align:center;color:#FFFFFF;\">to the exam review platform for <b>Dr. Derek Mahony’s</b> EODO Miniresidency students</p>\n   <h5 style=\"text-align:center;\"><a href=\"#\" style=\"color:#FFFFFF;\"><b>LEARN MOR</b>E</a></h5>\n   <br></div>\n<br>\n<br>\n<h3><a name=\"toc-1\"></a><img src=\"@@PLUGINFILE@@/left_image.jpg\" alt=\"\" class=\"atto_image_button_left\" width=\"450\" height=\"300\"> <a href=\"edit.php?pageid=1&amp;section=%3Cimg+src%3D%22%40%40PLUGINFILE%40%40%2Fleft_image.jpg%22+alt%3D%22%22+class%3D%22atto_image_button_left%22+width%3D%22450%22+height%3D%22300%22%3E\" class=\"wiki_edit_section\">[edit]</a></h3>\n<br>\n<h3><a name=\"toc-2\"></a>How it works <a href=\"edit.php?pageid=1&amp;section=How+it+works\" class=\"wiki_edit_section\">[edit]</a></h3>\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n   <p><b>Login, upload your work, see the results</b></p>\n</div>\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n   <div style=\"text-align:left;\">\n    </div>\n   <div style=\"margin-left:30px;\" class=\"editor-indent\">\n       <div style=\"margin-left:30px;\" class=\"editor-indent\">\n           <div style=\"margin-left:30px;\" class=\"editor-indent\">\n               <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                   <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                       <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                           <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                               <div style=\"text-align:left;\">Create a login<br>Choose the module you would like to submit<br>Upload your exam PDFs and pay for the corrections with PayPal<br>Review your results<br>Obtain the diploma at the end of the EODO Miniresidency Program</div>\n                           </div>\n                       </div>\n                   </div>\n               </div>\n           </div>\n       </div>\n   </div>\n   <div style=\"text-align:left;\"><a href=\"#\">LOGIN</a></div>\n</div>\n<br>\n<br>\n<br>\n<br>\n<div style=\"text-align:center;\"><img src=\"@@PLUGINFILE@@/image3.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"><img src=\"@@PLUGINFILE@@/image4.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"> <img src=\"@@PLUGINFILE@@/image5.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">\n   <img src=\"@@PLUGINFILE@@/image1.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">&nbsp; <img src=\"@@PLUGINFILE@@/image2.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"></div>\n<div style=\"text-align:center;\">&nbsp;&nbsp;&nbsp; 24h access&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Review results&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manage exams&nbsp;&nbsp; Deadline overview&nbsp;&nbsp; Easy upload</div>\n<div><br></div>\n<div>A PLACE THAT<br>PROVIDES ALL TOOLS<br>FOR COMFORTABLE<br>WORK ENVIRONMENT</div>\n<div><br></div>\n<div style=\"text-align:left;\">This platform provides you with the tools to easily upload and manage<br>your EODO Miniresidency exams and assignments. You can<br>conveniently access your account 24/7 to check on your results and<br>ensure that you fulfil all requirements for your diploma\n   at the end of the<br>residency.</div>\n<div><br></div>\n<div style=\"text-align:center;\"><b>Copyright C 2019 MR Corrections<br>Impressum</b><br></div>\n', 1581595559, 1581612597, 1581612597, 2, 15, 0),
(2, 1, 'Contact', '<form action=\"/action_page.php\">\n <label for=\"fname\">First name:</label><br>\n <input type=\"text\" id=\"fname\" name=\"fname\" value=\"John\"><br>\n <label for=\"lname\">Last name:</label><br>\n <input type=\"text\" id=\"lname\" name=\"lname\" value=\"Doe\"><br><br>\n <input type=\"submit\" value=\"Submit\">\n</form>\n', 1581596935, 1581609544, 1581611012, 2, 8, 0),
(3, 1, 'About Us', '<p><a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=1\">Home</a>&nbsp; <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=2\">Contact</a>&nbsp; <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=3\">About Us</a> <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=4\">Login</a></p>\n<div style=\"background-image:url(&quot;@@PLUGINFILE@@/aboutus.png&quot;);background-repeat:no-repeat;padding:100px 0 100px 0;background-size:100%\">\n   <h2 style=\"text-align:center;color:#FFFFFF;\"><b>About Us</b></h2>\n</div>\n<div style=\"text-align:left;\"><b>ABOUT MR CORRECTIONS</b></div>\n<div style=\"text-align:left;\">We carry out the corrections for all Miniresidency<br>exams and assignments for Dr. Derek Mahony\'s<br>courses and submit the results to EODO to be<br>taken into account for your diploma and if<br>applicable your application for the Master of<br>Clinical\n   Dentistry of the City<b><br></b></div>\n<div style=\"text-align:center;\"><b><img src=\"@@PLUGINFILE@@/image002.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"300\" height=\"200\"></b><br></div>\n', 1581611105, 1581612104, 1581612104, 2, 4, 0),
(4, 1, 'Login', '<p><a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=1\">Home</a>&nbsp; <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=2\">Contact</a>&nbsp; <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=3\">About Us</a> <a href=\"http://localhost/moodle/mod/wiki/view.php?pageid=4\">Login</a></p>\n', 1581612002, 1581612012, 1581612012, 2, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_wiki_pages`
--
ALTER TABLE `mdl_wiki_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_wikipage_subtituse_uix` (`subwikiid`,`title`,`userid`),
  ADD KEY `mdl_wikipage_sub_ix` (`subwikiid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_wiki_pages`
--
ALTER TABLE `mdl_wiki_pages`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
