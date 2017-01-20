<?php

/**
 * sub example model
 */
class SubExampleModel extends Model {
    public $content = array();

    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = 'Sub Example';
    }
}