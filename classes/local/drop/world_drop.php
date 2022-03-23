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

/**
 * A drop within a particular world.
 *
 * @package    block_xp
 * @copyright  2017 Frédéric Massart
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class world_drop implements drop {
    /** @var int $id The id of the drop. */
    protected $id;
    /** @var int $xp The xp associated with this drop */
    protected $xp;
    /** @var string $secret The generated secret for the drop */
    protected $secret;
    /** @var int $courseid The world this belongs to */
    protected $courseid;

    public function __construct($id, $xp, $secret, $courseid) {
        $this->id = $id;
        $this->xp = $xp;
        $this->courseid = $courseid;
        $this->secret = $secret;
    }

    /**
     * Get the id of the drop
     *
     * @return int
     */
    public function get_id() {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function get_xp() {
        return $this->xp;
    }

    /**
     * @inheritDoc
     */
    public function get_secret() {
        return $this->secret;
    }

    /**
     * @inheritDoc
     */
    public function get_courseid() {
        return $this->courseid;
    }
}