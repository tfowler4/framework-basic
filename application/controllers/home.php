<?php

/**
 * home controller
 */
class Home extends AbstractController {
    const CONTROLLER_NAME  = 'Home';
    const PAGE_TITLE       = 'Home';
    const PAGE_DESCRIPTION = 'Home Description';

    public function __construct($params) {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setPageDescription(META_DESCRIPTION);
        $this->_setParameters($params);
    }

    public function index() {
        $this->_loadView('header/index', $this->_data);
        $this->_loadView('home/index', $this->_data);
    }
}