<?php

// site details
define('SITE_NAME', 'Framework Basic');
define('APP_NAME',  'framework-basic');
define('SITE_URL',  'http://localhost/framework-basic/');
//define('SITE_URL',  'http://localhost:8080/framework-basic/');
define('SITE_STATUS', 1);
define('TIMESTAMP', rand(0,100000000));
define('SITE_TEMPLATE', 'default');

// paths
define('ABS_BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/' . APP_NAME . '/');

define('FOLDER_VIEWS',       ABS_BASE_PATH . 'application/views/');
define('FOLDER_CONTROLLERS', ABS_BASE_PATH . 'application/controllers/');
define('FOLDER_MODELS',      ABS_BASE_PATH . 'application/models/');
define('FOLDER_TEMPLATES',   ABS_BASE_PATH . 'public/templates/');
define('FOLDER_JS',          ABS_BASE_PATH . 'public/js/');
define('FOLDER_CSS',         ABS_BASE_PATH . 'public/css/');

define('SITE_JS',  SITE_URL . 'public/js/');
define('SITE_CSS', SITE_URL . 'public/css/');

// modules
define('MODULE_HOME_STATUS', 1);
define('MODULE_EXAMPLE_SET', 1);

// database settings
define('DB_HOST', '198.57.149.136');
//define('DB_HOST', '127.0.0.1:3308');
define('DB_NAME', 'xeonsold_framework_test');
define('DB_USER', 'xeonsold_test');
define('DB_PASS', 'test74108520');

Database::init(DB_USER, DB_PASS, DB_NAME, DB_HOST);

SessionData::start();