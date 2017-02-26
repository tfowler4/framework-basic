<?php

/**
 * portfolio model
 */
class PortfolioModel extends AbstractModel {
    const MODEL_NAME = 'Portfolio';

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }
}