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
 * user signup page.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_once($CFG->libdir . '/authlib.php');
require_once('lib.php');
require_once('Stripe/init.php');
use \Stripe\Stripe;
use \Stripe\Customer;
use \Stripe\ApiOperations\Create;
use \Stripe\Charge;

if (!$authplugin = signup_is_enabled()) {
    print_error('notlocalisederrormessage', 'error', '', 'Sorry, you may not use this page.');
}

$PAGE->set_url('/login/signup.php');
$PAGE->set_context(context_system::instance());

// If wantsurl is empty or /login/signup.php, override wanted URL.
// We do not want to end up here again if user clicks "Login".
if (empty($SESSION->wantsurl)) {
    $SESSION->wantsurl = $CFG->wwwroot . '/';
} else {
    $wantsurl = new moodle_url($SESSION->wantsurl);
    if ($PAGE->url->compare($wantsurl, URL_MATCH_BASE)) {
        $SESSION->wantsurl = $CFG->wwwroot . '/';
    }
}

if (isloggedin() and !isguestuser()) {
    // Prevent signing up when already logged in.
    echo $OUTPUT->header();
    echo $OUTPUT->box_start();
    $logout = new single_button(new moodle_url('/login/logout.php',
        array('sesskey' => sesskey(), 'loginpage' => 1)), get_string('logout'), 'post');
    $continue = new single_button(new moodle_url('/'), get_string('cancel'), 'get');
    echo $OUTPUT->confirm(get_string('cannotsignup', 'error', fullname($USER)), $logout, $continue);
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer();
    exit;
}

// If verification of age and location (digital minor check) is enabled.
if (\core_auth\digital_consent::is_age_digital_consent_verification_enabled()) {
    $cache = cache::make('core', 'presignup');
    $isminor = $cache->get('isminor');
    if ($isminor === false) {
        // The verification of age and location (minor) has not been done.
        redirect(new moodle_url('/login/verify_age_location.php'));
    } else if ($isminor === 'yes') {
        // The user that attempts to sign up is a digital minor.
        redirect(new moodle_url('/login/digital_minor.php'));
    }
}

if(count($_POST) > 0){
    global $DB;
    $user_email = $DB->get_record('user', array('email' =>  $_POST['email']));
    $user_username = $DB->get_record('user', array('username' =>  $_POST['username']));
    if (empty($user_email) && empty($user_username)) {
        $customerDetailsAry = array(
            'email' => $_POST['email'],
            'source' => $_POST['token']
        );
        $sandbox = get_config('local_stripsignup', 'sandbox');
        if($sandbox == 1){
            \Stripe\Stripe::setApiKey(get_config('local_stripsignup','sandbox_secretkey'));
        }else{
            \Stripe\Stripe::setApiKey(get_config('local_stripsignup','secretkey'));
        }
        $customer = new Customer();

        $customerDetails = $customer->create($customerDetailsAry);
        $data = $DB->get_record_sql("SELECT * FROM {local_discounts} WHERE discount_code=? LIMIT 1", array($_POST['cc_discount_code']));
        $amount = get_config('local_stripsignup', 'cost');
        if(!empty($data)){
            $percentage = intval($data->percentage);
            if(round($percentage) == 100){
                $amount = 0;
            }else{
                $percentage = $percentage/100;
                $discount_amout = $amount*$percentage;
                $amount = $amount-$discount_amout;
            }
            $send_email_to = explode(',', $data->emailto);
            $send_emails = array();
            if(count($send_email_to) > 0){
                foreach ($send_email_to as $email){
                    if($email != $_POST['email']){
                        $send_emails[] = $email;
                    }
                }
            }
            $options = new stdClass();
            $options->id = $data->id;
            $options->emailto = implode(',', $send_emails);
            $DB->update_record('local_discounts', $options);
        }
        
        $cardDetailsAry = array(
            'customer' => $customerDetails->id,
            'amount' => $amount*100,
            'currency' => 'usd',
            'description' => 'User Subscription on eodo',
        );
        $charge = new Charge();
        $result = $charge->create($cardDetailsAry);
        $strip_result = $result->jsonSerialize();
        if ($strip_result['status'] == 'succeeded') {
            $data = new stdClass();
            if($_POST['cc_discount_code']){
                $data->discount_code = $_POST['cc_discount_code'];
            }
            $data->price = $amount;
            $data->user_email = $_POST['email'];
            $data->username = $_POST['username'];
            $data->date_created  = date('Y-m-d h:i:s');
            $DB->insert_record('local_subscribed_user', $data);
        }else{
            redirect(new moodle_url('/login/signup.php'));
        }
    }
}
// Plugins can create pre sign up requests.
// Can be used to force additional actions before sign up such as acceptance of policies, validations, etc.
core_login_pre_signup_requests();

$mform_signup = $authplugin->signup_form();

if ($mform_signup->is_cancelled()) {
    redirect(get_login_url());

} else if ($user = $mform_signup->get_data()) {
    // Add missing required fields.
    $user = signup_setup_new_user($user);
    // Plugins can perform post sign up actions once data has been validated.
    core_login_post_signup_requests($user);
    
    $authplugin->user_signup($user, true); // prints notice and link to login/index.php
    exit; //never reached
}

$newaccount = get_string('newaccount');
$login      = get_string('login');

$PAGE->navbar->add($login);
$PAGE->navbar->add($newaccount);

$PAGE->set_pagelayout('login');
$PAGE->set_title($newaccount);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

if ($mform_signup instanceof renderable) {
    // Try and use the renderer from the auth plugin if it exists.
    try {
        $renderer = $PAGE->get_renderer('auth_' . $authplugin->authtype);
    } catch (coding_exception $ce) {
        // Fall back on the general renderer.
        $renderer = $OUTPUT;
    }
    echo $renderer->render($mform_signup);
} else {
    // Fall back for auth plugins not using renderables.
    $mform_signup->display();
}
echo $OUTPUT->footer();
