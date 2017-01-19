<?php

/**
 * admin controller
 */
class Admin extends Controller {
    protected $_modelName = 'Admin';

    const PAGE_TITLE       = 'Administration';
    const PAGE_DESCRIPTION = 'Admin Description';

    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    public function index($params = array()) {
        $adminModel = $this->_loadModal($this->_modelName, $params);
        $adminModel->getArticles();
        $adminModel->getCategories();

        $this->_loadPageView('index', $adminModel);
    }

    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    /*
    public function index($params = array()) {
        $adminModel = $this->_model($this->_modelName, $params);
        $adminModel->getArticles();
        $adminModel->getCategories();

        $this->_view('index', $adminModel);
    }
    */
}