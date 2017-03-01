<?php

/**
 * error controller
 */
class Error extends AbstractController {
    const CONTROLLER_NAME  = 'Error';
    const PAGE_TITLE       = 'Error';
    const PAGE_DESCRIPTION = 'An Error Page';

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
        $errorModel = $this->_loadModal('error', $params);

        $this->_loadPageView('error/index', $this->_data);
    }
}