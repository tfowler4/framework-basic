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
                category,
                content
            FROM
                article_table
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
}