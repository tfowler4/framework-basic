<?php
    if ( session_id() == '' || !isset($_SESSION) ) {
        session_start();
    }   

    include 'application/initialize.php'; 

    $app = new App();
