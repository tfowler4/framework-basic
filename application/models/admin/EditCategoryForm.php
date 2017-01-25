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
    const SUCCESS_GENERIC = array('type' => 'success', 'title' => 'Success', 'message' => 'Category successfully saved!');
    const ERROR_GENERIC   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while saving your Category!');

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
        if ( !$this->_validateRequiredFields() ) {
            return $this->_generateMissingFieldsError($this->form);
        }

        if ( $this->_updateCategorytoDb() ) {
            SessionData::remove('form');
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
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