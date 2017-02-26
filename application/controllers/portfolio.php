<?php

/**
 * portfolio controller
 */
class Portfolio extends AbstractController {
    const CONTROLLER_NAME  = 'Portfolio';
    const PAGE_TITLE       = 'Portfolio';
    const PAGE_DESCRIPTION = 'Portfilio & Work';

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
        $portfolioModel = $this->_loadModal('portfolio', $params);

        $this->_loadPageView('portfolio/index', $this->_data);
    }
}