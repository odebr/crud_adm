<?php

$id	= $_REQUEST['id'];
$user_id= $_REQUEST['user_id'];

if($id !='') { 
    //Main Connection
    include('../conn.php');
	$sql = "DELETE FROM fund_form where user_id = '$user_id' AND batch='$id'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());

}

?>