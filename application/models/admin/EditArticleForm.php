<?php

/**
 * edit article form
 */
class EditArticleForm extends Form {
    public $id;
    public $form;
    public $title;
    public $category;
    public $content;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully saved!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while saving your Article!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('id', 'title', 'category', 'content'));
    }

    public function submitForm() {
        $response = parent::MESSAGE_GENERIC;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            if ( $this->_updateArticletoDb() && $this->_updateCategoryArticleCount() ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = $this->generateMissingFieldsError($this->form);
        }

        return $response;
    }

    private function _updateArticletoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "UPDATE
                article_table
            SET
                title = '%s',
                category_id = '%d',
                content = '%s'
            WHERE
                article_id='%d'",
            $this->title,
            $this->category,
            $this->content,
            $this->id
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