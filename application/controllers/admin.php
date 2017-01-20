<?php

/**
 * admin controller
 */
class Admin extends Controller {
    const MODEL_NAME       = 'Admin';
    const PAGE_TITLE       = 'Administration';
    const PAGE_DESCRIPTION = 'Admin Description';

    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    public function index($params = array()) {
        $adminModel = $this->_loadModal(self::MODEL_NAME, $params);
        $adminModel->getArticles();
        $adminModel->getCategories();

        $this->_loadPageView('index', $adminModel);
    }
}