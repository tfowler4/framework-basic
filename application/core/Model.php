<?php

/**
 * base model class
 */
abstract class AbstractModel {
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