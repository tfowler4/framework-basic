<?php

/**
 * Admin model
 */
class AdminModel extends Model {
    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = 'Administration';
    }
}