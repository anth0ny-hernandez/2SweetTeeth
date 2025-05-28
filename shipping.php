<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    // set ALL default values of variables for initial page load
    if(!isset($first_name)) { $first_name = ''; }
    if(!isset($last_name)) { $last_name = ''; }
    if(!isset($address)) { $address = ''; }
    if(!isset($city)) { $city = ''; }
    if(!isset($state)) { $state = ''; }
    if(!isset($zip_code)) { $zip_code = ''; }
    if(!isset($date)) { $date = ''; }
    if(!isset($weight)) { $weight = ''; }
    if(!isset($height)) { $height = ''; }
    if(!isset($length)) { $length = ''; }
    if(!isset($width)) { $width = ''; }
    if(!isset($order_num)) { $order_num = ''; }
?>
<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
    <body>
        <!-- styles the whole main body to a fixed width and height -->
        <main id="shipping">
            <p style="text-align:right; margin-right: 10px;">
            289 Gumdrup Avenue, Clifton, NJ
            </p>

            <!-- Navigation Menu w/ links to other pages -->
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="desserts.php">Desserts</a></li>

                    <!-- Shows everything unless user is not authenticated -->
                    <?php
                        if(isset($_SESSION['is_valid_admin'])) {
                    ?>
                        <li><a href="shipping.php">Shipping</a></li>
                        <li><a href="create.php">Create</a></li>
                        <li><a href="details.php">Details</a></li>
                        <li style="float: right;"><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
            <br>
            <?php 
                $name = $_SESSION['name'];
                $email = $_SESSION['email']; 
            ?>
                <h4><?php echo "Logged In: $name<br>Email: $email"; ?></h4>

            <!-- validates that the error variable is not empty -->
            <?php if(!empty($error_message)) { ?>
                <p><?php echo htmlspecialchars($error_message); ?></p>
            <?php }?>
            
            <h2>To:</h2>

            <!-- START of form field that will display all input fields -->
            <form action="display.php" method="post" id="to-form-field">

                <!-- 
                     Input form fields of ID "data" for a full name, address
                     city, state, and zip code
                -->
                <div id="data" style="width: 500px; float: left;">
                    <label>First Name: </label>
                    <input type="text" name="first_name" 
                    value="<?php echo htmlspecialchars($first_name); ?>" /><br>

                    <label>Last Name: </label>
                    <input type="text" name="last_name" 
                    value="<?php echo htmlspecialchars($last_name); ?>" /><br>

                    <label>Street Address: </label>
                    <input type="text" name="address" 
                    value="<?php echo htmlspecialchars($address); ?>" /><br>

                    <label>City: </label>
                    <input type="text" name="city" 
                    value="<?php echo htmlspecialchars($city); ?>" /><br>

                    <label>State: </label>
                    <input type="text" name="state" 
                    value="<?php echo htmlspecialchars($state); ?>" /><br>

                    <label>Zip Code: </label>
                    <input type="text" name="zip_code" 
                    value="<?php echo htmlspecialchars($zip_code); ?>" /><br>
                    
                    <input type="submit" value="Confirm" />
                </div>


                <!--
                    Input form fields of ID "data" for shipping date,
                    package weight/length/width/height, and order number
                -->
                <div id="data" style="width: 600px; float: right;">
                    <label>Delivery Date: </label>
                    <input type="date" name="shipping_date"><br>
                    
                    <label>Package Weight: </label>
                    <input type="text" name="weight"
                    value="<?php echo htmlspecialchars($weight); ?>" /><br>

                    <label>Package Length: </label>
                    <input type="text" name="length"
                    value="<?php echo htmlspecialchars($length); ?>" /><br>

                    <label>Package Width: </label>
                    <input type="text" name="width"
                    value="<?php echo htmlspecialchars($width); ?>" /><br>

                    <label>Package Height: </label>
                    <input type="text" name="height"
                    value="<?php echo htmlspecialchars($height); ?>" /><br>

                    <label>Order Number: </label>
                    <input type="text" name="order_num"
                    value="<?php echo htmlspecialchars($order_num); ?>" /><br>
                </div>
            </form>
            <!-- /********************* END *********************/ -->

            <figure id="notice">
                <figcaption>
                    Please note that all fields are required.<br>
                    Trying to bypass the fields will be yield an error.
                </figcaption>
            </figure>
            <!-- If NOT authorized, then only this error message will display in the main body -->
                <?php } else { ?>
                    <li><a href="details.php">Details</a></li>
                    <li style="float: right;"><a href="login.php">Login</a></li>
                    <h3>Oops, it seems you don't have the authorization to access this page!<br>
                        If you have an email and password login, please click <em>Login</em>
                        to be authenticated.<br>
                        Otherwise, return to the homepage and enjoy the abundance of desserts
                        we have to offer!
                    </h3>
                <?php } ?>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>