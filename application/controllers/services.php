<?php

/**
 * services controller
 */
class Services extends AbstractController {
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

    /**
     * get a specific article by article id
     *
     * @param  array $params [ array containing article id ]
     *
     * @return void
     *
     */
    public function getArticle($params) {
        $article;

        $database = $this->_loadModal('database', '');
        $query    = $database->getArticleById($params[0]);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);
        }

        echo json_encode($article);
    }

    /**
     * get a specific category by category id
     *
     * @param  array $params [ array containing category id ]
     *
     * @return void
     *
     */
    public function getCategory($params) {
        $category;

        $database = $this->_loadModal('database', '');
        $query    = $database->getCategoryById($params[0]);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row);
        }

        echo json_encode($category);
    }

    /**
     * get the html for a the login form
     *
     * @return void
     */
    public function getLoginForm() {
        ob_start();
        $this->_loadView('login/login-form');

        $data['title'] = 'Login';
        $data['body']  = ob_get_clean();

        echo json_encode($data);
    }

    /**
     * get the html for a the logout form
     *
     * @return void
     */
    public function getLogoutForm() {
        ob_start();
        $this->_loadView('logout/logout-form');

        $data['title'] = 'Logout';
        $data['body']  = ob_get_clean();

        echo json_encode($data);
    }

    /**
     * get the html for a the deactivate account form
     *
     * @return void
     */
    public function getDeactivationForm() {
        ob_start();
        $this->_loadView('userpanel/deactivate-form');

        $data['title'] = 'Confirm Account Deactivation';
        $data['body']  = ob_get_clean();

        echo json_encode($data);
    }

    /**
     * logout the user and reset the session data
     *
     * @return void
     */
    public function logoutUser() {
        SessionData::reset();

        $message = array('type' => 'success',  'title' => 'Logout', 'message' => 'You logged out successfully!');
        SessionData::set('message', $message);
    }

    /**
     * run the site maintenance script
     *
     * @param  array $params [ array containing parameters to execute wit hthe script ]
     *
     * @return void
     */
    public function runScript($params) {
        $scriptName = $params[0];

        include FOLDER_SCRIPTS . $scriptName . '.php';
    }
}