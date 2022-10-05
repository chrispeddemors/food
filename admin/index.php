<?php include('partials/menu.php') ?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Dashboard</h1>
            <br>
            <?php 
            
            //* Session = Login Succes
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];// *Displaying Session Message
                unset ($_SESSION['login']);// *Removing Session Message 
            }
            
            ?> 
            <br>
            <div class="col-4 text-center">
                <?php 
                    //Create Query
                    $sql = "SELECT * FROM tbl_category";
                    //Execute
                    $res = mysqli_query($conn, $sql);
                    //Validate
                    $count = mysqli_num_rows($res);

                ?>
                <h1><?php echo $count ?></h1>
                <br>
                Categories
            </div>

            <div class="col-4 text-center">
                <?php 
                    //Create Query
                    $sql2 = "SELECT * FROM tbl_food";
                    //Execute
                    $res2 = mysqli_query($conn, $sql2);
                    //Validate
                    $count2 = mysqli_num_rows($res2);
                ?>
                <h1><?php echo $count2 ?></h1>
                <br>
                Foods
            </div>

            <div class="col-4 text-center">
                <?php
                //Create Query 
                $sql3 = "SELECT * FROM tbl_order";
                //Execute
                $res3 = mysqli_query($conn, $sql3);
                //Validate
                $count3 = mysqli_num_rows($res3);
                ?>
                <h1><?php echo $count3 ?></h1>
                <br>
                Total orders
            </div>

            <div class="col-4 text-center">
                <?php 
                //Create query
                $sql4 = "SELECT SUM(total) AS Total FROM tbl_order";
                //Execute
                $res4 = mysqli_query($conn, $sql4);
                //Validate
                $row = mysqli_fetch_assoc($res4);
                $total_earned = $row['Total'];
                ?>
                <h1>$ <?php echo $total_earned ?></h1>
                <br>
                Total earned
            </div>

            <div class="clearfix"></div>
        </div>

    </div>
    <!-- Main Content Section Ends -->

   <?php include('partials/footer.php')?>
