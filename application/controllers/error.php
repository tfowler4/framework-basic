<?php

/**
 * Error controller
 */
class Error extends Controller {
    protected $_modelName = 'Error';
    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        $errorModel = $this->_model($this->_modelName, $params);

        $this->_view('index', $errorModel);
    }
}