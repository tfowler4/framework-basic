<?php

use MatthiasMullie\Minify;

/**
 * base controller class
 */
abstract class AbstractController {
    protected $_pageTitle;
    protected $_pageDescription;
    protected $_siteName;
    protected $_controllerName;
    protected $_viewPath = FOLDER_VIEWS;
    protected $_dbh;
    protected $_data = array();
    protected $_params;
    protected $_loadedJSFiles = array();
    protected $_loadedCSSFiles = array();

    public $alert = array(
        'title'   => '',
        'message' => '',
        'type'    => '',
        'active'  => FALSE
    );

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->_dbh = Database::getHandler();
        $this->_setSiteName();

        $currController        = '';
        $this->_controllerName = static::CONTROLLER_NAME;

        if ( !empty(SessionData::get('controller')) ) {
            $currController = SessionData::get('controller');
            SessionData::set('prev_controller', $currController);
        }

        SessionData::set('controller', $this->_controllerName);

        if ( $currController != $this->_controllerName ) {
            SessionData::remove('form');
        }
    }

    /**
     * load a model file
     *
     * @param  string $modalName [ name of model ]
     * @param  string $params    [ parameters for ]
     *
     * @return obj [ model class object ]
     */
    protected function _loadModel($modalName, $params = '') {
        $modalName = strtolower($modalName);
        $modelFile = ucfirst($modalName) . 'Model';

        return new $modelFile($this->_dbh, $params);
    }

    /**
     * load a view file
     *
     * @param  string $view [ name of view file ]
     * @param  string $data [ data to be used in the view ]
     *
     * @return void
     */
    protected function _loadView($view, $data = array()) {
        $viewFile = '';

        if ( !empty($view) ) {
            $view = strtolower($view);
            $viewFile = $this->_viewPath . $view . '.html';
        } else {
            $this->_loadError();
        }

        if ( !file_exists($viewFile) ) {
            return;
        }

        $moduleFolder = explode('/', $view)[0];

        extract((array)$data);

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_start('ob_gzhandler');
        }

        include strtolower($viewFile);

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_end_flush();
        }

        // load view js/css if exist
        $this->_loadJS($moduleFolder);
        $this->_loadCSS($moduleFolder);
    }

    /**
     * load all javascript files associated with the controller page
     *
     * @return void
     */
    protected function _loadJS($folder = '') {
        $jsFilePath = FOLDER_JS . '*.js';

        // only load from preferred folder
        if ( !empty($folder) ) {
            $jsFilePath = FOLDER_JS . 'modules/' . $folder . '/*.js';

            foreach(glob($jsFilePath) as $file) {
                if ( in_array($file, $this->_loadedJSFiles) ) {
                    continue;
                }

                $this->_loadedJSFiles[] = $file;

                $filePath = SITE_JS . 'modules/' . $folder . '/' . basename($file) . '?v=' . TIMESTAMP;
                $absFile  = ABS_BASE_PATH . '/public/js/modules/' . $folder . '/' . basename($file);

                echo '<script src="' . $file . '"></script>' . "\n";
            }

            return;
        }

        // load global JS files
        foreach(glob($jsFilePath) as $file) {
            if ( in_array($file, $this->_loadedJSFiles) ) {
                continue;
            }

            $this->_loadedJSFiles[] = $file;

            $filePath = SITE_JS . basename($file) . '?v=' . TIMESTAMP;
            $absFile  = ABS_BASE_PATH . '/public/js/' . basename($file);

            echo '<script src="' . $filePath . '"></script>' . "\n";
        }

        // load controller JS files
        if ( !empty($this->_controllerName) ) {
            $jsFilePath = FOLDER_JS . 'modules/' . strtolower($this->_controllerName) . '/*.js';

            foreach(glob($jsFilePath) as $file) {
                if ( in_array($file, $this->_loadedJSFiles) ) {
                    continue;
                }

                $this->_loadedJSFiles[] = $file;

                $filePath = SITE_JS . 'modules/' . strtolower($this->_controllerName) . '/' . basename($file) . '?v=' . TIMESTAMP;
                $absFile  = ABS_BASE_PATH . '/public/js/modules/' . strtolower($this->_controllerName)  . '/' . basename($file);

                echo '<script src="' . $file . '"></script>' . "\n";
            }
        }
    }

    /**
     * load all css files associated with the controller page
     *
     * @return void
     */
    protected function _loadCSS($folder = '') {
        $cssFilePath = FOLDER_CSS . '*.css';

        // only load from preferred folder
        if ( !empty($folder) ) {
            $cssFilePath = FOLDER_CSS . 'modules/' . $folder . '/*.css';

            foreach(glob($cssFilePath) as $file) {
                if ( in_array($file, $this->_loadedCSSFiles) ) {
                    continue;
                }

                $this->_loadedCSSFiles[] = $file;

                $filePath = SITE_CSS . 'modules/' . $folder . '/' .basename($file) . '?v=' . TIMESTAMP;
                $absFile  = ABS_BASE_PATH . '/public/css/modules/' . $folder  . '/' . basename($file);

                echo '<link rel="stylesheet" type="text/css" href="' . $filePath  . '">' . "\n";
            }

            return;
        }

        // load global CSS file
        foreach(glob($cssFilePath) as $file) {
            if ( in_array($file, $this->_loadedCSSFiles) ) {
                continue;
            }

            $this->_loadedCSSFiles[] = $file;

            $filePath = SITE_CSS . basename($file) . '?v=' . TIMESTAMP;
            $absFile  = ABS_BASE_PATH . '/public/css/' . basename($file);

            echo '<link rel="stylesheet" type="text/css" href="' . $filePath  . '">' . "\n";
        }

        if ( !empty($this->_controllerName) ) {
            $filePath = FOLDER_CSS . 'modules/' . strtolower($this->_controllerName) . '/*';

            foreach(glob($filePath) as $file) {
                if ( in_array($file, $this->_loadedCSSFiles) ) {
                    continue;
                }

                $this->_loadedCSSFiles[] = $file;

                $filePath = SITE_CSS . 'modules/' . strtolower($this->_controllerName) . '/' . basename($file) . '?v=' . TIMESTAMP;
                $absFile  = ABS_BASE_PATH . '/public/css/modules/' . strtolower($this->_controllerName)  . '/' . basename($file);

                echo '<link rel="stylesheet" type="text/css" href="' . $filePath  . '">' . "\n";
            }
        }
    }

    /**
     * load a HTML file
     *
     * @param  string $filePath [ path of html file ]
     *
     * @return void
     */
    protected function _loadFile($filePath) {
        if ( file_exists($filePath) ) {
            include $filePath;
        }
    }

    /**
     * redirect to error page
     *
     * @return void
     */
    protected function _loadError() {
        redirect(SITE_URL . 'error');
    }

    /**
     * load the header page
     *
     * @return void
     */
    protected function _loadHeader() {
        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_start('ob_gzhandler');
        }

        $this->_loadView('header/index', $this->_data);

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_end_flush();
        }
    }

    /**
     * load the footer page
     *
     * @return void
     */
    protected function _loadFooter() {
        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_start('ob_gzhandler');
        }

        $this->_loadView('footer/index', $this->_data);

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_end_flush();
        }
    }

    /**
     * load entire page view with header, footer, and content view
     *
     * @param  string $view  [ name of view ]
     * @param  obj    $model [ model file ]
     *
     * @return void
     */
    protected function _loadPageView($view, $model) {
        $this->_data['alert']       = $this->alert;

        // Begin Compression
        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_start('ob_gzhandler');
        }

        // load header
        $this->_loadHeader();

        // load main content
        $this->_loadView($view, $model);

        // load footer
        //$this->_loadFooter();

        if ( defined('SERVER"') && SERVER == 'live' ) {
            ob_end_flush();
        }
    }

    /**
     * set name of web application site
     *
     * @return void
     */
    protected function _setSiteName() {
        if ( defined('SITE_NAME') && !empty(SITE_NAME) ) {
            $this->_siteName = SITE_NAME;
        } else {
            $this->_siteName = 'Unnamed Site';
        }
    }

    /**
     * set title of page
     *
     * @return void
     */
    protected function _setPageTitle($pageTitle = '') {
        if ( defined('static::PAGE_TITLE') && !empty(static::PAGE_TITLE) ) {
            $this->_pageTitle = static::PAGE_TITLE;
        } else {
            $this->_pageTitle = 'No Title Set';
        }

        if ( !empty($pageTitle) ) {
            $this->_pageTitle = $pageTitle;
        }

        $this->_pageTitle = $this->_pageTitle . ' | ' . $this->_siteName;
    }

    /**
     * set description of page
     *
     * @return void
     */
    protected function _setPageDescription($pageDescription = '') {
        if ( defined('static::PAGE_DESCRIPTION') && !empty(static::PAGE_DESCRIPTION) ) {
            $this->_pageDescription = static::PAGE_DESCRIPTION;
        } else {
            $this->_pageDescription = 'No Description Set';
        }

        if ( !empty($pageDescription) ) {
            $this->_pageDescription = $pageDescription;
        }
    }

    /**
     * set url parameters
     *
     * @return void
     */
    protected function _setParameters($params) {
        if ( !empty($params) ) {
            foreach ( $params as $index => $param ) {
                $params[$index] = urldecode($param);
            }
        }

        $this->_params = $params;
    }
}