<?php

$id	= $_REQUEST['id'];
$USERID	= $_REQUEST['user_id'];

if($id !='') { 

    //Main Connection
    include('../conn.php');
    
	$sql = "DELETE FROM email_create where user_id = '$USERID' AND email_id = '$id'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());

}

?>