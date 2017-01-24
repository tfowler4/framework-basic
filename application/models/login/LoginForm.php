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
            if ( !empty($this->_verifyLoginInfo()) ) {
                $response = self::MESSAGE_SUCCESS;
                SessionData::remove('form');

                redirect(SITE_URL . 'userpanel');
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->_generateMissingFieldsError($this->form);
        }

        return $response;
    }


    private function _checkPassword($hash) {
        $validPassword = FALSE;

        if (password_verify($this->password, $hash)) {
            $validPassword = TRUE;
            // Login successful.
            //if (password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost' => 12])) {
                // Recalculate a new password_hash() and overwrite the one we stored previously
            //}
        }

        return $validPassword;
    }

    /**
     * [_verifyLoginInfo description]
     *
     * @return [type] [description]
     */
    private function _verifyLoginInfo() {
        $user = array();

        $query = sprintf(
            "SELECT
                *
            FROM
                user_table
            WHERE
                username = '%s'",
            $this->username
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ( $this->_checkPassword($row['password']) ) {
                $user = $row;

                SessionData::set('login', TRUE);
                SessionData::set('user', $user);
                break;
            }
        }

        return $user;
    }
}