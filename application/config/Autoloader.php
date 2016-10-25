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

    $className = str_replace('_', '/', $className);
    
    echo "ClassName: $className<br>";
    
    foreach( $directorys as $directory ) {
        $classPath = ABS_BASE_PATH . 'application/' . $directory . $className . '.php';
        
        echo 'ClassPath: ' . $classPath . "<br>";
        
        if( file_exists($classPath) ) {
            require $classPath;

            return;
        }
    }
}
