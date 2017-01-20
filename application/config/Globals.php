<?php

function logger($severity, $message, $user = 'user') {
    $logger = new Logger();
    $logger->log($severity, $message, $user = 'user');
}