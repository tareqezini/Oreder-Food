<?php include('tamplet/header.php') ;


$id = $_GET['id'];
$stm = $con->prepare("SELECT * FROM category WHERE id_cat = ?");
$stm ->execute(array($id));
$cat = $stm->fetch();
$rowCount = $stm->rowCount();
if ($rowCount == 1) 
{
    $stm1 = $con->prepare("SELECT * FROM food WHERE id_cat = ?");
    $stm1 ->execute(array($id));
    $menu_Foods = $stm1->fetchAll();
    $cnt = $stm1->rowCount();
    if($cnt>0)
    {?>
        <!-- fOOD sEARCH Section Starts Here -->
        <section class="food-search text-center">
            <div class="container">
                
                <h2>Foods on <a href="#" class="text-white"> <?php echo $cat['title']?>  </a></h2>
    
            </div>
        </section>
        <!-- fOOD sEARCH Section Ends Here -->
        <section class="food-menu">
        <div class="container">
        <?php
        foreach($menu_Foods as $food)
        {?>
    
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="<?php echo 'admin/image/food/' . $food['image_food'] ?>"  class="img-responsive img-curve">
                    </div>
    
                    <div class="food-menu-desc">
                        <h4><?php echo $food['title'] ?></h4>
                        <p class="food-price"><?php echo $food['price'] .'$' ?></p>
                        <p class="food-detail">
                            <?php echo $food['description'] ?>
                        </p>
                        <br>
    
                        <a href="#" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
        
        <?php
        }?>
        
    <!-- fOOD Menu Section Ends Here -->
        <div class="clearfix"></div>
    
        </div>

    </section>
   
        
       
   <?php }else
    {
        echo 'No FOOD';
    }
    
   
    
}else
{
    header('location:categories.php');
}

?>

    

    <?php include('tamplet/footer.php') ?>