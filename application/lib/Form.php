<?php

/**
 * generate form class
 */
abstract class Form {
    protected $_dbh;

    public $requiredFields   = array();
    public $missingFields    = array();
    public $repopulateFields = array();

    const MESSAGE_GENERIC = array('type' => 'warning', 'title' => 'Rut Roh', 'message' => 'Something happened and we dunno what it was!');

    /* Test Lorem
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices. Vestibulum lacus tortor, finibus non dui non, posuere placerat enim. Sed ac fringilla velit. Phasellus non nunc ut leo facilisis auctor. Aliquam ac diam ipsum. Donec eget nunc lorem. In erat sapien, suscipit ut felis sed, rutrum vulputate eros. Nullam gravida justo vel arcu euismod, a molestie tellus auctor. Sed at nisl sagittis, porta mauris eget, tincidunt lorem. Nam magna erat, hendrerit sed egestas quis, pharetra vitae dolor
    */

    public function __construct($dbh) {
        $this->_dbh = $dbh;
    }

    public function repopulateForm($form) {
        $sessionForm = SessionData::get('form');

        if ( !empty($sessionForm) ) {
            foreach ( $sessionForm as $field => $value ) {
                if ( !in_array($field, $this->repopulateFields) ) {
                    continue;
                }

                $form->$field = $value;
            }
        }
    }

    protected function _validateRequiredFields() {
        $areRequiredFieldsValid = TRUE;

        foreach( $this->requiredFields as $field ) {
            if ( in_array($field, $this->missingFields) ) {
                $areRequiredFieldsValid = FALSE;
            }
        }

        return $areRequiredFieldsValid;
    }

    protected function _setFieldRequired($fields) {
        $this->requiredFields = $fields;
    }

    protected function _setRepopulateFields($fields) {
        $this->repopulateFields = $fields;
    }

    protected function _populateField($field) {
        $formValue = Post::get($field);

        if ( empty($formValue) ) {
            array_push($this->missingFields, $field);
        }

        return $formValue;
    }

    protected function _generateMissingFieldsError($formName) {
        $message = '';

        foreach( $this->missingFields as $missingField ) {
            if ( !empty($message) ) {
                $message .= ', ';
            }

            $message .= $this->_formatFormFieldName($missingField);
        }

        $errorMessage = array(
            'type'    => 'danger',
            'title'   => 'WOMP',
            'message' => $this->_formatFormFieldName($formName) . ': The following field(s) are missing: ' . $message
        );

        return $errorMessage;
    }

    protected function _formatFormFieldName($formName) {
        if ( strpos($formName, '-') > -1 ) {
            $formNameArray = explode('-', $formName);

            for ( $i = 0; $i < count($formNameArray); $i++ ) {
                $formNameArray[$i] = ucfirst($formNameArray[$i]);
            }

            $formName = implode($formNameArray, ' ');
        } else {
             $formName = ucfirst($formName);
        }

        return $formName;
    }
}