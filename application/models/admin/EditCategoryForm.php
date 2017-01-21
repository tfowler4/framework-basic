<?php

/**
 * edit category form
 */
class EditCategoryForm extends Form {
    public $id;
    public $form;
    public $name;
    public $meta;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Category successfully saved!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while saving your Category!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('id, name', 'meta'));
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            if ( $this->_updateCategorytoDb() ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->generateMissingFieldsError($this->form);
        }

        return $response;
    }

    private function _updateCategorytoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "UPDATE
                category_table
            SET
                name = '%s',
                meta = '%s'
            WHERE
                category_id = '%d'",
            $this->name,
            $this->meta,
            $this->id
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}