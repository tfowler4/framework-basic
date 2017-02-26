<?php

/**
 * register model
 */
class RegisterModel extends AbstractModel {
    const MODEL_NAME = 'Register';

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh, $params) {
        parent::__construct($dbh);

        $this->_loadForms();
    }

    /**
     * load all forms associated with model
     *
     * @return void
     */
    protected function _loadForms() {
        $this->forms = new stdClass();
        $this->forms->register = new RegisterForm($this->_dbh);

        foreach ( $this->forms as $form ) {
            $form->repopulateForm($form);
        }
    }
}