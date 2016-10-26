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

    foreach( $directorys as $directory ) {
        $classPath = ABS_BASE_PATH . 'application/' . $directory . $className . '.php';
echo "ClassPath: $classPath<br>"l
        if( file_exists($classPath) ) {
            include_once $classPath;

            return;
        } elseif ( $isModelFile && $directory == 'models/' ) {
            $modelPath = ABS_BASE_PATH . 'application/' . $directory . $className . '/' . $directory . '*.php';

            foreach( glob($modelPath) as $model ) {
                include_once  $model;
            }
        }
    }
}
