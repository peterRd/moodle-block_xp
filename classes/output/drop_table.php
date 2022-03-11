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
 * Block XP log table.
 *
 * @package    block_xp
 * @copyright  2022 Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_xp\output;

require_once($CFG->libdir . '/tablelib.php');

use stdClass;
use table_sql;
use block_xp\local\course_world;

/**
 * Block XP log table class.
 *
 * @package    block_xp
 * @copyright  2022 Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class drop_table extends table_sql {
    /** @var course_world The world. */
    protected $world;
    /** @var renderer_base The renderer. */
    protected $renderer;

    /**
     * Constructor.
     *
     * @param course_world $world The world.
     * @param int $groupid The group ID.
     */
    public function __construct(course_world $world) {
        parent::__construct('block_xp_log');
        $this->world = $world;
        $this->renderer = \block_xp\di::get('renderer');
        $courseid = $world->get_courseid();

        $headers = [
            'name' => get_string('name', 'block_xp'),
            'points' => get_string('xp', 'block_xp'),
            'uniqueid' => get_string('uniqueid', 'block_xp'),
        ];

        $this->define_columns(array_keys($headers));
        $this->define_headers(array_values($headers));

        // Define SQL.
        $this->sql = new stdClass();
        $this->sql->fields = 'x.*';
        $this->sql->from = '{block_xp_drops} x';
        $this->sql->where = 'x.courseid = :courseid';
        $this->sql->params = ['courseid' => $courseid];
    }

    /**
     * XP.
     *
     * @param stdClass $row The row.
     * @return string
     */
    protected function col_points($row) {
        return $this->renderer->xp($row->points);
    }

    /**
     * Override to rephrase.
     *
     * @return void
     */
    public function print_nothing_to_display() {
        $message = get_string('nothingtodisplay', 'core');

        echo \html_writer::div(
            \block_xp\di::get('renderer')->notification_without_close($message, 'info'),
            '',
            ['style' => 'margin: 1em 0']
        );
    }
}
