<?php

/**
 * form handling class
 */
class FormHandler {
    public static $form;
    public static $formName;
    public static $hasMessage   = FALSE;
    public static $alertMessage = array();

    const MESSAGE_GENERIC = array('type' => 'warning', 'title' => 'Rut Roh', 'message' => 'Something happened and we dunno what it was with FormHandler!');

    public static function process() {
        if ( !self::getFormName() ) {
            self::generateError();
            return;
        }

        self::getForm(self::$formName);

        self::populateFormFields();

        self::submit();

        header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit;
    }

    public static function submit() {
        $formResponse = self::$form->submitForm();

        if ( !empty($formResponse) && $formResponse > 0 ) {
            SessionData::set('message', $formResponse);

            SessionData::remove(self::$formName);
        } else {
            self::generateError();
        }
    }

    public static function getFormName() {
        $hasFormName = FALSE;

        if ( !empty(Post::get('form')) ) {
            self::$formName = Post::get('form');
            self::$formName = str_replace('-', '', self::$formName);
            $hasFormName = TRUE;
        }

        return $hasFormName;
    }

    public static function getForm($formName) {
        $className = $formName . 'Form';

        self::$form = new $className;
    }

    public static function generateError() {
        SessionData::set('message', self::MESSAGE_GENERIC);
    }

    public static function populateFormFields() {
        $formArray       = array();
        $formName        = get_class(self::$form);
        self::$formName  = $formName;

        foreach( self::$form as $formField => $fieldValue) {
            if ( !empty(Post::get($formField)) && is_string(Post::get($formField)) ) {
                $formArray[$formField]  = Post::get($formField);
            }
        }

        SessionData::set($formName, $formArray);
    }

    public static function isFormSubmitted() {
        $isFormSubmitted = FALSE;

        if ( Post::count() > 0 ) {
            $isFormSubmitted = TRUE;
        }

        return $isFormSubmitted;
    }
}