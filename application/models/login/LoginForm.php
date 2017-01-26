<?php

/**
 * login form
 */
class LoginForm extends Form {
    public $form;
    public $email;
    public $password;

    const FORM_NAME       = 'login';
    const SUCCESS_GENERIC = array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully logged in!');
    const ERROR_GENERIC   = array('type' => 'danger',  'title' => 'Error',   'message' => 'Invalid Email/Password combo!');

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

        if ( empty($this->_getUserFromDb()) ) {
            return self::ERROR_GENERIC;
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
        $user = array();

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