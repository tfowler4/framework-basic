<?php

class Constants {
    /**
     * constructor
     */
    public function __construct() {
        // site details
        define('SITE_NAME', 'Framework Basic');
        define('SITE_URL',  'http://localhost/framework-basic');
        define('SITE_STATUS', 1);
        define('APP_NAME', 'framework-basic');

        // paths
        if ( strpos($_SERVER['DOCUMENT_ROOT'], 'htdocs') !== FALSE ) {
            define('ABS_BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/' . APP_NAME . '/');
        } else {
            define('ABS_BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
        }


        // modules
        define('MODULE_HOME_STATUS', 1);
        define('MODULE_EXAMPLE_SET', 1);

        // database settings
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'xeonsold_framework_test');
        define('DB_USER', 'root');
        define('DB_PASS', '');

        $this->_loadSiteNavigation();
    }

    private function _loadSiteNavigation() {
        $navigationArray = array();

        // Biography
        $navItem = array('title' => 'Bio', 'model' => 'Bio', 'link' => '', 'icon' => 'glyphicon glyphicon-user', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Resume
        $navItem = array('title' => 'Resume', 'model' => 'Resume', 'link' => '', 'icon' => 'fa fa-file-pdf-o', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Portfolio
        $navItem = array('title' => 'Portfolio', 'model' => 'Portfolio', 'link' => '', 'icon' => 'fa fa-file-text', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Example Page
        $navItem = array('title' => 'Example', 'model' => 'Example', 'link' => '', 'icon' => 'fa fa-info-circle', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Github
        $navItem = array('title' => 'GitHub', 'model' => ' ', 'link' => 'http://www.github.com/tfowler4', 'icon' => 'fa fa-github-alt', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // navigation
        define('NAV', serialize($navigationArray));
    }
}

new Constants();