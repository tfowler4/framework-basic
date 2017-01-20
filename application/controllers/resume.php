<?php

/**
 * resume controller
 */
class Resume extends Controller {
    const MODEL_NAME       = 'Resume';
    const PAGE_TITLE       = 'Resume';
    const PAGE_DESCRIPTION = 'Interactive Resume';

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
        $resumeModel = $this->_loadModal(self::MODEL_NAME, $params);

        $this->_loadPageView('index', $resumeModel);
    }
}