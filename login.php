<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    // makes sure a session hasn't been set yet as the file
    // is included by Authenticate, which also starts a session
    // to make sure a user hasn't logged in
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    if(!isset($login_message))
    {
        $login_message = 'Hello! Please login to access your resources.';
    }
    // will redirect to the home once a user logs in
    if(isset($_SESSION['is_valid_admin'])) {
        $name = $_SESSION['name'];
        $email = $_SESSION['email']; 
        include('home.php'); 
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="If you have the proper authentication, you can
        login to gain complete access to the website as well as being able to modify the
        dessert shop's database.">
        <meta name="author" content="Anthony Hernandez">
    </head>
    <body>
        <!-- styles the whole main body to a fixed width and height -->
        <main id="create">
            <p style="text-align:right; margin-right: 10px;">
            289 Gumdrup Avenue, Clifton, NJ
            </p>

            <!-- Navigation Menu w/ links to other pages -->
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="desserts.php">Desserts</a></li>
                    <li><a href="details.php">Details</a></li>
                    <!-- This is moreso for when the user logs out, where the logout
                        page includes login.php and needs to redisplay the form and link -->
                    <?php
                        if(!isset($_SESSION['is_valid_admin'])) {
                    ?>
                     <li style="float: right;"><a href="login.php">Login</a></li>
                </ul>
            </nav>
            <br>
            <h3><?php echo $login_message; ?></h3>
            <form action="authenticate.php" method="post" id="authentication-form">
                <div id="login-fields">
                    <label>Email Address:</label>
                    <input type="text" name="email" value="" />
                    <br>
                    <label>Password:</label>
                    <input type="password" name="password" value="" />
                    <br><br>
                    <input type="submit" value="Login" />
                </div>
            </form>
            <?php } ?>
        </main>
        <?php include('footer.php'); ?>
    </body>
</html>