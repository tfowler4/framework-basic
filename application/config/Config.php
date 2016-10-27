<?php

/**
 * application configuration class
 */
class Config {
    /**
     * constructor
     */
    public function __construct() {
        $this->_loadDb();
    }

    private function _loadDb() {
        Database::init(DB_USER, DB_PASS, DB_NAME, DB_HOST);
    }
}