<?php include('../config/constants.php');

    //? Are all the mandatory values passed in the url?
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {//Yes, all values passed
        echo "Match!";

        //* Remove the image if available
        // Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //? Is the image available?
        if($image_name != "")
        {//Yes, image available
            //Set the path to delete image
            $path = "../images/food/".$image_name;
            //Remove image file from folder
            $remove = unlink($path);
            //? Failed to remove?
            if($remove != true)
            {//Yes failed to remove
                $_SESSION['upload'] = "<div class= 'error'>Failed to remove image</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
            
        }
        //Query to delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";        
        //Execute the query 
        $res = mysqli_query($conn, $sql);

        //? Query executed failed?
        if($res==true)
        {//Yes failed
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
                
        }
        else
        {
        // Redirect and show message
        $_SESSION['delete'] = "<div class='error'>Failed to delete</div>";
        header('location:'.SITEURL.'admin/manage-food.php');

        }


    }
    else
    {//No, values not passed
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>