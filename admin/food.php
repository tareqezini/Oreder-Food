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
    $food_stm = $con ->prepare("SELECT * FROM food");
    $food_stm ->execute();
    $foods = $food_stm ->fetchAll();
    ?>

 <!-- START The main content -->
 <?php $sn=1; ?>
<div class="main-content">
    <div class="container food">
        <h1 class="text-center">Mange Food</h1>
        <a href="food.php?do=Add" class="btn btn-primary">Add New Food</a>
        <!-- START FOOD Table -->
        <table class="tbl-full text-center">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image Food</th>
                <th>Price</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php 
                foreach($foods as $food)
                {?>
                    <tr>
                        <td><?php echo $sn++;?></td>
                        <td><?php  echo $food['title'] ?></td>
                        <td><?php  echo $food['description'] ?></td>
                        <td><img src="<?php echo "image/food/" . $food['image_food'] ?>" ></td>
                        <td><?php  echo $food['price'] ?></td>
                        <td>
                                <?php
                                    $cts_stm = $con ->prepare("SELECT title FROM category where id_cat =?");
                                    $cts_stm ->execute(array($food['id_cat']));
                                    $cat = $cts_stm ->fetch();
                                    echo $cat['title'];
                                ?>
                        </td>
                        <td><?php  echo $food['featured'] ?></td>
                        <td><?php  echo $food['active'] ?></td>
                        
                        <td>
                            <a href="food.php?do=delete&id=<?php echo $food['id']?>&image_name=<?php echo $food['image_food']?>" class="btn btn-danger">Delete</a> 
                            <a href="food.php?do=Edit&id=<?php echo $food['id']?>" class="btn btn-secondry">Update</a>
                            <?php
                                if($food['active'] == 'No')
                                
                                {?>
                                    <a href="category.php?do=Approve&id=<?php echo $food['id_cat'] ?>" class="btn btn-danger">Aprove</a> 
                               <?php }
                            ?>

                        </td>
                    </tr> <?php
                }

            ?>
            
        </table>
        
        <!-- END FOOOD Table -->
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
    <div class="main-content food">
    <div class="container">
        <h1 class="text-center">Add New Food</h1>
        <form class="form_cat text-center" method="POST" action="?do=Insert" enctype="multipart/form-data">
            <table >
                <tr>
                    <td>Title</td>
                    <td><input type="text" class="title" name="title" id="title"placeholder="Enter Category Title"  autocomplete="off" /></td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td><textarea name="desc" placeholder="Enter Your Descriotion"></textarea></td>
                </tr>
                <tr>
                    <td>Image Food</td>
                    <td><input type="file" class="img_food" name="img_food" id="title" placeholder="Select Image " autocomplete="off" /></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="text" class="price" name="price" id="price"placeholder="Enter Food Price"  autocomplete="off" /></td>
                </tr>

                <tr>
                    <td>Category</td>
                    <td>
                        <select class='select' name="category">
                            <?php 
                                $cts_stm = $con ->prepare("SELECT * FROM category ");
                                $cts_stm ->execute();
                                $cats = $cts_stm ->fetchAll();
                                foreach($cats as $cat)
                                {?>

                                   <option  value="<?php echo $cat['id_cat']?>" > <?php echo $cat['title'] ?></option>

                                <?php }
                                
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>YES <input type="radio" class="radio" name="active"   value="Yes" checked/>
                        NO <input type="radio" class="radio" name="active"  value="No" />
                    </td>
                
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>YES <input type="radio" class="radio" name="featured"   value="Yes" checked/>
                        NO <input type="radio" class="radio" name="featured"  value="No" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input class="btn addfood" type="submit" name="addfood" value="Add Food"/></td>
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
    $description = $_POST['desc'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $active = $_POST['active'];
    $featured = $_POST['featured'];

    //get  image data

    $image_food = $_FILES['img_food']['name'];
    $tpm_img = $_FILES['img_food']['tmp_name'];
    $extions = array('png','jpg','jpeg');
    $ext = end(explode('.' , $image_food));
    $img_rename = rand(0000,9999) . "_" . $image_food;
    $path = "image/food/" . $img_rename;
    $errorMsg = [];
    if(empty($title))
    {
        $errorMsg [] = "You Must Enter Title";
    }
    if(empty($description))
    {
        $errorMsg [] = "You Must Enter description";

    }
    if(empty($price))
    {
        $errorMsg [] = "You Must Enter Price";

    }

    if(empty($image_food))
    {
        $errorMsg [] = "You Must Select image";
    }
    if(! in_array($ext,$extions) && !empty($image_food))
    {
        $errorMsg [] =  'The Image is not valid ';
    }
    //Insert the data to database
    if(empty($errorMsg))
    {
        $stm = $con ->prepare("INSERT INTO food(title , description , image_food , price , active , featured , id_cat) VALUES(?,?,?,?,?,?,?)");
        $stm->execute(array($title ,$description , $img_rename, $price , $active ,$featured, $category));
        $row = $stm->rowCount();
        if($row>0)
        {
            $upload = move_uploaded_file($tpm_img,$path);
            $_SESSION['Add_food'] = '<div class="success">The Food Is Added</div>';
            header("Location:food.php");
        }else
        {
            $_SESSION['Add_food'] = '<div class="Failde">The Food Is Not Added</div>';
            header("Location:food.php");
        }
        
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
    $image_path = 'image/food/' . $image_name;
    //delete the image file if is exisit
    if(file_exists($image_path))
    {
        unlink($image_path);

    }
    //Make Query sql
    $stm3 = $con->prepare("DELETE FROM food where id = ?");
    $stm3 -> execute(array($id));
    $rslt_delete = $stm3->rowCount();
    
    //Creat masssage succes or faild
    if(empty($rslt_delete))
    {
        //message
        $_SESSION['cat_delete'] = '<div class="success">The Food is Deleted</div>';
        //Redirect
        header('location:food.php');
    }else {
        $_SESSION['cat_delete'] = '<div class="faild">Faild Delete</div>';
        //Redirect
        header('location:food.php');
    }
    //------------------------------End Page Delete ----------------------- */
}elseif ($do == 'Edit') 
{
    //------------------------------Starat Page Edit -----------------------
    //get the id
    $id_food = $_GET['id'];
    //Get The data
    $stm4 = $con->prepare("SELECT * FROM food WHERE id =?");
    $stm4->execute(array($id_food));
    $data_food = $stm4->fetch();
    
    ?>
    <div class="main-content food">
    <div class="container">
        <h1 class="text-center">Update Food</h1>
        <form class="form_cat text-center" method="POST" action="?do=Update" enctype="multipart/form-data">
            <table >
                <input type="hidden" name="id" value="<?php echo $id_food  ?>"/>
                <tr>
                    <td>Title</td>
                    <td><input type="text" class="title" name="title" value="<?php echo $data_food['title'] ?>"  placeholder="Enter Category Title"  autocomplete="off" /></td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td><input name="desc" value="<?php echo $data_food['description'] ?>" placeholder="Enter Your Descriotion"/></td>
                </tr>
                <tr>
                    <td>Image Food</td>
                    <td ><img class="img_upd" src="<?php echo "image/food/" . $data_food['image_food'] ?>"/></td>
                    <input type="text" value="<?php echo $data_food['image_food'] ?>"  name="curent_img"/>
                </tr>

                <tr>
                    <td>Update Image Food</td>
            
                    <td><input type="file"  class="img_food" name="newImage" id="title" placeholder="Select Image " autocomplete="off" /></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="text" class="price" name="price" value="<?php echo $data_food['price'] ?>" placeholder="Enter Food Price"  autocomplete="off" /></td>
                </tr>

                <tr>
                    <td>Category</td>
                    <td>
                        <select class='select' name="category">
                            <?php 
                                $cts_stm = $con ->prepare("SELECT * FROM category ");
                                $cts_stm ->execute();
                                $cats = $cts_stm ->fetchAll();
                                foreach($cats as $cat)
                                {?>

                                    <option  value="<?php echo $cat['id_cat']?> " <?php if($data_food['id_cat'] == $cat['id_cat']) { echo "selected" ; } ?> > <?php echo $cat['title'] ?> </option>

                                <?php }
                                
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>YES <input type="radio" class="radio" name="active" <?php if( $data_food['active'] == 'Yes') { echo 'checked' ;} ?>  value="Yes" checked/>
                        NO <input type="radio" class="radio" name="active" <?php if( $data_food['active'] == 'No') { echo 'checked' ;} ?>  value="No" />
                    </td>
                
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>YES <input type="radio" class="radio" name="featured" <?php if( $data_food['featured'] == 'Yes') { echo 'checked' ;} ?>   value="Yes" checked/>
                        NO <input type="radio" class="radio" name="featured" <?php if( $data_food['featured'] == 'No') { echo 'checked' ;} ?>  value="No" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input class="btn addfood" type="submit" name="addfood" value="Save"/></td>
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
    echo "updte";
   $id_food = $_POST['id'];
    //get the data
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $active = $_POST['active'];
    $featured = $_POST['featured'];
    //get the data image
    $curentImg = $_POST['curent_img'];
    
    if(isset($_FILES['newImage']['name']))
    {
        $newImage = $_FILES['newImage']['name'];
        $newImg_tmp = $_FILES['newImage']['tmp_name'];
        if($newImage != "")
        {
            $image_food =  rand(0000,9999) . "_" . $newImage;
            $path = 'image/food/' . $image_food;
            $upl = move_uploaded_file($newImg_tmp,$path);
            if($upl)
            {
                unlink('image/food/' . $curentImg);
            }else{
                header('location: food.php');
                die();
            }
            
        }
    }else
    {
        $image_food =  $curentImg;
    }
    
    $errorMsg = [];
    //check errors
    if(empty($title))
    {
        $errorMsg [] = "You Must Enter Title";
    }
    if(empty($desc))
    {
        $errorMsg [] = "You Must Enter description";

    }
    if(empty($price))
    {
        $errorMsg [] = "You Must Enter Price";

    }
    if(empty($image_food))
    {
        $errorMsg [] = "You Must Select Image";

    }

    //Insert the data to database
    if(empty($errorMsg))
    {
        $stm = $con->prepare("UPDATE food SET title = ? , description = ?, price=? ,id_cat =? , featured=? , active = ? ,image_food=? WHERE id = ?");
        $stm->execute(array($title,$desc,$price,$category  , $featured , $active , $image_food , $id_food ));
        $rslt = $stm->rowCount();
    }
    
    if($rslt>0)
    {
        //Creat the message
        $_SESSION['catupdate'] = '<div class="success">The Category is Update</div>';
        //Redirect
        header('location:food.php');
    }else {
        //Creat the message
        $_SESSION['catupdate'] = '<div class="faild">Faild Update</div>';
        //Redirect
        header('location:food.php');
    }
  
   

    //------------------------------End Page Update---------------------
  
}elseif ($do == 'Approve') 
{
    $id_aprove = $_GET['id'];
    echo $id_aprove;
    $stm5 = $con->prepare("SELECT * FROM food WHERE id = ?");
    $stm5->execute(array($id_aprove));
    $rslt_aprove = $stm5->rowCount();
    if($rslt_aprove == 1)
    {
       $stm6 = $con ->prepare("UPDATE food SET active = ?  WHERE id = ?");
       $stm6->execute(array('Yes' , $id_aprove));
       $rslt_ative = $stm6->rowCount();
       if($rslt_ative >0)
       {
           $msg[] = 'The Category Is Actived';
           header('location:food.php');
       }
    }else {
        echo 'this id not exisit';
    }
}
?>

<?php include('tamplet/footer.php'); ?>