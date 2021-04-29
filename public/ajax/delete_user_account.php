<?php

$id	= $_REQUEST['id'];


if($id !='') { 

        //Main Connection
    include('../conn.php');
    
	$sql = "DELETE FROM users where id='$id'";
    $res = mysqli_query($con,$sql) or die(mysqli_error());
    
    $sql = "DELETE FROM role_user where user_id='$id'";
    $res = mysqli_query($con,$sql) or die(mysqli_error());

}

?>