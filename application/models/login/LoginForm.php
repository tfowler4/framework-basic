<?php

/**
 * login form
 */
class LoginForm extends Form implements FormInterface {
    public $form;
    public $email;
    public $password;

    const FORM_NAME           = 'login';
    const SUCCESS_GENERIC     = array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully logged in!');
    const ERROR_GENERIC       = array('type' => 'danger',  'title' => 'Error',   'message' => 'Invalid Email/Password combo!');
    const ERROR_ACCT_LOCKED   = array('type' => 'danger',  'title' => 'Error',   'message' => 'Account is currently locked!');
    const ERROR_ACCT_INACTIVE = array('type' => 'danger',  'title' => 'Error',   'message' => 'Account has been deactivated! Password must be reset to reactivate!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('email-address', 'password'));
        $this->_setRepopulateFields(array('email-address'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->form     = $this->_populateField('form');
        $this->username = $this->_populateField('email-address');
        $this->password = $this->_populateField('password');
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

        $user = $this->_getUserFromDb();

        if ( empty($user) ) {
            return self::ERROR_GENERIC;
        }

        if ( $user['active'] == 0 ) {
            SessionData::set('login', FALSE);
            SessionData::set('user', NULL);
            SessionData::set('admin', FALSE);

            return self::ERROR_ACCT_INACTIVE;
        }

        if ( $user['locked'] == 1 ) {
            SessionData::set('login', FALSE);
            SessionData::set('user', NULL);
            SessionData::set('admin', FALSE);

            return self::ERROR_ACCT_LOCKED;
        }

        SessionData::remove('form');
        redirect(SITE_URL . 'userpanel');
    }

    /**
     * check to see if user supplied password matches stored hash
     *
     * @param  string $hash [ password hash string from database ]
     *
     * @return boolean [ if password matches hash ]
     */
    private function _checkPassword($hash) {
        $validPassword = FALSE;

        if (password_verify($this->password, $hash)) {
            $validPassword = TRUE;
        }

        return $validPassword;
    }

    /**
     * get the user from the database
     *
     * @return array [ array of user details ]
     */
    private function _getUserFromDb() {
        $user = null;

        $query = sprintf(
            "SELECT
                *
            FROM
                user_table
            WHERE
                email_address = '%s'",
            $this->username
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ( $this->_checkPassword($row['password']) ) {
                $user = $row;

                SessionData::set('login', TRUE);
                SessionData::set('user', $user);

                if ( $user['account_type'] == 1 ) {
                    SessionData::set('admin', TRUE);
                }

                break;
            }
        }

        return $user;
    }
}