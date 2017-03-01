<?php

/**
 * login model
 */
class LoginModel extends AbstractModel {
    const MODEL_NAME = 'Login';

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