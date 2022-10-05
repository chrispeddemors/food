<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <?php 
           if(isset($_SESSION['add'])) 
            {
                echo $_SESSION['add']; //Displaying Session Message
                unset ($_SESSION['add']);//Removing Session Message
            
            }

            if(isset($_SESSION['remove'])) 
            {
                echo $_SESSION['remove']; //Displaying Session Message
                unset ($_SESSION['remove']);//Removing Session Message
            
            }

            if(isset($_SESSION['delete'])) 
            {
                echo $_SESSION['delete']; //Displaying Session Message
                unset ($_SESSION['delete']);//Removing Session Message
            
            }

            if(isset($_SESSION['update'])) 
            {
                echo $_SESSION['update']; //Displaying Session Message
                unset ($_SESSION['update']);//Removing Session Message
            }

            if(isset($_SESSION['no-category-found'])) 
            {
                echo $_SESSION['no-category-found']; //Displaying Session Message
                unset ($_SESSION['no-category-found']);//Removing Session Message
            }

            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload']; //Displaying Session Message
                unset ($_SESSION['upload']);//Removing Session Message
            }            

            if(isset($_SESSION['failed-remove'])) 
            {
                echo $_SESSION['failed-remove']; //Displaying Session Message
                unset ($_SESSION['failed-remove']);//Removing Session Message
            }            


        ?>

        <br> <br> <br>
        <!-- Add Admin Button -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br> <br> <br>

        <!-- Table Section Starts -->
        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php 
                //Query to show all rows from database
                $sql = "SELECT * FROM tbl_category";

                //Execute query
                $res = mysqli_query($conn, $sql);

                //Count rows
                $count = mysqli_num_rows($res);

                $nr = 1; //* Create a variable and assign the value


                //?Is there data in database?
                if($count>0)
                {//Yes, fetch data and display
                    //?Show results as long as we have data in database
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        <tr>
                            <td><?php echo $nr++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>
                            <?php
                                //Is the image name not null?
                                if($image_name!="")    
                                {//No show image
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>"width="100px">
                                    <?php

                                }
                                else
                                {//Yes show message
                                    echo "<div class='error'>Image not added</div>";
                                }
                        

                            ?>
                              
                              </td>
                            
                            
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id ?>&image_name=<?php echo $image_name?>" class="btn-danger">Delete Category</a>
                            </td>
                        </tr>

                        <?php
                    }

                }
                else
                {//No, display message in table
                    ?>
                    <tr>
                        <td><div class="error">No Category Added</div></td>
                    </tr>
                    <?php
                }
            
            
            ?>

        </table>
        <!-- Table Section Ends -->
    </div>
</div>
<!-- Main Content Section Ends -->
<?php include('partials/footer.php');?>