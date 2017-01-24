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

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('id, name', 'meta'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->id   = $this->_populateField('edit-category-id');
        $this->form = $this->_populateField('form');
        $this->name = $this->_populateField('name');
        $this->meta = $this->_populateField('meta');
    }

    /**
     * attempt to submit the form using the populated fields
     *
     * @return boolean [ response from database query ]
     */
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

    /**
     * update category in the database
     *
     * @return boolean [ response from database query ]
     */
    private function _updateCategorytoDb() {
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

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}