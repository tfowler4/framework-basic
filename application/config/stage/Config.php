<?php

/**
 * app configuration class
 */
class Config {
    /**
     * constructor
     */
    public function __construct() {
        // site details
        define('SITE_NAME', 'Framework Basic');
        define('APP_NAME',  'framework-basic');
        define('SITE_URL',  'http://framework-basic.topofrift.com/');
        define('SITE_STATUS', 1);
        define('TIMESTAMP', rand(0,100000000));

        // template
        if ( empty($_SESSION['template']) ) {
            define('SITE_TEMPLATE', 'default');
        } else {
            define('SITE_TEMPLATE', $_SESSION['template']);
        }

        // paths
        define('ABS_BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

        define('FOLDER_VIEWS',       ABS_BASE_PATH . 'application/views/');
        define('FOLDER_CONTROLLERS', ABS_BASE_PATH . 'application/controllers/');
        define('FOLDER_MODELS',      ABS_BASE_PATH . 'application/models/');
        define('FOLDER_TEMPLATES',   ABS_BASE_PATH . 'public/templates/');
        define('FOLDER_JS',          ABS_BASE_PATH . 'public/js/');
        define('FOLDER_CSS',         ABS_BASE_PATH . 'public/css/');

        define('SITE_JS',  SITE_URL . 'public/js/');
        define('SITE_CSS', SITE_URL . 'public/css/');

        // modules
        define('MODULE_HOME_STATUS', 1);
        define('MODULE_EXAMPLE_SET', 1);

        // database settings
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'xeonsold_framework_test');
        define('DB_USER', 'xeonsold_test');
        define('DB_PASS', 'test74108520');

        $this->_loadSiteNavigation();
        $this->_loadDb();
    }

    private function _loadDb() {
        Database::init(DB_USER, DB_PASS, DB_NAME, DB_HOST);
    }
}

new Config();

SessionData::start();