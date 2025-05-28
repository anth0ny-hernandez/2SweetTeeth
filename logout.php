<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    session_start();

    $_SESSION = [];     // clear all session data
    session_destroy();  // cleanup sessionID

    $login_message = 'You have been logged out';
    include('login.php');
?>