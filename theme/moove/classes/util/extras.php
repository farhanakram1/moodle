<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Custom moove extras functions
 *
 * @package    theme_moove
 * @copyright  2018 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_moove\util;

use core_competency\api as competency_api;

defined('MOODLE_INTERNAL') || die();

/**
 * Class to get some extras info in Moodle.
 *
 * @package    theme_moove
 * @copyright  2019 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class extras {
    /**
     * Returns all user enrolled courses with progress
     *
     * @param \stdClass $user
     *
     * @return array
     */
    public static function user_courses_with_progress($user) {
        global $USER, $CFG;

        if (($USER->id !== $user->id) && !is_siteadmin($USER->id)) {
            return [];
        }

        require_once($CFG->dirroot.'/course/renderer.php');

        $chelper = new \coursecat_helper();

        $courses = enrol_get_users_courses($user->id, true, '*', 'sortorder ASC , fullname ASC, visible DESC');

        foreach ($courses as $course) {
            $course->fullname = strip_tags($chelper->get_course_formatted_name($course));

            $courseobj = new \core_course_list_element($course);
            $completion = new \completion_info($course);

            // First, let's make sure completion is enabled.
            if ($completion->is_enabled()) {
                $percentage = \core_completion\progress::get_course_progress_percentage($course, $user->id);

                if (!is_null($percentage)) {
                    $percentage = floor($percentage);
                }

                if (is_null($percentage)) {
                    $percentage = 0;
                }

                // Add completion data in course object.
                $course->completed = $completion->is_course_complete($user->id);
                $course->progress  = $percentage;
            }

            $course->link = $CFG->wwwroot."/course/view.php?id=".$course->id;

            // Summary.
            $course->summary = strip_tags($chelper->get_course_formatted_summary(
                $courseobj,
                array('overflowdiv' => false, 'noclean' => false, 'para' => false)
            ));

            $course->courseimage = self::get_course_summary_image($courseobj, $course->link);
        }

        return array_values($courses);
    }
    
    /**
     * Return Courses with all deep categories
     * @param Array $category Parent Category Array
     * @param array $student_enroll_numbers Student Enrolled Category ID Numbers
     * 
     * @return html Courses Details
     */
    
    /**
     * Returns the first course's summary issue
     *
     * @param \core_course_list_element $course
     * @param string $courselink
     *
     * @return string
     */
    public static function get_course_summary_image($course, $courselink) {
        global $CFG;

        $contentimage = '';
        foreach ($course->get_course_overviewfiles() as $file) {
            $isimage = $file->is_valid_image();
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
                '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
            if ($isimage) {
                $contentimage = \html_writer::link($courselink, \html_writer::empty_tag('img', array(
                    'src' => $url,
                    'alt' => $course->fullname,
                    'class' => 'card-img-top w-100')));
                break;
            }
        }

        if (empty($contentimage)) {
            $url = $CFG->wwwroot . "/theme/moove/pix/default_course.jpg";

            $contentimage = \html_writer::link($courselink, \html_writer::empty_tag('img', array(
                'src' => $url,
                'alt' => $course->fullname,
                'class' => 'card-img-top w-100')));
        }

        return $contentimage;
    }

    /**
     * Returns the user picture
     *
     * @param null $userobject
     * @param int $imgsize
     *
     * @return \moodle_url
     * @throws \coding_exception
     */
    public static function get_user_picture($userobject = null, $imgsize = 100) {
        global $USER, $PAGE;

        if (!$userobject) {
            $userobject = $USER;
        }

        $userimg = new \user_picture($userobject);

        $userimg->size = $imgsize;

        return $userimg->get_url($PAGE);
    }

    /**
     * Returns an array of all user competency plans
     *
     * @param \stdClass $user
     *
     * @return array
     *
     * @throws \coding_exception
     * @throws \required_capability_exception
     */
    public static function get_user_competency_plans($user) {
        global $USER;

        if (($USER->id !== $user->id) && !is_siteadmin($USER->id)) {
            return [];
        }

        $retorno = [];

        try {
            $plans = array_values(competency_api::list_user_plans($user->id));

            if (empty($plans)) {
                return [];
            }

            foreach ($plans as $plan) {
                $pclist = competency_api::list_plan_competencies($plan);

                $ucproperty = 'usercompetency';
                if ($plan->get('status') != 1) {
                    $ucproperty = 'usercompetencyplan';
                }

                $proficientcount = 0;
                foreach ($pclist as $pc) {
                    $usercomp = $pc->$ucproperty;

                    if ($usercomp->get('proficiency')) {
                        $proficientcount++;
                    }
                }

                $competencycount = count($pclist);
                $proficientcompetencypercentage = ((float) $proficientcount / (float) $competencycount) * 100.0;

                $progressclass = '';
                if ($proficientcompetencypercentage == 100) {
                    $progressclass = 'bg-success';
                }

                $retorno[] = [
                    'id' => $plan->get('id'),
                    'name' => $plan->get('name'),
                    'competencycount' => $competencycount,
                    'proficientcount' => $proficientcount,
                    'proficientcompetencypercentage' => $proficientcompetencypercentage,
                    'progressclass' => $progressclass
                ];
            }
        } catch (\Exception $e) {
            return [];
        }

        return $retorno;
    }

    /**
     * Returns the buttons displayed at the page header
     *
     * @param \context_course $context
     * @param \stdClass $user
     *
     * @return array
     *
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public static function get_mypublic_headerbuttons($context, $user) {
        global $USER, $CFG;

        $headerbuttons = [];

        // Check to see if we should be displaying a message button.
        if (!empty($CFG->messaging) && $USER->id != $user->id && has_capability('moodle/site:sendmessage', $context)) {
            $iscontact = !empty(\core_message\api::get_contact($USER->id, $user->id)) ? 1 : 0;
            $contacttitle = $iscontact ? 'removecontact' : 'addcontact';
            $contacturlaction = $iscontact ? 'removecontact' : 'addcontact';
            $contactimage = $iscontact ? 'slicon-user-unfollow' : 'slicon-user-follow';
            $headerbuttons = [
                [
                    'title' => get_string('sendmessage', 'core_message'),
                    'url' => new \moodle_url('/message/index.php', array('id' => $user->id)),
                    'icon' => 'fa fa-comment-o',
                    'class' => 'btn btn-block btn-outline-primary'
                ],
                [
                    'title' => get_string($contacttitle, 'theme_moove'),
                    'url' => new \moodle_url('/message/index.php', [
                            'user1' => $USER->id,
                            'user2' => $user->id,
                            $contacturlaction => $user->id,
                            'sesskey' => sesskey()]
                    ),
                    'icon' => $contactimage,
                    'class' => 'btn btn-block btn-outline-dark ajax-contact-button',
                    'linkattributes' => \core_message\helper::togglecontact_link_params($user, $iscontact),
                ]
            ];

            \core_message\helper::togglecontact_requirejs();
        }

        return $headerbuttons;
    }
    
//    public function course_by_categories($cat_id) {
//        global $DB;
//        $courses = $DB->get_records('course', array('category' => $cat_id), '*', $sort='order by sortorder asc', MUST_EXIST);
//        $course_html = '';
//        foreach ($courses as $course){
//            $chelper = new \coursecat_helper();
//            $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);
//            $course_render = new \course_renderer;
//            $course_html .= $this->coursecat_coursebox_content($chelper, $course);
//        }
//    }
//    
//    protected function coursecat_coursebox_content(coursecat_helper $chelper, $course) {
//        global $CFG;
//        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
//            return '';
//        }
//        if ($course instanceof stdClass) {
//            $course = new core_course_list_element($course);
//        }
//        $content = '';
//
//        // display course summary
//        if ($course->has_summary()) {
//            $content .= html_writer::start_tag('div', array('class' => 'summary'));
//            $content .= $chelper->get_course_formatted_summary($course,
//                    array('overflowdiv' => true, 'noclean' => true, 'para' => false));
//            $content .= html_writer::end_tag('div'); // .summary
//        }
//
//        // display course overview files
//        $contentimages = $contentfiles = '';
//        foreach ($course->get_course_overviewfiles() as $file) {
//            $isimage = $file->is_valid_image();
//            $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
//                    '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
//                    $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
//            if ($isimage) {
//                $contentimages .= html_writer::tag('div',
//                        html_writer::empty_tag('img', array('src' => $url)),
//                        array('class' => 'courseimage'));
//            } else {
//                $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
//                $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
//                        html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
//                $contentfiles .= html_writer::tag('span',
//                        html_writer::link($url, $filename),
//                        array('class' => 'coursefile fp-filename-icon'));
//            }
//        }
//        $content .= $contentimages. $contentfiles;
//
//        // Display course contacts. See core_course_list_element::get_course_contacts().
//        if ($course->has_course_contacts()) {
//            $content .= html_writer::start_tag('ul', array('class' => 'teachers'));
//            foreach ($course->get_course_contacts() as $coursecontact) {
//                $rolenames = array_map(function ($role) {
//                    return $role->displayname;
//                }, $coursecontact['roles']);
//                $name = implode(", ", $rolenames).': '.
//                        html_writer::link(new moodle_url('/user/view.php',
//                                array('id' => $coursecontact['user']->id, 'course' => SITEID)),
//                            $coursecontact['username']);
//                $content .= html_writer::tag('li', $name);
//            }
//            $content .= html_writer::end_tag('ul'); // .teachers
//        }
//
//        // display course category if necessary (for example in search results)
//        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_EXPANDED_WITH_CAT) {
//            if ($cat = core_course_category::get($course->category, IGNORE_MISSING)) {
//                $content .= html_writer::start_tag('div', array('class' => 'coursecat'));
//                $content .= get_string('category').': '.
//                        html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $cat->id)),
//                                $cat->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));
//                $content .= html_writer::end_tag('div'); // .coursecat
//            }
//        }
//
//        // Display custom fields.
//        if ($course->has_custom_fields()) {
//            $handler = core_course\customfield\course_handler::create();
//            $customfields = $handler->display_custom_fields_data($course->get_custom_fields());
//            $content .= \html_writer::tag('div', $customfields, ['class' => 'customfields-container']);
//        }
//
//        return $content;
//    }
}
