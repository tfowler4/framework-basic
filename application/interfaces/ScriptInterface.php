<?php

/**
 * maintenance site script interface
 */
interface ScriptInterface {
    public function setResponse($status, $message);
    public function checkVariables();
    public function execute();
    public function endScript();
}