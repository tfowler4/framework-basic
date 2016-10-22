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
        $this->_view('index', $this->_model($this->_modelName, $params));
    }

    public function grid($params = array()) {
        $this->_view('grid', $this->_model($this->_modelName, $params));
    }
}