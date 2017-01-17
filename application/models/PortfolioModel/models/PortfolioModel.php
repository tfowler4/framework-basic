<?php

/**
 * portfolio model
 */
class PortfolioModel extends Model {
    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = 'Portfolio';
    }
}