<?php
$id	= $_REQUEST['id'];

if($id !='') { 
    //Main Connection
    include('../conn.php');
	$sql = "DELETE FROM merchant_products where id='$id'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());
}
?>