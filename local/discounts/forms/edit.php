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
 * Moodec pages dynamic Form
 *
 * @package     local_discounts
 * @author      LEADconcept
 * @copyright   2020 LEADconcept Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');
require_once(dirname(__FILE__) . '/../lib.php');

/**
 * Class pages_edit_product_form
 *
 * @copyright   2020 LEADconcept Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class pages_edit_product_form extends moodleform {
    /**
     * @var $_pagedata
     */
    public $_pagedata;

    /**
     * @var $callingpage
     */
    public $callingpage;

    /**
     * pages_edit_product_form constructor.
     * @param mixed $page
     */
    public function __construct($page) {
        if ($page) {
            $this->_pagedata = $page->pagedata;
            $this->callingpage = $page->id;
        }
        parent::__construct();
    }

    /**
     *
     * Set the page data.
     *
     * @param mixed $defaults
     * @return mixed
     */
    public function set_data($defaults) {
        $context = context_system::instance();
        $draftideditor = file_get_submitted_draft_itemid('emailcontent');
        $defaults->emailcontent['text'] = file_prepare_draft_area($draftideditor, $context->id,
            'local_discounts', 'emailcontent', 0, array('subdirs' => true), $defaults->emailcontent['text']);
        $defaults->emailcontent['itemid'] = $draftideditor;
        $defaults->emailcontent['format'] = FORMAT_HTML;
        return parent::set_data($defaults);
    }

    /**
     * Get a list of all pages
     */
    public function definition() {
        global $DB, $PAGE;

        // Get a list of all pages.
        $none = get_string("none", "local_discounts");
        $pages = array(0 => $none);
        $allpages = $DB->get_records('local_discounts', array('deleted' => 0));
        foreach ($allpages as $page) {
            if ($page->id != $this->callingpage) {
                $pages[$page->id] = $page->discount_code;
            }
        }
        $hasstandard = false;
        $layouts = array("standard" => "standard");
        $layoutkeys = array_keys($PAGE->theme->layouts);
        foreach ($layoutkeys as $layoutname) {
            if (strtolower($layoutname) != "standard") {
                $layouts[$layoutname] = $layoutname;
            } else {
                $hasstandard = true;
            }
        }
        if (!$hasstandard) {
            unset($layouts['standard']);
        }

        $mform = $this->_form;

        $mform->addElement(
            'date_selector', 'exp_discount_date',
            get_string(
                'discount_date',
                'local_discounts'
            ), get_string('to')
        );
        $mform->setType('exp_discount_date', PARAM_TEXT);
        $mform->addHelpButton('exp_discount_date', 'exp_discount_date_description', 'local_discounts');

        $mform->addElement('text', 'discount_code', get_string('discount_name', 'local_discounts'));
        $mform->setType('discount_code', PARAM_TEXT);

        $mform->addElement('text', 'discountorder', get_string('discount_order', 'local_discounts'));
        $mform->setType('discountorder', PARAM_INT);
        
        $mform->addElement('text', 'percentage', get_string('discount_percentage', 'local_discounts'));
        $mform->setType('percentage', PARAM_INT);

        $mform->addElement('text', 'accesslevel', get_string('discount_accesslevel', 'local_discounts'));
        $mform->addHelpButton('accesslevel', 'accesslevel_description', 'local_discounts');
        $mform->setType('accesslevel', PARAM_TEXT);

        $context = context_system::instance();
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean' => true, 'context' => $context);

        $mform->addElement('editor', 'emailcontent', get_string('email_content', 'local_discounts'),
            get_string('email_content_description', 'local_discounts'), $editoroptions);
        
        $mform->addElement('text', 'emailto', get_string('emailto_name', 'local_discounts'));
        $mform->setType('emailto', PARAM_TEXT);
        
        $mform->addRule('emailcontent', null, 'required', null, 'client');
        $mform->setType('emailcontent', PARAM_RAW); // XSS is prevented when printing the block contents and serving files.

        $mform->addHelpButton('emailcontent', 'emailcontent_description', 'local_discounts');

//        $mform->addElement('html', $this->build_html_form());

        // FORM BUTTONS.
        $this->add_action_buttons();

        $mform->addElement('hidden', 'id', null);

        $mform->setType('id', PARAM_INT);
    }

    /**
     *
     * Validate the form
     *
     * @param mixed $data
     * @param mixed $files
     * @return mixed
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return $errors;
    }

    /**
     *
     * Build the HTML form elements
     *
     * @return string
     */
    private function build_html_form() {
        global $DB;
        $usertable = $DB->get_record_sql("select * FROM {user} LIMIT 1");
        $records = json_decode($this->_pagedata);

        // PHP 7.2 now gives an error if the item cannot be counted - pre 7.2 it returned 0.
        $limit = intval(@count($records));

        $i = 0;
        $html = '<div class="form-builder row" id="form-builder">' .
            '<h3 style="width:100%"><a href="#" id="showform-builder">'. get_string('formbuilder', 'local_discounts') .'  ' .
            '<span id="showEdit">' . get_string('show', 'local_discounts') .
            '</span> <span id="hideEdit">' . get_string('hide', 'local_discounts') .
            '</span></a></h3><div class="formbuilderform">';
        do {
            $html .= '<div class="formrow row"><div class="col-sm-12 col-md-2 span2"><label>' .
                get_string('label_name', 'local_discounts') .' </label>' .
                '<textarea class="form-control field-name" name="fieldname[]" ' .
                'placeholder="' . get_string('placeholder_fieldname', 'local_discounts') .
                '" style="height:25px;resize:none;overflow:hidden">' .
                (isset($records[$i]) ? $records[$i]->name : '') .
                '</textarea></div>';
            $html .= '<div class="col-sm-12 col-md-2 span2"><label>'.
                get_string('label_placeholder', 'local_discounts') . '</label>' .
                '<textarea type="text" class="form-control default-name" ' .
                'name="defaultvalue[]" style="height:25px;resize:none;overflow:hidden" placeholder="' .
                get_string('placeholder_text', 'local_discounts') . '">' .
                (isset($records[$i]) ? $records[$i]->defaultvalue : '') .
                '</textarea></div>';

            $html .= '<div class="col-sm-12 col-md-2 span2"><label>' .
                get_string('label_relatesto', 'local_discounts') .' </label>' .
                '<select class="form-control field-readsfrom" name="readsfrom[]">' .
                '<option value="">'. get_string('select_nothing', 'local_discounts')  .' </option>';
            $keys = array_keys((array)$usertable);
            foreach ($keys as $key) {
                $html .= '<option ' . ((isset($records[$i]) &&
                        isset($records[$i]->readsfrom) &&
                        $records[$i]->readsfrom == $key) ? 'selected="selected"' : '') . '>' . $key . '</option>';
            }
            $html .= '<option value="fullname" ' . ((isset($records[$i]) &&
                    isset($records[$i]->readsfrom) &&
                    $records[$i]->readsfrom == "fullname") ? 'selected="selected"' : '') . '>' .
                get_string('select_fullname', 'local_discounts') . '</option>';
            $html .= '</select></div>';

            $html .= '<div class="col-sm-12 col-md-2 span2"><label>' .
                get_string('label_required', 'local_discounts') .'</label>' .
                '<select class="form-control field-required" name="fieldrequired[]">' .
                '<option value="Yes" ' . (isset($records[$i]) &&
                $records[$i]->required == 'Yes' ? 'selected="selected"' : '') . '>' .
                get_string('select_yes', 'local_discounts') .'</option>' .
                '<option value="No" ' . (isset($records[$i]) &&
                $records[$i]->required == 'No' ? 'selected="selected"' : '') . '>' .
                get_string('select_no', 'local_discounts').'</option>' .
                '</select></div>';

            $html .= '<div class="col-sm-12 col-md-2 span2"><label>' .
                get_string('type', 'local_discounts') . '</label>' .
                '<select class="form-control field-type" name="fieldtype[]">' .
                '<option value="Text" ' . (isset($records[$i]) &&
                $records[$i]->type == 'Text' ? 'selected="selected"' : '') . ' >' .
                get_string('select_text', 'local_discounts') . '</option>' .
                '<option value="Email" ' . (isset($records[$i]) &&
                $records[$i]->type == 'Email' ? 'selected="selected"' : '') . ' >' .
                get_string('select_email', 'local_discounts') . '</option>' .
                '<option value="Number" ' . (isset($records[$i]) &&
                $records[$i]->type == 'Number' ? 'selected="selected"' : '') . '  >' .
                get_string('select_number', 'local_discounts')  . '</option>' .
                '<option value="Checkbox" ' . (isset($records[$i]) &&
                $records[$i]->type == 'Checkbox' ? 'selected="selected"' : '') . ' >' .
                get_string('select_checkbox', 'local_discounts') . '</option>' .
                '<option value="Text Area"' . (isset($records[$i]) &&
                $records[$i]->type == 'Text Area' ? 'selected="selected"' : '') . ' >' .
                get_string('select_text_area', 'local_discounts') . '</option>' .
                '<option value="Select" ' . (isset($records[$i]) &&
                $records[$i]->type == 'Select' ? 'selected="selected"' : '') . ' >' .
                get_string('select_select', 'local_discounts') . '</option>' .
                '<option value="HTML" ' . (isset($records[$i]) &&
                $records[$i]->type == 'HTML' ? 'selected="selected"' : '') . ' >' .
                get_string('select_html', 'local_discounts') . '</option>' .
                '</select></div>';

            $html .= '<div class="col-sm-12 col-md-2 span2"><label style="width:100%"> &nbsp;</label>' .
                '<input type="button" value="' . get_string('label_add', 'local_discounts') . '" ' .
                'class="form-submit form-addrow btn btn-primary" name="submitbutton" type="button" />' .
                '<input type="button" value="' . get_string('label_remove', 'local_discounts') .'" ' .
                'class="form-submit form-removerow btn btn-danger" name="cancel" type="button" />' .
                '</div>' .
                '</div>';
            $i++;
        } while ($i < $limit);

        $html .= '</div></div>';
        return $html;
    }
}