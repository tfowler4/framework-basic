<?php

/**
 * home controller
 */
class Home extends AbstractController {
    const CONTROLLER_NAME  = 'Home';
    const PAGE_TITLE       = 'Home';
    const PAGE_DESCRIPTION = 'Home Description';

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
        $homeModel = $this->_loadModal('home');

        $this->_data['articles']   = $homeModel->getArticles(10);
        $this->_data['categories'] = $homeModel->getCategories();
        $this->_data['archives']   = $homeModel->getArchives();

        $this->_loadPageView('home/index', $this->_data);
    }

    /**
     * grid page of controller
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function grid($params = array()) {
        $homeModel = $this->_loadModal('home');

        $this->_data['articles']   = $homeModel->getArticles();
        $this->_data['categories'] = $homeModel->getCategories();

        $this->_loadPageView('home/grid', $this->_data);
    }

    /**
     * list of articles based on category
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function category($params = array()) {
        $homeModel = $this->_loadModal('home');

        $this->_data['articles']   = $homeModel->getArticlesByCategory($params);
        $this->_data['categories'] = $homeModel->getCategories();

        $this->_loadPageView('home/index', $this->_data);
    }
}