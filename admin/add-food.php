<?php include('partials/menu.php') ?>
<div class="main-content">

    <div class="wrapper">
        <h1>Add Food</h1>

        <br>
        <?php 
           if(isset($_SESSION['upload'])) 
           {
               echo $_SESSION['upload']; //Displaying Session Message
               unset ($_SESSION['upload']);//Removing Session Message
           }        
           if(isset($_SESSION['add'])) 
           {
               echo $_SESSION['add']; //Displaying Session Message
               unset ($_SESSION['add']);//Removing Session Message
           }      
        ?>
        <br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Title"></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Description"></textarea></td>
                </tr>
                <tr>
                    <td>Price: €</td>
                    <td><input type="number" name="price" placeholder="Price"></td>
                </tr>
                <tr>
                    <td>Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Category :</td>
                    <td>
                        <select name="category">
                            <?php 
                                //*Fetch current categories
                                //1. Create SQL Query
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //1a. Execute Query
                                $res = mysqli_query($conn, $sql);
                                //? Query executed?
                                $count = mysqli_num_rows($res);
                                if($count>0)
                                {//Yes
                                    while($row=mysqli_fetch_assoc($res))//*Loops the amount of returned rows 
                                    {
                                        //Get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id ;?>"><?php echo $title ;?></option>
                                         <?php 
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
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>                
            </table>
            <br><br><input type="submit" name="submit" value="Add Food" class="btn-secondary">
        </form>

        <?php 
        //* Insert in database

        //? Is the submit button clicked?
        if(isset($_POST['submit']))
        {//Yes, button clicked
            //1. Get data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            // Check whether radio button for featured/active are checked or not
            //? Is featured yes?
            if(isset($_POST['featured']))
            {// Yes, featured is yes
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "No";
            }
            //? Is active yes?
            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No";
            }
            //2. Upload the image if selected
            //? Is "select image" button clicked?
            if(isset($_FILES['image']['name']))
            {//Yes, select image is clicked
                $image_name = $_FILES['image']['name'];
                //? Is there a file uploaded?
                if($image_name!="")
                {
                    //* Generate image name
                    //Get extension only
                    $ext = end(explode('.' , $image_name));
                    //Get filename only
                    $name_only = current(explode('.', $image_name));
                    //Generate unique image name
                    $image_name = $name_only.'_'.uniqid().'.'.$ext;

                    //* Upload image
                    //Get the temp path
                    $src=$_FILES['image']['tmp_name'];
                    //Set the destination path
                    $destination_path = "../images/food/".$image_name;
                    //Upload the file
                    $upload = move_uploaded_file($src, $destination_path);

                    //? Upload succesfully?
                    if($upload==true)
                    {//Yes, upload success

                    }
                    else
                    {//No, upload failed
                        $_SESSION['upload'] = "<div class='error'>Please select an image</div>";
                        //Redirect to same page
                        header('location:'.SITEURL.'admin/add-food.php');
                        // //Stop the process (do not execute)
                        // die();                        
                    }
                }
            } 
            else
            {//No, select image not clicked
                $image_name = "";
            }

            //3. Insert into database
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category, 
                featured = '$featured',
                active = '$active'

                ";
            //4. Redirect and show message
            $res2 = mysqli_query($conn, $sql2);

            if($res2=TRUE)
            {// Yes
                $_SESSION['add'] = "<div class='success'>Food Added Successfully!</div>";
                // Redirect to manage-category.php
                header("location:".SITEURL.'/admin/manage-food.php');
            }
            else
            {// No
                $_SESSION['add'] = "<div class='error text-center'>Failed to add Food!</div>";
                // Redirect to same page
                header("location:".SITEURL.'/admin/add-food.php');
            }            


            
        }
        ?>

    </div>


</div>



<?php include('partials/footer.php') ?>