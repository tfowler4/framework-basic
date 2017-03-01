<?php

/**
 * create category form
 */
class CreateCategoryForm extends Form implements FormInterface {
    public $form;
    public $name;
    public $meta;
    public $icon;
    public $primaryColor;

    const FORM_NAME       = 'create-category';
    const SUCCESS_GENERIC = array('type' => 'success', 'title' => 'Success', 'message' => 'Article Category successfully created!');
    const ERROR_GENERIC   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while creating your Article Category!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('name', 'meta'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->form         = $this->_populateField('form');
        $this->name         = $this->_populateField('name');
        $this->meta         = $this->_populateField('meta');
        $this->icon         = $this->_populateField('icon');
        $this->primaryColor = $this->_populateField('primary-color');
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

        if ( $this->_insertCategorytoDb() ) {
            SessionData::remove('form');
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
    }

    /**
     * insert category into the database
     *
     * @return boolean [ query success or failure ]
     */
    private function _insertCategorytoDb() {
        $query = sprintf(
            "INSERT INTO
                category_table (name, meta, icon, color_1, date_added, last_modified)
            values
                ('%s', '%s', '%s', '%s', null, null)",
            $this->name,
            $this->meta,
            $this->icon,
            $this->primaryColor
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}