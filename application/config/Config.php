<?php

class Config {
    /**
     * constructor
     */
    public function __construct() {
        $this->_loadDb();
    }

    protected function _loadDb() {
        require 'Database.php';

        Database::init('root', '', 'framework_test', 'localhost');
    }
}