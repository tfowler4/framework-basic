<?php

/**
 * autoloader
 */
function __autoload($className)  {
    $directorys = array(
        'config/',
        'controllers/',
        'lib/',
        'models/',
        'views/'
    );

    $isModelFile = false;

    if ( strpos($className, 'Model') !== FALSE ) {
        $isModelFile = true;
    }

    //print_r($directorys);
    foreach( $directorys as $directory ) {
        $classPath = ABS_BASE_PATH . 'application/' . $directory . $className . '.php';

        if( file_exists($classPath) ) {
            include_once $classPath;

            return;
        } elseif ( $isModelFile && $directory == 'models/' ) {
            $className = strtolower(str_replace('Model', '', $className));
            $modelPath = ABS_BASE_PATH . 'application/' . $directory . $className . '/*.php';

            foreach( glob($modelPath) as $model ) {
                include_once $model;
            }
        }
    }
}

spl_autoload_register('__autoload');