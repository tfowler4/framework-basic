<?php

/**
 * error model
 */
class ErrorModel extends AbstractModel {
    const MODEL_NAME = 'Error';

    /**
     * constructor
     *
     * @param obj   $dbh    [ database handler ]
     * @param array $params [ parameters sent by the url ]
     *
     * @return void
     */
    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }
}