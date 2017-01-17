<?php

/**
 * home controller
 */
class Home extends Controller {
    protected $_modelName = 'Home';
    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        $homeModel = $this->_model($this->_modelName, $params);
        $homeModel->getArticles();

        $this->_view('index', $homeModel);
    }

    public function grid($params = array()) {
        $homeModel = $this->_model($this->_modelName, $params);
        $homeModel->getArticles();

        $this->_view('grid', $homeModel);
    }
}