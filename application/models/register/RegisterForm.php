<?php

/**
 * register form
 */
class RegisterForm extends Form {
    public $form;
    public $username;
    public $email;
    public $password;
    public $confirmPassword;

    const FORM_NAME       = 'register';
    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Registration successful!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while attempting to register!');

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
        $response = parent::MESSAGE_GENERIC;

        if ( $this->_validateRequiredFields() ) {
            if ( $this->_registerUserToDb() ) {
                $response = self::MESSAGE_SUCCESS;
                SessionData::remove('form');
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->_generateMissingFieldsError($this->form);
        }

        return $response;
    }

    private function _encodePassword() {

    }

    /**
     * [_registerUserToDb description]
     *
     * @return [type] [description]
     */
    private function _registerUserToDb() {
        $dbh = Database::getHandler();

        /*
        $query = sprintf(
            "INSERT INTO
                article_table (title, category_id, content)
            values
                ('%s', '%d', '%s')",
            $this->title,
            $this->category,
            $this->content
        );

        $query = $dbh->prepare($query);

        return $query->execute();
        */
       return TRUE;
    }
}