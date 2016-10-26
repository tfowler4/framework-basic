<?php
    include 'application/initialize.php'; 

    if ( session_id() == '' || !isset($_SESSION) ) {
        session_start();
    }   

    $app = new App();
