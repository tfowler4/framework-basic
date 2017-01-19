<?php

/**
 * home controller
 */
class Home extends Controller {
    protected $_modelName = 'Home';

    const PAGE_TITLE       = 'Home';
    const PAGE_DESCRIPTION = 'Home Description';

    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    public function index($params = array()) {
        $homeModel = $this->_loadModal($this->_modelName, $params);
        $homeModel->getArticles();
        $homeModel->getCategories();

        $this->_loadPageView('index', $homeModel);
    }

    public function grid($params = array()) {
        $homeModel = $this->_loadModal($this->_modelName, $params);
        $homeModel->getArticles();
        $homeModel->getCategories();

        $this->_loadPageView('grid', $homeModel);
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
        $homeModel = $this->_model($this->_modelName, $params);

        $this->_view('index', $homeModel);
    }
    */
}