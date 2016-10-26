<?php

/**
 * example model
 */
class ExampleModel extends Model {
    public $content = array();

    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = 'Example';

        new SubExampleModel($module, $params);
    }
}