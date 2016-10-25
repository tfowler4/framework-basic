<?php

class Config {
    /**
     * constructor
     */
    public function __construct() {
        $this->_loadDb();
    }

    protected function _loadDb() {
        Database::init('root', '', 'framework_test', 'localhost');
    }
}