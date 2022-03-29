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
    //------------------------------Starat Page Mange Categories -----------------------
    //Get the Data
    $cat_stm = $con ->prepare("SELECT * FROM category");
    $cat_stm ->execute();
    $Cats = $cat_stm ->fetchAll();
    ?>

 <!-- START The main content -->
 <?php $sn=1; ?>
<div class="main-content">
    <div class="container category">
        <h1 class="text-center">Mange Categories</h1>
        <a href="category.php?do=Add" class="btn btn-primary">Add New Category</a>
        <!-- START Category Table -->
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php 
                foreach($Cats as $cat)
                {?>
                    <tr>
                        <td><?php echo $sn++;?></td>
                        <td><?php  echo $cat['title'] ?></td>
                        <td><img src="<?php echo "image/category/" . $cat['image_cat'] ?>" ></td>
                        <td><?php  echo $cat['featured'] ?></td>
                        <td><?php  echo $cat['active'] ?></td>
                        
                        <td>
                            <a href="category.php?do=delete&id=<?php echo $cat['id_cat']?>&image_name=<?php echo $cat['image_cat']?>" class="btn btn-danger">Delete</a> 
                            <a href="category.php?do=Edit&id=<?php echo $cat['id_cat']?>" class="btn btn-secondry">Update</a>
                            <?php
                                if($cat['active'] == 'No')
                                
                                {?>
                                    <a href="category.php?do=Approve&id=<?php echo $cat['id_cat'] ?>" class="btn btn-danger">Aprove</a> 
                               <?php }
                            ?>

                        </td>
                    </tr> <?php
                }

            ?>
            
        </table>
        
        <!-- END Category Table -->
        <!-- Start Message Area -->
            <div class="eroor-messagse">
                    <?php 
                        if(isset($_SESSION['cat_delete']))
                        {
                            echo $_SESSION['cat_delete'];
                            unset($_SESSION['cat_delete']);
                        }
                        if(isset($_SESSION['catupdate']))
                        {
                            echo $_SESSION['catupdate'];
                            unset($_SESSION['catupdate']);
                        }
                        if(isset($_SESSION['Add']))
                        {
                            echo $_SESSION['Add'];
                            unset($_SESSION['Add']);
                        }
                    ?>
            </div>
        <!-- End Message Area -->
    </div>  
 </div>
<!-- END The main content -->
<?php
//------------------------------End Page Mange Categories -----------------------
}elseif ($do == 'Add') {
    //------------------------------Starat Page Add Categories-----------------------
    ?>
    <div class="main-content category">
    <div class="container">
        <h1 class="text-center">Add New Admin</h1>
        <form class="form_cat text-center" method="POST" action="?do=Insert" enctype="multipart/form-data">
            <table class="">
                <tr>
                    <td>Title</td>
                    <td><input type="text" class="title" name="title" id="title"placeholder="Enter Category Title" required autocomplete="off" /></td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>YES <input type="radio" name="approve"  required value="Yes" checked/>
                        NO <input type="radio" name="approve" required value="No" />
                    </td>
                </tr>

                <tr>
                    <td>Featured</td>
                    <td>YES <input type="radio" name="featured"  required value="Yes" checked/>
                        NO <input type="radio" name="featured" required value="No" />
                    </td>
                </tr>
                <tr>
                    <td>Image Category</td>
                    <td>
                        <input type="file" class="file" name="image_cat" required />
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input class="btn addcat" type="submit" name="addcat" value="Add Category"/></td>
                </tr>
            </table>
            
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
    //------------------------------End Page Add Categories -----------------------------
}elseif($do == 'Insert')
{
//------------------------------START Page Insert ----------------------------------

    $title = $_POST['title'];
    $active = $_POST['approve'];
    $featured = $_POST['featured'];
    $errorMsg = [];

    //upload image

    $cat_name = $_FILES['image_cat']['name'];
    $oldePath = $_FILES['image_cat']['tmp_name'];
    $ext = strtolower(end(explode('.',$cat_name)));
    $image_cat = rand(0000,9999) . "_" . $cat_name;
    $extions = array('png','jpg','jpeg');
    $newPath = "image/category/" .$image_cat;
    if(empty($title))
    {
        $errorMsg [] = "You Must Enter Title";
    }
    if(empty($cat_name))
    {
        $errorMsg [] = "You Must Select image";
    }
    if(! in_array($ext,$extions))
    {
        $errorMsg [] =  'The Image is not valid ';
    }
    
    //Insert the data to database
    if(empty($errorMsg))
    {
        $stm = $con ->prepare("INSERT INTO category(title , image_cat , active , featured) VALUES(?,?,?,?)");
        $stm->execute(array($title , $image_cat , $active ,$featured));
        $row = $stm->rowCount();
        $upload = move_uploaded_file($oldePath,$newPath);
        $_SESSION['Add_cat'] = '<div class="success">The Category Is Added</div>';
        header("Location:category.php");
    }
//------------------------------End Page Insert ------------------------------------
}elseif($do == "delete")
{
    //------------------------------Starat Page Delete -----------------------
    //Get the id 
    $id = $_GET['id']; 
    //remove the image
    $image_name = $_GET['image_name'];
    echo $image_name;
    $image_path = 'image/category/' . $image_name;
    //delete the image file if is exisit
    if(file_exists($image_path))
    {
        unlink($image_path);

    }
    //Make Query sql
    $stm3 = $con->prepare("DELETE FROM category where id_cat = ?");
    $stm3 -> execute(array($id));
    $rslt_delete = $stm3->rowCount();
    
    //Creat masssage succes or faild
    if(empty($rslt_delete))
    {
        //message
        $_SESSION['cat_delete'] = '<div class="success">The Category is Deleted</div>';
        //Redirect
        header('location:category.php');
    }else {
        $_SESSION['cat_delete'] = '<div class="faild">Faild Delete</div>';
        //Redirect
        header('location:category.php');
    }
    //------------------------------End Page Delete ----------------------- */
}elseif ($do == 'Edit') 
{
    //------------------------------Starat Page Edit -----------------------
    //get the id
    $id = $_GET['id'];
    //Get The data
    $stm4 = $con->prepare("SELECT * FROM category WHERE id_cat =?");
    $stm4->execute(array($id));
    $data = $stm4->fetch();
    
    ?>
    <div class="main-content category">
    <div class="container">
        <h1 class="text-center">Update Category</h1>
        <form class="form_cat text-center" method="POST" action="?do=Update">
        <table >
            <input type="hidden" value="<?php echo $id ?>" name="id">
                <tr>
                    <td>Title</td>
                    <td><input type="text" class="title" value="<?php echo $data['title'] ?>" name="title" id="title"placeholder="Enter Category Title" required autocomplete="off" /></td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>YES <input type="radio" name="approve"  required value="Yes" <?php if( $data['featured'] == 'Yes') { echo 'checked' ;} ?>/>
                        NO <input type="radio" name="approve" required value="No" <?php if( $data['featured'] == 'No') { echo 'checked' ;} ?> />
                    </td>
                </tr>

                <tr>
                    <td>Featured</td>
                    <td>YES <input type="radio" name="featured"  required value="Yes" <?php if( $data['active'] == 'Yes') { echo 'checked' ;} ?>/>
                        NO <input type="radio" name="featured" required value="No" <?php if( $data['active'] == 'No') { echo 'checked' ;} ?>/>
                    </td>
                </tr>
                <tr>
                    <td>Image : </td>
                    <td>
                        <img src="<?php echo "image/category/" . $data['image_cat'] ?>" >
                    </td>
                </tr>

                <!--<tr>
                    <td>Image Category</td>
                    <td><input type="file" class="file" name="image_cat"  required /></td>
                </tr> --->
                <tr>
                    <td colspan="2"> <input class="btn addcat" type="submit" name="addcat" value ="Save Category"/></td>
                </tr>
            </table>
        </form> 
    </div>  
 </div>
 <?php
 //------------------------------END Page Edit -----------------------
}elseif ($do == 'Update') {
    //------------------------------Starat Page Update---------------------
    //GET The Id

   $id = $_POST['id'];
   

    //get the data
    $title = $_POST['title'];
    $active = $_POST['approve'];
    $featured = $_POST['featured'];
    
    $errorMsg = [];
    if(empty($title))
    {
        $errorMsg [] = "You Must Enter Title";
    }
    echo 'test';
  
    //Insert the data to database
    if(empty($errorMsg))
    {
        $stm = $con->prepare("UPDATE category SET title = ? , featured = ? , active = ?  WHERE id_cat = ?");
        $stm->execute(array($title , $featured , $active , $id ));
        $rslt = $stm->rowCount();
    }
    
    if($rslt>0)
    {
        //Creat the message
        $_SESSION['catupdate'] = '<div class="success">The Category is Update</div>';
        //Redirect
        header('location:category.php');
    }else {
        //Creat the message
        $_SESSION['catupdate'] = '<div class="faild">Faild Update</div>';
        //Redirect
        header('location:category.php');
    }
  
    

    //------------------------------End Page Update---------------------
  
}elseif ($do == 'Approve') 
{
    $id_aprove = $_GET['id'];
    echo $id_aprove;
    $stm5 = $con->prepare("SELECT * FROM category WHERE id_cat = ?");
    $stm5->execute(array($id_aprove));
    $rslt_aprove = $stm5->rowCount();
    if($rslt_aprove == 1)
    {
       $stm6 = $con ->prepare("UPDATE category SET active = ?  WHERE id_cat = ?");
       $stm6->execute(array('Yes' , $id_aprove));
       $rslt_ative = $stm6->rowCount();
       if($rslt_ative >0)
       {
           $msg[] = 'The Category Is Actived';
           header('location:category.php');
       }
    }else {
        echo 'this id not exisit';
    }
}
?>

<?php include('tamplet/footer.php'); ?>