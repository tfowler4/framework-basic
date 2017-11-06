<?php

// site details
define('SITE_NAME', 'Framework Basic');
define('SITE_URL',  'http://' . getHostByName(getHostName()) . ':8080/site-framework-basic/');

// paths
define('ABS_BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/site-framework-basic/');

// database settings
define('DB_HOST', '127.0.0.1'); // host address
define('DB_PORT', '3308'); // host port
define('DB_NAME', 'xeonsold_framework_test'); // name of db
define('DB_USER', 'xeonsold_test'); // name of user
define('DB_PASS', 'test74108520'); // password for user