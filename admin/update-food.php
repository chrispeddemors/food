<?php include("partials/menu.php");?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>



        <br><br>

        <!-- Authorization check -->
        <?php 
            //? Id passed in URL?
            if(isset($_GET['id']))
            {//Yes, ID passed
                //Get the id as to fetch other data in database
                $id = $_GET['id'];
                //Create SQL query to fetch other data that is linked to this ID
                $sql = "SELECT * FROM tbl_food WHERE id=$id";
                //Execute the query
                $res = mysqli_query($conn, $sql);
                //Count rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);
                //? Fetch data success?
                if($count==1)
                {//Yes, success
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $current_image = $row['image_name'];
                    $current_category = $row['category_id'];
                    $featured = $row['featured'];
                    $active = $row['active'];


                }
                else
                {//No, Data not fetched
                    $_SESSION['update'] = "<div class= 'error'>Failed to update Category [Data not fetched]</div>";
                    header("location:".SITEURL."/admin/manage-food.php");
                }

            }
            else
            {//No, ID not passed
                $_SESSION['update'] = "<div class='error'>Failed to update Category [ID not passed]</div>";   
                header("location:".SITEURL."/admin/manage-food.php");           
            }


        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <td>Price: €</td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>
                <tr>
                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php
                        //? Is there an current image?
                        if($current_image != "")
                        {//Yes, display image
                            ?>
                            <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                        else
                        {//No show error message
                            echo "<div class='error'>Image Not Added.</div>";
                        }
                        ?>
                    </td>
                </tr>                    
                    <td>New image: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Category :</td>
                    <td>
                        <select name="category" value="<?php echo $category; ?>">
                            <?php 
                                //*Fetch current categories
                                //1. Create SQL Query
                                $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //1a. Execute Query
                                $res2 = mysqli_query($conn, $sql2);
                                //? Query executed?
                                $count = mysqli_num_rows($res2);
                                if($count>0)
                                {//Yes
                                    while($row2=mysqli_fetch_assoc($res2))//*Loops the amount of returned rows 
                                    {   
                                        //Get the details of categories
                                        $category_id = $row2['id'];
                                        $category_title = $row2['title'];
                                        ?> 
                                        <option 
                                        <?php if($current_category==$category_id){echo "selected";  } ?> 
                                        value="<?php echo $category_id?>"><?php echo $category_title; ?> 
                                        </option><?php
                                    }
                                }
                                else
                                {//No 
                                    ?>
                                    <option value="0">No categories found</option>
                                    <?php
                                }
                                //2. Display on dropdown
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";}?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";}?> type="radio" name="active" value="No"> No


                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">                        
                    </td>
                </tr>                
            </table>
            <br><br><input type="submit" name="submit" value="Update Food" class="btn-secondary">
        </form>

        <?php 
        
        
        //*Save data in database
        //? Is "Update Food" Clicked?                             
        if(isset($_POST['submit']))
        {
            //Get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description= $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //Upload image if selected
            //? Is the upload button cliked?
            if(isset($_FILES['image']['name']))
            {//Yes, upload button clicked
                $image_name = $_FILES['image']['name']; 

                //? Is the image available?
                if($image_name!="")
                {//Yes, image available
                    //*Generate filename
                    //Get extension only
                    $ext = end(explode('.', $image_name));
                    //Get filename only
                    $name_only = current(explode('.', $image_name));
                    //Generate unique image name
                    $image_name = $name_only.'_'.uniqid().'.'.$ext;
                    //*Set paths
                    //Get source and destination path
                    $src_path = $_FILES['image']['tmp_name']; //Source
                    $dest_path = "../images/food/".$image_name; //Destination
                    //*Upload file
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //? Image uploaded?
                    if($upload==true)
                    {//Yes, upload success
                        //? Is there a current image?
                        if($current_image!="")
                        {//Yes, current image available
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);
                            //? Failed to delete image?
                            if($remove===false)
                            {
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove image</div>";
                                header("location:".SITEURL."admin/manage-food.php");
                                die();
                            }
                        }
                    }
                    else
                    {//No, upload failed
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                        header("location:".SITEURL."admin/manage-food.php");
                        die();
                    }

                }
                else
                {//No image not available
                    $image_name = $current_image;
                }
            }

            //Create query
            $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";
            //Execute query
            $res3 = mysqli_query($conn, $sql3);
            //? Query executed?
            if($res3==true)
            {//Yes query executed
                $_SESSION['update'] = "<div class='success'>Food updated succesfully!</div>";
                header("location:".SITEURL."admin/manage-food.php");
            }
            else
            {//No, failed to execute
                $_SESSION['update'] = "<div class='error'>Failed to update food!</div>";
                header("location:".SITEURL."admin/manage-food.php");
            }
            
                        




        }
        else
        {
            echo "Button not clicked yet";
        }
        
        
        
        ?>

    </div>
</div>



<?php include("partials/footer.php");?>