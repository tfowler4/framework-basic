<?php

/**
 * base controller class
 */
class Controller {
    protected $_modelName;
    protected $_modelFile;
    protected $_contentFile;

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
    protected function _view($view = '', $data = array() ) {
        $this->_contentFile = '';
        $this->_contentFile = './application/models/' . $this->_modelFile . '/view/index.html';

        // include the index html file
        include './public/templates/default/index.html';
    }
}