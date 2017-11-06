<?php

/**
 * main application class
 */
class App {
    protected $_controller = 'home';
    protected $_method     = 'index';
    protected $_params     = array();

    public function __construct() {
        $url  = $this->_parseURL();
        $file = ABS_BASE_PATH . 'application/controllers/' . $url[0] . '.php';

        if ( file_exists($file) ) {
            $this->_controller = $url[0];
            array_splice($url, 0, 1);
        }

        // set parameters from url
        $this->_params = $url ? array_values($url) : array();

        // load the new controller
        $this->_controller = new $this->_controller($this->_params);

        if ( !empty($url[0]) ) {
            if ( method_exists($this->_controller, $url[0]) ) {
                $this->_method = $url[0];
                array_splice($url, 0, 1);
            }
        }

        call_user_func_array( array($this->_controller, $this->_method), array());
    }

    private function _parseURL() {
        if ( isset($_GET['url']) ) {
            return explode('/', filter_var(rtrim($_GET['url'], '/')) ); //FILTER_SANITIZE_URL
        }
    }
}