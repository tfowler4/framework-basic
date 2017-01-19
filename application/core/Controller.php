<?php

/**
 * base controller class
 */
abstract class Controller {
    protected $_pageTitle;
    protected $_pageDescription;
    protected $_siteName;
    protected $_modelName;
    protected $_modelFile;
    protected $_alert;
    protected $_viewPath = ABS_BASE_PATH . 'application/models/';
    protected $_dbh;
    //protected $_header;
    //protected $_footer;
    //protected $_viewFile;
    //protected $_contentFile;

    public function __construct() {
        $this->_dbh = Database::getHandler();
        $this->_setSiteName();
    }

    protected function _loadModal($modalName, $params) {
        $this->_modelName = strtolower($modalName);
        $this->_modelFile = ucfirst($this->_modelName) . 'Model';

        return new $this->_modelFile($this->_dbh, $params);
    }

    protected function _loadView($viewName, $data = array()) {
        if ( !empty($viewName) ) {
            $viewName           = strtolower($viewName);
            $this->_contentFile = $this->_viewPath . $this->_modelFile . '/views/' . $viewName . '.html';
        } else {
            header('Location: ' . SITE_URL . 'error');
        }

        extract((array)$data);

        include $this->_contentFile;
    }

    protected function _loadError() {
        header('Location: ' . SITE_URL . 'error');
    }

    protected function _loadHeader($activeModel) {
        $header = new Header($activeModel);

        extract((array)$header);

        $headerFile = ABS_BASE_PATH . 'public/templates/default/header.html';
        include $headerFile;
    }

    protected function _loadFooter() {
        $footer = new Footer();

        extract((array)$footer);

        $footerFile = ABS_BASE_PATH . 'public/templates/default/footer.html';
        include $footerFile;
    }

    protected function _loadPageView($view, $model) {
        $this->_loadHeader($this->_modelName);
        $this->_loadView($view, $model);
        $this->_loadFooter();
    }

    protected function _setSiteName() {
        if ( !empty(SITE_NAME) ) {
            $this->_siteName = SITE_NAME;
        } else {
            $this->_siteName = 'Unnamed Site';
        }
    }

    protected function _setPageTitle() {
        if ( !empty(static::PAGE_TITLE) ) {
            $this->_pageTitle = static::PAGE_TITLE;
        } else {
            $this->_pageTitle = 'No Title Set';
        }

        $this->_pageTitle .= ' | ' . $this->_siteName;
    }

    protected function _setPageDescription() {
        if ( !empty(static::PAGE_DESCRIPTION) ) {
            $this->_pageDescription = static::PAGE_DESCRIPTION;
        } else {
            $this->_pageDescription = 'No Description Set';
        }
    }

    /**
     * creates requested model class
     *
     * @param string $model  [ name of model class ]
     * @param array  $params [ parameters passed ]
     *
     * @return object [ new model object ]
     */
    /*
    protected function _model($model, $params) {
        $this->_modelName = strtolower($model);
        $this->_modelFile = ucfirst($model) . 'Model';

        return new $this->_modelFile($model, $params);
    }
    */

    /**
     * creates a view of the requested model class
     *
     * @param  string $view [ name of specific view file to use ]
     * @param  object $data [ returned model object ]
     *
     * @return void
     */
    /*
    protected function _view($view = '', $data = array()) {
        if ( !empty($view) ) {
            $this->_contentFile = ABS_BASE_PATH . 'application/models/' . $this->_modelFile . '/views/' . strtolower($view) . '.html';
        }

        if ( !file_exists($this->_contentFile) ) {
            $this->_loadError();
        }

        // handle if any form submission took place
        if ( FormHandler::isFormSubmitted() ) {
            FormHandler::process();
        }

        if ( !empty(SessionData::get('message')) ) {
            $data->alert = SessionData::get('message');
            SessionData::remove('message');
        }

        if ( !empty(SessionData::get('form')) ) {
            //$data->form = SessionData::get('form');
        }

        // convert array values to variables
        extract((array)$data);

        // load header content
        $header = $this->_loadHeader($this->_modelName);
        extract((array)$header);

        // load footer content
        $footer = $this->_loaderFooter();
        extract((array)$footer);

        // include the index html file
        include './public/templates/index.html';
    }
    */
}
