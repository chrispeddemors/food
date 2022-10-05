<?php include('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>
        <?php
            // * Session = Add
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];// *Displaying Session Message
                unset ($_SESSION['add']);// *Removing Session Message 
            }

            //* Session = Delete
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];// *Displaying Session Message
                unset ($_SESSION['delete']);// *Removing Session Message 
            }
            
            //* Session = Update
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];// *Displaying Session Message
                unset ($_SESSION['update']);// *Removing Session Message 
            }
            //* Session = Update
            if(isset($_SESSION['password-changed']))
            {
                echo $_SESSION['password-changed'];// *Displaying Session Message
                unset ($_SESSION['password-changed']);// *Removing Session Message 
            }



        ?>

        <br> <br> <br>


        <!-- Add Admin Button -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php
            // *Query to get all Admins
            $sql = "SELECT * FROM tbl_admin";
            // *Execute the query
            $res = mysqli_query($conn, $sql);
            // *Check whether the query is executed or not
            if ($res==TRUE)
            {
                // *Count rows to check whether we have data in database or not
                $count = mysqli_num_rows($res); //*Function to get all the rows in database

                $nr = 1; //* Create a variable and assign the value

                // *Check the num of rows
                if ($count>0)
                {
                    // *We have data in database
                    while($rows=mysqli_fetch_assoc($res))
                    {
                        // *Using while loop to get all the data from database
                        // *And while loop will run as long as we have data in database

                        // *Get individual data
                        $id=$rows['id'];
                        $full_name=$rows['full_name'];
                        $username=$rows['username']; 
                        $email=$rows['email']; 

                        // *Display the values in our table
                        ?>

                       <tr>
                           <td><?php echo $nr++; ?></td>
                           <td><?php echo $full_name; ?></td>
                           <td><?php echo $username ?></td>
                           <td><?php echo $email ?></td>
                           <td>
                               <a href="<?php echo SITEURL; ?>admin/change-password.php?id=<?php echo $id; ?>" class="btn btn-primary">Change Password</a>
                               <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                               <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                           </td>
                       </tr>


                       <?php
                    }

                }
                else
                {
                    // *We do not have data in database

                }




            }
            
            ?>

        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php')?>