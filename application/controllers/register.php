<?php

/**
 * register controller
 */
class Register extends Controller {
    const CONTROLLER_NAME  = 'Register';
    const PAGE_TITLE       = 'Registration';
    const PAGE_DESCRIPTION = 'Register Description';

    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    public function index($params = array()) {
        $registerModel = $this->_loadModal('register', $params);

        $this->_loadPageView('register/index', $registerModel);
    }
}