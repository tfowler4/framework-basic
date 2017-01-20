<?php

/**
 * Error controller
 */
class Error extends Controller {
    const MODEL_NAME       = 'Error';
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
        $errorModel = $this->_loadModal(self::MODEL_NAME, $params);

        $this->_loadPageView('index', $errorModel);
    }
}