<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    require_once('database.php');

    // Validates the appropriate values of the input fields
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $code = filter_input(INPUT_POST, 'code');
    $name = filter_input(INPUT_POST, 'name');
    $description = filter_input(INPUT_POST, 'description');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

    // Function that checks if the dessert table already has a dessert code
    function checkDessertCode($dbase, $dessert) {
        $categoryQuery = 'SELECT * FROM dessert 
                          ORDER BY dessertCategoryID';
        $statement1 = $dbase->prepare($categoryQuery);
        $statement1->execute();
        $dessertCode = $statement1->fetchAll();
        $statement1->closeCursor();

        foreach($dessertCode as $food) {
            if($food['dessertCode'] == $dessert) {
                return true;
            }
        }
    }

    // Call to the function to validate a dessert code is unique
    if(checkDessertCode($db, $code)) {
        $error_message = 'Sorry, that dessert code already exists. Please try something else.';
    }
    /* Checks if price is a valid positive double and if it's actually a number
    else if($price <= 0.0 || $price > 100.0 || $price == NULL || $price == FALSE) {
        $error_message = 'Sorry, please enter a valid price that is greater than $0 
        or less than $100.';
    }
    // Checks that the dessert code is not null
    else if($code == NULL) {
        $error_message = 'Sorry, but you must have something as your dessert code.';
    }
    // Checks that the dessert name is not null
    else if($name == NULL) {
        $error_message = 'Sorry, but you must have something as your dessert name.';
    }
    // Checks that the description is not empty
    else if($description == '') {
        $error_message = 'Sorry, but you must have something in your description.';
    }
    */
    // "Lowers" the error flag to indicate everything is good to go
    else {
        $error_message = '';
    }

    // Checks if any error flags were raised
    if($error_message != '') {
        include('create.php');
        exit();
    }

    // Query for the dessert table, which binds all values w/ the form data input
    $dessertQuery = 'INSERT INTO dessert
    (dessertCategoryID, dessertCode, dessertName, description, price, dateAdded)
    VALUE
    (:category_id, :code, :name, :description, :price, NOW())';
    $statement2 = $db->prepare($dessertQuery);
    $statement2->bindValue(':category_id', $category_id);
    $statement2->bindValue(':code', $code);
    $statement2->bindValue(':name', $name);
    $statement2->bindValue(':description', $description);
    $statement2->bindValue(':price', $price);
    $success = $statement2->execute();
    $categories = $statement2->fetchAll();
    $statement2->closeCursor();

    // Re-directs back to create and successfully adds a dessert
    if($success == 1)
    {
        $sent = 'Your dessert was successfully added to the table.';
        include('create.php');
        exit();
    }
?>