<?php

/**
 * form handling class
 */

class FormHandler {
    public $alertMessage = array();
    private $_form;
    private $_formName;
    private $_hasMessage   = FALSE;
    private $_dbh;

    const MESSAGE_GENERIC = array('type' => 'warning', 'title' => 'Rut Roh', 'message' => 'Something happened and we dunno what it was with FormHandler!');

    public function __construct($dbh) {
        $this->_dbh =$dbh;
    }

    public function process() {
        if ( !$this->_getFormName() ) {
            $this->_generateError();
            return;
        }

        $this->_getForm($this->_formName);
        $this->_populateFormFields();
        $this->_submit();

        header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit;
    }

    public function isFormSubmitted() {
        $isFormSubmitted = FALSE;

        if ( Post::count() > 0 ) {
            $isFormSubmitted = TRUE;
        }

        return $isFormSubmitted;
    }

    private function _submit() {
        $formResponse = $this->_form->submitForm();

        if ( !empty($formResponse) && $formResponse > 0 ) {
            SessionData::set('message', $formResponse);

            SessionData::remove($this->_formName);
        } else {
            $this->_generateError();
        }
    }

    private function _getFormName() {
        $hasFormName = FALSE;

        if ( !empty(Post::get('form')) ) {
            $this->_formName = Post::get('form');
            $this->_formName = str_replace('-', '', $this->_formName);
            $hasFormName = TRUE;
        }

        return $hasFormName;
    }

    private function _getForm($formName) {
        $className = $formName . 'Form';

        $this->_form = new $className;
    }

    private function _generateError() {
        SessionData::set('message', self::MESSAGE_GENERIC);
    }

    private function _populateFormFields() {
        $formArray       = array();
        $formName        = get_class($this->_form);
        $this->_formName = $formName;

        foreach( $this->_form as $formField => $fieldValue) {
            if ( !empty(Post::get($formField)) && is_string(Post::get($formField)) ) {
                $formArray[$formField]  = Post::get($formField);
            }
        }

        SessionData::set($formName, $formArray);
    }
}