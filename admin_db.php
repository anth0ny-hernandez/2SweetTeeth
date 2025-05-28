<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    // function is used to pull the password, first name, and last name fields
    // from their respective login rows
    function is_valid_admin_login($email, $password) 
    {
        require_once('database.php');
        $query = 'SELECT password FROM dessertmanagers
                  WHERE emailAddress = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        // checks if a row was returned for a particular user,
        // and if false means that the user does not exist
       if($row === false) {
            $login_message = 'Sorry, invalid login credentials.';
            return false;
        }
        else {
            $query2 = 'SELECT * FROM dessertmanagers
                       WHERE emailAddress = :email';
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(':email', $email);
            $statement2->execute();
            $row = $statement2->fetch();
            $statement2->closeCursor();
            // pulls password field to run it against the user's hashed password
            $hash = $row['password'];
            // pulls the user's first & last name to make a full name
            $_SESSION['name'] = '' . $row['firstName'] . ' ' . $row['lastName'];
            // pulls the user's email so that all this info can be displayed across all pages
            $_SESSION['email'] = $row['emailAddress'];
            return password_verify($password, $hash);
        }
    }
?>