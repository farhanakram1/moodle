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
 * Local Discount Codes 
 *
 * This module allows custom pages and forms in moodle
 *
 * @package    local_discounts
 * @copyright  2017 LEADconcept, www.learningworks.co.nz
 * @author     LEADconcept
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Settings discount code strings.
$string['pluginname'] = 'Discount Codes ';
$string['pluginsettings'] = 'Settings';
$string['pluginsettings_managediscountcode'] = 'Manage discount codes';

// Other plugin strings.
$string['discount_codes_settings'] = 'Discount Codes  Settings';
$string['customdiscount_title'] = 'Manage Discount Codes ';
$string['discount_code_setup_title'] = 'Discount Code Management';
$string['discount_code_setup_heading'] = 'Discount Code heading';
$string['email_content_description'] = 'Add content for the Promotion Email';
$string['email_content'] = 'Promotion Email';
$string['discount_name'] = 'Discount Code';
$string['discount_order'] = 'Discount Code Order';
$string['discount_percentage'] = 'Discount Percentage';
$string['discount_date'] = 'Expire Discount In';
$string['discount_date_help'] = 'Add number of days in which discount will be expire';
$string['discount_parent'] = 'Discount Code Parent';
$string['menu_name'] = 'Discount Code URL';
$string['discount_onmenu'] = 'Display on menu';
$string['cleanurl_enabled'] = 'Enable Smart URLS';
$string['cleanurl_enabled_description'] = 'Enable Links to use a clean URL';
$string['discount_codes_settings'] = 'Discount Codes  Settings';
$string['emailto_name'] = 'Send Email To';
$string['emailto_description'] = 'Add comma seperated email addresses to send to many users';
$string['emailto_description_help'] = 'Add comma seperated email addresses to send to many users';
$string['subject_line_name'] = 'Subject Line';
$string['subject_line_description'] = 'Add email subject you can use {percentage} in the promotional email subject';
$string['subject_line_description_help'] = 'Add email subject you can use {percentage} in the promotional email subject';
$string['form_field_id'] = "ID";
$string['form_field_date'] = "Date";
$string['form_field_content'] = "Form Details";
$string['discount_accesslevel'] = "Capability required";
$string['noaccess'] = 'You do not have rights to view this discount code';
$string['emailcontent_description_help'] = "This area is the promotion email sent to users added in 'Send Email To' section. You can use {discount_code},{discounted_price},{original_price} and {percentage} to include in the promotion email.<br/><b>{discount_code}: </b> Discount Code<br/><b>{discounted_price}: </b> Discount Price<br/><b>{original_price}: </b> Original Price<br/><b>{percentage}: </b> Percentage";
$string['exp_discount_date_description_help'] = 'Select the expiry date till that you want to give promotion';
$string['accesslevel_description_help'] = 'Enter in the capability string, you can comma seperate to add multiple capabilites<br/>If you want everyone BUT that capability to view - put an ! mark before it<br/>Example: mod/folder:managefiles,!mod/quiz:grade';
$string['accesslevel_description'] = "Access Level";
$string['exp_discount_date_description'] = "Discount Code Expiry Date";
$string['emailcontent_description'] = "Discount Code Content";
$string['email_headers_description'] = 'Enter the Email headers to send - use {html} to send html messages. use {From} to set a from address and use {Reply-to} to enable a reply to header';
$string['email_headers'] = 'Custom headers for PHP mail';
$string['user_copy'] = "Copy message to person";
$string['user_copy_description'] = "Select if the person filling in the form is to receive a message";
$string['message_copy'] = "Message to go to user";
$string['message_copy_description'] = "Enter {field name} from the form to appear in the message. Use {table} to place the all form fields";
$string['enable_limit'] = "Limit emails to one per session";
$string['enable_limit_description'] = "This stops users sending multiple emails";
$string['cannnot_send'] = "Sorry - You have already sent us an email - please give us time to process it";
$string['discount_loggedin'] = "Force users to login";
$string['adddiscountcodes'] = "Add discount codes";
$string['discountcodes:adddiscountcodes'] = "Add Discount Codes ";
$string['formbuilder'] = "Form Builder";
$string['show'] = 'Show';
$string['hide'] = 'Hide';
$string['placeholder_fieldname'] = "Field Name";
$string['placeholder_text'] = "Placeholder text";
$string['label_name'] = "Name";
$string['label_placeholder'] = "Placeholder";
$string['label_relatesto'] = "Relates to";
$string['label_required'] = "Required";
$string['label_remove'] = "Remove";
$string['label_add'] = "Add";
$string['select_nothing'] = "Nothing";
$string['select_yes'] = "Yes";
$string['select_no'] = "No";
$string['select_text'] = "Text";
$string['select_email'] = "Email";
$string['select_number'] = "Number";
$string['select_checkbox'] = "Checkbox";
$string['select_text_area'] = "Text Area";
$string['select_select'] = "Select";
$string['select_html'] = "HTML";
$string['select_fullname'] = "fullname";
$string['view'] = "View";
$string['edit'] = "Edit";
$string['delete'] = "Delete";
$string['privacy:metadata'] = 'The discount codes local plugin does not store any personal data';
$string['discountcodeplugin'] = 'Discount Codes';
$string['adddiscountcode'] = "Add discount code";
$string['pdfmanual'] = "PDF Manual";
$string['submit'] = "Submit";
$string['none'] = "None";
$string['pleaseselect'] = 'Please Select an option';
$string['yes'] = "Yes";
$string['no'] = "No";
$string['backtolist'] = "Back to discount codes list";
$string['page'] = 'Discount Code';
$string['form'] = 'Form';
$string['type'] = 'Type';
$string['send_email_label'] = 'Send Email';
$string['send_email_descriotion'] = 'Send email to users now';
$string['send_email_descriotion_help'] = 'Send email to users now';