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

require_once $CFG->libdir.'/gradelib.php';
require_once $CFG->dirroot.'/grade/lib.php';
require_once $CFG->dirroot.'/grade/report/overview/lib.php';

global $DB;
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

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;

$extraclasses = [];
if ($navdraweropen) {
    $extraclasses[] = 'drawer-open-left';
}

if ($draweropenright && $hasblocks) {
    $extraclasses[] = 'drawer-open-right';
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'hasdrawertoggle' => true,
    'navdraweropen' => $navdraweropen,
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
}

// Improve boost navigation.
theme_moove_extend_flat_navigation($PAGE->flatnav);

$templatecontext['flatnavigation'] = $PAGE->flatnav;
$themesettings = new \theme_moove\util\theme_settings();

$templatecontext = array_merge($templatecontext, $themesettings->footer_items());

$usercourses = \theme_moove\util\extras::user_courses_with_progress($user);
$templatecontext['hascourses'] = (count($usercourses)) ? true : false;
$templatecontext['courses'] = array_values($usercourses);




//Grade Report Overview Dashboard Show

$courseid = optional_param('id', SITEID, PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

$context = context_course::instance($course->id);

/// return tracking object
$gpr = new grade_plugin_return(array('type'=>'report', 'plugin'=>'overview', 'courseid'=>$course->id, 'userid'=>$userid));

// grade_report_overview dashboard
// Create a report instance
    $report = new grade_report_overview($userid, $gpr, $context);

 if (!empty($report->studentcourseids)) {
        // If the course id matches the site id then we don't have a course context to work with.
        // Display a standard page.
        if ($courseid == SITEID) {
            
            if ($report->fill_table(true, true)) {
                $templatecontext['courses_report'] =  $report->print_table(true);
            }
        } else { // We have a course context. We must be navigating from the gradebook.
            print_grade_page_head($courseid, 'report', 'overview', get_string('pluginname', 'gradereport_overview')
                    . ' - ' . fullname($report->user));
            if ($report->fill_table()) {
                echo '<br />' . $report->print_table(true);
            }
        }
    }

    if (count($report->teachercourses)) {
        echo html_writer::tag('h3', get_string('coursesiamteaching', 'grades'));
        $report->print_teacher_table();
    }

    if (empty($report->studentcourseids) && empty($report->teachercourses)) {
        // We have no report to show the user. Let them know something.
        echo $OUTPUT->notification(get_string('noreports', 'grades'), 'notifymessage');
    }

    // echo "<pre>";
    // // print_r($report->fill_table(true, true));
    // die();

echo $OUTPUT->render_from_template('theme_moove/mydashboard', $templatecontext);
