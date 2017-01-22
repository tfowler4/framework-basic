<?php

/**
 * edit category form
 */
class EditCategoryForm extends Form {
    public $id;
    public $form;
    public $name;
    public $meta;

    const FORM_NAME       = 'edit-category';
    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Category successfully saved!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while saving your Category!');

    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('id, name', 'meta'));

        $this->populateForm();
    }

    public function populateForm() {
        $this->id   = $this->_populateField('edit-category-id');
        $this->form = $this->_populateField('form');
        $this->name = $this->_populateField('name');
        $this->meta = $this->_populateField('meta');
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        if ( $this->_validateRequiredFields() ) {
            if ( $this->_updateCategorytoDb() ) {
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