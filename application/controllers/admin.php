<?php

/**
 * admin controller
 */
class Admin extends Controller {
    const CONTROLLER_NAME  = 'Admin';
    const PAGE_TITLE       = 'Administration';
    const PAGE_DESCRIPTION = 'Admin Description';

    public function __construct() {
        if ( !SessionData::get('admin') ) {
            redirect('home');
        }

        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    public function index($params = array()) {
        $adminModel = $this->_loadModal('admin', $params);
        $adminModel->getArticles();
        $adminModel->getCategories();

        $this->_loadPageView('admin/index', $adminModel);
    }
}