    <?php include('menu.php'); ?>

    <!-- FOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <form action="food-search.php" method="POST">
                <input type="search" name="search" placeholder="Yemek ara.." required>
                <input type="submit" name="submit" value="ARA" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Yemekleri Keşfet</h2>

            <?php
            //Create SQL Query to Display CAtegories from Database
            $sql = "SELECT * FROM tbl_category LIMIT 3";
            //Execute the Query
            $res = mysqli_query($conn, $sql);
            //Count rows to check whether the category is available or not
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                //CAtegories Available
                while ($row = mysqli_fetch_assoc($res)) {
                    //Get the Values like id, title, image_name
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>

                    <a href="category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php
                            //Check whether Image is available or not
                            if ($image_name == "") {
                                //Display MEssage
                                echo "<div class='error'>Foto bulunamadı</div>";
                            } else {
                                //Image Available
                            ?>
                                <img src="<?php echo $image_name; ?>" alt="Yemek" class="img-responsive img-curve">
                            <?php
                            }
                            ?>


                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

            <?php
                }
            } else {
                //Categories not Available
                echo "<div class='error'>Katergori Yok.</div>";
            }
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Yemek Menüsü</h2>

            <?php

            //Getting Foods from Database that are active and featured
            //SQL Query
            $sql2 = "SELECT * FROM tbl_food LIMIT 4";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Count Rows
            $count2 = mysqli_num_rows($res2);

            //CHeck whether food available or not
            if ($count2 > 0) {
                //Food Available
                while ($row = mysqli_fetch_assoc($res2)) {
                    //Get all the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
            ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            //Check whether image available or not
                            if ($image_name == "") {
                                //Image not Available
                                echo "<div class='error'>Foto bulunamadı.</div>";
                            } else {
                                //Image Available
                            ?>
                                <img src="<?php echo $image_name; ?>" alt="Yemek" class="img-responsive img-curve">
                            <?php
                            }
                            ?>

                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price"><?php echo $price; ?>tl</p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Sipariş Et</a>
                        </div>
                    </div>

            <?php
                }
            } else {
                //Food Not Available 
                echo "<div class='error'>Yemek bulumamadı.</div>";
            }

            ?>
            
            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="#">Tüm yemekleri gör</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->


    <?php include('footer.php'); ?>