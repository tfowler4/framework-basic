<?php

/**
 * reset password form
 */
class ResetPasswordForm extends Form implements FormInterface {
    public $form;
    public $password;
    public $passwordConfirm;
    public $token;

    const FORM_NAME               = 'reset-password';
    const SUCCESS_GENERIC         = array('type' => 'success', 'title' => 'Success', 'message' => 'Password successfully reset. You can now login!');
    const ERROR_GENERIC           = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while trying to reset your paassword!');
    const ERROR_MISMATCH_PASSWORD = array('type' => 'danger',  'title' => 'Error',   'message' => 'Passwords do not match!');

    /**
     * constructor
     *
     * @param obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('password', 'confirm-password', 'token'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->password        = $this->_populateField('password');
        $this->passwordConfirm = $this->_populateField('confirm-password');
        $this->token           = $this->_populateField('token');
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

        if ( !$this->_checkPasswordMatch() ) {
            return self::ERROR_MISMATCH_PASSWORD;
        }

        if ( $this->_updatePasswordInDb() ) {
            SessionData::remove('form');
            SessionData::set('message', self::SUCCESS_GENERIC);
            redirect(SITE_URL);
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
     * check if the new provided passwords match with the confirmed password
     *
     * @return boolean [ if provided passwords match ]
     */
    private function _checkPasswordMatch() {
        $doPasswordsMatch = FALSE;

        if ( $this->password == $this->passwordConfirm ) {
            $doPasswordsMatch = TRUE;
        }

        return $doPasswordsMatch;
    }

    /**
     * update user password in the database
     *
     * @return boolean [ response from database query ]
     */
    private function _updatePasswordInDb() {
        $query = sprintf(
            "UPDATE
                user_table
            SET
                password = '%s',
                token = '',
                locked = '0',
                token_expire_time = ''
            WHERE
                token = '%s'
            AND
                token_expire_time >= NOW()",
            $this->_hashPassword($this->password),
            $this->token
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}