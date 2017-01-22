<?php

/**
 * base controller class
 */
abstract class Controller {
    protected $_pageTitle;
    protected $_pageDescription;
    protected $_siteName;
    protected $_modelName;
    protected $_viewPath = FOLDER_VIEWS;
    protected $_dbh;

    public $alert;

    public function __construct() {
        $this->_dbh = Database::getHandler();
        $this->_setSiteName();

        $currController = '';
        $newController  = static::CONTROLLER_NAME;

        if ( !empty(SessionData::get('controller')) ) {
            $currController = SessionData::get('controller');
            SessionData::set('prev_controller', $currController);
        }

        SessionData::set('controller', $newController);

        if ( $currController != $newController ) {
            SessionData::remove('form');
        }
    }

    protected function _loadModal($modalName, $params = '') {
        $this->_modelName = strtolower($modalName);
        $modelFile        = ucfirst($this->_modelName) . 'Model';

        return new $modelFile($this->_dbh, $params);
    }

    protected function _loadView($view, $data = '') {
        $viewFile = '';

        if ( !empty($view) ) {
            $view = strtolower($view);
            $viewFile = $this->_viewPath . $view . '.html';
        } else {
            $this->_loadError();
        }

        extract((array)$data);

        include strtolower($viewFile);
    }

    protected function _loadJS() {
        // load global JS file
        $globalFile = FOLDER_JS . 'global.js';

        if ( file_exists($globalFile) ) {
            $globalFile = SITE_JS . 'global.js?v=' . TIMESTAMP;
            echo '<script src="' . $globalFile . '"></script>';
        }

        if ( defined('static::CONTROLLER_NAME') && !empty(static::CONTROLLER_NAME) ) {
            $filePath = FOLDER_JS . 'modules/' . strtolower(static::CONTROLLER_NAME) . '/*.js';

            foreach(glob($filePath) as $file) {
                $file = SITE_JS . 'modules/' . strtolower(static::CONTROLLER_NAME) . '/' . basename($file) . '?v=' . TIMESTAMP;
                echo '<script src="' . $file . '"></script>';
            }
        }
    }

    protected function _loadCSS() {
        // load global CSS file
        $globalFile = FOLDER_CSS . 'global.css';

        if ( file_exists($globalFile) ) {
            $globalFile = SITE_CSS . 'global.css?v=' . TIMESTAMP;
            echo '<link rel="stylesheet" type="text/css" href="' . $globalFile  . '">';
        }

        if ( defined('static::CONTROLLER_NAME') && !empty(static::CONTROLLER_NAME) ) {
            $filePath = FOLDER_CSS . 'modules/' . strtolower(static::CONTROLLER_NAME) . '/*.css';

            foreach(glob($filePath) as $file) {
                $file = SITE_CSS . 'modules/' . strtolower(static::CONTROLLER_NAME) . '/' . basename($file) . '?v=' . TIMESTAMP;
                echo '<link rel="stylesheet" type="text/css" href="' . $file  . '">';
            }
        }
    }

    protected function _loadFile($filePath) {
        if ( file_exists($filePath) ) {
            include $filePath;
        }
    }

    protected function _loadError() {
        header('Location: ' . SITE_URL . 'error');
        exit;
    }

    protected function _loadHeader() {
        $headerModel = $this->_loadModal('header', static::CONTROLLER_NAME);
        $this->_loadView('header/index', $headerModel);
    }

    protected function _loadFooter() {
        $footerModel = $this->_loadModal('footer');
        $this->_loadView('footer/index', $footerModel);
    }

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

    protected function _setSiteName() {
        if ( defined('SITE_NAME') && !empty(SITE_NAME) ) {
            $this->_siteName = SITE_NAME;
        } else {
            $this->_siteName = 'Unnamed Site';
        }
    }

    protected function _setPageTitle() {
        if ( defined('static::PAGE_TITLE') && !empty(static::PAGE_TITLE) ) {
            $this->_pageTitle = static::PAGE_TITLE;
        } else {
            $this->_pageTitle = 'No Title Set';
        }

        $this->_pageTitle .= ' | ' . $this->_siteName;
    }

    protected function _setPageDescription() {
        if ( defined('static::PAGE_DESCRIPTION') && !empty(static::PAGE_DESCRIPTION) ) {
            $this->_pageDescription = static::PAGE_DESCRIPTION;
        } else {
            $this->_pageDescription = 'No Description Set';
        }
    }
}
