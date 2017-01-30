<?php

/**
 * example controller
 */
class Example extends Controller {
    const CONTROLLER_NAME  = 'Example';
    const PAGE_TITLE       = 'Example';
    const PAGE_DESCRIPTION = 'Example Test Page';

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
        $exampleModel = $this->_loadModal('example', $params);

        $this->_loadPageView('example/index', $this->_data);
    }
}