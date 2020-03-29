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
 * @package         local_stripsignup
 * @author          LEADconcept <info@leadconcept.biz>.
 * @copyright       2017 LEADconcept Ltd.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

defined('MOODLE_INTERNAL') || die;

// Used to stay DRY with the get_string function call.
$componentname = "local_stripsignup";

// Default for users that have site config.

if (is_siteadmin()) {
    
    $settings = new admin_settingpage( $componentname, get_string('stippaymentheading', $componentname) );
 
    // Create 
    $ADMIN->add( 'localplugins', $settings );
    
    // Strip Sandbox Payment Settings.
    $settings->add(new admin_setting_heading("local_stripsignup_discount",
        get_string('discount_code', $componentname), get_string('discount_code_desc', $componentname) ));
    
    $settings->add(new admin_setting_configtext('local_stripsignup/discount_code', get_string('discount_code', $componentname),
    '', '', PARAM_TEXT));
    
    $settings->add(new admin_setting_configtext('local_stripsignup/cost', get_string('cost', $componentname),
    '', 0, PARAM_FLOAT, 4));
    
    $settings->add(new admin_setting_configtext('local_stripsignup/percentage', get_string('discount_percentage', $componentname),
    '', 0, PARAM_INT));
    
    $stripecurrencies = enrol_get_plugin('stripepayment')->get_currencies();
    $settings->add(new admin_setting_configselect('local_stripsignup/currency',
    get_string('currency', $componentname), '', 'USD', $stripecurrencies));
    
    // Strip Live Payment Settings
    $settings->add(new admin_setting_heading("local_stripsignup_live",
        get_string('stripesignupconfiguration', $componentname), get_string('stripepayment_desc', $componentname) ));
    
    
    $settings->add(new admin_setting_configtext('local_stripsignup/secretkey', get_string('secretkey', $componentname),
    get_string('secretkey_desc', $componentname), '', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('local_stripsignup/publishablekey',
    get_string('publishablekey', $componentname),
    get_string('publishablekey_desc', $componentname), '', PARAM_TEXT));
    
    // Strip Sandbox Payment Settings.
    $settings->add(new admin_setting_heading("local_stripsignup_sandbox",
        get_string('sandbox_stripesignupconfiguration', $componentname), get_string('sandbox_stripepayment_desc', $componentname) ));
    $settings->add(new admin_setting_configtext('local_stripsignup/sandbox_secretkey', get_string('secretkey', $componentname),
    get_string('secretkey_desc', $componentname), '', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('local_stripsignup/sandbox_publishablekey',
    get_string('publishablekey', $componentname),
    get_string('publishablekey_desc', $componentname), '', PARAM_TEXT));

    
    $settings->add(new admin_setting_configcheckbox('local_stripsignup/sandbox',
    get_string('sandboxlive', $componentname), '', 0));
    
    $ADMIN->add('localplugins', new \admin_category($componentname, get_string('pluginname', $componentname)));
    
}