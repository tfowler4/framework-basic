<?php

/**
 * create category form
 */
class CreateCategoryForm extends Form {
    public $form;
    public $name;
    public $meta;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article Category successfully created!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while creating your Article Category!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('name', 'meta'));
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            if ( $this->_insertCategorytoDb() ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->generateMissingFieldsError($this->form);
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