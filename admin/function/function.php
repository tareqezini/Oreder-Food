<?php

//function calcule Items

function calItems($counter,$table)
{
    global $con;

    $stm = $con->prepare("SELECT COUNT($counter) FROM $table");
    $stm->execute();
    echo $stm->fetchColumn();
}


?>