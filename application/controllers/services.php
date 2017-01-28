<?php

/**
 * services controller
 */
class Services extends Controller {
    const CONTROLLER_NAME = 'Services';

    public function __construct() {
        parent::__construct();
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
                icon,
                color_1,
                num_of_articles,
                date_added,
                last_modified
            FROM
                category_table
            WHERE
                category_id = '%d'",
            $params[0]
        );

        $query = $this->_dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row);
        }

        echo json_encode($category);
    }

    public function getLoginForm() {
        ob_start();
        $this->_loadView('login/login-form');

        $data['title'] = 'Login';
        $data['body']  = ob_get_clean();

        echo json_encode($data);
    }

    public function getLogoutForm() {
        ob_start();
        $this->_loadView('logout/logout-form');

        $data['title'] = 'Logout';
        $data['body']  = ob_get_clean();

        echo json_encode($data);
    }

    public function logoutUser() {
        SessionData::set('login', FALSE);
        SessionData::remove('user');
        SessionData::remove('admin');

        $message = array('type' => 'success',  'title' => 'Logout',   'message' => 'You logged out so....bye!');
        SessionData::set('message', $message);
    }
}