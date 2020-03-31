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

defined('MOODLE_INTERNAL') || die;
//require_once($CFG->dirroot.'/local/iomad/lib/company.php');

/**
 * Event handler for 'user_created'
 * For 'email' authentication (only) add this user
 * to the defined role and company.
 */
function local_registration_fees_user_created($user) {
    global $CFG, $DB;

    // the plugin needs to be enabled
    if (!$CFG->local_registration_fees_enable) {
        return true;
    }

    // If not 'email' auth then we are not interested
    if (!in_array($user->auth, explode(',', $CFG->local_registration_fees_auth))) {
        return true;
    }

    // Get context
    $context = context_system::instance();

    // Check if we have a domain already for this users email address.
    list($dump, $emaildomain) = explode('@', $user->email); 
    if ($domaininfo = $DB->get_record_sql("SELECT * FROM {company_domains} WHERE " . $DB->sql_compare_text('domain') . " = '" . $DB->sql_compare_text($emaildomain)."'")) {
        // Get company.
        $company = new company($domaininfo->companyid);

        // assign the user to the company.
        $company->assign_user_to_company($user->id);
    } else if (!empty($CFG->local_registration_fees_company)) {
        // Do we have a company to assign?
        // Get company.
        $company = new company($CFG->local_registration_fees_company);

        // assign the user to the company.
        $company->assign_user_to_company($user->id);
    }
    
    // Do we have a role to assign?
    if (!empty($CFG->local_registration_fees_role)) {
        // Get role
        if ($role = $DB->get_record('role', array('id' => $CFG->local_registration_fees_role), '*', MUST_EXIST)) {

            // assign the user to the role
            role_assign($role->id, $user->id, $context->id);
        }
    }

    return true;
}

function get_currencies() {
        // See https://www.stripe.com/cgi-bin/webscr?cmd=p/sell/mc/mc_intro-outside,
        // 3-character ISO-4217: https://cms.stripe.com/us/cgi-bin/?cmd=
        // _render-content&content_ID=developer/e_howto_api_currency_codes.
        $codes = array(
            'AUD', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'ILS', 'JPY',
            'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RUB', 'SEK', 'SGD', 'THB', 'TRY', 'TWD', 'USD');
        $currencies = array();
        foreach ($codes as $c) {
            $currencies[$c] = new lang_string($c, 'core_currencies');
        }

        return $currencies;
    }
