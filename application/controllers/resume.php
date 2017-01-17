<?php

/**
 * resume controller
 */
class Resume extends Controller {
    protected $_modelName = 'Resume';
    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        $resumeModel = $this->_model($this->_modelName, $params);

        $this->_view('index', $resumeModel);
    }
}