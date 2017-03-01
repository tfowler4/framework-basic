<?php

/**
 * admin controller
 */
class Admin extends AbstractController {
    const CONTROLLER_NAME  = 'Admin';
    const PAGE_TITLE       = 'Administration';
    const PAGE_DESCRIPTION = 'Admin Description';

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        if ( !SessionData::get('admin') ) {
            redirect('home');
        }

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
        $adminModel = $this->_loadModal('admin', $params);

        $this->_data['articles']   = $adminModel->getArticles();
        $this->_data['categories'] = $adminModel->getCategories();
        $this->_data['forms']      = $adminModel->forms;
        $this->_data['scripts']    = $adminModel->getScripts();

        $this->_loadPageView('admin/index', $this->_data);
    }
}