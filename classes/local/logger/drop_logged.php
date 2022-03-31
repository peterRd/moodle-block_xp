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

namespace block_xp\local\logger;

use block_xp\local\drop\drop;

/**
 * Collection logger.
 *
 * @package    block_xp
 * @copyright  2022 Branch Up Pty Ltd
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface drop_logged {
    /**
     * Finds whether a drop has been logged
     *
     * @return bool
     */
    public function is_logged($userid, drop $drop);

    /**
     * Make a drop specific log entry.
     *
     * @param $userid
     * @param drop $drop
     * @return void
     */
    public function log_drop($userid, drop $drop);
}
