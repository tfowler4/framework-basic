<?php

/**
 * update password form
 */
class UpdatePasswordForm extends Form implements FormInterface {
    public $form;
    public $oldPassword;
    public $confirmPassword;

    const FORM_NAME                = 'update-password';
    const SUCCESS_GENERIC          = array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully updated your Password!');
    const ERROR_GENERIC            = array('type' => 'danger',  'title' => 'Error',   'message' => 'There was an error in updating your password!');
    const ERROR_INCORRECT_PASSWORD = array('type' => 'danger',  'title' => 'Error',   'message' => 'Incorrect old password!');
    const ERROR_MISMATCH_PASSWORD  = array('type' => 'danger',  'title' => 'Error',   'message' => 'Passwords do not match!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('old-password', 'new-password', 'confirm-password'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->oldPassword     = $this->_populateField('old-password');
        $this->newPassword     = $this->_populateField('new-password');
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

        if ( !$this->_validateOldPassword() ) {
            return self::ERROR_INCORRECT_PASSWORD;
        }

        if ( !$this->_checkPasswordMatch() ) {
            return self::ERROR_MISMATCH_PASSWORD;
        }

        if ( $this->_updatePasswordInDb() ) {
            SessionData::remove('form');
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
    }

    /**
     * check if the new provided passwords match with the confirmed password
     *
     * @return boolean [ if provided passwords match ]
     */
    private function _checkPasswordMatch() {
        $doPasswordsMatch = FALSE;

        if ( $this->newPassword == $this->confirmPassword ) {
            $doPasswordsMatch = TRUE;
        }

        return $doPasswordsMatch;
    }

    /**
     * validate if old password inputted is correct
     *
     * @return boolean [ if old password matches what is in the database ]
     */
    private function _validateOldPassword() {
        $userId           = SessionData::get('user')['user_id'];
        $userPasswordHash = $this->_getOldPasswordHash($userId);

        return $this->_checkPassword($userPasswordHash);
    }

    /**
     * get the old password hash from database for the user
     *
     * @param  string $userId [ id of user ]
     *
     * @return string [ password hash from database ]
     */
    private function _getOldPasswordHash($userId) {
        $query = sprintf(
            "SELECT
                password
            FROM
                user_table
            WHERE
                user_id = '%s'",
            $userId
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            return $row['password'];
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
     * check to see if user supplied password matches stored hash
     *
     * @param  string $hash [ password hash string from database ]
     *
     * @return boolean [ if password matches hash ]
     */
    private function _checkPassword($hash) {
        $validPassword = FALSE;

        if (password_verify($this->oldPassword, $hash)) {
            $validPassword = TRUE;
        }

        return $validPassword;
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
                password = '%s'
            WHERE
                user_id='%d'",
            $this->_hashPassword($this->newPassword),
            SessionData::get('user')['user_id']
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}