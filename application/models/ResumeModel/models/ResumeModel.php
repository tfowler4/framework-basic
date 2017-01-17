<?php

/**
 * resume model
 */
class ResumeModel extends Model {
    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = 'Resume';
    }
}