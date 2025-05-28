<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    // connects to dessert database & checks if a user has logged in
    require_once('admin_db.php');
    session_start();

    // filters email and password fields
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    // checks if the fields are either empty or incorrect
    if($email == NULL && $password == NULL) {
        $login_message = 'You must enter an email address AND password.';
    }
    elseif($email == NULL && $password) {
        $login_message = 'You must enter an email address.';
    }
    elseif($email && $password == NULL) {
        $login_message = 'You must enter a password.';
    }
    elseif(!$email && !$password) {
        $login_message = 'Invalid credentials.';
    }
    else {
        $login_message = '';
        if(is_valid_admin_login($email, $password))
        {
            // will be used to validate any session calls
            // to see if a user has already logged in
            $_SESSION['is_valid_admin'] = true;
        }
    }
    
    include('login.php');
?>