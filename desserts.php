<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */

    // checks if a user has logged in
    session_start();
    // authenticates user credentials to access dessert_shop database
    $dsn = 'mysql:host=localhost;dbname=dessert_shop';
    $username = 'web_user';
    $password = 'pa55word';

    // catches any errors that may arise with logging into the database
    // and prints out the error
    try {
        $db = new PDO($dsn, $username, $password);
    }
    catch (PDOException $e) {
        $error_mssg = $e->getMessage();
        echo "<p>Error: $error_mssg </p>";
    }

    $dessert_id = filter_input(INPUT_GET, 'dessert_id', FILTER_VALIDATE_INT);

    // set a default value just in case so we don't break the database
    if ($dessert_id == NULL || $dessert_id == FALSE)
    {
        $dessert_id = 1;
    }
    
    // gets all columns and puts it into a 2D array so that
    // I can cycle through all the dessert IDs and category names
    $queryAllCats = 'SELECT * FROM dessertcategories
                  ORDER BY dessertCategoryID';
    $statement1 = $db->prepare($queryAllCats);
    $statement1->execute();
    $category = $statement1->fetchAll();
    $statement1->closeCursor();

    // gets the necessary columns from the dessert table, which will
    // be the actual content displayed in the table rows
    $queryAll = 'SELECT * FROM dessert
                 WHERE dessertCategoryID = :dessert_id
                 ORDER BY dessertCategoryID';
    $statement2 = $db->prepare($queryAll);
    $statement2->bindValue(':dessert_id', $dessert_id);
    $statement2->execute();
    $categories = $statement2->fetchAll();
    $statement2->closeCursor();

    // gets all columns from dessertcategories again, but will be used
    // instead to reflect the current table as a header
    $queryID = 'SELECT * FROM dessertcategories WHERE dessertCategoryID = :dessert_id';
    $statement3 = $db->prepare($queryID);
    $statement3->bindValue(':dessert_id', $dessert_id);
    $statement3->execute();
    $category_name = $statement3->fetch();
    $dessert_category = $category_name['dessertCategoryName'];
    $statement3->closeCursor();
?>

<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
    <!-- meta description tags and author name, on top of an included header file -->
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Come one, come all! Satisfy your sweet tooth
        at 2Sweet Teeth and check out what desserts we have to offer all day, all night.">
        <meta name="author" content="Anthony Hernandez">
    </head>
    <body>
        <!-- styles the whole main body to a fixed width and height -->
        <main id="dessert">
            <p style="text-align:right; margin-right: 10px;">
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
                the user's name & email can be displayed -->
            <?php
                if(isset($_SESSION['is_valid_admin'])) {
                    $name = $_SESSION['name'];
                    $email = $_SESSION['email']; 
            ?>
                <h4><?php echo "Logged In: $name<br>Email: $email"; ?></h4>
            <?php } ?>

            <!-- Sections hyperlinks that contain tables of each dessertCategoryID -->
            <aside>
                <h2>Dessert Categories</h2>
                <ul class="categories">
                       <?php foreach ($category as $dessert) : ?>
                        <li id="catlinks">
                            <a href="desserts.php?dessert_id=<?php echo $dessert['dessertCategoryID']; ?>"
                            id="links">
                            <?php echo $dessert['dessertCategoryName']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

            <br>
            <!-- Notifies user that dessert deletion is successful -->
            <?php if (!empty($sent)) { ?>
                <p><?php echo htmlspecialchars($sent); ?></p>
            <?php } ?>
            <!-- Callback to the second calling of the dessertcategories table -->
            <h2><?php echo $dessert_category; ?></h2>

            <table id="table-design">
            <!-- Lists the column names of the dessert table -->
                <tr style="background-color: #F0EAD6">
                    <th>Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>

                    <!-- Hides the Delete header column from unauthorized users -->
                    <?php
                        if(isset($_SESSION['is_valid_admin'])) {
                    ?>
                        <th>Delete</th>
                    <?php } ?>
                </tr>
                <!-- Loops through the dessert table and access each value once per row -->
                <?php foreach ($categories as $product):?>
                    <tr>
                        <td>
                            <a href="details.php?dessert_id=<?php echo $product['dessertID']; ?>">
                                <?php echo $product['dessertCode']; ?>
                            </a>
                        </td>
                        <td><?php echo $product['dessertName']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['price']; ?></td>

                        <!-- Hides the delete button from unauthorized users -->
                        <?php
                            if(isset($_SESSION['is_valid_admin'])) {
                        ?>
                            <td>
                                <form action="delete_dessert.php" method="post">
                                    <input type="hidden" name="dessert_id"
                                        value="<?php echo $product['dessertID']; ?>" 
                                        id="dessert_id" />
                                    <input type="hidden" name="dessertcategory_id"
                                        value="<?php echo $product['dessertCategoryID']; ?>" 
                                        id="dessertCat_id" />
                                    <input type="submit" value="Delete" id="delete_button"/>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>

                <!-- So as to avoid declaring the const 3 times -->
                <?php
                    if(isset($_SESSION['is_valid_admin'])) {
                ?>
                <!-- JS Code for prompting the user for a confirmation -->
                <script>
                    const confirmDelete = evt => {
                        const choice = confirm("Are you sure you want to delete this dessert?");
                        if(choice) {
                            console.log("User deleted item");
                        } else {
                            evt.preventDefault();
                            console.log("User did not delete item");
                        }
                    }
                    document.addEventListener("DOMContentLoaded", () => {
                        const deletion = document.querySelectorAll("#delete_button");
                        for(let deleteButton of deletion) {
                            deleteButton.addEventListener("click", confirmDelete);
                        }
                    });
                </script>
                <?php } ?>

            </table>
        </main>
        <?php include('footer.php'); ?>
    </body>
</html>