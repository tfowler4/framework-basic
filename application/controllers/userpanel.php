<?php

/**
 * userpanel controller
 */
class Userpanel extends AbstractController {
    const CONTROLLER_NAME  = 'Userpanel';
    const PAGE_TITLE       = 'User Panel';
    const PAGE_DESCRIPTION = 'User Panel Description';

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
        $userpanelModel = $this->_loadModal('userpanel', $params);

        $this->_data['user'] = $userpanelModel->loadUserFromSession();

        if ( $this->_data['user'] != NULL ) {
            $this->_loadPageView('userpanel/index', $this->_data);
        } else {
            redirect(SITE_URL);
        }
    }
}