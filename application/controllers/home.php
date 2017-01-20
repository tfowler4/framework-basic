<?php

/**
 * home controller
 */
class Home extends Controller {
    const MODEL_NAME       = 'Home';
    const PAGE_TITLE       = 'Home';
    const PAGE_DESCRIPTION = 'Home Description';

    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    public function index($params = array()) {
        $homeModel = $this->_loadModal(self::MODEL_NAME, $params);
        $homeModel->getArticles();
        $homeModel->getCategories();

        $this->_loadPageView('index', $homeModel);
    }

    public function grid($params = array()) {
        $homeModel = $this->_loadModal(self::MODEL_NAME, $params);
        $homeModel->getArticles();
        $homeModel->getCategories();

        $this->_loadPageView('grid', $homeModel);
    }
}