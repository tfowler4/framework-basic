<?php

/**
 * generate form class
 */
abstract class Form {
    public $requiredFields = array();
    public $missingFields  = array();

    const MESSAGE_GENERIC = array('type' => 'warning', 'title' => 'Rut Roh', 'message' => 'Something happened and we dunno what it was!');

    /* Test Lorem
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices. Vestibulum lacus tortor, finibus non dui non, posuere placerat enim. Sed ac fringilla velit. Phasellus non nunc ut leo facilisis auctor. Aliquam ac diam ipsum. Donec eget nunc lorem. In erat sapien, suscipit ut felis sed, rutrum vulputate eros. Nullam gravida justo vel arcu euismod, a molestie tellus auctor. Sed at nisl sagittis, porta mauris eget, tincidunt lorem. Nam magna erat, hendrerit sed egestas quis, pharetra vitae dolor
    */

    public function __construct() {
        $this->prePopulateFields();
    }

    public function validateRequiredFields() {
        $areRequiredFieldsValid = TRUE;

        foreach( $this as $fieldName => $fieldValue ) {
            if ( !in_array($fieldName, $this->requiredFields) ) {
                continue;
            }

            if ( empty($this->$fieldName) ) {
                array_push($this->missingFields, $fieldName);
                $areRequiredFieldsValid = FALSE;
            }
        }

        return $areRequiredFieldsValid;
    }

    public function setFieldRequired($fields) {
        $this->requiredFields = $fields;
    }

    public function prePopulateFields() {
        if ( !empty(SessionData::get(get_class($this))) ) {
            $sessionForm = SessionData::get(get_class($this));

            foreach( $sessionForm as $formField => $fieldValue ) {
                $this->$formField = '';

                if ( !empty($fieldValue) && is_string($fieldValue) ) {
                    $this->$formField = $fieldValue;
                }
            }

            SessionData::remove(get_class($this));
        }
    }

    public function generateMissingFieldsError($formName) {
        $message = '';

        foreach( $this->missingFields as $missingField ) {
            if ( !empty($message) ) {
                $message .= ', ';
            }

            $message .= ucfirst($missingField);
        }

        $errorMessage = array(
            'type'    => 'danger',
            'title'   => 'WOMP',
            'message' => $this->_formatFormName($formName) . ': The following field(s) are missing: ' . $message
        );

        return $errorMessage;
    }

    protected function _formatFormName($formName) {
        if ( strpos($formName, '-') > -1 ) {
            $formNameArray = explode('-', $formName);

            for ( $i =0; $i < count($formNameArray); $i++ ) {
                $formNameArray[$i] = ucfirst($formNameArray[$i]);
            }

            $formName = implode($formNameArray, ' ');
        } else {
             $formName = ucfirst($formName);
        }

        return $formName;
    }
}