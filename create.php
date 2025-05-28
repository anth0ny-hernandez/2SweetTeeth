<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    require_once('database.php');
    // checks if a user has logged in
    session_start();

    // Checks if there is an authentication or other
    // error before anything else in the main body
    if(!empty($error_mssg)) {
        $error_message = $error_mssg;
    }
    // Proceeds as normal
    else {
        $query = 'SELECT * FROM dessertcategories
                ORDER BY dessertCategoryID';
        $statement = $db->prepare($query);
        $statement->execute();
        $categories = $statement->fetchAll();
        $statement->closeCursor();
    }
?>

<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <!-- meta description tags and author name, on top of an included header file -->
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Add your own desserts into the dessert table, with your
        own code, name, price, and description! Just select the category, and leave no field blank.">
        <meta name="author" content="Anthony Hernandez">
    </head>
    <body>
        <!-- styles the whole main body to a fixed width and height -->
        <main id="create">
            <p style="text-align: right; margin-right: 10px;">
            289 Gumdrup Avenue, Clifton, NJ
            </p>

            <!-- Navigation Menu w/ links to other pages -->
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="desserts.php">Desserts</a></li>

                    <!-- Shows Create & Shipping only if user is authorized,
                        plus Logout; otherwise neither is shown along with Login -->
                    <?php
                        if(isset($_SESSION['is_valid_admin'])) {
                    ?>
                        <li><a href="shipping.php">Shipping</a></li>
                        <li><a href="create.php">Create</a></li>
                    <?php } ?>
                        <li><a href="details.php">Details</a></li>
                    <?php
                        if(isset($_SESSION['is_valid_admin'])) {
                    ?>
                        <li style="float: right;"><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
            <br>
            <!-- Digs into the $_SESSION array for the user's name & email to display -->
            <?php 
                $name = $_SESSION['name'];
                $email = $_SESSION['email']; 
            ?>
                <h4><?php echo "Logged In: $name<br>Email: $email"; ?></h4>

            <!-- Checks that there are no errors with form data submission -->
            <?php if(!empty($error_message)) { ?>
                <p style="display: inline;"><?php echo htmlspecialchars($error_message); ?></p>
                <br><br>
            <?php } ?>
            <!-- Returns to the user that their data submission was successful -->
            <?php if (!empty($sent)) { ?>
                <p><?php echo htmlspecialchars($sent); ?></p>
            <?php } ?>
            
            <!-- Form POSTS data and creates custom border -->
            <form action="add_dessert.php" method="post" id="dessert-form">
                <div id="add-dessert">
                    <!-- Displays dessert categories by accessing the dessert table -->
                    <label>Category: </label>
                    <select name="category_id" class="dessert-list">
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['dessertCategoryID']; ?>">
                            <?php echo $category['dessertCategoryName']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>

                    <!-- Next four input fields take in the necessary dessert information -->
                    <label>Dessert Code: </label>
                    <input type="text" id="code" name="code" class="dessert-list" /><br>

                    <label>Dessert Name: </label>
                    <input type="text" id="name" name="name" class="dessert-list" /><br>

                    <label>Dessert Description: </label>
                    <textarea class="dessert-list" id="description"
                    name="description" rows="1" cols="50"></textarea>
                    <br>

                    <label>Dessert Price: </label>
                    <input type="text" id="price" name="price" class="dessert-list" /><br><br>
                    
                    <!-- Simple clear and submit buttons -->
                    <input type="reset" value="Clear" />
                    <input type="submit" id="submit_button" value="Submit" />
                </div>
            </form><br>
            <script>
                // checks ALL fields before submitting the form
                const checkAll = evt => {
                    // checks the field with the code id to see if it's blank, is less than 4 characters,
                    // or exceeds 10 characters
                    const code = document.querySelector("#code");
                    const codeLength = code.value.length;
                    if(codeLength == 0 || codeLength < 4 || codeLength > 10) {
                        alert("The code field should have a minimum of four characters and a maximum of ten characters!");
                        evt.preventDefault();
                    }

                    // checks the field with the name id to see if it's blank, is less than 10 characters,
                    // or exceeds 100 characters
                    const name = document.querySelector("#name");
                    const nameLength = name.value.length;
                    if(nameLength == 0 || nameLength < 10 || nameLength > 100) {
                        alert("The name field should have a minimum of 10 characters and a maximum of 100 characters!");
                        evt.preventDefault();
                    }

                    // checks the field with the description id to see if it's blank, is less than 10 characters,
                    // or exceeds 255 characters
                    const description = document.querySelector("#description");
                    const descriptionLength = description.value.length;
                    if(descriptionLength == 0 || descriptionLength < 10 || descriptionLength > 255) {
                        alert("The description field should have a minimum of 10 characters and a maximum of 255 characters!");
                        evt.preventDefault();
                    }

                    // checks the field with the price id to see if it's blank, exceeds $100K,
                    // is less than $0, is if it's even a valid number
                    const price = document.querySelector("#price");
                    const priceValue = parseFloat(price.value).toFixed(2);
                    const priceLength = price.value.length;
                    if(priceLength == 0 || priceValue <= 0.00 || priceValue > 100000.00 || isNaN(priceValue)) {
                        alert("The price field should not be blank, be less than or equal to $0, or exceed $100K!");
                        evt.preventDefault();
                    }
                };
                document.addEventListener("DOMContentLoaded", () => {
                    document.querySelector("#submit_button")
                    .addEventListener("click", checkAll);
                });
            </script>
            <!-- If NOT authorized, then only this error message will display in the main body -->
            <?php } else { ?>
                <li style="float: right;"><a href="login.php">Login</a></li>
                <h3>Oops, it seems you don't have the authorization to access
                    this page!<br>
                    If you have an email and password login, please click <em>Login</em>
                    to be authenticated.<br>
                    Otherwise, return to the homepage and enjoy the
                    abundance of desserts we have to offer!
                </h3>
            <?php } ?>
        </main>    
        <?php include('footer.php'); ?>
    </body>
</html>