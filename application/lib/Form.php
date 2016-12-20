<?php

/**
 * generate form class
 */
abstract class Form {
    public $requiredFields = array();

    const MESSAGE_GENERIC = array('type' => 'warning', 'title' => 'Rut Roh', 'message' => 'Something happened and we dunno what it was!');

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
                $areRequiredFieldsValid = FALSE;
                return;
            }
        }

        return $areRequiredFieldsValid;
    }

    public function setFieldRequired($fieldName) {
        array_push($this->requiredFields, $fieldName);
    }

    public function prePopulateFields() {
        if ( !empty(SessionData::get(get_class($this))) ) {
            $sessionForm = SessionData::get(get_class($this));

            foreach( $sessionForm as $formField => $fieldValue ) {
                $this->$formField = '';

                if ( is_string($fieldValue) ) {
                    $this->$formField = $fieldValue;
                }
            }

            SessionData::remove(get_class($this));
        }
    }
}