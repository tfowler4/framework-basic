<?php

/**
 * create category form
 */
class CreateCategoryForm extends Form {
    public $form;
    public $name;
    public $meta;

    const FORM_NAME       = 'create-category';
    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article Category successfully created!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while creating your Article Category!');

    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('name', 'meta'));

        $this->populateForm();
    }

    public function populateForm() {
        $this->form = $this->_populateField('form');
        $this->name = $this->_populateField('name');
        $this->meta = $this->_populateField('meta');
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        if ( $this->_validateRequiredFields() ) {
            if ( $this->_insertCategorytoDb() ) {
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

    private function _insertCategorytoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "INSERT INTO
                category_table (name, meta)
            values
                ('%s', '%s')",
            $this->name,
            $this->meta
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}