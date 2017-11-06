<?php

// autoloader class
require 'config/Autoloader.php';

// globals class
require 'config/Globals.php';

// config class
require 'config/' . SERVER . '/Config.php';

// general config class
require 'config/GeneralConfig.php';

// base app class
require 'core/App.php';

// base controller class
require 'core/Controller.php';

// base model class
require 'core/Model.php';