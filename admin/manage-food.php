<?php include('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br>
        <?php 
           if(isset($_SESSION['add'])) 
            {
                echo $_SESSION['add']; //Displaying Session Message
                unset ($_SESSION['add']);//Removing Session Message
            }   
            if(isset($_SESSION['unauthorized'])) 
            {
                echo $_SESSION['unauthorized']; //Displaying Session Message
                unset ($_SESSION['unauthorized']);//Removing Session Message
            }            
            if(isset($_SESSION['delete'])) 
            {
                echo $_SESSION['delete']; //Displaying Session Message
                unset ($_SESSION['delete']);//Removing Session Message
            }
            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload']; //Displaying Session Message
                unset ($_SESSION['upload']);//Removing Session Message
            }
            if(isset($_SESSION['update'])) 
            {
                echo $_SESSION['update']; //Displaying Session Message
                unset ($_SESSION['update']);//Removing Session Message
            }
            if(isset($_SESSION['remove-failed'])) 
            {
                echo $_SESSION['remove-failed']; //Displaying Session Message
                unset ($_SESSION['remove-failed']);//Removing Session Message
            }
        ?>

        <br> <br> 
        <!-- Add Admin Button -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br> <br> <br>

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php 
                //Create SQL Query to get all data
                $sql = "SELECT * FROM tbl_food";

                //Excute the query
                $res = mysqli_query($conn, $sql);

                //Count rows
                $count = mysqli_num_rows($res);

                //Create ascending order ids, start with 1
                $sn = 1;

                //? Records available?
                if($count>0)
                {//Yes, records available
                    while($row=mysqli_fetch_assoc($res)) //Fetch assoc = get all the data in arrays
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    
                    ?> 
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                            <?php 
                            //? Does it contain an image?
                            if($image_name != "")
                            {//Yes, image added
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>"width="100px">
                                <?php
                            }
                            else
                            {//No image added
                                echo "<div class='error'>Image not added</div>";
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>"class="btn-secondary">Update Food</a>
                            <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name ?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>
                    <?php
                    }
                }
                else
                {//No records available
                    echo "<tr> <td colspan='7' class='error'> Food not Added Yet</td> </tr>";
                }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php')?>