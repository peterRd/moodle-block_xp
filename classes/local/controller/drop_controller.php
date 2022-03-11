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

use block_xp\form\drop;
use block_xp\output\drop_table;

class drop_controller extends page_controller {
    /** @var string The route name. */
    protected $routename = 'drops';
    /** @var bool Whether manage permissions ar required. */
    protected $requiremanage = true;
    /** @var moodleform The form. */
    private $form;

    protected function define_optional_params() {
        return [
            ['edit', null, PARAM_INT, false],
        ];
    }
    /**
     * @inheritDoc
     */
    protected function page_content() {
        if ($this->get_param('edit') !== null) {
            $form = $this->get_form($this->get_param('edit'));
            if ($form->is_submitted()) {
                // We are editing/adding a new drop

            } else if ($form->is_cancelled()) {
                // TODO: Update pagesize.
                echo $this->get_table()->out(10, true);
            } else {
                echo $form->display();
            }
        } else {
            // TODO: Update pagesize.
            echo $this->get_table()->out(10, true);
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

    protected function get_table(): \flexible_table {
        $table = new drop_table($this->world);
        $table->define_baseurl($this->pageurl->out(false));
        return $table;
    }

    protected function get_form(int $id = 0): \moodleform {
        if (!$this->form) {
            return new drop($this->pageurl->out(false), ['id' => $this->get_param('edit')]);
        }

        return $this->form;
    }
}