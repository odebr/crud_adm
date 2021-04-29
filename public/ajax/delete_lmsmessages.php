<?php

$id	= $_REQUEST['id'];

if($id !='') { 
    
$USERID = substr($id, 0, strrpos($id, '-'));  

$student_id = substr($id, strpos($id, '-') + 1);  

    //Main Connection
    include('../conn.php');
	$sql = "DELETE FROM student_messages WHERE user_id='".$USERID."' AND student_id ='".$student_id."'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());

}

?>