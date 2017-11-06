<?php

/**
 * services controller
 */
class Services extends AbstractController {
    const CONTROLLER_NAME = 'Services';

    public function __construct($params) {
        parent::__construct();
        $this->_setParameters($params);
    }

    /*
        this controller is specifially for making ajax calls via javascript
     */

    public function exampleServiceCall() {}
}