<?php

/**
 * resume model
 */
class ResumeModel extends Model {
    const MODEL_NAME = 'Resume';

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