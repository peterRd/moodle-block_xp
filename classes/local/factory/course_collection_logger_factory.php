<?php

namespace block_xp\local\factory;

use block_xp\local\course_world;
use block_xp\local\logger\course_user_event_collection_logger;
use block_xp\local\logger\reason_collection_logger;

class course_collection_logger_factory implements course_reason_collection_logger_factory, course_reason_occurance_logger_factory {
    protected $logger = [];

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * @param $courseid
     */
    protected function get_combined_logger($courseid) {
        if (isset($this->logger[$courseid])) {
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