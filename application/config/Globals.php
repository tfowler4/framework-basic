<?php

/**
 * add a log entry
 *
 * @param  int    $severity [ level of severity integer ]
 * @param  string $message  [ log message ]
 * @param  string $user     [ client type ]
 *
 * @return void
 */
function logger($severity, $message, $user = 'user') {
    $logger = new Logger();
    $logger->log($severity, $message, $user = 'user');
}

function redirect($address) {
    header('Location: ' . $address);
    die();
}