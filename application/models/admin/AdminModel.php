<?php

/**
 * administration model
 */
class AdminModel extends Model {
    public $articles   = array();
    public $categories = array();

    const MODEL_NAME = 'Admin';

    /**
     * constructor
     *
     * @param obj   $dbh    [ database handler ]
     * @param array $params [ parameters sent by the url ]
     *
     * @return void
     */
    public function __construct($dbh, $params) {
        parent::__construct($dbh);

        $this->_loadForms();
    }

    /**
     * load all forms associated with model
     *
     * @return void
     */
    protected function _loadForms() {
        $this->forms = new stdClass();
        $this->forms->createArticle  = new CreateArticleForm($this->_dbh);
        $this->forms->createCategory = new CreateCategoryForm($this->_dbh);
        $this->forms->editArticle    = new EditArticleForm($this->_dbh);
        $this->forms->editCategory   = new EditCategoryForm($this->_dbh);
        $this->forms->removeCategory = new RemoveCategoryForm($this->_dbh);
        $this->forms->removeArticle  = new RemoveArticleForm($this->_dbh);

        foreach ( $this->forms as $form ) {
            $form->repopulateForm($form);
        }
    }

    /**
     * get a list of all categories from database
     *
     * @return void
     */
    public function getCategories() {
        $query = sprintf(
            "SELECT
                category_id,
                name,
                meta,
                icon,
                color_1,
                num_of_articles,
                date_added,
                last_modified
            FROM
               category_table
            ORDER BY
                name DESC"
        );

        $query = $this->_dbh->query($query);

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
        $query = sprintf(
            "SELECT
                article_id,
                title,
                content,
                category_table.category_id,
                meta,
                category_table.name as category,
                article_table.date_added as date_added,
                article_table.last_modified as last_modified,
                category_table.color_1,
                category_table.icon
            FROM
                article_table
            INNER JOIN
                category_table
            ON
                article_table.category_id = category_table.category_id
            ORDER BY
                article_table.date_added DESC"
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);

            array_push($this->articles, $article);
        }
    }
}