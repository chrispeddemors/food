<?php 
    include('../config/constants.php');
    include('partials/auth.php');

    if (isset($_SESSION['user']))
    {
        // * Include constants.php file here
        include('../config/constants.php');

        // *1. Get the ID of the Admin to be deleted
        $id = $_GET['id'];

        // *2. Create SQL Query to delete admin
        $sql = "DELETE FROM tbl_admin WHERE id=$id";

        // *3. Execute the query
        $res = mysqli_query($conn, $sql);

        // * Check whether the query is executed successfully or not
        if ($res==true)
        {
            // * Query executed succesfully and admin deleted
            // echo "Admin Deleted";
            // * Create session variable to display message
            $_SESSION['delete'] = "<div class='success'>Admin Deleted Succesfully</div>";
            // * Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // * Failed to delete admin
            $_SESSION['delete'] = "<div class='failed'>Failed to Delete Admin</div>";
            // * Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
?>


