<?php

/**
 * create article form
 */
class CreateArticleForm extends Form implements FormInterface {
    public $form;
    public $title;
    public $category;
    public $content;

    const FORM_NAME       = 'create-article';
    const SUCCESS_GENERIC = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully created!');
    const ERROR_GENERIC   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while creating your Article!');

    /**
     * constructor
     *
     * @param obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->_setFieldRequired(array('title', 'category', 'content'));
        $this->_setRepopulateFields(array('title', 'category', 'content'));

        $this->populateForm();
    }

    /**
     * populate the form with values in POST or SESSION
     *
     * @return void
     */
    public function populateForm() {
        $this->form     = $this->_populateField('form');
        $this->title    = $this->_populateField('title');
        $this->category = $this->_populateField('category');
        $this->content  = $this->_populateField('content');
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

        if ( $this->_insertArticletoDb() && $this->_updateCategoryArticleCount() ) {
            SessionData::remove('form');
            return self::SUCCESS_GENERIC;
        } else {
            return self::ERROR_GENERIC;
        }
    }

    /**
     * insert article into the database
     *
     * @return boolean [ query success or failure ]
     */
    private function _insertArticletoDb() {
        $query = sprintf(
            "INSERT INTO
                article_table (title, category_id, content, date_added, last_modified)
            values
                ('%s', '%d', '%s', null, null)",
            $this->title,
            $this->category,
            $this->content
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }

    /**
     * update the number of articles per category in the database
     *
     * @return boolean [ query success or failure ]
     */
    private function _updateCategoryArticleCount() {
        $updateString = '';
        $categories   = '';

        $query = sprintf(
            "SELECT
                category_id,
                COUNT(*) AS num_of_articles
            FROM
                article_table
            GROUP BY
                category_id"
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $categoryId    = $row['category_id'];
            $numOfArticles = $row['num_of_articles'];

            $updateString .= ' WHEN ' . $categoryId . ' THEN ' . $numOfArticles . ' ';

            if ( !empty($categories) ) {
                $categories .= ',';
            }

            $categories .= $categoryId;
        }

        $query = sprintf(
            "UPDATE
                category_table
            SET
                num_of_articles = CASE category_id %s END
            WHERE
                category_id IN (%s)",
            $updateString,
            $categories
        );

        $query = $this->_dbh->prepare($query);

        return $query->execute();
    }
}