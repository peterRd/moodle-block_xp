<?php

namespace block_xp\local\factory;

use block_xp\local\course_world;
use block_xp\local\logger\course_user_event_collection_logger;

/**
 * Course collection logger. Should return the respective type of logger.
 *
 * @package    block_xp
 * @copyright  2022 Branch Up Pty Ltd
 * @author     Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_collection_logger_factory implements course_reason_collection_logger_factory, course_reason_occurance_logger_factory {
    /** @var array reason_collection_logger[] $logger A list of loggers per world. */
    protected $logger = [];
    /** @var \moodle_database $db The database objet. */
    protected $db;

    public function __construct(\moodle_database $db) {
        $this->db = $db;
    }

    /**
     * Get the combined collection/occurance logger.
     *
     * @param int $courseid
     */
    protected function get_combined_logger($courseid) {
        if (!isset($this->logger[$courseid])) {
            $this->logger[$courseid] = new course_user_event_collection_logger($this->db, $courseid);
        }

        return $this->logger[$courseid];
    }

    /**
     * @inheritDoc
     */
    public function get_collection_logger(course_world $world) {
        return $this->get_combined_logger($world->get_courseid());
    }

    /**
     * @inheritDoc
     */
    public function get_occurance_indicator(course_world $world) {
        return $this->get_combined_logger($world->get_courseid());
    }
}
