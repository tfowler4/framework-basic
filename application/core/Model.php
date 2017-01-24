<?php

/**
 * base model class
 */
abstract class Model {
    protected $_dbh;

    public $forms;

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        $this->_dbh = $dbh;
    }
}