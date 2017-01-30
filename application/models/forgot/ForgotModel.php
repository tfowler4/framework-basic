<?php

/**
 * forgot model
 */
class ForgotModel extends Model {
    const MODEL_NAME = 'Home';

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