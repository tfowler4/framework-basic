<?php

if ( !defined('SITE_NAME') ) { die('Direct access not permitted'); }

/**
 * test maintenance script
 */
class Test implements ScriptInterface {
    private $_response;

    const RESPONSE_SUCCESS = array('status' => 'success', 'response' => 'Test Success');
    const RESPONSE_FAIL    = array('status' => 'fail', 'response' => 'Test Fail');
    const RESPONSE_WARNING = array('status' => 'warning', 'response' => 'Test Warning');

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->checkVariables();

        $this->execute();

        $this->endScript();
    }

    /**
     * set the response the script will return if it were to end
     *
     * @param string $status  [ status of script if success, fail, or warning ]
     * @param string $message [ response message for the script ]
     *
     * @return void
     */
    public function setResponse($status, $message) {}

    /**
     * begin execution of the script
     *
     * @return void
     */
    public function execute() {}

    /**
     * check any parameters sent to configure the script execution
     *
     * @return void
     */
    public function checkVariables() {}

    /**
     * end the script and log any messages if needed
     *
     * @return void
     */
    public function endScript() {
        echo json_encode(self::RESPONSE_SUCCESS);
        die();
    }
}

new Test();