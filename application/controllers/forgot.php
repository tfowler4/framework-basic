<?php

/**
 * forgot password controller
 */
class Forgot extends AbstractController {
    const CONTROLLER_NAME  = 'Forgot';
    const PAGE_TITLE       = 'Forgot';
    const PAGE_DESCRIPTION = 'Forgot Password Recovery';

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
        $forgotModel = $this->_loadModal('forgot', $params);

        $this->_loadPageView('forgot/index', $this->_data);
    }

    /**
     * reset password page of controller
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function reset($params = array()) {
        $forgotModel = $this->_loadModal('forgot', $params);

        $this->_data['token'] = $forgotModel->token;

        $isTokenValid = $forgotModel->validateToken();

        if ( $isTokenValid ) {
            $this->_loadPageView('forgot/reset', $this->_data);
        } else {
            $this->_loadPageView('forgot/index', $this->_data);
        }
    }
}