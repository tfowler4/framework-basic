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
        $this->forms->editArticle    = new EditArticleForm();
        $this->forms->editCategory   = new EditCategoryForm();
        $this->forms->removeCategory = new RemoveCategoryForm();
        $this->forms->removeArticle  = new RemoveArticleForm();
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
                num_of_articles,
                date_added,
                last_modified
            FROM
               category_table
            ORDER BY
                name DESC"
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
                category_table.name as category,
                article_table.date_added as date_added,
                article_table.last_modified as last_modified
            FROM
                article_table
            INNER JOIN
                category_table
            ON
                article_table.category_id = category_table.category_id
            ORDER BY
                article_table.date_added DESC"
        );

        $query = $dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);

            array_push($this->articles, $article);
        }
    }
}