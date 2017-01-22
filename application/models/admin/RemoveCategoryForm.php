<?php

/**
 * remove category form
 */
class RemoveCategoryForm extends Form {
    public $id;
    public $form;

    const FORM_NAME       = 'remove-category';
    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Category successfully removed!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while removing your Category!');

    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('id'));

        $this->populateForm();
    }

    public function populateForm() {
        $this->id   = $this->_populateField('edit-category-id');
        $this->form = $this->_populateField('form');
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        if ( $this->_validateRequiredFields() ) {
            if ( $this->_verifyRemainingCategoryArticles() ) {
                if ( $this->_removeCategoryFromDb() ) {
                    $response = self::MESSAGE_SUCCESS;
                    SessionData::remove('form');
                } else {
                    $response = self::MESSAGE_ERROR;
                }
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->_generateMissingFieldsError($this->form);
        }

        return $response;
    }

    private function _verifyRemainingCategoryArticles() {
        $dbh = Database::getHandler();

        $clearedArticlesWithCategory = TRUE;

        $query = sprintf(
            "SELECT
                COUNT(*) as num_of_articles
            FROM
                article_table
            WHERE
                category_id = '%d'
            GROUP BY
                category_id",
            $this->id
        );

        $query = $dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $numOfArticles = $row['num_of_articles'];

            if ( $numOfArticles > 0 ) {
                $clearedArticlesWithCategory = FALSE;
            }

            break;
        }

        return $clearedArticlesWithCategory;
    }

    private function _removeCategoryFromDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "DELETE
            FROM
                category_table
            WHERE
                category_id = '%d'",
            $this->id
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}