<?php 
include('tamplet/header.php') ;
include('.//connecte.php') ;
include('function/function.php');

 //get the total of category

?>
 <!-- START The main content -->
<div class="main-content text-center">
    <div class="container">
        <h1 class="text-center">Dashboard</h1>
        <div class="box-ping col-4 box-one">
            <span><?php echo calItems('id_cat','category'); ?></span>
            <p>Category</p>
        </div>
        <div class="box-ping col-4 box-tow">
            <span><?php echo calItems('id','food'); ?></span>
            <p>Food</p>
        </div>

        <div class="box-ping col-4 box-three">
            <span> <?php echo calItems('id','tbl_order'); ?> </span>
            <p>Order</p>
        </div>

        
    </div>  
 </div> 
<!-- END The main content -->

<?php include('tamplet/footer.php') ; ?>