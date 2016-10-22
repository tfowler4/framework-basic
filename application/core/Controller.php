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

        // include all class files of model
        foreach ( glob('./application/models/' . $this->_modelFile . '/model/*.php') as $fileName ) {
            include $fileName;
        }

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
        $header = $this->_headerContent();
        extract((array)$header);

        // load footer content
        $footer = $this->_footerContent();
        extract((array)$footer);

        // include the index html file
        include './public/templates/default/index.html';
    }

    protected function _loadError() {
        header('Location: http://localhost/framework-basic/error/');
    }

    protected function _headerContent() {
        include './application/views/header.php';

        return new Header();
    }

    protected function _footerContent() {
        include './application/views/footer.php';

        return new Footer();
    }
}