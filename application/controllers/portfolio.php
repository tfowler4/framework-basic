<?php

/**
 * portfolio controller
 */
class Portfolio extends Controller {
    const CONTROLLER_NAME  = 'Portfolio';
    const PAGE_TITLE       = 'Portfolio';
    const PAGE_DESCRIPTION = 'Portfilio & Work';

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
        $portfolioModel = $this->_loadModal('portfolio', $params);

        $this->_loadPageView('portfolio/index', $portfolioModel);
    }
}