<?php

define('SITE_STATUS', 1);
define('TIMESTAMP', rand(0,100000000));

define('FOLDER_VIEWS',       ABS_BASE_PATH . 'application/views/');
define('FOLDER_CONTROLLERS', ABS_BASE_PATH . 'application/controllers/');
define('FOLDER_MODELS',      ABS_BASE_PATH . 'application/models/');
define('FOLDER_JS',          ABS_BASE_PATH . 'public/js/');
define('FOLDER_CSS',         ABS_BASE_PATH . 'public/css/');
define('FOLDER_IMAGES',      ABS_BASE_PATH . 'public/images/');
define('FOLDER_FONTS',       ABS_BASE_PATH . 'public/fonts/');
define('FOLDER_SCRIPTS',     ABS_BASE_PATH . 'scripts/');
define('FOLDER_LIBRARY',     ABS_BASE_PATH . 'library/');
define('FOLDER_DATA',        ABS_BASE_PATH . 'data/');
define('FOLDER_LOGS',        ABS_BASE_PATH . 'data/logs/');
define('FOLDER_BACKUPS',     ABS_BASE_PATH . 'data/backups/');

define('SITE_JS',  SITE_URL . 'public/js/');
define('SITE_CSS', SITE_URL . 'public/css/');

// meta
define('META_AUTHOR',          "");
define('META_KEYWORDS',        "");
define('META_DESCRIPTION',     "");

Database::init(DB_USER, DB_PASS, DB_NAME, DB_HOST, DB_PORT);

SessionData::start();