<?php

/**
 * constants defining class
 */
class Constants {
    /**
     * constructor
     */
    public function __construct() {
        // site details
        define('SITE_NAME', 'Framework Basic');
        define('SITE_STATUS', 1);
        define('APP_NAME', 'framework-basic');

        // template
        if ( empty($_SESSION['template']) ) {
            define('SITE_TEMPLATE', 'default');
        } else {
            define('SITE_TEMPLATE', $_SESSION['template']);
        }

        // paths
        if ( strpos($_SERVER['DOCUMENT_ROOT'], 'htdocs') !== FALSE ) {
            define('SITE_URL',  'http://localhost/framework-basic/');
            define('ABS_BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/' . APP_NAME . '/');
        } else {
            define('SITE_URL',  'http://framework-basic.topofrift.com/');
            define('ABS_BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
        }


        // modules
        define('MODULE_HOME_STATUS', 1);
        define('MODULE_EXAMPLE_SET', 1);

        // database settings
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'xeonsold_framework_test');
        define('DB_USER', 'xeonsold_test');
        define('DB_PASS', 'test74108520');

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
