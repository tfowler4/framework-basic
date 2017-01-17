<?php

/**
 * services controller
 */
class Services extends Controller {
    protected $_modelName = 'Service';
    protected $_dbh;

    public function __construct() {
        $this->_dbh = Database::getHandler();
    }

    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        return;
    }

    public function getArticle($params = array()) {
        $article;

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
            WHERE
                article_id=%d",
            $params[0]
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);
        }

        echo json_encode($article);
    }

    public function getCategory($params = array()) {
        $category;

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
            WHERE
                category_id=%d",
            $params[0]
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row);
        }

        echo json_encode($category);
    }
}