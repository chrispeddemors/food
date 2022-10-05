<?php include('partials/menu.php') ?>



<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
           if(isset($_SESSION['add'])) //Checking whether the session is set or not
            {
                echo $_SESSION['add']; //Displaying Session Message
            
                //? IF YOU REFRESH THE PAGE, MESSAGE WILL BE GONE :
                unset ($_SESSION['add']);//Removing Session Message
            
            }
        ?>
 
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Full Name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Username"></td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td><input type="text" name="email" placeholder="Email"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Password"></td>
                </tr>
            </table>
            <br>
            <!-- button -->
            <input type="submit" name="submit" value="Add Admin + Close" class="btn-secondary">
            <!-- button -->
            <input type="submit" name="submit-new" value="Add Admin + New" class="btn-secondary">
        </form>


    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php')?>

<?php 
    
    // 1. Get the data from the form
    if (isset($_POST['submit']))
    {
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Encrypt the password
        

    // 2. SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username' ,
        email = '$email',
        password = '$password' 
    ";

    // 3. Excecuting Query and Saving data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 4. Check whether the (Query is executed) data is inserted or not and display appropriate message
        if($res=TRUE)
        {
            // Data inserted
            // echo "Data Inserted"
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully!</div>";
            // Redirect page to Manage Admin
            header("location:".SITEURL.'/admin/manage-admin.php');
        }
        else
        {
            // Failed to insert data
            // echo "Failed to insert data";
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Failed to Add Admin</div>";
            // Redirect page to Add Admin
            header("location:".SITEURL.'/admin/add-admin.php');
        }

    }
    if (isset($_POST['submit-new']))
    {
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Encrypt the password
        

    // 2. SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username' ,
        email = '$email',
        password = '$password' 
    ";

    // 3. Excecuting Query and Saving data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 4. Check whether the (Query is executed) data is inserted or not and display appropriate message
        if($res=TRUE)
        {
            // Data inserted
            // echo "Data Inserted"
            // Create a session variable to display message
            $_SESSION['add'] = "Admin Added Successfully!";
            // Redirect page to Manage Admin
            header("location:".SITEURL.'/admin/add-admin.php');
        }
        else
        {
            // Failed to insert data
            // echo "Failed to insert data";
            // Create a session variable to display message
            $_SESSION['add'] = "Failed to Add Admin";
            // Redirect page to Add Admin
            header("location:".SITEURL.'/admin/add-admin.php');
        }

    }
?>