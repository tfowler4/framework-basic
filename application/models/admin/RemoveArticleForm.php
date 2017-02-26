<?php

/**
 * remove article form
 */
class RemoveArticleForm extends Form implements FormInterface {
    public $id;
    public $form;

    const FORM_NAME       = 'remove-article';
    const SUCCESS_GENERIC = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully removed!');
    const ERROR_GENERIC   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while removing your Article!');

    /**
     * constructor
     *
     * @param  obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('id'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->id   = $this->_populateField('id');
        $this->form = $this->_populateField('form');
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

        if ( $this->_removeArticleFromDb() ) {
            SessionData::remove('form');
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
    }

    /**
     * remove article from the database
     *
     * @return boolean [ response from database query ]
     */
    private function _removeArticleFromDb() {
        $query = sprintf(
            "DELETE
            FROM
                article_table
            WHERE
                article_id = '%d'",
            $this->id
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}