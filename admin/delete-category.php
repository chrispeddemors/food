<?php 
    // Include constants file
    include('../config/constants.php');
    
    // (Security) Check whether the combination id and image_name matches.
    // To prevent that anyone outside admin can delete category
    if (isset($_SESSION['user']) && isset($_GET['id']) && isset($_GET['image_name']))
    {
        // Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //? Image file available ?
        if($image_name != "")
        {//Yes remove image
            $path = "../images/category/".$image_name;
            //* Unlink is a function that removes the file
            $remove = unlink($path);

            //? Failed to remove image?
            if($remove == false)
            {//Yes Show error message, redirect, terminate
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image</div>";
                header("location:".SITEURL."admin/manage-category.php");
                die();
            }
        }


        //Set Query (delete)
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute query
        $res = mysqli_query($conn, $sql);

        //Redirect to manage category with message
        if($res==true)
        {
            //Set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Category succesfully deleted</div>";
            header("location:".SITEURL."admin/manage-category.php");
            die();
        }
        else
        {
            //Set fail message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to delete category</div>";
            header("location:".SITEURL."admin/manage-category.php");
            die();
        }

    }
    else
    {
        // Redirect to same page and show message
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>
