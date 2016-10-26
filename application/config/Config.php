<?php

class Config {
    /**
     * constructor
     */
    public function __construct() {
        $this->_loadDb();
    }

    protected function _loadDb() {
        Database::init(DB_USER, DB_PASS, DB_NAME, DB_HOST);
    }
}