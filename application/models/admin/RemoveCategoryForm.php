<?php

/**
 * remove category form
 */
class RemoveCategoryForm extends Form {
    public $id;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Category successfully removed!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while removing your Category!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('id'));
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            if ( $this->_verifyRemainingCategoryArticles() ) {
                if ( $this->_removeCategoryFromDb() ) {
                    $response = self::MESSAGE_SUCCESS;
                } else {
                    $response = self::MESSAGE_ERROR;
                }
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->generateMissingFieldsError($this->form);
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