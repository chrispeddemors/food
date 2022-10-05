<?php include('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br>

        <?php 

            //* Fetch the id
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }

            //* Session = Current password incorrect
            if(isset($_SESSION['password-incorrect']))
            {
                echo $_SESSION['password-incorrect'];// *Displaying Session Message
                unset ($_SESSION['password-incorrect']);// *Removing Session Message 
            }

            //* Session = Password not matched
            if(isset($_SESSION['password-not-matched']))
            {
                echo $_SESSION['password-not-matched'];// *Displaying Session Message
                unset ($_SESSION['password-not-matched']);// *Removing Session Message 
            }

            //* Session = Password not changed
            if(isset($_SESSION['password-not-changed']))
            {
                echo $_SESSION['password-not-changed'];// *Displaying Session Message
                unset ($_SESSION['password-not-changed']);// *Removing Session Message 
            }            
            



        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>

                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>

                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </td>
                </tr>
                <br>
            </table>
            <br>
            <input class="btn-secondary " type="submit" name="submit" value="Change Password">


        </form>

    </div>
</div>
<!-- Main Content Section Ends -->

<?php 
    //* Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //* 1. Get data from the form
        $id=$_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //* 2. Check whether the user with current id and current pass matches or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        //* Execute the query
        $res = mysqli_query($conn, $sql);
        
        if($res==true)
        {
            $count=mysqli_num_rows($res);

            //? Is the current password correct?
            if($count==1)
            {
                //! Current password correct

                //? Does the new passwords match?
                if($new_password==$confirm_password)
                {
                    //! New passwords matched
                     //* Update the password
                    $sql2 = "UPDATE tbl_admin SET
                    password = '$new_password'
                    WHERE id=$id
                    ";
                    //* Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //* Check whether the query is executed or not
                    if($res2==true)
                    {
                        //* Display message
                        $_SESSION['password-changed'] = "<div class='success'>Password updated succesfully</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //* Display error message
                        $_SESSION['password-not-changed'] = "<div class='error'>Failed to change Password</div>";
                        //* Redirect to the same page
                        header('location:'.SITEURL.'admin/change-password.php?id='.$id);
                    }


                }
                else
                {
                  //! New passwords not matched
                  //* Redirect to manage admin page and show error message
                  $_SESSION['password-not-matched'] = "<div class='error'>The passwords do not match, please try again.</div>";
                  //* Redirect to the same page
                  header('location:'.SITEURL.'admin/change-password.php?id='.$id);
                }
            }
        else
        {
            //! Current password not correct
            $_SESSION['password-incorrect'] = "<div class='error'>The current password is incorrect, please try again.</div>";
            //* Redirect the same page
            header('location:'.SITEURL.'admin/change-password.php?id='.$id);
        }
        }
        

        //* 3. Check whether the new Password and confirm Password match or not

        //* 4. Change password if all above is true
    }


?>

<?php include('partials/footer.php')?>