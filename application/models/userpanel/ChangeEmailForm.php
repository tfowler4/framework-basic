<?php

/**
 * change email form
 */
class ChangeEmailForm extends Form implements FormInterface {
    public $form;
    public $emailAddress;

    const FORM_NAME            = 'change-email';
    const SUCCESS_GENERIC      = array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully updated your Email Address!');
    const ERROR_GENERIC        = array('type' => 'danger',  'title' => 'Error',   'message' => 'Invalid Email!');
    const ERROR_EXISTING_EMAIL = array('type' => 'danger',  'title' => 'Error',   'message' => 'Email already exists!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('email-address'));
        $this->_setRepopulateFields(array('email-address'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->emailAddress = $this->_populateField('email-address');
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

        if ( $this->_checkEmailInDb() > 0 ) {
            return self::ERROR_EXISTING_EMAIL;
        }

        if ( $this->_updateEmailInDb() ) {
            SessionData::remove('form');

            $user = SessionData::get('user');
            $user['email_address'] = $this->emailAddress;
            SessionData::set('user', $user);
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
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
            $this->emailAddress
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $usersFound++;
        }

       return $usersFound;
    }

    /**
     * update user email address in the database
     *
     * @return boolean [ response from database query ]
     */
    private function _updateEmailInDb() {
        $query = sprintf(
            "UPDATE
                user_table
            SET
                email_address = '%s'
            WHERE
                user_id='%d'",
            $this->emailAddress,
            SessionData::get('user')['user_id']
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}