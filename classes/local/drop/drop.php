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

namespace block_xp\local\drop;
defined('MOODLE_INTERNAL') || die();

/**
 * Drop interface.
 *
 * @package    block_xp
 * @copyright  2022 Branch Up Pty Ltd
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface drop {

    /**
     * Get the points for the drop.
     *
     * @return int
     */
    public function get_id();

    /**
     * Get the points for the drop.
     *
     * @return int
     */
    public function get_xp();

    /**
     * Get the secret for the drop.
     *
     * @return string
     */
    public function get_secret();

    /**
     * Get the name of the drop.
     *
     * @return string
     */
    public function get_name();

    /**
     * Get the courseid for the drop.
     *
     * @return int
     */
    public function get_courseid();
}
