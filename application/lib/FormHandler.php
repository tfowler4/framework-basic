<?php

/**
 * form handling class to be used when attempting to submit forms
 */
class FormHandler {
    private $_form;
    private $_formName;
    private $_hasMessage = FALSE;
    private $_dbh;

    public $alertMessage = array();

    const MESSAGE_GENERIC = array('type' => 'warning', 'title' => 'Rut Roh', 'message' => 'Something happened and we dunno what it was with FormHandler!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        $this->_dbh = $dbh;
    }

    /**
     * process any form data in POST
     *
     * @return void
     */
    public function process() {
        if ( !$this->_getFormName() ) {
            $this->_generateError();
            return;
        }

        $this->_setForm($this->_formName);
        $this->_populateFormFields();
        $this->_submit();

        redirect('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    /**
     * check if any form data has been submitted to POST
     *
     * @return boolean [ if any form data has been submitted ]
     */
    public function isFormSubmitted() {
        $isFormSubmitted = FALSE;

        if ( Post::count() > 0 ) {
            $isFormSubmitted = TRUE;
        }

        return $isFormSubmitted;
    }

    /**
     * sattempt to submit the form data from POST
     *
     * @return void
     */
    private function _submit() {
        $formResponse = $this->_form->submitForm();

        if ( !empty($formResponse) && $formResponse > 0 ) {
            SessionData::set('message', $formResponse);
        } else {
            $this->_generateError();
        }
    }

    /**
     * get the name of the form submitted
     *
     * @return boolean [ was a form name submitted ]
     */
    private function _getFormName() {
        $hasFormName = FALSE;

        if ( !empty(Post::get('form')) ) {
            $this->_formName = Post::get('form');
            $this->_formName = ucfirst(str_replace('-', '', $this->_formName));
            $hasFormName     = TRUE;
        }

        return $hasFormName;
    }

    /**
     * set the form object from the form name
     *
     * @param void
     */
    private function _setForm($formName) {
        $className = $formName . 'Form';

        $this->_form = new $className($this->_dbh);
    }

    /**
     * set error message in session data to be displayed in an alert
     *
     * @return void
     */
    private function _generateError() {
        SessionData::set('message', self::MESSAGE_GENERIC);
    }

    /**
     * populate the form and place into session to be submitted
     *
     * @return void
     */
    private function _populateFormFields() {
        $formArray       = array();
        $this->_formName = $this->_form->form;

        foreach( $this->_form as $formField => $formValue ) {
            if ( is_string($formValue) ) {
                $formArray[$formField] = $formValue;
            }
        }

        SessionData::set('form', $formArray);
    }
}