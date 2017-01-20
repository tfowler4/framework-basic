<?php

/**
 * example controller
 */
class Example extends Controller {
    const MODEL_NAME       = 'Example';
    const PAGE_TITLE       = 'Example';
    const PAGE_DESCRIPTION = 'Example Test Page';

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
        $exampleModel = $this->_loadModal(self::MODEL_NAME, $params);

        $this->_loadPageView('index', $exampleModel);
    }
}