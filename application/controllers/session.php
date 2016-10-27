<?php

/**
 * session controller
 */
class Session extends Controller {
    protected $_modelName = 'Session';
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
