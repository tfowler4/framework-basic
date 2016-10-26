<?php

/**
 * Error model
 */
class ErrorModel extends Model {
    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = '404 Woops!';
    }
}