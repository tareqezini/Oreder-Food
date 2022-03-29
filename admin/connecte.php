<?php
$dsn = 'mysql:host=localhost;dbname=order_food';
$user = "root";
$pass = "";


try
    {
        $con = new PDO($dsn,$user,$pass);
        $con ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
        echo 'Faild'  . $e->getMessage();
    }
?>