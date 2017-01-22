<?php

/**
 * session controller
 */
class Session extends Controller {
    const CONTROLLER_NAME = 'Session';

    public function __construct() {
        parent::__construct();
    }

    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function template($params = array()) {
        if ( !empty($params[0]) ) {
            $_SESSION['template'] = $params[0];
        }
    }
}
