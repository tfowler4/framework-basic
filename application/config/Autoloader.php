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

<<<<<<< HEAD
    $className = str_replace('_', '/', $className);
    
    echo 'ClassName: ' . $className . '<br>';
    
    foreach( $directorys as $directory ) {
        $classPath = ABS_BASE_PATH . 'application/' . $directory . $className . '.php';
        
        echo 'ClassPath: ' . $classPath . "<br>";
        
=======
    $isModelFile = false;

    if ( strpos($className, 'Model') !== FALSE ) {
        $isModelFile = true;
    }

    foreach( $directorys as $directory ) {
        $classPath = ABS_BASE_PATH . 'application/' . $directory . $className . '.php';

>>>>>>> stage
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
