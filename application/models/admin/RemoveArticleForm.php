<?php

/**
 * remove article form
 */
class RemoveArticleForm extends Form {
    public $id;
    public $form;

    const FORM_NAME       = 'remove-article';
    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully removed!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while removing your Article!');

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
        $response = parent::MESSAGE_GENERIC;

        if ( $this->_validateRequiredFields() ) {
            if ( $this->_removeArticleFromDb() ) {
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