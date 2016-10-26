<?php
/**
 * session controller
 */
class Session extends Controller {
    protected $_modelName = 'Example';
    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function template($params = array()) {
        if ( !empty($params) ) {
            $_SESSION['template'] = $params[0];
        }
    }
}
