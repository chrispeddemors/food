<?php 
ob_start(); 
    // * Session start()
    session_start();


    // Create constants to store non repeating values
    define ('SITEURL', 'http://localhost/food/');
    define ('LOCALHOST', 'localhost');
    define ('DB_USERNAME', 'root');
    define ('DB_PASSWORD', '');
    define ('DB_NAME', 'food-order');

    //tbl_admin
    //tbl_category
    //tbl_food
    

    $conn = mysqli_connect(LOCALHOST,DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));




?>