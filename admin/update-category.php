<?php include("partials/menu.php")?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        
        <br><br>

        <?php

            //* Check Whether id is set or not
            if(isset($_GET['id']))
            {
                //Get the id and all other details
                $id = $_GET['id'];
                //Create SQL Query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);

                //?Is the data fetched?
                if($count==1)
                {//Yes
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {//No
                    //Redirect to manage-category.php with message
                    $_SESSION['no-category-found'] = "<div class='error'>Category not found</div>";
                    header('location:'.SITEURL.'/admin/manage-category.php');
                }
            }
            else
            {
                //Redirect to manage-category and show message
                $_SESSION['update'] = "<div class='error'>Pass an id</div>";
                header("location:".SITEURL."/admin/manage-category.php");
            }

        ?>



        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php
                        //? Is there an current image?
                        if($current_image != "")
                        {//Yes, display image
                            ?>
                            <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                        else
                        {//No show error message
                            echo "<div class='error'>Image Not Added.</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </td>
                </tr>
            </table>
            <br><br><input type="submit" name="submit" value="Update Category" class="btn-secondary">
        </form>

        <?php 
        
        //* -- SAVE DATA IN DATABASE --
        //? Is "Update Category" Clicked?
        if(isset($_POST['submit']))
        {
            //1. Get all the values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];           
            
            //2. Updating new image if selected

            //? Button "New Image" Clicked?
            if(isset($_FILES['image']['name']))
            {//Yes, get image details
                $image_name = $_FILES['image']['name'];

                //? Image clicked, but also uploaded?
                if($image_name != "")
                {//Yes, upload new image and remove current image
                    //Get extension
                    $ext = end(explode('.', $image_name));
                    // explode = split | end = last section of the split
                    // e.g. input = small.jpg | output = jpg
                    //Get filename only
                    $name_only = current(explode('.', $image_name));
                    // explode = split | current = first section of the split

                    //Generate unique image name
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
                        header('location:'.SITEURL.'admin/manage-category.php');
                        //Stop the process (do not execute)
                        die();
                    }         
                    
                    //Remove current image if available
                    if($current_image != "")
                    {
                        $remove_path = "../images/category/".$current_image;

                        $remove = unlink($remove_path);
    
                        //? Current image removed?
                        if($remove==false)
                        {//No, failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove Image</div>";
                            header("location:".SITEURL."admin/manage-category.php");
                            die();
                        }
                    }
                
                }
                else
                {//
                    $image_name = $current_image;
                }
            }
            else
            {//No, set current image
                $image_name = $current_image;
            }

            //3. Update the database
            $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";
            //Execute the query
            $res2 = mysqli_query($conn, $sql2);

            //4. Redirect to manage-cateogory page and show message

            //? Query executed? 
            if($res2 == true)
            {//Yes, category is updated
                $_SESSION['update'] = "<div class = 'success'>Category updated succesfully!</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                $_SESSION['update'] = "<div class = 'error'>Failed to update Category!</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }
        ?>
    </div>
</div>




<?php include("partials/footer.php")?>

