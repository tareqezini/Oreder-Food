
    <?php include('tamplet/header.php') ;
    //get the info data
    if ($_GET['id_food']) 
    {
        //Get the id
        $id_food = $_GET['id_food'];
        //Get all Data
        $stm = $con->prepare("SELECT * From food WHERE id =?");
        $stm->execute(array($id_food));
        $order_food = $stm->fetch();
        $count = $stm->rowCount();

        $food_name = $order_food['title'];
        $price = $order_food['price'];
        $dedc = $order_food['description'];
        $img_food =$order_food['image_food'];
        
    }else{
        header('location:index.php');
    }
    
    
    ?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <img src="<?php echo 'admin/image/food/'. $img_food ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                        <input type="hidden" name="img_food" value="<?php echo $food['image_food'] ?>">

                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo  $food_name ?></h3>
                        <input type="hidden" name="food_name" value="<?php echo  $food_name ?>">
                        <p class="food-price"><?php echo  $price .'$' ?></p>
                        <input type="hidden" name="price" value="<?php echo $price ?>">


                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php 

if(isset($_POST['submit']))
{
    //get the data
    $food_name = $_POST['food_name'];
    $price = $_POST['price'];  
    $img = $_POST['img_food'];
    $qty = $_POST['qty'];
    $tprice = $qty * $price;
    $order_date = date("Y-m-d H:i:sa");
    $csmtr_name = $_POST['name'];
    $csmtr_contact = $_POST['contact'];
    $csmtr_email = $_POST['email'];
    $csmtr_address = $_POST['address'];
    $status = "order";
    $errors = array();
    if (empty($food_name))
    {
        $errors[] = 'empty';
    }
    if (empty($price))
    {
        $errors[] = 'empty';
    }
    if (empty($img))
    {
        $errors[] = 'empty';
    }
    if (empty($qty))
    {
        $errors[] = 'empty';
    }
    if (empty($csmtr_name))
    {
        $errors[] = 'empty';
    }
    if (empty($csmtr_email))
    {
        $errors[] = 'empty';
    }
    if (empty($csmtr_address))
    {
        $errors[] = 'empty';
    }
    if (empty($csmtr_contact))
    {
        $errors[] = 'empty';
    }

    if(empty($errors))
    {
        $ordr = $con ->prepare("INSERT INTO tbl_order(title,price,Quntite,total_price,order_date, status ,customer_name,customer_contact,customer_email,customer_address) 
                                values(?,?,?,?,?,?,?,?,?,?)");
        $ordr->execute(array($food_name,$price,$qty,$tprice,$order_date,$status,$csmtr_name,$csmtr_contact,$csmtr_email,$csmtr_address));
        $row_order = $ordr->rowCount();
        if ($row_order>0) 
        {
            $_SESSION['order'] =  '<div class="text-center sucesses"></div>';
            header('location:index.php');
        }else
        {
            $_SESSION['order'] =  '<div class="text-center eroor"></div>';
            header('location:index.php');

        }
    }

}



 include('tamplet/footer.php') ?>