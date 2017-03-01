<?php

/**
 * register form
 */
class RegisterForm extends Form implements FormInterface {
    public $form;
    public $username;
    public $email;
    public $password;
    public $confirmPassword;

    const FORM_NAME          = 'register';
    const SUCCESS_GENERIC    = array('type' => 'success', 'title' => 'Success', 'message' => 'Registration successful!');
    const ERROR_GENERIC      = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while attempting to register!');
    const ERROR_EMAIL_EXISTS = array('type' => 'warning',  'title' => 'Error',   'message' => 'Email Address already registered!');
    const ERROR_USER_EXISTS  = array('type' => 'warning',  'title' => 'Error',   'message' => 'Username already registered!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('username', 'email', 'password', 'confirm-password'));
        $this->_setRepopulateFields(array('username', 'email'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->form            = $this->_populateField('form');
        $this->username        = $this->_populateField('username');
        $this->email           = $this->_populateField('email');
        $this->password        = $this->_populateField('password');
        $this->confirmPassword = $this->_populateField('confirm-password');
    }

    /**
     * attempt to submit the form using the populated fields
     *
     * @return boolean [ response from database query ]
     */
    public function submitForm() {
        if ( !$this->_validateRequiredFields() ) {
            return $this->_generateMissingFieldsError($this->form);
        }

        if ( $this->_checkUserInDb() > 0 ) {
            return self::ERROR_USER_EXISTS;
        }

        if ( $this->_checkEmailInDb() > 0 ) {
            return self::ERROR_EMAIL_EXISTS;
        }

        if ( $this->_registerUserToDb() ) {
            SessionData::remove('form');
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
    }

    /**
     * hash the given password with an algorithm
     *
     * @param  string $password [ user password string in plain text]
     *
     * @return string [ hashed password ]
     */
    private function _hashPassword($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

        return $hash;
    }

    /**
     * add user to the database
     *
     * @return boolean [ response from database query ]
     */
    private function _registerUserToDb() {
        $query = sprintf(
            "INSERT INTO
                user_table (username, email_address, password, date_added, last_modified)
            values
                ('%s', '%s', '%s', null, null)",
            $this->username,
            $this->email,
            $this->_hashPassword($this->password)
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }

    /**
     * check the database to see if the username exists
     *
     * @return integer [ number of users found ]
     */
    private function _checkUserInDb() {
        $usersFound = 0;

        $query = sprintf(
            "SELECT
                user_id,
                username,
                email_address,
                password,
                date_added,
                last_modified
            FROM
               user_table
            WHERE
                username = '%s'",
            $this->username
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $usersFound++;
        }

       return $usersFound;
    }

    /**
     * check the database to see if the email address exists
     *
     * @return integer [ number of users found ]
     */
    private function _checkEmailInDb() {
        $usersFound = 0;

        $query = sprintf(
            "SELECT
                user_id,
                username,
                email_address,
                password,
                date_added,
                last_modified
            FROM
               user_table
            WHERE
                email_address = '%s'",
            $this->email
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $usersFound++;
        }

       return $usersFound;
    }
}