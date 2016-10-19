<?php

/**
 * index controller
 */
class Home extends Controller {
    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function index($params = array()) {
        $this->_view('', $this->_model('Home', $params));
    }
}