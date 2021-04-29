<?php

$id	= $_REQUEST['id'];


if($id !='') { 

    //Main Connection
    include('../conn.php');
	$sql = "DELETE FROM attendance where id='$id'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());

}

?>