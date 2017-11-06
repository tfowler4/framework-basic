<?php

/**
 * example controller
 */
class Example extends AbstractController {
    const CONTROLLER_NAME  = 'Example';
    const PAGE_TITLE       = 'Example Title';
    const PAGE_DESCRIPTION = 'Example Description';

    public function __construct($params) {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription(META_DESCRIPTION);
        $this->_setParameters($params);
    }

    public function index() {
        /*
            default page for controller
         */
        $this->_loadPageView('example/index', $this->_data);
    }
}