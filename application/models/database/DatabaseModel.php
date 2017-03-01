<?php

/**
 * database model
 */
class DatabaseModel extends AbstractModel {
    const MODEL_NAME = 'Database';

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
     * get a list of all categories from database
     *
     * @return obj [ database query results ]
     */
    public function getAllCategories() {
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
                name ASC"
        );

        return $this->_dbh->query($query);
    }

    /**
     * get a list of all articles from database
     *
     * @return obj [ database query results ]
     */
    public function getAllArticles($limit = '') {
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

        if ( !empty($limit) ) {
            $query .= ' LIMIT ' . $limit;
        }

        return $this->_dbh->query($query);
    }

    /**
     * get an article from the database by article id
     *
     * @param  integer $articleId [ id of article ]
     *
     * @return obj [ database query results ]
     */
    public function getArticleById($articleId) {
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
            WHERE
                article_id = '%d'",
            $articleId
        );

        return $this->_dbh->query($query);
    }

    /**
     * get a list of articles by category
     *
     * @param  integer $articleId [ id of article ]
     *
     * @return obj [ database query results ]
     */
    public function getArticlesByCategory($category) {
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
            WHERE
                category_table.name = '%s'",
            $category
        );

        return $this->_dbh->query($query);
    }

    /**
     * get a category from the database by category id
     *
     * @param  integer $categoryId [ id of category ]
     *
     * @return obj [ database query results ]
     */
    public function getCategoryById($categoryId) {
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
            WHERE
                category_id = '%d'",
            $categoryId
        );

        return $this->_dbh->query($query);
    }
}