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

namespace block_xp\local\controller;

use block_xp\form\drop;
use block_xp\output\drop_table;

/**
 * Drop controller.
 *
 * @package    block_xp
 * @copyright  2022 Branch Up Pty Ltd
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class drops_controller extends page_controller {
    /** @var string The route name. */
    protected $routename = 'drops';
    /** @var bool Whether manage permissions ar required. */
    protected $requiremanage = true;
    /** @var moodleform The form. */
    private $form;
    /** @var drop_repository $droprepo The drop repository */
    protected $droprepo;

    /**
     * @inheritDoc
     */
    protected function define_optional_params() {
        return [
            ['dropid', null, PARAM_INT],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function page_content() {
        // We are handling a form display.
        if ($this->get_param('dropid') !== null) {
            $form = $this->get_form($this->get_param('dropid'));
            if ($data = $form->get_data()) {
                // We are editing/adding a new drop.
                $this->save_drop($data);
            } else if (!$form->is_cancelled()) {
                echo $form->display();
                return;
            }
        }

        $output = $this->get_renderer();
        $url = $this->pageurl;
        $url->param('dropid', 0);

        echo $output->action_link($url, get_string('adddrop', 'block_xp'), null, ['class' => 'btn btn-primary']);
        echo $this->get_table()->out(10, true);
    }

    /**
     * Update/Create a drop.
     *
     * @param \stdClass $data The drop data to be persisted.
     */
    protected function save_drop($data) {
        $db = \block_xp\di::get('db');
        $secret = substr(bin2hex(random_bytes(128)), 0, 7);
        $data->courseid = $this->world->get_courseid();
        if ($data->dropid) {
            $data->id = $data->dropid;
            $db->update_record('block_xp_drops', $data);
        } else {
            $data->secret = $secret;
            $db->insert_record('block_xp_drops', $data);
        }
    }

    /**
     * @inheritDoc
     */
    protected function get_page_html_head_title() {
        return get_string('drops', 'block_xp');
    }

    /**
     * @inheritDoc
     */
    protected function get_page_heading() {
        return get_string('drops', 'block_xp');
    }

    /**
     * Get the drop table.
     *
     * @return \flexible_table
     */
    protected function get_table() {
        $table = new drop_table($this->world);
        $table->define_baseurl($this->pageurl);
        return $table;
    }

    /**
     * Get the drop repository
     *
     * @return drop_repository
     */
    protected function get_drop_repository() {
        if (!$this->droprepo) {
            $this->droprepo = di::get('drop_repository_factory')->get_repository($this->world->get_courseid());
        }

        return $this->droprepo;
    }

    /**
     * Get the drop form.
     *
     * @param int $id
     * @return \moodleform
     */
    protected function get_form($id = 0) {
        if (!$this->form) {
            $this->form = new drop($this->pageurl->out(false));
        }

        // Initialise the form with some basic information.
        if ($id) {
            $droprepo = $this->get_drop_repository();
            $drop = $droprepo->get_by_id($id);
            if ($drop) {
                $this->form->set_data([
                    'dropid' => $drop->get_id(),
                    'name' => $drop->get_name(),
                    'points' => $drop->get_xp(),
                ]);
            }
        }

        return $this->form;
    }
}
