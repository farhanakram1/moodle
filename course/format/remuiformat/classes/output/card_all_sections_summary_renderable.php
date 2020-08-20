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
 * Sinigle Section Renderable - A topics based format that uses card layout to diaply the content.
 *
 * @package course/format
 * @subpackage remuiformat
 * @copyright  2019 WisdmLabs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace format_remuiformat\output;
defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;
use stdClass;
use context_course;
use html_writer;
use moodle_url;
use core_completion\progress;
use core_course\external\course_summary_exporter;

require_once($CFG->dirroot.'/course/format/renderer.php');
require_once($CFG->dirroot.'/course/renderer.php');
require_once($CFG->dirroot.'/course/format/remuiformat/classes/mod_stats.php');
require_once($CFG->dirroot.'/course/format/remuiformat/classes/course_format_data_common_trait.php');
require_once($CFG->dirroot.'/course/format/remuiformat/lib.php');

/**
 * This file contains the definition for the renderable classes for the card all sections summary page.
 *
 * @package   format_remuiformat
 * @copyright  2019 WisdmLabs
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class format_remuiformat_card_all_sections_summary implements renderable, templatable {

    // Variables.
    private $course;
    private $courseformat;
    protected $courserenderer;
    private $modstats;
    private $courseformatdatacommontrait;
    private $settings;

    /**
     * Constructor
     */
    public function __construct($course, $renderer) {
        $this->courseformat = course_get_format($course);
        $this->course = $this->courseformat->get_course();
        $this->courserenderer = $renderer;
        $this->modstats = \format_remuiformat\ModStats::getinstance();
        $this->courseformatdatacommontrait = \format_remuiformat\course_format_data_common_trait::getinstance();
        $this->settings = $this->courseformat->get_settings();
    }

    /**
     * Function to export the renderer data in a format that is suitable for a
     * question mustache template.
     *
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export.
     * @return stdClass|array
     */
    public function export_for_template(renderer_base $output) {
        global $PAGE, $CFG;
        unset($output);
        $export = new \stdClass();
        $renderer = $PAGE->get_renderer('format_remuiformat');
        $rformat = $this->settings['remuicourseformat'];

        // Get necessary default values required to display the UI.
        $editing = $PAGE->user_is_editing();
        $export->editing = $editing;
        $export->courseformat = get_config('format_remuiformat', 'defaultcourseformat');

        if ($rformat == REMUI_CARD_FORMAT) {
            $PAGE->requires->js_call_amd('format_remuiformat/format_card', 'init');
            $this->get_card_format_context($export, $renderer, $editing, $rformat);
        }
        return  $export;
    }

    /**
     * Returns the context containing the details required by the cards format mustache.
     *
     * @param Object $export
     * @param Object $renderer
     * @param Boolean $editing
     * @return Object
     */
    private function get_card_format_context(&$export, $renderer, $editing, $rformat) {
        global $OUTPUT, $DB,$USER;
        $coursecontext = context_course::instance($this->course->id);
        $modinfo = get_fast_modinfo($this->course);
        $sections = $modinfo->get_section_info_all();

        // Setting up data for General Section.
        $generalsection = $modinfo->get_section_info(0);
        $generalsectionsummary = $renderer->format_summary_text($generalsection);
        if ($generalsection) {
            if ($editing) {
                $export->generalsection['title'] = $renderer->section_title($generalsection, $this->course);
                $export->generalsection['editsetionurl'] = new \moodle_url('editsection.php', array('id' => $generalsection->id));
                $export->generalsection['leftsection'] = $renderer->section_left_content($generalsection, $this->course, false);
                $export->generalsection['optionmenu'] = $renderer->section_right_content($generalsection, $this->course, false);
            } else {
                $export->generalsection['title'] = $this->courseformat->get_section_name($generalsection);
            }

            $generalsecactivities = $this->get_activities_details($generalsection);
            $export->generalsection['activities'] = $generalsecactivities;
            // Check if activities exists in general section.
            if ( !empty($generalsecactivities) ) {
                $export->generalsection['activityexists'] = 1;
            } else {
                $export->generalsection['activityexists'] = 0;
            }
            $export->generalsection['availability'] = $renderer->section_availability($generalsection);
            $sectiontitlesummarymaxlength = $this->settings['sectiontitlesummarymaxlength'];

            $export->generalsection['summary'] = $renderer->abstract_html_contents(
                $generalsectionsummary, 400
            );
            $export->generalsection['fullsummary'] = $renderer->format_summary_text($generalsection);
            // Get course image if added.

            $imgurl = $this->courseformatdatacommontrait->display_file($this->settings['remuicourseimage_filemanager']);
            $imgurl = $this->courseformatdatacommontrait->display_file($this->settings['remuicourseimage_filemanager']);
            if (empty($imgurl)) {
                $imgurl = $this->courseformatdatacommontrait->get_dummy_image_for_id($this->course->id);
            }
            $export->generalsection['coursemainimage'] = $imgurl;
            
            $percentage = progress::get_course_progress_percentage($this->course);
            if (!is_null($percentage)) {
                $percentage = floor($percentage);
                $export->generalsection['percentage'] = $percentage;
            }
            $export->scheduler_class = '';
            $number_of_sessions = $DB->get_record_sql('SELECT * from {customfield_data} where instanceid = '.$this->course->id);
            $number_of_sessions = (int)$number_of_sessions->intvalue;
            if($number_of_sessions > 0){
                $export->scheduler_class = 'scheduler';
                $sql = 'SELECT count(*) as total_attended_sessions FROM {scheduler} s
                        LEFT JOIN {scheduler_slots} ss
                        ON s.id = ss.schedulerid
                        LEFT JOIN {scheduler_appointment} sa 
                        ON ss.id = sa.slotid
                        WHERE s.course = '.$this->course->id.' and sa.attended = 1 and sa.studentid = '.$USER->id;
                $attended_sessions = $DB->get_record_sql($sql);
                $attended_sessions = (int)$attended_sessions->total_attended_sessions;
                if($attended_sessions > $number_of_sessions){
                    $attended_sessions = $number_of_sessions;
                }
                $percentChange = ($attended_sessions / $number_of_sessions) * 100;
                $export->generalsection['percentage'] = $percentChange;
                if($percentChange == 100){
                    $export->generalsection['scheduler_sessions'] = 'All Sessions Completed';
                }else{
                    $export->generalsection['scheduler_sessions'] = 'Attended Sessions: '.$attended_sessions;
                }
            }
            
            // Get the all activities count from the all sections.
            $sectionmods = array();
            for ($i = 0; $i < count($sections); $i++) {
                if (isset($modinfo->sections[$i])) {
                    foreach ($modinfo->sections[$i] as $cmid) {
                        $thismod = $modinfo->cms[$cmid];
                        if (isset($sectionmods[$thismod->modname])) {
                            $sectionmods[$thismod->modname]['name'] = $thismod->modplural;
                            $sectionmods[$thismod->modname]['count']++;
                        } else {
                            $sectionmods[$thismod->modname]['name'] = $thismod->modfullname;
                            $sectionmods[$thismod->modname]['count'] = 1;
                        }
                    }
                }
            }
            foreach ($sectionmods as $mod) {    
                $output['activitylist'][] = $mod['count'].' '.$mod['name'];
            }
            $export->activitylist = $output['activitylist'];

            // Get reseume activity link.
            $export->resumeactivityurl = $this->courseformatdatacommontrait->get_activity_to_resume($this->course);
        }
        // Add new activity.
        $export->generalsection['addnewactivity'] = $this->courserenderer->course_section_add_cm_control($this->course, 0, 0);
        // Setting up data for remianing sections.
        $export->sections = $this->courseformatdatacommontrait->get_all_section_data(
            $renderer,
            $editing, $rformat,
            $this->settings,
            $this->course,
            $this->courseformat,
            $this->courserenderer
        );
    }

    private function get_activities_details($section, $displayoptions = array()) {
        global $PAGE,$DB;
        $modinfo = get_fast_modinfo($this->course);
        $output = array();
        $completioninfo = new \completion_info($this->course);
        if (!empty($modinfo->sections[$section->section])) {
            $count = 1;
            foreach ($modinfo->sections[$section->section] as $modnumber) {
                $mod = $modinfo->cms[$modnumber];
                if (!$mod->is_visible_on_course_page()) {
                    continue;
                }
                $completiondata = $completioninfo->get_data($mod, true);
                $activitydetails = new \stdClass();
                $activitydetails->index = $count;
                $activitydetails->id = $mod->id;
                if ($completioninfo->is_enabled()) {
                    $activitydetails->completion = $this->courserenderer->course_section_cm_completion(
                        $this->course,   $completioninfo, $mod, $displayoptions
                    );
                }
                $activitydetails->viewurl = $mod->url;
                $activitydetails->title = $this->courserenderer->course_section_cm_name($mod, $displayoptions);
                if ($mod->modname == 'label') {
                    $activitydetails->title = $this->courserenderer->course_section_cm_text($mod, $displayoptions);
                }
                $activitydetails->title .= $mod->afterlink;
                $activitydetails->modulename = $mod->modname;
                $activitydetails->summary = $this->courserenderer->course_section_cm_text($mod, $displayoptions);
                $activitydetails->summary = $this->modstats->get_formatted_summary(
                    $activitydetails->summary,
                    $this->settings
                );
                $activitydetails->completed = $completiondata->completionstate;
                $modicons = '';
                if ($mod->visible == 0) {
                    $activitydetails->hidden = 1;
                }
                $availstatus = $this->courserenderer->course_section_cm_availability($mod, $modnumber);
                if ($availstatus != "") {
                    $activitydetails->availstatus = $availstatus;
                }
                $download_files = $DB->get_records_sql('SELECT * FROM {context} oc, {files} of WHERE oc.id = of.contextid and oc.instanceid=' . $mod->id . ' and of.filesize != 0 and of.component = "mod_assign" ');
                if(count($download_files) > 0){
                    $downloads = '<div class="download_assignments"><b>Download Assignment</b><br/>';
                    foreach ($download_files as $download_file) {
                        $file_link = new moodle_url('/pluginfile.php/' . $download_file->contextid . '/' . $download_file->component . '/' . $download_file->filearea . '/0/' . $download_file->filename . '?forcedownload=1');
                        $downloads .= '<button data-course-id="'.$this->course->id.'" data-link="'.$file_link.'" type="button" class="download_file" onclick="check_status(this);" title="Download Assignment"> ' . $download_file->filename . '</button> <a onlclick href="' . $file_link . '"></a><br/>';
                    }
                    $downloads .= '</div>';
                    $activitydetails->downloads = $downloads;
                    $submission_link = new moodle_url('/mod/assign/view.php');
                    if($activitydetails->completed){
                        $activitydetails->submissions  = '<a style="text-decoration:none;" class="btn btn-secondary"  href="'.$mod->url.'">View submission</a>';
                    }else{
                        $activitydetails->submissions  = '<form method="get" action="'.$submission_link.'">
                                                <input type="hidden" name="id" value="'.$mod->id.'">
                                                <input type="hidden" name="action" value="editsubmission">
                                            <button type="submit" class="btn btn-secondary" id="single_button" title="">Add submission</button>
                                        </form>';
                    }
                }
                if ($PAGE->user_is_editing()) {
                    $editactions = course_get_cm_edit_actions($mod, $mod->indent, $section->section);
                    $modicons .= ' '. $this->courserenderer->course_section_cm_edit_actions($editactions, $mod, 0);
                    $modicons .= $mod->afterediticons;
                    $activitydetails->modicons = $modicons;
                }
                $output[] = $activitydetails;
                $count++;
            }
        }
        return $output;
    }
}
