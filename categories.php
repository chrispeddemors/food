<?php

use function PHPSTORM_META\map;

 include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
            
            //Create SQL query to display categories from database
            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'" ;
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
                        if($image_name != "")
                        {//Yes, image available
                            ?>
                            <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        else
                        {//No image available
                            echo "<div class='error'>Image not found</div>";
                        }
                        
                        ?>

        
                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                    </a>
                    <?php
                }
            }
            else
            {//No categories available
                echo "No categories available";
            }
            
            
            ?>




            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


  <?php include('partials-front/footer.php'); ?>