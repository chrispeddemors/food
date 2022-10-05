<?php include('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br> <br> <br>
        <!-- Add Admin Button -->
        <a href="#" class="btn-primary">Add Order</a>
        <br> <br> <br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Customer Email</th>
                <th>Customer Adress</th>
                <th>Actions</th>
            </tr>

            <?php
            //Get data from database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            //Serial number to count the rows
            $sn = 1;
            if($count>0)
            {//Orders available
                while($row=mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
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

                    ?>

                    <tr>
                
                        <!-- id 	food 	price 	qty 	  -->
                        <td><?php echo $sn++ ?></td>
                        <td><?php echo $food ?></td>
                        <td><?php echo $price ?></td>
                        <td><?php echo $qty ?></td>                        
                        <!-- total 	order_date 	status 	customer_name 	 -->
                        <td><?php echo $total ?></td>
                        <td><?php echo $order_date ?></td>
                        <td><?php echo $status ?></td>
                        <td><?php echo $customer_name ?></td>
                        <!-- customer_contact 	customer_email 	customer_adress  -->
                        <td><?php echo $customer_contact ?></td>
                        <td><?php echo $customer_email ?></td>
                        <td><?php echo $customer_adress ?></td>

                        <td>
                            <!-- <a href="#" class="btn-secondary">Update Admin</a> -->
                            <!-- <a href="#" class="btn-danger">Delete Admin</a> -->
                        </td>
                    </tr>

                    <?php


                }
            }
            else
            {//No orders available
                echo "<tr><td colspan ='12' class='error'>No orders available</td></tr>";
            }
            ?>  


        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php')?>