<?php

/**
 * userpanel model
 */
class UserpanelModel extends Model {
    public $user;
    public $loggedIn = FALSE;

    const MODEL_NAME = 'Userpanel';

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

    public function loadUserFromSession() {
        if ( !empty(SessionData::get('user')) ) {
            $this->user = new User(SessionData::get('user'));
            $this->loggedIn = TRUE;
        }
    }
}