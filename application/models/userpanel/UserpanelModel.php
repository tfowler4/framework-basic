<?php

/**
 * userpanel model
 */
class UserpanelModel extends AbstractModel {
    const MODEL_NAME = 'Userpanel';

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

    /**
     * get user details from session data
     *
     * @return obj [ user object if it exists ]
     */
    public function loadUserFromSession() {
        $user = NULL;

        if ( SessionData::get('login') === TRUE ) {
            $user = new User(SessionData::get('user'));
        }

        return $user;
    }
}