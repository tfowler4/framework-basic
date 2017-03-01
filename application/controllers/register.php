<?php

/**
 * register controller
 */
class Register extends AbstractController {
    const CONTROLLER_NAME  = 'Register';
    const PAGE_TITLE       = 'Registration';
    const PAGE_DESCRIPTION = 'Register Description';

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
        $registerModel = $this->_loadModal('register', $params);

        $this->_data['forms'] = $registerModel->forms;

        $this->_loadPageView('register/index', $this->_data);
    }
}