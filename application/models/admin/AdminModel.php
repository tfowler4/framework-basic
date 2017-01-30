<?php

/**
 * administration model
 */
class AdminModel extends Model {
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
     * get a list of all articles from database
     *
     * @return void
     */
    public function getArticles() {
        $articles = array();
        $database = new DatabaseModel($this->_dbh);
        $query    = $database->getAllArticles();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);

            array_push($articles, $article);
        }

        return $articles;
    }

    /**
     * get a list of all article categories from database
     *
     * @return void
     */
    public function getCategories() {
        $categories = array();
        $database   = new DatabaseModel($this->_dbh);
        $query      = $database->getAllCategories();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row);

            array_push($categories, $category);
        }

        return $categories;
    }
}