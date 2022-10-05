<?php include('partials/menu.php') ?>


<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br>

        <?php   
           if(isset($_SESSION['add'])) 
            {
                echo $_SESSION['add']; //Displaying Session Message
                unset ($_SESSION['add']);//Removing Session Message
            }

            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload']; //Displaying Session Message
                unset ($_SESSION['upload']);//Removing Session Message
            }
            
        ?>
        <br>


        <!-- Add category form starts -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <!--  Category Title -->
                <tr>
                    <td>Category Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <!-- Select Image  -->
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <!-- Featured -->
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No

                    </td>
                </tr>
                <!--  Active -->
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
            </table> <!--  Submit button -->
            <br><br><input type="submit" name="submit" value="Add Category" class="btn-secondary">
        </form>
        <!-- Add category form ends -->

        <?php
        //* 1. Check and set the data
        if(isset($_POST['submit']))
        {//Yes button clicked
            // Set post
            if($_POST['title'] != "")
            {
                $title = $_POST['title'];
            }
            else
            {
                $_SESSION['upload'] = "<div class='error'>Please enter the category title</div>";
                //Redirect to same page
                header('location:'.SITEURL.'admin/add-category.php');
                //Stop the process (do not execute)
                die();
            }

            //? Featured clicked?
            if(isset($_POST['featured']))
            {// Yes, set post
                
                $featured = $_POST['featured'];
            }
            else
            {// No, set default value   
                $featured = "No";
            }
            
            //? Active clicked?
            if(isset($_POST['active']))
            {// Yes, set post
                $active = $_POST['active'];
            }
            else
            {// No, set default value   
                $active = "No";
            }            

            //? Image selected?
            if(isset($_FILES['image']['name']))
            {// Yes, upload image
                $image_name = $_FILES['image']['name'];

                if($image_name != "")
                {
                    
                    //*Get extension
                    $ext = end(explode('.', $image_name));
                    // explode = split | end = last section of the split
                    // e.g. input = small.jpg | output = jpg
                    //*Get filename only
                    $name_only = current(explode('.', $image_name));
                    // explode = split | current = first section of the split

                    //*Generate unique image name
                    $image_name = $name_only.'_'.uniqid().'.'.$ext;
                    //Output = name_only + unique_id + ext
                    //e.g. hamburger_625fffa3afd2d.jpg

                    $source_path = $_FILES['image']['tmp_name'];
                    
                    $destination_path = "../images/category/".$image_name;

                    //Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //? Image uploaded?
                    if($upload==false)
                    {// No, show message
                        $_SESSION['upload'] = "<div class='error'>Please select an image</div>";
                        //Redirect to same page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //Stop the process (do not execute)
                        die();
                    }
                }
            }
            else
            {// No, set as NULL
                $image_name ="";    
            }



            //* 2. SQL Query to save the data into database
            $sql = "INSERT INTO tbl_category SET
            title = '$title',   
            image_name = '$image_name',
            featured = '$featured' ,
            active = '$active'";

            //* 3. Excecuting Query and Saving data into database
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            //?  Query executed?
            if($res=TRUE)
            {// Yes
                $_SESSION['add'] = "<div class='success'>Category Added Successfully!</div>";
                // Redirect to manage-category.php
                header("location:".SITEURL.'/admin/manage-category.php');
            }
            else
            {// No
                $_SESSION['add'] = "<div class='error text-center'>Failed to add Category!</div>";
                // Redirect to same page
                header("location:".SITEURL.'/admin/add-category.php');
            }            

        }
        ?>
    </div>

</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php') ?>