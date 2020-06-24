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
 * Course renderer.
 *
 * @package    theme_moove
 * @copyright  2017 Willian Mano - conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_moove\output\core;

defined('MOODLE_INTERNAL') || die();

use moodle_url;
use html_writer;
use core_course_category;
use coursecat_helper;
use stdClass;
use core_course_list_element;
use theme_moove\util\extras;

/**
 * Renderers to align Moove's course elements to what is expect
 *
 * @package    theme_moove
 * @copyright  2017 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_renderer extends \core_course_renderer {

    /**
     * Renders the list of courses
     *
     * This is internal function, please use {@link core_course_renderer::courses_list()} or another public
     * method from outside of the class
     *
     * If list of courses is specified in $courses; the argument $chelper is only used
     * to retrieve display options and attributes, only methods get_show_courses(),
     * get_courses_display_option() and get_and_erase_attributes() are called.
     *
     * @param coursecat_helper $chelper various display options
     * @param array $courses the list of courses to display
     * @param int|null $totalcount total number of courses (affects display mode if it is AUTO or pagination if applicable),
     *     defaulted to count($courses)
     * @return string
     */
    protected function coursecat_courses(coursecat_helper $chelper, $courses, $totalcount = null) {
        global $CFG;

        $theme = \theme_config::load('moove');

        if (!empty($theme->settings->courselistview)) {
            return parent::coursecat_courses($chelper, $courses, $totalcount);
        }

        if ($totalcount === null) {
            $totalcount = count($courses);
        }

        if (!$totalcount) {
            // Courses count is cached during courses retrieval.
            return '';
        }

        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_AUTO) {
            // In 'auto' course display mode we analyse if number of courses is more or less than $CFG->courseswithsummarieslimit.
            if ($totalcount <= $CFG->courseswithsummarieslimit) {
                $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);
            } else {
                $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED);
            }
        }

        // Prepare content of paging bar if it is needed.
        $paginationurl = $chelper->get_courses_display_option('paginationurl');
        $paginationallowall = $chelper->get_courses_display_option('paginationallowall');
        if ($totalcount > count($courses)) {
            // There are more results that can fit on one page.
            if ($paginationurl) {
                // The option paginationurl was specified, display pagingbar.
                $perpage = $chelper->get_courses_display_option('limit', $CFG->coursesperpage);
                $page = $chelper->get_courses_display_option('offset') / $perpage;
                $pagingbar = $this->paging_bar($totalcount, $page, $perpage,
                        $paginationurl->out(false, array('perpage' => $perpage)));
                if ($paginationallowall) {
                    $pagingbar .= html_writer::tag('div', html_writer::link($paginationurl->out(false, array('perpage' => 'all')),
                                            get_string('showall', '', $totalcount)), array('class' => 'paging paging-showall'));
                }
            } else if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
                // The option for 'View more' link was specified, display more link.
                $viewmoretext = $chelper->get_courses_display_option('viewmoretext', new \lang_string('viewmore'));
                $morelink = html_writer::tag('div', html_writer::link($viewmoreurl, $viewmoretext),
                                array('class' => 'paging paging-morelink'));
            }
        } else if (($totalcount > $CFG->coursesperpage) && $paginationurl && $paginationallowall) {
            // There are more than one page of results and we are in 'view all' mode, suggest to go back to paginated view mode.
            $pagingbar = html_writer::tag(
                            'div',
                            html_writer::link(
                                    $paginationurl->out(
                                            false,
                                            array('perpage' => $CFG->coursesperpage)
                                    ),
                                    get_string('showperpage', '', $CFG->coursesperpage)
                            ),
                            array('class' => 'paging paging-showperpage')
            );
        }

        // Display list of courses.
        $attributes = $chelper->get_and_erase_attributes('courses');
        $content = html_writer::start_tag('div', $attributes);

        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }

        $coursecount = 1;
        $content .= html_writer::start_tag('div', array('class' => 'card-deck mt-2'));
        foreach ($courses as $course) {
            $content .= $this->coursecat_coursebox($chelper, $course);

            if ($coursecount % 4 == 0) {
                $content .= html_writer::end_tag('div');
                $content .= html_writer::start_tag('div', array('class' => 'card-deck mt-2'));
            }

            $coursecount ++;
        }

        $content .= html_writer::end_tag('div');

        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }

        if (!empty($morelink)) {
            $content .= $morelink;
        }

        $content .= html_writer::end_tag('div'); // End courses.
        return $content;
    }

    /**
     * Displays one course in the list of courses.
     *
     * This is an internal function, to display an information about just one course
     * please use {@link core_course_renderer::course_info_box()}
     *
     * @param coursecat_helper $chelper various display options
     * @param core_course_list_element|stdClass $course
     * @param string $additionalclasses additional classes to add to the main <div> tag (usually
     *    depend on the course position in list - first/last/even/odd)
     * @return string
     *
     * @throws \coding_exception
     */
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        $theme = \theme_config::load('moove');

        if (!empty($theme->settings->courselistview)) {
            return parent::coursecat_coursebox($chelper, $course, $additionalclasses);
        }

        if (!isset($this->strings->summary)) {
            $this->strings->summary = get_string('summary');
        }
        if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
            return '';
        }
        if ($course instanceof stdClass) {
            $course = new core_course_list_element($course);
        }

        $classes = trim('card');
        if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
            $nametag = 'h3';
        } else {
            $classes .= ' collapsed';
            $nametag = 'div';
        }

        // End coursebox.
        $content = html_writer::start_tag('div', array(
                    'class' => $classes,
                    'data-courseid' => $course->id,
                    'data-type' => self::COURSECAT_TYPE_COURSE,
        ));

        $content .= $this->coursecat_coursebox_content($chelper, $course);

        $content .= html_writer::end_tag('div'); // End coursebox.

        return $content;
    }

    /**
     * Returns HTML to display course content (summary, course contacts and optionally category name)
     *
     * This method is called from coursecat_coursebox() and may be re-used in AJAX
     *
     * @param coursecat_helper $chelper various display options
     * @param stdClass|core_course_list_element $course
     *
     * @return string
     *
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public function coursecat_coursebox_content(coursecat_helper $chelper, $course,$exam_orginzer='') {
        global $CFG, $DB, $USER;

        if ($course instanceof stdClass) {
            $course = new core_course_list_element($course);
        }
        if(is_siteadmin()){
             $show_student = true;
        }else{
            $roleassignments = $DB->get_records_sql('SELECT roleid FROM {role_assignments} WHERE userid=? ', array(intval($USER->id)));


            $show_student = false;
            $show_teacher = false;
            foreach ($roleassignments as $roleassignment){
               if($roleassignment->roleid < 5){
                   $show_student = true;
               }
               if($roleassignment->roleid > 1 && $roleassignment->roleid < 5){
                    $show_teacher = true;
                }
              
            }
        }
//      $content = extras::get_course_summary_image($course, $courselink);

        $theme = \theme_config::load('moove');

        // Course instructors.
//        if ($course->has_course_contacts() && !($theme->settings->disableteacherspic)) {
//            $content .= html_writer::start_tag('div', array('class' => 'course-contacts'));
//
//            $instructors = $course->get_course_contacts();
//            foreach ($instructors as $key => $instructor) {
//                $name = $instructor['username'];
//                $url = $CFG->wwwroot . '/user/profile.php?id=' . $key;
//                $picture = extras::get_user_picture($DB->get_record('user', array('id' => $key)));
//
//                $content .= "<a href='{$url}' class='contact' data-toggle='tooltip' title='{$name}'>";
//                $content .= "<img src='{$picture}' class='rounded-circle' alt='{$name}'/>";
//                $content .= "</a>";
//            }
//
//            $content .= html_writer::end_tag('div'); // Ends course-contacts.
//        }

        $access = false;
        // Print enrolmenticons.
        
        if (isset($USER->enrol['enrolled'][$course->id])) {
            if ($USER->enrol['enrolled'][$course->id] > time()) {
                $access = true;
                if (isset($USER->enrol['tempguest'][$course->id])) {
                    unset($USER->enrol['tempguest'][$course->id]);
                    remove_temp_course_roles($coursecontext);
                }
            } else {
                // Expired.
                unset($USER->enrol['enrolled'][$course->id]);
            }
        }
        if (isset($USER->enrol['tempguest'][$course->id])) {
            if ($USER->enrol['tempguest'][$course->id] == 0) {
                $access = true;
            } else if ($USER->enrol['tempguest'][$course->id] > time()) {
                $access = true;
            } else {
                // Expired.
                unset($USER->enrol['tempguest'][$course->id]);
                remove_temp_course_roles($coursecontext);
            }
        }

        if (!$access) {
            // Cache not ok.
            $until = enrol_get_enrolment_end($coursecontext->instanceid, $USER->id);
            if ($until !== false) {
                // Active participants may always access, a timestamp in the future, 0 (always) or false.
                if ($until == 0) {
                    $until = ENROL_MAX_TIMESTAMP;
                }
                $USER->enrol['enrolled'][$course->id] = $until;
                $access = true;
            } else if (core_course_category::can_view_course_info($course)) {
                $params = array('courseid' => $course->id, 'status' => ENROL_INSTANCE_ENABLED);
                $instances = $DB->get_records('enrol', $params, 'sortorder, id ASC');
                $enrols = enrol_get_plugins(true);
                // First ask all enabled enrol instances in course if they want to auto enrol user.
                foreach ($instances as $instance) {
                    if (!isset($enrols[$instance->enrol])) {
                        continue;
                    }
                    // Get a duration for the enrolment, a timestamp in the future, 0 (always) or false.
                    $until = $enrols[$instance->enrol]->try_autoenrol($instance);
                    if ($until !== false) {
                        if ($until == 0) {
                            $until = ENROL_MAX_TIMESTAMP;
                        }
                        $USER->enrol['enrolled'][$course->id] = $until;
                        $access = true;
                        break;
                    }
                }
                // If not enrolled yet try to gain temporary guest access.
                if (!$access) {
                    foreach ($instances as $instance) {
                        if (!isset($enrols[$instance->enrol])) {
                            continue;
                        }
                        // Get a duration for the guest access, a timestamp in the future or false.
                        $until = $enrols[$instance->enrol]->try_guestaccess($instance);
                        if ($until !== false and $until > time()) {
                            $USER->enrol['tempguest'][$course->id] = $until;
                            $access = true;
                            break;
                        }
                    }
                }
            }
        }
        $class = '';
        if ($icons = enrol_get_course_info_icons($course)) {
            foreach ($icons as $pixicon) {
//                $content .= $this->render($pixicon);
            }
        }
        if ($access) {
            $class = 'access';
        } else {
            if(!$show_student){
                $class = 'noaccess';
            }else{
                $class = 'show-course';
            }
            $enrolinstances = enrol_get_instances($course->id, true);
            $forms = array();
            foreach($enrolinstances as $instance) {
                if (!isset($enrols[$instance->enrol])) {
                    continue;
                }
                $form = $enrols[$instance->enrol]->enrol_page_hook($instance);
                if ($form) {
                    $forms[$instance->id] = $form;
                }
            }
        }
        
        $context = get_context_instance(CONTEXT_COURSE, $course->id, MUST_EXIST);
        $enrolled = is_enrolled($context, $USER->id, '', true);
        if($enrolled){
            $class = 'access';
        }
        $content .= html_writer::start_tag('div', array('id' => 'enrollment-modal-'.$course->id.'-'.$exam_orginzer, 'class' => 'modalEnrol'));        
            $content .= html_writer::start_tag('div', array( 'class' => 'modal-content-course'));
            $content .= html_writer::start_tag('span', array( 'class' => 'cloaseModal'));
            $content .= '&times;';
            $content .= html_writer::end_tag('span');
            foreach ($forms as $form) {
                $content .= $form;
            }
        if (!$forms) {
            $content .= html_writer::start_tag('div', array('class' => 'generalbox'));
            if (isguestuser()) {
                 $content .= html_writer::start_tag('p', array('class' => 'card-text'));
                $content .= get_string('noguestaccess', 'enrol');
                $content .= html_writer::end_tag('p');
                $content .= html_writer::link(get_login_url(),
                        'Continue', array('class' => 'card-link btn btn-primary '));
            } else if ($returnurl) {
                 $content .= html_writer::start_tag('p', array('class' => 'card-text'));
                $content .= get_string('notenrollable', 'enrol');
                $content .= html_writer::end_tag('p');
                $content .= html_writer::link($returnurl,
                        'Continue', array('class' => 'card-link btn btn-primary '));
            } else {
                $url = get_local_referer(false);
                if (empty($url)) {
                    $url = new moodle_url('/index.php');
                }
                $content .= html_writer::start_tag('p', array('class' => 'card-text'));
                $content .= get_string('notenrollable', 'enrol');
                $content .= html_writer::end_tag('p');
                $content .= html_writer::link($url,
                        'Continue', array('class' => 'card-link btn btn-primary '));
            }
            $content .= html_writer::end_tag('div');
        }
        $content .= html_writer::end_tag('div');        
        $content .= html_writer::end_tag('div');
        
        
        // Course name.
        $coursename = $chelper->get_course_formatted_name($course);
        $courselink = new moodle_url('/course/view.php', array('id' => $course->id));
        if(time() < $course->startdate || $course->visible  == 0){
            $class = 'noaccess-grey';
            $string = 'unavailable';
        }
        $percentage = \core_completion\progress::get_course_progress_percentage($course, $USER->id);
        
        if($percentage == 0 && $class == 'access'){
            $access_class = 'start_course';
            $string = 'ready';
        }else if($show_teacher){
            $class = 'noaccess-grey';
            $show_student = false;
        }
        if($percentage > 0 && $class == 'access'){
            $string = 'downloaded';
        }
        if($show_student){
            $coursenamelink = html_writer::link($courselink, $coursename, array('class' => $course->visible ? '' : 'dimmed'));
        }else{
            if($class == 'access'){
                $coursenamelink = html_writer::link($courselink, $coursename, array('class' => $course->visible ? '' : 'dimmed'));
            }else if($class == 'noaccess-grey'){
                $coursenamelink = html_writer::link('#',
                            $coursename, array('class' => 'card-link '));
            }else{
                $coursenamelink = html_writer::link('#',
                            $coursename, array('id' => 'open-modal-'.$course->id, 'onclick' => 'open_enrollment_form('.$course->id.',"'.$exam_orginzer.'")','class' => 'card-link '));
                $string = 'unlock';
            }
        }
        $content .= html_writer::start_tag('div', array('class' => 'eodo-course card-body '.$class." ".$access_class, 'id' => 'course-link-'.$course->id));
        $content .= "<h4 class='card-title'>" . $coursenamelink . "</h4>";
        // Display course summary.
//        if ($course->has_summary()) {
//            $content .= html_writer::start_tag('p', array('class' => 'card-text'));
//            $content .= $chelper->get_course_formatted_summary($course,
//                    array('overflowdiv' => true, 'noclean' => true, 'para' => false));
//            $content .= html_writer::end_tag('p'); // End summary.
//        }
        $content .= html_writer::start_tag('p', array('class' => 'card-text eodo-course-text'));
        $content .= $string;
        $content .= html_writer::end_tag('p');
        $content .= html_writer::end_tag('div');

        $content .= html_writer::start_tag('div', array('class' => 'card-footer', 'style' => 'display:none;'));
        $content .= html_writer::start_tag('div', array('class' => 'pull-right'));
        $content .= html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
                        get_string('access', 'theme_moove'), array('class' => 'card-link btn btn-primary ' . $class));
        $content .= html_writer::link('#',
                        get_string('access', 'theme_moove'), array('id' => 'open-modal-'.$course->id.'-'.$exam_orginzer, 'onclick' => 'open_enrollment_form('.$course->id.',"'.$exam_orginzer.'")','class' => 'card-link btn btn-primary ' . $class));
        $content .= html_writer::end_tag('div'); // End pull-right.

        $content .= html_writer::end_tag('div'); // End card-block.
        // Display course category if necessary (for example in search results).
        if(empty($exam_orginzer)){
            if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_EXPANDED_WITH_CAT) {
                require_once($CFG->libdir . '/coursecatlib.php');
                if ($cat = core_course_category::get($course->category, IGNORE_MISSING)) {
                    $content .= html_writer::start_tag('div', array('class' => 'coursecat'));
                    $content .= get_string('category') . ': ' .
                            html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $cat->id)),
                                    $cat->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));
                    $content .= html_writer::end_tag('div'); // End coursecat.
                }
            }
        }
//        $script = 'var btn = document.getElementById("open-modal-'.$course->id.'-'.$exam_orginzer.'");'
//                . 'function open_enrollment_form(course_id){'
//                . 'var modal = document.getElementById("enrollment-modal-'.$course->id.'-'.$exam_orginzer.'");'
//                . 'modal.style.display = "block";'
//                . '}';
//        $content .= html_writer::script($script);
        return $content;
    }

}
