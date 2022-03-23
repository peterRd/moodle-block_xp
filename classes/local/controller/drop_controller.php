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
        // We are handling a form display
        if ($this->get_param('edit') !== null) {
            $form = $this->get_form($this->get_param('edit'));
            if ($form->is_submitted()) {
                // We are editing/adding a new drop
                $this->update_drop($form->get_data());
            } else if ($form->is_cancelled()) {
                // TODO: Update pagesize.
                echo $this->get_table()->out(10, true);
            } else {
                echo $form->display();
            }
        } else {
            // TODO: Update pagesize.
            $output = $this->get_renderer();
            $nexturl = $this->urlresolver->reverse($this->get_route_name(), ['courseid' => $this->world->get_courseid()]);
            $nexturl->param('edit', 0);

            echo $output->action_link($nexturl, 'Add drop', null, ['class' => 'btn btn-primary']);
            echo $this->get_table()->out(10, true);
        }
    }

    protected function update_drop($data) {
        return $this->world->create_drop($data->edit, $data->name, $data->points);
    }

    /**
     * @return \lang_string|string
     */
    protected function get_page_html_head_title() {
        return get_string('drops', 'block_xp');
    }

    /**
     * @return \lang_string|string
     */
    protected function get_page_heading() {
        return get_string('drops', 'block_xp');
    }

    /**
     * @return \flexible_table
     */
    protected function get_table() {
        $table = new drop_table($this->world);
        $table->define_baseurl($this->pageurl->out(false));
        return $table;
    }

    /**
     * @param int $id
     * @return \moodleform
     */
    protected function get_form(int $id = 0) {
        if (!$this->form) {
            return new drop($this->pageurl->out(false), ['id' => $this->get_param('edit')]);
        }

        return $this->form;
    }
}