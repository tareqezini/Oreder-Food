<?php 
    session_start();
    include('checklogin.php');
    
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Restaurant Website</title>
        <!-- Link our CSS file -->
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <!-- START The nav bar -->
        <div class="nav-bar text-center">
            <div class="container">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="mange.php">Admin</a></li>
                    <li><a href="category.php">Category</a></li>
                    <li><a href="food.php">Food</a></li>
                    <li><a href="order.php">Order</a></li>
                    <li><a href="logout.php">Log out</a></li>
                </ul>
            </div>  
        </div>
        <!-- END The nav bar -->