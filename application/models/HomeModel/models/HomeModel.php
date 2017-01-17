<?php

/**
 * home model
 */
class HomeModel extends Model {
    public $content = array();

    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();

        $this->pageTitle = 'Home';
    }

    /**
     * get a list of all article categories from database
     *
     * @return void
     */
    public function getArticles() {
        $dbh = Database::getHandler();

        $query = $dbh->query(sprintf(
            "SELECT article_id,
                    title,
                    category,
                    content
               FROM article_table"
        ));

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);

            array_push($this->content, $article);
        }
    }
}