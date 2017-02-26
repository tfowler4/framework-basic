<?php

/**
 * home model
 */
class HomeModel extends AbstractModel {
    const MODEL_NAME = 'Home';

    /**
     * constructor
     *
     * @param obj   $dbh    [ database handler ]
     * @param array $params [ parameters sent by the url ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);
    }

    /**
     * get a list of all articles from database
     *
     * @return void
     */
    public function getArticles($limit = '') {
        $articles = array();
        $database = new DatabaseModel($this->_dbh);
        $query;

        if ( !empty($limit) && is_numeric($limit) && $limit > 0 ) {
            $query = $database->getAllArticles($limit);
        } else {
            $query = $database->getAllArticles();
        }

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);

            array_push($articles, $article);
        }

        return $articles;
    }

    /**
     * get latest 10 archives
     *
     * @return void
     */
    public function getArchives() {
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
     * get a list of all articles by category from database
     *
     * @return void
     */
    public function getArticlesByCategory($category = '') {
        $articles = array();
        $database = new DatabaseModel($this->_dbh);
        $query;

        if ( empty($category) ) {
            $query = $database->getAllArticles();
        } else {
            $query = $database->getArticlesByCategory($category[0]);
        }

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