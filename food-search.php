<?php include('tamplet/header.php') ;
 $search = $_POST['search'];

$stm = $con->prepare("SELECT * FROM food WHERE title like '%$search%'");
$stm->execute();
$foods = $stm->fetchAll();

?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

                <?php 
                   
                    if ($search != "") 
                    {
                      
                       foreach($foods as $food)
                       {
                           ?>
                               <div class="food-menu-box">
                                       <div class="food-menu-img">
                                           <img src="<?php echo 'admin/image/food/' . $food['image_food'] ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                       </div>
       
                                       <div class="food-menu-desc">
                                           <h4><?php echo $food['title'] ?></h4>
                                           <p class="food-price"><?php echo "$" . $food['price'] ?></p>
                                           <p class="food-detail">
                                           <?php echo $food['description'] ?>
                                           </p>
                                           <br>
                                           <a href="<?php echo 'order.php?id_food=' .  $food['id'] ?>" class="btn btn-primary">Order Now</a>
                                       </div>
                               </div>
                           <?php
                       }
                
                    }else{
                        header('location:index.php');
                    }
                ?>
           

            
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('tamplet/footer.php') ?>