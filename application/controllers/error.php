<?php

/**
 * Error controller
 */
class Error extends Controller {
    const CONTROLLER_NAME  = 'Error';
    const PAGE_TITLE       = 'Error';
    const PAGE_DESCRIPTION = 'An Error Page';

    public function __construct() {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription();
    }

    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        $errorModel = $this->_loadModal('error', $params);

        $this->_loadPageView('error/index', $errorModel);
    }
}