<?php

/**
 * example model
 */
class ExampleModel extends AbstractModel {
    const MODEL_NAME = 'Example';

    public function __construct($dbh, $params) {
        parent::__construct($dbh);
    }

    public function getData() {}

    public function getDataById($id) {}

    private function _getDataFromDb() {}

    private function _getDataByIdFromDb($id) {}
}