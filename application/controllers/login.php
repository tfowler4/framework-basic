<?php

/**
 * login controller
 */
class Login extends Controller {
    const CONTROLLER_NAME  = 'Login';
    const PAGE_TITLE       = 'Login';
    const PAGE_DESCRIPTION = 'Login Description';

    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    public function index($params = array()) {
        $loginModel = $this->_loadModal('login', $params);

        $this->_loadPageView('login/index', $loginModel);
    }
}