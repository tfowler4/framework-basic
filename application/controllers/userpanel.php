<?php

/**
 * userpanel controller
 */
class Userpanel extends Controller {
    const CONTROLLER_NAME  = 'Userpanel';
    const PAGE_TITLE       = 'User Panel';
    const PAGE_DESCRIPTION = 'User Panel Description';

    public function __construct() {
        parent::__construct();

    }

    public function index($params = array()) {
        $userpanelModel = $this->_loadModal('userpanel', $params);
        $userpanelModel->loadUserFromSession();

        if ( $userpanelModel->loggedIn ) {
            $this->_loadPageView('userpanel/index', $userpanelModel);
        } else {
            $this->_loadError();
        }
    }
}