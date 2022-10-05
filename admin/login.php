<?php include('../config/constants.php'); ?>

<html>

    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
        
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Admin Login</h1>

            <br>
            <?php 
            
            //* Session = Login failed
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];// *Displaying Session Message
                unset ($_SESSION['login']);// *Removing Session Message 
            }

            //* Session = Please login
            if(isset($_SESSION['not-logged-in']))
            {
                echo $_SESSION['not-logged-in'];// *Displaying Session Message
                unset ($_SESSION['not-logged-in']);// *Removing Session Message 
            }            
            
            ?> 

            <br><br>

            <!-- Login form starts here -->
            <form action="" method="POST" class="text-center">
                Username :<br>
                <input type="text" name="username" placeholder="Username"> <br><br>
                Password :<br>
                <input type="password" name="password" placeholder="Password"><br> <br>
                <input type="submit" name="submit" value="Login" class="btn-primary">
            </form>
            <br><br>


            <!-- Login ends starts here -->

            <p class="text-center">Created by - Chris Peddemors</p>
        </div>



    </body>
</html>

<?php 

//* Check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //* 1. Get the data from Login Form
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //* 2. SQL Query to check if login credentials are correct
    $sql = "SELECT * from tbl_admin WHERE username = '$username' AND password = '$password'";
    
    //* 3. Execute the query
    $res = mysqli_query($conn, $sql);


    //* 4. Count rows to check if login credenials are correct
    $count = mysqli_num_rows($res);

    if($count==1)
    //? Login succesfull?
    {
        //! Login successfull
        $_SESSION['login'] = "<div class='success'>Login Succesfull!</div>";
        $_SESSION['user'] = $username; //* To check whether the user is logged in or not
        // * Redirect to admin page
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        //! Login failed
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
        // * Redirect to same page and show message
        header('location:'.SITEURL.'admin/login.php');
    }
}
else
{

}

?>