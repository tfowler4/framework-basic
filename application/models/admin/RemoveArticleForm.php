<?php

/**
 * remove article form
 */
class RemoveArticleForm extends Form {
    public $id;
    public $form;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully removed!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while removing your Article!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('id'));
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            if ( $this->_removeArticleFromDb() ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->generateMissingFieldsError($this->form);
        }

        return $response;
    }

    private function _removeArticleFromDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "DELETE
            FROM
                article_table
            WHERE
                article_id = '%d'",
            $this->id
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}