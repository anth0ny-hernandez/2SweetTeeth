<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */
    
    // checks if a session hasn't been started by the Shipping page
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    /* START
        All input fields are filtered, and if applicable, also validated
        to avoid improper input
    */
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $address = filter_input(INPUT_POST, 'address');
    $city = filter_input(INPUT_POST, 'city');
    $state = filter_input(INPUT_POST, 'state');
    $zip_code = filter_input(INPUT_POST, 'zip_code', FILTER_VALIDATE_FLOAT);
    $date = filter_input(INPUT_POST, 'shipping_date');
    $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
    $length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
    $width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_FLOAT);
    $order_num = filter_input(INPUT_POST, 'order_num', FILTER_VALIDATE_INT);
    
    /******************************** END ********************************/


    /* START
        First massive if-statement checks if either of the 50 state initials
        are input or not

        Following suit are if-statements for the full name, address, city, zip code,
        shipping date, package weight/length/width/height, and ordery number.

        Else, there are no errors and the error handling variable is set to empty
    */
    if( !( ($state == 'AL') || ($state == 'AK') || ($state == 'AZ') || ($state == 'AR') ||
        ($state == 'CA') || ($state == 'CO') || ($state == 'CT') || ($state == 'DE') ||
        ($state == 'FL') || ($state == 'GA') || ($state == 'HI') || ($state == 'ID') ||
        ($state == 'IL') || ($state == 'IN') || ($state == 'IA') || ($state == 'KS') ||
        ($state == 'KY') || ($state == 'LA') || ($state == 'ME') || ($state == 'MD') ||
        ($state == 'MA') || ($state == 'MI') || ($state == 'MN') || ($state == 'MS') ||
        ($state == 'MO') || ($state == 'MT') || ($state == 'NE') || ($state == 'NV') ||
        ($state == 'NH') || ($state == 'NJ') || ($state == 'NM') || ($state == 'NY') ||
        ($state == 'NC') || ($state == 'ND') || ($state == 'OH') || ($state == 'OK') ||
        ($state == 'OR') || ($state == 'PA') || ($state == 'RI') || ($state == 'SC') ||
        ($state == 'SD') || ($state == 'TN') || ($state == 'TX') || ($state == 'UT') ||
        ($state == 'VT') || ($state == 'VA') || ($state == 'WA') || ($state == 'WV') ||
        ($state == 'WI') || ($state == 'WY') ) ) {
        $error_message = 'Please enter a valid initial of your state.';
    }
    else if($first_name == '' || $last_name == '') {
        $error_message = 'Please enter a first AND last name.';
    }
    else if($address == '') {
        $error_message = 'Please enter an address.';
    }
    else if($city == '') {
        $error_message = 'Please enter the city you live in.';
    }
    else if($zip_code === FALSE) {
        $error_message = 'Please enter a valid numeric zip code.';
    }
    else if($date == '' || $date == null) {
        $error_message = 'Please enter a date for your delivery that works for you.';
    }
    else if(($weight === FALSE || $weight < 0) || ($weight > 150.0)) {
        $error_message = 'Please enter a valid numeric weight between 0 and 150lbs.';
    }
    else if (($height > 36.00 || $height < 0.0) || ($height === FALSE)) {
        $error_message = 'Please enter a valid numeric height between 0 and 36 inches.';
    }
    else if (($length > 36.00 || $length < 0.0) || ($length === FALSE)) {
        $error_message = 'Please enter a valid numeric length between 0 and 36 inches.';
    }
    else if (($width > 36.00 || $width < 0.0) || ($width === FALSE)) {
        $error_message = 'Please enter a valid numeric width between 0 and 36 inches.';
    }
    else if ($order_num === FALSE || $order_num < 0) {
        $error_message = 'Please enter an valid order number and that is also greater than 0';
    }
    else {
        $error_message = '';
    }

    /******************************** END ********************************/


    // Checks if the error variable is not empty and reloads the shipping page
    if($error_message != '') {
        include('shipping.php');
        exit();
    }

    // Formats the full name, weight, and package dimensions accordingly
    $full_name = $first_name . ' ' . $last_name;
    $weight_f = $weight . ' lbs';
    $dimensions = $length.' x '.$width.' x '.$height;
?>
<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
    <body>
        <!-- styles the whole main body to a fixed width and height -->
        <main id="display">
            <p style="text-align:right; margin-right: 10px;">
            289 Gumdrup Avenue, Clifton, NJ
            </p>

            <!-- Navigation Menu w/ links to other pages -->
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="desserts.php">Desserts</a></li>

                    <!-- If the user has logged in, it will display the Shipping &  
                        Create pages as well as the hyperlink to Logout -->
                    <?php
                        if(isset($_SESSION['is_valid_admin'])) {
                    ?>
                        <li><a href="shipping.php">Shipping</a></li>
                        <li><a href="create.php">Create</a></li>
                        <li style="float: right;"><a href="logout.php">Logout</a></li>
                    <?php } ?>

                    <!-- Details is placed here to maintain consistency -->
                    <li><a href="details.php">Details</a></li>
                        
                    <?php if(!isset($_SESSION['is_valid_admin'])) { ?>
                        <li style="float: right;"><a href="login.php">Login</a></li>
                    <?php } ?>
                </ul>
            </nav>
            <br>

            <!-- To avoid complications, another login check was implemented so that
                the user's name & email can be displayed as well as the rest of the page -->
            <?php
                if(isset($_SESSION['is_valid_admin'])) {
                    $name = $_SESSION['name'];
                    $email = $_SESSION['email']; 
            ?>
                <h4><?php echo "Logged In: $name<br>Email: $email"; ?></h4>
                </ul>

            <!-- Titles the Shipping Information -->
            <h2>Shipping Information</h2>
            <h3>From: 289 Gumdrup Avenue, Clifton, NJ 07011</h3>
            <br>

            <!-- Titles the Delivery Service -->
            <div style="width: 500px; margin: auto;">
                <h3 style="text-align: center">USPS Priority Mail</h3>
                <h3>To:</h3>
            </div>

            <!-- Formats & Sections the name, address, etc
                 to replicate the look of a real shipping label
            -->
            <div id="to-info">
                <span><?php echo $full_name; ?></span>
                <br>
                <span><?php echo $address; ?></span>
                <br>
                <span><?php echo $city . ', ' . $state . ' ' . $zip_code ?></span>
                <br>
                <label>Est. Delivery: </label>
                <span><?php echo $date ?></span>
            </div>

            <!-- Formats & Sections the weight and dimension info
                 to continue the look of a real shipping label
            -->
            <div id="weight-and-dimens">
                <span style="border-right: solid black; padding-right: 20px;">
                    <label>Weight: </label>
                    <span><?php echo $weight_f ?></span>
                </span>
                <span style="text-align: center; padding-left: 20px;">
                    <label>Dimensions (in): </label>
                    <span><?php echo $dimensions ?></span>
                </span>
            </div>

            <!-- Formats & Sections the tracking number along with a 
                 barcode to really give the feeling of immersion
            -->
            <div id="tracking">
                <span>Tracking Number: 0123 4567 8998 7654 3210</span>
                <br>
                <img src="images/barcode.png" 
                alt="Tracking Number Barcode" width="400"/>
            </div>
            
            <!-- Order Number Displayed at the bottom -->
            <div style="text-align: center; padding-top: 10px;">
                <label>Order Number: </label>
                <span><?php echo $order_num ?></span>
            </div>
            <br>

            <!-- Finishes with an owner's promise -->
            <figure class="promise">
                <figcaption><b>As the owner I say:</b></figcaption>
                <blockquote>
                    Guaranteed delivery by the date or get your money back!
                </blockquote>
            </figure>
            <figure class="promise">
                <figcaption><b>Spanish Version:</b></figcaption>
                <blockquote>
                    Si no lo recibes antes de o en la fecha, tu pedido es gratis.
                </blockquote>
            </figure>

            <!-- If NOT authorized, then only this error message will display in the main body -->
            <?php } else { ?>
                <h3>Oops, it seems you don't have the authorization to access
                    this page!<br>
                    If you have an email and password login, please click <em>Login</em>
                    to be authenticated.<br>
                    Otherwise, return to the homepage and enjoy the abundance of
                    desserts we have to offer!
                </h3>
            <?php } ?>
            
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>