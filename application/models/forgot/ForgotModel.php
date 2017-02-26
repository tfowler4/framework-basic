<?php

/**
 * forgot model
 */
class ForgotModel extends AbstractModel {
    public $token;

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

        if ( !empty($params[0]) ) {
            $this->token = $params[0];
        }
    }

    /**
     * validate the supplied token with the token in database
     *
     * @return boolean [ if the token is found match in the database ]
     */
    public function validateToken() {
        $isTokenValid = FALSE;

        if ( $this->_checkTokenInDb() == TRUE ) {
            $isTokenValid = TRUE;
        } else {
            SessionData::set('message', array('type' => 'danger', 'title' => 'Error', 'message' => 'Invalid token!!'));
        }

        return $isTokenValid;
    }

    /**
     * check if token exists in database
     *
     * @return boolean [ response from database query ]
     */
    private function _checkTokenInDb() {
        $tokenFound = FALSE;

        $query = sprintf(
            "SELECT
                token,
                token_expire_time
            FROM
               user_table
            WHERE
                token = '%s'
            AND
                token_expire_time >= NOW()
                ",
            $this->token
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $tokenFound = TRUE;
            break;
        }

       return $tokenFound;
    }
}