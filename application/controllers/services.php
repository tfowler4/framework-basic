<?php

/**
 * services controller
 */
class Services extends Controller {
    const CONTROLLER_NAME = 'Services';

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * index page of controller
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        return;
    }

    public function getArticle($params) {
        $article;

        $database = $this->_loadModal('database', '');
        $query    = $database->getArticleById($params[0]);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);
        }

        echo json_encode($article);
    }

    public function getCategory($params) {
        $category;

        $database = $this->_loadModal('database', '');
        $query    = $database->getCategoryById($params[0]);

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
        SessionData::reset();

        $message = array('type' => 'success',  'title' => 'Logout', 'message' => 'You logged out so....bye!');
        SessionData::set('message', $message);
    }
}