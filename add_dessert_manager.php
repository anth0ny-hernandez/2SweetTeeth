<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    // a function that is not linked to the website, but adds rows to the manager table
    function add_dessert_manager($email, $password, $first_name, $last_name) {

        // authenticates user credentials to access dessert_shop database
        $dsn = 'mysql:host=localhost;dbname=dessert_shop';
        $username = 'web_user';
        $password = 'pa55word';
        $db = new PDO($dsn, $username, $password);
        
        // will put hashed version of password into the password column
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // adds all the following data for each and every user so as to be unique
        $query = 'INSERT INTO dessertManagers (emailAddress, password, firstName, lastName)
                  VALUES (:email, :password, :f_name, :l_name)';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':f_name', $first_name);
        $statement->bindValue(':l_name', $last_name);
        $success = $statement->execute();
        $statement->closeCursor();
    }

    // adds three dessert managers to the manager table
    add_dessert_manager('ant@gmail.com', 'ilovephp123', 'Anthony', 'Hernandez');
    add_dessert_manager('samuelbrenard@gmail.com', 'samiam300', 'Sammy', 'Brenard');
    add_dessert_manager('angelcruz@gmail.com', 'passwordispassword', 'Angel', 'Cruz');
?>