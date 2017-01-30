<?php

/**
 * home model
 */
class HomeModel extends Model {
    const MODEL_NAME = 'Home';

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