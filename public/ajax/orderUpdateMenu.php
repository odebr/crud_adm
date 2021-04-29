<?php
//include database class
include_once 'dbmenu.php';
$db = new DB();

//get images id and generate ids array
$idArray = explode(",",$_POST['ids']);

//update images order
$db->updateOrder($idArray);
?>