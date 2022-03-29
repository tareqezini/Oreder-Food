<?php 
session_start();
 include('.//connecte.php') ;
 

    if(isset($_POST['login']))
    {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $passwordH = sha1($password);
        $log_stm = $con->prepare("SELECT * FROM admin WHERE userName =? AND password = ? ");
        $log_stm ->execute(array($user,$passwordH));
        $log_count = $log_stm->rowCount();
        if($log_count == 1)
        {
            //creat session 
            $_SESSION['login'] = $user;
            //Redirect
            header('location:index.php');
        }else 
        {
            $_SESSION['logfaild'] = '<div class="faild">The Passwor And No Mach</div>';
            //Redirect
        }
    }

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
        <div class="container">
           <div class="login text-center">
                <h1>Log In</h1>
               <form class="" method="POST" action="login.php">
                    <input type="text" name="user" placeholder="Your User Name">
                    <input type="password" name="password" placeholder="Your Passowrd">
                    <input type="submit" name="login" value="Log in">
               </form>
           </div>
            <div><div class="eroor-messagse">
               <?php
                    if(isset($_SESSION['logfaild']))
                    {
                        echo $_SESSION['logfaild'];
                        session_unset();
                    }
               ?>
            </div>
           

        </div>
    </body>
</html>

