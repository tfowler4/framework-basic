<?php

/**
 * login controller
 */
class Login extends AbstractController {
    const CONTROLLER_NAME  = 'Login';
    const PAGE_TITLE       = 'Login';
    const PAGE_DESCRIPTION = 'Login Description';

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    /**
     * index page of controller
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        $loginModel = $this->_loadModal('login', $params);

        $this->_loadPageView('login/index', $this->_data);
    }
}