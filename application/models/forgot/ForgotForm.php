<?php

/**
 * forgot form
 */
class ForgotForm extends Form {
    public $form;
    public $emailAddress;

    const FORM_NAME           = 'forgot';
    const SUCCESS_GENERIC     = array('type' => 'success', 'title' => 'Success', 'message' => 'Please check your email for instructions on how to recover your password!');
    const ERROR_GENERIC       = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while trying to recover your paassword!');
    const ERROR_INVALID_EMAIL = array('type' => 'danger',  'title' => 'Error',   'message' => 'Unable to find an account associated with the email address provided.');

    /**
     * constructor
     *
     * @param obj $dbh [ database handler ]
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
        $this->form         = $this->_populateField('form');
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

        if ( $this->_checkEmailInDb() == 0 ) {
            return self::ERROR_INVALID_EMAIL;
        }


        if ( !$this->_lockAccountInDb() ) {
            return self::ERROR_GENERIC;
        }

        if ( $this->_sendRecoveryEmail() !== FALSE ) {
            SessionData::remove('form');
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
     * lock account in database by updating locked field
     *
     * @return boolean [ response from database query ]
     */
    private function _lockAccountInDb() {
        $query = sprintf(
            "UPDATE
                user_table
            SET
                locked = 1
            WHERE
                email_address='%s'",
            $this->emailAddress
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }

    /**
     * lock account in database by updating locked field
     *
     * @return boolean [ response from database query ]
     */
    private function _sendRecoveryEmail() {
        mail('terrijonfowler@gmail.com','Testing', 'Test message');
    }
}