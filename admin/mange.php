<?php include('tamplet/header.php') ;
 include('.//connecte.php') ;
 if(isset($_GET['do']))
 {
     $do = $_GET['do'];
 }else {
    $do ='mange';
 }
if($do =='mange')
{
    //------------------------------Starat Page Mange -----------------------
    //Get the Data
    $stm2 = $con ->prepare("SELECT * FROM admin");
    $stm2 ->execute();
    $admins = $stm2 ->fetchAll();
    ?>

 <!-- START The main content -->
 <?php $sn=1; ?>
<div class="main-content text-center">
    <div class="container">
        <h1 class="text-center">Mange Admin Panne</h1>
        <a href="mange.php?do=Add" class="btn btn-primary">Add New Admin</a>
        <!-- START Admin Table -->
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>User Name</th>
                <th>Action</th>
            </tr>
            <?php 
                foreach($admins as $admin)
                {?>
                    <tr>
                        <td><?php echo $sn++;?></td>
                        <td><?php echo $admin['fullName'] ?></td>
                        <td><?php  echo $admin['userName'] ?></td>
                        <td>
                            <a href="mange.php?do=delete&id=<?php echo $admin['id']?>" class="btn btn-danger">Delete</a> 
                            <a href="mange.php?do=Edit&id=<?php echo $admin['id']?>" class="btn btn-secondry">Update</a>
                        </td>
                    </tr> <?php
                }

            ?>
            
        </table>
        
        <!-- END Admin Table -->
        <!-- Start Message Area -->
            <div class="eroor-messagse">
                    <?php 
                        if(isset($_SESSION['delete']))
                        {
                            echo $_SESSION['delete'];
                            session_unset();
                        }
                        if(isset($_SESSION['update']))
                        {
                            echo $_SESSION['update'];
                            session_unset();
                        }
                        if(isset($_SESSION['Add']))
                        {
                            echo $_SESSION['Add'];
                            session_unset();
                        }
                    ?>
            </div>
        <!-- End Message Area -->
    </div>  
 </div>
<!-- END The main content -->
<?php
//------------------------------End Page Mange -----------------------
}elseif ($do == 'Add') {
    //------------------------------Starat Page Add -----------------------
    ?>
    <div class="main-content text-center addAdmin">
    <div class="container">
        <h1>Add New Admin</h1>
        <form autocomplete="off" method="POST" action="?do=Insert">
            <input type="text" name="fullName" id="fullName"placeholder="Enter You Full Name" required autocomplete="off" />
            <input type="text" name="userName" placeholder="Enter You userName" required autocomplete="off" />
            <input type="password" name="password" placeholder="Enter You Password" required autocomplete="off" />
            <input type="password" name="passwordc" placeholder="Confirme Password" required autocomplete="off" />
            <input class="btn-add" type="submit" name="addAdmin" value="Add"/>
        </form>
        
            <?php 
                    if(!empty($errorMsg))
                    {
                        foreach($errorMsg as $error)
                        {
                            echo '<div class="error">' . $error . '</div>';
                        }
                    }
            ?>
        
    </div>  
 </div> <?php
    //------------------------------End Page Add -----------------------------
}elseif($do == 'Insert')
{
//------------------------------START Page Insert ----------------------------------
$fullName = $_POST['fullName'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $passwordTwo = $_POST['passwordc'];
    $passwordencrypt = sha1($password);
    $errorMsg = [];
    if(empty( $fullName))
    {
        $errorMsg [] = "You Must Enter Your name";
    }
    if(empty( $password))
    {
        $errorMsg [] = "You Must Enter Your Password";
    }
    if(empty( $userName))
    {
        $errorMsg [] = "You Must Enter Your userName";
    }
    if($password != $passwordTwo)
    {
        $errorMsg [] = "Your Passwosrs Not The Same";
    }
    
    //Insert the data to database
    if(empty($errorMsg))
    {
        $stm = $con ->prepare("INSERT INTO admin(fullName, userName, password) VALUES(?,?,?)");
        $stm->execute(array($fullName , $userName,$passwordencrypt));
        $row = $stm->rowCount();
        $_SESSION['Add'] = '<div class="success">The Admin is Added</div>';
        header("Location:mange.php");
    }
//------------------------------End Page Insert ------------------------------------
}elseif($do == "delete")
{
    //------------------------------Starat Page Delete -----------------------
    //Get the id 
    $id = $_GET['id'];
    echo $id;
    //Make Query sql
    $stm3 = $con->prepare("DELETE FROM admin where id = ?");
    $stm3 -> execute(array($id));
    $rslt = $stm3->rowCount();
    //Creat masssage succes or faild
    if($rslt>0)
    {
        $_SESSION['delete'] = '<div class="success">The Admin is Deleted</div>';
        //Redirect
        header('location:mange.php');
    }else {
        $_SESSION['delete'] = '<div class="faild">Faild Delete</div>';
        //Redirect
        header('location:mange.php');
    }
    //------------------------------End Page Delete -----------------------
}elseif ($do == 'Edit') 
{
    //------------------------------Starat Page Edit -----------------------
    //get the id
    $id = $_GET['id'];
    //Get The data
    $stm4 = $con->prepare("SELECT * FROM admin WHERE id =?");
    $stm4->execute(array($id));
    $data = $stm4->fetch();
    
    ?>
    <div class="main-content text-center addAdmin">
    <div class="container">
        <h1>Add New Admin</h1>
        <form autocomplete="off" method="POST" action="?do=update&adminid=<?php echo $id ?>">
            <input type="text" name="fullName" value="<?php echo $data['fullName'] ?>" id="fullName"placeholder="Enter You Full Name" required autocomplete="off" />
            <input type="text" name="userName" value="<?php echo $data['userName'] ?>" placeholder="Enter You userName" required autocomplete="off" />
            <input type="password" name="password" value="<?php echo $data['password'] ?>" placeholder="Enter You Password" required autocomplete="off" />
            <input type="password" name="passwordc" value="" placeholder="Confirme Password" required autocomplete="off" />
            <input class="btn-add" type="submit" name="addAdmin" value="Save"/>
        </form> 
    </div>  
 </div>
 <?php
 //------------------------------END Page Edit -----------------------
}elseif ($do == 'update') 
{
    //------------------------------Starat Page Update---------------------
    //GET The Id
    $admin_id = $_GET['adminid'];
    //get the data
    $fullName = $_POST['fullName'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $passwordc = $_POST['passwordc'];
    
    $passwordH = sha1($password);
    $errorMsg = [];
    if(empty( $fullName))
    {
        $errorMsg [] = "You Must Enter Your name";
    }
    if(empty( $password))
    {
        $errorMsg [] = "You Must Enter Your Password";
    }
    if(empty( $userName))
    {
        $errorMsg [] = "You Must Enter Your UserName";
    }
    if($password != $passwordc)
    {
        $errorMsg [] = "Your Passwosrs Not The Same";
    }
    
    //Insert the data to database
    if(empty($errorMsg))
    {
        $stm = $con->prepare("UPDATE admin SET fullName = ? , userName = ? , password = ? WHERE id = ?");
        $stm->execute(array($fullName , $userName , $passwordH,$admin_id ));
        $rslt = $stm->rowCount();
    }
    
    if($rslt>0)
    {
        //Creat the message
        $_SESSION['update'] = '<div class="success">The Admin is Update</div>';
        //Redirect
        header('location:mange.php');
    }else {
        //Creat the message
        $_SESSION['update'] = '<div class="faild">Faild Update</div>';
        //Redirect
        header('location:mange.php');
    }
  
    

    //------------------------------End Page Update---------------------
}

 ?>

<?php include('tamplet/footer.php') ?>