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

            array_push($this->content, $article);
        }
    }
}