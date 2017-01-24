<?php

/**
 * login form
 */
class LoginForm extends Form {
    public $form;
    public $username;
    public $password;

    const FORM_NAME       = 'login';
    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully logged in!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'Invalid Username/Password combo!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('username', 'password'));
        $this->_setRepopulateFields(array('username'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->form     = $this->_populateField('form');
        $this->username = $this->_populateField('username');
        $this->password = $this->_populateField('password');
    }

    /**
     * attempt to submit the form using the populated fields
     *
     * @return boolean [ response from database query ]
     */
    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        if ( $this->_validateRequiredFields() ) {
            if ( $this->_verifyLoginInfo() ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->_generateMissingFieldsError($this->form);
        }

        return $response;
    }

    /**
     * [_verifyLoginInfo description]
     *
     * @return [type] [description]
     */
    private function _verifyLoginInfo() {
        return TRUE;
        /*
        $dbh = Database::getHandler();

        $query = sprintf(
            "SELECT
                *
            FROM
                user_table
            WHERE
                username = '%s'
            AND
                password = '%s'",
            $this->username,
            $this->password
        );

        $query = $dbh->prepare($query);

        return $query->execute();
        */
    }
}