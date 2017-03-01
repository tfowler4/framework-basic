<?php

/**
 * deactivate account form
 */
class DeactivateForm extends Form implements FormInterface {
    public $form;
    public $userId;

    const FORM_NAME       = 'deactivate';
    const SUCCESS_GENERIC = array('type' => 'success', 'title' => 'Success', 'message' => 'Successfully deactivated your account!');
    const ERROR_GENERIC   = array('type' => 'danger',  'title' => 'Error',   'message' => 'Unable to deactivate this account!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);
    }

    public function populateForm() {}

    /**
     * attempt to submit the form using the populated fields
     *
     * @return boolean [ response from database query ]
     */
    public function submitForm() {
        if ( $this->deactivateAccountInDb() ) {
            SessionData::remove('form');
            SessionData::set('user', NULL);
            SessionData::set('login', FALSE);

            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
    }

    /**
     * lock user account in database
     *
     * @return boolean [ response from database query ]
     */
    private function deactivateAccountInDb() {
        $query = sprintf(
            "UPDATE
                user_table
            SET
                active = 0,
                token = ''
            WHERE
                user_id='%d'",
            SessionData::get('user')['user_id']
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}