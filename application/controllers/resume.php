<?php

/**
 * resume controller
 */
class Resume extends AbstractController {
    const CONTROLLER_NAME  = 'Resume';
    const PAGE_TITLE       = 'Resume';
    const PAGE_DESCRIPTION = 'Interactive Resume';

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
        $resumeModel = $this->_loadModal('resume', $params);

        $this->_loadPageView('resume/index', $this->_data);
    }
}