<?php

/**
 * base form class
 */
abstract class Form {
    protected $_dbh;

    public $requiredFields   = array();
    public $missingFields    = array();
    public $repopulateFields = array();

    const MESSAGE_GENERIC = array('type' => 'warning', 'title' => 'Rut Roh', 'message' => 'Something happened and we dunno what it was!');

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
     * repopulate a form with data from the active session
     *
     * @param  obj $form [ form class object ]
     *
     * @return void
     */
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

    /**
     * checks if the required fields have been populated
     *
     * @return boolean [ if all required fields have been populated ]
     */
    protected function _validateRequiredFields() {
        $areRequiredFieldsValid = TRUE;

        foreach( $this->requiredFields as $field ) {
            if ( in_array($field, $this->missingFields) ) {
                $areRequiredFieldsValid = FALSE;
            }
        }

        return $areRequiredFieldsValid;
    }

    /**
     * set the required form fields
     *
     * @param  array $fields [ array of field names ]
     *
     * @return void
     */
    protected function _setFieldRequired($fields) {
        $this->requiredFields = $fields;
    }

    /**
     * set the array of fields that need to be repopulated if form submission fails
     *
     * @param  array $fields [ array of field names ]
     *
     * @return void
     */
    protected function _setRepopulateFields($fields) {
        $this->repopulateFields = $fields;
    }

    /**
     * get the value from the provided field name and mark if its empty into the missing fields
     *
     * @param  string $field [ name of field ]
     *
     * @return string [ value for field ]
     */
    protected function _populateField($field) {
        $formValue = Post::get($field);

        if ( empty($formValue) ) {
            array_push($this->missingFields, $field);
        }

        return $formValue;
    }

    /**
     * generate an error message based on missing fields that are required
     *
     * @param  string $formName [ form field name ]
     *
     * @return array [ error message array ]
     */
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

    /**
     * format the form field name to go from html format to php format (camelcase)
     *
     * @param  string $formName [ name of field ]
     *
     * @return string [ formatted form field name ]
     */
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