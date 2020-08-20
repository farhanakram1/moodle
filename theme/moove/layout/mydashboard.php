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
     * A two column layout for the moove theme.
     *
     * @package   theme_moove
     * @copyright 2017 Willian Mano - http://conecti.me
     * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    defined('MOODLE_INTERNAL') || die();

    require_once $CFG->libdir . '/gradelib.php';
    require_once $CFG->dirroot . '/grade/lib.php';
    require_once $CFG->dirroot . '/course/renderer.php';
    require_once $CFG->dirroot . '/grade/report/overview/lib.php';
//    require_once $CFG->dirroot . '/calander/renderer.php';
    

    global $DB, $USER;
    // Get the profile userid.
    $userid = optional_param('id', $USER->id, PARAM_INT);
    $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);



    user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
    user_preference_allow_ajax_update('sidepre-open', PARAM_ALPHA);

    require_once($CFG->libdir . '/behat/lib.php');

    if (isloggedin()) {
        $navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
        $draweropenright = (get_user_preferences('sidepre-open', 'true') == 'true');
    } else {
        $navdraweropen = false;
        $draweropenright = false;
    }
    // echo "<pre>";
    // print_r($OUTPUT);
    // die();
    $blockshtml = $OUTPUT->blocks('side-pre');
    $hasblocks = strpos($blockshtml, 'data-block=') !== false;

    $extraclasses = [];
    if ($navdraweropen) {
        $extraclasses[] = 'drawer-open-left';
    }

    if ($draweropenright && $hasblocks) {
        $extraclasses[] = 'drawer-open-right';
    }
    $arthodentent_courses = 0;
    $clinical_sessions = 0;
    $typodent_sessions = 0;
    $bodyattributes = $OUTPUT->body_attributes($extraclasses);
    //$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();

    $cor_course_render = new core_course_renderer($PAGE, 'dashboard');
    //$templatecontext['courses_examorganizer_courses'] = $cor_course_render->course_category(0);
    $roleassignments = $DB->get_records_sql('SELECT roleid FROM {role_assignments} WHERE userid=? ', array(intval($USER->id)));
    $show_student = false;
    $user_roles = array();
    $course_cat = $cor_course_render->course_category(0);
    foreach ($roleassignments as $roleassignment) {
        $user_roles[] = $roleassignment->roleid;
    }
    //print_r($user_roles);exit;
    $show_full_course = false;
    $show_teacher_course = false;
    $teacher_courses = '';
    $chelper = new \coursecat_helper();
    $chelper->set_show_courses(30);
    $exam_organizers = '';
    if (in_array(5, $user_roles)) {
        $show_student = true;
        $user_info_field = $DB->get_record_sql("SELECT * FROM {user_info_field} WHERE shortname='registrationcode' LIMIT 1");
        $user_info_data = $DB->get_record_sql("SELECT * FROM {user_info_data} WHERE userid=? and fieldid=?  LIMIT 1", array(intval($USER->id), intval($user_info_field->id)));
        $user_short_code = strtolower($user_info_data->data);
        $user_short_codes = explode("\r\n", $user_short_code);

        $q = 0;
        foreach ($user_short_codes as $short_code) {
            if(!empty($short_code)){
                $exam_organizers .= '<div class="category  eodo-category">';
                $exam_organizers .= '<div class="info2">';
                $category = $DB->get_record_sql("SELECT * FROM {course_categories} WHERE idnumber Like '%" . $short_code . "%' LIMIT 1");
                $exam_organizers .= '<h3 class="categoryname">' . $category->name . '</h3>';
                $child_categories = $DB->get_records_sql("SELECT * FROM {course_categories} WHERE parent='" . $category->id . "' and path Like '%" . $category->id . "%' and coursecount > 0 order by sortorder asc");
                $course_html = '';
                $sub_categories = array();
                foreach ($child_categories as $child_category) {
                    $sub_categories[] = '"' . $child_category->id . '"';
                }
                if (count($child_categories) > 1) {
                    $sub_categories = implode(',', $sub_categories);

                    $courses = $DB->get_records_sql("SELECT * FROM {course} WHERE category IN(" . $sub_categories . ") order by sortorder asc");
                    $i = 0;
                    foreach ($courses as $course) {
                        
                        
                        $course_html .= '<div class="course-deck mt-2" style="float:left;">';
                        $course_html .= '<div class="card collapsed organizers" data-courseid="' . $course->id . '">';
                        $course_html .= '<br/>';
                        $course_html .= \theme_moove\output\core\course_renderer::coursecat_coursebox_content($chelper, $course, 'examp_orginizer');
                        $course_html .= "</div>";
                        
                        $course_html .= "</div>";
                        $i++;
                    }
                    $exam_organizers .= '<div class="course"> ' . $course_html
                            . "</div>";
                }
                $courses = $DB->get_records('course', array('category' => $category->id), $sort = 'sortorder asc', '*');
                $i = 0;
                $course_html = '';
                foreach ($courses as $course) {
                    
                    $course_html .= '<div class="course-deck  mt-2">';
                    $course_html .= '<div class="card collapsed organizers" data-courseid="' . $course->id . '">';
                    $course_html .= '<br/>';
                    $course_html .= \theme_moove\output\core\course_renderer::coursecat_coursebox_content($chelper, $course, 'examp_orginizer');
                    $course_html .= "</div>";
                    $course_html .= "</div>";
                    $i++;
                }
                $exam_organizers .= '<div class="course"> ' . $course_html
                        . "</div>";

                $exam_organizers .= '</div>';
                $exam_organizers .= '</div>';
                $q++;
            }
        }
    } else if (in_array(1, $user_roles) || in_array(6, $user_roles) || in_array(7, $user_roles) || in_array(8, $user_roles)) {
        $show_full_course = true;
        $show_student = false;
        if (in_array(1, $user_roles)){
            $heading_full_course = 'Manage Courses';
        }else{
            $heading_full_course = 'Book Courses';
        }
    } else if(in_array(2, $user_roles) || in_array(3, $user_roles)){
        $show_full_course = false;
        $show_student = false; 
        $show_teacher_course = true;
        $heading_full_course = 'Manage Courses';
        $teacher_courses = '<div class="category  eodo-category">';
        $teacher_courses .= '<div class="info2">';
        $courses = enrol_get_users_courses($USER->id, true, '*', 'sortorder ASC , fullname ASC, visible DESC');
            $i = 0;
            $course_html = '<div class="card-deck mt-2"> ';
            foreach ($courses as $course) {
                if ($i > 3) {
                    $i = 0;
                    $course_html .= '<div class="card-deck mt-2">';
                }
                $course_html .= '<div class="card collapsed organizers" data-courseid="' . $course->id . '">';
                $course_html .= \theme_moove\output\core\course_renderer::coursecat_coursebox_content($chelper, $course, 'examp_orginizer');
                $course_html .= "</div>";
                if ($i == 3) {
                    $course_html .= "</div>";
                }
                $i++;
            }
            $course_html .= "</div>";
            $teacher_courses .= '<div class="course"> ' . $course_html
                    . "</div>";
        $teacher_courses .= '</div>';
        $teacher_courses .= '</div>';
    }else {
        $show_student = false;
    }
//    $content_html = $OUTPUT->blocks('content');
    // Add a custom block.
    if (in_array(5, $user_roles)) {
        $contextt = context_user::instance($user->id);
        $page = new moodle_page();
        $page->set_context($contextt);
        $page->set_pagelayout('mydashboard');
        $page->set_pagetype('my-index');
        $page->blocks->add_region('content');
        $currentpage = my_get_page($user->id, MY_PAGE_PRIVATE);
        $page->set_subpage($currentpage->id);
        $page->blocks->load_blocks();
        
        $is_calendar_month_block_cinstance = $DB->get_record_sql("SELECT count(*) as block_count FROM {block_instances} WHERE parentcontextid='".$contextt->id."' and blockname='calendar_month' and pagetypepattern='my-index' and defaultregion='content' ");
        if($is_calendar_month_block_cinstance->block_count == 0){
            $page->blocks->add_block('calendar_month', 'content', 0, false);
        }
        $is_timeline_block_cinstance = $DB->get_record_sql("SELECT count(*) as block_count FROM {block_instances} WHERE parentcontextid='".$contextt->id."' and blockname='timeline' and pagetypepattern='my-index' and defaultregion='content' ");
        if($is_timeline_block_cinstance->block_count == 0){
            $page->blocks->add_block('timeline', 'content', 0, false);
        }
    }
    //$exame_orginser = '';
    $templatecontext = [
        'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
        'output' => $OUTPUT,
        'sidepreblocks' => $blockshtml,
        'course_cat' => $course_cat,
        'hasblocks' => $hasblocks,
        'bodyattributes' => $bodyattributes,
        'hasdrawertoggle' => true,
        'exame_orginser' => $exam_organizers,
        'show_student' => $show_student,
        'heading_full_course' => $heading_full_course,
        'show_full_course' => $show_full_course,
        'show_teacher_course' => $show_teacher_course,
        'teacher_courses' => $teacher_courses,
        'navdraweropen' => $navdraweropen,
        'calander' => $PAGE->blocks->region_has_content('block_calendar', $OUTPUT),
    'rand_time' => time(),
        'draweropenright' => $draweropenright,
        'regionmainsettingsmenu' => $regionmainsettingsmenu,
        'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
        'is_siteadmin' => is_siteadmin()
    ];
    
    $themesettings = new \theme_moove\util\theme_settings();

    $templatecontext = array_merge($templatecontext, $themesettings->footer_items());

    if (is_siteadmin()) {
        $adminifos = new \theme_moove\util\admininfos();

        $templatecontext['totalusage'] = $adminifos->get_totaldiskusage();
        $templatecontext['totalactiveusers'] = $adminifos->get_totalactiveusers();
        $templatecontext['totalsuspendedusers'] = $adminifos->get_suspendedusers();
        $templatecontext['totalcourses'] = $adminifos->get_totalcourses();
        $templatecontext['onlineusers'] = $adminifos->get_totalonlineusers();
        $templatecontext['category_course_registered_user'] = $adminifos->get_category_course_registered_user();
    }

    // Improve boost navigation.
    theme_moove_extend_flat_navigation($PAGE->flatnav);

    $templatecontext['flatnavigation'] = $PAGE->flatnav;
    $themesettings = new \theme_moove\util\theme_settings();

    $templatecontext = array_merge($templatecontext, $themesettings->footer_items());


//    $calander_render = new core_calendar_renderer();
    //$cor_course_render = new core_course_renderer($PAGE, 'course');
    //$templatecontext['courses_examorganizer_courses'] = $cor_course_render->course_category(0);
    $usercourses = \theme_moove\util\extras::user_courses_with_progress($user);
    foreach($usercourses as $usercourse){
//        print_r($usercourse);
    }
    $templatecontext['hascourses'] = $show_student;
    if ($templatecontext['hascourses']) {

    }
    $templatecontext['courses'] = array_values($usercourses);

    $templatecontext['firstname'] = $user->firstname;

    //Three Tabs Names
    $templatecontext['overview'] = get_string('overview', 'theme_moove');
    $templatecontext['examorganizer'] = get_string('examorganizer', 'theme_moove');
    $templatecontext['bookcourses'] = get_string('bookcourses', 'theme_moove');
    // $templatecontext['welcome'] = get_string('welcome','theme_moove');
    // Second Tabs Work Here ExamOrganizer
    // $exam_course = get_courses();
    $exam_course = \theme_moove\util\extras::user_courses_with_progress($user);
    $templatecontext['courses_examorganizer'] = (!empty($exam_organizers)) ? true : false;
    $templatecontext['get_courses_examorganizer'] = array_values($exam_course);

    // require_once $CFG->dirroot.'/availability/condition/days/classes/condition.php';
    // $res_course = new condition();
    // $reference_date = $res_course->get_reference_date();
    // Second Tabs Work Here ExamOrganizer
    //Grade Report Overview Dashboard Show
    // $courseid = optional_param('id', SITEID, PARAM_INT);
    // if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    //     print_error('invalidcourseid');
    // }
    // $context = context_course::instance($course->id);
    // /// return tracking object
    // $gpr = new grade_plugin_return(array('type'=>'report', 'plugin'=>'overview', 'courseid'=>$course->id, 'userid'=>$userid));
    // // grade_report_overview dashboard
    // // Create a report instance
    //     $report = new grade_report_overview($userid, $gpr, $context);
    //  if (!empty($report->studentcourseids)) {
    //         // If the course id matches the site id then we don't have a course context to work with.
    //         // Display a standard page.
    //         if ($courseid == SITEID) {
    //             if ($report->fill_table(true, true)) {
    //                 echo html_writer::tag('h3', get_string('coursesiamtaking', 'grades'));
    //                 $templatecontext['courses_report'] =  $report->print_table(true);
    //             }
    //         } else { // We have a course context. We must be navigating from the gradebook.
    //             print_grade_page_head($courseid, 'report', 'overview', get_string('pluginname', 'gradereport_overview')
    //                     . ' - ' . fullname($report->user));
    //             if ($report->fill_table()) {
    //                 echo '<br />' . $report->print_table(true);
    //             }
    //         }
    //     }
    //     if (count($report->teachercourses)) {
    //         echo html_writer::tag('h3', get_string('coursesiamteaching', 'grades'));
    //         $report->print_teacher_table();
    //     }
    //     if (empty($report->studentcourseids) && empty($report->teachercourses)) {
    //         // We have no report to show the user. Let them know something.
    //         echo $OUTPUT->notification(get_string('noreports', 'grades'), 'notifymessage');
    //     }
    // echo "<pre>";
    // // print_r($report->fill_table(true, true));
    // die();

    echo $OUTPUT->render_from_template('theme_moove/mydashboard', $templatecontext);
