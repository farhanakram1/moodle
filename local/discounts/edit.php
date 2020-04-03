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
 * local pages
 *
 * @package     local_discounts
 * @author      LEADconcept
 * @copyright   2020 LEADconcept Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/local/discounts/lib.php');

$download = optional_param('download', '', PARAM_ALPHA);
$pageid = optional_param('id', 0, PARAM_INT);
$context = context_system::instance();

global $USER, $PAGE;

// Set PAGE variables.
$PAGE->set_context($context);
$PAGE->set_url($CFG->wwwroot . '/local/discounts/edit.php', array("id" => $pageid));

// Force the user to login/create an account to access this page.
require_login();

if (!has_capability('local/discountcodes:adddiscountcodes', $context)) {
    require_capability('local/discountcodes:adddiscountcodes', $context);
}

// Add chosen Javascript to list.
$PAGE->requires->jquery();
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/local/discounts/js/pages.js'));

$PAGE->set_pagelayout('standard');

// Get the renderer for this page.
$renderer = $PAGE->get_renderer('local_discounts');

$pagetoedit = \local_discounts\custompage::load($pageid, true);
$renderer->save_page($pagetoedit);
// Print the page header.
$PAGE->set_title(get_string('discount_code_setup_title', 'local_discounts'));
$PAGE->set_heading(get_string('discount_code_setup_heading', 'local_discounts'));

$table = new \local_discounts\formhistory('form-history');
$table->is_downloadable(true);
$table->is_downloading($download, 'form-report', 'Pages Form Report');

// Configure the table.
$table->define_baseurl(new moodle_url($CFG->wwwroot . '/local/discounts/edit.php', array("id" => $pageid)));

$table->set_attribute('class', 'admintable generaltable history-table');
$table->collapsible(false);
$table->show_download_buttons_at(array(TABLE_P_BOTTOM));

$table->set_sql('*', "{local_discountslogging}", "formname = '$pageid'");

if (!$table->is_downloading()) {

    echo $OUTPUT->header();

    printf('<h1 class="page__title">%s<a style="color:#FFF;float:right;font-size:15px" href="' .
        new moodle_url($CFG->wwwroot . '/local/discounts/discounts.php') . '"> '.
        get_string('backtolist', 'local_discounts') .'</a></h1>',
        get_string('customdiscount_title', 'local_discounts'));

    echo $renderer->edit_page($pagetoedit);
}
if (strtolower($pagetoedit->pagetype) == "form") {
    $table->out(25, true);
}

if (!$table->is_downloading()) {
    echo $OUTPUT->footer();
}