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
        $this->_view('index', $this->_model($this->_modelName, $params));
    }
}