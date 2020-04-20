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
 * Custom moove admin infos
 *
 * @package    theme_moove
 * @copyright  2020 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_moove\util;

defined('MOODLE_INTERNAL') || die();

/**
 * Class to get some admin infos in Moodle.
 *
 * @package    theme_moove
 * @copyright  2020 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class admininfos {
    /**
     * Returns the total of active users.
     *
     * @return int
     * @throws \dml_exception
     */
    public function get_totalactiveusers() {
        global $DB;

        return $DB->count_records('user', array('deleted' => 0, 'suspended' => 0)) - 1;
    }

    public function get_category_course_name() {
        global $DB;

        $sql = "SELECT name FROM {course_categories} ";
        $category_course_registered_user = $DB->get_records_sql($sql);
        $course_cat = json_decode(json_encode($category_course_registered_user),true);

        $course_category = [];
        foreach ($course_cat as $key => $value) {
            array_push($course_category, $value);
        }
        return $course_category;
    }

    public function get_category_course_registered_user(){
        global $DB, $USER;

        $userid = optional_param('id', $USER->id, PARAM_INT);
        $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);

        $sql = "SELECT * FROM `oodo_user_enrolments` as user_enroll
        LEFT JOIN `oodo_user` as user_details ON user_details.id = user_enroll.userid
       
        ";
        $course_cat = $DB->get_records_sql($sql);

// echo "<pre>";
// print_r($course_cat);
// die();

    }


    /**
     * Returns the total of suspended users.
     *
     * @return int
     * @throws \dml_exception
     */
    public function get_suspendedusers() {
        global $DB;

        return $DB->count_records('user', array('deleted' => 0, 'suspended' => 1));
    }

    /**
     * Returns the total of courses.
     *
     * @return int
     * @throws \dml_exception
     */
    public function get_totalcourses() {
        global $DB;

        return $totalcourses = $DB->count_records('course') - 1;
    }

    /**
     * Returns the total of online users.
     *
     * @return int
     * @throws \dml_exception
     */
    public function get_totalonlineusers() {
        $onlineusers = new \block_online_users\fetcher(null, time(), 300, null, CONTEXT_SYSTEM, null);

        return $onlineusers->count_users();
    }

    /**
     * Returns the total of disk usage
     *
     * @return string
     * @throws \coding_exception
     */
    public function get_totaldiskusage() {
        $cache = \cache::make('theme_moove', 'admininfos');
        $totalusagereadable = $cache->get('totalusagereadable');

        if (!$totalusagereadable) {
            return get_string('notcalculatedyet', 'theme_moove');
        }

        $usageunit = ' MB';
        if ($totalusagereadable > 1024) {
            $usageunit = ' GB';
        }

        return $totalusagereadable . $usageunit;
    }
}
