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
?>
<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>
    <body>
        <!-- styles the whole main body to a fixed width and height -->
        <main id="home">
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

            <!-- This small pair of paragraph tags serve as the intro
                 to my dessert shop and explains why I started it -->
            <p>This shop was founded on June 21, 2020 in the midst
                of the COVID-19 pandemic.
            </p>
            <p>
                It was a risky decision to start up a bussiness
                in a time when everyone was practically scared of
                even being looked at the wrong way.
            </p>
            
            <!-- START
                 Creates a div container for the first image and sentences
                 so that they align properly and don't break the page flow
            -->
            <div style="margin-bottom: none;" class="box">
                <figure style="float: right; width: 350px">
                    <img src="images/covid-panederia.jpeg"
                    class="midimages" alt="Tough times" />
                    <figcaption>Our head baker, Rosa, powering through
                    the tough trials the pandemic threw at us.</figcaption>
                </figure>

                <div id="bakeryleft">
                    <p style="text-align: right; margin-top: 90px;">
                        But I believed that's exactly why people needed
                        something like food to metaphorically<br> bring
                        them closer, rather than getting 
                        further away from one another. People <i>love</i> 
                        food,<br> and it brings people closer
                        together, so what better business than a
                        shop about desserts<br>--- everyone's favorite meal!
                    </p>
                </div>
            </div>
            <!-- /**************** END ****************/ -->


            <!-- START
                 Creates a div container for the second image and set of 
                 sentences for proper alignment and proper page flow
            -->
            <div style="margin-bottom: 65px;" class="box">
                <figure style="float: left; width: 260px;">
                    <img src="images/strawberry-torte.jpg" alt="Picture of a
                    strawberry torte" style="width: 260px; height: 225px;"/>
                    <figcaption>A tasty strawberry torte made by
                        yours truly.
                    </figcaption>
                </figure>
                
                <div id="examples" style="clear: right; display: inline-block;">
                    <p id="tortright">
                        With the love of homemade recipes, and the
                        professional equipment<br> of a proper bakery, I
                        do hope you give us a chance and find out for <br>
                        yourself why we're so loved and survived after
                        all this time.
                    </p>
                </div>
            </div>
            <!-- /**************** END ****************/ -->


            <!-- START
                 Div id "mexicantreats" contains info about additional desserts
                 that relate to my culture along with 2 final picturs to really
                 sell how delicious they are
            -->
            <div id="mexicantreats">
                <h3>
                    Additionally, out of love to my Mexican roots,
                    I also bake Mexican holiday desserts such as Rosca
                    de Reyes and other sweets like conchas on top of
                    everything else we offer.
                </h3>

                <span>
                <figure style="width: 450px;">
                    <img src="images/rosca.jpg" alt="Rosca De Reyes" 
                    style="width: 450px; height: 200px;" />
                    <figcaption>
                        Near Three Kings' Day, we bake a tasty
                        treat called Rosca de Reyes to celebrate the birth of
                        Christ. Order one when they come, they sell out fast!
                        <br><strong>* Only available in January *</strong>
                    </figcaption>
                </figure>
                </span>

                <span>
                    <figure style="width: 350px;">
                        <img src="images/conchas.jpg" 
                        alt="Conchas (candy bread)" style="width: 350px;
                        height: 200px;" />
                        <figcaption>Our second famous desserts are Mexican
                        conchas, which is baked cookie dough on the top that
                        resembles a shell, AKA, a "concha".</figcaption>
                    </figure>
                </span>
            </div>
            <!-- /**************** END ****************/ -->

        </main>
        <br><br><br><br>
        <?php include 'footer.php'; ?>
    </body>
</html>