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
 * Pages plugin settings file.
 *
 * @package         local_discounts
 * @author          LEADconcept <info@leadconcept.biz>.
 * @copyright       2020 LEADconcept Ltd.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

defined('MOODLE_INTERNAL') || die;

// Used to stay DRY with the get_string function call.
$componentname = 'local_discounts';

// Default for users that have site config.
if ($hassiteconfig) {
    // Add the category to the local plugin branch.
    $ADMIN->add('localplugins', new \admin_category('local_discounts', get_string('pluginname', $componentname)));

    // Create a settings page for local pages.
    $settingspage = new \admin_settingpage('pages', get_string('pluginsettings', $componentname));

    // Make a container for all of the settings for the settings page.
    $settings = [];

    // Setting to control the URLs used for created pages.
    $settings[] = new \admin_setting_configcheckbox(
        'local_discounts/cleanurl_enabled',
        get_string('cleanurl_enabled', 'local_discounts'),
        get_string('cleanurl_enabled_description', 'local_discounts'),
        0
    );

    // Setting to copy a message to the user that fills out a form.
    $settings[] = new \admin_setting_configcheckbox(
        'local_discounts/user_copy',
        get_string('user_copy', 'local_discounts'),
        get_string('user_copy_description', 'local_discounts'),
        0
    );

    // Setting to limit the amount of emails to 1 per session.
    $settings[] = new \admin_setting_configcheckbox(
        'local_discounts/enable_limit',
        get_string('enable_limit', 'local_discounts'),
        get_string('enable_limit_description', 'local_discounts'),
        0
    );

    // Setting to define a message to be sent to a user from a form.
    $settings[] = new \admin_setting_confightmleditor(
        'local_discounts/message_copy',
        get_string('message_copy', 'local_discounts'),
        get_string('message_copy_description', 'local_discounts'),
        ''
    );

    // Add all the settings to the settings page.
    foreach ($settings as $setting) {
        $settingspage->add($setting);
    }

    // Add the settings page to the nav tree.
    $ADMIN->add('local_discounts', $settingspage);

    // Add the 'Manage pages' page to the nav tree.
    $ADMIN->add(
        'local_discounts',
        new \admin_externalpage(
            'Manage Pages',
            get_string('pluginsettings_managediscountcode', $componentname),
            new \moodle_url('/local/discounts/discounts.php'),
            'local/discountcodes:adddiscountcodes'
        )
    );
} else if (has_capability('local/discountcodes:adddiscountcodes', \context_system::instance())) {
    // For other users that don't have the site config capability, do this.
    $ADMIN->add('root', new \admin_category('local_discounts', get_string('pluginname', $componentname)));

    // Add the 'Manage pages' page to the nav tree.
    $ADMIN->add(
        'local_discounts',
        new \admin_externalpage(
            'Manage Pages',
            get_string('pluginsettings_managediscountcode', $componentname),
            new \moodle_url('/local/discounts/discounts.php'),
            'local/discountcodes:adddiscountcodes'
        )
    );
}