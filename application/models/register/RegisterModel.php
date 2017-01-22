<?php

/**
 * register model
 */
class RegisterModel extends Model {
    /**
     * constructor
     */
    public function __construct($dbh, $params) {
        parent::__construct($dbh);

        $this->_loadForms();
    }

    protected function _loadForms() {
        $this->forms = new stdClass();
        $this->forms->register = new RegisterForm($this->_dbh);

        foreach ( $this->forms as $form ) {
            $form->repopulateForm($form);
        }
    }
}