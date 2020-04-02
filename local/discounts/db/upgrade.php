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
 * Local Pages Upgrade
 *
 * @package     local_discounts
 * @author      LEADconcept
 * @copyright   2020 LEADconcept Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

/**
 *
 * This is to upgrade the older versions of the plugin.
 *
 * @param integer $oldversion
 * @return bool
 * @copyright   2020 LEADconcept Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function xmldb_local_discounts_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2020011100) {
        $table = new xmldb_table('local_discounts');
        $field = new xmldb_field('exp_discount_date', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');

        // Conditionally add exp_discount_date.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('discountorder', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');

        // Conditionally add exp_discount_date.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('local_discountslogging');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('formcontent', XMLDB_TYPE_TEXT, null, null, null, null);
        $table->add_field('formdate', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('formname', XMLDB_TYPE_TEXT, '10', null, null, null);
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Local pages savepoint reached.
        upgrade_plugin_savepoint(true, 2020011100, 'local', 'pages');
    }

    return true;
}