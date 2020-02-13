-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 06:14 PM
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
-- Table structure for table `mdl_editor_atto_autosave`
--

CREATE TABLE `mdl_editor_atto_autosave` (
  `id` bigint(10) NOT NULL,
  `elementid` varchar(255) NOT NULL DEFAULT '',
  `contextid` bigint(10) NOT NULL,
  `pagehash` varchar(64) NOT NULL DEFAULT '',
  `userid` bigint(10) NOT NULL,
  `drafttext` longtext NOT NULL,
  `draftid` bigint(10) DEFAULT NULL,
  `pageinstance` varchar(64) NOT NULL DEFAULT '',
  `timemodified` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Draft text that is auto-saved every 5 seconds while an edito' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_editor_atto_autosave`
--

INSERT INTO `mdl_editor_atto_autosave` (`id`, `elementid`, `contextid`, `pagehash`, `userid`, `drafttext`, `draftid`, `pageinstance`, `timemodified`) VALUES
(3, 'id_s__summary', 1, 'ff3f77df26ca7129b0695554811c1957ff416f7d', 2, '', -1, 'yui_3_17_2_1_1581429594824_46', 1581429595),
(4, 'id_s__maintenance_message', 1, 'a428c9349710d8f146707a2979d1bd1b2905927c', 2, '', -1, 'yui_3_17_2_1_1581433949624_46', 1581433950),
(7, 'id_summary_editor', 2, 'e0909cc09d694353c14840de20baf7d6c3026d81', 2, '', 835464824, 'yui_3_17_2_1_1581595401677_100', 1581595402),
(13, 'id_newcontent_editor', 26, 'e8cfc7d0dfee3241c11d8f34adb2a48944da5709', 2, '<p>[[Home]]&nbsp; [[Contact]]&nbsp; [[About Us]] [[Login]]</p>\n<div style=\"background-image:url(&quot;http://localhost/moodle/draftfile.php/5/user/draft/18783735/bg.png&quot;);background-repeat:no-repeat;padding:200px 0 200px 0;\">\n    <h2 style=\"text-align:center;color:#FFFFFF;\"><b>WELCOME</b></h2>\n    <p style=\"text-align:center;color:#FFFFFF;\">to the exam review platform for <b>Dr. Derek Mahony’s</b> EODO Miniresidency students</p>\n    <h5 style=\"text-align:center;\"><a href=\"#\" style=\"color:#FFFFFF;\"><b>LEARN MOR</b>E</a></h5>\n    <br></div>\n<br>\n<br>\n<h4><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/18783735/left_image.jpg\" alt=\"\" class=\"atto_image_button_left\" width=\"450\" height=\"300\">\n</h4>\n<br>\n\n<h4>How it works</h4>\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n    <p><b>Login, upload your work, see the results</b></p>\n</div>\n\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n    <div style=\"text-align:left;\">\n\n    </div>\n    <div style=\"margin-left:30px;\" class=\"editor-indent\">\n        <div style=\"margin-left:30px;\" class=\"editor-indent\">\n            <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                    <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                        <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                            <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                                <div style=\"text-align:left;\">Create a login<br>Choose the module you would like to submit<br>Upload your exam PDFs and pay for the corrections with PayPal<br>Review your results<br>Obtain the diploma at the end of the EODO Miniresidency Program</div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </div>\n    <div style=\"text-align:left;\"><a href=\"#\">LOGIN</a></div>\n</div>\n<br>\n<br>\n<br>\n<br>\n<div style=\"text-align:center;\"><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/18783735/image3.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/18783735/image4.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"> <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/18783735/image5.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">\n    <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/18783735/image1.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">&nbsp; <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/18783735/image2.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"></div>\n<div style=\"text-align:center;\">&nbsp;&nbsp;&nbsp; 24h access&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Review results&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manage exams&nbsp;&nbsp; Deadline overview&nbsp;&nbsp; Easy upload</div>\n<div><br></div>\n<div>A PLACE THAT<br>PROVIDES ALL TOOLS<br>FOR COMFORTABLE<br>WORK ENVIRONMENT</div>\n<div><br></div>\n<div style=\"text-align:left;\">This platform provides you with the tools to easily upload and manage<br>your EODO Miniresidency exams and assignments. You can<br>conveniently access your account 24/7 to check on your results and<br>ensure that you fulfil all requirements for your diploma\n    at the end of the<br>residency.</div>\n<div><br></div>\n<div style=\"text-align:center;\"><b>Copyright C 2019 MR Corrections<br>Impressum</b><br></div>', 18783735, 'yui_3_17_2_1_1581597971090_99', 1581598035),
(26, 'id_newcontent_editor', 26, 'ce6c442c087d7e45f4400c3b20c7467e89249891', 2, '<p>[[Home]]&nbsp; [[Contact]]&nbsp; [[About Us]] [[Login]]</p>\n<div style=\"background-image:url(&quot;http://localhost/moodle/draftfile.php/5/user/draft/957812560/bg.png&quot;);background-repeat:no-repeat;padding:200px 0 200px 0;\">\n    <h2 style=\"text-align:center;color:#FFFFFF;\"><b>WELCOME</b></h2>\n    <p style=\"text-align:center;color:#FFFFFF;\">to the exam review platform for <b>Dr. Derek Mahony’s</b> EODO Miniresidency students</p>\n    <h5 style=\"text-align:center;\"><a href=\"#\" style=\"color:#FFFFFF;\"><b>LEARN MOR</b>E</a></h5>\n    <br></div>\n<br>\n<br>\n<h4><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/957812560/left_image.jpg\" alt=\"\" class=\"atto_image_button_left\" width=\"450\" height=\"300\">\n</h4>\n<br>\n\n<h4>How it works</h4>\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n    <p><b>Login, upload your work, see the results</b></p>\n</div>\n\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n    <div style=\"text-align:left;\">\n\n    </div>\n    <div style=\"margin-left:30px;\" class=\"editor-indent\">\n        <div style=\"margin-left:30px;\" class=\"editor-indent\">\n            <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                    <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                        <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                            <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                                <div style=\"text-align:left;\">Create a login<br>Choose the module you would like to submit<br>Upload your exam PDFs and pay for the corrections with PayPal<br>Review your results<br>Obtain the diploma at the end of the EODO Miniresidency Program</div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </div>\n    <div style=\"text-align:left;\"><a href=\"#\">LOGIN</a></div>\n</div>\n<br>\n<br>\n<br>\n<br>\n<div style=\"text-align:center;\"><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/957812560/image3.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/957812560/image4.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"> <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/957812560/image5.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">\n    <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/957812560/image1.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">&nbsp; <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/957812560/image2.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"></div>\n<div style=\"text-align:center;\">&nbsp;&nbsp;&nbsp; 24h access&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Review results&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manage exams&nbsp;&nbsp; Deadline overview&nbsp;&nbsp; Easy upload</div>\n<div><br></div>\n<div>A PLACE THAT<br>PROVIDES ALL TOOLS<br>FOR COMFORTABLE<br>WORK ENVIRONMENT</div>\n<div><br></div>\n<div style=\"text-align:left;\">This platform provides you with the tools to easily upload and manage<br>your EODO Miniresidency exams and assignments. You can<br>conveniently access your account 24/7 to check on your results and<br>ensure that you fulfil all requirements for your diploma\n    at the end of the<br>residency.</div>\n<div><br></div>\n<div style=\"text-align:center;\"><b>Copyright C 2019 MR Corrections<br>Impressum</b><br></div>', 957812560, 'yui_3_17_2_1_1581601649382_99', 1581601713),
(29, 'id_summary_editor', 3, 'fe94f82330900b1e022c6c6526c44316e343016d', 2, '<p>English<br></p>', NULL, 'yui_3_17_2_1_1581601771836_284', 1581601834),
(31, 'id_newcontent_editor', 26, '300891a9d2372c4dd2df29e8e4ec5c92ccfd849b', 2, '<p>[[Home]]&nbsp; [[Contact]]&nbsp; [[About Us]] [[Login]]</p>\n<div style=\"background-image:url(&quot;http://localhost/moodle/draftfile.php/5/user/draft/411762887/bg.png&quot;);background-repeat:no-repeat;padding:200px 0 200px 0;\">\n    <h2 style=\"text-align:center;color:#FFFFFF;\"><b>WELCOME</b></h2>\n    <p style=\"text-align:center;color:#FFFFFF;\">to the exam review platform for <b>Dr. Derek Mahony’s</b> EODO Miniresidency students</p>\n    <h5 style=\"text-align:center;\"><a href=\"#\" style=\"color:#FFFFFF;\"><b>LEARN MOR</b>E</a></h5>\n    <br></div>\n<br>\n<br>\n<h4><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/411762887/left_image.jpg\" alt=\"\" class=\"atto_image_button_left\" width=\"450\" height=\"300\">\n</h4>\n<br>\n\n<h4>How it works</h4>\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n    <p><b>Login, upload your work, see the results</b></p>\n</div>\n\n<div style=\"margin-left:30px;\" class=\"editor-indent\">\n    <div style=\"text-align:left;\">\n\n    </div>\n    <div style=\"margin-left:30px;\" class=\"editor-indent\">\n        <div style=\"margin-left:30px;\" class=\"editor-indent\">\n            <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                    <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                        <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                            <div style=\"margin-left:30px;\" class=\"editor-indent\">\n                                <div style=\"text-align:left;\">Create a login<br>Choose the module you would like to submit<br>Upload your exam PDFs and pay for the corrections with PayPal<br>Review your results<br>Obtain the diploma at the end of the EODO Miniresidency Program</div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </div>\n    <div style=\"text-align:left;\"><a href=\"#\">LOGIN</a></div>\n</div>\n<br>\n<br>\n<br>\n<br>\n<div style=\"text-align:center;\"><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/411762887/image3.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"><img src=\"http://localhost/moodle/draftfile.php/5/user/draft/411762887/image4.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"> <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/411762887/image5.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">\n    <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/411762887/image1.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\">&nbsp; <img src=\"http://localhost/moodle/draftfile.php/5/user/draft/411762887/image2.png\" alt=\"\" class=\"img-responsive atto_image_button_text-bottom\" width=\"99\" height=\"99\"></div>\n<div style=\"text-align:center;\">&nbsp;&nbsp;&nbsp; 24h access&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Review results&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manage exams&nbsp;&nbsp; Deadline overview&nbsp;&nbsp; Easy upload</div>\n<div><br></div>\n<div>A PLACE THAT<br>PROVIDES ALL TOOLS<br>FOR COMFORTABLE<br>WORK ENVIRONMENT</div>\n<div><br></div>\n<div style=\"text-align:left;\">This platform provides you with the tools to easily upload and manage<br>your EODO Miniresidency exams and assignments. You can<br>conveniently access your account 24/7 to check on your results and<br>ensure that you fulfil all requirements for your diploma\n    at the end of the<br>residency.</div>\n<div><br></div>\n<div style=\"text-align:center;\"><b>Copyright C 2019 MR Corrections<br>Impressum</b><br></div>', 411762887, 'yui_3_17_2_1_1581602457983_99', 1581602520),
(32, 'id_introeditor', 29, '02863ae594d83e1377305e47675b126d2030a8f9', 2, 'General news and announcements', 456610414, 'yui_3_17_2_1_1581606780614_144', 1581606842),
(33, 'id_summary_editor', 28, 'ea17d50ecfc81b054f15c2ed35734f683cd2a33d', 2, '', 946036338, 'yui_3_17_2_1_1581608353252_100', 1581608354),
(35, 'id_config_text', 34, '19c8b117e0c0881facde9667e0c97ff9b50efc55', 2, '<form action=\"/action_page.php\">\n  <label for=\"fname\">First name:</label><br>\n  <input type=\"text\" id=\"fname\" name=\"fname\" value=\"John\"><br>\n  <label for=\"lname\">Last name:</label><br>\n  <input type=\"text\" id=\"lname\" name=\"lname\" value=\"Doe\"><br><br>\n  <input type=\"submit\" value=\"Submit\">\n</form>', NULL, 'yui_3_17_2_1_1581609203314_102', 1581609265),
(39, 'id_newcontent_editor', 26, '86258889ec36b8608dab54a1a7324f042f802109', 2, 'First name:<br>\n  <br>\n  Last name:<br>\n  <br><br>', 750950349, 'yui_3_17_2_1_1581611047187_99', 1581611110);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_editor_atto_autosave`
--
ALTER TABLE `mdl_editor_atto_autosave`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_editattoauto_eleconuse_uix` (`elementid`,`contextid`,`userid`,`pagehash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_editor_atto_autosave`
--
ALTER TABLE `mdl_editor_atto_autosave`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
