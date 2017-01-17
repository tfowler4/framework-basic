<?php

/**
 * Admin model
 */
class AdminModel extends Model {
    public $categories = array();
    public $articles   = array();
    public $forms;

    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = 'Administration';

        $this->_loadForms();
    }

    protected function _loadForms() {
        $this->forms = new stdClass();
        $this->forms->createArticle  = new CreateArticleForm();
        $this->forms->createCategory = new CreateCategoryForm();
    }

    /**
     * get a list of all article categories from database
     *
     * @return void
     */
    public function getCategories() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "SELECT
                category_id,
                name,
                meta,
                num_of_articles
            FROM
               category_table
            ORDER BY
                name"
        );

        $query = $dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row);

            array_push($this->categories, $category);
        }
    }

    /**
     * get a list of all articles from database
     *
     * @return void
     */
    public function getArticles() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "SELECT
                article_id,
                title,
                content,
                category_table.category_id,
                meta,
                category_table.name as category
            FROM
                article_table
            INNER JOIN
                category_table
            ON
                article_table.category_id = category_table.category_id
            ORDER BY
                date_added DESC"
        );

        $query = $dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);

            array_push($this->articles, $article);
        }
    }
}