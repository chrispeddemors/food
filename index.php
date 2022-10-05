<?php include('partials-front/menu.php') ;?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //Create SQL query to display categories from database
                $sql = "SELECT * FROM tbl_category 
                        WHERE featured = 'Yes' AND active = 'Yes' LIMIT 3;";

                //Execute query
                $res = mysqli_query($conn, $sql);
                //? Categories available?
                if(mysqli_num_rows($res) > 0)
                {//Yes, categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get values like id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                            <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id ?>">
                                <div class="box-3 float-container">
                                    <?php

                                    //? Image available?
                                    if($image_name!="")
                                    {//Yes, image available
                                         ?>
                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                         <?php                                        
                                    }
                                    else
                                    {//No Image available
                                        ?>

                                        <img src="<?php echo SITEURL;?>images/no-image.jpg" alt="<?php echo $title; ?>" class="img-responsive img-curve">            
                                        <?php
                                        

                                    }
                                    
                                    ?>
                                        
                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php

                    }
                }
                else
                {//No category available
                    echo "<div class='error'>No Categories available</div>";
                }

            
            ?>




            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            $mysql = "SELECT * FROM tbl_food WHERE active = 'Yes'";
            $res = mysqli_query($conn, $mysql);
            if(mysqli_num_rows($res) > 0)
            {//Query executed
                while($row=mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];



                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                if($image_name !="")
                                {
                                    ?>
                                    <img src="<?php SITEURL;?>images/food/<?php echo $image_name ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <img src="<?php SITEURL;?>images/no-image.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            
                            ?>
                        </div>
                    
                        <div class="food-menu-desc"> 
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price"><?php echo $price ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>
                    
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id ?>" class="btn btn-primary">Order Now</a>
                        </div>
                      </div>                    
                    <?php
                }
            }
            else
            {//Query not executed
                echo "Food not available";
            }          
            
            ?>

           


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->


<?php include('partials-front/footer.php'); ?>