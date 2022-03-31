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

namespace block_xp\local\factory;

use block_xp\local\repository\course_drop_repository;
use moodle_database;

/**
 * Drop repository factory
 *
 * @package    block_xp
 * @copyright  2022 Branch Up Pty Ltd
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class default_drop_repository_factory implements drop_repository_factory {
    /** @var moodle_database The DB. */
    protected $db;
    /** @var course_world[] World cache. */
    protected $worlds = [];

    /**
     * Constructor.
     *
     * @param moodle_database $db The DB.
     */
    public function __construct(moodle_database $db) {
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function get_repository($courseid = 0) {
        if (!isset($this->worlds[$courseid])) {
            $this->worlds[$courseid] = new course_drop_repository($this->db, $courseid);
        }

        return $this->worlds[$courseid];
    }
}
