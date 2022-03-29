<?php include('tamplet/header.php') ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            
            <?php 
            //function getCat($item , $tbl , $value)
            $cats = getCat("*" , "category" , "Yes");
            foreach($cats as $cat)
            {
                ?>
                <a href="category-foods.php?id=<?php echo $cat['id_cat'] ?>">
                    <div class="box-3 float-container">
                        <img src="<?php echo 'admin/image/category/' . $cat['image_cat'] ?>"  class="img-responsive img-curve">

                        <h3 class="float-text text-white"><?php echo $cat['title']  ?></h3>
                    </div>
                </a>
                <?php
            }

            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('tamplet/footer.php') ?>