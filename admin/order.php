<?php include('tamplet/header.php');
include('.//connecte.php') ;
$stm = $con->prepare("SELECT * FROM tbl_order");
$stm->execute();
$orders = $stm->fetchAll();

if(isset($_GET['do']))
{
    $do = $_GET['do'];
}else
{
    $do = 'Mange';
}

if ($do == 'Mange') {
    

?>

 <!-- START The main content -->
<div class="main-content text-center">
    <div class="container">
        <h1 class="text-center">Menu order</h1>
        <!-- START order Message -->
        <?php 
            if(isset($_SESSION['order_dlt']))
            {
                echo $_SESSION['order_dlt'];
                unset($_SESSION['order_dlt']);
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
         <!-- START order Table -->
        <table class="tbl-full">
            <tr>
                <th>id</th>
                <th>Title</th>
                <th>Price</th>
                <th>Quntite</th>
                <th>Total Price</th>
                <th>Date</th>
                <th>Status</th>
                <th>Custmor Name</th>
                <th>Custmor Contact</th>
                <th>Custmor Email</th>
                <th>Custmor Addres</th>
                <th>Action</th>

            </tr>
<?php
            foreach($orders as $order)
            {
?>
            <tr>
                <td>1</td>
                <td><?php echo $order['title'] ?></td>
                <td><?php echo $order['price'] ?></td>
                <td><?php echo $order['Quntite'] ?></td>
                <td><?php echo $order['total_price'] ?></td>
                <td><?php echo $order['order_date'] ?></td>
                <td><?php echo $order['status'] ?></td>
                <td><?php echo $order['customer_name'] ?></td>
                <td><?php echo $order['customer_contact'] ?></td>
                <td><?php echo $order['customer_email'] ?></td>
                <td><?php echo $order['customer_address'] ?></td>
                <td>
                    <a href="order.php?do=Delete&id=<?php echo $order['id'] ?>" class="btn btn-danger">Delete</a> 
                    <a href="order.php?do=Edit&id=<?php echo $order['id'] ?>" class="btn btn-secondry">Update</a>
                </td>
            </tr>
<?php
            }
?>
        </table>
        <!-- END order Table -->
    </div>  
 </div>
<!-- END The main content -->

<?php 
}elseif($do == 'Delete')
{
    $id = $_GET['id'];
    $stm = $con->prepare('SELECT * FROM tbl_order WHERE id =?');
    $stm->execute(array($id));
    $row = $stm->rowCount();
    if($row == 1)
    {
        $stm = $con->prepare('DELETE FROM tbl_order WHERE id=?');
        $stm->execute(array($id));
        $count = $stm->rowCount();
        if ($count == 1) 
        {
           $_SESSION['order_dlt'] = '<div class="success">The Order Is Deleted</div>';
           header('location:order.php');
        }else
        {
            $_SESSION['order_dlt'] = '<div class="error">Failde Delete</div>';
           header('location:order.php');
        }
    }
}elseif($do == 'Edit')
{
    
    $id = $_GET['id'];
    echo $id;
    ?>
    
 <!-- START The main content -->
 <div class="main-content text-center">
     <div class="container order">
         <h1 class="text-center">Menu order</h1>
        <!-- START order Table -->
         <table class="tbl-full"> 
             <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?do=Update&id=' .$id ?>">
             <tr>
                 <td>
                     <label>Status :</label>
                 </td>

                 <td>
                     <select name="status">
                         <option value="Order">Order</option>
                         <option value="Delevry">Delevry</option>
                         <option value="Canceled">Canceled</option>
                     </select>
                 </td>
             </tr>
             <tr>
                 <td colspan="2"> <input type="submit" name="submit" value="Update" /></td>
             </tr>
         </table>
         </form>
        <!-- END order Table -->
     </div>  
  </div>
 <!-- END The main content -->
<?php    
}elseif($do == 'Update')
{
    $id = $_GET['id'];
    $status = $_POST['status'];
    $stm = $con->prepare('SELECT * FROM tbl_order WHERE id =?');
    $stm->execute(array($id));
    $row = $stm->rowCount();
    if($row == 1)
    {
        $stm = $con->prepare('UPDATE  tbl_order SET Status = ? WHERE id =?');
        $stm->execute(array($status , $id));
        $couter = $stm->rowCount();
        if ($couter) 
        {
            $_SESSION['update'] = '<div class="success">The Order is Update </div>';
            header('location:order.php');
        }else{
            $_SESSION['update'] = '<div class="error">Faild Update </div>';
            header('location:order.php');    
        }
    }else
    {
        $_SESSION['update'] = '<div class="error">Faild Update </div>';
        header('location:order.php');
    }
    
}
include('tamplet/footer.php') ?>