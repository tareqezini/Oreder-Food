<?php 
function getItems($item , $tbl , $value, $and , $limt)
{
    global $con;
    //$stm = $con->prepare("SELECT * From category where active = ? and featured = ? Limit 3");
    $stm = $con->prepare("SELECT $item From $tbl where active = ? AND  featured = ?  limit $limt");
    $stm->execute(array($value , $and ));
    return $stm->fetchAll();
}



//function to get the category
function getCat($item , $tbl , $value )
{
    global $con;
    //$stm = $con->prepare("SELECT * From category where active = ? and featured = ? Limit 3");
    $stm = $con->prepare("SELECT $item From $tbl where active = ?");
    $stm->execute(array($value));
    return $stm->fetchAll();
}
?>