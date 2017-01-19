<?php

/**
 * base model class
 */
abstract class Model {
    protected $_dbh;
    public $forms;

    /**
     * constructor
     */
    public function __construct($dbh) {
        $this->_dbh = $dbh;
    }
}