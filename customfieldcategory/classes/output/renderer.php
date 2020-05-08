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
 * Renderer.
 *
 * @package   core_customfieldcategory
 * @copyright 2018 David Matamoros <davidmc@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_customfieldcategory\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

/**
 * Renderer class.
 *
 * @package   core_customfieldcategory
 * @copyright 2018 David Matamoros <davidmc@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Render custom field management interface.
     *
     * @param \core_customfieldcategory\output\management $list
     * @return string HTML
     */
    protected function render_management(\core_customfieldcategory\output\management $list) {
        $context = $list->export_for_template($this);

        return $this->render_from_template('core_customfieldcategory/list', $context);
    }

    /**
     * Render single custom field value
     *
     * @param \core_customfieldcategory\output\field_data $field
     * @return string HTML
     */
    protected function render_field_data(\core_customfieldcategory\output\field_data $field) {
        $context = $field->export_for_template($this);
        return $this->render_from_template('core_customfieldcategory/field_data', $context);
    }
}