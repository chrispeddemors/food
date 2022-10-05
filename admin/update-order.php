<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update order</h1>
        <br><br>
        <?php 
        //Check if is set, otherwise redirect
        if(isset($_GET['id']))
        {//Id is set
            echo "The id is set";
        }
        else
        {//Id is not set, redirect
            $_SESSION['update'] = "<div class='error'>Failed to update order</div>";
            header("location:".SITEURL."admin/manage-order.php");
        }

        ?>
    </div>
</div>
<?php include('partials/footer.php') ?>