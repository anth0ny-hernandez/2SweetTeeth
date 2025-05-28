<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    require_once("database.php");

    // validates that the IDs of both fields are integers
    $dessert_id = filter_input(INPUT_POST, 'dessert_id', FILTER_VALIDATE_INT);
    $dessert_category_id = filter_input(INPUT_POST, 'dessertcategory_id', FILTER_VALIDATE_INT);

    // a final check for the field validation
    if($dessert_id != FALSE && $dessert_category_id != FALSE) {
        $query = 'DELETE FROM dessert
                  WHERE dessertID = :dessert_id';
        $statement1 = $db->prepare($query);
        $statement1->bindValue(':dessert_id', $dessert_id);
        $success = $statement1->execute();
        $statement1->closeCursor();
        // Re-directs back to the Dessert page upon dessert deletion
        if($success == 1)
        {
            $sent = 'Your dessert was successfully deleted from the table.';
            include("desserts.php");
            exit();
        }
    }
?>