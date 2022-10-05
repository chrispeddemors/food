<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update order</h1>
        <br><br>
        <?php 
        //Check if is set, otherwise redirect
        if(isset($_GET['id']))
        {//Id is set
            //Fetch data with id
            $id = $_GET['id'];
            //Query
            $sql = "SELECT * FROM tbl_order WHERE id = $id";
            //Execute query
            $res = mysqli_query($conn, $sql);
            //Count results
            $count = mysqli_num_rows($res);
            //Validate execution
            if($count==1)
            {//Fetch data
                $row=mysqli_fetch_assoc($res);
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $total = $row['total'];
                $order_date = $row['order_date'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_adress = $row['customer_adress'];
            }
            else
            {
                $_SESSION['update'] = "<div class='error'>Failed to update order</div>";
                header("location:".SITEURL."admin/manage-order.php");
            }

        }
        else
        {//Id is not set, redirect
            $_SESSION['update'] = "<div class='error'>Failed to update order</div>";
            header("location:".SITEURL."admin/manage-order.php");
        }
        ?>
        <form action="" method="post">
        <table class="tbl-30">

        <!-- Order Section -->
            <tr>
                <td>Food Name</td>
                <td><?php echo $food?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><?php echo "$".$price?></td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td><input type="number" name="qty" value="<?php echo $qty ?>"></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <select name="status">
                        <option <?php if($status =="Ordered"){echo "selected";} ?> value="Ordered" >Ordered</option>
                        <option <?php if($status =="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                        <option <?php if($status =="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                        <option <?php if($status =="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                    </select>
                </td>
            </tr>
            
            
            <!-- Customer Section -->
            <tr>
                <td>Customer Name</td>
                <td><input type="text" name="customer_name" value="<?php echo $customer_name ?>"></td>
            </tr>
            <tr>
                <td>Customer Contact</td>
                <td><input type="text" name="customer_contact" value="<?php echo $customer_contact ?>"></td>
            </tr>
            <tr>
                <td>Customer Email</td>
                <td><input type="text" name="customer_email" value="<?php echo $customer_email ?>"></td>
            </tr>
            <tr>
                <td>Customer Adress</td>
                <td><textarea name="customer_adress" cols="30" rows="5" value=""><?php echo $customer_adress ?></textarea></td>
            </tr>

        </table>
        <!-- Submit button -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="price" value="<?php echo $price; ?>">
        <br><br><input type="submit" name="submit" value="Update Order" class="btn-secondary">
        </form>

        <?php
        //Check if submit is clicked
        if(isset($_POST['submit']))
        {
            //Get all values from the form
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_adress = $_POST['customer_adress'];
            //Update values
            $sql2 = "UPDATE tbl_order SET
                qty = $qty,
                total = $total,
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_adress = '$customer_adress'
                WHERE id=$id
                ";
            //Execute query
            $res2 = mysqli_query($conn,$sql2);
            //Validate execution
            if($res2 == true)
            {//Executed succesfully, redirect to page
                $_SESSION['update'] = "<div class='success'>Order succesfully updated</div>";
                header("location:".SITEURL."admin/manage-order.php");
            }
            else
            {//Failed to update order
                $_SESSION['update'] = "<div class='error'>Failed to update order</div>";
                header("location:".SITEURL."admin/manage-order.php");
            }


        }
    
        ?>

        <?php

        ?>
    </div>
</div>
<?php include('partials/footer.php') ?>