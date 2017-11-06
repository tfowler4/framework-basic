<?php

/**
 * base model class
 */
abstract class AbstractModel {
    protected $_dbh;

    public $forms;

    public function __construct($dbh) {
        $this->_dbh = $dbh;
    }
}