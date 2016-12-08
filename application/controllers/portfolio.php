<?php

/**
 * portfolio controller
 */
class Portfolio extends Controller {
    protected $_modelName = 'Portfolio';
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