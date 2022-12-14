<?php include('partials-front/menu.php')?>

    <?php 

    //Check if the food id is set
    if(isset($_GET['food_id']))
    {//Id is set
        //Get the details of the selected food
        $food_id = $_GET['food_id'];
        $sql = "SELECT * FROM tbl_food WHERE id = '$food_id'";
        $res = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($res);
        //Check if food details are available
        if($count > 0)
        {//Food details available
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else
        {//No food details available
            header("location:".SITEURL);
        }

    }
    else
    {//Id is not set, redirect to home page
        header("location:".SITEURL);
    }


    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                        if($image_name!="")
                        {//Image available
                            ?><img src="images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve"><?php
                        }
                        else
                        {//Image not available
                            ?> <img src="images/no-image.jpg" alt="<?php echo $title; ?>"class="img-responsive img-curve"> <?php
                        }
                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title;?></h3>
                        <input type="hidden" name="title" value=<?php echo $title; ?>>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                //Check if submit button is clicked
                if(isset($_POST['submit']))
                {//Submit button is clicked
                    //id 	food 	price 	qty 	total 	order_date 	status 
                    $food = $_POST['title'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;
                    $order_date = date("Y-m-d h:i:s"); //Order date
                    $status = "Ordered";//Ordered, On Delivery, Delivered,Cancelled

                    //	customer_name 	customer_contact 	
                    $customer_name = $_POST["full-name"];
                    $customer_contact = $_POST['contact'];
                    //customer_email 	customer_adress 	
                    $customer_email = $_POST['email'];
                    $customer_adress = $_POST['address'];

                    //Insert in database
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = '$price',
                        qty = $qty,
                        total = '$total',
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_adress = '$customer_adress'
                    ";
                    // echo $sql2;

                    //Execute the query
                    $res2 = mysqli_query($conn, $sql2);
                    //Check if execution is done
                    if($res2==true)
                    {//Yes, order saved
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Succesfully</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {//Order not saved
                        $_SESSION['order'] = "<div class='error text-center'>Failed to order food</div>";
                        header('location:'.SITEURL);
                    } 

                }
                else
                {

                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php')?>
