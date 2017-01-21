<?php

/**
 * create article form
 */
class CreateArticleForm extends Form {
    public $form;
    public $title;
    public $category;
    public $content;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully created!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while creating your Article!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('title', 'category', 'content'));
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            if ( $this->_insertArticletoDb() && $this->_updateCategoryArticleCount() ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->generateMissingFieldsError($this->form);
        }

        return $response;
    }

    private function _insertArticletoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "INSERT INTO
                article_table (title, category_id, content)
            values
                ('%s', '%d', '%s')",
            $this->title,
            $this->category,
            $this->content
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }

    private function _updateCategoryArticleCount() {
        $dbh = Database::getHandler();

        $updateString        = '';
        $categories          = '';

        $query = sprintf(
            "SELECT
                category_id,
                COUNT(*) AS num_of_articles
            FROM
                article_table
            GROUP BY
                category_id"
        );

        $query = $dbh->query($query);

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

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}