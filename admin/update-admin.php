<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
            // ? SET UP THE FORM AND ATTACH TABLES TO IT
            //* 1. Get the ID of selected admin
            $id=$_GET['id'];

            //* 2. Create SQL Query to get the details
            $sql="SELECT * FROM tbl_admin WHERE id=$id;";

            //* 3. Execute the query
            $res=mysqli_query($conn, $sql);

            //* 4. Check whether the query is executed or not
            if($res==true)
            {
                //* Check whether the data is available or not
                $count = mysqli_num_rows($res);
                //* Check whether we have admin data or not
                if($count==1)
                {
                    //* Get the details 
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                    $email = $row['email'];
                }
                else
                {
                    //* Rededirect to Manage Admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else{//* 
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Full Name" value ="<?php echo $full_name; ?>"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Username" value ="<?php echo $username; ?>"></td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td><input type="text" name="email" placeholder="Email" value ="<?php echo $email; ?>"></td>
                    <!--  Hidden input to pass the id to database -->
                    <td><input type="hidden" name="id" value="<?php echo $id; ?>"></td>
                </tr>

            </table>
            <br>

            <!-- button -->
            <input type="submit" name="submit" value="Update Admin" class="btn-secondary">

        </form>
    </div>


</div>


<?php 
    //* Check whether the Submit Button is clicked or not
    if(isset($_POST['submit']))
        //* Button is clicked
    {
        //* Get all the values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        //* Create SQL Query to update Admin
        $sql = "UPDATE tbl_admin SET 
        full_name = '$full_name',
        username = '$username',
        email = '$email'
        WHERE id='$id'
        ";

        //* Execute the query
        $res = mysqli_query($conn, $sql);

        //* Check whether the query is executed succesfully or not
        if($res==true)
        {
            //* Query executed and Admin Updated
            $_SESSION['update'] = "<div class='success'>Admin Updated Succesfully!</div>";
            //* Redirect to Manage Admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //* Failed to update Admin
            $_SESSION['update'] = "<div class='error'>Update Admin Failed</div>";
            //* Redirect to Update Admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
?>

<?php include('partials/footer.php') ?>