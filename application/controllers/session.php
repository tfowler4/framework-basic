<?php
/**
 * session controller
 */
class Session extends Controller {
    protected $_modelName = 'Session';
    /**
     * index model function when page is accessed
     *
     * @param  array [ url GET parameters ]
     *
     * @return void
     */
    public function template($params = array()) {
        echo "inside session->template with: "; var_dump($params);
        if ( !empty($params) ) {
            $_SESSION['template'] = $params[0];
        }
    }
}
