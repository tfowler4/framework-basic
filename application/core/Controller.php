<?php

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
    protected $_breadCrumbs = array();

    public $alert;

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
    protected function _loadModal($modalName, $params = '') {
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
            $this->_loadError();
        }

        extract((array)$data);

        include strtolower($viewFile);
    }

    /**
     * load all javascript files associated with the controller page
     *
     * @return void
     */
    protected function _loadJS() {
        // load global JS files
        $filePath = FOLDER_JS . '*.js';

        foreach(glob($filePath) as $file) {
            $file = SITE_JS . basename($file) . '?v=' . TIMESTAMP;
            echo '<script src="' . $file . '"></script>';
        }

        // load site settings into javascript
        echo '<script>global.loadSitePaths("' . SITE_URL . '", "' . ABS_BASE_PATH . '");</script>';

        // load controller JS files
        if ( !empty($this->_controllerName) ) {
            $filePath = FOLDER_JS . 'modules/' . strtolower($this->_controllerName) . '/*.js';

            foreach(glob($filePath) as $file) {
                $file = SITE_JS . 'modules/' . strtolower($this->_controllerName) . '/' . basename($file) . '?v=' . TIMESTAMP;
                echo '<script src="' . $file . '"></script>';
            }
        }
    }

    /**
     * load all css files associated with the controller page
     *
     * @return void
     */
    protected function _loadCSS() {
        // load global CSS file

        $filePath = FOLDER_CSS . '*.css';

        foreach(glob($filePath) as $file) {
            $file = SITE_CSS . basename($file) . '?v=' . TIMESTAMP;
            echo '<link rel="stylesheet" type="text/css" href="' . $file  . '">';
        }

        if ( !empty($this->_controllerName) ) {
            $filePath = FOLDER_CSS . 'modules/' . strtolower($this->_controllerName) . '/*.css';

            foreach(glob($filePath) as $file) {
                $file = SITE_CSS . 'modules/' . strtolower($this->_controllerName) . '/' . basename($file) . '?v=' . TIMESTAMP;
                echo '<link rel="stylesheet" type="text/css" href="' . $file  . '">';
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
        $headerModel = $this->_loadModal('header', $this->_controllerName);

        $this->_data['breadCrumbs'] = $this->_loadBreadCrumbs();
        $this->_data['controller']  = $this->_controllerName;

        $this->_loadView('header/index', $headerModel);
        $this->_loadView('modals/index');
    }

    protected function _addBreadCrumb($breadCrumb) {
        array_push($this->_breadCrumbs, $breadCrumb);
    }

    protected function _loadBreadCrumbs() {
        if ( empty($this->_breadCrumbs) ) {
            return array();
        }

        end($this->_breadCrumbs);
        $breadCrumbIndex = key($this->_breadCrumbs);
        $this->_breadCrumbs[$breadCrumbIndex]['active'] = TRUE;
        reset($this->_breadCrumbs);

        return $this->_breadCrumbs;
    }

    /**
     * load the footer page
     *
     * @return void
     */
    protected function _loadFooter() {
        $footerModel = $this->_loadModal('footer');
        $this->_loadView('footer/index', $footerModel);
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
        $this->_handleSessionData();

        // Begin Compression
        ob_start('ob_gzhandler');

        // load header
        $this->_loadHeader();

        // load main content
        $this->_loadView($view, $model);

        // load footer
        $this->_loadFooter();

        ob_end_flush();
    }

    /**
     * handle any data in the session for forms
     *
     * @return void
     */
    protected function _handleSessionData() {
        $formHandler = new FormHandler($this->_dbh);

        if ( $formHandler->isFormSubmitted() ) {
            $formHandler->process();
        }

        if ( !empty(SessionData::get('message')) ) {
            $this->alert = new Alert(SessionData::get('message'));
            SessionData::remove('message');
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

        $this->_pageTitle .= ' | ' . $this->_siteName;
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
        $this->_params = $params;
    }
}