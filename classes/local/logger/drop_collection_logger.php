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
use DateTime;
use dml_exception;
use moodle_database;
use stdClass;

/**
 * Course user event collection logger.
 *
 * @package    block_xp
 * @copyright  2022 Branch Up Pty Ltd
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class drop_collection_logger implements collection_logger, drop_logged {

    /** The table name. */
    const TABLE = 'block_xp_log';

    const SIGNATURE = 'block_xp\drop_collected';

    /** @var int The course ID. */
    protected $courseid;
    /** @var moodle_database The DB. */
    protected $db;

    /**
     * Constructor.
     *
     * @param moodle_database $db The DB.
     * @param int $courseid The course ID.
     */
    public function __construct(moodle_database $db, $courseid) {
        $this->db = $db;
        $this->courseid = $courseid;
    }

    /**
     * Delete logs older than a certain date.
     *
     * @param \DateTime $dt The date.
     * @return void
     */
    public function delete_older_than(DateTime $dt) {
        $this->db->delete_records_select(
            static::TABLE,
            'courseid = :courseid AND time < :time AND eventname = :signature',
            [
                'courseid' => $this->courseid,
                'time' => $dt->getTimestamp(),
                'signature' => self::SIGNATURE
            ]
        );
    }

    /**
     * Log a thing.
     *
     * @param int $id The target.
     * @param int $points The points.
     * @param string $signature A signature.
     * @param DateTime|null $time When that happened.
     * @return void
     */
    public function log($id, $points, $signature, DateTime $time = null) {
        $time = $time ? $time : new DateTime();
        $record = new stdClass();
        $record->courseid = $this->courseid;
        $record->userid = $id;
        $record->eventname = $signature;
        $record->xp = $points;
        $record->time = $time->getTimestamp();
        try {
            $this->db->insert_record(static::TABLE, $record);
        } catch (dml_exception $e) {
            // Ignore, but please the linter.
            $pleaselinter = true;
        }
    }

    /**
     * Purge drop logs.
     *
     * @return void
     */
    public function reset() {
        $this->db->delete_records_select(
            static::TABLE,
            'courseid = :courseid AND signature = :signature',
            [
                'courseid' => $this->courseid,
                'signature' => self::SIGNATURE,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function is_logged($userid, drop $drop) {
        $record = $this->db->get_record(self::TABLE, [
            'userid' => $userid,
            'eventname' => $this->get_custom_generated_signature($drop),
            'courseid' => $this->courseid
        ]);

        return $record ?? false;
    }

    /**
     * @inheritDoc
     */
    public function log_drop($userid, drop $drop) {
        $this->log($userid, $drop->get_xp(), $this->get_custom_generated_signature($drop));
    }

    /**
     * Get a custom generated signature to be used in the logs
     *
     * @param drop $drop
     * @return string
     */
    protected function get_custom_generated_signature(drop $drop) {
        return self::SIGNATURE . "\\{$drop->get_id()}";
    }
}
