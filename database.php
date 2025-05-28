<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */
    
    // Establishes connection to dessert database
    $dsn = 'mysql:host=localhost;dbname=dessert_shop';
    $username = 'web_user';
    $password = 'pa55word';

    // Ensures that the proper credentials are used, or else
    // it will display an error before the create form
    try {
        $db = new PDO($dsn, $username, $password);
    }
    catch (PDOException $e) {
        $error_mssg = 'Error: ' . $e->getMessage();
        include('create.php');
        exit();
    }
?>