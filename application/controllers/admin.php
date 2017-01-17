<?php

/**
 * admin controller
 */
class Admin extends Controller {
    protected $_modelName = 'Admin';
    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        $adminModel = $this->_model($this->_modelName, $params);
        $adminModel->getArticles();
        $adminModel->getCategories();

        $this->_view('index', $adminModel);
    }
}