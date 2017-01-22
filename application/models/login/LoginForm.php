<?php

/**
 * login form
 */
class LoginForm extends Form {
    public $form;
    public $username;
    public $password;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully logged in!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'Invalid Username/Password combo!');

    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('username', 'password'));
    }

    public function populateForm() {
        $this->form     = $this->_populateField('form');
        $this->username = $this->_populateField('username');
        $this->password = $this->_populateField('password');
    }

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