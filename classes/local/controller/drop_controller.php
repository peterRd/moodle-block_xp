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
 * Drop controller.
 *
 * @package    block_xp
 * @copyright  2022 Peter Dias
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_xp\local\controller;

use flexible_table;

class drop_controller extends page_controller {
    /** @var string The route name. */
    protected $routename = 'drops';
    /** @var bool Whether manage permissions ar required. */
    protected $requiremanage = true;

    protected function define_optional_params() {
        return [
            ['edit', false, PARAM_BOOL, true]
        ];
    }
    /**
     * @inheritDoc
     */
    protected function page_content() {
        echo $this->get_renderer()->heading(get_string('preview'), 3);
        if ($this->get_param('edit')) {
            // We are editing/adding a new drop
            $this->get_form()->display();
        } else {
            echo $this->get_table()->out();
        }
    }

    /**
     * @return \lang_string|string
     */
    protected function get_page_html_head_title(): string {
        return get_string('drops', 'block_xp');
    }

    /**
     * @return \lang_string|string
     */
    protected function get_page_heading(): string {
        return get_string('drops', 'block_xp');
    }

    protected function get_table(): flexible_table {
        // TODO: New flex table in output
        return new flexible_table();
    }

    protected function get_form(): \moodleform {
        // TODO: New flex form in classes/form
        return new \restore_moodleform();
    }
}