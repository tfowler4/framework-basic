<?php

/**
 * main application class
 */
class App {
    protected $_controller = 'home';
    protected $_method     = 'index';
    protected $_params     = array();

    /**
     * constructor
     */
    public function __construct() {
        $url  = $this->_parseURL();
        $file = ABS_BASE_PATH . 'application/controllers/' . $url[0] . '.php';

        if ( file_exists($file) ) {
            $this->_controller = $url[0];
            unset($url[0]);
        }

        // load config
        $this->_loadAppConfig();

        // load the new controller
        $this->_controller = new $this->_controller;

        if ( isset($url[0]) ) {
            if ( method_exists($this->_controller, $url[0]) ) {
                $this->_method = $url[0];
                unset($url[0]);
            }
        }

        $this->_params = $url ? array_values($url) : array();

        call_user_func_array( array($this->_controller, $this->_method), array($this->_params));
    }

    /**
     * parses the url string into an array
     *
     * @return array [ array of url parameters split by '/' ]
     */
    private function _parseURL() {
        if ( isset($_GET['url']) ) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL) );
        }
    }

    /**
     * load configuration file
     *
     * @return void
     */
    private function _loadAppConfig() {
        new Config();
    }
}