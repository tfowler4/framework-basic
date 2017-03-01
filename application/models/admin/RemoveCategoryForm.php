<?php

/**
 * remove category form
 */
class RemoveCategoryForm extends Form implements FormInterface {
    public $id;
    public $form;

    const FORM_NAME       = 'remove-category';
    const SUCCESS_GENERIC = array('type' => 'success', 'title' => 'Success', 'message' => 'Category successfully removed!');
    const ERROR_GENERIC   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while removing your Category!');

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

        if ( !$this->_verifyRemainingCategoryArticles() ) {
            return self::ERROR_GENERIC;
        }

        if ( $this->_removeCategoryFromDb() ) {
            SessionData::remove('form');
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
    }

    /**
     * check if there are any articles remaining for the category
     *
     * @return boolean [ if there are any articles for specified category id ]
     */
    private function _verifyRemainingCategoryArticles() {
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

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $numOfArticles = $row['num_of_articles'];

            if ( $numOfArticles > 0 ) {
                $clearedArticlesWithCategory = FALSE;
            }

            break;
        }

        return $clearedArticlesWithCategory;
    }

    /**
     * remove category from the database
     *
     * @return boolean [ response from database query ]
     */
    private function _removeCategoryFromDb() {
        $query = sprintf(
            "DELETE
            FROM
                category_table
            WHERE
                category_id = '%d'",
            $this->id
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}