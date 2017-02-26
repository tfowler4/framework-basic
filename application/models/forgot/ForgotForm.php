<?php

/**
 * forgot form
 */
class ForgotForm extends Form  implements FormInterface {
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
     * store token hash in database
     *
     * @return boolean [ response from database query ]
     */
    private function _storeTokenInDb($token) {
        $query = sprintf(
            "UPDATE
                user_table
            SET
                token = '%s',
                token_expire_time =  NOW() + INTERVAL 15 MINUTE
            WHERE
                email_address='%s'",
            $token,
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
        $email   = $this->emailAddress;
        $message = '';
        $title   = '';

        $token = $this->_generateResetToken(40);
        $this->_storeTokenInDb($token);

        $message = SITE_URL . 'forgot/reset/' . $token;

        mail('terrijonfowler@gmail.com', SITE_NAME .' - Password Recovery', $message);
    }

    /**
     * generate a reset token to be emailed
     *
     * @param  integer $length [ number of characters in token ]
     * @return string          [ hashed token value ]
     */
    private function _generateResetToken($length) {
        $token        = '';
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet.= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet.= '0123456789';
        $max          = strlen($codeAlphabet); // edited

        for ( $i = 0; $i < $length; $i++ ) {
            $token .= $codeAlphabet[$this->_cryptoRandSecure(0, $max - 1)];
        }

        return $token;
    }

    /**
     * crypting the hash with a secure algorithm
     *
     * @param  integer $min [ min integer ]
     * @param  integer $max [ max integer ]
     *
     * @return integer      [ minumum value plus a random integer not exceeding the maximum ]
     */
    private function _cryptoRandSecure($min, $max) {
        $range = $max - $min;

        if ( $range < 1 ) {
            return $min;
        } // not so random...

        $log    = ceil(log($range, 2));
        $bytes  = (int) ($log / 8) + 1; // length in bytes
        $bits   = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ( $rnd > $range );

        return $min + $rnd;
    }
}