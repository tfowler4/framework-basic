<?php

/**
 * base controller class
 */
class Controller {
    protected $_modelName;
    protected $_modelFile;
    protected $_viewFile;
    protected $_contentFile;
    protected $_header;
    protected $_footer;

    /**
     * creates requested model class
     *
     * @param string $model  [ name of model class ]
     * @param array  $params [ parameters passed ]
     *
     * @return object [ new model object ]
     */
    protected function _model($model, $params) {
        $this->_modelName = strtolower($model);
        $this->_modelFile = ucfirst($model) . 'Model';

        return new $this->_modelFile($model, $params);
    }

    /**
     * creates a view of the requested model class
     *
     * @param  string $view [ name of specific view file to use ]
     * @param  object $data [ returned model object ]
     *
     * @return void
     */
    protected function _view($view = '', $data = array()) {
        if ( !empty($view) ) {
            $this->_contentFile = $_SERVER['DOCUMENT_ROOT'] . '/framework-basic/application/models/' . $this->_modelFile . '/view/' . strtolower($view) . '.html';
        }

        if ( !file_exists($this->_contentFile) ) {
            $this->_loadError();
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
        include './public/templates/default/index.html';
    }

    private function _loadError() {
        //header('Location: ' . SITE_URL . 'error');
    }

    private function _loadHeader($activeModel) {
        return new Header($activeModel);
    }

    private function _loaderFooter() {
        return new Footer();
    }
}
