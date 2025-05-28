<?php
    /*
    Anthony Hernandez
    April 7, 2023
    IT 202-006
    Unit 11 Assignment Final Phase
    ah727@njit.edu
    */
    session_start();
    require_once('database.php');

    $dessert_id = filter_input(INPUT_GET, 'dessert_id', FILTER_VALIDATE_INT);

    // set a default value just in case so we don't break the database
    if ($dessert_id == NULL || $dessert_id == FALSE)
    {
        $dessert_id = 1;
    }

    $query = 'SELECT * FROM dessert
                  WHERE dessertID = :dessert_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':dessert_id', $dessert_id);
    // used to verify whether the dessert id exists or not
    $statement->execute();
    $categories = $statement->fetch();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
    <!-- meta description tags and author name, on top of an included header file -->
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Have a sweet tooth, or two? Take a look at
        detailed descriptions of our desserts so you can gouge what you'd really like
        to sink your teeth into!">
        <meta name="author" content="Anthony Hernandez">
    </head>
    <body>
        <!-- styles the whole main body to a fixed width and height -->
        <main id="details">
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
            <?php if($categories != false) { ?>
                <figure id="dessert-showoff">
                    <img id="dessert-image" src="images/<?php echo $categories['dessertID']; ?>-bw.jpg" />
                    <figcaption style="text-align: center; color: purple; font-weight: bold">
                        Hover your mouse over the image for a colored version.
                    </figcaption>
                </figure>
                <br>
                <div id="detail-styling">
                    <label><?php echo "<strong>Dessert ID</strong>: " . $categories['dessertID']; ?></label>
                    <label><?php echo "<strong>Category ID</strong>: " . $categories['dessertCategoryID']; ?></label>
                    <label><?php echo "<strong>Dessert Code</strong>: " . $categories['dessertCode']; ?></label>
                    <label><?php echo "<strong>Dessert Name</strong>: " . $categories['dessertName']; ?></label>
                    <label><?php echo "<strong>The Description</strong>: " . $categories['description']; ?></label>
                    <label><?php echo "<strong>Dessert Price</strong>: " . $categories['price']; ?></label>
                    <label><?php echo "<strong>Date Added</strong>: " . $categories['dateAdded']; ?></label>
                </div>
                <br>
                <script>
                    const colorChange = () => {
                        const coloredImage = document.querySelector("#dessert-image");
                        coloredImage.src="images/<?php echo $categories['dessertID']; ?>-color.jpg";
                        console.log("image src = " + coloredImage.getAttribute("src"));
                    };
                    const bwChange = () => {
                        const bwImage = document.querySelector("#dessert-image");
                        bwImage.src="images/<?php echo $categories['dessertID']; ?>-bw.jpg";
                        console.log("image src = " + bwImage.getAttribute("src"));
                    };

                    document.addEventListener("DOMContentLoaded", () => {
                        document.querySelector("#dessert-image").addEventListener("mouseenter", colorChange);

                        document.querySelector("#dessert-image").addEventListener("mouseleave", bwChange);
                    });
                </script>
            <?php } else { ?>
                <p>Looks like that dessert doesn't exist! Please try selecting from the desserts that
                we do have and treat yourself!</p>
            <?php } ?>
        </main>
        <?php include('footer.php'); ?>
    </body>
</html>