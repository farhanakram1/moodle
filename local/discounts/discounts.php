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
 * Local Pages Edit Page
 *
 * @package     local_discounts
 * @author      LEADconcept
 * @copyright   2020 LEADconcept Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/local/discounts/lib.php');

$deletepage = optional_param('pagedel', 0, PARAM_INT);
$context = context_system::instance();

global $USER, $PAGE;

// Set PAGE variables.
$PAGE->set_context($context);
$PAGE->set_url($CFG->wwwroot . '/local/discounts/discounts.php');

// Force the user to login/create an account to access this page.
require_login();

require_capability('local/discountcodes:adddiscountcodes', $context);

if ($deletepage !== 0) {
    if (confirm_sesskey()) {
        global $DB;
        $options = new stdClass();
        $options->id = $deletepage;
        $options->deleted = 1;
        $DB->update_record('local_discounts', $options);
    }
}

$PAGE->set_pagelayout('standard');

// Get the renderer for this page.
$renderer = $PAGE->get_renderer('local_discounts');

// Only print headers if not asked to download data.
// Print the page header.
$PAGE->set_title(get_string('discount_code_setup_title', 'local_discounts'));
$PAGE->set_heading(get_string('discount_code_setup_heading', 'local_discounts'));
$PAGE->requires->jquery();

// Set the admin navigation tree to Plugins > Local Plugins > Pages > Manage Pages for users that have site config.
if (has_capability('moodle/site:config', $context)) {
//    require_once($CFG->libdir . '/adminlib.php');
//    admin_externaldiscount_setup('Manage Discount Codes');
}

echo $OUTPUT->header();

printf('<h1 class="discount__title">%s</h1>', get_string('customdiscount_title', 'local_discounts'));

echo $renderer->list_discounts();

echo $OUTPUT->footer();