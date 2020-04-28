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

        $sql = "SELECT name FROM `oodo_course_categories` ";
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

        // $userid = optional_param('id', $USER->id, PARAM_INT);
        // $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);

        // $sql = "SELECT DISTINCT coursecount, count(userid) FROM `oodo_course_categories` as course_cat
        // INNER JOIN `oodo_course` as course ON course_cat.id = course.category
        // INNER JOIN `oodo_enrol` as enroll ON enroll.courseid = course.id
        // INNER JOIN `oodo_user_enrolments` as user_enrol ON user_enrol.enrolid = enroll.id";

          // $sql = "SELECT DISTINCT u.id AS userid, c.id AS courseid
        //         FROM oodo_user u
        //         INNER JOIN oodo_user_enrolments ue ON ue.userid = u.id
        //         INNER JOIN oodo_enrol e ON e.id = ue.enrolid
        //         INNER JOIN oodo_role_assignments ra ON ra.userid = u.id
        //         INNER JOIN oodo_context ct ON ct.id = ra.contextid AND ct.contextlevel = 50
        //         INNER JOIN oodo_course c ON c.id = ct.instanceid AND e.courseid = c.id
        //         INNER JOIN oodo_role r ON r.id = ra.roleid AND r.shortname = 'student'
        //         WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0
        //           AND (ue.timeend = 0 OR ue.timeend > NOW()) AND ue.status = 0";


        $sql = "SELECT DISTINCT count(ue.userid), cc.name
                FROM oodo_user u
                INNER JOIN oodo_user_enrolments ue ON ue.userid = u.id
                INNER JOIN oodo_enrol e ON e.id = ue.enrolid
                INNER JOIN oodo_role_assignments ra ON ra.userid = u.id
                INNER JOIN oodo_course c ON e.courseid = c.id
                INNER JOIN oodo_course_categories cc ON cc.id = c.category
                INNER JOIN oodo_role r ON r.id = ra.roleid AND r.shortname = 'student'
                WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0 AND ue.status = 0
                ";



        $course_count = $DB->get_records_sql($sql);

        return $course_count;
    }

    public function allcourses() {
        global $DB;

        $sql = "SELECT id FROM `oodo_course_categories` ";
        $category_course_id = $DB->get_records_sql($sql);
        $course_cat = json_decode(json_encode($category_course_id),true);
        $course_category_by_id = [];
        
        foreach ($course_cat as $key => $value) {
            
            $id_cat = $course_cat[$key]['id'];
            $get_course = "SELECT * FROM `oodo_course` WHERE category = '". $id_cat ."'";
            $_course_id = $DB->get_records_sql($get_course);
            $cour_ = json_decode(json_encode($_course_id),true);

            foreach ($cour_ as $keys => $values) {
                array_push($course_category_by_id, $values);
            }

        }
        
        return $course_category_by_id;
    }

    public function upload_course() {
        global $DB;

        $get_courses = "SELECT *
                        FROM oodo_files
                        -- INNER JOIN oodo_context ON oodo_files.contextid = oodo_context.id
                        -- INNER JOIN oodo_resource ON oodo_context.instanceid = oodo_resource.id
                        -- INNER JOIN oodo_course ON oodo_resource.course = oodo_course.id
                        INNER JOIN oodo_role_assignments ON oodo_role_assignments.userid = oodo_files.userid
                        INNER JOIN oodo_role ON oodo_role.id = oodo_role_assignments.roleid AND oodo_role.shortname = 'student'
                        ";
        $_course_ids = $DB->get_records_sql($get_courses);
        // echo "<pre>";
        // print_r($_course_ids);
        // die();
        return $_course_ids;
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
